<?php

namespace App\Http\Controllers\Admin;

use App\Models\RentalBooking;
use App\Models\GasOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Models\Notification;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        // Get filter parameters
        $category = $request->get('category', 'all');
        $paymentMethod = $request->get('payment_method', 'all');
        $search = $request->get('search');

        // Build queries
        // Build queries
        // Include transactions with proof OR system generated (active/completed statuses)
        $activeStatuses = ['confirmed', 'approved', 'being_prepared', 'in_delivery', 'arrived', 'completed', 'returned'];
        
        $rentalQuery = RentalBooking::with(['user', 'barang'])->where(function($q) use ($activeStatuses) {
            $q->whereNotNull('payment_proof')
              ->orWhereIn('status', $activeStatuses);
        });

        $gasQuery = GasOrder::with('user')->where(function($q) use ($activeStatuses) {
            $q->whereNotNull('proof_of_payment')
              ->orWhereIn('status', $activeStatuses);
        });

        // Filter by search
        if ($search) {
            $rentalQuery->where(function($q) use ($search) {
                $q->where('status', 'LIKE', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'LIKE', "%{$search}%");
                  });
            });
            
            $gasQuery->where(function($q) use ($search) {
                $q->where('status', 'LIKE', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'LIKE', "%{$search}%");
                  });
            });
        }

        // Filter by payment method
        if ($paymentMethod !== 'all') {
            $rentalQuery->where('payment_method', $paymentMethod);
            $gasQuery->where('payment_method', $paymentMethod);
        }

        // Get results based on category filter
        if ($category === 'rental') {
            $rentalPayments = $rentalQuery->orderByDesc('updated_at')->get();
            $gasPayments = collect();
        } elseif ($category === 'gas') {
            $rentalPayments = collect();
            $gasPayments = $gasQuery->orderByDesc('updated_at')->get();
        } else {
            $rentalPayments = $rentalQuery->orderByDesc('updated_at')->get();
            $gasPayments = $gasQuery->orderByDesc('updated_at')->get();
        }

        // Count statistics
        $rentalCount = RentalBooking::where(function($q) use ($activeStatuses) {
            $q->whereNotNull('payment_proof')
              ->orWhereIn('status', $activeStatuses);
        })->count();
        
        $gasCount = GasOrder::where(function($q) use ($activeStatuses) {
            $q->whereNotNull('proof_of_payment')
              ->orWhereIn('status', $activeStatuses);
        })->count();

        $stats = [
            'total' => $rentalCount + $gasCount,
            'rental_total' => $rentalCount,
            'gas_total' => $gasCount,
            'transfer_total' => 0, // Transfer is disabled for now
            'cash_total' => $rentalCount + $gasCount, // All valid transactions are essentially verified/cash/system
        ];

        return view('admin.aktivitas.transactions', compact('rentalPayments', 'gasPayments', 'stats', 'category', 'paymentMethod', 'search'));
    }

    public function verify(Request $request, $id, $type)
    {
        if ($type === 'rental') {
            $model = RentalBooking::findOrFail($id);
        } else {
            $model = GasOrder::findOrFail($id);
        }

        $model->update(['status' => 'completed']);

        // Trigger notifikasi: Pengajuan Selesai
        $notification = new Notification();
        $notification->title = "Transaksi Selesai";
        $notification->message = "Transaksi Anda (#{$model->id}) untuk {$type} telah diselesaikan.";
        $notification->type = 'pengajuan_selesai';
        $notification->user_id = $model->user_id; // User yang transaksi
        $notification->admin_id = auth()->id(); // Admin yang menyelesaikan
        $notification->save();

        session()->flash('success', "Bukti pembayaran {$type} telah diverifikasi.");

        return redirect()->back();
    }

    public function reject(Request $request, $id, $type)
    {
        $request->validate([
            'reason' => 'required|string|max:500',
        ]);

        if ($type === 'rental') {
            $model = RentalBooking::findOrFail($id);
        } else {
            $model = GasOrder::findOrFail($id);
        }

        $model->update([
            'status' => 'rejected',
            'rejection_reason' => $request->reason,
        ]);

        // Trigger notifikasi: Bukti Pembayaran Ditolak
        $notification = new Notification();
        $notification->title = "Bukti Pembayaran Ditolak";
        $notification->message = "Bukti pembayaran untuk transaksi Anda (#{$model->id}) untuk {$type} telah ditolak oleh " . auth()->user()->name . ". Alasan: {$request->reason}";
        $notification->type = 'status_berubah'; // atau buat type baru seperti 'bukti_ditolak'
        $notification->user_id = $model->user_id; // User yang upload bukti
        $notification->admin_id = auth()->id(); // Admin yang menolak
        $notification->save();

        session()->flash('warning', "Bukti pembayaran {$type} ditolak: {$request->reason}");

        return redirect()->back();
    }

    public function downloadProof($id, $type)
    {
        if ($type === 'rental') {
            $model = RentalBooking::findOrFail($id);
        } else {
            $model = GasOrder::findOrFail($id);
        }

        // Determine proof column
        $proofColumn = ($type === 'rental') ? 'payment_proof' : 'proof_of_payment';

        if (!$model->$proofColumn) {
            abort(404, 'Bukti pembayaran tidak ditemukan.');
        }

        // Check if file exists in storage
        if (!Storage::disk('public')->exists($model->$proofColumn)) {
            abort(404, 'File bukti pembayaran tidak ditemukan di storage.');
        }

        return Storage::disk('public')->download($model->$proofColumn);
    }
}