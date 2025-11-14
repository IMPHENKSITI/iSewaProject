<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\Unit\PenyewaanAlatController;
use App\Http\Controllers\Admin\Unit\PenjualanGasController;
use App\Http\Controllers\Admin\Unit\PertanianPerkebunanController;
use App\Http\Controllers\Admin\Unit\SimpanPinjamController;
use App\Http\Controllers\Admin\Aktivitas\PermintaanController;
use App\Http\Controllers\Admin\Aktivitas\TransaksiController;
use App\Http\Controllers\Admin\Aktivitas\KemitraanController;
use App\Http\Controllers\Admin\Laporan\LaporanController;
use App\Http\Controllers\Admin\BumdesProfileController;
use App\Http\Controllers\Admin\SettingController; // Gunakan SettingController yang baru untuk halaman setting utama
use App\Http\Controllers\Admin\UnitPenyewaanController;

// Welcome Page
Route::get('/', function () {
    return view('welcome');
});

// ============================================
// AUTH ROUTES (Tanpa Middleware)
// ============================================
Route::get('/admin/login', [AuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'login'])->name('admin.login.post');
Route::get('/admin/register', [AuthController::class, 'showRegisterForm'])->name('admin.register');
Route::post('/admin/register', [AuthController::class, 'register'])->name('admin.register.post');
Route::get('/admin/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('admin.forgot-password');
Route::post('/admin/forgot-password', [AuthController::class, 'forgotPassword'])->name('admin.forgot-password.post');
Route::get('/admin/reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('admin.reset-password');
Route::post('/admin/reset-password', [AuthController::class, 'resetPassword'])->name('admin.reset-password.post');
Route::post('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');

// ============================================
// DASHBOARD ROUTES (Tanpa Middleware)
// ============================================
Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

// ============================================
// PROFILE ROUTES
// ============================================
Route::get('/admin/profile', [DashboardController::class, 'profile'])->name('admin.profile');
Route::post('/admin/profile', [DashboardController::class, 'profileUpdate'])->name('admin.profile.update');

// ============================================
// SETTINGS ROUTES (Menggunakan SettingController yang baru)
// ============================================
// Route untuk halaman utama pengaturan, diganti untuk menggunakan controller baru
Route::get('/admin/settings', [SettingController::class, 'index'])->name('admin.settings');
Route::post('/admin/settings', [SettingController::class, 'update'])->name('admin.settings.update'); // Misalnya untuk update pengaturan umum

// ============================================
// USERS MANAGEMENT ROUTES
// ============================================
Route::get('/admin/users', [DashboardController::class, 'usersList'])->name('admin.users.index');
Route::get('/admin/users/create', [DashboardController::class, 'usersCreate'])->name('admin.users.create');
Route::post('/admin/users', [DashboardController::class, 'usersStore'])->name('admin.users.store');
Route::get('/admin/users/{id}/edit', [DashboardController::class, 'usersEdit'])->name('admin.users.edit');
Route::put('/admin/users/{id}', [DashboardController::class, 'usersUpdate'])->name('admin.users.update');
Route::delete('/admin/users/{id}', [DashboardController::class, 'usersDestroy'])->name('admin.users.destroy');

// ============================================
// CONNECTIONS & NOTIFICATIONS ROUTES
// ============================================
Route::get('/admin/settings/connections', [DashboardController::class, 'connections'])->name('admin.settings.connections');
Route::get('/admin/settings/notifications', [DashboardController::class, 'notifications'])->name('admin.settings.notifications');
Route::post('/admin/settings/notifications', [DashboardController::class, 'notificationsUpdate'])->name('admin.settings.notifications.update');

// ============================================
// MAINTENANCE ROUTE
// ============================================
Route::get('/maintenance', [DashboardController::class, 'maintenance'])->name('maintenance');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ============================================
// ROUTES BARU SESUAI STRUKTUR MENU UNTUK SIDEBAR INDEX.BLADE.PHP
// ============================================

// Rute untuk Notifikasi (diperlukan oleh sidebar index.blade.php)
Route::get('/admin/notifications', [DashboardController::class, 'notifications'])->name('admin.notifications.index');

// Grup Rute untuk Unit Layanan (diperlukan oleh sidebar index.blade.php)
Route::prefix('admin/unit')->group(function () {
    Route::get('/penyewaan', [DashboardController::class, 'index'])->name('admin.unit.penyewaan.index');
    Route::get('/gas', [DashboardController::class, 'index'])->name('admin.unit.gas.index');
    Route::get('/pertanian', [DashboardController::class, 'index'])->name('admin.unit.pertanian.index');
    Route::get('/simpanpinjam', [DashboardController::class, 'index'])->name('admin.unit.simpanpinjam.index');
});

// Grup Rute untuk Aktivitas (diperlukan oleh sidebar index.blade.php)
Route::prefix('admin/aktivitas')->group(function () {
    Route::get('/permintaan', [DashboardController::class, 'index'])->name('admin.aktivitas.permintaan.index');
    Route::get('/transaksi', [DashboardController::class, 'index'])->name('admin.aktivitas.transaksi.index');
    Route::get('/kemitraan', [DashboardController::class, 'index'])->name('admin.aktivitas.kemitraan.index');
});

// Grup Rute untuk Data & Laporan (diperlukan oleh sidebar index.blade.php)
Route::prefix('admin/laporan')->group(function () {
    Route::get('/transaksi', [DashboardController::class, 'index'])->name('admin.laporan.transaksi');
    Route::get('/panen', [DashboardController::class, 'index'])->name('admin.laporan.panen');
    Route::get('/pendapatan', [DashboardController::class, 'index'])->name('admin.laporan.pendapatan');
    Route::get('/log', [DashboardController::class, 'index'])->name('admin.laporan.log');
});

Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    // ... route lainnya ...

    // Unit Penyewaan Alat - Tambahkan ini jika belum ada
    Route::prefix('unit')->name('unit.')->group(function () {
        Route::prefix('penyewaan')->name('penyewaan.')->group(function () {
            Route::get('/', [UnitPenyewaanController::class, 'index'])->name('index'); // <-- Ini penting
            Route::get('/create', [UnitPenyewaanController::class, 'create'])->name('create');
            Route::post('/', [UnitPenyewaanController::class, 'store'])->name('store');
            Route::get('/{id}', [UnitPenyewaanController::class, 'show'])->name('show');
            Route::get('/{id}/edit', [UnitPenyewaanController::class, 'edit'])->name('edit');
            Route::put('/{id}', [UnitPenyewaanController::class, 'update'])->name('update');
            Route::delete('/{id}', [UnitPenyewaanController::class, 'destroy'])->name('destroy');
        });
    });

    // ... route lainnya ...
});


// Rute untuk Manajemen Pengguna (diperlukan oleh sidebar index.blade.php)
// Sudah ada: Route::get('/admin/users', [DashboardController::class, 'usersList'])->name('admin.users.index');

// Rute untuk Profil BUMDes (diperlukan oleh sidebar index.blade.php)
Route::get('/admin/bumdes/profile', [DashboardController::class, 'profile'])->name('admin.bumdes.profile');
// Rute untuk Profil iSewa (baru)
Route::get('/admin/isewa/profile', [DashboardController::class, 'index'])->name('admin.isewa.profile');

// Rute untuk Pengaturan (Selain akun) - Jika Anda ingin tautan ke pengaturan global di sidebar
// Sudah ada: Route::get('/admin/settings', [SettingController::class, 'index'])->name('admin.settings');
// ✅ INI YANG BARU — tambahkan DI BAWAHnya
Route::get('/admin/isewa/profile', [DashboardController::class, 'index'])->name('admin.isewa.profile');

// Rute untuk Pengaturan (Selain akun) - Jika Anda ingin tautan ke pengaturan global di sidebar
// Sudah ada: Route::get('/admin/settings', [SettingController::class, 'index'])->name('admin.settings');
