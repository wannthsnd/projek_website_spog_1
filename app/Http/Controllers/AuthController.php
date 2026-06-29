<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Upt;
use App\Models\PasswordResetRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\Registered;

class AuthController extends Controller
{
    /**
     * Show registration form dengan UPT selector
     */
    public function showRegistrationForm()
    {
        // ✅ Get all active UPTs for dropdown
        $upts = Upt::active()->orderBy('name')->get();

        return view('auth.register', compact('upts'));
    }

    /**
     * Register a new user dengan UPT selection
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'upt_id' => ['required', 'exists:upts,id'], // ✅ Wajib pilih UPT
        ], [
            'name.required' => 'Nama lengkap wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.unique' => 'Email sudah terdaftar',
            'password.min' => 'Password minimal 8 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
            'upt_id.required' => 'Silakan pilih Unit Pelaksana Teknis (UPT) Anda',
            'upt_id.exists' => 'UPT yang dipilih tidak valid',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',
            'upt_id' => $request->upt_id, // ✅ Simpan UPT ID
            'is_active' => true,
        ]);

        event(new Registered($user));

        Auth::login($user);

        // ✅ Tampilkan nama UPT di success message
        $uptName = $user->upt?->name ?? 'UPT Anda';

        return redirect()->route('dashboard')
            ->with('success', "✅ Registrasi berhasil! Anda terdaftar di {$uptName}. Selamat datang di SPOG KAPAL.");
    }

    /**
     * Show login form
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle login - REGULAR PASSWORD
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required' => 'Email wajib diisi',
            'password.required' => 'Password wajib diisi',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();

            // ✅ Update last login timestamp
            $user->update(['last_login_at' => now()]);

            // Redirect based on role
            if ($user->isAdmin()) {
                return redirect()->intended(route('admin.dashboard'))
                    ->with('success', 'Selamat datang, Admin!');
            }

            if ($user->isSuperAdmin()) {
                return redirect()->intended(route('super-admin.dashboard'))
                    ->with('success', 'Selamat datang, Super Administrator!');
            }

            return redirect()->intended(route('dashboard'))
                ->with('success', 'Selamat datang kembali, ' . $user->name . '!');
        }

        throw ValidationException::withMessages([
            'email' => 'Email atau password salah. Silakan coba lagi.',
        ]);
    }

    /**
     * Handle login - TEMPORARY PASSWORD (FIXED)
     */
    public function loginWithTemporaryPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email'],
            'temporary_password' => ['required', 'string'],
        ], [
            'email.required' => 'Email wajib diisi',
            'temporary_password.required' => 'Temporary password wajib diisi',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Cari request reset password yang match dengan email dan temporary password
        $resetRequest = PasswordResetRequest::where('email', $request->email)
            ->where('temporary_password', $request->temporary_password)
            ->where('status', 'approved')
            ->first();

        // Jika tidak ditemukan
        if (!$resetRequest) {
            return redirect()->back()
                ->withErrors(['email' => 'Email atau temporary password tidak valid.'])
                ->withInput();
        }

        // Cek apakah sudah expired
        if ($resetRequest->isExpired()) {
            return redirect()->back()
                ->withErrors(['email' => 'Temporary password sudah kadaluarsa. Silakan ajukan permintaan reset password baru.'])
                ->withInput();
        }

        // Cek apakah sudah pernah digunakan
        if ($resetRequest->isCompleted()) {
            return redirect()->back()
                ->withErrors(['email' => 'Temporary password sudah pernah digunakan. Silakan login dengan password baru Anda.'])
                ->withInput();
        }

        // Cari user berdasarkan email
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return redirect()->back()
                ->withErrors(['email' => 'User tidak ditemukan.'])
                ->withInput();
        }

        // ✅ LOGIN USER SECARA MANUAL (tanpa verifikasi password di tabel users)
        Auth::login($user);

        // ✅ Update last login timestamp
        $user->update(['last_login_at' => now()]);

        // ✅ TANDAI REQUEST SEBAGAI COMPLETED
        $resetRequest->update([
            'status' => 'completed',
            'completed_at' => now(),
        ]);

        // ✅ SET SESSION FLAG UNTUK FORCE CHANGE PASSWORD
        session()->put('must_change_password', true);

        // ✅ REDIRECT KE HALAMAN GANTI PASSWORD
        return redirect()->route('profile.password')
            ->with('success', 'Login berhasil! Silakan ganti password Anda sekarang untuk keamanan akun.');
    }

    /**
     * Show user profile page
     */
    public function profile()
    {
        $user = Auth::user()->loadCount('shipPermits');
        return view('auth.profile', compact('user'));
    }

    /**
     * Show password change form
     */
    public function showPasswordForm()
    {
        return view('auth.change-password');
    }

    /**
     * Update user profile
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
        ], [
            'name.required' => 'Nama lengkap wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.unique' => 'Email sudah digunakan oleh akun lain',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('profile')
            ->with('success', 'Profil berhasil diperbarui!');
    }

    /**
     * Update user password - WITH FORCE CHANGE CHECK
     */
    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        // Check if user must change password (after temporary login)
        if (session()->get('must_change_password', false)) {
            // Skip current password validation for forced change
            $validator = Validator::make($request->all(), [
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ], [
                'password.required' => 'Password baru wajib diisi',
                'password.min' => 'Password minimal 8 karakter',
                'password.confirmed' => 'Konfirmasi password tidak cocok',
            ]);
        } else {
            // Normal password change - require current password
            $validator = Validator::make($request->all(), [
                'current_password' => ['required', 'string'],
                'password' => ['required', 'string', 'min:8', 'confirmed', 'different:current_password'],
            ], [
                'current_password.required' => 'Password saat ini wajib diisi',
                'password.required' => 'Password baru wajib diisi',
                'password.min' => 'Password minimal 8 karakter',
                'password.confirmed' => 'Konfirmasi password tidak cocok',
                'password.different' => 'Password baru harus berbeda dari password saat ini',
            ]);
        }

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Verify current password only if not forced change
        if (!session()->get('must_change_password', false)) {
            if (!Hash::check($request->current_password, $user->password)) {
                return redirect()->back()
                    ->withErrors(['current_password' => 'Password saat ini tidak sesuai'])
                    ->withInput();
            }
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        // Clear must_change_password session
        session()->forget('must_change_password');

        return redirect()->route('profile')
            ->with('success', 'Password berhasil diperbarui!');
    }

    /**
     * Show user settings page
     */
    public function settings()
    {
        $user = Auth::user();

        // Get user settings from session or default values
        $settings = session()->get('user_settings', [
            'theme' => 'system',
            'email_notifications' => true,
            'sms_notifications' => false,
        ]);

        return view('auth.settings', compact('user', 'settings'));
    }

    /**
     * Update user settings
     */
    public function updateSettings(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'theme' => ['nullable', 'in:light,dark,system'],
            'email_notifications' => ['nullable', 'boolean'],
            'sms_notifications' => ['nullable', 'boolean'],
        ], [
            'theme.in' => 'Pilihan tema tidak valid',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Update settings in session
        $currentSettings = session()->get('user_settings', []);

        $newSettings = [
            'theme' => $request->theme ?? ($currentSettings['theme'] ?? 'system'),
            'email_notifications' => $request->boolean('email_notifications'),
            'sms_notifications' => $request->boolean('sms_notifications'),
        ];

        session()->put('user_settings', $newSettings);

        return redirect()->route('settings')
            ->with('success', 'Pengaturan berhasil disimpan!');
    }

    /**
     * Handle logout
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'Anda telah logout. Sampai jumpa!');
    }

    // ============================================
    // ✅ LUPA PASSWORD TANPA EMAIL (SECURE)
    // ============================================

    /**
     * Show forgot password form
     */
    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    /**
     * Submit password reset request
     */
    public function submitResetRequest(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email', 'exists:users,email'],
        ], [
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.exists' => 'Email tidak terdaftar dalam sistem',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Check if there's already a pending request
        $existingRequest = PasswordResetRequest::where('email', $request->email)
            ->where('status', 'pending')
            ->where('expires_at', '>', now())
            ->first();

        if ($existingRequest) {
            return redirect()->route('password.status', ['email' => $request->email])
                ->with('info', 'Permintaan reset password Anda sedang diproses.');
        }

        // Create new reset request (valid for 24 hours)
        PasswordResetRequest::create([
            'email' => $request->email,
            'status' => 'pending',
            'expires_at' => now()->addHours(24),
        ]);

        // Redirect to status page with email parameter
        return redirect()->route('password.status', ['email' => $request->email])
            ->with('success', 'Permintaan reset password berhasil diajukan! Silakan cek statusnya.');
    }

    /**
     * Show reset status page
     */
    public function showResetStatus(Request $request)
    {
        return view('auth.reset-status');
    }

    /**
     * Check reset request status via AJAX
     */
    public function checkResetStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email'],
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Email tidak valid'], 422);
        }

        $resetRequest = PasswordResetRequest::where('email', $request->email)
            ->latest()
            ->first();

        if (!$resetRequest) {
            return response()->json([
                'status' => 'not_found',
                'message' => 'Tidak ada permintaan reset password untuk email ini.'
            ]);
        }

        return response()->json([
            'status' => $resetRequest->status,
            'temporary_password' => $resetRequest->status === 'approved' ? $resetRequest->temporary_password : null,
            'created_at' => $resetRequest->created_at->format('d M Y H:i'),
            'expires_at' => $resetRequest->expires_at->format('d M Y H:i'),
            'is_expired' => $resetRequest->isExpired(),
            'admin_notes' => $resetRequest->admin_notes,
            'verified_by' => $resetRequest->verified_by,
        ]);
    }
}
