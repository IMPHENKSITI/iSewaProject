<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Gas;

class GasSalesUserController extends Controller
{
    public function index()
    {
        $items = Gas::where('status', '!=', 'rusak')
                    ->orderBy('created_at', 'desc')
                    ->get();
        
        return view('users.gas-sales', compact('items'));
    }

    public function show($id)
    {
        // Fetch specific gas product
        $item = Gas::findOrFail($id);
        
        // Fetch system settings for location
        $setting = \App\Models\SystemSetting::first();
        
        return view('users.gas-detail', compact('item', 'setting'));
    }

    public function booking($id)
    {
        // Check if user is authenticated
        if (!\Illuminate\Support\Facades\Auth::check()) {
            return redirect()->route('beranda')->with('open_login_modal', true);
        }

        // Fetch specific gas product
        $item = Gas::findOrFail($id);
        
        // Get quantity from query parameter, default to 1
        $quantity = request()->query('quantity', 1);
        
        // Validate quantity
        if ($quantity < 1) {
            $quantity = 1;
        }
        if ($quantity > $item->stok) {
            $quantity = $item->stok;
        }
        
        // Fetch system settings for payment methods and bank details
        $setting = \App\Models\SystemSetting::first();
        
        return view('users.gas-booking', compact('item', 'quantity', 'setting'));
    }
}
