<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\RentalBooking;
use App\Models\SystemSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class RentalBookingController extends Controller
{
    /**
     * Show the booking form
     */
    public function create($itemId)
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('beranda')->with('open_login_modal', true);
        }

        // Fetch the rental item
        $item = Barang::findOrFail($itemId);
        
        // Fetch system settings for bank account and location
        $setting = SystemSetting::first();
        
        // Get quantity from request (from detail page)
        $quantity = request()->get('quantity', 1);
        
        return view('users.rental-booking', compact('item', 'setting', 'quantity'));
    }

    /**
     * Store the booking
     */
    public function store(Request $request)
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'Anda harus login terlebih dahulu'], 401);
        }

        // Validate the request
        $validated = $request->validate([
            'barang_id' => 'required|exists:barang,id',
            'delivery_method' => 'required|in:antar,jemput',
            'quantity' => 'required|integer|min:1',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'payment_method' => 'required|in:transfer,tunai',
            
            // For 'antar' delivery method
            'recipient_name' => 'required_if:delivery_method,antar',
            'delivery_address' => 'required_if:delivery_method,antar',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            
            // For 'transfer' payment method
            'payment_proof' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        // Calculate days count
        $startDate = \Carbon\Carbon::parse($validated['start_date']);
        $endDate = \Carbon\Carbon::parse($validated['end_date']);
        $daysCount = $startDate->diffInDays($endDate) + 1;

        // Get item to calculate total
        $item = Barang::findOrFail($validated['barang_id']);
        $totalAmount = $item->harga_sewa * $validated['quantity'];

        // Handle payment proof upload
        $paymentProofPath = null;
        if ($request->hasFile('payment_proof')) {
            $paymentProofPath = $request->file('payment_proof')->store('payment_proofs', 'public');
        }

        // Create the booking
        $booking = RentalBooking::create([
            'user_id' => Auth::id(),
            'barang_id' => $validated['barang_id'],
            'delivery_method' => $validated['delivery_method'],
            'quantity' => $validated['quantity'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'days_count' => $daysCount,
            'recipient_name' => $validated['recipient_name'] ?? null,
            'delivery_address' => $validated['delivery_address'] ?? null,
            'latitude' => $validated['latitude'] ?? null,
            'longitude' => $validated['longitude'] ?? null,
            'payment_method' => $validated['payment_method'],
            'payment_proof' => $paymentProofPath,
            'total_amount' => $totalAmount,
            'status' => 'pending',
        ]);

        // Create transaction receipt
        $receipt = \App\Models\TransactionReceipt::create([
            'booking_type' => 'rental',
            'booking_id' => $booking->id,
            'receipt_number' => \App\Models\TransactionReceipt::generateReceiptNumber('rental'),
            'user_id' => Auth::id(),
            'item_name' => $item->nama_barang,
            'quantity' => $validated['quantity'],
            'total_amount' => $totalAmount,
            'payment_method' => $validated['payment_method'],
        ]);

        // Create admin notification
        \App\Models\AdminNotification::create([
            'type' => 'rental_request',
            'reference_id' => $booking->id,
            'title' => 'Permintaan Penyewaan Baru',
            'message' => 'Permintaan penyewaan ' . $item->nama_barang . ' dari ' . Auth::user()->name,
            'is_read' => false,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Pemesanan berhasil dibuat!',
            'booking_id' => $booking->id,
            'receipt_id' => $receipt->id,
            'receipt_number' => $receipt->receipt_number,
        ]);
    }
}

