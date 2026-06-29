@extends('layouts.app')
@section('title', 'Admin Dashboard - ' . (auth()->user()->upt?->name ?? 'UPT'))

@section('content')
<div class="max-w-7xl mx-auto">

    <!-- Header Section - With UPT Info -->
    <div class="mb-8">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div class="flex items-center gap-4">
                <!-- UPT Icon with Glow Effect -->
                <div class="relative group">
                    <div class="absolute inset-0 bg-gradient-to-br from-emerald-400 to-green-600 rounded-2xl blur-xl opacity-40 group-hover:opacity-60 transition-opacity"></div>
                    <div class="relative w-14 h-14 bg-gradient-to-br from-emerald-400 to-green-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-105 transition-transform">
                        <i class="bi bi-building text-2xl text-white"></i>
                    </div>
                </div>

                <div>
                    <h1 class="text-2xl lg:text-3xl font-bold text-gray-900 dark:text-white mb-1">
                        👋 Selamat Datang, {{ auth()->user()->name }}!
                    </h1>
                    <div class="flex items-center gap-2 flex-wrap">
                        <span class="px-3 py-1 bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300 text-sm font-bold rounded-full flex items-center gap-1">
                            <i class="bi bi-pin-map"></i>
                            {{ auth()->user()->upt?->name ?? 'UPT Tidak Ditetapkan' }}
                        </span>
                        <span class="text-gray-500 dark:text-gray-400 text-sm">|</span>
                        <span class="text-gray-600 dark:text-gray-400 text-sm font-medium">
                            {{ auth()->user()->upt?->code ?? '---' }} - {{ auth()->user()->upt?->region ?? 'Regional' }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-3 flex-wrap">
                <!-- Admin Badge -->
                <span class="px-4 py-2 bg-gradient-to-r from-emerald-500 to-green-600 text-white rounded-xl font-bold text-sm shadow-lg flex items-center gap-2">
                    <i class="bi bi-shield-check"></i>
                    <span>Admin Panel</span>
                </span>

                <!-- Date Badge -->
                <span class="px-4 py-2 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 rounded-xl font-medium text-sm border border-gray-200 dark:border-gray-700 shadow-sm">
                    <i class="bi bi-calendar mr-1"></i>
                    {{ now()->format('d M Y') }}
                </span>
            </div>
        </div>
    </div>

    <!-- Stats Cards Grid - Scoped to UPT -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Permohonan (UPT Scope) -->
        <div class="group relative bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-700 rounded-3xl p-6 shadow-xl hover:shadow-2xl transition-all duration-300 border border-gray-200/60 dark:border-gray-600/60 hover:scale-[1.02]">
            <div class="absolute top-0 right-0 w-24 h-24 bg-emerald-400/10 rounded-full blur-2xl group-hover:bg-emerald-400/20 transition-colors"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-emerald-400 to-green-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                        <i class="bi bi-clipboard-data text-2xl text-white"></i>
                    </div>
                    <span class="px-3 py-1 bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300 text-xs font-bold rounded-full">Total</span>
                </div>
                <h3 class="text-4xl font-bold text-gray-900 dark:text-white mb-1">{{ number_format($stats['total'] ?? 0) }}</h3>
                <p class="text-gray-600 dark:text-gray-400 font-medium text-sm">Permohonan di {{ auth()->user()->upt?->code ?? 'UPT' }}</p>
            </div>
        </div>

        <!-- Pending (UPT Scope) -->
        <div class="group relative bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-700 rounded-3xl p-6 shadow-xl hover:shadow-2xl transition-all duration-300 border border-gray-200/60 dark:border-gray-600/60 hover:scale-[1.02]">
            <div class="absolute top-0 right-0 w-24 h-24 bg-amber-400/10 rounded-full blur-2xl group-hover:bg-amber-400/20 transition-colors"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-amber-400 to-orange-500 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                        <i class="bi bi-clock-history text-2xl text-white"></i>
                    </div>
                    <span class="px-3 py-1 bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-300 text-xs font-bold rounded-full flex items-center gap-1">
                        <span class="w-1.5 h-1.5 bg-amber-500 rounded-full animate-pulse"></span>
                        Pending
                    </span>
                </div>
                <h3 class="text-4xl font-bold text-gray-900 dark:text-white mb-1">{{ number_format($stats['pending'] ?? 0) }}</h3>
                <p class="text-gray-600 dark:text-gray-400 font-medium text-sm">Menunggu Persetujuan</p>
            </div>
            @if(($stats['pending'] ?? 0) > 0)
            <div class="absolute top-3 right-3 w-2.5 h-2.5 bg-amber-500 rounded-full animate-pulse"></div>
            @endif
        </div>

        <!-- Approved (UPT Scope) -->
        <div class="group relative bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-700 rounded-3xl p-6 shadow-xl hover:shadow-2xl transition-all duration-300 border border-gray-200/60 dark:border-gray-600/60 hover:scale-[1.02]">
            <div class="absolute top-0 right-0 w-24 h-24 bg-green-400/10 rounded-full blur-2xl group-hover:bg-green-400/20 transition-colors"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-green-400 to-emerald-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                        <i class="bi bi-check-circle text-2xl text-white"></i>
                    </div>
                    <span class="px-3 py-1 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 text-xs font-bold rounded-full">Approved</span>
                </div>
                <h3 class="text-4xl font-bold text-gray-900 dark:text-white mb-1">{{ number_format($stats['approved'] ?? 0) }}</h3>
                <p class="text-gray-600 dark:text-gray-400 font-medium text-sm">Telah Disetujui</p>
            </div>
        </div>

        <!-- Rejected (UPT Scope) -->
        <div class="group relative bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-700 rounded-3xl p-6 shadow-xl hover:shadow-2xl transition-all duration-300 border border-gray-200/60 dark:border-gray-600/60 hover:scale-[1.02]">
            <div class="absolute top-0 right-0 w-24 h-24 bg-rose-400/10 rounded-full blur-2xl group-hover:bg-rose-400/20 transition-colors"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-rose-400 to-red-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                        <i class="bi bi-x-circle text-2xl text-white"></i>
                    </div>
                    <span class="px-3 py-1 bg-rose-100 dark:bg-rose-900/30 text-rose-700 dark:text-rose-300 text-xs font-bold rounded-full">Rejected</span>
                </div>
                <h3 class="text-4xl font-bold text-gray-900 dark:text-white mb-1">{{ number_format($stats['rejected'] ?? 0) }}</h3>
                <p class="text-gray-600 dark:text-gray-400 font-medium text-sm">Ditolak</p>
            </div>
        </div>
    </div>

    <!-- Quick Actions & Recent Activity -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">

        <!-- Quick Actions Card -->
        <div class="lg:col-span-1 bg-white dark:bg-gray-800 rounded-3xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-emerald-50 to-green-50 dark:from-gray-700 dark:to-gray-600">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                    <i class="bi bi-lightning-charge text-emerald-600"></i>
                    Aksi Cepat
                </h3>
            </div>
            <div class="p-6 space-y-3">
                <a href="{{ route('admin.permits.index') }}"
                   class="flex items-center gap-4 p-4 bg-gray-50 dark:bg-gray-700/50 rounded-2xl hover:bg-gradient-to-r hover:from-emerald-50 hover:to-green-50 dark:hover:from-gray-600/50 dark:hover:to-gray-600/50 border-2 border-transparent hover:border-emerald-300 dark:hover:border-emerald-600 transition-all group">
                    <div class="relative">
                        <div class="absolute inset-0 bg-gradient-to-br from-emerald-400 to-green-600 rounded-xl blur-sm opacity-50 group-hover:opacity-70 transition-opacity"></div>
                        <div class="relative w-12 h-12 bg-gradient-to-br from-emerald-400 to-green-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                            <i class="bi bi-list-ul text-white text-xl"></i>
                        </div>
                    </div>
                    <div class="flex-1">
                        <p class="font-bold text-gray-900 dark:text-white">Lihat Semua Permohonan</p>
                        <p class="text-xs text-gray-600 dark:text-gray-400">Kelola data permohonan UPT</p>
                    </div>
                    <i class="bi bi-arrow-right text-gray-400 group-hover:text-emerald-600 group-hover:translate-x-1 transition-all"></i>
                </a>

                <a href="{{ route('admin.data.pemohon') }}"
                   class="flex items-center gap-4 p-4 bg-gray-50 dark:bg-gray-700/50 rounded-2xl hover:bg-gradient-to-r hover:from-blue-50 hover:to-cyan-50 dark:hover:from-gray-600/50 dark:hover:to-gray-600/50 border-2 border-transparent hover:border-blue-300 dark:hover:border-blue-600 transition-all group">
                    <div class="relative">
                        <div class="absolute inset-0 bg-gradient-to-br from-blue-400 to-cyan-500 rounded-xl blur-sm opacity-50 group-hover:opacity-70 transition-opacity"></div>
                        <div class="relative w-12 h-12 bg-gradient-to-br from-blue-400 to-cyan-500 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                            <i class="bi bi-people text-white text-xl"></i>
                        </div>
                    </div>
                    <div class="flex-1">
                        <p class="font-bold text-gray-900 dark:text-white">Data Pemohon</p>
                        <p class="text-xs text-gray-600 dark:text-gray-400">Lihat daftar pemohon UPT</p>
                    </div>
                    <i class="bi bi-arrow-right text-gray-400 group-hover:text-blue-600 group-hover:translate-x-1 transition-all"></i>
                </a>

                <a href="{{ route('admin.reports.monthly') }}"
                   class="flex items-center gap-4 p-4 bg-gray-50 dark:bg-gray-700/50 rounded-2xl hover:bg-gradient-to-r hover:from-purple-50 hover:to-indigo-50 dark:hover:from-gray-600/50 dark:hover:to-gray-600/50 border-2 border-transparent hover:border-purple-300 dark:hover:border-purple-600 transition-all group">
                    <div class="relative">
                        <div class="absolute inset-0 bg-gradient-to-br from-purple-400 to-indigo-500 rounded-xl blur-sm opacity-50 group-hover:opacity-70 transition-opacity"></div>
                        <div class="relative w-12 h-12 bg-gradient-to-br from-purple-400 to-indigo-500 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                            <i class="bi bi-file-earmark-pdf text-white text-xl"></i>
                        </div>
                    </div>
                    <div class="flex-1">
                        <p class="font-bold text-gray-900 dark:text-white">Laporan Bulanan</p>
                        <p class="text-xs text-gray-600 dark:text-gray-400">Export data laporan UPT</p>
                    </div>
                    <i class="bi bi-arrow-right text-gray-400 group-hover:text-purple-600 group-hover:translate-x-1 transition-all"></i>
                </a>
            </div>
        </div>

        <!-- Recent Permits Card - UPT Scoped -->
        <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-3xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-blue-50 to-cyan-50 dark:from-gray-700 dark:to-gray-600 flex items-center justify-between">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                    <i class="bi bi-clock-history text-blue-600"></i>
                    Permohonan Terbaru
                </h3>
                <a href="{{ route('admin.permits.index') }}" class="text-sm text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 font-semibold hover:underline flex items-center gap-1">
                    Lihat Semua <i class="bi bi-arrow-right"></i>
                </a>
            </div>
            <div class="p-6">
                @forelse($recentPermits->take(5) as $permit)
                <div class="flex items-center gap-4 p-4 rounded-2xl hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors {{ $loop->last ? '' : 'border-b border-gray-200 dark:border-gray-700 pb-4 mb-4' }}">
                    <!-- Avatar with Gradient -->
                    <div class="relative">
                        <div class="absolute inset-0 bg-gradient-to-br from-emerald-400 to-green-600 rounded-xl blur-sm opacity-50"></div>
                        <div class="relative w-12 h-12 bg-gradient-to-br from-emerald-400 to-green-600 rounded-xl flex items-center justify-center text-white font-bold text-lg shadow-lg">
                            {{ substr($permit->name, 0, 1) }}
                        </div>
                    </div>

                    <!-- Info -->
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2 mb-1 flex-wrap">
                            <p class="font-bold text-gray-900 dark:text-white truncate">{{ $permit->ship_name ?? $permit->ship_type }}</p>
                            <span class="px-2.5 py-0.5 text-[10px] font-bold rounded-full {{ $permit->status_badge }} shadow-sm">
                                {{ ucfirst($permit->status) }}
                            </span>
                        </div>
                        <p class="text-sm text-gray-600 dark:text-gray-400 truncate">{{ $permit->email }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-500 mt-1 flex items-center gap-2">
                            <span><i class="bi bi-calendar mr-1"></i>{{ $permit->application_date->format('d M Y') }}</span>
                            <span class="text-gray-300 dark:text-gray-600">•</span>
                            <span>{{ $permit->application_date->diffForHumans() }}</span>
                        </p>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center gap-2">
                        <a href="{{ route('admin.permits.show', $permit->id) }}"
                           class="p-2.5 text-gray-500 hover:text-emerald-600 dark:text-gray-400 dark:hover:text-emerald-400 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 rounded-xl transition-all hover:scale-110" title="Lihat Detail">
                            <i class="bi bi-eye text-lg"></i>
                        </a>
                        @if($permit->status === 'pending')
                        <form action="{{ route('admin.permits.approve', $permit->id) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="p-2.5 text-gray-500 hover:text-green-600 dark:text-gray-400 dark:hover:text-green-400 hover:bg-green-50 dark:hover:bg-green-900/20 rounded-xl transition-all hover:scale-110" title="Setujui">
                                <i class="bi bi-check-lg text-lg"></i>
                            </button>
                        </form>
                        <form action="{{ route('admin.permits.reject', $permit->id) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="p-2.5 text-gray-500 hover:text-rose-600 dark:text-gray-400 dark:hover:text-rose-400 hover:bg-rose-50 dark:hover:bg-rose-900/20 rounded-xl transition-all hover:scale-110" title="Tolak">
                                <i class="bi bi-x-lg text-lg"></i>
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
                @empty
                <div class="text-center py-12">
                    <div class="relative mx-auto mb-4">
                        <div class="absolute inset-0 bg-gradient-to-br from-emerald-400 to-green-600 rounded-full blur-2xl opacity-30"></div>
                        <div class="relative w-20 h-20 bg-gradient-to-br from-emerald-400 to-green-600 rounded-full flex items-center justify-center shadow-lg">
                            <i class="bi bi-clipboard-check text-3xl text-white"></i>
                        </div>
                    </div>
                    <p class="text-gray-600 dark:text-gray-400 font-medium mb-1">Tidak ada permohonan baru</p>
                    <p class="text-sm text-gray-500 dark:text-gray-500">Semua permohonan sudah diproses</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Status Overview Chart - UPT Scoped -->
    <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl border border-gray-200 dark:border-gray-700 p-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-6 gap-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-gradient-to-br from-indigo-400 to-purple-500 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="bi bi-graph-up text-xl text-white"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Ringkasan Status</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Data permohonan di {{ auth()->user()->upt?->name ?? 'UPT Anda' }}</p>
                </div>
            </div>
            <span class="text-sm text-gray-500 dark:text-gray-400 bg-gray-100 dark:bg-gray-700 px-4 py-2 rounded-xl">
                Periode: {{ now()->format('F Y') }}
            </span>
        </div>

        <!-- Simple Status Bars with Animation -->
        <div class="space-y-5">
            @php
            $total = ($stats['total'] ?? 1) ?: 1;
            $pendingPct = min(100, round((($stats['pending'] ?? 0) / $total) * 100));
            $approvedPct = min(100, round((($stats['approved'] ?? 0) / $total) * 100));
            $rejectedPct = min(100, round((($stats['rejected'] ?? 0) / $total) * 100));
            @endphp

            <!-- Pending Bar -->
            <div class="group">
                <div class="flex justify-between items-center mb-2">
                    <span class="text-sm font-semibold text-gray-700 dark:text-gray-300 flex items-center gap-2">
                        <span class="w-3 h-3 bg-gradient-to-br from-amber-400 to-orange-500 rounded-full shadow-sm shadow-amber-500/50"></span>
                        Pending
                    </span>
                    <span class="text-sm font-bold text-gray-900 dark:text-white">{{ $pendingPct }}%</span>
                </div>
                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-4 overflow-hidden">
                    <div class="bg-gradient-to-r from-amber-400 to-orange-500 h-4 rounded-full transition-all duration-700 ease-out group-hover:shadow-lg group-hover:shadow-amber-500/50"
                         style="width: {{ $pendingPct }}%"></div>
                </div>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $stats['pending'] ?? 0 }} dari {{ $total }} permohonan</p>
            </div>

            <!-- Approved Bar -->
            <div class="group">
                <div class="flex justify-between items-center mb-2">
                    <span class="text-sm font-semibold text-gray-700 dark:text-gray-300 flex items-center gap-2">
                        <span class="w-3 h-3 bg-gradient-to-br from-green-400 to-emerald-600 rounded-full shadow-sm shadow-green-500/50"></span>
                        Approved
                    </span>
                    <span class="text-sm font-bold text-gray-900 dark:text-white">{{ $approvedPct }}%</span>
                </div>
                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-4 overflow-hidden">
                    <div class="bg-gradient-to-r from-green-400 to-emerald-600 h-4 rounded-full transition-all duration-700 ease-out group-hover:shadow-lg group-hover:shadow-green-500/50"
                         style="width: {{ $approvedPct }}%"></div>
                </div>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $stats['approved'] ?? 0 }} dari {{ $total }} permohonan</p>
            </div>

            <!-- Rejected Bar -->
            <div class="group">
                <div class="flex justify-between items-center mb-2">
                    <span class="text-sm font-semibold text-gray-700 dark:text-gray-300 flex items-center gap-2">
                        <span class="w-3 h-3 bg-gradient-to-br from-rose-400 to-red-600 rounded-full shadow-sm shadow-rose-500/50"></span>
                        Rejected
                    </span>
                    <span class="text-sm font-bold text-gray-900 dark:text-white">{{ $rejectedPct }}%</span>
                </div>
                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-4 overflow-hidden">
                    <div class="bg-gradient-to-r from-rose-400 to-red-600 h-4 rounded-full transition-all duration-700 ease-out group-hover:shadow-lg group-hover:shadow-rose-500/50"
                         style="width: {{ $rejectedPct }}%"></div>
                </div>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $stats['rejected'] ?? 0 }} dari {{ $total }} permohonan</p>
            </div>
        </div>

        <!-- UPT Info Footer -->
        <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between text-sm">
                <div class="flex items-center gap-2 text-gray-600 dark:text-gray-400">
                    <i class="bi bi-info-circle"></i>
                    <span>Data hanya menampilkan permohonan dari UPT Anda</span>
                </div>
                @if(auth()->user()->upt)
                <span class="text-gray-500 dark:text-gray-500">
                    {{ auth()->user()->upt->name }} ({{ auth()->user()->upt->code }})
                </span>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
