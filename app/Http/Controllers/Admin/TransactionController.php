<?php

namespace App\Http\Controllers\Admin;

use App\Models\RentalRequest;
use App\Models\GasOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Models\Notification;

class TransactionController extends Controller
{
    public function index()
    {
        $rentalPayments = RentalRequest::whereNotNull('proof_of_payment')->orderByDesc('updated_at')->get();
        $gasPayments = GasOrder::whereNotNull('proof_of_payment')->orderByDesc('updated_at')->get();

        return view('admin.aktivitas.transactions', compact('rentalPayments', 'gasPayments'));
    }

    public function verify(Request $request, $id, $type)
    {
        if ($type === 'rental') {
            $model = RentalRequest::findOrFail($id);
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
            $model = RentalRequest::findOrFail($id);
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
            $model = RentalRequest::findOrFail($id);
        } else {
            $model = GasOrder::findOrFail($id);
        }

        if (!$model->proof_of_payment) {
            abort(404, 'Bukti pembayaran tidak ditemukan.');
        }

        return Storage::download($model->proof_of_payment);
    }
}