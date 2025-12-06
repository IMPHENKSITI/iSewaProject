<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\RentalBooking;
use App\Models\GasOrder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

class ReceiptController extends Controller
{
    /**
     * View rental receipt
     */
    public function viewRentalReceipt($id)
    {
        $booking = RentalBooking::findOrFail($id);
        
        // Check if user owns this booking
        if ($booking->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access');
        }
        
        if (!$booking->receipt_path || !Storage::disk('public')->exists($booking->receipt_path)) {
            abort(404, 'Receipt not found');
        }
        
        $path = Storage::disk('public')->path($booking->receipt_path);
        
        return Response::file($path, [
            'Content-Type' => 'image/png',
            'Content-Disposition' => 'inline; filename="Bukti_Transaksi_' . $booking->order_number . '.png"'
        ]);
    }
    
    /**
     * Download rental receipt
     */
    public function downloadRentalReceipt($id)
    {
        $booking = RentalBooking::findOrFail($id);
        
        // Check if user owns this booking
        if ($booking->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access');
        }
        
        if (!$booking->receipt_path || !Storage::disk('public')->exists($booking->receipt_path)) {
            abort(404, 'Receipt not found');
        }
        
        return Storage::disk('public')->download(
            $booking->receipt_path,
            'Bukti_Transaksi_Penyewaan_' . $booking->order_number . '.png'
        );
    }
    
    /**
     * View gas receipt
     */
    public function viewGasReceipt($id)
    {
        $order = GasOrder::findOrFail($id);
        
        // Check if user owns this order
        if ($order->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access');
        }
        
        if (!$order->receipt_path || !Storage::disk('public')->exists($order->receipt_path)) {
            abort(404, 'Receipt not found');
        }
        
        $path = Storage::disk('public')->path($order->receipt_path);
        
        return Response::file($path, [
            'Content-Type' => 'image/png',
            'Content-Disposition' => 'inline; filename="Bukti_Transaksi_' . $order->order_number . '.png"'
        ]);
    }
    
    /**
     * Download gas receipt
     */
    public function downloadGasReceipt($id)
    {
        $order = GasOrder::findOrFail($id);
        
        // Check if user owns this order
        if ($order->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access');
        }
        
        if (!$order->receipt_path || !Storage::disk('public')->exists($order->receipt_path)) {
            abort(404, 'Receipt not found');
        }
        
        return Storage::disk('public')->download(
            $order->receipt_path,
            'Bukti_Transaksi_Gas_' . $order->order_number . '.png'
        );
    }
}
