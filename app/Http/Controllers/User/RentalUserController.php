<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Barang;

class RentalUserController extends Controller
{
    public function index()
    {
        // Fetch all rental items (exclude broken items)
        $items = Barang::where('status', '!=', 'rusak')
                       ->orderBy('created_at', 'desc')
                       ->get();
        
        return view('users.rental-equipment', compact('items'));
    }
}
