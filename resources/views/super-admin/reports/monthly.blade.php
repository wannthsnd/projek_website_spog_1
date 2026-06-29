@extends('layouts.app')
@section('title', 'Laporan Bulanan - Super Admin')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50/30 to-indigo-50/30 dark:from-slate-900 dark:via-slate-800 dark:to-slate-900 transition-colors duration-300 py-6 sm:py-8">

    <!-- Animated Background Elements -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-40 -right-40 w-96 h-96 bg-purple-400/10 dark:bg-purple-600/5 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute top-1/2 -left-40 w-80 h-80 bg-blue-400/10 dark:bg-blue-600/5 rounded-full blur-3xl animate-pulse" style="animation-delay: 1.5s;"></div>
        <div class="absolute bottom-0 right-1/4 w-72 h-72 bg-indigo-400/10 dark:bg-indigo-600/5 rounded-full blur-3xl animate-pulse" style="animation-delay: 3s;"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Header Section - Modern & Elegant -->
        <div class="mb-8">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5">
                <div class="flex items-center gap-4">
                    <div class="relative group">
                        <div class="absolute inset-0 bg-gradient-to-br from-purple-500 to-blue-500 rounded-2xl blur-lg opacity-40 group-hover:opacity-60 transition-opacity"></div>
                        <div class="relative w-14 h-14 bg-gradient-to-br from-purple-600 to-blue-600 rounded-2xl flex items-center justify-center shadow-xl shadow-purple-500/30 group-hover:shadow-purple-500/50 transition-all duration-300">
                            <i class="bi bi-bar-chart-line text-2xl text-white group-hover:scale-110 transition-transform"></i>
                        </div>
                    </div>
                    <div>
                        <h1 class="text-2xl sm:text-3xl font-bold bg-gradient-to-r from-slate-900 via-purple-900 to-slate-900 dark:from-white dark:via-purple-200 dark:to-white bg-clip-text text-transparent">
                            Laporan Bulanan
                        </h1>
                        <p class="text-slate-600 dark:text-slate-400 text-sm flex items-center gap-2">
                            <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                            {{ $monthYear }} • Data Real-time
                        </p>
                    </div>
                </div>

                <!-- Export Buttons - Modern -->
                <div class="flex gap-3">
                    <a href="{{ route('super-admin.reports.monthly.pdf', ['month' => $month, 'year' => $year]) }}"
                       class="group inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-rose-500 to-rose-600 hover:from-rose-600 hover:to-rose-700 text-white rounded-xl text-sm font-semibold shadow-lg shadow-rose-500/30 hover:shadow-rose-500/50 transition-all duration-300 hover:-translate-y-0.5">
                        <i class="bi bi-file-pdf text-lg group-hover:rotate-12 transition-transform"></i>
                        <span class="hidden sm:inline">PDF</span>
                    </a>
                    <a href="{{ route('super-admin.reports.monthly.excel', ['month' => $month, 'year' => $year]) }}"
                       class="group inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 text-white rounded-xl text-sm font-semibold shadow-lg shadow-emerald-500/30 hover:shadow-emerald-500/50 transition-all duration-300 hover:-translate-y-0.5">
                        <i class="bi bi-file-earmark-excel text-lg group-hover:rotate-12 transition-transform"></i>
                        <span class="hidden sm:inline">Excel</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Filter Form - Modern Glass -->
        <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl shadow-xl border border-white/20 dark:border-slate-700/50 p-5 mb-8">
            <form method="GET" action="{{ route('super-admin.reports.monthly') }}" class="flex flex-col sm:flex-row gap-4 items-end">
                <div class="flex-1 w-full">
                    <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 mb-2 uppercase tracking-wide">Bulan</label>
                    <div class="relative">
                        <select name="month" class="w-full px-4 py-3 bg-slate-50/80 dark:bg-slate-700/80 border border-slate-300/60 dark:border-slate-600/60 rounded-xl focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 text-slate-900 dark:text-white text-sm transition-all appearance-none cursor-pointer">
                            @foreach(range(1, 12) as $m)
                            <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                            </option>
                            @endforeach
                        </select>
                        <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                            <i class="bi bi-chevron-down"></i>
                        </div>
                    </div>
                </div>
                <div class="flex-1 w-full">
                    <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 mb-2 uppercase tracking-wide">Tahun</label>
                    <div class="relative">
                        <select name="year" class="w-full px-4 py-3 bg-slate-50/80 dark:bg-slate-700/80 border border-slate-300/60 dark:border-slate-600/60 rounded-xl focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 text-slate-900 dark:text-white text-sm transition-all appearance-none cursor-pointer">
                            @foreach(range(date('Y'), date('Y') - 5) as $y)
                            <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                            @endforeach
                        </select>
                        <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                            <i class="bi bi-chevron-down"></i>
                        </div>
                    </div>
                </div>
                <button type="submit" class="w-full sm:w-auto px-6 py-3 bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-700 hover:to-blue-700 text-white rounded-xl text-sm font-semibold shadow-lg shadow-purple-500/30 hover:shadow-purple-500/50 transition-all duration-300 hover:-translate-y-0.5 flex items-center justify-center gap-2 group">
                    <i class="bi bi-search group-hover:rotate-12 transition-transform"></i>
                    <span>Tampilkan</span>
                </button>
            </form>
        </div>

        <!-- Key Insights - Modern Gradient Cards -->
        <div class="bg-gradient-to-r from-purple-600 via-blue-600 to-indigo-600 rounded-2xl p-6 mb-8 shadow-2xl shadow-purple-500/25 relative overflow-hidden">
            <div class="absolute inset-0 opacity-20">
                <div class="absolute top-0 right-0 w-40 h-40 bg-white/20 rounded-full blur-2xl"></div>
                <div class="absolute bottom-0 left-0 w-32 h-32 bg-amber-400/30 rounded-full blur-xl"></div>
            </div>

            <div class="relative">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-10 h-10 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center border border-white/30">
                        <i class="bi bi-lightbulb text-xl text-white"></i>
                    </div>
                    <h3 class="text-base font-bold text-white">✨ Insight Cepat</h3>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 hover:bg-white/20 transition-all duration-200 border border-white/20 hover:scale-105">
                        <p class="text-sm text-white/85 mb-2">Total Permohonan</p>
                        <p class="text-3xl font-bold text-white">{{ number_format($stats['total_permits'] ?? 0) }}</p>
                        <p class="text-xs text-white/70 mt-2 flex items-center gap-1">
                            <i class="bi bi-arrow-up-right text-emerald-300"></i>
                            {{ ($stats['total_permits'] ?? 0) > 0 ? 'Aktif bulan ini' : 'Belum ada data' }}
                        </p>
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 hover:bg-white/20 transition-all duration-200 border border-white/20 hover:scale-105">
                        <p class="text-sm text-white/85 mb-2">Tingkat Persetujuan</p>
                        <p class="text-3xl font-bold text-white">{{ $stats['approval_rate'] ?? 0 }}%</p>
                        <div class="w-full bg-white/20 rounded-full h-2.5 mt-3 overflow-hidden">
                            <div class="bg-gradient-to-r from-emerald-300 to-white h-2.5 rounded-full transition-all duration-700" style="width: {{ $stats['approval_rate'] ?? 0 }}%"></div>
                        </div>
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 hover:bg-white/20 transition-all duration-200 border border-white/20 hover:scale-105">
                        <p class="text-sm text-white/85 mb-2">Status Dominan</p>
                        @php
                            $highest = max($stats['approved'] ?? 0, $stats['pending'] ?? 0, $stats['rejected'] ?? 0);
                            $status = $highest == ($stats['approved'] ?? 0) ? 'Disetujui' : ($highest == ($stats['pending'] ?? 0) ? 'Pending' : 'Ditolak');
                            $statusColor = $highest == ($stats['approved'] ?? 0) ? 'text-emerald-300' : ($highest == ($stats['pending'] ?? 0) ? 'text-amber-300' : 'text-rose-300');
                        @endphp
                        <p class="text-3xl font-bold {{ $statusColor }}">{{ $status }}</p>
                        <p class="text-xs text-white/70 mt-2">{{ number_format($highest) }} permohonan</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Cards - Modern Grid -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            @php
            $statsConfig = [
                ['label' => 'Total', 'value' => $stats['total_permits'] ?? 0, 'icon' => 'bi-clipboard-data', 'color' => 'blue', 'desc' => 'Permohonan'],
                ['label' => 'Disetujui', 'value' => $stats['approved'] ?? 0, 'icon' => 'bi-check-circle', 'color' => 'emerald', 'desc' => 'Berhasil'],
                ['label' => 'Pending', 'value' => $stats['pending'] ?? 0, 'icon' => 'bi-clock-history', 'color' => 'amber', 'desc' => 'Diproses'],
                ['label' => 'Rate', 'value' => $stats['approval_rate'] ?? 0, 'suffix' => '%', 'icon' => 'bi-percent', 'color' => 'purple', 'desc' => 'Approval'],
            ];
            @endphp

            @foreach($statsConfig as $stat)
            <div class="group bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm rounded-2xl p-5 border border-white/20 dark:border-slate-700/50 shadow-lg hover:shadow-2xl hover:-translate-y-1 transition-all duration-300">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-11 h-11 bg-gradient-to-br from-{{ $stat['color'] }}-400 to-{{ $stat['color'] }}-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300 shadow-lg">
                        <i class="bi {{ $stat['icon'] }} text-white text-lg"></i>
                    </div>
                    @if($stat['label'] === 'Rate')
                    <span class="px-2.5 py-1 bg-{{ $stat['color'] }}-100 dark:bg-{{ $stat['color'] }}-900/40 text-{{ $stat['color'] }}-700 dark:text-{{ $stat['color'] }}-400 text-xs font-bold rounded-lg">
                        {{ $stat['value'] }}%
                    </span>
                    @endif
                </div>
                <p class="text-3xl font-bold bg-gradient-to-r from-slate-900 to-slate-700 dark:from-white dark:to-slate-300 bg-clip-text text-transparent mb-1">
                    {{ number_format($stat['value']) }}
                    @if(isset($stat['suffix']) && $stat['label'] !== 'Rate')<span class="text-xl text-slate-400">{{ $stat['suffix'] }}</span>@endif
                </p>
                <p class="text-xs font-semibold text-slate-600 dark:text-slate-400">{{ $stat['label'] }}</p>
                <p class="text-xs text-slate-400 dark:text-slate-500">{{ $stat['desc'] }}</p>
            </div>
            @endforeach
        </div>

        <!-- Charts Section - Modern Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">

            <!-- Chart 1: Status Permohonan -->
            <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm rounded-2xl border border-white/20 dark:border-slate-700/50 p-6 shadow-xl">
                <div class="flex items-center justify-between mb-5">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-purple-400 to-purple-600 rounded-xl flex items-center justify-center shadow-lg">
                            <i class="bi bi-pie-chart text-white"></i>
                        </div>
                        <h3 class="text-base font-bold text-slate-900 dark:text-white">Status Permohonan</h3>
                    </div>
                    <span class="px-3 py-1.5 bg-purple-100/80 dark:bg-purple-900/40 text-purple-700 dark:text-purple-400 text-xs font-semibold rounded-lg">Real-time</span>
                </div>
                <div class="relative h-64">
                    <canvas id="permitStatusChart"></canvas>
                </div>
                <div class="flex justify-center gap-6 mt-5 pt-4 border-t border-slate-200/60 dark:border-slate-700/60">
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 bg-emerald-500 rounded-full shadow-sm"></div>
                        <span class="text-xs font-medium text-slate-600 dark:text-slate-400">Approved</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 bg-amber-500 rounded-full shadow-sm"></div>
                        <span class="text-xs font-medium text-slate-600 dark:text-slate-400">Pending</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 bg-rose-500 rounded-full shadow-sm"></div>
                        <span class="text-xs font-medium text-slate-600 dark:text-slate-400">Rejected</span>
                    </div>
                </div>
            </div>

            <!-- Chart 2: Pertumbuhan User -->
            <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm rounded-2xl border border-white/20 dark:border-slate-700/50 p-6 shadow-xl">
                <div class="flex items-center justify-between mb-5">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                            <i class="bi bi-people text-white"></i>
                        </div>
                        <h3 class="text-base font-bold text-slate-900 dark:text-white">Pertumbuhan User</h3>
                    </div>
                    <span class="px-3 py-1.5 bg-blue-100/80 dark:bg-blue-900/40 text-blue-700 dark:text-blue-400 text-xs font-semibold rounded-lg">6 Bulan</span>
                </div>
                <div class="relative h-64">
                    <canvas id="userGrowthChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Chart 3: Daily Trend (Full Width) -->
        <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm rounded-2xl border border-white/20 dark:border-slate-700/50 p-6 mb-8 shadow-xl">
            <div class="flex items-center justify-between mb-5">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-amber-400 to-amber-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="bi bi-graph-up text-white"></i>
                    </div>
                    <h3 class="text-base font-bold text-slate-900 dark:text-white">Tren Harian</h3>
                </div>
                <span class="px-3 py-1.5 bg-amber-100/80 dark:bg-amber-900/40 text-amber-700 dark:text-amber-400 text-xs font-semibold rounded-lg">{{ $monthYear }}</span>
            </div>
            <div class="relative h-72">
                <canvas id="dailyTrendChart"></canvas>
            </div>
        </div>

        <!-- Top Ships & UPT Stats -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">

            <!-- Top Ships -->
            <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm rounded-2xl border border-white/20 dark:border-slate-700/50 p-6 shadow-xl">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-10 h-10 bg-gradient-to-br from-amber-400 to-amber-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="bi bi-trophy text-white"></i>
                    </div>
                    <h3 class="text-base font-bold text-slate-900 dark:text-white">🏆 Top 5 Kapal</h3>
                </div>
                <div class="space-y-3">
                    @forelse($topShips ?? [] as $index => $ship)
                    <div class="group flex items-center gap-4 p-4 bg-slate-50/60 dark:bg-slate-700/40 rounded-xl hover:bg-gradient-to-r hover:from-amber-50/80 hover:to-orange-50/80 dark:hover:from-amber-900/20 dark:hover:to-orange-900/20 transition-all duration-200 border border-transparent hover:border-amber-200/60 dark:hover:border-amber-700/60">
                        <div class="w-9 h-9 bg-gradient-to-br from-amber-400 to-orange-500 rounded-xl flex items-center justify-center text-white font-bold text-sm shadow-lg group-hover:shadow-xl group-hover:scale-105 transition-all">
                            {{ $index + 1 }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-slate-900 dark:text-white text-sm truncate group-hover:text-amber-700 dark:group-hover:text-amber-300 transition-colors">{{ $ship['ship_name'] ?? '-' }}</p>
                            <p class="text-xs text-slate-500 dark:text-slate-400">{{ $ship['ship_type'] ?? '-' }}</p>
                        </div>
                        <span class="text-sm font-bold text-amber-600 dark:text-amber-400 bg-amber-50/80 dark:bg-amber-900/30 px-3.5 py-1.5 rounded-xl border border-amber-200/60 dark:border-amber-700/60">{{ $ship['count'] ?? 0 }}</span>
                    </div>
                    @empty
                    <div class="text-center py-8">
                        <div class="w-14 h-14 mx-auto bg-slate-100 dark:bg-slate-700 rounded-2xl flex items-center justify-center mb-3">
                            <i class="bi bi-inbox text-2xl text-slate-400 dark:text-slate-500"></i>
                        </div>
                        <p class="text-slate-500 dark:text-slate-400 text-sm">Tidak ada data kapal</p>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- UPT Statistics -->
            <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm rounded-2xl border border-white/20 dark:border-slate-700/50 p-6 shadow-xl">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="bi bi-building text-white"></i>
                    </div>
                    <h3 class="text-base font-bold text-slate-900 dark:text-white">🏢 Top 5 UPT</h3>
                </div>
                <div class="space-y-3">
                    @forelse(($uptStats ?? collect())->take(5) as $index => $upt)
                    <div class="group flex items-center gap-4 p-4 bg-slate-50/60 dark:bg-slate-700/40 rounded-xl hover:bg-gradient-to-r hover:from-blue-50/80 hover:to-indigo-50/80 dark:hover:from-blue-900/20 dark:hover:to-indigo-900/20 transition-all duration-200 border border-transparent hover:border-blue-200/60 dark:hover:border-blue-700/60">
                        <div class="w-9 h-9 bg-gradient-to-br from-blue-400 to-blue-600 rounded-xl flex items-center justify-center text-white font-bold text-sm shadow-lg group-hover:shadow-xl group-hover:scale-105 transition-all">
                            {{ $index + 1 }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-slate-900 dark:text-white text-sm truncate group-hover:text-blue-700 dark:group-hover:text-blue-300 transition-colors">{{ $upt->name ?? '-' }}</p>
                            <p class="text-xs text-slate-500 dark:text-slate-400">{{ $upt->region ?? '-' }}</p>
                        </div>
                        <span class="text-sm font-bold text-blue-600 dark:text-blue-400 bg-blue-50/80 dark:bg-blue-900/30 px-3.5 py-1.5 rounded-xl border border-blue-200/60 dark:border-blue-700/60">{{ $upt->permits_count ?? 0 }}</span>
                    </div>
                    @empty
                    <div class="text-center py-8">
                        <div class="w-14 h-14 mx-auto bg-slate-100 dark:bg-slate-700 rounded-2xl flex items-center justify-center mb-3">
                            <i class="bi bi-inbox text-2xl text-slate-400 dark:text-slate-500"></i>
                        </div>
                        <p class="text-slate-500 dark:text-slate-400 text-sm">Tidak ada data UPT</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Data Table - Modern & Clean -->
        <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm rounded-2xl border border-white/20 dark:border-slate-700/50 overflow-hidden mb-8 shadow-xl">
            <div class="px-6 py-4 border-b border-slate-200/60 dark:border-slate-700/60 bg-gradient-to-r from-slate-50/80 to-white/80 dark:from-slate-700/40 dark:to-slate-800/40">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 bg-gradient-to-br from-indigo-400 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="bi bi-table text-white"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-slate-900 dark:text-white">Detail Permohonan</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400">{{ $monthYear }}</p>
                    </div>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-50/80 dark:bg-slate-700/50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wide">Tanggal</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wide">Kapal</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wide">Pemohon</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wide">UPT</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wide">Status</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wide">Pnp</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200/60 dark:divide-slate-700/60">
                        @forelse($permits ?? [] as $permit)
                        <tr class="group hover:bg-gradient-to-r hover:from-purple-50/60 hover:to-blue-50/60 dark:hover:from-purple-900/20 dark:hover:to-blue-900/20 transition-all duration-200">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 bg-gradient-to-br from-purple-100 to-purple-200 dark:from-purple-900/40 dark:to-purple-800/40 rounded-xl flex items-center justify-center">
                                        <i class="bi bi-calendar text-purple-600 dark:text-purple-400 text-sm"></i>
                                    </div>
                                    <span class="text-sm font-semibold text-slate-900 dark:text-white">{{ $permit->application_date?->format('d/m/Y') ?? '-' }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-gradient-to-br from-blue-100 to-blue-200 dark:from-blue-900/40 dark:to-blue-800/40 rounded-xl flex items-center justify-center shadow-sm">
                                        <i class="bi bi-ship text-blue-600 dark:text-blue-400"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-slate-900 dark:text-white">{{ $permit->ship_name ?? '-' }}</p>
                                        <p class="text-xs text-slate-500 dark:text-slate-400">{{ $permit->ship_type ?? '-' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 bg-gradient-to-br from-purple-100 to-purple-200 dark:from-purple-900/40 dark:to-purple-800/40 rounded-full flex items-center justify-center text-purple-600 dark:text-purple-400 text-xs font-bold">
                                        {{ substr($permit->user?->name ?? 'U', 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-slate-900 dark:text-white">{{ $permit->user?->name ?? '-' }}</p>
                                        <p class="text-xs text-slate-500 dark:text-slate-400 truncate max-w-32">{{ $permit->user?->email ?? '-' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-700 dark:text-slate-300">{{ $permit->upt?->name ?? '-' }}</td>
                            <td class="px-6 py-4 text-center">
                                @if(($permit->status ?? '') === 'approved')
                                    <span class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-gradient-to-r from-emerald-50/80 to-emerald-100/80 dark:from-emerald-900/40 dark:to-emerald-800/40 text-emerald-700 dark:text-emerald-300 text-xs font-bold rounded-xl border border-emerald-200/60 dark:border-emerald-700/60 shadow-sm">
                                        <i class="bi bi-check-circle-fill text-[10px]"></i> Approved
                                    </span>
                                @elseif(($permit->status ?? '') === 'pending')
                                    <span class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-gradient-to-r from-amber-50/80 to-amber-100/80 dark:from-amber-900/40 dark:to-amber-800/40 text-amber-700 dark:text-amber-300 text-xs font-bold rounded-xl border border-amber-200/60 dark:border-amber-700/60 shadow-sm">
                                        <i class="bi bi-clock-fill text-[10px]"></i> Pending
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-gradient-to-r from-rose-50/80 to-rose-100/80 dark:from-rose-900/40 dark:to-rose-800/40 text-rose-700 dark:text-rose-300 text-xs font-bold rounded-xl border border-rose-200/60 dark:border-rose-700/60 shadow-sm">
                                        <i class="bi bi-x-circle-fill text-[10px]"></i> Rejected
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex items-center justify-center w-9 h-9 bg-gradient-to-br from-blue-100 to-blue-200 dark:from-blue-900/40 dark:to-blue-800/40 text-blue-700 dark:text-blue-300 text-sm font-bold rounded-xl shadow-sm">
                                    {{ number_format($permit->passenger_count ?? 0) }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-14 text-center">
                                <div class="flex flex-col items-center gap-4">
                                    <div class="w-16 h-16 bg-slate-100 dark:bg-slate-700 rounded-2xl flex items-center justify-center">
                                        <i class="bi bi-inbox text-3xl text-slate-400 dark:text-slate-500"></i>
                                    </div>
                                    <p class="text-slate-500 dark:text-slate-400 text-sm font-medium">Tidak ada data untuk periode ini</p>
                                    <p class="text-slate-400 dark:text-slate-500 text-xs">Coba ubah filter bulan/tahun</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Footer - Minimal -->
        <div class="text-center text-slate-400 dark:text-slate-500 text-xs py-6">
            <p>&copy; {{ date('Y') }} SPOG KAPAL DAN CVS • Laporan otomatis • <span class="text-purple-500 font-semibold">v2.0</span></p>
        </div>
    </div>
</div>

<!-- Chart Data -->
<script>
window.chartData = {
    permitStatus: {
        labels: ['Approved', 'Pending', 'Rejected'],
        values: [{{ $stats['approved'] ?? 0 }}, {{ $stats['pending'] ?? 0 }}, {{ $stats['rejected'] ?? 0 }}]
    },
    daily: {!! json_encode($dailyData ?? []) !!},
    userGrowth: {!! json_encode($userGrowthData ?? []) !!}
};
</script>

<!-- Chart.js Library -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

<!-- ✅ CHART INITIALIZATION - FIXED SYNTAX -->
<script>
document.addEventListener("DOMContentLoaded", function () {
    console.log('📊 Initializing modern charts...');

    const { permitStatus, daily, userGrowth } = window.chartData;

    // Chart 1: Doughnut - Status Permohonan
    const ctxStatus = document.getElementById('permitStatusChart');
    if (ctxStatus) {
        try {
            new Chart(ctxStatus, {
                type: 'doughnut',
                data: {
                    labels: permitStatus.labels,
                    datasets: [{
                        data: permitStatus.values,
                        backgroundColor: ['#10B981', '#F59E0B', '#EF4444'],
                        borderWidth: 3,
                        borderColor: '#fff',
                        hoverOffset: 15,
                        hoverBorderWidth: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '75%',
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: 'rgba(255, 255, 255, 0.98)',
                            titleColor: '#1f2937',
                            bodyColor: '#4b5563',
                            borderColor: '#e5e7eb',
                            borderWidth: 2,
                            padding: 14,
                            cornerRadius: 12,
                            titleFont: { size: 13, weight: 'bold' },
                            bodyFont: { size: 12 },
                            callbacks: {
                                label: function(ctx) {
                                    const total = ctx.dataset.data.reduce((a,b) => a+b, 0);
                                    const pct = total > 0 ? Math.round((ctx.parsed / total) * 100) : 0;
                                    return ctx.label + ': ' + ctx.parsed + ' (' + pct + '%)';
                                }
                            }
                        }
                    },
                    animation: {
                        duration: 800,
                        easing: 'easeOutQuart',
                        animateRotate: true,
                        animateScale: true
                    }
                }
            });
            console.log('✅ Status chart created');
        } catch (error) {
            console.error('❌ Error creating status chart:', error);
        }
    }

    // Chart 2: Bar - Pertumbuhan User
    const ctxUser = document.getElementById('userGrowthChart');
    if (ctxUser && userGrowth && userGrowth.length > 0) {
        try {
            new Chart(ctxUser, {
                type: 'bar',
                data: {
                    labels: userGrowth.map(i => i.label),
                    datasets: [{
                        label: 'User Baru',
                        data: userGrowth.map(i => i.value || 0),
                        backgroundColor: 'rgba(139, 92, 246, 0.8)',
                        borderColor: '#8B5CF6',
                        borderWidth: 2,
                        borderRadius: 10,
                        borderSkipped: false
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        x: {
                            ticks: { color: '#94a3b8', font: { size: 10 } },
                            grid: { display: false }
                        },
                        y: {
                            beginAtZero: true,
                            ticks: { color: '#94a3b8', font: { size: 10 }, stepSize: 1 },
                            grid: { color: 'rgba(0,0,0,0.05)' }
                        }
                    },
                    animation: { duration: 600, easing: 'easeOutQuart' }
                }
            });
            console.log('✅ User growth chart created');
        } catch (error) {
            console.error('❌ Error creating user chart:', error);
        }
    }

    // Chart 3: Line - Tren Harian
    const ctxDaily = document.getElementById('dailyTrendChart');
    if (ctxDaily && daily && daily.length > 0) {
        try {
            new Chart(ctxDaily, {
                type: 'line',
                data: {
                    labels: daily.map(d => 'Tgl ' + d.date),
                    datasets: [
                        {
                            label: 'Total',
                            data: daily.map(d => d.total || 0),
                            borderColor: '#8B5CF6',
                            backgroundColor: 'rgba(139, 92, 246, 0.15)',
                            fill: true,
                            tension: 0.4,
                            borderWidth: 3,
                            pointRadius: 4,
                            pointHoverRadius: 7,
                            pointBackgroundColor: '#8B5CF6',
                            pointBorderColor: '#fff',
                            pointBorderWidth: 3,
                            pointHoverBorderWidth: 4
                        },
                        {
                            label: 'Approved',
                            data: daily.map(d => d.approved || 0),
                            borderColor: '#10B981',
                            backgroundColor: 'rgba(16, 185, 129, 0.15)',
                            fill: true,
                            tension: 0.4,
                            borderWidth: 3,
                            pointRadius: 4,
                            pointHoverRadius: 7,
                            pointBackgroundColor: '#10B981',
                            pointBorderColor: '#fff',
                            pointBorderWidth: 3,
                            pointHoverBorderWidth: 4
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: { color: '#94a3b8', font: { size: 11 }, padding: 15, usePointStyle: true, pointStyle: 'circle' }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(255, 255, 255, 0.98)',
                            titleColor: '#1f2937',
                            bodyColor: '#4b5563',
                            borderColor: '#e5e7eb',
                            borderWidth: 2,
                            padding: 14,
                            cornerRadius: 12,
                            titleFont: { size: 13, weight: 'bold' },
                            bodyFont: { size: 12 },
                            mode: 'index',
                            intersect: false
                        }
                    },
                    scales: {
                        x: {
                            ticks: { color: '#94a3b8', font: { size: 9 } },
                            grid: { display: false }
                        },
                        y: {
                            beginAtZero: true,
                            ticks: { color: '#94a3b8', font: { size: 10 }, stepSize: 1 },
                            grid: { color: 'rgba(0,0,0,0.05)' }
                        }
                    },
                    animation: { duration: 700, easing: 'easeOutQuart' }
                }
            });
            console.log('✅ Daily trend chart created');
        } catch (error) {
            console.error('❌ Error creating daily chart:', error);
        }
    }

    console.log('📊 All modern charts initialized!');
});
</script>

<!-- Modern Professional CSS -->
<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
body { font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif; }
* { scroll-behavior: smooth; }
::-webkit-scrollbar { width: 6px; height: 6px; }
::-webkit-scrollbar-track { background: transparent; }
::-webkit-scrollbar-thumb { background: rgba(139, 92, 246, 0.4); border-radius: 3px; }
::-webkit-scrollbar-thumb:hover { background: rgba(139, 92, 246, 0.6); }
</style>
@endsection
