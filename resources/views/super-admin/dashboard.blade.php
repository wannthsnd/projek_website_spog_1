@extends('layouts.app')
@section('title', 'Super Admin Dashboard')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-100 via-slate-50 to-blue-50/40 dark:from-slate-950 dark:via-slate-900 dark:to-slate-950 transition-colors duration-500">

    <!-- ✨ Subtle Ocean Wave Background - Lightweight -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none" aria-hidden="true">
        <svg class="absolute inset-0 w-full h-full opacity-[0.03] dark:opacity-[0.05]" viewBox="0 0 1440 800" preserveAspectRatio="none">
            <path fill="currentColor" class="text-slate-900 dark:text-white" d="M0,256L48,272C96,288,192,320,288,314.7C384,309,480,267,576,261.3C672,256,768,288,864,304C960,320,1056,320,1152,298.7C1248,277,1344,235,1392,213.3L1440,192L1440,800L1392,800C1344,800,1248,800,1152,800C1056,800,960,800,864,800C768,800,672,800,576,800C480,800,384,800,288,800C192,800,96,800,48,800L0,800Z"></path>
        </svg>
        <div class="absolute top-0 right-0 w-96 h-96 bg-blue-900/5 dark:bg-blue-500/5 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-80 h-80 bg-cyan-900/5 dark:bg-cyan-500/5 rounded-full blur-3xl"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8">

        <!-- ✨ Elegant Header - Navy Professional -->
        <header class="mb-8">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5">
                <div class="flex items-center gap-4">
                    <div class="relative group">
                        <div class="absolute inset-0 bg-gradient-to-br from-blue-900 to-slate-800 rounded-2xl blur-xl opacity-50 group-hover:opacity-70 transition-opacity duration-300"></div>
                        <div class="relative w-14 h-14 bg-gradient-to-br from-blue-800 to-slate-700 rounded-2xl flex items-center justify-center shadow-lg shadow-blue-900/30 group-hover:shadow-blue-900/50 group-hover:scale-105 transition-all duration-300 border border-blue-700/30">
                            <i class="bi bi-shield-check text-xl text-white"></i>
                        </div>
                    </div>
                    <div>
                        <h1 class="text-xl sm:text-2xl font-bold text-slate-900 dark:text-white">
                            Super Admin Dashboard
                        </h1>
                        <p class="text-slate-600 dark:text-slate-400 text-sm flex items-center gap-2 mt-0.5">
                            <span class="w-1.5 h-1.5 bg-blue-600 rounded-full animate-pulse"></span>
                            <span class="font-medium">Sistem SPOG KAPAL</span> • Kontrol Penuh
                        </p>
                    </div>
                </div>

                <!-- ✨ Premium Admin Badge - Navy Style -->
                <div class="flex items-center gap-2.5 px-4 py-2 bg-gradient-to-r from-blue-800 to-slate-700 text-white rounded-xl text-sm font-semibold shadow-lg shadow-blue-900/30 hover:shadow-blue-900/50 transition-shadow duration-300 border border-blue-700/30">
                    <i class="bi bi-shield-lock"></i>
                    <span>Super Admin</span>
                    <span class="ml-1 px-2 py-0.5 bg-blue-600/40 rounded-lg text-xs font-bold backdrop-blur-sm border border-blue-500/30">● Active</span>
                </div>
            </div>
        </header>

        <!-- ✨ Stats Grid - Professional Navy Cards -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            <!-- Total Users -->
            <a href="{{ route('super-admin.users.index') }}" class="group relative bg-white/90 dark:bg-slate-800/90 backdrop-blur-md rounded-2xl p-5 border border-slate-200/80 dark:border-slate-700/80 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-0.5 bg-gradient-to-r from-blue-600 to-blue-800"></div>
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold text-slate-500 dark:text-slate-400 mb-1.5 uppercase tracking-wider">Total Users</p>
                        <p class="text-2xl font-bold text-slate-900 dark:text-white tabular-nums">
                            {{ number_format($stats['total_users'] ?? 0) }}
                        </p>
                        <p class="text-xs text-blue-600 dark:text-blue-400 mt-1.5 flex items-center gap-1 font-medium">
                            <i class="bi bi-arrow-up-short"></i>
                            <span>+12% bulan ini</span>
                        </p>
                    </div>
                    <div class="w-11 h-11 bg-blue-50 dark:bg-blue-900/40 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300 border border-blue-100 dark:border-blue-800/50">
                        <i class="bi bi-people text-blue-600 dark:text-blue-400 text-lg"></i>
                    </div>
                </div>
            </a>

            <!-- Total Admins -->
            <a href="{{ route('super-admin.admins.index') }}" class="group relative bg-white/90 dark:bg-slate-800/90 backdrop-blur-md rounded-2xl p-5 border border-slate-200/80 dark:border-slate-700/80 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-0.5 bg-gradient-to-r from-slate-600 to-slate-800"></div>
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold text-slate-500 dark:text-slate-400 mb-1.5 uppercase tracking-wider">Total Admins</p>
                        <p class="text-2xl font-bold text-slate-900 dark:text-white tabular-nums">
                            {{ number_format($stats['total_admins'] ?? 0) }}
                        </p>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1.5">
                            <span class="font-semibold text-blue-600 dark:text-blue-400">{{ number_format($stats['active_admins'] ?? 0) }}</span> aktif
                        </p>
                    </div>
                    <div class="w-11 h-11 bg-slate-50 dark:bg-slate-700/50 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300 border border-slate-200 dark:border-slate-600/50">
                        <i class="bi bi-person-gear text-slate-600 dark:text-slate-400 text-lg"></i>
                    </div>
                </div>
            </a>

            <!-- Total Permits -->
            <a href="{{ route('super-admin.permits.index') }}" class="group relative bg-white/90 dark:bg-slate-800/90 backdrop-blur-md rounded-2xl p-5 border border-slate-200/80 dark:border-slate-700/80 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-0.5 bg-gradient-to-r from-cyan-600 to-teal-700"></div>
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold text-slate-500 dark:text-slate-400 mb-1.5 uppercase tracking-wider">Total Permohonan</p>
                        <p class="text-2xl font-bold text-slate-900 dark:text-white tabular-nums">
                            {{ number_format($stats['total_permits'] ?? 0) }}
                        </p>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1.5">
                            <span class="font-semibold text-cyan-600 dark:text-cyan-400">{{ number_format($stats['approved_permits'] ?? 0) }}</span> disetujui
                        </p>
                    </div>
                    <div class="w-11 h-11 bg-cyan-50 dark:bg-cyan-900/40 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300 border border-cyan-100 dark:border-cyan-800/50">
                        <i class="bi bi-folder-check text-cyan-600 dark:text-cyan-400 text-lg"></i>
                    </div>
                </div>
            </a>

            <!-- Pending Permits - Coral Accent -->
            <a href="{{ route('super-admin.permits.index') }}?status=pending" class="group relative bg-white/90 dark:bg-slate-800/90 backdrop-blur-md rounded-2xl p-5 border border-slate-200/80 dark:border-slate-700/80 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-0.5 bg-gradient-to-r from-rose-500 to-coral-600"></div>
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold text-slate-500 dark:text-slate-400 mb-1.5 uppercase tracking-wider">Menunggu</p>
                        <p class="text-2xl font-bold text-rose-600 dark:text-rose-400 tabular-nums">
                            {{ number_format($stats['pending_permits'] ?? 0) }}
                        </p>
                        @if(($stats['pending_permits'] ?? 0) > 0)
                        <div class="mt-1.5 flex items-center gap-1.5">
                            <span class="w-2 h-2 bg-rose-500 rounded-full animate-pulse"></span>
                            <span class="text-xs font-semibold text-rose-600 dark:text-rose-400">Perlu perhatian</span>
                        </div>
                        @endif
                    </div>
                    <div class="w-11 h-11 bg-rose-50 dark:bg-rose-900/40 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300 border border-rose-100 dark:border-rose-800/50">
                        <i class="bi bi-clock-history text-rose-600 dark:text-rose-400 text-lg"></i>
                    </div>
                </div>
            </a>
        </div>

        <!-- ✨ Quick Report Card - Navy Premium -->
        <div class="mb-8">
            <a href="{{ route('super-admin.reports.monthly') }}" class="group relative block bg-gradient-to-br from-blue-900 via-slate-800 to-slate-900 rounded-2xl p-6 shadow-xl shadow-blue-900/30 hover:shadow-2xl hover:shadow-blue-900/50 transition-all duration-400 hover:-translate-y-1 overflow-hidden border border-blue-700/30">
                <!-- Subtle Pattern Overlay -->
                <div class="absolute inset-0 opacity-10" style="background-image: url(\"data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.4'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E\");"></div>

                <div class="relative flex flex-col sm:flex-row sm:items-center sm:justify-between gap-5">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 bg-blue-700/40 backdrop-blur-md rounded-xl flex items-center justify-center border border-blue-500/40 shadow-lg">
                            <i class="bi bi-bar-chart-line-fill text-2xl text-white"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-white">📊 Laporan Bulanan</h3>
                            <p class="text-blue-200 text-sm mt-0.5">Analisis statistik lengkap & ekspor data</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        <div class="flex items-center gap-2.5 px-4 py-2 bg-blue-700/40 backdrop-blur-md rounded-xl border border-blue-500/40">
                            <span class="text-base font-bold text-white tabular-nums">{{ number_format($stats['total_permits'] ?? 0) }}</span>
                            <span class="text-sm text-blue-200">Permohonan</span>
                        </div>
                        <div class="flex items-center gap-2 px-4 py-2.5 bg-white text-blue-800 rounded-xl font-bold shadow-lg group-hover:shadow-xl transition-all group-hover:scale-105">
                            <span>Lihat</span>
                            <i class="bi bi-arrow-right text-sm group-hover:translate-x-1 transition-transform"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- ✨ Quick Actions - Clean Professional Grid -->
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3 mb-8">
            @php
            $actions = [
                ['route' => 'super-admin.upts.create', 'icon' => 'bi-building', 'label' => 'Tambah UPT', 'color' => 'blue'],
                ['route' => 'super-admin.users.create', 'icon' => 'bi-person-plus', 'label' => 'Tambah User', 'color' => 'blue'],
                ['route' => 'super-admin.admins.create', 'icon' => 'bi-person-gear', 'label' => 'Tambah Admin', 'color' => 'slate'],
                ['route' => 'super-admin.permits.index', 'query' => '?status=pending', 'icon' => 'bi-clock-history', 'label' => 'Pending', 'color' => 'rose'],
                ['route' => 'super-admin.upts.index', 'icon' => 'bi-list', 'label' => 'Kelola UPT', 'color' => 'cyan'],
                ['route' => 'super-admin.export.users.excel', 'icon' => 'bi-file-earmark-excel', 'label' => 'Export', 'color' => 'emerald'],
            ];
            @endphp

            @foreach($actions as $action)
            <a href="{{ route($action['route']) }}{{ $action['query'] ?? '' }}"
               class="group flex flex-col items-center gap-2.5 p-4 bg-white/90 dark:bg-slate-800/90 backdrop-blur-md rounded-xl border border-slate-200/80 dark:border-slate-700/80 hover:border-{{ $action['color'] }}-400/60 dark:hover:border-{{ $action['color'] }}-500/60 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200">
                <div class="w-11 h-11 bg-{{ $action['color'] }}-50 dark:bg-{{ $action['color'] }}-900/40 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-200 border border-{{ $action['color'] }}-100 dark:border-{{ $action['color'] }}-800/50">
                    <i class="bi {{ $action['icon'] }} text-{{ $action['color'] }}-600 dark:text-{{ $action['color'] }}-400 text-base"></i>
                </div>
                <span class="text-xs font-semibold text-slate-700 dark:text-slate-300 text-center group-hover:text-{{ $action['color'] }}-600 dark:group-hover:text-{{ $action['color'] }}-400 transition-colors leading-tight">
                    {{ $action['label'] }}
                </span>
            </a>
            @endforeach
        </div>

        <!-- ✨ Charts Section - Professional Clean -->
        <div class="space-y-6 mb-8">
            <!-- Permit Status Chart -->
            <div class="bg-white/90 dark:bg-slate-800/90 backdrop-blur-md rounded-2xl border border-slate-200/80 dark:border-slate-700/80 shadow-sm p-5">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-semibold text-slate-900 dark:text-white flex items-center gap-2.5">
                        <div class="w-8 h-8 bg-blue-50 dark:bg-blue-900/40 rounded-xl flex items-center justify-center border border-blue-100 dark:border-blue-800/50">
                            <i class="bi bi-pie-chart-fill text-blue-600 dark:text-blue-400 text-sm"></i>
                        </div>
                        Status Permohonan
                    </h3>
                    <span class="px-2.5 py-1 bg-blue-50/90 dark:bg-blue-900/40 text-blue-700 dark:text-blue-300 text-xs font-semibold rounded-lg backdrop-blur-sm border border-blue-200/50 dark:border-blue-700/50">Real-time</span>
                </div>
                <div class="h-60">
                    <div id="permitStatusChart"></div>
                </div>
            </div>

            <!-- User Growth Chart -->
            <div class="bg-white/90 dark:bg-slate-800/90 backdrop-blur-md rounded-2xl border border-slate-200/80 dark:border-slate-700/80 shadow-sm p-5">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-semibold text-slate-900 dark:text-white flex items-center gap-2.5">
                        <div class="w-8 h-8 bg-cyan-50 dark:bg-cyan-900/40 rounded-xl flex items-center justify-center border border-cyan-100 dark:border-cyan-800/50">
                            <i class="bi bi-people-fill text-cyan-600 dark:text-cyan-400 text-sm"></i>
                        </div>
                        Pertumbuhan User
                    </h3>
                    <span class="px-2.5 py-1 bg-cyan-50/90 dark:bg-cyan-900/40 text-cyan-700 dark:text-cyan-300 text-xs font-semibold rounded-lg backdrop-blur-sm border border-cyan-200/50 dark:border-cyan-700/50">6 Bulan</span>
                </div>
                <div class="h-60">
                    <div id="userGrowthChart"></div>
                </div>
            </div>

            <!-- Permit Trend Chart -->
            <div class="bg-white/90 dark:bg-slate-800/90 backdrop-blur-md rounded-2xl border border-slate-200/80 dark:border-slate-700/80 shadow-sm p-5">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-semibold text-slate-900 dark:text-white flex items-center gap-2.5">
                        <div class="w-8 h-8 bg-emerald-50 dark:bg-emerald-900/40 rounded-xl flex items-center justify-center border border-emerald-100 dark:border-emerald-800/50">
                            <i class="bi bi-graph-up-arrow text-emerald-600 dark:text-emerald-400 text-sm"></i>
                        </div>
                        Tren Permohonan
                    </h3>
                    <span class="px-2.5 py-1 bg-emerald-50/90 dark:bg-emerald-900/40 text-emerald-700 dark:text-emerald-300 text-xs font-semibold rounded-lg backdrop-blur-sm border border-emerald-200/50 dark:border-emerald-700/50">6 Bulan</span>
                </div>
                <div class="h-64">
                    <div id="permitTrendChart"></div>
                </div>
            </div>
        </div>

        <!-- ✨ Recent Activity - Clean Professional Lists -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 mb-8">
            <!-- Recent Users -->
            <div class="bg-white/90 dark:bg-slate-800/90 backdrop-blur-md rounded-2xl border border-slate-200/80 dark:border-slate-700/80 shadow-sm overflow-hidden">
                <div class="px-5 py-4 border-b border-slate-200/80 dark:border-slate-700/80 bg-gradient-to-r from-blue-50/80 to-slate-50/60 dark:from-blue-900/30 dark:to-slate-800/50">
                    <h3 class="text-sm font-semibold text-slate-900 dark:text-white">User Terbaru</h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">5 pendaftar terakhir</p>
                </div>
                <div class="p-3 space-y-2">
                    @forelse($recentUsers ?? [] as $user)
                    <div class="flex items-center gap-3 p-3 bg-slate-50/70 dark:bg-slate-700/50 rounded-xl hover:bg-blue-50/80 dark:hover:bg-blue-900/30 transition-colors duration-200 border border-transparent hover:border-blue-200/50 dark:hover:border-blue-700/50">
                        <div class="w-9 h-9 bg-blue-100 dark:bg-blue-900/50 rounded-xl flex items-center justify-center text-blue-600 dark:text-blue-400 text-sm font-bold border border-blue-200/50 dark:border-blue-800/50">
                            {{ substr($user->name, 0, 1) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-slate-900 dark:text-white truncate">{{ $user->name }}</p>
                            <p class="text-xs text-slate-500 dark:text-slate-400 truncate">{{ $user->email }}</p>
                        </div>
                        <span class="text-xs text-slate-400 font-medium whitespace-nowrap">{{ $user->created_at->diffForHumans(short: true) }}</span>
                    </div>
                    @empty
                    <p class="text-center py-8 text-slate-500 dark:text-slate-400 text-sm">Belum ada user</p>
                    @endforelse
                </div>
                <div class="px-5 py-3 border-t border-slate-200/80 dark:border-slate-700/80">
                    <a href="{{ route('super-admin.users.index') }}" class="text-xs font-semibold text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 flex items-center gap-1.5 transition-colors">
                        Lihat semua <i class="bi bi-arrow-right text-xs"></i>
                    </a>
                </div>
            </div>

            <!-- Recent Permits -->
            <div class="bg-white/90 dark:bg-slate-800/90 backdrop-blur-md rounded-2xl border border-slate-200/80 dark:border-slate-700/80 shadow-sm overflow-hidden">
                <div class="px-5 py-4 border-b border-slate-200/80 dark:border-slate-700/80 bg-gradient-to-r from-cyan-50/80 to-teal-50/60 dark:from-cyan-900/30 dark:to-teal-900/20">
                    <h3 class="text-sm font-semibold text-slate-900 dark:text-white">Permohonan Terbaru</h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">5 terakhir</p>
                </div>
                <div class="p-3 space-y-2">
                    @forelse($recentPermits ?? [] as $permit)
                    <div class="flex items-center gap-3 p-3 bg-slate-50/70 dark:bg-slate-700/50 rounded-xl hover:bg-cyan-50/80 dark:hover:bg-cyan-900/30 transition-colors duration-200 border border-transparent hover:border-cyan-200/50 dark:hover:border-cyan-700/50">
                        <div class="w-9 h-9 bg-cyan-100 dark:bg-cyan-900/50 rounded-xl flex items-center justify-center border border-cyan-200/50 dark:border-cyan-800/50">
                            <i class="bi bi-ship text-cyan-600 dark:text-cyan-400 text-sm"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-slate-900 dark:text-white truncate">{{ $permit->ship_type }}</p>
                            <p class="text-xs text-slate-500 dark:text-slate-400 truncate">{{ $permit->user?->name ?? 'Unknown' }}</p>
                        </div>
                        <span class="px-2.5 py-1 {{ $permit->status_badge ?? 'bg-slate-100 text-slate-700 dark:bg-slate-700 dark:text-slate-300' }} text-xs font-semibold rounded-lg whitespace-nowrap">
                            {{ ucfirst($permit->status) }}
                        </span>
                    </div>
                    @empty
                    <p class="text-center py-8 text-slate-500 dark:text-slate-400 text-sm">Belum ada permohonan</p>
                    @endforelse
                </div>
                <div class="px-5 py-3 border-t border-slate-200/80 dark:border-slate-700/80">
                    <a href="{{ route('super-admin.permits.index') }}" class="text-xs font-semibold text-cyan-600 dark:text-cyan-400 hover:text-cyan-700 dark:hover:text-cyan-300 flex items-center gap-1.5 transition-colors">
                        Lihat semua <i class="bi bi-arrow-right text-xs"></i>
                    </a>
                </div>
            </div>

            <!-- Recent Logins -->
            <div class="bg-white/90 dark:bg-slate-800/90 backdrop-blur-md rounded-2xl border border-slate-200/80 dark:border-slate-700/80 shadow-sm overflow-hidden">
                <div class="px-5 py-4 border-b border-slate-200/80 dark:border-slate-700/80 bg-gradient-to-r from-emerald-50/80 to-lime-50/60 dark:from-emerald-900/30 dark:to-lime-900/20">
                    <h3 class="text-sm font-semibold text-slate-900 dark:text-white">Login Terbaru</h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">5 terakhir</p>
                </div>
                <div class="p-3 space-y-2">
                    @forelse($recentLogins ?? [] as $user)
                    <div class="flex items-center gap-3 p-3 bg-slate-50/70 dark:bg-slate-700/50 rounded-xl hover:bg-emerald-50/80 dark:hover:bg-emerald-900/30 transition-colors duration-200 border border-transparent hover:border-emerald-200/50 dark:hover:border-emerald-700/50">
                        <div class="w-9 h-9 bg-emerald-100 dark:bg-emerald-900/50 rounded-xl flex items-center justify-center text-emerald-600 dark:text-emerald-400 text-sm font-bold border border-emerald-200/50 dark:border-emerald-800/50">
                            {{ substr($user->name, 0, 1) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-slate-900 dark:text-white truncate">{{ $user->name }}</p>
                            <p class="text-xs text-slate-500 dark:text-slate-400">{{ ucfirst($user->role) }}</p>
                        </div>
                        <span class="text-xs text-slate-400 font-medium whitespace-nowrap">
                            {{ $user->last_login_at ? \Carbon\Carbon::parse($user->last_login_at)->diffForHumans(short: true) : '-' }}
                        </span>
                    </div>
                    @empty
                    <p class="text-center py-8 text-slate-500 dark:text-slate-400 text-sm">Belum ada aktivitas</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- ✨ UPT Statistics Table - Clean Professional -->
        @if(isset($upts) && $upts->count() > 0)
        <div class="bg-white/90 dark:bg-slate-800/90 backdrop-blur-md rounded-2xl border border-slate-200/80 dark:border-slate-700/80 shadow-sm overflow-hidden mb-8">
            <div class="px-5 py-4 border-b border-slate-200/80 dark:border-slate-700/80 bg-gradient-to-r from-slate-50/80 to-blue-50/60 dark:from-slate-700/50 dark:to-blue-900/30 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 bg-blue-50 dark:bg-blue-900/40 rounded-xl flex items-center justify-center border border-blue-100 dark:border-blue-800/50">
                        <i class="bi bi-building text-blue-600 dark:text-blue-400"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-slate-900 dark:text-white">Statistik UPT</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Distribusi per wilayah</p>
                    </div>
                </div>
                <a href="{{ route('super-admin.upts.index') }}" class="text-xs font-semibold text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 flex items-center gap-1.5 transition-colors">
                    Lihat semua <i class="bi bi-arrow-right text-xs"></i>
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-50/90 dark:bg-slate-700/60">
                        <tr>
                            <th class="px-5 py-3.5 text-left text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">UPT</th>
                            <th class="px-5 py-3.5 text-left text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Kode</th>
                            <th class="px-5 py-3.5 text-center text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Users</th>
                            <th class="px-5 py-3.5 text-center text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Admins</th>
                            <th class="px-5 py-3.5 text-center text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Permohonan</th>
                            <th class="px-5 py-3.5 text-center text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200/80 dark:divide-slate-700/80">
                        @foreach($upts as $upt)
                        <tr class="hover:bg-blue-50/60 dark:hover:bg-blue-900/30 transition-colors duration-150">
                            <td class="px-5 py-4">
                                <p class="text-sm font-semibold text-slate-900 dark:text-white">{{ $upt->name }}</p>
                                @if($upt->email)<p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">{{ $upt->email }}</p>@endif
                            </td>
                            <td class="px-5 py-4">
                                <span class="inline-flex items-center px-3 py-1.5 bg-blue-50 dark:bg-blue-900/40 text-blue-700 dark:text-blue-300 text-xs font-mono font-semibold rounded-lg backdrop-blur-sm border border-blue-200/50 dark:border-blue-700/50">
                                    {{ $upt->code }}
                                </span>
                            </td>
                            <td class="px-5 py-4 text-center">
                                <span class="inline-flex items-center justify-center w-8 h-8 bg-blue-100 dark:bg-blue-900/40 text-blue-700 dark:text-blue-300 text-xs font-bold rounded-lg border border-blue-200/50 dark:border-blue-800/50">
                                    {{ $upt->users_count ?? 0 }}
                                </span>
                            </td>
                            <td class="px-5 py-4 text-center">
                                <span class="inline-flex items-center justify-center w-8 h-8 bg-emerald-100 dark:bg-emerald-900/40 text-emerald-700 dark:text-emerald-300 text-xs font-bold rounded-lg border border-emerald-200/50 dark:border-emerald-800/50">
                                    {{ $upt->admins_count ?? 0 }}
                                </span>
                            </td>
                            <td class="px-5 py-4 text-center text-sm font-semibold text-slate-900 dark:text-white tabular-nums">{{ $upt->permits_count ?? 0 }}</td>
                            <td class="px-5 py-4 text-center">
                                @if($upt->is_active)
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-50 dark:bg-emerald-900/40 text-emerald-700 dark:text-emerald-300 text-xs font-semibold rounded-lg backdrop-blur-sm border border-emerald-200/50 dark:border-emerald-700/50">
                                    <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                                    Aktif
                                </span>
                                @else
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 text-xs font-semibold rounded-lg">
                                    <span class="w-2 h-2 bg-slate-400 rounded-full"></span>
                                    Nonaktif
                                </span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif

        <!-- ✨ Clean Footer -->
        <footer class="text-center text-slate-400 dark:text-slate-500 text-xs py-5">
            <p class="flex items-center justify-center gap-2">
                <span>&copy; {{ date('Y') }} SPOG KAPAL</span>
                <span class="text-slate-300 dark:text-slate-600">•</span>
                <span>Super Admin Panel</span>
                <span class="text-slate-300 dark:text-slate-600">•</span>
                <span class="text-blue-600 dark:text-blue-400 font-semibold">v2.0</span>
            </p>
        </footer>

    </div>
</div>

<!-- ApexCharts Library -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const isDark = document.documentElement.classList.contains('dark');
    const textColor = isDark ? '#94a3b8' : '#64748b';
    const gridColor = isDark ? '#334155' : '#e2e8f0';

    // ✨ Professional Navy Theme Colors
    const chartColors = {
        primary: isDark ? '#60a5fa' : '#2563eb',    // Blue-500/600
        secondary: isDark ? '#22d3ee' : '#06b6d4',  // Cyan-400/500
        accent: isDark ? '#fb7185' : '#f43f5e',     // Rose-400/500
        success: isDark ? '#34d399' : '#10b981',    // Emerald-400/500
        warning: isDark ? '#fbbf24' : '#f59e0b',    // Amber-400/500
        neutral: isDark ? '#64748b' : '#94a3b8'     // Slate-500
    };

    // Permit Status Chart - Professional Donut
    const permitStatusData = @json($permitStatusData ?? ['labels' => [], 'values' => []]);
    const statusChartEl = document.querySelector('#permitStatusChart');

    if (statusChartEl) {
        const hasData = permitStatusData.values && permitStatusData.values.some(v => parseInt(v) > 0);
        const colors = hasData ? [chartColors.primary, chartColors.success, chartColors.accent] : [chartColors.neutral];

        new ApexCharts(statusChartEl, {
            series: hasData ? permitStatusData.values.map(v => parseInt(v) || 0) : [1],
            labels: hasData ? permitStatusData.labels : ['No Data'],
            chart: {
                type: 'donut',
                height: 240,
                fontFamily: 'inherit',
                foreColor: textColor,
                toolbar: { show: false },
                animations: { enabled: true, speed: 400 }
            },
            colors: colors,
            stroke: { width: 0 },
            dataLabels: { enabled: false },
            legend: {
                position: 'bottom',
                fontSize: '11px',
                fontWeight: 500,
                markers: { radius: 4, size: 9 },
                offsetY: 5,
                itemMargin: { horizontal: 6 }
            },
            plotOptions: {
                pie: {
                    donut: {
                        size: '75%',
                        labels: {
                            show: true,
                            total: {
                                show: true,
                                label: 'Total',
                                fontSize: '11px',
                                fontWeight: 600,
                                color: textColor,
                                formatter: () => hasData ? permitStatusData.values.reduce((a, b) => parseInt(a) + parseInt(b), 0) : 0
                            },
                            value: {
                                show: hasData,
                                fontSize: '20px',
                                fontWeight: 700,
                                color: isDark ? '#f1f5f9' : '#0f172a'
                            }
                        }
                    }
                }
            },
            tooltip: {
                theme: isDark ? 'dark' : 'light',
                style: { fontSize: '11px' },
                y: { formatter: (val) => val.toLocaleString('id-ID') + ' permohonan' }
            }
        }).render();
    }

    // User Growth Chart - Clean Area
    const userGrowthData = @json($userGrowthData ?? ['labels' => [], 'values' => []]);
    const growthChartEl = document.querySelector('#userGrowthChart');

    if (growthChartEl && userGrowthData.labels && userGrowthData.labels.length > 0) {
        new ApexCharts(growthChartEl, {
            series: [{
                name: 'User Baru',
                data: userGrowthData.values.map(v => parseInt(v) || 0)
            }],
            chart: {
                type: 'area',
                height: 240,
                fontFamily: 'inherit',
                foreColor: textColor,
                toolbar: { show: false },
                animations: { enabled: true, speed: 400 }
            },
            colors: [chartColors.primary],
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.35,
                    opacityTo: 0.05,
                    stops: [0, 60, 100]
                }
            },
            stroke: { curve: 'smooth', width: 2.5 },
            dataLabels: { enabled: false },
            markers: { size: 3.5, colors: ['#fff'], strokeColors: chartColors.primary, strokeWidth: 2 },
            xaxis: {
                categories: userGrowthData.labels,
                axisBorder: { show: false },
                axisTicks: { show: false },
                labels: { style: { fontSize: '10px', colors: textColor } }
            },
            yaxis: {
                labels: { style: { fontSize: '10px', colors: textColor } },
                tickAmount: 4,
                min: 0
            },
            grid: { borderColor: gridColor, strokeDashArray: 3, padding: { left: 0, right: 0, top: 0 } },
            tooltip: { theme: isDark ? 'dark' : 'light', style: { fontSize: '11px' } }
        }).render();
    }

    // Permit Trend Chart - Professional Multi-line
    const permitTrendData = @json($permitTrendData ?? ['labels' => [], 'datasets' => []]);
    const trendChartEl = document.querySelector('#permitTrendChart');

    if (trendChartEl && permitTrendData.labels && permitTrendData.labels.length > 0) {
        const datasets = permitTrendData.datasets || [];
        const colors = datasets.map(ds => ds.color || chartColors.primary);

        new ApexCharts(trendChartEl, {
            series: datasets.map(ds => ({
                name: ds.label,
                data: (ds.data || []).map(v => parseInt(v) || 0)
            })),
            chart: {
                type: 'line',
                height: 256,
                fontFamily: 'inherit',
                foreColor: textColor,
                toolbar: { show: false },
                animations: { enabled: true, speed: 400 }
            },
            colors: colors.length ? colors : [chartColors.primary, chartColors.secondary, chartColors.success],
            stroke: { curve: 'smooth', width: 2.5 },
            fill: { opacity: 1 },
            dataLabels: { enabled: false },
            markers: { size: 3.5, colors: ['#fff'], strokeColors: colors, strokeWidth: 2 },
            xaxis: {
                categories: permitTrendData.labels,
                axisBorder: { show: false },
                axisTicks: { show: false },
                labels: { style: { fontSize: '10px', colors: textColor } }
            },
            yaxis: {
                labels: { style: { fontSize: '10px', colors: textColor } },
                tickAmount: 4,
                min: 0
            },
            grid: { borderColor: gridColor, strokeDashArray: 3, padding: { left: 0, right: 0, top: 0 } },
            tooltip: { theme: isDark ? 'dark' : 'light', style: { fontSize: '11px' } },
            legend: {
                show: true,
                position: 'top',
                horizontalAlign: 'center',
                fontSize: '10px',
                fontWeight: 500,
                offsetY: -5,
                markers: { radius: 4, size: 9 }
            }
        }).render();
    }
});
</script>

<!-- ✨ Lightweight Custom Styles -->
<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
body { font-family: 'Inter', system-ui, -apple-system, sans-serif; }
* { scroll-behavior: smooth; }

/* Minimal Scrollbar */
::-webkit-scrollbar { width: 5px; height: 5px; }
::-webkit-scrollbar-track { background: transparent; }
::-webkit-scrollbar-thumb {
    background: rgba(37, 99, 235, 0.3);
    border-radius: 3px;
}
::-webkit-scrollbar-thumb:hover { background: rgba(37, 99, 235, 0.5); }

/* Focus Accessibility */
a:focus-visible, button:focus-visible {
    outline: 2px solid rgba(37, 99, 235, 0.5);
    outline-offset: 2px;
}

/* Utilities */
.tabular-nums { font-variant-numeric: tabular-nums; }

/* Mobile Responsive */
@media (max-width: 640px) {
    .grid-cols-2, .grid-cols-4 { grid-template-columns: repeat(2, 1fr); }
    .lg\\:grid-cols-3, .lg\\:grid-cols-4 { grid-template-columns: repeat(2, 1fr); }
    .lg\\:grid-cols-6 { grid-template-columns: repeat(3, 1fr); }
}

/* Reduced Motion */
@media (prefers-reduced-motion: reduce) {
    *, *::before, *::after {
        animation-duration: 0.01ms !important;
        transition-duration: 0.01ms !important;
    }
}
</style>
@endsection
