<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class SettingController extends Controller
{
    public function index()
    {
        return view('settings.index'); // sesuaikan dengan lokasi view Anda
    }

    public function update()
    {
        // handle update jika diperlukan
        return back()->with('success', 'Pengaturan berhasil disimpan.');
    }
}