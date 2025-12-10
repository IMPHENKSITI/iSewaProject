<?php

namespace App\Services;

use App\Models\RentalBooking;
use App\Models\GasOrder;
use Illuminate\Support\Facades\Storage;

class ReceiptGeneratorService
{
    /**
     * Generate receipt for rental booking
     */
    public function generateRentalReceipt(RentalBooking $booking)
    {
        // Load background template
        $backgroundPath = public_path('admin/img/transaksi/bukti-penyewaan-alat.png');
        
        if (!file_exists($backgroundPath)) {
            throw new \Exception('Background template not found: ' . $backgroundPath);
        }

        $image = imagecreatefrompng($backgroundPath);
        $imageWidth = imagesx($image);
        $imageHeight = imagesy($image);
        
        // Set colors
        $black = imagecolorallocate($image, 0, 0, 0);
        $red = imagecolorallocate($image, 255, 0, 0);
        $green = imagecolorallocate($image, 0, 170, 0);
        
        // Font path
        $fontPath = public_path('fonts/arial.ttf');
        
        // Font sizes - REALLY BIG for readability
        $normalSize = 78;  // Normal text - MUCH BIGGER
        $headerSize = 66;  // Section headers - MUCH BIGGER
        
        // Adjusted layout for bigger fonts
        $startY = 280;
        $lineHeight = 70;  // More space for bigger fonts
        
        // No. Pesanan
        $y = $startY;
        $this->addText($image, 'No. Pesanan', 50, $y, $normalSize, $black, $fontPath, true);
        $this->addText($image, ': ' . $booking->order_number, 400, $y, $normalSize, $black, $fontPath);
        
        // Waktu Pemesanan
        $y += $lineHeight;
        $this->addText($image, 'Waktu Pemesanan', 50, $y, $normalSize, $black, $fontPath, true);
        $this->addText($image, ': ' . $booking->created_at->locale('id')->isoFormat('dddd, DD MMMM YYYY  HH:mm') . ' WIB', 400, $y, $normalSize, $black, $fontPath);
        
        // Nama Pemesan
        $y += $lineHeight;
        $this->addText($image, 'Nama Pemesan', 50, $y, $normalSize, $black, $fontPath, true);
        $this->addText($image, ': ' . $booking->user->name, 400, $y, $normalSize, $black, $fontPath);
        
        // Email
        $y += $lineHeight;
        $this->addText($image, 'Email', 50, $y, $normalSize, $black, $fontPath, true);
        $this->addText($image, ': ' . $booking->user->email, 400, $y, $normalSize, $black, $fontPath);
        
        // Horizontal line
        $y += 30;
        $this->drawLine($image, 50, $y, $imageWidth - 50, $y, $black);
        
        // Informasi Pembayaran Header
        $y += 40;
        $this->addText($image, 'Informasi Pembayaran', 50, $y, $headerSize, $black, $fontPath, true);
        
        // Waktu Pembayaran
        $y += $lineHeight;
        $this->addText($image, 'Waktu Pembayaran', 50, $y, $normalSize, $black, $fontPath, true);
        $this->addText($image, ': ' . ($booking->confirmed_at ? $booking->confirmed_at->locale('id')->isoFormat('dddd, DD MMMM YYYY  HH:mm') . ' WIB' : '-'), 400, $y, $normalSize, $black, $fontPath);
        
        // Metode Pembayaran
        $y += $lineHeight;
        $this->addText($image, 'Metode Pembayaran', 50, $y, $normalSize, $black, $fontPath, true);
        $this->addText($image, ': ' . $this->getPaymentMethodLabel($booking->payment_method), 400, $y, $normalSize, $black, $fontPath);
        
        // Total Pembayaran
        $y += $lineHeight;
        $this->addText($image, 'Total Pembayaran', 50, $y, $normalSize, $black, $fontPath, true);
        $this->addText($image, ': Rp. ' . number_format($booking->total_amount, 0, ',', '.'), 400, $y, $normalSize, $black, $fontPath);
        
        // Status
        $y += $lineHeight;
        $this->addText($image, 'Status', 50, $y, $normalSize, $black, $fontPath, true);
        $statusText = $this->getStatusLabel($booking->status);
        $statusColor = in_array($booking->status, ['completed', 'confirmed']) ? $green : (in_array($booking->status, ['cancelled', 'rejected']) ? $red : $black);
        $this->addText($image, ': ' . $statusText, 400, $y, $normalSize, $statusColor, $fontPath);
        
        // Horizontal line
        $y += 30;
        $this->drawLine($image, 50, $y, $imageWidth - 50, $y, $black);
        
        // Detail Pembayaran Header
        $y += 40;
        $this->addText($image, 'Detail Pembayaran', 50, $y, $headerSize, $black, $fontPath, true);
        
        // Table Headers
        $y += $lineHeight;
        $this->addText($image, 'Keterangan', 50, $y, $normalSize, $black, $fontPath, true);
        $this->addText($image, 'Jumlah', 450, $y, $normalSize, $black, $fontPath, true);
        $this->addText($image, 'Satuan', 600, $y, $normalSize, $black, $fontPath, true);
        $this->addText($image, 'Total', 850, $y, $normalSize, $black, $fontPath, true);
        
        // Line under headers
        $y += 10;
        $this->drawLine($image, 50, $y, $imageWidth - 50, $y, $black);
        
        // Table Data
        $y += 35;
        $itemName = $booking->barang->nama_barang;
        $quantity = (string)$booking->quantity;
        $unitPrice = 'Rp. ' . number_format($booking->barang->harga, 0, ',', '.');
        $total = 'Rp. ' . number_format($booking->total_amount, 0, ',', '.');
        
        $this->addText($image, $itemName, 50, $y, $normalSize, $black, $fontPath);
        $this->addText($image, $quantity, 450, $y, $normalSize, $black, $fontPath);
        $this->addText($image, $unitPrice, 600, $y, $normalSize, $black, $fontPath);
        $this->addText($image, $total, 850, $y, $normalSize, $black, $fontPath);
        
        // Line
        $y += 35;
        $this->drawLine($image, 450, $y, $imageWidth - 50, $y, $black);
        
        // Total Pemesanan
        $y += 35;
        $this->addText($image, 'Total Pemesanan', 450, $y, $normalSize, $black, $fontPath);
        $this->addText($image, 'Rp. ' . number_format($booking->total_amount, 0, ',', '.'), 850, $y, $normalSize, $black, $fontPath);
        
        // Total Dibayar (Bold)
        $y += $lineHeight;
        $this->addText($image, 'Total Dibayar', 450, $y, $headerSize, $black, $fontPath, true);
        $this->addText($image, 'Rp. ' . number_format($booking->total_amount, 0, ',', '.'), 850, $y, $headerSize, $black, $fontPath, true);
        
        // Footer
        $y += 80;
        $location = 'Bengkalis';
        $date = $booking->created_at->locale('id')->isoFormat('DD MMMM YYYY');
        $this->addText($image, $location . ', ' . $date, 50, $y, $normalSize, $black, $fontPath, true);
        
        // Save receipt
        $filename = 'receipt_rental_' . $booking->order_number . '_' . time() . '.png';
        $path = 'receipts/rental/' . $filename;
        
        $fullPath = storage_path('app/public/' . dirname($path));
        if (!file_exists($fullPath)) {
            mkdir($fullPath, 0755, true);
        }
        
        ob_start();
        imagepng($image);
        $imageData = ob_get_clean();
        Storage::disk('public')->put($path, $imageData);
        
        imagedestroy($image);
        
        return $path;
    }

    /**
     * Generate receipt for gas order
     */
    public function generateGasReceipt(GasOrder $order)
    {
        // Load background template
        $backgroundPath = public_path('admin/img/transaksi/bukti-gas.png');
        
        if (!file_exists($backgroundPath)) {
            throw new \Exception('Background template not found: ' . $backgroundPath);
        }

        $image = imagecreatefrompng($backgroundPath);
        $imageWidth = imagesx($image);
        $imageHeight = imagesy($image);
        
        // Set colors
        $black = imagecolorallocate($image, 0, 0, 0);
        $red = imagecolorallocate($image, 255, 0, 0);
        $green = imagecolorallocate($image, 0, 170, 0);
        
        // Font path
        $fontPath = public_path('fonts/arial.ttf');
        
        // Font sizes - REALLY BIG for readability
        $normalSize = 78;  // Normal text - MUCH BIGGER
        $headerSize = 66;  // Section headers - MUCH BIGGER
        
        // Adjusted layout for bigger fonts
        $startY = 280;
        $lineHeight = 70;  // More space for bigger fonts
        
        // No. Pesanan
        $y = $startY;
        $this->addText($image, 'No. Pesanan', 50, $y, $normalSize, $black, $fontPath, true);
        $this->addText($image, ': ' . $order->order_number, 400, $y, $normalSize, $black, $fontPath);
        
        // Waktu Pemesanan
        $y += $lineHeight;
        $this->addText($image, 'Waktu Pemesanan', 50, $y, $normalSize, $black, $fontPath, true);
        $this->addText($image, ': ' . $order->created_at->locale('id')->isoFormat('dddd, DD MMMM YYYY  HH:mm') . ' WIB', 400, $y, $normalSize, $black, $fontPath);
        
        // Nama Pemesan
        $y += $lineHeight;
        $this->addText($image, 'Nama Pemesan', 50, $y, $normalSize, $black, $fontPath, true);
        $this->addText($image, ': ' . $order->user->name, 400, $y, $normalSize, $black, $fontPath);
        
        // Email
        $y += $lineHeight;
        $this->addText($image, 'Email', 50, $y, $normalSize, $black, $fontPath, true);
        $this->addText($image, ': ' . $order->user->email, 400, $y, $normalSize, $black, $fontPath);
        
        // Horizontal line
        $y += 30;
        $this->drawLine($image, 50, $y, $imageWidth - 50, $y, $black);
        
        // Informasi Pembayaran Header
        $y += 40;
        $this->addText($image, 'Informasi Pembayaran', 50, $y, $headerSize, $black, $fontPath, true);
        
        // Waktu Pembayaran
        $y += $lineHeight;
        $this->addText($image, 'Waktu Pembayaran', 50, $y, $normalSize, $black, $fontPath, true);
        $this->addText($image, ': ' . ($order->confirmed_at ? $order->confirmed_at->locale('id')->isoFormat('dddd, DD MMMM YYYY  HH:mm') . ' WIB' : '-'), 400, $y, $normalSize, $black, $fontPath);
        
        // Metode Pembayaran
        $y += $lineHeight;
        $this->addText($image, 'Metode Pembayaran', 50, $y, $normalSize, $black, $fontPath, true);
        $this->addText($image, ': ' . $this->getPaymentMethodLabel($order->payment_method), 400, $y, $normalSize, $black, $fontPath);
        
        // Total Pembayaran
        $totalPrice = $order->price * $order->quantity;
        $y += $lineHeight;
        $this->addText($image, 'Total Pembayaran', 50, $y, $normalSize, $black, $fontPath, true);
        $this->addText($image, ': Rp. ' . number_format($totalPrice, 0, ',', '.'), 400, $y, $normalSize, $black, $fontPath);
        
        // Status
        $y += $lineHeight;
        $this->addText($image, 'Status', 50, $y, $normalSize, $black, $fontPath, true);
        $statusText = $this->getStatusLabel($order->status);
        $statusColor = in_array($order->status, ['completed', 'confirmed']) ? $green : (in_array($order->status, ['cancelled', 'rejected']) ? $red : $black);
        $this->addText($image, ': ' . $statusText, 400, $y, $normalSize, $statusColor, $fontPath);
        
        // Horizontal line
        $y += 30;
        $this->drawLine($image, 50, $y, $imageWidth - 50, $y, $black);
        
        // Detail Pembayaran Header
        $y += 40;
        $this->addText($image, 'Detail Pembayaran', 50, $y, $headerSize, $black, $fontPath, true);
        
        // Table Headers
        $y += $lineHeight;
        $this->addText($image, 'Keterangan', 50, $y, $normalSize, $black, $fontPath, true);
        $this->addText($image, 'Jumlah', 450, $y, $normalSize, $black, $fontPath, true);
        $this->addText($image, 'Satuan', 600, $y, $normalSize, $black, $fontPath, true);
        $this->addText($image, 'Total', 850, $y, $normalSize, $black, $fontPath, true);
        
        // Line under headers
        $y += 10;
        $this->drawLine($image, 50, $y, $imageWidth - 50, $y, $black);
        
        // Table Data
        $y += 35;
        $itemName = $order->item_name;
        $quantity = (string)$order->quantity;
        $unitPrice = 'Rp. ' . number_format($order->price, 0, ',', '.');
        $total = 'Rp. ' . number_format($totalPrice, 0, ',', '.');
        
        $this->addText($image, $itemName, 50, $y, $normalSize, $black, $fontPath);
        $this->addText($image, $quantity, 450, $y, $normalSize, $black, $fontPath);
        $this->addText($image, $unitPrice, 600, $y, $normalSize, $black, $fontPath);
        $this->addText($image, $total, 850, $y, $normalSize, $black, $fontPath);
        
        // Line
        $y += 35;
        $this->drawLine($image, 450, $y, $imageWidth - 50, $y, $black);
        
        // Total Pemesanan
        $y += 35;
        $this->addText($image, 'Total Pemesanan', 450, $y, $normalSize, $black, $fontPath);
        $this->addText($image, 'Rp. ' . number_format($totalPrice, 0, ',', '.'), 850, $y, $normalSize, $black, $fontPath);
        
        // Total Dibayar (Bold)
        $y += $lineHeight;
        $this->addText($image, 'Total Dibayar', 450, $y, $headerSize, $black, $fontPath, true);
        $this->addText($image, 'Rp. ' . number_format($totalPrice, 0, ',', '.'), 850, $y, $headerSize, $black, $fontPath, true);
        
        // Footer
        $y += 80;
        $location = 'Bengkalis';
        $date = $order->created_at->locale('id')->isoFormat('DD MMMM YYYY');
        $this->addText($image, $location . ', ' . $date, 50, $y, $normalSize, $black, $fontPath, true);
        
        // Save receipt
        $filename = 'receipt_gas_' . $order->order_number . '_' . time() . '.png';
        $path = 'receipts/gas/' . $filename;
        
        $fullPath = storage_path('app/public/' . dirname($path));
        if (!file_exists($fullPath)) {
            mkdir($fullPath, 0755, true);
        }
        
        ob_start();
        imagepng($image);
        $imageData = ob_get_clean();
        Storage::disk('public')->put($path, $imageData);
        
        imagedestroy($image);
        
        return $path;
    }

    /**
     * Draw horizontal line
     */
    protected function drawLine($image, $x1, $y, $x2, $y2, $color)
    {
        imagesetthickness($image, 2);
        imageline($image, $x1, $y, $x2, $y2, $color);
        imagesetthickness($image, 1);
    }

    /**
     * Add text to image using GD
     */
    protected function addText($image, $text, $x, $y, $size, $color, $fontPath, $bold = false)
    {
        if (file_exists($fontPath)) {
            imagettftext($image, $size, 0, $x, $y, $color, $fontPath, $text);
            
            if ($bold) {
                imagettftext($image, $size, 0, $x + 1, $y, $color, $fontPath, $text);
                imagettftext($image, $size, 0, $x, $y + 1, $color, $fontPath, $text);
                imagettftext($image, $size, 0, $x + 1, $y + 1, $color, $fontPath, $text);
            }
        } else {
            imagestring($image, 5, $x, $y, $text, $color);
        }
    }

    protected function getPaymentMethodLabel($method)
    {
        $labels = [
            'transfer' => 'Transfer - Bank Syariah Indonesia',
            'tunai' => 'Pembayaran Tunai',
            'cash' => 'Pembayaran Tunai',
        ];
        return $labels[$method] ?? ucfirst($method);
    }

    protected function getStatusLabel($status)
    {
        $labels = [
            'pending' => 'Di Proses',
            'confirmed' => 'Lunas / Selesai',
            'in_progress' => 'Dalam Proses',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
            'rejected' => 'Ditolak',
            'paid' => 'Sudah Bayar',
            'approved' => 'Disetujui',
            'being_prepared' => 'Dipersiapkan',
            'in_delivery' => 'Dalam Pengiriman',
            'arrived' => 'Tiba',
            'returned' => 'Dikembalikan',
        ];
        return $labels[$status] ?? ucfirst($status);
    }
}
