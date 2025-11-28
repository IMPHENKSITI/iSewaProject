<?php

namespace App\Http\Controllers\Admin;

use App\Models\SystemSetting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SystemSettingController extends Controller
{
    public function index()
    {
        // Ambil setting pertama (atau buat baru jika belum ada)
        $setting = SystemSetting::first();
        if (!$setting) {
            $setting = SystemSetting::create([
                'location_name' => 'BUMDes Desa Pematang Duku Timur',
                'latitude' => -0.5000000,
                'longitude' => 101.0000000,
                'address' => 'Jl. Raya No. 123, Desa Pematang Duku Timur',
                'bank_name' => 'Bank Syariah Indonesia',
                'bank_account_number' => '12345678989',
                'bank_account_holder' => 'BUMDes Desa Pematang Duku Timur',
                'payment_methods' => ['transfer', 'tunai'],
                'whatsapp_number' => '+6281234567890',
                'office_address' => 'Jl. Kantor BUMDes, Desa Pematang Duku Timur',
                'operating_hours' => 'Senin - Sabtu, 08:00 - 17:00',
            ]);
        }

        return view('admin.system_settings.index', compact('setting'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'location_name' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'address' => 'nullable|string',
            'bank_name' => 'nullable|string|max:255',
            'bank_account_number' => 'nullable|string|max:255',
            'bank_account_holder' => 'nullable|string|max:255',
            'payment_methods' => 'nullable|array',
            'card_background_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'whatsapp_number' => 'nullable|string|max:20',
            'office_address' => 'nullable|string',
            'operating_hours' => 'nullable|string|max:255',
        ]);

        $setting = SystemSetting::first();

        $paymentMethods = $request->input('payment_methods', []);
        $paymentMethods['tunai_to'] = $request->input('tunai_to');
        $paymentMethods['card_style'] = $request->input('card_style');

        // Handle card background image upload
        $cardBackgroundImage = $setting->card_background_image;
        if ($request->hasFile('card_background_image')) {
            // Delete old image if exists
            if ($cardBackgroundImage && \Storage::disk('public')->exists($cardBackgroundImage)) {
                \Storage::disk('public')->delete($cardBackgroundImage);
            }
            
            // Store new image
            $cardBackgroundImage = $request->file('card_background_image')->store('card_backgrounds', 'public');
        }

        $setting->update([
            'location_name' => $request->input('location_name'),
            'latitude' => $request->input('latitude'),
            'longitude' => $request->input('longitude'),
            'address' => $request->input('address'),
            'bank_name' => $request->input('bank_name'),
            'bank_account_number' => $request->input('bank_account_number'),
            'bank_account_holder' => $request->input('bank_account_holder'),
            'payment_methods' => $paymentMethods,
            'card_background_image' => $cardBackgroundImage,
            'whatsapp_number' => $request->input('whatsapp_number'),
            'office_address' => $request->input('office_address'),
            'operating_hours' => $request->input('operating_hours'),
        ]);

        return redirect()->back()->with('success', 'Pengaturan sistem berhasil disimpan.');
    }

    public function reset()
    {
        $setting = SystemSetting::first();
        if ($setting) {
            // Delete card background image if exists
            if ($setting->card_background_image && \Storage::disk('public')->exists($setting->card_background_image)) {
                \Storage::disk('public')->delete($setting->card_background_image);
            }
            $setting->delete();
        }

        return redirect()->route('admin.system-settings.index')->with('success', 'Pengaturan sistem berhasil direset.');
    }
}