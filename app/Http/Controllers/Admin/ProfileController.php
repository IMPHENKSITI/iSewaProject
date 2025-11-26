<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        // Simulasikan data user, seolah-olah sudah login
        $user = (object)[
            'id' => 1,
            'username' => 'admin_user',
            'name' => 'Admin Nama',
            'email' => 'admin@example.com',
            'phone' => '081234567890',
            'address' => 'Jl. Admin No. 1',
            'gender' => 'laki-laki',
            'avatar' => null, // atau path jika ada
        ];

        return view('admin.profile.index', compact('user'));
    }

    public function update(Request $request)
    {
        // Simulasikan update data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'gender' => 'nullable|in:laki-laki,perempuan',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Simulasikan penyimpanan data
        // $user = User::find(1); // nanti saat sudah login, gunakan ini
        // $user->update([...]);

        return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        // Simulasikan verifikasi password lama (abaikan dulu)
        // if (!Hash::check($request->current_password, $user->password)) { ... }

        // Simulasikan generate OTP
        $otp = rand(100000, 999999);
        session(['otp_code' => $otp]);
        session(['otp_expires_at' => now()->addMinutes(5)]);
        session(['new_password' => $request->new_password]);

        // Simulasikan kirim email OTP (abaikan dulu)

        return response()->json(['success' => true, 'message' => 'OTP telah dikirim.']);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6',
        ]);

        $otp = session('otp_code');
        $expiresAt = session('otp_expires_at');

        if (!$otp || !$expiresAt || now()->gt($expiresAt)) {
            return response()->json(['success' => false, 'message' => 'Kode OTP telah kedaluwarsa.']);
        }

        if ($request->otp != $otp) {
            return response()->json(['success' => false, 'message' => 'Kode OTP tidak valid.']);
        }

        // Simulasikan update password
        // $user = User::find(1);
        // $user->password = Hash::make(session('new_password'));
        // $user->save();

        // Clear session
        session()->forget(['otp_code', 'otp_expires_at', 'new_password']);

        return response()->json(['success' => true, 'message' => 'Kata sandi berhasil diperbarui.']);
    }

    public function resendOtp()
    {
        // Simulasikan kirim ulang OTP
        return response()->json(['success' => true, 'message' => 'Kode OTP telah dikirim ulang.']);
    }

    public function logout(Request $request)
    {
        // Simulasikan logout
        // Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/'); // atau halaman login nanti
    }
}