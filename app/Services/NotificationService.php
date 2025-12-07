<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\AdminNotification;
use App\Models\User;

class NotificationService
{
    /**
     * Notify user when order is approved
     */
    public function notifyOrderApproved($order, $type)
    {
        $itemName = $type === 'gas' ? $order->item_name : $order->barang->nama_barang;
        
        if ($type === 'gas') {
            $message = "Pembelian gas Anda telah disetujui! Order #{$order->order_number} akan segera diproses.";
            $title = "Pesanan Gas Disetujui";
        } else {
            $duration = $order->days_count ?? 1;
            $amount = number_format($order->total_amount, 0, ',', '.');
            $message = "Penyewaan {$itemName} telah disetujui! Duration: {$duration} hari | Total: Rp {$amount}";
            $title = "Penyewaan Disetujui";
        }

        Notification::create([
            'title' => $title,
            'message' => $message,
            'type' => 'approval_success',
            'user_id' => $order->user_id,
            'admin_id' => auth()->id(),
        ]);
    }

    /**
     * Notify user when order is rejected
     */
    public function notifyOrderRejected($order, $reason, $type)
    {
        $itemName = $type === 'gas' ? ($order->item_name ?? 'Gas') : ($order->barang->nama_barang ?? 'Alat');
        
        Notification::create([
            'title' => 'Permintaan Ditolak',
            'message' => "Mohon maaf, permintaan {$itemName} Anda ditolak. Alasan: {$reason}",
            'type' => 'rejection',
            'user_id' => $order->user_id,
            'admin_id' => auth()->id(),
        ]);
    }

    /**
     * Notify user and admin when stock is insufficient
     */
    public function notifyStockInsufficient($order, $type, $availableStock, $requestedQty)
    {
        $itemName = $type === 'gas' ? $order->item_name : $order->barang->nama_barang;
        
        // Notify user
        Notification::create([
            'title' => 'Stok Tidak Mencukupi',
            'message' => "Mohon maaf, stok {$itemName} tidak mencukupi. Silakan ajukan ulang atau hubungi admin.",
            'type' => 'approval_failed',
            'user_id' => $order->user_id,
            'admin_id' => auth()->id(),
        ]);

        // Notify admin
        AdminNotification::create([
            'type' => 'stock_alert',
            'reference_id' => $order->id,
            'title' => 'Gagal Approve - Stok Tidak Cukup',
            'message' => "⚠️ Gagal approve request #{$order->order_number}. Stok {$itemName} tidak cukup (tersisa: {$availableStock}, diminta: {$requestedQty})",
            'is_read' => false,
        ]);
    }

    /**
     * Notify user when rental is completed
     */
    public function notifyRentalCompleted($booking)
    {
        $itemName = $booking->barang->nama_barang ?? 'Alat';
        
        Notification::create([
            'title' => 'Penyewaan Selesai',
            'message' => "Terima kasih! Penyewaan {$itemName} telah selesai. Jangan lupa beri rating ⭐",
            'type' => 'rental_completed',
            'user_id' => $booking->user_id,
            'admin_id' => auth()->id(),
        ]);
    }

    /**
     * Notify admin when stock is low
     */
    public function notifyLowStock($item, $type, $currentStock)
    {
        $itemName = $type === 'gas' ? $item->jenis_gas : $item->nama_barang;
        $satuan = $item->satuan ?? 'unit';
        
        AdminNotification::create([
            'type' => 'stock_low',
            'reference_id' => $item->id,
            'title' => 'Stok Menipis',
            'message' => "⚠️ Stok {$itemName} menipis! Tersisa: {$currentStock} {$satuan}. Segera restock.",
            'is_read' => false,
        ]);
    }

    /**
     * Notify admin when stock is depleted
     */
    public function notifyStockDepleted($item, $type)
    {
        $itemName = $type === 'gas' ? $item->jenis_gas : $item->nama_barang;
        
        AdminNotification::create([
            'type' => 'stock_depleted',
            'reference_id' => $item->id,
            'title' => 'Stok Habis',
            'message' => "🚨 Stok {$itemName} HABIS! Segera restock atau nonaktifkan item.",
            'is_read' => false,
        ]);
    }
}
