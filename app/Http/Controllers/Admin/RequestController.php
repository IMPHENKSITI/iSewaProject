<?php

namespace App\Http\Controllers\Admin;

use App\Models\RentalRequest;
use App\Models\GasOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Models\Notification;

class RequestController extends Controller
{
    public function index()
    {
        $rentalRequests = RentalRequest::where('status', 'pending')->orderByDesc('created_at')->get();
        $gasOrders = GasOrder::where('status', 'pending')->orderByDesc('created_at')->get();

        return view('admin.aktivitas.requests', compact('rentalRequests', 'gasOrders'));
    }

    public function show($id, $type)
    {
        if ($type === 'rental') {
            $request = RentalRequest::findOrFail($id);
        } else {
            $request = GasOrder::findOrFail($id);
        }

        return view('admin.aktivitas.request-detail', compact('request', 'type'));
    }

    public function approve(Request $request, $id, $type)
    {
        if ($type === 'rental') {
            $model = RentalRequest::findOrFail($id);
        } else {
            $model = GasOrder::findOrFail($id);
        }

        $model->update(['status' => 'approved']);

        // Trigger notifikasi: Status Berubah (Disetujui)
        $notification = new Notification();
        $notification->title = "Permintaan Disetujui";
        $notification->message = "Permintaan Anda (#{$model->id}) untuk {$type} telah disetujui oleh " . auth()->user()->name . ".";
        $notification->type = 'status_berubah';
        $notification->user_id = $model->user_id; // User yang membuat permintaan
        $notification->admin_id = auth()->id(); // Admin yang menyetujui
        $notification->save();

        session()->flash('success', "Permintaan {$type} berhasil disetujui.");

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

        // Trigger notifikasi: Status Berubah (Ditolak)
        $notification = new Notification();
        $notification->title = "Permintaan Ditolak";
        $notification->message = "Permintaan Anda (#{$model->id}) untuk {$type} telah ditolak oleh " . auth()->user()->name . ". Alasan: {$request->reason}";
        $notification->type = 'status_berubah';
        $notification->user_id = $model->user_id; // User yang membuat permintaan
        $notification->admin_id = auth()->id(); // Admin yang menolak
        $notification->save();

        session()->flash('warning', "Permintaan {$type} ditolak dengan alasan: {$request->reason}");

        return redirect()->back();
    }
}