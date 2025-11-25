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
use App\Http\Controllers\Admin\GasController; // ✅ Tambahkan ini

// Welcome Page
Route::get('/', function () {
    return redirect('beranda');
});
Route::get('/beranda', function () {
    return view('beranda.index');
})->name('beranda');
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
    // ✅ Route untuk Penyewaan Alat (Tetap seperti sebelumnya)
    Route::get('/penyewaan', [UnitPenyewaanController::class, 'index'])->name('admin.unit.penyewaan.index');
    Route::resource('penyewaan', UnitPenyewaanController::class)->names([
        'index' => 'admin.unit.penyewaan.index',
        'create' => 'admin.unit.penyewaan.create',
        'store' => 'admin.unit.penyewaan.store',
        'show' => 'admin.unit.penyewaan.show',
        'edit' => 'admin.unit.penyewaan.edit',
        'update' => 'admin.unit.penyewaan.update',
        'destroy' => 'admin.unit.penyewaan.destroy',
    ]);

    // ✅ Route untuk Penjualan Gas (Baru ditambahkan)
    Route::get('/gas', [GasController::class, 'index'])->name('admin.unit.penjualan_gas.index');
    Route::resource('gas', GasController::class)
    ->parameters(['gas' => 'id']) // ✅ Ubah parameter dari `ga` menjadi `id`
    ->names([
        'edit' => 'admin.unit.penjualan_gas.edit',
        'index' => 'admin.unit.penjualan_gas.index',
        'create' => 'admin.unit.penjualan_gas.create',
        'store' => 'admin.unit.penjualan_gas.store',
        'show' => 'admin.unit.penjualan_gas.show',
        'update' => 'admin.unit.penjualan_gas.update',
        'destroy' => 'admin.unit.penjualan_gas.destroy',
    ]);

    // ✅ Route untuk Tanikebun & Simpanpinjam (Tetap seperti sebelumnya)
    Route::get('/tanikebun', [DashboardController::class, 'index'])->name('admin.unit.tanikebun.index');
    Route::get('/simpanpinjam', [DashboardController::class, 'index'])->name('admin.unit.simpanpinjam.index');
});

// Grup Rute untuk Aktivitas (diperlukan oleh sidebar index.blade.php)
Route::prefix('admin/aktivitas')->group(function () {
    Route::get('/kajian', [DashboardController::class, 'index'])->name('admin.aktivitas.kajian.index');
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

// ✅ Ini adalah route lama untuk penyewaan, tidak dihapus, hanya dipindahkan ke grup unit
// Route::prefix('admin')->name('admin.')->group(function () { ... });

// Rute untuk Profil BUMDes (diperlukan oleh sidebar index.blade.php)
Route::get('/admin/bumdes/profile', [DashboardController::class, 'profile'])->name('admin.bumdes.profile');
// Rute untuk Profil iSewa (baru)
Route::get('/admin/isewa/profile', [DashboardController::class, 'index'])->name('admin.isewa.profile');

Route::get('/admin/isewa/profile', [DashboardController::class, 'index'])->name('admin.isewa.profile');