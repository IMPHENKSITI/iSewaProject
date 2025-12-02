<?php

use Illuminate\Support\Facades\Route;

// ===============================
// IMPORT CONTROLLERS
// ===============================
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\UnitPenyewaanController;
use App\Http\Controllers\Admin\GasController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\SystemSettingController;
use App\Http\Controllers\Admin\ProfileController; // Sudah di-import di sini

// Welcome Page
Route::get('/', function () {
    return redirect('beranda');
});
Route::get('/beranda', function () {
    return view('beranda.index');
})->name('beranda');

// User Pages
Route::get('/pelayanan', function () {
    return view('users.pelayanan');
})->name('pelayanan');

// BUMDes Routes
Route::get('/bumdes/profil-layanan', function () {
    return view('users.bumdes-profil');
})->name('bumdes.profil');

Route::get('/bumdes/laporan', function () {
    return view('users.bumdes-laporan');
})->name('bumdes.laporan');

// ============================================
// USER AUTH ROUTES 
// ============================================
Route::post('/auth/register', [AuthController::class, 'register'])->name('auth.register');
Route::post('/auth/verify-otp', [AuthController::class, 'verifyOtp'])->name('auth.verify-otp');
Route::post('/auth/resend-otp', [AuthController::class, 'resendOtp'])->name('auth.resend-otp');
Route::post('/auth/login', [AuthController::class, 'login'])->name('auth.login');
Route::post('/auth/logout', [AuthController::class, 'logout'])->name('auth.logout');
Route::post('/auth/forgot-password', [AuthController::class, 'forgotPassword'])->name('auth.forgot-password');
Route::post('/auth/reset-password', [AuthController::class, 'resetPassword'])->name('auth.reset-password');

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
// PROFILE ROUTES (Hanya untuk akses login via DashboardController)
// ============================================
// Hapus atau komentari baris-baris ini karena kita akan gunakan ProfileController
// Route::get('/admin/profile', [DashboardController::class, 'profile'])->name('admin.profile');
// Route::post('/admin/profile', [DashboardController::class, 'profileUpdate'])->name('admin.profile.update');

// ============================================
// SETTINGS ROUTES (Menggunakan SettingController yang baru)
// ============================================
Route::get('/admin/settings', [SettingController::class, 'index'])->name('admin.settings');
Route::post('/admin/settings', [SettingController::class, 'update'])->name('admin.settings.update');

// ============================================
// CONNECTIONS & NOTIFICATIONS ROUTES (Hanya untuk akses login via DashboardController)
// ============================================
Route::get('/admin/settings/connections', [DashboardController::class, 'connections'])->name('admin.settings.connections');
Route::get('/admin/settings/notifications', [DashboardController::class, 'notifications'])->name('admin.settings.notifications');
Route::post('/admin/settings/notifications', [DashboardController::class, 'notificationsUpdate'])->name('admin.settings.notifications.update');

// ============================================
// MAINTENANCE ROUTE
// ============================================
Route::get('/maintenance', [DashboardController::class, 'maintenance'])->name('maintenance');
// Hapus atau komentari baris ini karena logout sudah ada di AuthController
// Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ============================================
// ROUTES SESUAI STRUKTUR MENU UNTUK SIDEBAR
// ============================================

// Grup Rute untuk Unit Layanan
Route::prefix('admin/unit')->group(function () {
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

    Route::resource('gas', GasController::class)->parameters(['gas' => 'gas'])->names([
        'index' => 'admin.unit.penjualan_gas.index',
        'create' => 'admin.unit.penjualan_gas.create',
        'store' => 'admin.unit.penjualan_gas.store',
        'show' => 'admin.unit.penjualan_gas.show',
        'edit' => 'admin.unit.penjualan_gas.edit',
        'update' => 'admin.unit.penjualan_gas.update',
        'destroy' => 'admin.unit.penjualan_gas.destroy',
    ]);
});

// Grup Rute untuk Aktivitas
Route::prefix('admin/aktivitas')->group(function () {
    Route::get('/kajian', [DashboardController::class, 'index'])->name('admin.aktivitas.kajian.index');
    Route::get('/transaksi', [DashboardController::class, 'index'])->name('admin.aktivitas.transaksi.index');
    Route::get('/kemitraan', [DashboardController::class, 'index'])->name('admin.aktivitas.kemitraan.index');

    Route::get('/permintaan-pengajuan', [\App\Http\Controllers\Admin\RequestController::class, 'index'])->name('admin.aktivitas.permintaan-pengajuan.index');
    Route::get('/permintaan-pengajuan/{id}/{type}', [\App\Http\Controllers\Admin\RequestController::class, 'show'])->name('admin.aktivitas.permintaan-pengajuan.show');
    Route::post('/permintaan-pengajuan/{id}/{type}/approve', [\App\Http\Controllers\Admin\RequestController::class, 'approve'])->name('admin.aktivitas.permintaan-pengajuan.approve');
    Route::post('/permintaan-pengajuan/{id}/{type}/reject', [\App\Http\Controllers\Admin\RequestController::class, 'reject'])->name('admin.aktivitas.permintaan-pengajuan.reject');

    Route::get('/bukti-transaksi', [\App\Http\Controllers\Admin\TransactionController::class, 'index'])->name('admin.aktivitas.bukti-transaksi.index');
    Route::get('/bukti-transaksi/{id}/{type}', [\App\Http\Controllers\Admin\TransactionController::class, 'show'])->name('admin.aktivitas.bukti-transaksi.show');
    Route::post('/bukti-transaksi/{id}/{type}/verify', [\App\Http\Controllers\Admin\TransactionController::class, 'verify'])->name('admin.aktivitas.bukti-transaksi.verify');
    Route::post('/bukti-transaksi/{id}/{type}/reject', [\App\Http\Controllers\Admin\TransactionController::class, 'reject'])->name('admin.aktivitas.bukti-transaksi.reject');
    Route::get('/bukti-transaksi/{id}/{type}/download', [\App\Http\Controllers\Admin\TransactionController::class, 'downloadProof'])->name('admin.aktivitas.bukti-transaksi.download');
});

// Grup Rute untuk Data & Laporan
Route::prefix('admin/laporan')->group(function () {
    Route::get('/transaksi', [\App\Http\Controllers\Admin\ReportController::class, 'transactions'])->name('admin.laporan.transaksi');
    Route::get('/pendapatan', [\App\Http\Controllers\Admin\ReportController::class, 'income'])->name('admin.laporan.pendapatan');
    Route::get('/log', [\App\Http\Controllers\Admin\ReportController::class, 'logs'])->name('admin.laporan.log');
    
    // Manual Transaction Routes
    Route::post('/manual-transaction', [\App\Http\Controllers\Admin\ReportController::class, 'storeManualTransaction'])->name('admin.laporan.manual.store');
    Route::put('/manual-transaction/{id}', [\App\Http\Controllers\Admin\ReportController::class, 'updateManualTransaction'])->name('admin.laporan.manual.update');
    Route::delete('/manual-transaction/{id}', [\App\Http\Controllers\Admin\ReportController::class, 'destroyManualTransaction'])->name('admin.laporan.manual.destroy');
});

// Rute untuk Profil iSewa
Route::get('/admin/isewa/profile', [\App\Http\Controllers\Admin\SettingController::class, 'showIsewaProfile'])->name('admin.isewa.profile');
Route::get('/admin/isewa/developer/{name}', [\App\Http\Controllers\Admin\SettingController::class, 'showDeveloperProfile'])->name('admin.isewa.developer.profile');

// Profil & Manajemen BUMDes
Route::get('/admin/isewa/profil-bumdes', [\App\Http\Controllers\Admin\BumdesController::class, 'index'])->name('admin.isewa.profile-bumdes');
Route::prefix('admin/isewa/bumdes')->group(function () {
    Route::get('/', [\App\Http\Controllers\Admin\BumdesController::class, 'index'])->name('admin.isewa.bumdes.index');
    Route::get('/create', [\App\Http\Controllers\Admin\BumdesController::class, 'create'])->name('admin.isewa.bumdes.create');
    Route::post('/', [\App\Http\Controllers\Admin\BumdesController::class, 'store'])->name('admin.isewa.bumdes.store');
    Route::get('/{id}/edit', [\App\Http\Controllers\Admin\BumdesController::class, 'edit'])->name('admin.isewa.bumdes.edit');
    Route::put('/{id}', [\App\Http\Controllers\Admin\BumdesController::class, 'update'])->name('admin.isewa.bumdes.update');
    Route::delete('/{id}', [\App\Http\Controllers\Admin\BumdesController::class, 'destroy'])->name('admin.isewa.bumdes.destroy');
});
Route::post('/admin/isewa/bumdes/update-whatsapp', [\App\Http\Controllers\Admin\BumdesController::class, 'updateWhatsapp'])->name('admin.isewa.bumdes.update.whatsapp');

// ============================================
// 🔹 GABUNGKAN SEMUA ROUTE ADMIN YANG DIPROTEKSI DI SINI
// ============================================
Route::prefix('admin')->group(function () {
    // Route untuk Profil Admin (menggunakan ProfileController)
    Route::get('/profile', [ProfileController::class, 'index'])->name('admin.profile'); // <-- Gunakan nama ini
    Route::put('/profile', [ProfileController::class, 'update'])->name('admin.profile.update');
    Route::post('/profile/change-password', [ProfileController::class, 'changePassword'])->name('admin.profile.change-password');
    Route::post('/profile/verify-otp', [ProfileController::class, 'verifyOtp'])->name('admin.profile.verify-otp');
    Route::post('/admin/profile/resend-otp', [App\Http\Controllers\Admin\ProfileController::class, 'resendOtp'])->name('admin.profile.resend-otp');
    // Route::get('/profile/otp-verification', [ProfileController::class, 'showOtpVerification'])->name('admin.profile.otp-verification');
    // Route::get('/profile/success', [ProfileController::class, 'showSuccess'])->name('admin.profile.success');
    // Route::post('/logout', [ProfileController::class, 'logout'])->name('admin.logout'); // Gunakan route logout dari AuthController

    // Route untuk Manajemen Pengguna
    Route::get('/manajemen-pengguna', [UserManagementController::class, 'index'])->name('admin.manajemen-pengguna.index');
    Route::get('/manajemen-pengguna/{user}', [UserManagementController::class, 'show'])->name('admin.manajemen-pengguna.show');
    Route::put('/manajemen-pengguna/{user}/toggle-status', [UserManagementController::class, 'toggleStatus'])->name('admin.manajemen-pengguna.toggle-status');

    // Route untuk Notifikasi
    Route::get('/notifications', [NotificationController::class, 'index'])->name('admin.notifications.index');
    Route::get('/notifications/create', [NotificationController::class, 'create'])->name('admin.notifications.create');
    Route::post('/notifications', [NotificationController::class, 'store'])->name('admin.notifications.store');
    Route::put('/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])->name('admin.notifications.mark-as-read');
    Route::put('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('admin.notifications.mark-all-read');

    // Route untuk Pengaturan Sistem
    Route::get('/pengaturan-sistem', [SystemSettingController::class, 'index'])->name('admin.system-settings.index');
    Route::put('/pengaturan-sistem', [SystemSettingController::class, 'update'])->name('admin.system-settings.update');
    Route::delete('/pengaturan-sistem/reset', [SystemSettingController::class, 'reset'])->name('admin.system-settings.reset');
});