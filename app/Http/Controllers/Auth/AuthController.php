<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * Handle user registration
     */
    public function register(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255|unique:users,username',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'gender' => 'required|in:laki-laki,perempuan',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'username.required' => 'Username harus diisi',
            'username.unique' => 'Username sudah digunakan',
            'name.required' => 'Nama lengkap harus diisi',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'phone.required' => 'No telepon harus diisi',
            'address.required' => 'Alamat harus diisi',
            'gender.required' => 'Jenis kelamin harus dipilih',
            'password.required' => 'Password harus diisi',
            'password.min' => 'Password minimal 8 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Generate OTP 4 digit
            $otpCode = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);

            // Buat user baru
            $user = User::create([
                'username' => $request->username,
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'gender' => $request->gender,
                'password' => Hash::make($request->password),
                'role' => 'user',
                'status' => 'non_aktif', // Status non-aktif sampai verifikasi OTP
                'otp_code' => $otpCode,
                'otp_expires_at' => now()->addMinutes(5), // OTP berlaku 5 menit
            ]);

            // TODO: Kirim OTP ke email/SMS user
            // Untuk development, kita log OTP
            \Log::info("OTP untuk {$user->email}: {$otpCode}");

            return response()->json([
                'success' => true,
                'message' => 'Registrasi berhasil! Silakan verifikasi dengan kode OTP yang dikirim ke email Anda.',
                'data' => [
                    'user_id' => $user->id,
                    'email' => $user->email,
                    'otp' => $otpCode, // HANYA UNTUK DEVELOPMENT - HAPUS DI PRODUCTION
                ]
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat registrasi',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Verify OTP after registration
     */
    public function verifyOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'otp' => 'required|string|size:4',
        ], [
            'user_id.required' => 'User ID tidak ditemukan',
            'user_id.exists' => 'User tidak valid',
            'otp.required' => 'Kode OTP harus diisi',
            'otp.size' => 'Kode OTP harus 4 digit',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $user = User::find($request->user_id);

            // Cek apakah OTP sudah kadaluarsa
            if (now()->greaterThan($user->otp_expires_at)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kode OTP telah kedaluwarsa'
                ], 400);
            }

            // Cek apakah OTP benar
            if ($user->otp_code !== $request->otp) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kode OTP tidak valid'
                ], 400);
            }

            // Aktifkan user dan hapus OTP
            $user->update([
                'status' => 'aktif',
                'email_verified_at' => now(),
                'otp_code' => null,
                'otp_expires_at' => null,
            ]);

            // Auto login setelah verifikasi
            Auth::login($user);

            return response()->json([
                'success' => true,
                'message' => 'Akun berhasil diverifikasi!',
                'redirect' => route('beranda')
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat verifikasi OTP',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Resend OTP
     */
    public function resendOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $user = User::find($request->user_id);

            // Generate OTP baru
            $otpCode = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);

            $user->update([
                'otp_code' => $otpCode,
                'otp_expires_at' => now()->addMinutes(5),
            ]);

            // TODO: Kirim OTP ke email/SMS
            \Log::info("OTP baru untuk {$user->email}: {$otpCode}");

            return response()->json([
                'success' => true,
                'message' => 'Kode OTP baru telah dikirim',
                'data' => [
                    'otp' => $otpCode, // HANYA UNTUK DEVELOPMENT
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengirim ulang OTP',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Handle user login
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email_or_phone' => 'required|string',
            'password' => 'required|string',
        ], [
            'email_or_phone.required' => 'Email atau No Telepon harus diisi',
            'password.required' => 'Password harus diisi',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $loginField = $request->email_or_phone;
            $fieldType = filter_var($loginField, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';

            // Cari user berdasarkan email atau phone
            $user = User::where($fieldType, $loginField)->first();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Email/No Telepon tidak terdaftar'
                ], 401);
            }

            // Cek status akun
            if ($user->status === 'non_aktif') {
                return response()->json([
                    'success' => false,
                    'message' => 'Akun Anda belum diverifikasi atau telah dinonaktifkan'
                ], 403);
            }

            // Cek password
            if (!Hash::check($request->password, $user->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Password salah'
                ], 401);
            }

            // Login user
            Auth::login($user, $request->filled('remember'));

            // Redirect berdasarkan role
            $redirectUrl = $user->role === 'admin' 
                ? route('admin.dashboard') 
                : route('beranda');

            return response()->json([
                'success' => true,
                'message' => 'Login berhasil!',
                'data' => [
                    'user' => [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'role' => $user->role,
                    ]
                ],
                'redirect' => $redirectUrl
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat login',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Handle logout
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Logout berhasil',
                'redirect' => route('beranda')
            ], 200);
        }

        return redirect()->route('beranda');
    }

    /**
     * Forgot password - send OTP
     */
    public function forgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ], [
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'email.exists' => 'Email tidak terdaftar',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $user = User::where('email', $request->email)->first();

            // Generate OTP
            $otpCode = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);

            $user->update([
                'otp_code' => $otpCode,
                'otp_expires_at' => now()->addMinutes(5),
            ]);

            // TODO: Kirim OTP ke email
            \Log::info("OTP reset password untuk {$user->email}: {$otpCode}");

            return response()->json([
                'success' => true,
                'message' => 'Kode OTP telah dikirim ke email Anda',
                'data' => [
                    'user_id' => $user->id,
                    'email' => $user->email,
                    'otp' => $otpCode, // DEVELOPMENT ONLY
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Reset password with OTP
     */
    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'otp' => 'required|string|size:4',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $user = User::find($request->user_id);

            // Cek OTP
            if (now()->greaterThan($user->otp_expires_at)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kode OTP telah kedaluwarsa'
                ], 400);
            }

            if ($user->otp_code !== $request->otp) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kode OTP tidak valid'
                ], 400);
            }

            // Update password
            $user->update([
                'password' => Hash::make($request->password),
                'otp_code' => null,
                'otp_expires_at' => null,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Password berhasil direset!',
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}