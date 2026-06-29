<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ShipPermit;
use App\Models\PasswordResetRequest;
use App\Models\Upt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Carbon\Carbon;

class SuperAdminController extends Controller
{
    // ============================================
    // 🔐 AUTHENTICATION
    // ============================================

    /**
     * Show super admin login form
     */
    public function showLoginForm()
    {
        if (auth()->check() && auth()->user()->isSuperAdmin()) {
            return redirect()->route('super-admin.dashboard');
        }

        if (auth()->check()) {
            Auth::logout();
            session()->flash('error', 'Akses ditolak. Diperlukan akun Super Admin.');
            return redirect()->route('super-admin.login');
        }

        return view('super-admin.auth.login');
    }

    /**
     * Handle super admin login
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'password.required' => 'Password wajib diisi',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $user = Auth::user();

            if (!$user->isSuperAdmin()) {
                Auth::logout();
                return redirect()->route('login')
                    ->with('error', '⛔ Akses ditolak. Diperlukan akun Super Admin.');
            }

            $user->update(['last_login_at' => now()]);
            $request->session()->regenerate();

            Log::channel('security')->info('Super Admin Login', [
                'user_id' => $user->id,
                'email' => $user->email,
                'ip_address' => $request->ip(),
                'timestamp' => now()->toDateTimeString(),
            ]);

            return redirect()->intended(route('super-admin.dashboard'))
                ->with('success', '✅ Selamat datang, Super Administrator!');
        }

        Log::channel('security')->warning('Failed Super Admin Login Attempt', [
            'email' => $request->email,
            'ip_address' => $request->ip(),
            'timestamp' => now()->toDateTimeString(),
        ]);

        return redirect()->back()
            ->withErrors(['email' => '❌ Email atau password salah.'])
            ->withInput();
    }

    /**
     * Super admin logout
     */
    public function logout(Request $request)
    {
        $user = Auth::user();

        Log::channel('security')->info('Super Admin Logout', [
            'user_id' => $user->id ?? 'unknown',
            'email' => $user->email ?? 'unknown',
            'timestamp' => now()->toDateTimeString(),
        ]);

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('super-admin.login')
            ->with('success', 'Anda telah logout dari panel Super Admin.');
    }

    // ============================================
    // 📊 DASHBOARD (GLOBAL ACCESS)
    // ============================================

    /**
     * Show super admin dashboard dengan Chart Data Real
     */
    public function dashboard()
    {
        // System-wide statistics
        $stats = [
            'total_users' => User::where('role', 'user')->count(),
            'total_admins' => User::where('role', 'admin')->count(),
            'total_super_admins' => User::where('role', 'super_admin')->count(),
            'total_upts' => Upt::count(),
            'active_upts' => Upt::where('is_active', true)->count(),
            'total_permits' => ShipPermit::count(),
            'pending_permits' => ShipPermit::where('status', 'pending')->count(),
            'approved_permits' => ShipPermit::where('status', 'approved')->count(),
            'rejected_permits' => ShipPermit::where('status', 'rejected')->count(),
            'active_users' => User::where('is_active', true)->count(),
            'suspended_users' => User::where('is_active', false)->count(),
        ];

        // Recent activities (dari SEMUA UPT)
        $recentUsers = User::where('role', 'user')
            ->with('upt')
            ->latest()
            ->take(5)
            ->get();

        $recentPermits = ShipPermit::with(['user', 'upt'])
            ->latest()
            ->take(5)
            ->get();

        $recentLogins = User::whereNotNull('last_login_at')
            ->orderBy('last_login_at', 'desc')
            ->take(5)
            ->get();

        // ✅ Chart data - Permits by status (Pie Chart)
        $permitStatusData = [
            'labels' => ['Pending', 'Approved', 'Rejected'],
            'values' => [
                (int) ShipPermit::where('status', 'pending')->count(),
                (int) ShipPermit::where('status', 'approved')->count(),
                (int) ShipPermit::where('status', 'rejected')->count(),
            ],
        ];

        // ✅ Chart data - Users by month (Last 6 Months - Area Chart)
        $userGrowthData = $this->getUserGrowthData();

        // ✅ Chart data - Permit trend by status (Last 6 Months - Multi-line Chart)
        $permitTrendData = $this->getPermitTrendData();

        // ✅ Chart data - Permits by UPT (Bar Chart)
        $permitsByUpt = $this->getPermitsByUptData();

        return view('super-admin.dashboard', compact(
            'stats',
            'recentUsers',
            'recentPermits',
            'recentLogins',
            'permitStatusData',
            'userGrowthData',
            'permitTrendData',
            'permitsByUpt'
        ));
    }

    /**
     * Get user growth data for chart (Last 6 Months)
     */
    private function getUserGrowthData(): array
    {
        $months = [];
        $counts = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $monthLabel = $date->format('M');
            $monthStart = $date->copy()->startOfMonth()->format('Y-m-d 00:00:00');
            $monthEnd = $date->copy()->endOfMonth()->format('Y-m-d 23:59:59');

            $count = User::where('role', 'user')
                ->whereBetween('created_at', [$monthStart, $monthEnd])
                ->count();

            $months[] = $monthLabel;
            $counts[] = (int) $count;
        }

        return [
            'labels' => $months,
            'values' => $counts,
        ];
    }

    /**
     * Get permit trend data for chart (Last 6 Months)
     */
    private function getPermitTrendData(): array
    {
        $months = [];
        $pending = [];
        $approved = [];
        $rejected = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $monthLabel = $date->format('M');
            $monthStart = $date->copy()->startOfMonth()->format('Y-m-d 00:00:00');
            $monthEnd = $date->copy()->endOfMonth()->format('Y-m-d 23:59:59');

            $months[] = $monthLabel;

            $pending[] = (int) ShipPermit::where('status', 'pending')
                ->whereBetween('created_at', [$monthStart, $monthEnd])
                ->count();

            $approved[] = (int) ShipPermit::where('status', 'approved')
                ->whereBetween('created_at', [$monthStart, $monthEnd])
                ->count();

            $rejected[] = (int) ShipPermit::where('status', 'rejected')
                ->whereBetween('created_at', [$monthStart, $monthEnd])
                ->count();
        }

        return [
            'labels' => $months,
            'datasets' => [
                ['label' => 'Pending', 'data' => $pending, 'color' => '#F59E0B'],
                ['label' => 'Approved', 'data' => $approved, 'color' => '#10B981'],
                ['label' => 'Rejected', 'data' => $rejected, 'color' => '#EF4444'],
            ],
        ];
    }

    /**
     * Get permits by UPT data for chart (Bar Chart)
     */
    private function getPermitsByUptData(): array
    {
        $labels = [];
        $pending = [];
        $approved = [];
        $rejected = [];

        $upts = Upt::withCount([
            'permits as pending_count' => fn($q) => $q->where('status', 'pending'),
            'permits as approved_count' => fn($q) => $q->where('status', 'approved'),
            'permits as rejected_count' => fn($q) => $q->where('status', 'rejected'),
        ])
        ->orderBy('pending_count', 'desc')
        ->take(10)
        ->get();

        foreach ($upts as $upt) {
            $labels[] = $upt->code;
            $pending[] = $upt->pending_count;
            $approved[] = $upt->approved_count;
            $rejected[] = $upt->rejected_count;
        }

        return [
            'labels' => $labels,
            'datasets' => [
                ['label' => 'Pending', 'data' => $pending, 'color' => '#F59E0B'],
                ['label' => 'Approved', 'data' => $approved, 'color' => '#10B981'],
                ['label' => 'Rejected', 'data' => $rejected, 'color' => '#EF4444'],
            ],
        ];
    }

    // ============================================
    // 📊 MONTHLY REPORT FEATURE (BARU)
    // ============================================

    /**
     * Tampilkan halaman laporan bulanan
     */
    public function monthlyReport(Request $request)
{
    // Default bulan dan tahun saat ini
    $month = $request->input('month', date('m'));
    $year = $request->input('year', date('Y'));

    // Format bulan untuk tampilan
    $monthName = \Carbon\Carbon::create()->month($month)->format('F');
    $monthYear = \Carbon\Carbon::create()->month($month)->year($year)->format('F Y');

    // Query data berdasarkan bulan dan tahun
    $permits = \App\Models\ShipPermit::whereYear('application_date', $year)
        ->whereMonth('application_date', $month)
        ->with(['user', 'upt'])
        ->orderBy('application_date', 'desc')
        ->get();

    // Statistik Summary
    $stats = [
        'total_permits' => $permits->count(),
        'approved' => $permits->where('status', 'approved')->count(),
        'pending' => $permits->where('status', 'pending')->count(),
        'rejected' => $permits->where('status', 'rejected')->count(),
        'total_passengers' => $permits->sum('passenger_count'),
        'total_gt' => $permits->sum('gross_tonnage'),
        'approval_rate' => $permits->count() > 0
            ? round(($permits->where('status', 'approved')->count() / $permits->count()) * 100, 1)
            : 0,
    ];

    // ✅ 1. USER GROWTH DATA (6 bulan terakhir) - UNTUK BAR CHART
    $userGrowthData = [];
    for ($i = 5; $i >= 0; $i--) {
        $date = \Carbon\Carbon::now()->subMonths($i);
        $userCount = \App\Models\User::whereYear('created_at', $date->year)
            ->whereMonth('created_at', $date->month)
            ->count();
        $userGrowthData[] = [
            'label' => $date->format('M Y'),
            'value' => $userCount,
            'new_users' => $userCount,
        ];
    }

    // ✅ 2. PERMIT STATUS DATA (untuk doughnut chart) - WAJIB!
    $permitStatusData = [
        'labels' => ['Approved', 'Pending', 'Rejected'],
        'values' => [
            $stats['approved'],
            $stats['pending'],
            $stats['rejected'],
        ],
    ];

    // ✅ 3. DAILY DATA (untuk line chart)
    $dailyData = [];
    $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
    for ($day = 1; $day <= $daysInMonth; $day++) {
        $date = sprintf('%04d-%02d-%02d', $year, $month, $day);
        $dailyData[] = [
            'date' => $day,
            'total' => $permits->filter(function($permit) use ($date) {
                return $permit->application_date->toDateString() == $date;
            })->count(),
            'approved' => $permits->filter(function($permit) use ($date) {
                return $permit->application_date->toDateString() == $date && $permit->status == 'approved';
            })->count(),
            'pending' => $permits->filter(function($permit) use ($date) {
                return $permit->application_date->toDateString() == $date && $permit->status == 'pending';
            })->count(),
        ];
    }

    // Statistik per UPT
    $uptStats = \App\Models\Upt::withCount([
            'permits as permits_count' => function ($query) use ($month, $year) {
                $query->whereYear('application_date', $year)
                      ->whereMonth('application_date', $month);
            }
        ])
        ->withCount([
            'permits as approved_count' => function ($query) use ($month, $year) {
                $query->whereYear('application_date', $year)
                      ->whereMonth('application_date', $month)
                      ->where('status', 'approved');
            }
        ])
        ->orderBy('permits_count', 'desc')
        ->get();

    // Top 5 kapal terbanyak
    $topShips = $permits->groupBy('ship_name')
        ->map(function($items) {
            return [
                'ship_name' => $items->first()->ship_name,
                'count' => $items->count(),
                'ship_type' => $items->first()->ship_type,
            ];
        })
        ->sortByDesc('count')
        ->take(5)
        ->values();

    // Data untuk export
    $exportData = [
        'permits' => $permits,
        'stats' => $stats,
        'month' => $month,
        'year' => $year,
        'monthYear' => $monthYear,
    ];

    // Convert to JSON strings untuk JavaScript
$dailyDataJson = json_encode($dailyData);
$userGrowthDataJson = json_encode($userGrowthData);
$permitStatusDataJson = json_encode($permitStatusData);

// Debug
\Log::info('Chart JSON Data:', [
    'daily' => $dailyDataJson,
    'user' => $userGrowthDataJson,
    'status' => $permitStatusDataJson,
]);

    // ✅ RETURN VIEW DENGAN SEMUA VARIABEL YANG LENGKAP
    return view('super-admin.reports.monthly', compact(
        'permits',
        'stats',
        'month',
        'year',
        'monthName',
        'monthYear',
        'uptStats',
        'dailyData',           // ✅ Untuk Line Chart
        'topShips',
        'exportData',
        'userGrowthData',      // ✅ Untuk Bar Chart
        'permitStatusData'     // ✅ Untuk Doughnut Chart - INI YANG HILANG!
    ));
}

    /**
     * Export laporan bulanan ke PDF
     */
    public function exportMonthlyPdf(Request $request)
    {
        $month = $request->input('month', date('m'));
        $year = $request->input('year', date('Y'));
        $monthYear = Carbon::create()->month($month)->year($year)->format('F Y');

        $permits = ShipPermit::whereYear('application_date', $year)
            ->whereMonth('application_date', $month)
            ->with(['user', 'upt'])
            ->orderBy('application_date', 'desc')
            ->get();

        $stats = [
            'total_permits' => $permits->count(),
            'approved' => $permits->where('status', 'approved')->count(),
            'pending' => $permits->where('status', 'pending')->count(),
            'rejected' => $permits->where('status', 'rejected')->count(),
            'total_passengers' => $permits->sum('passenger_count'),
            'approval_rate' => $permits->where('status', 'approved')->count() > 0
                ? round(($permits->where('status', 'approved')->count() / $permits->count()) * 100, 1)
                : 0,
        ];

        $pdf = Pdf::loadView('super-admin.reports.pdf.monthly', compact(
            'permits',
            'stats',
            'month',
            'year',
            'monthYear'
        ))
        ->setPaper('a4', 'landscape')
        ->setOption('isHtml5ParserEnabled', true)
        ->setOption('isRemoteEnabled', true);

        $filename = 'Laporan_Bulanan_' . $monthYear . '.pdf';
        return $pdf->download($filename);
    }

    /**
     * Export laporan bulanan ke Excel
     */
    public function exportMonthlyExcel(Request $request)
    {
        $month = $request->input('month', date('m'));
        $year = $request->input('year', date('Y'));
        $monthYear = Carbon::create()->month($month)->year($year)->format('F_Y');

        $permits = ShipPermit::whereYear('application_date', $year)
            ->whereMonth('application_date', $month)
            ->with(['user', 'upt'])
            ->orderBy('application_date', 'desc')
            ->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header
        $sheet->mergeCells('A1:J1');
        $sheet->setCellValue('A1', 'LAPORAN BULANAN PERMOHONAN SPOG');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $sheet->mergeCells('A2:J2');
        $sheet->setCellValue('A2', 'Periode: ' . Carbon::create()->month($month)->year($year)->format('F Y'));
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $sheet->fromArray([
            [],
            ['No', 'Tanggal', 'Nama Kapal', 'Jenis Kapal', 'Pemohon', 'Email', 'UPT', 'Status', 'Penumpang', 'GT'],
        ], null, 'A3');

        $sheet->getStyle('A4:J4')->getFont()->setBold(true);
        $sheet->getStyle('A4:J4')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setRGB('FCD34D');

        $row = 5;
        foreach ($permits as $index => $permit) {
            $sheet->fromArray([
                $index + 1,
                $permit->application_date->format('d/m/Y'),
                $permit->ship_name,
                $permit->ship_type,
                $permit->user?->name ?? '-',
                $permit->user?->email ?? '-',
                $permit->upt?->name ?? '-',
                ucfirst($permit->status),
                $permit->passenger_count,
                $permit->gross_tonnage,
            ], null, 'A' . $row);
            $row++;
        }

        // Auto-size columns
        foreach (range('A', 'J') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $filename = 'Laporan_Bulanan_' . $monthYear . '.xlsx';

        $writer = new Xlsx($spreadsheet);

        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, $filename);
    }

    // ============================================
    // 🏢 UPT MANAGEMENT - UPDATED WITH ALL FIELDS
    // ============================================

    /**
     * Display UPT list
     */
    public function upts(Request $request)
    {
        $query = Upt::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%")
                  ->orWhere('region', 'like', "%{$search}%")
                  ->orWhere('kota', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        $upts = $query->withCount([
            'users as active_users_count' => function($q) {
                $q->where('role', 'user')->where('is_active', true);
            },
            'permits'
        ])->latest()->paginate(15)->withQueryString();

        return view('super-admin.upts.index', compact('upts'));
    }

    /**
     * Show create UPT form
     */
    public function createUpt()
    {
        return view('super-admin.upts.create');
    }

    /**
     * Store new UPT - ✅ WITH ALL FIELDS FROM MODEL
     */
    public function storeUpt(Request $request)
    {
        $validator = Validator::make($request->all(), [
            // Required fields
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:20', 'unique:upts,code'],
            'region' => ['required', 'string', 'max:100'],

            // Contact fields (optional)
            'alamat' => ['nullable', 'string', 'max:500'],
            'kota' => ['nullable', 'string', 'max:100'],
            'kode_pos' => ['nullable', 'string', 'max:10'],
            'telepon' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:255'],
            'website' => ['nullable', 'url', 'max:255'],
            'tgm' => ['nullable', 'string', 'max:50'],
            'tlx' => ['nullable', 'string', 'max:50'],
            'fax' => ['nullable', 'string', 'max:50'],

            // Kepala Kantor fields (optional)
            'kepala_kantor' => ['nullable', 'string', 'max:255'],
            'nip_kepala' => ['nullable', 'string', 'max:50'],

            // Status
            'is_active' => ['nullable', 'boolean'],
        ], [
            'name.required' => 'Nama UPT wajib diisi',
            'code.required' => 'Kode UPT wajib diisi',
            'code.unique' => 'Kode UPT sudah digunakan',
            'region.required' => 'Region/Wilayah wajib diisi',
            'email.email' => 'Format email tidak valid',
            'website.url' => 'Format website tidak valid',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Upt::create([
            'name' => $request->name,
            'code' => strtoupper($request->code),
            'region' => $request->region,
            'alamat' => $request->alamat,
            'kota' => $request->kota,
            'kode_pos' => $request->kode_pos,
            'telepon' => $request->telepon,
            'email' => $request->email,
            'website' => $request->website,
            'tgm' => $request->tgm,
            'tlx' => $request->tlx,
            'fax' => $request->fax,
            'kepala_kantor' => $request->kepala_kantor,
            'nip_kepala' => $request->nip_kepala,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('super-admin.upts.index')
            ->with('success', 'UPT berhasil ditambahkan!');
    }

    /**
     * Show edit UPT form
     */
    public function editUpt($id)
    {
        $upt = Upt::findOrFail($id);
        return view('super-admin.upts.edit', compact('upt'));
    }

    /**
     * Update UPT - ✅ WITH ALL FIELDS FROM MODEL
     */
    public function updateUpt(Request $request, $id)
    {
        $upt = Upt::findOrFail($id);

        $validator = Validator::make($request->all(), [
            // Required fields
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:20', Rule::unique('upts')->ignore($upt->id)],
            'region' => ['required', 'string', 'max:100'],

            // Contact fields (optional)
            'alamat' => ['nullable', 'string', 'max:500'],
            'kota' => ['nullable', 'string', 'max:100'],
            'kode_pos' => ['nullable', 'string', 'max:10'],
            'telepon' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:255'],
            'website' => ['nullable', 'url', 'max:255'],
            'tgm' => ['nullable', 'string', 'max:50'],
            'tlx' => ['nullable', 'string', 'max:50'],
            'fax' => ['nullable', 'string', 'max:50'],

            // Kepala Kantor fields (optional)
            'kepala_kantor' => ['nullable', 'string', 'max:255'],
            'nip_kepala' => ['nullable', 'string', 'max:50'],

            // Status
            'is_active' => ['nullable', 'boolean'],
        ], [
            'name.required' => 'Nama UPT wajib diisi',
            'code.required' => 'Kode UPT wajib diisi',
            'code.unique' => 'Kode UPT sudah digunakan',
            'region.required' => 'Region/Wilayah wajib diisi',
            'email.email' => 'Format email tidak valid',
            'website.url' => 'Format website tidak valid',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $upt->update([
            'name' => $request->name,
            'code' => strtoupper($request->code),
            'region' => $request->region,
            'alamat' => $request->alamat,
            'kota' => $request->kota,
            'kode_pos' => $request->kode_pos,
            'telepon' => $request->telepon,
            'email' => $request->email,
            'website' => $request->website,
            'tgm' => $request->tgm,
            'tlx' => $request->tlx,
            'fax' => $request->fax,
            'kepala_kantor' => $request->kepala_kantor,
            'nip_kepala' => $request->nip_kepala,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('super-admin.upts.index')
            ->with('success', 'UPT berhasil diperbarui!');
    }

    /**
     * Show UPT details - ✅ WITH PROPER STATS
     */
    public function showUpt($id)
    {
        $upt = Upt::findOrFail($id);

        // ✅ Statistik yang disesuaikan dengan UPT ini
        $stats = [
            'total_users' => User::where('upt_id', $upt->id)->where('role', 'user')->count(),
            'total_admins' => User::where('upt_id', $upt->id)->where('role', 'admin')->count(),
            'total_permits' => ShipPermit::where('upt_id', $upt->id)->count(),
            'pending_permits' => ShipPermit::where('upt_id', $upt->id)->where('status', 'pending')->count(),
            'approved_permits' => ShipPermit::where('upt_id', $upt->id)->where('status', 'approved')->count(),
            'rejected_permits' => ShipPermit::where('upt_id', $upt->id)->where('status', 'rejected')->count(),
        ];

        // ✅ Ambil 5 permohonan terbaru di UPT ini
        $recentPermits = ShipPermit::where('upt_id', $upt->id)
            ->with('user')
            ->latest()
            ->take(5)
            ->get();

        // ✅ Ambil 5 users terbaru di UPT ini
        $recentUsers = User::where('upt_id', $upt->id)
            ->where('role', 'user')
            ->latest()
            ->take(5)
            ->get();

        return view('super-admin.upts.show', compact('upt', 'stats', 'recentPermits', 'recentUsers'));
    }

    /**
     * Delete UPT
     */
    public function deleteUpt($id)
    {
        $upt = Upt::findOrFail($id);

        // Prevent deletion if UPT has users or permits
        if ($upt->users()->count() > 0 || $upt->permits()->count() > 0) {
            return redirect()->back()
                ->with('error', 'UPT tidak dapat dihapus karena masih memiliki user atau permohonan.');
        }

        $upt->delete();

        return redirect()->route('super-admin.upts.index')
            ->with('success', 'UPT berhasil dihapus!');
    }

    // ============================================
    // 👥 USER MANAGEMENT (WITH UPT SUPPORT)
    // ============================================

    /**
     * Display users list
     */
    public function users(Request $request)
    {
        $query = User::where('role', 'user');

        if ($request->filled('upt_id')) {
            $query->where('upt_id', $request->upt_id);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        $users = $query->with('upt')->latest()->paginate(15)->withQueryString();
        $upts = Upt::active()->orderBy('name')->get();

        return view('super-admin.users.index', compact('users', 'upts'));
    }

    /**
     * Show create user form
     */
    public function createUser()
    {
        $upts = Upt::active()->orderBy('name')->get();
        return view('super-admin.users.create', compact('upts'));
    }

    /**
     * Store new user
     */
    public function storeUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'upt_id' => ['required', 'exists:upts,id'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',
            'upt_id' => $request->upt_id,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('super-admin.users.index')
            ->with('success', 'User berhasil ditambahkan!');
    }

    /**
     * Show edit user form
     */
    public function editUser($id)
    {
        $user = User::with('upt')->findOrFail($id);

        if ($user->isSuperAdmin() || $user->id === auth()->id()) {
            abort(403, 'User ini tidak dapat diedit.');
        }

        $upts = Upt::active()->orderBy('name')->get();
        return view('super-admin.users.edit', compact('user', 'upts'));
    }

    /**
     * Update user
     */
    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if ($user->isSuperAdmin() || $user->id === auth()->id()) {
            abort(403, 'User ini tidak dapat diedit.');
        }

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'upt_id' => ['required', 'exists:upts,id'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
            'upt_id' => $request->upt_id,
            'is_active' => $request->boolean('is_active'),
        ];

        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        $user->update($updateData);

        return redirect()->route('super-admin.users.index')
            ->with('success', 'User berhasil diperbarui!');
    }

    /**
     * Delete user
     */
    public function deleteUser($id)
    {
        $user = User::findOrFail($id);

        if ($user->isSuperAdmin() || $user->id === auth()->id()) {
            abort(403, 'User ini tidak dapat dihapus.');
        }

        // Clean up related data
        $user->shipPermits()->delete();
        $user->notifications()->delete();
        PasswordResetRequest::where('email', $user->email)->delete();
        $user->delete();

        return redirect()->route('super-admin.users.index')
            ->with('success', 'User berhasil dihapus!');
    }

    /**
     * Toggle user active status
     */
    public function toggleUserStatus($id)
    {
        $user = User::findOrFail($id);

        if ($user->isSuperAdmin() || $user->id === auth()->id()) {
            abort(403, 'Status user ini tidak dapat diubah.');
        }

        $user->update(['is_active' => !$user->is_active]);

        return redirect()->back()
            ->with('success', 'Status user berhasil diubah!');
    }

    // ============================================
    // 👨‍💼 ADMIN UPT MANAGEMENT
    // ============================================

    /**
     * Display admins list
     */
    public function admins(Request $request)
    {
        $query = User::where('role', 'admin');

        if ($request->filled('upt_id')) {
            $query->where('upt_id', $request->upt_id);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $admins = $query->with('upt')->latest()->paginate(15)->withQueryString();
        $upts = Upt::active()->orderBy('name')->get();

        return view('super-admin.admins.index', compact('admins', 'upts'));
    }

    /**
     * Show create admin form
     */
    public function createAdmin()
    {
        $upts = Upt::active()->orderBy('name')->get();
        return view('super-admin.admins.create', compact('upts'));
    }

    /**
     * Store new admin
     */
    public function storeAdmin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'upt_id' => ['required', 'exists:upts,id'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin',
            'upt_id' => $request->upt_id,
            'is_active' => true,
        ]);

        return redirect()->route('super-admin.admins.index')
            ->with('success', 'Admin UPT berhasil ditambahkan!');
    }

    /**
     * Show edit admin form
     */
    public function editAdmin($id)
    {
        $admin = User::with('upt')->findOrFail($id);

        if ($admin->id === auth()->id()) {
            abort(403, 'Anda tidak dapat mengedit akun sendiri.');
        }

        $upts = Upt::active()->orderBy('name')->get();
        return view('super-admin.admins.edit', compact('admin', 'upts'));
    }

    /**
     * Update admin
     */
    public function updateAdmin(Request $request, $id)
    {
        $admin = User::findOrFail($id);

        if ($admin->id === auth()->id()) {
            abort(403, 'Anda tidak dapat mengedit akun sendiri.');
        }

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($admin->id)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'upt_id' => ['required', 'exists:upts,id'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
            'upt_id' => $request->upt_id,
        ];

        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        $admin->update($updateData);

        return redirect()->route('super-admin.admins.index')
            ->with('success', 'Admin UPT berhasil diperbarui!');
    }

    /**
     * Show admin details
     */
    public function showAdmin($id)
    {
        $admin = User::with('upt')->findOrFail($id);

        // Get statistics for this admin's UPT
        $stats = [
            'total_users' => User::where('upt_id', $admin->upt_id)->where('role', 'user')->count(),
            'total_permits' => ShipPermit::where('upt_id', $admin->upt_id)->count(),
            'pending_permits' => ShipPermit::where('upt_id', $admin->upt_id)->where('status', 'pending')->count(),
            'approved_permits' => ShipPermit::where('upt_id', $admin->upt_id)->where('status', 'approved')->count(),
            'rejected_permits' => ShipPermit::where('upt_id', $admin->upt_id)->where('status', 'rejected')->count(),
        ];

        $recentUsers = User::where('upt_id', $admin->upt_id)
            ->where('role', 'user')
            ->latest()
            ->take(5)
            ->get();

        $recentPermits = ShipPermit::where('upt_id', $admin->upt_id)
            ->with('user')
            ->latest()
            ->take(5)
            ->get();

        return view('super-admin.admins.show', compact(
            'admin',
            'stats',
            'recentUsers',
            'recentPermits'
        ));
    }

    /**
     * Delete admin
     */
    public function deleteAdmin($id)
    {
        $admin = User::findOrFail($id);

        if ($admin->id === auth()->id()) {
            abort(403, 'Anda tidak dapat menghapus akun sendiri.');
        }

        $admin->delete();

        return redirect()->route('super-admin.admins.index')
            ->with('success', 'Admin UPT berhasil dihapus!');
    }

    /**
     * Promote user to admin
     */
    public function promoteToAdmin($id)
    {
        $user = User::findOrFail($id);

        if ($user->isSuperAdmin() || $user->id === auth()->id()) {
            abort(403, 'User ini tidak dapat dipromosikan.');
        }

        $user->update(['role' => 'admin']);

        return redirect()->back()
            ->with('success', "User {$user->name} berhasil dipromosikan menjadi Admin!");
    }

    /**
     * Demote admin to user
     */
    public function demoteToUser($id)
    {
        $admin = User::findOrFail($id);

        if ($admin->id === auth()->id()) {
            abort(403, 'Anda tidak dapat mendemosikan akun sendiri.');
        }

        $admin->update(['role' => 'user']);

        return redirect()->back()
            ->with('success', "Admin {$admin->name} berhasil didemosikan menjadi User!");
    }

    // ============================================
    // 📊 PERMITS OVERVIEW
    // ============================================

    /**
     * Display permits list
     */
    public function permits(Request $request)
    {
        $query = ShipPermit::with(['user', 'upt']);

        if ($request->filled('upt_id')) {
            $query->where('upt_id', $request->upt_id);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('ship_type', 'like', "%{$search}%")
                  ->orWhere('ship_name', 'like', "%{$search}%")
                  ->orWhereHas('user', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $permits = $query->latest()->paginate(15)->withQueryString();
        $upts = Upt::active()->orderBy('name')->get();

        return view('super-admin.permits.index', compact('permits', 'upts'));
    }

    /**
     * Show permit detail
     */
    public function showPermit($id)
    {
        $permit = ShipPermit::with(['user', 'upt'])->findOrFail($id);
        return view('super-admin.permits.show', compact('permit'));
    }

    /**
     * Update permit status
     */
    public function updatePermitStatus(Request $request, $id)
    {
        $permit = ShipPermit::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'status' => ['required', Rule::in(['approved', 'rejected', 'pending'])],
            'admin_notes' => ['nullable', 'string', 'max:500'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $permit->update([
            'status' => $request->status,
            'admin_notes' => $request->admin_notes,
        ]);

        // Notify user if permit has user
        if ($permit->user) {
            $permit->user->notify(new \App\Notifications\PermitStatusUpdated(
                $permit,
                $request->status,
                $request->admin_notes
            ));
        }

        return redirect()->back()
            ->with('success', "Status permohonan berhasil diubah menjadi {$request->status}!");
    }

    /**
     * Delete permit
     */
    public function deletePermit($id)
    {
        $permit = ShipPermit::findOrFail($id);

        // Delete associated documents
        for ($i = 1; $i <= 7; $i++) {
            $field = "document_{$i}";
            if (!empty($permit->$field)) {
                Storage::disk('public')->delete($permit->$field);
            }
        }

        $permit->delete();

        return redirect()->back()
            ->with('success', 'Permohonan berhasil dihapus!');
    }

    // ============================================
    // ⚙️ SYSTEM SETTINGS
    // ============================================

    /**
     * Show system settings
     */
    public function settings()
    {
        $settings = [
            'app_name' => config('app.name', 'SPOG KAPAL'),
            'app_url' => config('app.url', env('APP_URL')),
            'mail_from_address' => config('mail.from.address', ''),
            'maintenance_mode' => file_exists(storage_path('framework/down')),
        ];

        return view('super-admin.settings.index', compact('settings'));
    }

    /**
     * Update system settings
     */
    public function updateSettings(Request $request)
    {
        return redirect()->back()
            ->with('success', 'Pengaturan sistem berhasil diperbarui!');
    }

    // ============================================
    // 📋 AUDIT LOGS
    // ============================================

    /**
     * Display audit logs
     */
    public function auditLogs(Request $request)
    {
        $logs = User::whereNotNull('last_login_at')
            ->orderBy('last_login_at', 'desc')
            ->paginate(20);

        return view('super-admin.logs.index', compact('logs'));
    }

    // ============================================
    // 📤 EXPORT FUNCTIONS
    // ============================================

    /**
     * Export users to Excel
     */
    public function exportUsers(Request $request)
    {
        $query = User::where('role', 'user');

        if ($request->filled('upt_id')) {
            $query->where('upt_id', $request->upt_id);
        }

        $users = $query->with('upt')->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->fromArray([
            ['ID', 'Nama', 'Email', 'UPT', 'Status', 'Terdaftar', 'Login Terakhir'],
        ], null, 'A1');

        $sheet->getStyle('A1:G1')->getFont()->setBold(true);

        $row = 2;
        foreach ($users as $user) {
            $sheet->fromArray([
                $user->id,
                $user->name,
                $user->email,
                $user->upt?->name ?? '-',
                $user->is_active ? 'Active' : 'Suspended',
                $user->created_at->format('d/m/Y H:i'),
                // ✅ FIXED: Parse to Carbon first if it's a string
                $user->last_login_at ? Carbon::parse($user->last_login_at)->format('d/m/Y H:i') : '-',
            ], null, "A{$row}");
            $row++;
        }

        foreach (range('A', 'G') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $filename = "Users_Export_" . now()->format('Ymd_His') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    /**
     * Export permits to PDF
     */
    public function exportPermitsPdf(Request $request)
    {
        $query = ShipPermit::with(['user', 'upt']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('upt_id')) {
            $query->where('upt_id', $request->upt_id);
        }

        $permits = $query->get();

        $data = [
            'title' => 'Laporan Semua Permohonan',
            'generated_at' => now()->format('d F Y H:i'),
            'permits' => $permits,
            'total' => $permits->count(),
            'filter' => [
                'status' => $request->status,
                'upt_id' => $request->upt_id ? Upt::find($request->upt_id)?->name : null,
            ],
        ];

        $pdf = Pdf::loadView('super-admin.exports.permits-pdf', $data)
            ->setPaper('a4', 'landscape')
            ->setOption('isHtml5ParserEnabled', true);

        return $pdf->download('Laporan_Permohonan_' . now()->format('Ymd') . '.pdf');
    }
}
