<?php

namespace App\Http\Controllers\Admin;

use App\Models\RentalBooking;
use App\Models\GasOrder;
use App\Models\Gas;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Services\NotificationService;

class RequestController extends Controller
{
    public function index(Request $request)
    {
        // Get filter parameters
        $status = $request->get('status', 'all');
        $category = $request->get('category', 'all');

        // Build queries for rental bookings
        $rentalQuery = RentalBooking::with(['user', 'barang']);
        if ($status !== 'all') {
            if ($status === 'cancellation_pending') {
                $rentalQuery->where('cancellation_status', 'pending');
            } elseif ($status === 'in_process') {
                $rentalQuery->whereIn('status', ['confirmed', 'approved', 'being_prepared', 'in_delivery', 'arrived']);
            } elseif ($status === 'completed') {
                $rentalQuery->whereIn('status', ['completed', 'resolved', 'returned']);
            } else {
                $rentalQuery->where('status', $status);
            }
        }

        // Build queries for gas orders
        $gasQuery = GasOrder::with('user');
        if ($status !== 'all') {
            if ($status === 'cancellation_pending') {
                $gasQuery->where('cancellation_status', 'pending');
            } elseif ($status === 'in_process') {
                $gasQuery->whereIn('status', ['confirmed', 'approved', 'being_prepared', 'in_delivery', 'arrived']);
            } elseif ($status === 'completed') {
                $gasQuery->whereIn('status', ['completed', 'resolved']);
            } else {
                $gasQuery->where('status', $status);
            }
        }

        // Get results based on category filter
        if ($category === 'rental') {
            $rentalRequests = $rentalQuery->orderByDesc('created_at')->get();
            $gasOrders = collect();
        } elseif ($category === 'gas') {
            $rentalRequests = collect();
            $gasOrders = $gasQuery->orderByDesc('created_at')->get();
        } elseif ($category === 'latest') {
            // Filter terbaru (7 hari terakhir)
            $rentalRequests = $rentalQuery->where('created_at', '>=', now()->subDays(7))->orderByDesc('created_at')->get();
            $gasOrders = $gasQuery->where('created_at', '>=', now()->subDays(7))->orderByDesc('created_at')->get();
        } else {
            $rentalRequests = $rentalQuery->orderByDesc('created_at')->get();
            $gasOrders = $gasQuery->orderByDesc('created_at')->get();
        }

        // Count statistics
        $stats = [
            'total' => RentalBooking::count() + GasOrder::count(),
            'pending' => RentalBooking::where('status', 'pending')->count() + GasOrder::where('status', 'pending')->count(),
            'approved' => RentalBooking::where('status', 'approved')->count() + GasOrder::where('status', 'approved')->count(),
            'rejected' => RentalBooking::where('status', 'rejected')->count() + GasOrder::where('status', 'rejected')->count(),
            'cancellation_pending' => RentalBooking::where('cancellation_status', 'pending')->count() + GasOrder::where('cancellation_status', 'pending')->count(),
            'rental_total' => RentalBooking::count(),
            'gas_total' => GasOrder::count(),
        ];

        return view('admin.aktivitas.requests', compact('rentalRequests', 'gasOrders', 'stats', 'status', 'category'));
    }

    public function show($id, $type)
    {
        if ($type === 'rental') {
            $request = RentalBooking::with(['user', 'barang'])->findOrFail($id);
        } else {
            $request = GasOrder::with('user')->findOrFail($id);
        }

        return view('admin.aktivitas.request-detail', compact('request', 'type'));
    }

    public function approve(Request $request, $id, $type)
    {
        $notificationService = new NotificationService();

        try {
            DB::beginTransaction();

            if ($type === 'rental') {
                $model = RentalBooking::with('barang')->findOrFail($id);
                
                // Check if already approved
                if ($model->status !== 'pending') {
                    throw new \Exception("Permintaan sudah diproses sebelumnya.");
                }

                // Get barang and validate stock
                $barang = $model->barang;
                $quantity = $model->quantity;

                if (!$barang->hasStock($quantity)) {
                    // Send notifications about insufficient stock
                    $notificationService->notifyStockInsufficient($model, 'rental', $barang->stok, $quantity);
                    
                    throw new \Exception("Stok tidak mencukupi. Tersedia: {$barang->stok}, diminta: {$quantity}");
                }

                // Decrease stock
                $barang->decreaseStock($quantity);

                // Check if stock is low after decrease
                if ($barang->stok < 5) {
                    $notificationService->notifyLowStock($barang, 'barang', $barang->stok);
                }

                // Check if stock is depleted
                if ($barang->stok == 0) {
                    $notificationService->notifyStockDepleted($barang, 'barang');
                }

                // Update booking status
                $newStatus = 'confirmed';
                $updateData = [
                    'status' => $newStatus,
                    'confirmed_at' => now()
                ];
                
                // Generate order number if not exists
                if (!$model->order_number) {
                    $updateData['order_number'] = \App\Models\RentalBooking::generateOrderNumber();
                }
                
                $model->update($updateData);

            } else {
                $model = GasOrder::findOrFail($id);
                
                // Check if already approved
                if ($model->status !== 'pending') {
                    throw new \Exception("Permintaan sudah diproses sebelumnya.");
                }

                // Get gas and validate stock
                $gas = Gas::findOrFail($model->gas_id);
                $quantity = $model->quantity;

                if (!$gas->hasStock($quantity)) {
                    // Send notifications about insufficient stock
                    $notificationService->notifyStockInsufficient($model, 'gas', $gas->stok, $quantity);
                    
                    throw new \Exception("Stok tidak mencukupi. Tersedia: {$gas->stok}, diminta: {$quantity}");
                }

                // Decrease stock (PERMANENT for gas)
                $gas->decreaseStock($quantity);

                // Check if stock is low after decrease
                if ($gas->stok < 5) {
                    $notificationService->notifyLowStock($gas, 'gas', $gas->stok);
                }

                // Check if stock is depleted
                if ($gas->stok == 0) {
                    $notificationService->notifyStockDepleted($gas, 'gas');
                }

                // Update order status
                $newStatus = 'confirmed';
                $updateData = [
                    'status' => $newStatus,
                    'confirmed_at' => now()
                ];
                
                // Generate order number if not exists
                if (!$model->order_number) {
                    $updateData['order_number'] = GasOrder::generateOrderNumber();
                }

                $model->update($updateData);
            }

            // Send approval success notification to user
            $notificationService->notifyOrderApproved($model, $type);

            DB::commit();

            $message = "Permintaan {$type} berhasil disetujui dan stok telah diperbarui.";

            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => $message,
                    'status' => $newStatus
                ]);
            }

            session()->flash('success', $message);
            return redirect()->back();

        } catch (\Exception $e) {
            DB::rollBack();

            $errorMessage = $e->getMessage();

            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => $errorMessage
                ], 400);
            }

            session()->flash('error', $errorMessage);
            return redirect()->back();
        }
    }

    public function reject(Request $request, $id, $type)
    {
        $request->validate([
            'reason' => 'required|string|max:500',
        ]);

        $notificationService = new NotificationService();

        if ($type === 'rental') {
            $model = RentalBooking::findOrFail($id);
            // RentalBooking uses Strict ENUM: pending, confirmed, in_progress, completed, cancelled
            // We use 'cancelled' to represent Rejection by Admin, and explain in notes
            $newStatus = 'cancelled';
            $model->update([
                'status' => $newStatus,
                'admin_notes' => "Ditolak: " . $request->reason,
                'cancellation_reason' => "Ditolak Admin: " . $request->reason,
                // Ensure cancellation_status is not 'pending' to avoid confusion
                'cancellation_status' => null 
            ]);
        } else {
            $model = GasOrder::findOrFail($id);
            // GasOrder uses string status, likely supports 'rejected'
            $newStatus = 'rejected';
            $model->update([
                'status' => $newStatus,
                'rejection_reason' => $request->reason,
            ]);
        }

        // Send rejection notification to user
        $notificationService->notifyOrderRejected($model, $request->reason, $type);

        $message = "Permintaan {$type} ditolak dengan alasan: {$request->reason}";

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'status' => $newStatus
            ]);
        }

        session()->flash('warning', $message);
        return redirect()->back();
    }

    public function updateStatus(Request $request, $type, $id)
    {
        $request->validate([
            'status' => 'required|string|in:confirmed,being_prepared,in_delivery,arrived,completed',
        ]);

        $notificationService = new NotificationService();

        if ($type === 'rental') {
            $order = \App\Models\RentalBooking::with('barang')->findOrFail($id);
        } else {
            $order = GasOrder::findOrFail($id);
        }

        $oldStatus = $order->status;
        $newStatus = $request->status;

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

                // RETURN STOCK for rental (not for gas!)
                if ($type === 'rental') {
                    $barang = $order->barang;
                    $quantity = $order->quantity;

                    // Increase stock back
                    $barang->increaseStock($quantity);

                    // Send rental completed notification to user
                    $notificationService->notifyRentalCompleted($order);

                    // Check if stock is still low after return
                    if ($barang->stok < 5 && $barang->stok > 0) {
                        $notificationService->notifyLowStock($barang, 'barang', $barang->stok);
                    }
                }
                break;
        }

        // Update status
        $order->status = $newStatus;
        $order->save();

        // Send notification to user about status change
        $statusLabels = [
            'confirmed' => 'dikonfirmasi',
            'being_prepared' => 'sedang dipersiapkan',
            'in_delivery' => 'dalam proses pengiriman',
            'arrived' => 'telah tiba',
            'completed' => 'selesai',
        ];

        // Only send general status update notification if not 'completed' (for completed we already sent specific notification above)
        if ($newStatus !== 'completed') {
            Notification::create([
                'title' => 'Status Pesanan Diperbarui',
                'message' => "Pesanan Anda #{$order->order_number} telah {$statusLabels[$newStatus]}.",
                'type' => 'status_update',
                'user_id' => $order->user_id,
                'admin_id' => auth()->id(),
            ]);
        }

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