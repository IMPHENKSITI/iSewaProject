<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\RentalBooking;
use App\Models\GasOrder;
use App\Models\SystemSetting;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function index()
    {
        // Get authenticated user
        $user = Auth::user();
        
        // Fetch user's rental bookings with product details
        $rentalBookings = RentalBooking::where('user_id', $user->id)
            ->with('barang') // Assuming relationship exists
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Fetch user's gas orders with gas details
        $gasOrders = GasOrder::where('user_id', $user->id)
            ->with('gas') // Load gas relationship
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Fetch system settings for location
        $setting = SystemSetting::first();
        
        return view('users.activity', compact('rentalBookings', 'gasOrders', 'setting'));
    }

    public function requestCancellation(Request $request, $type, $id)
    {
        $request->validate([
            'reason' => 'required|string|max:500',
        ]);

        if ($type === 'rental') {
            $order = RentalBooking::where('id', $id)
                ->where('user_id', Auth::id())
                ->firstOrFail();
            
            if (!$order->canBeCancelled()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Pesanan tidak dapat dibatalkan'
                ], 400);
            }

            $order->update([
                'cancellation_reason' => $request->reason,
                'cancellation_requested_at' => now(),
                'cancellation_status' => 'pending',
            ]);
        } else {
            $order = GasOrder::where('id', $id)
                ->where('user_id', Auth::id())
                ->firstOrFail();
            
            if (!$order->canBeCancelled()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Pesanan tidak dapat dibatalkan'
                ], 400);
            }

            $order->update([
                'cancellation_reason_user' => $request->reason,
                'cancellation_requested_at' => now(),
                'cancellation_status' => 'pending',
            ]);
        }

        // Create notification for admin
        Notification::create([
            'title' => 'Permintaan Pembatalan Pesanan',
            'message' => "User {$order->user->name} mengajukan pembatalan pesanan #{$order->order_number}. Alasan: {$request->reason}",
            'type' => 'cancellation_request',
            'user_id' => null, // For admin
            'admin_id' => 1, // Send to admin
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Permintaan pembatalan berhasil diajukan'
        ]);
    }
}
