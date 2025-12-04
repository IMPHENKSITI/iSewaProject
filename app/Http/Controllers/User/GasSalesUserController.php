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
}
