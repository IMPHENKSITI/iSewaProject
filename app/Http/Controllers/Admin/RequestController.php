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
    public function index(Request $request)
    {
        // Get filter parameters
        $status = $request->get('status', 'all');
        $category = $request->get('category', 'all');

        // Build queries for rental requests
        $rentalQuery = RentalRequest::with('user');
        if ($status !== 'all') {
            $rentalQuery->where('status', $status);
        }

        // Build queries for gas orders
        $gasQuery = GasOrder::with('user');
        if ($status !== 'all') {
            $gasQuery->where('status', $status);
        }

        // Get results based on category filter
        if ($category === 'rental') {
            $rentalRequests = $rentalQuery->orderByDesc('created_at')->get();
            $gasOrders = collect();
        } elseif ($category === 'gas') {
            $rentalRequests = collect();
            $gasOrders = $gasQuery->orderByDesc('created_at')->get();
        } else {
            $rentalRequests = $rentalQuery->orderByDesc('created_at')->get();
            $gasOrders = $gasQuery->orderByDesc('created_at')->get();
        }

        // Count statistics
        $stats = [
            'total' => RentalRequest::count() + GasOrder::count(),
            'pending' => RentalRequest::where('status', 'pending')->count() + GasOrder::where('status', 'pending')->count(),
            'approved' => RentalRequest::where('status', 'approved')->count() + GasOrder::where('status', 'approved')->count(),
            'rejected' => RentalRequest::where('status', 'rejected')->count() + GasOrder::where('status', 'rejected')->count(),
            'rental_total' => RentalRequest::count(),
            'gas_total' => GasOrder::count(),
        ];

        return view('admin.aktivitas.requests', compact('rentalRequests', 'gasOrders', 'stats', 'status', 'category'));
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