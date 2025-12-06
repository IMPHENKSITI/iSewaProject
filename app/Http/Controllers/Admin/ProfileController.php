<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        // Get the authenticated admin user
        $user = Auth::user();
        
        // Pass real admin data to view
        return view('admin.profile.index', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'gender' => 'nullable|in:laki-laki,perempuan',
            'position' => 'nullable|string|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            // Delete old avatar if exists
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }
            
            // Store new avatar
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $avatarPath;
        }

        // Update user data
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'gender' => $request->gender,
            'position' => $request->position,
        ]);

        return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
    }

    public function changePassword(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        // Verify current password
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json(['success' => false, 'message' => 'Kata sandi lama tidak sesuai.']);
        }

        // Generate OTP
        $otp = rand(100000, 999999);
        session(['otp_code' => $otp]);
        session(['otp_expires_at' => now()->addMinutes(5)]);
        session(['new_password' => $request->new_password]);

        // In production, send OTP via email
        // Mail::to($user->email)->send(new OtpMail($otp));

        return response()->json(['success' => true, 'message' => 'OTP telah dikirim.']);
    }

    public function verifyOtp(Request $request)
    {
        $user = Auth::user();
        
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

        // Update password
        $user->password = Hash::make(session('new_password'));
        $user->save();

        // Clear session
        session()->forget(['otp_code', 'otp_expires_at', 'new_password']);

        return response()->json(['success' => true, 'message' => 'Kata sandi berhasil diperbarui.']);
    }

    public function resendOtp()
    {
        // Simulasikan kirim ulang OTP
        return response()->json(['success' => true, 'message' => 'Kode OTP telah dikirim ulang.']);
    }

    public function deleteAvatar()
    {
        $user = Auth::user();
        
        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }
        
        $user->avatar = null;
        $user->save();
        
        return response()->json(['success' => true, 'message' => 'Avatar berhasil dihapus.']);
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