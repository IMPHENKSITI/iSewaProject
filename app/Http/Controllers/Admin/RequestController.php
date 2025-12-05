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

    public function updateStatus(Request $request, $type, $id)
    {
        $request->validate([
            'status' => 'required|string|in:confirmed,being_prepared,in_delivery,arrived,completed',
        ]);

        if ($type === 'rental') {
            $order = \App\Models\RentalBooking::findOrFail($id);
        } else {
            $order = GasOrder::findOrFail($id);
        }

        $oldStatus = $order->status;
        $newStatus = $request->status;

        // Update status
        $order->status = $newStatus;

        // Auto-generate timestamps based on status
        switch ($newStatus) {
            case 'confirmed':
                if (!$order->confirmed_at) {
                    $order->confirmed_at = now();
                }
                // Generate order number if not exists
                if (!$order->order_number) {
                    $order->order_number = $type === 'rental' 
                        ? \App\Models\RentalBooking::generateOrderNumber()
                        : GasOrder::generateOrderNumber();
                }
                break;
            case 'in_delivery':
                if (!$order->delivery_time) {
                    $order->delivery_time = now();
                }
                break;
            case 'arrived':
                if (!$order->arrival_time) {
                    $order->arrival_time = now();
                }
                break;
            case 'completed':
                if (!$order->completion_time) {
                    $order->completion_time = now();
                }
                break;
        }

        $order->save();

        // Send notification to user
        $statusLabels = [
            'confirmed' => 'dikonfirmasi',
            'being_prepared' => 'sedang dipersiapkan',
            'in_delivery' => 'dalam proses pengiriman',
            'arrived' => 'telah tiba',
            'completed' => 'selesai',
        ];

        Notification::create([
            'title' => 'Status Pesanan Diperbarui',
            'message' => "Pesanan Anda #{$order->order_number} telah {$statusLabels[$newStatus]}.",
            'type' => 'status_update',
            'user_id' => $order->user_id,
            'admin_id' => auth()->id(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Status berhasil diperbarui',
            'order' => $order
        ]);
    }

    public function uploadDeliveryProof(Request $request, $type, $id)
    {
        $request->validate([
            'delivery_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($type === 'rental') {
            $order = \App\Models\RentalBooking::findOrFail($id);
        } else {
            $order = GasOrder::findOrFail($id);
        }

        // Store the image
        if ($request->hasFile('delivery_proof')) {
            // Delete old proof if exists
            if ($order->delivery_proof_image) {
                Storage::delete($order->delivery_proof_image);
            }

            $path = $request->file('delivery_proof')->store('delivery_proofs', 'public');
            $order->delivery_proof_image = $path;
            
            // Auto-update status to arrived if not already
            if ($order->status !== 'arrived' && $order->status !== 'completed') {
                $order->status = 'arrived';
                if (!$order->arrival_time) {
                    $order->arrival_time = now();
                }
            }
            
            $order->save();

            // Send notification to user
            Notification::create([
                'title' => 'Bukti Pengiriman Tersedia',
                'message' => "Bukti pengiriman untuk pesanan #{$order->order_number} telah tersedia.",
                'type' => 'delivery_proof',
                'user_id' => $order->user_id,
                'admin_id' => auth()->id(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Bukti pengiriman berhasil diunggah',
                'path' => $path
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Gagal mengunggah bukti pengiriman'
        ], 400);
    }

    public function handleCancellation(Request $request, $type, $id, $action)
    {
        if (!in_array($action, ['approve', 'reject'])) {
            return response()->json([
                'success' => false,
                'message' => 'Aksi tidak valid'
            ], 400);
        }

        if ($type === 'rental') {
            $order = \App\Models\RentalBooking::findOrFail($id);
        } else {
            $order = GasOrder::findOrFail($id);
        }

        if ($order->cancellation_status !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada permintaan pembatalan yang pending'
            ], 400);
        }

        if ($action === 'approve') {
            $order->cancellation_status = 'approved';
            $order->status = 'cancelled';
            $message = 'Permintaan pembatalan disetujui';
            
            // Send notification to user
            Notification::create([
                'title' => 'Pembatalan Disetujui',
                'message' => "Permintaan pembatalan pesanan #{$order->order_number} telah disetujui.",
                'type' => 'cancellation_approved',
                'user_id' => $order->user_id,
                'admin_id' => auth()->id(),
            ]);
        } else {
            $request->validate([
                'admin_response' => 'required|string|max:500',
            ]);

            $order->cancellation_status = 'rejected';
            $order->admin_cancellation_response = $request->admin_response;
            $message = 'Permintaan pembatalan ditolak';
            
            // Send notification to user
            Notification::create([
                'title' => 'Pembatalan Ditolak',
                'message' => "Permintaan pembatalan pesanan #{$order->order_number} ditolak. Alasan: {$request->admin_response}",
                'type' => 'cancellation_rejected',
                'user_id' => $order->user_id,
                'admin_id' => auth()->id(),
            ]);
        }

        $order->save();

        return response()->json([
            'success' => true,
            'message' => $message
        ]);
    }
}