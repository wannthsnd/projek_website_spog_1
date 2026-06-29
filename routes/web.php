<?php

use App\Http\Controllers\FormController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SuperAdminController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - PNBP Maritime SPOG System
| Fitur: Multi-UPT Architecture, View & Download Dokumen (2 Opsi),
|        Edit, SPOG PDF Generation, Registrasi User, Notifikasi,
|        Laporan Bulanan, Profil & Pengaturan, Lupa Password (Tanpa Email),
|        Super Admin Panel dengan Hak Akses Penuh
|--------------------------------------------------------------------------
*/

// ==================== PUBLIC ROUTES ====================

// Home redirect to dashboard
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Dashboard (Public) - Halaman utama yang bisa diakses semua user
Route::get('/dashboard', [FormController::class, 'dashboard'])->name('dashboard');

// Data Pemohon (Public) - Hanya lihat data, tidak bisa edit
Route::get('/data-pemohon', [FormController::class, 'dataPemohon'])->name('data.pemohon');

// Permohonan Baru (Public) - Form untuk membuat permohonan SPOG
Route::get('/tambah-data', [FormController::class, 'create'])->name('permohonan.create');
Route::post('/simpan-data', [FormController::class, 'store'])->name('permohonan.store');

// Detail Permohonan (Public) - Lihat detail permohonan berdasarkan ID
Route::get('/permohonan/{id}/detail', [FormController::class, 'detail'])->name('permohonan.detail');

// ✅ Download Dokumen Pendukung - 2 OPSI:
// - /permohonan/{id}/download/{document}/view → Preview inline di browser (tidak terunduh)
// - /permohonan/{id}/download/{document}/download → Force download file ke device (terunduh)
// - /permohonan/{id}/download/{document} → Default download (backward compatible)
Route::get('/permohonan/{id}/download/{document}/{action?}', [FormController::class, 'download'])->name('permohonan.download');

// ==================== AUTHENTICATION ROUTES ====================

// ✅ Registration dengan UPT Selector (Multi-UPT Architecture)
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

// User Login - Form dan proses login untuk user biasa
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/login-temporary', [AuthController::class, 'loginWithTemporaryPassword'])->name('login.temporary');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ✅ PASSWORD RESET ROUTES (Lupa Password - TANPA EMAIL)
// Flow: User request → Admin verify → Generate temp password → User check status → Login & change password
Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'submitResetRequest'])->name('password.submit');
Route::get('/reset-status', [AuthController::class, 'showResetStatus'])->name('password.status');
Route::post('/check-reset-status', [AuthController::class, 'checkResetStatus'])->name('password.check-status');

// ==================== PROTECTED USER ROUTES ====================
// Routes ini hanya bisa diakses oleh user yang sudah login (middleware: auth)

Route::middleware(['auth'])->group(function () {

    // Profile & Settings - Halaman profil dan pengaturan akun user
    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
    Route::put('/profile/update', [AuthController::class, 'updateProfile'])->name('profile.update');

    // ✅ PASSWORD ROUTES - GET untuk form, PUT untuk update
    Route::get('/profile/password', [AuthController::class, 'showPasswordForm'])->name('profile.password');
    Route::put('/profile/password', [AuthController::class, 'updatePassword'])->name('profile.password.update');

    // ✅ SETTINGS ROUTES - GET untuk form, PUT untuk update
    Route::get('/settings', [AuthController::class, 'settings'])->name('settings');
    Route::put('/settings/update', [AuthController::class, 'updateSettings'])->name('settings.update');

    // ✅ Edit Permohonan (User hanya bisa edit milik sendiri berdasarkan email)
    // ✅ DUAL ROUTE NAMES: Support both naming conventions for flexibility
    Route::get('/permohonan/{id}/edit', [FormController::class, 'editUser'])->name('permohonan.edit');
    Route::get('/permohonan/{id}/edit-user', [FormController::class, 'editUser'])->name('permohonan.edit.user');

    Route::put('/permohonan/{id}', [FormController::class, 'updateUser'])->name('permohonan.update');
    Route::put('/permohonan/{id}/update-user', [FormController::class, 'updateUser'])->name('permohonan.update.user');

    // ✅ Download SPOG PDF (User hanya bisa download milik sendiri & status harus approved)
    Route::get('/permohonan/{id}/download-spog', [FormController::class, 'downloadSPOGUser'])->name('permohonan.download.spog');

    // ✅ NOTIFICATION ROUTES (User) - Manajemen notifikasi untuk user
    Route::prefix('notifications')->name('notifications.')->group(function () {
        // List notifications - Tampilkan daftar notifikasi user
        Route::get('/', [NotificationController::class, 'index'])->name('index');

        // Mark single notification as read & redirect to action URL
        Route::get('/read/{id}', [NotificationController::class, 'markAsRead'])->name('read');

        // Mark all notifications as read - Tandai semua notifikasi sebagai sudah dibaca
        Route::post('/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('mark-all-read');

        // Delete single notification - Hapus satu notifikasi
        Route::delete('/{id}', [NotificationController::class, 'destroy'])->name('destroy');

        // Delete all notifications - Hapus semua notifikasi user
        Route::delete('/all', [NotificationController::class, 'destroyAll'])->name('destroy-all');
    });
});

// ==================== ADMIN PANEL ROUTES ====================

// Admin Login (Public) - Form dan proses login khusus admin
Route::get('/admin/login', [AdminController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'login'])->name('admin.login.post');

// Protected Admin Routes (Hanya untuk admin) - Middleware: auth + admin
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    // Admin Logout - Proses logout untuk admin
    Route::get('/logout', [AdminController::class, 'logout'])->name('logout');

    // Admin Dashboard - Halaman dashboard khusus admin dengan statistik (AUTO-SCOPED BY UPT)
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Admin Data Pemohon - List semua permohonan (AUTO-SCOPED BY UPT)
    Route::get('/data-pemohon', [AdminController::class, 'dataPemohon'])->name('data.pemohon');

    // ✅ Permits Management (CRUD Lengkap) - AUTO-SCOPED BY UPT
    Route::prefix('permits')->name('permits.')->group(function () {

        // Index & Show - List permits dan detail permit
        Route::get('/', [AdminController::class, 'index'])->name('index');
        Route::get('/{id}', [AdminController::class, 'show'])->name('show');

        // Edit & Update - Form edit dan proses update data permit oleh admin
        Route::get('/{id}/edit', [AdminController::class, 'edit'])->name('edit');
        Route::put('/{id}', [AdminController::class, 'update'])->name('update');

        // Delete - Hapus data permit secara permanen
        Route::delete('/{id}', [AdminController::class, 'destroy'])->name('destroy');

        // ✅ Download Dokumen Pendukung Admin - 2 OPSI:
        // - /admin/permits/{id}/download/{document}/view → Preview inline di browser
        // - /admin/permits/{id}/download/{document}/download → Force download file
        Route::get('/{id}/download/{document}/{action?}', [AdminController::class, 'download'])->name('download');

        // ✅ Download SPOG PDF Admin (hanya jika status approved)
        Route::get('/{id}/download-spog', [AdminController::class, 'downloadSPOG'])->name('download.spog');

        // Approve & Reject (dengan notifikasi otomatis ke user via database notifications)
        Route::post('/{id}/approve', [AdminController::class, 'approve'])->name('approve');
        Route::post('/{id}/reject', [AdminController::class, 'reject'])->name('reject');
    });

    // ✅ REPORT ROUTES - LAPORAN BULANAN (Admin Only - AUTO-SCOPED BY UPT)
    Route::prefix('reports')->name('reports.')->group(function () {
        // Monthly Report - Halaman laporan bulanan dengan filter & grafik
        Route::get('/monthly', [ReportController::class, 'index'])->name('monthly');

        // Export PDF - Download laporan bulanan dalam format PDF
        Route::get('/monthly/export/pdf', [ReportController::class, 'exportPdf'])->name('monthly.export.pdf');

        // Export Excel - Download laporan bulanan dalam format Excel
        Route::get('/monthly/export/excel', [ReportController::class, 'exportExcel'])->name('monthly.export.excel');
    });

    // ✅ PASSWORD RESET MANAGEMENT (Admin Only - AUTO-SCOPED BY UPT)
    Route::get('/password-reset-requests', [AdminController::class, 'passwordResetRequests'])->name('password-reset-requests');
    Route::post('/password-reset-requests/{id}/approve', [AdminController::class, 'approveResetRequest'])->name('password-reset-requests.approve');
    Route::post('/password-reset-requests/{id}/reject', [AdminController::class, 'rejectResetRequest'])->name('password-reset-requests.reject');

    // ✅ API ENDPOINT - Real-time badge count for notifications
    Route::get('/api/pending-reset-count', [AdminController::class, 'getPendingResetCount'])->name('api.pending-reset-count');

    // Admin Profile & Settings - Halaman profil dan pengaturan akun admin
    Route::get('/profile', [AdminController::class, 'profile'])->name('profile');
    Route::put('/profile/update', [AdminController::class, 'updateProfile'])->name('profile.update');
    Route::put('/profile/password', [AdminController::class, 'updatePassword'])->name('profile.password');

    // ✅ ADMIN SETTINGS ROUTES
    Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
    Route::put('/settings/update', [AdminController::class, 'updateSettings'])->name('settings.update');
});

// ==================== SUPER ADMIN PANEL ====================

// Super Admin Root Redirect
Route::get('/super-admin', function() {
    if (auth()->check() && auth()->user()->isSuperAdmin()) {
        return redirect()->route('super-admin.dashboard');
    }
    return redirect()->route('super-admin.login');
})->name('super-admin');

// Super Admin Login
Route::get('/super-admin/login', [SuperAdminController::class, 'showLoginForm'])->name('super-admin.login');
Route::post('/super-admin/login', [SuperAdminController::class, 'login'])->name('super-admin.login.post');

// ✅ SUPER ADMIN PROTECTED ROUTES - LENGKAP DENGAN ALIAS
Route::middleware(['auth', 'super_admin'])->prefix('super-admin')->name('super-admin.')->group(function () {

    // Dashboard & Logout
    Route::get('/dashboard', [SuperAdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/logout', [SuperAdminController::class, 'logout'])->name('logout');

    // 👥 USER MANAGEMENT - DENGAN ALIAS UTAMA + NESTED
    Route::get('/users', [SuperAdminController::class, 'users'])->name('users'); // ✅ ALIAS: super-admin.users
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [SuperAdminController::class, 'users'])->name('index'); // ✅ super-admin.users.index
        Route::get('/create', [SuperAdminController::class, 'createUser'])->name('create');
        Route::post('/store', [SuperAdminController::class, 'storeUser'])->name('store');
        Route::get('/{id}/edit', [SuperAdminController::class, 'editUser'])->name('edit');
        Route::put('/{id}', [SuperAdminController::class, 'updateUser'])->name('update');
        Route::delete('/{id}', [SuperAdminController::class, 'deleteUser'])->name('destroy');
        Route::post('/{id}/toggle-status', [SuperAdminController::class, 'toggleUserStatus'])->name('toggle-status');
    });

    // 👨‍💼 ADMIN UPT MANAGEMENT - DENGAN ALIAS UTAMA + NESTED
    Route::get('/admins', [SuperAdminController::class, 'admins'])->name('admins'); // ✅ ALIAS: super-admin.admins
    Route::prefix('admins')->name('admins.')->group(function () {
        Route::get('/', [SuperAdminController::class, 'admins'])->name('index'); // ✅ super-admin.admins.index
        Route::get('/create', [SuperAdminController::class, 'createAdmin'])->name('create');
        Route::post('/store', [SuperAdminController::class, 'storeAdmin'])->name('store');
        Route::get('/{id}', [SuperAdminController::class, 'showAdmin'])->name('show'); // ✅ super-admin.admins.show
        Route::get('/{id}/edit', [SuperAdminController::class, 'editAdmin'])->name('edit');
        Route::put('/{id}', [SuperAdminController::class, 'updateAdmin'])->name('update');
        Route::delete('/{id}', [SuperAdminController::class, 'deleteAdmin'])->name('destroy');
    });

    // 🏢 UPT MANAGEMENT - DENGAN ALIAS UTAMA + NESTED
    Route::get('/upts', [SuperAdminController::class, 'upts'])->name('upts'); // ✅ ALIAS: super-admin.upts
    Route::prefix('upts')->name('upts.')->group(function () {
        Route::get('/', [SuperAdminController::class, 'upts'])->name('index'); // ✅ super-admin.upts.index
        Route::get('/create', [SuperAdminController::class, 'createUpt'])->name('create');
        Route::post('/store', [SuperAdminController::class, 'storeUpt'])->name('store');
        Route::get('/{id}', [SuperAdminController::class, 'showUpt'])->name('show'); // ✅ super-admin.upts.show
        Route::get('/{id}/edit', [SuperAdminController::class, 'editUpt'])->name('edit');
        Route::put('/{id}', [SuperAdminController::class, 'updateUpt'])->name('update');
        Route::delete('/{id}', [SuperAdminController::class, 'deleteUpt'])->name('destroy');
    });

    // 📊 PERMITS MANAGEMENT - DENGAN ALIAS UTAMA + NESTED
    Route::get('/permits', [SuperAdminController::class, 'permits'])->name('permits'); // ✅ ALIAS: super-admin.permits
    Route::prefix('permits')->name('permits.')->group(function () {
        Route::get('/', [SuperAdminController::class, 'permits'])->name('index'); // ✅ super-admin.permits.index
        Route::get('/{id}', [SuperAdminController::class, 'showPermit'])->name('show');
        Route::post('/{id}/update-status', [SuperAdminController::class, 'updatePermitStatus'])->name('update-status');
        Route::delete('/{id}', [SuperAdminController::class, 'deletePermit'])->name('destroy');
    });

    // ✅ SUPER ADMIN REPORTS - LAPORAN BULANAN
    Route::prefix('reports')->name('reports.')->group(function () {
        // Monthly Report Page - Tampilkan halaman laporan bulanan dengan filter & grafik
        Route::get('/monthly', [SuperAdminController::class, 'monthlyReport'])->name('monthly');

        // Export PDF - Download laporan bulanan dalam format PDF
        Route::get('/monthly/pdf', [SuperAdminController::class, 'exportMonthlyPdf'])->name('monthly.pdf');

        // Export Excel - Download laporan bulanan dalam format Excel
        Route::get('/monthly/excel', [SuperAdminController::class, 'exportMonthlyExcel'])->name('monthly.excel');
    });

    // ⚙️ SETTINGS & EXPORTS
    Route::get('/settings', [SuperAdminController::class, 'settings'])->name('settings');
    Route::put('/settings/update', [SuperAdminController::class, 'updateSettings'])->name('settings.update'); // ✅ Konsisten dengan pattern lain
    Route::get('/export/users/excel', [SuperAdminController::class, 'exportUsers'])->name('export.users.excel');
    Route::get('/export/permits/pdf', [SuperAdminController::class, 'exportPermitsPdf'])->name('export.permits.pdf');
});
