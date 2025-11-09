<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AuthController;

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
// SETTINGS ROUTES
// ============================================
Route::get('/admin/settings', [DashboardController::class, 'settings'])->name('admin.settings');
Route::post('/admin/settings', [DashboardController::class, 'settingsUpdate'])->name('admin.settings.update');

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