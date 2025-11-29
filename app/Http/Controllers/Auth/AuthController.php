<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        try {
            $validated = $request->validate([
                'username' => 'required|string|max:255|unique:users,username',
                'email' => 'required|email|unique:users,email',
                'name' => 'required|string|max:255',
                'phone' => 'required|string|max:20',
                'address' => 'required|string',
                'gender' => 'required|in:laki-laki,perempuan',
                'password' => 'required|string|min:8|confirmed',
            ], [
                'username.unique' => 'Username sudah digunakan',
                'email.unique' => 'Email sudah terdaftar',
                'password.min' => 'Password minimal 8 karakter',
                'password.confirmed' => 'Konfirmasi password tidak cocok',
            ]);

            $otpCode = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
            $tempUserId = 'temp_' . time() . '_' . rand(1000, 9999);
            
            session([
                'temp_registration' => [
                    'temp_id' => $tempUserId,
                    'username' => $validated['username'],
                    'email' => $validated['email'],
                    'name' => $validated['name'],
                    'phone' => $validated['phone'],
                    'address' => $validated['address'],
                    'gender' => $validated['gender'],
                    'password' => Hash::make($validated['password']),
                    'otp_code' => $otpCode,
                    'otp_expires_at' => now()->addMinutes(5),
                ]
            ]);

            Log::info("OTP untuk {$validated['email']}: {$otpCode}");

            return response()->json([
                'success' => true,
                'message' => 'Kode OTP telah dikirim',
                'data' => [
                    'temp_user_id' => $tempUserId,
                    'email' => $validated['email'],
                    'otp' => $otpCode,
                ]
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Registration error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan'
            ], 500);
        }
    }

    public function verifyOtp(Request $request)
    {
        try {
            $validated = $request->validate([
                'temp_user_id' => 'required|string',
                'otp' => 'required|digits:4',
            ]);

            $tempData = session('temp_registration');

            if (!$tempData || $tempData['temp_id'] !== $validated['temp_user_id']) {
                return response()->json([
                    'success' => false,
                    'message' => 'Session tidak valid'
                ], 400);
            }

            if (now()->greaterThan($tempData['otp_expires_at'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kode OTP sudah kadaluarsa'
                ], 400);
            }

            if ($tempData['otp_code'] !== $validated['otp']) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kode OTP tidak valid'
                ], 400);
            }

            $user = User::create([
                'username' => $tempData['username'],
                'email' => $tempData['email'],
                'name' => $tempData['name'],
                'phone' => $tempData['phone'],
                'address' => $tempData['address'],
                'gender' => $tempData['gender'],
                'password' => $tempData['password'],
                'role' => 'user',
                'status' => 'aktif',
                'email_verified_at' => now(),
            ]);

            session()->forget('temp_registration');
            Auth::login($user);

            return response()->json([
                'success' => true,
                'message' => 'Registrasi berhasil!',
                'redirect' => route('beranda')
            ], 200);

        } catch (\Exception $e) {
            Log::error('OTP verification error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan'
            ], 500);
        }
    }

    public function resendOtp(Request $request)
    {
        try {
            $validated = $request->validate([
                'temp_user_id' => 'required|string',
            ]);

            $tempData = session('temp_registration');

            if (!$tempData || $tempData['temp_id'] !== $validated['temp_user_id']) {
                return response()->json([
                    'success' => false,
                    'message' => 'Session tidak valid'
                ], 400);
            }

            $newOtpCode = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
            $tempData['otp_code'] = $newOtpCode;
            $tempData['otp_expires_at'] = now()->addMinutes(5);
            session(['temp_registration' => $tempData]);

            Log::info("OTP baru untuk {$tempData['email']}: {$newOtpCode}");

            return response()->json([
                'success' => true,
                'message' => 'Kode OTP baru telah dikirim',
                'data' => [
                    'otp' => $newOtpCode,
                ]
            ], 200);

        } catch (\Exception $e) {
            Log::error('Resend OTP error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengirim ulang OTP'
            ], 500);
        }
    }

    public function login(Request $request)
    {
        try {
            $validated = $request->validate([
                'email_or_phone' => 'required|string',
                'password' => 'required|string',
                'remember' => 'nullable|boolean',
            ]);

            $loginField = $validated['email_or_phone'];
            $fieldType = filter_var($loginField, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';
            $user = User::where($fieldType, $loginField)->first();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Email/nomor telepon tidak ditemukan'
                ], 401);
            }

            if ($user->status !== 'aktif') {
                return response()->json([
                    'success' => false,
                    'message' => 'Akun belum aktif'
                ], 403);
            }

            if (!Hash::check($validated['password'], $user->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Password salah'
                ], 401);
            }

            Auth::login($user, $validated['remember'] ?? false);

            $redirectUrl = $user->role === 'admin' ? route('admin.dashboard') : route('beranda');

            return response()->json([
                'success' => true,
                'message' => 'Login berhasil',
                'redirect' => $redirectUrl,
            ], 200);

        } catch (\Exception $e) {
            Log::error('Login error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan'
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json([
            'success' => true,
            'redirect' => route('beranda')
        ]);
    }

    public function forgotPassword(Request $request)
    {
        return response()->json([
            'success' => false,
            'message' => 'Fitur akan tersedia di update berikutnya'
        ], 501);
    }

    public function resetPassword(Request $request)
    {
        return response()->json([
            'success' => false,
            'message' => 'Fitur akan tersedia di update berikutnya'
        ], 501);
    }
}