<?php

namespace App\Http\Controllers;

use App\Models\ShipPermit;
use App\Models\User;
use App\Models\PasswordResetRequest;
use App\Models\Upt;
use App\Notifications\PermitApproved;
use App\Notifications\PermitRejected;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    /**
     * Constructor - Pastikan admin memiliki UPT
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $user = auth()->user();

            // Jika admin tapi tidak memiliki upt_id, tolak akses
            if ($user && $user->role === 'admin' && !$user->upt_id) {
                Auth::logout();
                return redirect()->route('login')
                    ->with('error', 'Akun admin tidak terikat dengan UPT. Hubungi Super Admin.');
            }

            return $next($request);
        });
    }

    // ============================================
    // 🔐 AUTHENTICATION
    // ============================================

    /**
     * Tampilkan form login admin
     */
    public function showLoginForm()
    {
        return view('admin.login');
    }

    /**
     * Proses login admin
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $user = Auth::user();

            // ✅ Pastikan user adalah admin DAN memiliki UPT
            if (!$user->isAdmin() || !$user->upt_id) {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Akun Anda tidak memiliki akses admin UPT.',
                ]);
            }

            // ✅ Update last login
            $user->update(['last_login_at' => now()]);

            $request->session()->regenerate();

            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    /**
     * Logout admin
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }

    // ============================================
    // 📊 DASHBOARD (UPT-SCOPED)
    // ============================================

    /**
     * Dashboard admin - OTOMATIS TER-SCOPE BY UPT via Global Scope
     */
    public function dashboard()
    {
        $admin = auth()->user();
        $upt = $admin->upt;

        // ✅ GLOBAL SCOPE di ShipPermit otomatis filter by upt_id
        // Admin hanya melihat data dari UPT mereka sendiri

        $stats = [
            'total' => ShipPermit::count(), // ✅ Auto-scoped by UptScope
            'pending' => ShipPermit::where('status', 'pending')->count(), // ✅ Auto-scoped
            'approved' => ShipPermit::where('status', 'approved')->count(), // ✅ Auto-scoped
            'rejected' => ShipPermit::where('status', 'rejected')->count(), // ✅ Auto-scoped
        ];

        // Recent permits (auto-scoped)
        $recentPermits = ShipPermit::with('user')
            ->latest()
            ->take(10)
            ->get(); // ✅ Auto-scoped by UptScope

        // Chart data for this UPT only
        $permitStatusData = [
            'labels' => ['Pending', 'Approved', 'Rejected'],
            'values' => [
                ShipPermit::where('status', 'pending')->count(), // ✅ Auto-scoped
                ShipPermit::where('status', 'approved')->count(), // ✅ Auto-scoped
                ShipPermit::where('status', 'rejected')->count(), // ✅ Auto-scoped
            ],
        ];

        return view('admin.dashboard', compact(
            'stats',
            'recentPermits',
            'permitStatusData',
            'upt' // ✅ Pass UPT info to view
        ));
    }

    // ============================================
    // 📋 PERMITS MANAGEMENT (UPT-SCOPED)
    // ============================================

    /**
     * Data pemohon (admin) - Auto-scoped by UPT via Global Scope
     */
    public function dataPemohon(Request $request)
    {
        // ✅ GLOBAL SCOPE otomatis filter by admin's upt_id
        $query = ShipPermit::with('user');

        // Filter tambahan (search) - tetap dalam scope UPT
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('ship_name', 'like', "%{$search}%")
                  ->orWhere('ship_type', 'like', "%{$search}%")
                  ->orWhereHas('user', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by status - tetap dalam scope UPT
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $data = $query->latest()->paginate(15)->withQueryString(); // ✅ Auto-scoped

        return view('admin.data-pemohon', compact('data'));
    }

    /**
     * Index permits (admin) - Auto-scoped by UPT via Global Scope
     */
    public function index(Request $request)
    {
        // ✅ GLOBAL SCOPE otomatis filter by admin's upt_id
        $query = ShipPermit::with('user');

        // Filter tambahan (search, status) - tetap dalam scope UPT
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('ship_name', 'like', "%{$search}%")
                  ->orWhere('ship_type', 'like', "%{$search}%")
                  ->orWhereHas('user', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $permits = $query->latest()->paginate(15)->withQueryString(); // ✅ Auto-scoped

        return view('admin.permits.index', compact('permits'));
    }

    /**
     * Show detail permit (admin) - Auto-scoped by UPT via Global Scope
     */
    public function show($id)
    {
        // ✅ GLOBAL SCOPE + findOrFail = 404 jika permit tidak ada di UPT admin
        $permit = ShipPermit::with('user')->findOrFail($id);

        return view('admin.permits.show', compact('permit'));
    }

    /**
     * Edit permit (admin) - Auto-scoped by UPT via Global Scope
     */
    public function edit($id)
    {
        // ✅ GLOBAL SCOPE + findOrFail = 404 jika permit tidak ada di UPT admin
        $permit = ShipPermit::findOrFail($id);

        return view('admin.permits.edit', compact('permit'));
    }

    /**
     * Update permit (admin) - LENGKAP DENGAN HANDLING FILE UPLOAD
     * Auto-scoped by UPT via Global Scope
     */
    public function update(Request $request, $id)
    {
        // ✅ GLOBAL SCOPE memastikan admin hanya bisa update permit di UPT mereka
        $permit = ShipPermit::findOrFail($id);

        // Validasi input lengkap dengan custom messages
        $validator = Validator::make($request->all(), [
            // Identitas Pemohon
            'email' => 'required|email|max:255',
            'name' => 'required|string|max:255',

            // Data Kapal
            'ship_name' => 'required|string|max:255',
            'ship_type' => 'required|string|max:255',
            'passenger_count' => 'required|integer|min:1',
            'captain_name' => 'required|string|max:255',
            'owner_agent' => 'required|string|max:255',
            'departure_location' => 'required|string|max:255',
            'movement_time' => 'required|string|max:255',
            'purpose' => 'required|string',

            // Dokumen (optional saat update - hanya jika diupload ulang)
            'document_1' => 'nullable|file|mimes:pdf|max:10240',
            'document_2' => 'nullable|file|mimes:pdf|max:10240',
            'document_3' => 'nullable|file|mimes:pdf|max:10240',
            'document_4' => 'nullable|file|mimes:pdf|max:10240',
            'document_5' => 'nullable|file|mimes:pdf|max:10240',
            'document_6' => 'nullable|file|mimes:pdf|max:10240',
            'document_7' => 'nullable|file|mimes:pdf|max:10240',

            // Status & Tanggal
            'application_date' => 'required|date',
            'status' => 'required|in:pending,approved,rejected',
        ], [
            'ship_name.required' => 'Nama Kapal wajib diisi',
            'ship_type.required' => 'Jenis Kapal wajib dipilih',
            '*.mimes' => 'Format file harus PDF',
            '*.max' => 'Ukuran file maksimal 10MB',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Prepare data untuk update (field teks)
        $updateData = [
            'email' => $request->email,
            'name' => $request->name,
            'ship_name' => $request->ship_name,
            'ship_type' => $request->ship_type,
            'passenger_count' => $request->passenger_count,
            'captain_name' => $request->captain_name,
            'owner_agent' => $request->owner_agent,
            'departure_location' => $request->departure_location,
            'movement_time' => $request->movement_time,
            'purpose' => $request->purpose,
            'application_date' => $request->application_date,
            'status' => $request->status,
        ];

        // Handle file uploads (optional - hanya jika ada file baru diupload)
        $documentFields = [
            'document_1', 'document_2', 'document_3',
            'document_4', 'document_5', 'document_6', 'document_7'
        ];

        foreach ($documentFields as $field) {
            if ($request->hasFile($field)) {
                // Hapus file lama dari storage jika ada
                if (!empty($permit->$field)) {
                    Storage::disk('public')->delete($permit->$field);
                }

                // Upload file baru ke storage
                $file = $request->file($field);
                $filename = time() . '_' . $field . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('documents', $filename, 'public');

                // Tambahkan path ke array update
                $updateData[$field] = $path;
            }
        }

        // Update database dengan semua data
        $permit->update($updateData);

        return redirect()->route('admin.permits.show', $permit->id)
            ->with('success', 'Data permohonan berhasil diupdate!');
    }

    /**
     * Delete permit (admin) - Auto-scoped by UPT via Global Scope
     */
    public function destroy($id)
    {
        // ✅ GLOBAL SCOPE memastikan admin hanya bisa hapus permit di UPT mereka
        $permit = ShipPermit::findOrFail($id);

        // Hapus file dokumen jika ada
        for ($i = 1; $i <= 7; $i++) {
            $documentField = "document_{$i}";
            if (!empty($permit->$documentField)) {
                Storage::disk('public')->delete($permit->$documentField);
            }
        }

        $permit->delete();

        return redirect()->route('admin.permits.index')
            ->with('success', 'Data permohonan berhasil dihapus!');
    }

    /**
     * Download atau preview dokumen pendukung (admin) - Auto-scoped by UPT
     */
    public function download($id, $document, $action = null)
    {
        // ✅ GLOBAL SCOPE memastikan admin hanya bisa download dokumen dari UPT mereka
        $permit = ShipPermit::findOrFail($id);

        // Validasi nomor dokumen (1-7)
        if (!in_array($document, range(1, 7))) {
            return back()->with('error', 'Dokumen tidak valid!');
        }

        $documentField = "document_{$document}";

        // Cek apakah dokumen ada
        if (empty($permit->$documentField)) {
            return back()->with('error', 'Dokumen tidak ditemukan!');
        }

        $path = Storage::disk('public')->path($permit->$documentField);
        $filename = 'document_' . $document . '_' . ($permit->ship_name ?? $permit->ship_type) . '.pdf';

        // ✅ OPSI 1: LIHAT (Preview inline di browser - TIDAK TERUNDUH)
        if ($action === 'view') {
            return response()->file($path, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . $filename . '"'
            ]);
        }

        // ✅ OPSI 2: UNDUH (Force download ke device - TERUNDUH)
        if ($action === 'download') {
            return response()->download($path, $filename, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"'
            ]);
        }

        // Default: Download
        return Storage::disk('public')->download($permit->$documentField, $filename);
    }

    /**
     * Generate dan download surat SPOG untuk admin - Auto-scoped by UPT
     */
    public function downloadSPOG($id)
    {
        // ✅ GLOBAL SCOPE memastikan admin hanya bisa download SPOG dari UPT mereka
        $permit = ShipPermit::findOrFail($id);

        // Hanya bisa download jika status approved
        if ($permit->status !== 'approved') {
            return back()->with('error', 'Surat SPOG hanya dapat diunduh setelah permohonan disetujui.');
        }

        // Data untuk PDF - sesuai format dokumen resmi
        $data = [
            'permit' => $permit,
            'generated_at' => now()->format('d F Y H:i'),
            'office' => $permit->upt?->name ?? 'KANTOR KESYAHBANDARAN DAN OTORITAS PELABUHAN',
            'branch' => $permit->upt?->region ?? 'Wilayah Kerja',
        ];

        // Generate PDF dengan template sesuai dokumen resmi
        $pdf = Pdf::loadView('pdf.spog', $data)
            ->setPaper('a4', 'portrait')
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('isRemoteEnabled', true);

        // Download dengan nama file yang deskriptif
        $shipIdentifier = $permit->ship_name ?? $permit->ship_type;
        $uptCode = $permit->upt?->code ?? 'UPT';
        $filename = "SPOG_{$uptCode}_" . strtoupper(str_replace(' ', '_', $shipIdentifier)) . '_' . $permit->application_date->format('Ymd') . '.pdf';

        return $pdf->download($filename);
    }

    /**
     * Approve permit (admin) + Send notification to user - Auto-scoped by UPT
     */
    public function approve($id)
    {
        // ✅ GLOBAL SCOPE memastikan admin hanya bisa approve permit di UPT mereka
        $permit = ShipPermit::findOrFail($id);

        // Optional: Double-check untuk keamanan ekstra
        if (auth()->user()->upt_id && $permit->upt_id !== auth()->user()->upt_id) {
            abort(403, 'Anda tidak memiliki akses untuk permohonan ini.');
        }

        $permit->update([
            'status' => 'approved',
            'approved_by' => auth()->user()->name,
            'approved_at' => now(),
        ]);

        // ✅ Kirim notifikasi ke user bahwa permohonannya disetujui
        try {
            $user = User::where('email', $permit->email)->first();
            if ($user) {
                $user->notify(new PermitApproved($permit));
            }
        } catch (\Exception $e) {
            // Log error tapi jangan hentikan proses
            Log::error('Failed to send approval notification: ' . $e->getMessage());
        }

        return back()->with('success', 'Permohonan disetujui!');
    }

    /**
     * ✅ REJECT PERMIT DENGAN CATATAN PENOLAKAN + NOTIFIKASI KE USER
     * Auto-scoped by UPT via Global Scope
     *
     * FIX: Wrapped notification in try-catch untuk handle email error
     */
    public function reject(Request $request, $id)
    {
        // ✅ Validasi catatan penolakan
        $validator = Validator::make($request->all(), [
            'rejection_notes' => [
                'required',
                'string',
                'min:10',
                'max:1000',
            ],
        ], [
            'rejection_notes.required' => 'Catatan penolakan wajib diisi',
            'rejection_notes.min' => 'Catatan penolakan minimal 10 karakter',
            'rejection_notes.max' => 'Catatan penolakan maksimal 1000 karakter',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // ✅ GLOBAL SCOPE memastikan admin hanya bisa reject permit di UPT mereka
        $permit = ShipPermit::findOrFail($id);

        // Optional: Double-check untuk keamanan ekstra
        if (auth()->user()->upt_id && $permit->upt_id !== auth()->user()->upt_id) {
            abort(403, 'Anda tidak memiliki akses untuk permohonan ini.');
        }

        // ✅ Update permit dengan status rejected dan catatan penolakan
        $permit->update([
            'status' => 'rejected',
            'rejection_notes' => $request->rejection_notes,
            'rejected_by' => auth()->user()->name,
            'rejected_at' => now(),
        ]);

        // ✅ Kirim notifikasi ke user dengan detail penolakan
        // WRAPPED IN TRY-CATCH untuk handle email error
        $emailSent = false;
        try {
            $user = User::where('email', $permit->email)->first();
            if ($user) {
                $user->notify(new PermitRejected($permit, $request->rejection_notes));
                $emailSent = true;
            }
        } catch (\Exception $e) {
            // Log error tapi jangan hentikan proses reject
            Log::error('Failed to send rejection notification: ' . $e->getMessage());
            // Notifikasi tetap tersimpan di database notifications table
        }

        // Return dengan pesan yang sesuai
        if ($emailSent) {
            return back()->with('success', 'Permohonan ditolak. User telah diberitahu dengan catatan penolakan.');
        } else {
            return back()->with('warning', 'Permohonan ditolak. Catatan penolakan tersimpan, namun email tidak dapat dikirim (periksa konfigurasi mail server).');
        }
    }

    // ============================================
    // 👤 ADMIN PROFILE & SETTINGS
    // ============================================

    /**
     * Show admin profile page
     */
    public function profile()
    {
        $admin = Auth::user();
        return view('admin.profile', compact('admin'));
    }

    /**
     * Update admin profile
     */
    public function updateProfile(Request $request)
    {
        $admin = Auth::user();

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($admin->id),
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

        $admin->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('admin.profile')
            ->with('success', 'Profil admin berhasil diperbarui!');
    }

    /**
     * Update admin password
     */
    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'current_password.required' => 'Password saat ini wajib diisi',
            'password.required' => 'Password baru wajib diisi',
            'password.min' => 'Password minimal 8 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $admin = Auth::user();

        // Verify current password
        if (!Hash::check($request->current_password, $admin->password)) {
            return redirect()->back()
                ->withErrors(['current_password' => 'Password saat ini tidak sesuai'])
                ->withInput();
        }

        $admin->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.profile')
            ->with('success', 'Password admin berhasil diperbarui!');
    }

    /**
     * Show admin settings page
     */
    public function settings()
    {
        $admin = Auth::user();

        // Get admin settings from session or default values
        $settings = session()->get('admin_settings', [
            'theme' => 'system',
            'email_notifications' => true,
            'sms_notifications' => false,
            'default_dashboard_view' => 'grid',
        ]);

        return view('admin.settings', compact('admin', 'settings'));
    }

    /**
     * Update admin settings
     */
    public function updateSettings(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'theme' => ['nullable', 'in:light,dark,system'],
            'email_notifications' => ['nullable', 'boolean'],
            'sms_notifications' => ['nullable', 'boolean'],
            'default_dashboard_view' => ['nullable', 'in:grid,list'],
        ], [
            'theme.in' => 'Pilihan tema tidak valid',
            'default_dashboard_view.in' => 'Pilihan tampilan dashboard tidak valid',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Get current settings or use defaults
        $currentSettings = session()->get('admin_settings', [
            'theme' => 'system',
            'email_notifications' => true,
            'sms_notifications' => false,
            'default_dashboard_view' => 'grid',
        ]);

        // Update settings with new values or keep current
        $newSettings = [
            'theme' => $request->input('theme', $currentSettings['theme']),
            'email_notifications' => $request->boolean('email_notifications'),
            'sms_notifications' => $request->boolean('sms_notifications'),
            'default_dashboard_view' => $request->input('default_dashboard_view', $currentSettings['default_dashboard_view']),
        ];

        session()->put('admin_settings', $newSettings);

        return redirect()->route('admin.settings')
            ->with('success', 'Pengaturan admin berhasil disimpan!');
    }

    // ============================================
    // 🔐 PASSWORD RESET MANAGEMENT (UPT-SCOPED)
    // ============================================

    /**
     * Show pending password reset requests - Auto-scoped by UPT
     */
    public function passwordResetRequests()
    {
        // ✅ Hanya tampilkan request dari user yang ada di UPT admin ini
        $admin = auth()->user();

        $requests = PasswordResetRequest::with('user')
            ->whereHas('user', function (Builder $query) use ($admin) {
                $query->where('upt_id', $admin->upt_id);
            })
            ->latest()
            ->paginate(15);

        $pendingCount = PasswordResetRequest::where('status', 'pending')
            ->whereHas('user', function (Builder $query) use ($admin) {
                $query->where('upt_id', $admin->upt_id);
            })
            ->count();

        return view('admin.password-reset-requests', compact('requests', 'pendingCount'));
    }

    /**
     * Approve password reset request - Auto-scoped by UPT
     */
    public function approveResetRequest(Request $request, $id)
    {
        $admin = auth()->user();

        // ✅ Pastikan request ini milik user di UPT admin
        $resetRequest = PasswordResetRequest::with('user')
            ->whereHas('user', function (Builder $query) use ($admin) {
                $query->where('upt_id', $admin->upt_id);
            })
            ->findOrFail($id);

        if (!$resetRequest->isPending()) {
            return redirect()->back()
                ->with('error', 'Request ini sudah diproses.');
        }

        if ($resetRequest->isExpired()) {
            return redirect()->back()
                ->with('error', 'Request sudah kadaluarsa.');
        }

        // Generate temporary password (4 letters + 4 numbers)
        $temporaryPassword = strtoupper(Str::random(4)) . rand(1000, 9999);

        $resetRequest->update([
            'status' => 'approved',
            'temporary_password' => $temporaryPassword,
            'verified_by' => Auth::user()->name,
            'admin_notes' => $request->notes,
            'approved_at' => now(),
        ]);

        return redirect()->back()
            ->with('success', 'Request disetujui! Temporary password: ' . $temporaryPassword)
            ->with('temporary_password', $temporaryPassword);
    }

    /**
     * Reject password reset request - Auto-scoped by UPT
     */
    public function rejectResetRequest(Request $request, $id)
    {
        $admin = auth()->user();

        // ✅ Pastikan request ini milik user di UPT admin
        $resetRequest = PasswordResetRequest::with('user')
            ->whereHas('user', function (Builder $query) use ($admin) {
                $query->where('upt_id', $admin->upt_id);
            })
            ->findOrFail($id);

        $resetRequest->update([
            'status' => 'rejected',
            'verified_by' => Auth::user()->name,
            'admin_notes' => $request->notes,
        ]);

        return redirect()->back()
            ->with('success', 'Request ditolak.');
    }

    /**
     * API endpoint for real-time badge count - Auto-scoped by UPT
     */
    public function getPendingResetCount()
    {
        $admin = auth()->user();

        return response()->json([
            'count' => PasswordResetRequest::where('status', 'pending')
                ->where('expires_at', '>', now())
                ->whereHas('user', function (Builder $query) use ($admin) {
                    $query->where('upt_id', $admin->upt_id);
                })
                ->count()
        ]);
    }
}
