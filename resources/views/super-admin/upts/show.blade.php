@extends('layouts.app')
@section('title', 'Detail UPT - ' . $upt->name)

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-cyan-50/40 to-teal-50/30 dark:from-slate-900 dark:via-slate-800 dark:to-slate-900 transition-colors duration-300 py-6 sm:py-8">

    <!-- Subtle Animated Background -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-cyan-400/10 dark:bg-cyan-500/5 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute top-1/2 -left-40 w-96 h-96 bg-teal-400/10 dark:bg-teal-500/5 rounded-full blur-3xl animate-pulse" style="animation-delay: 1.5s;"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div class="flex items-center gap-4">
                    <a href="{{ route('super-admin.upts.index') }}"
                       class="group w-12 h-12 bg-white/70 dark:bg-slate-800/70 backdrop-blur-sm hover:bg-white dark:hover:bg-slate-700 rounded-xl flex items-center justify-center shadow-sm border border-slate-200/60 dark:border-slate-700/60 transition-all duration-200 hover:-translate-x-0.5">
                        <i class="bi bi-arrow-left text-slate-700 dark:text-slate-300 group-hover:text-cyan-600 dark:group-hover:text-cyan-400 transition-colors"></i>
                    </a>
                    <div>
                        <h1 class="text-xl sm:text-2xl font-bold bg-gradient-to-r from-slate-900 via-cyan-900 to-slate-900 dark:from-white dark:via-cyan-200 dark:to-white bg-clip-text text-transparent mb-1">
                            Detail UPT
                        </h1>
                        <p class="text-slate-600 dark:text-slate-400 text-sm">Informasi lengkap Unit Pelaksana Teknis</p>
                    </div>
                </div>

                <div class="flex gap-3">
                    <a href="{{ route('super-admin.upts.edit', $upt->id) }}"
                       class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-cyan-600 to-teal-600 hover:from-cyan-700 hover:to-teal-700 text-white rounded-xl text-sm font-medium shadow-lg shadow-cyan-500/20 hover:shadow-cyan-500/40 hover:-translate-y-0.5 transition-all duration-200">
                        <i class="bi bi-pencil"></i>
                        <span>Edit</span>
                    </a>
                    <a href="{{ route('super-admin.upts.index') }}"
                       class="inline-flex items-center gap-2 px-5 py-2.5 bg-white/70 dark:bg-slate-800/70 hover:bg-white dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 rounded-xl text-sm font-medium transition-all duration-200 border border-slate-200/60 dark:border-slate-700/60 hover:border-cyan-400/60 dark:hover:border-cyan-600/60">
                        <i class="bi bi-arrow-left"></i>
                        <span class="hidden sm:inline">Kembali</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- UPT Info Card - Elegant Header -->
        <div class="bg-gradient-to-br from-cyan-600 via-teal-600 to-emerald-600 rounded-2xl p-5 sm:p-6 mb-8 shadow-xl shadow-cyan-500/20 relative overflow-hidden">
            <div class="absolute inset-0 opacity-20">
                <div class="absolute top-0 right-0 w-40 h-40 bg-white/20 rounded-full blur-2xl"></div>
                <div class="absolute bottom-0 left-0 w-32 h-32 bg-amber-400/30 rounded-full blur-xl"></div>
            </div>

            <div class="relative flex flex-col lg:flex-row lg:items-center justify-between gap-5">
                <div class="flex items-start gap-4">
                    <div class="w-14 h-14 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center flex-shrink-0 border border-white/30">
                        <i class="bi bi-building text-2xl text-white"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h2 class="text-xl sm:text-2xl font-bold text-white mb-2 truncate">{{ $upt->name }}</h2>
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-white/20 backdrop-blur-sm rounded-lg text-white text-xs font-medium border border-white/30">
                                <i class="bi bi-upc"></i>
                                {{ $upt->code }}
                            </span>
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-white/20 backdrop-blur-sm rounded-lg text-white text-xs font-medium border border-white/30">
                                <i class="bi bi-geo-alt"></i>
                                {{ $upt->region ?? 'N/A' }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    @if($upt->is_active)
                        <span class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-100/90 dark:bg-emerald-900/40 text-emerald-700 dark:text-emerald-300 rounded-xl text-xs font-semibold border border-emerald-200/60 dark:border-emerald-700/60 shadow-sm">
                            <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                            Aktif
                        </span>
                    @else
                        <span class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100/90 dark:bg-slate-700 text-slate-600 dark:text-slate-300 rounded-xl text-xs font-semibold border border-slate-200/60 dark:border-slate-600/60 shadow-sm">
                            <span class="w-2 h-2 bg-slate-400 rounded-full"></span>
                            Nonaktif
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">

            <!-- Left Column: Contact Info -->
            <div class="lg:col-span-2 space-y-6">

                <!-- Contact Information Card -->
                <div class="bg-white/70 dark:bg-slate-800/70 backdrop-blur-sm rounded-2xl shadow-sm border border-slate-200/60 dark:border-slate-700/60 p-5 sm:p-6 hover:shadow-md transition-shadow duration-200">
                    <div class="flex items-center gap-3 mb-5 pb-4 border-b border-slate-200/60 dark:border-slate-700/60">
                        <div class="w-9 h-9 bg-gradient-to-br from-cyan-100 to-cyan-200 dark:from-cyan-900/40 dark:to-cyan-800/40 rounded-lg flex items-center justify-center">
                            <i class="bi bi-geo-alt text-cyan-600 dark:text-cyan-400"></i>
                        </div>
                        <div>
                            <h3 class="text-base font-semibold text-slate-900 dark:text-white">Informasi Kontak</h3>
                            <p class="text-xs text-slate-500 dark:text-slate-400">Alamat dan komunikasi</p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <!-- Alamat -->
                        <div class="flex items-start gap-3 p-4 bg-slate-50/60 dark:bg-slate-700/40 rounded-xl hover:bg-cyan-50/60 dark:hover:bg-cyan-900/20 transition-colors">
                            <div class="w-9 h-9 bg-gradient-to-br from-cyan-100 to-cyan-200 dark:from-cyan-900/40 dark:to-cyan-800/40 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="bi bi-geo-alt text-cyan-600 dark:text-cyan-400"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wide mb-1">Alamat Lengkap</p>
                                @if(!empty(trim($upt->alamat ?? '')))
                                    <p class="text-slate-900 dark:text-white font-medium leading-relaxed">{{ $upt->alamat }}</p>
                                @else
                                    <p class="text-slate-400 italic">Belum diisi</p>
                                @endif
                            </div>
                        </div>

                        <!-- Kota & Kode Pos -->
                        <div class="flex items-start gap-3 p-4 bg-slate-50/60 dark:bg-slate-700/40 rounded-xl hover:bg-cyan-50/60 dark:hover:bg-cyan-900/20 transition-colors">
                            <div class="w-9 h-9 bg-gradient-to-br from-teal-100 to-teal-200 dark:from-teal-900/40 dark:to-teal-800/40 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="bi bi-map text-teal-600 dark:text-teal-400"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wide mb-1">Kota / Kode Pos</p>
                                @php
                                    $kota = trim($upt->kota ?? '');
                                    $kodePos = trim($upt->kode_pos ?? '');
                                @endphp
                                @if($kota || $kodePos)
                                    <p class="text-slate-900 dark:text-white font-medium">
                                        {{ $kota }}
                                        @if($kota && $kodePos) • @endif
                                        @if($kodePos)<span class="text-slate-500 dark:text-slate-400">({{ $kodePos }})</span>@endif
                                    </p>
                                @else
                                    <p class="text-slate-400 italic">Belum diisi</p>
                                @endif
                            </div>
                        </div>

                        <!-- Telepon -->
                        <div class="flex items-start gap-3 p-4 bg-slate-50/60 dark:bg-slate-700/40 rounded-xl hover:bg-cyan-50/60 dark:hover:bg-cyan-900/20 transition-colors">
                            <div class="w-9 h-9 bg-gradient-to-br from-emerald-100 to-emerald-200 dark:from-emerald-900/40 dark:to-emerald-800/40 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="bi bi-telephone text-emerald-600 dark:text-emerald-400"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wide mb-1">Telepon</p>
                                @if(!empty(trim($upt->telepon ?? '')))
                                    <p class="text-slate-900 dark:text-white font-medium">{{ $upt->telepon }}</p>
                                @else
                                    <p class="text-slate-400 italic">Belum diisi</p>
                                @endif
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="flex items-start gap-3 p-4 bg-slate-50/60 dark:bg-slate-700/40 rounded-xl hover:bg-cyan-50/60 dark:hover:bg-cyan-900/20 transition-colors">
                            <div class="w-9 h-9 bg-gradient-to-br from-blue-100 to-blue-200 dark:from-blue-900/40 dark:to-blue-800/40 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="bi bi-envelope text-blue-600 dark:text-blue-400"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wide mb-1">Email</p>
                                @if(!empty(trim($upt->email ?? '')))
                                    <a href="mailto:{{ $upt->email }}" class="text-cyan-600 dark:text-cyan-400 font-medium hover:text-cyan-700 dark:hover:text-cyan-300 hover:underline break-all transition-colors">
                                        {{ $upt->email }}
                                    </a>
                                @else
                                    <p class="text-slate-400 italic">Belum diisi</p>
                                @endif
                            </div>
                        </div>

                        <!-- Website -->
                        <div class="flex items-start gap-3 p-4 bg-slate-50/60 dark:bg-slate-700/40 rounded-xl hover:bg-cyan-50/60 dark:hover:bg-cyan-900/20 transition-colors">
                            <div class="w-9 h-9 bg-gradient-to-br from-purple-100 to-purple-200 dark:from-purple-900/40 dark:to-purple-800/40 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="bi bi-globe text-purple-600 dark:text-purple-400"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wide mb-1">Website</p>
                                @if(!empty(trim($upt->website ?? '')))
                                    @php
                                        $websiteUrl = Str::startsWith($upt->website, ['http://', 'https://']) ? $upt->website : 'https://' . $upt->website;
                                    @endphp
                                    <a href="{{ $websiteUrl }}" target="_blank" class="text-cyan-600 dark:text-cyan-400 font-medium hover:text-cyan-700 dark:hover:text-cyan-300 hover:underline break-all transition-colors">
                                        {{ $upt->website }}
                                    </a>
                                @else
                                    <p class="text-slate-400 italic">Belum diisi</p>
                                @endif
                            </div>
                        </div>

                        <!-- Fasilitas Komunikasi -->
                        @php
                            $tgm = trim($upt->tgm ?? '');
                            $tlx = trim($upt->tlx ?? '');
                            $fax = trim($upt->fax ?? '');
                            $hasFasilitas = $tgm || $tlx || $fax;
                        @endphp
                        @if($hasFasilitas)
                            <div class="flex items-start gap-3 p-4 bg-slate-50/60 dark:bg-slate-700/40 rounded-xl hover:bg-cyan-50/60 dark:hover:bg-cyan-900/20 transition-colors">
                                <div class="w-9 h-9 bg-gradient-to-br from-amber-100 to-amber-200 dark:from-amber-900/40 dark:to-amber-800/40 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <i class="bi bi-printer text-amber-600 dark:text-amber-400"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wide mb-1">Fasilitas Komunikasi</p>
                                    <div class="space-y-1 text-sm">
                                        @if($tgm)<p class="text-slate-900 dark:text-white"><span class="text-slate-500 dark:text-slate-400">TGM:</span> {{ $tgm }}</p>@endif
                                        @if($tlx)<p class="text-slate-900 dark:text-white"><span class="text-slate-500 dark:text-slate-400">TLX:</span> {{ $tlx }}</p>@endif
                                        @if($fax)<p class="text-slate-900 dark:text-white"><span class="text-slate-500 dark:text-slate-400">FAX:</span> {{ $fax }}</p>@endif
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Kepala Kantor -->
                        @php
                            $kepala = trim($upt->kepala_kantor ?? '');
                            $nip = trim($upt->nip_kepala ?? '');
                            $hasKepala = $kepala || $nip;
                        @endphp
                        @if($hasKepala)
                            <div class="flex items-start gap-3 p-4 bg-slate-50/60 dark:bg-slate-700/40 rounded-xl hover:bg-cyan-50/60 dark:hover:bg-cyan-900/20 transition-colors">
                                <div class="w-9 h-9 bg-gradient-to-br from-emerald-100 to-emerald-200 dark:from-emerald-900/40 dark:to-emerald-800/40 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <i class="bi bi-person-badge text-emerald-600 dark:text-emerald-400"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wide mb-1">Kepala Kantor</p>
                                    @if($kepala)<p class="text-slate-900 dark:text-white font-medium">{{ $kepala }}</p>@endif
                                    @if($nip)<p class="text-slate-500 dark:text-slate-400 text-sm">NIP: {{ $nip }}</p>@endif
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Recent Permits Table -->
                @if($recentPermits && $recentPermits->count() > 0)
                <div class="bg-white/70 dark:bg-slate-800/70 backdrop-blur-sm rounded-2xl shadow-sm border border-slate-200/60 dark:border-slate-700/60 overflow-hidden hover:shadow-md transition-shadow duration-200">
                    <div class="px-5 py-4 border-b border-slate-200/60 dark:border-slate-700/60 bg-gradient-to-r from-slate-50/60 to-white/60 dark:from-slate-700/40 dark:to-slate-800/40">
                        <h3 class="text-base font-semibold text-slate-900 dark:text-white flex items-center gap-2">
                            <div class="w-7 h-7 bg-gradient-to-br from-amber-100 to-amber-200 dark:from-amber-900/40 dark:to-amber-800/40 rounded-lg flex items-center justify-center">
                                <i class="bi bi-clock-history text-amber-600 dark:text-amber-400 text-sm"></i>
                            </div>
                            Permohonan Terbaru
                        </h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400 ml-9">Di {{ $upt->name }}</p>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-slate-50/80 dark:bg-slate-700/50">
                                <tr>
                                    <th class="px-5 py-3 text-left text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wide">Kapal</th>
                                    <th class="px-5 py-3 text-left text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wide">Pemohon</th>
                                    <th class="px-5 py-3 text-left text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wide">Status</th>
                                    <th class="px-5 py-3 text-left text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wide">Tanggal</th>
                                    <th class="px-5 py-3 text-right text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wide">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-200/60 dark:divide-slate-700/60">
                                @foreach($recentPermits as $permit)
                                <tr class="hover:bg-cyan-50/60 dark:hover:bg-cyan-900/20 transition-colors">
                                    <td class="px-5 py-4">
                                        <p class="font-medium text-slate-900 dark:text-white text-sm">{{ $permit->ship_name }}</p>
                                        <p class="text-xs text-slate-500 dark:text-slate-400">{{ $permit->ship_type }}</p>
                                    </td>
                                    <td class="px-5 py-4">
                                        <p class="font-medium text-slate-900 dark:text-white text-sm">{{ $permit->name }}</p>
                                        <p class="text-xs text-slate-500 dark:text-slate-400 truncate max-w-32">{{ $permit->email }}</p>
                                    </td>
                                    <td class="px-5 py-4">
                                        @if($permit->status === 'approved')
                                            <span class="inline-flex items-center px-2.5 py-1 bg-emerald-50/80 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300 text-xs font-medium rounded border border-emerald-200/60 dark:border-emerald-700/60">
                                                Approved
                                            </span>
                                        @elseif($permit->status === 'pending')
                                            <span class="inline-flex items-center px-2.5 py-1 bg-amber-50/80 dark:bg-amber-900/30 text-amber-700 dark:text-amber-300 text-xs font-medium rounded border border-amber-200/60 dark:border-amber-700/60">
                                                Pending
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-1 bg-rose-50/80 dark:bg-rose-900/30 text-rose-700 dark:text-rose-300 text-xs font-medium rounded border border-rose-200/60 dark:border-rose-700/60">
                                                Rejected
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-5 py-4 text-sm text-slate-700 dark:text-slate-300">
                                        {{ $permit->created_at->format('d M Y') }}
                                    </td>
                                    <td class="px-5 py-4 text-right">
                                        <a href="{{ route('super-admin.permits.show', $permit->id) }}"
                                           class="text-cyan-600 dark:text-cyan-400 hover:text-cyan-700 dark:hover:text-cyan-300 font-medium text-xs transition-colors">
                                            Detail <i class="bi bi-arrow-right text-[10px]"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @if($recentPermits->count() >= 5)
                    <div class="px-5 py-3 border-t border-slate-200/60 dark:border-slate-700/60 bg-slate-50/60 dark:bg-slate-800/40 text-center">
                        <a href="{{ route('super-admin.permits.index', ['upt_id' => $upt->id]) }}"
                           class="text-cyan-600 dark:text-cyan-400 hover:text-cyan-700 dark:hover:text-cyan-300 font-medium text-xs transition-colors">
                            Lihat Semua Permohonan <i class="bi bi-arrow-right text-[10px]"></i>
                        </a>
                    </div>
                    @endif
                </div>
                @endif
            </div>

            <!-- Right Column: Statistics -->
            <div class="space-y-6">
                <h3 class="text-base font-semibold text-slate-900 dark:text-white flex items-center gap-2">
                    <div class="w-7 h-7 bg-gradient-to-br from-cyan-100 to-cyan-200 dark:from-cyan-900/40 dark:to-cyan-800/40 rounded-lg flex items-center justify-center">
                        <i class="bi bi-bar-chart text-cyan-600 dark:text-cyan-400 text-sm"></i>
                    </div>
                    Statistik UPT
                </h3>

                <div class="grid grid-cols-2 gap-4">
                    <!-- Total Users -->
                    <div class="group bg-white/70 dark:bg-slate-800/70 backdrop-blur-sm rounded-xl p-4 border border-slate-200/60 dark:border-slate-700/60 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
                        <div class="flex items-center gap-2 mb-2">
                            <div class="w-8 h-8 bg-gradient-to-br from-blue-100 to-blue-200 dark:from-blue-900/40 dark:to-blue-800/40 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                                <i class="bi bi-people text-blue-600 dark:text-blue-400"></i>
                            </div>
                        </div>
                        <p class="text-2xl font-bold text-slate-900 dark:text-white">{{ $stats['total_users'] ?? 0 }}</p>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Total Users</p>
                    </div>

                    <!-- Total Admins -->
                    <div class="group bg-white/70 dark:bg-slate-800/70 backdrop-blur-sm rounded-xl p-4 border border-slate-200/60 dark:border-slate-700/60 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
                        <div class="flex items-center gap-2 mb-2">
                            <div class="w-8 h-8 bg-gradient-to-br from-emerald-100 to-emerald-200 dark:from-emerald-900/40 dark:to-emerald-800/40 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                                <i class="bi bi-person-gear text-emerald-600 dark:text-emerald-400"></i>
                            </div>
                        </div>
                        <p class="text-2xl font-bold text-slate-900 dark:text-white">{{ $stats['total_admins'] ?? 0 }}</p>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Total Admins</p>
                    </div>

                    <!-- Total Permits -->
                    <div class="group bg-white/70 dark:bg-slate-800/70 backdrop-blur-sm rounded-xl p-4 border border-slate-200/60 dark:border-slate-700/60 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
                        <div class="flex items-center gap-2 mb-2">
                            <div class="w-8 h-8 bg-gradient-to-br from-amber-100 to-amber-200 dark:from-amber-900/40 dark:to-amber-800/40 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                                <i class="bi bi-folder-check text-amber-600 dark:text-amber-400"></i>
                            </div>
                        </div>
                        <p class="text-2xl font-bold text-slate-900 dark:text-white">{{ $stats['total_permits'] ?? 0 }}</p>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Total Permohonan</p>
                    </div>

                    <!-- Pending Permits -->
                    <div class="group bg-white/70 dark:bg-slate-800/70 backdrop-blur-sm rounded-xl p-4 border border-slate-200/60 dark:border-slate-700/60 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
                        <div class="flex items-center gap-2 mb-2">
                            <div class="w-8 h-8 bg-gradient-to-br from-amber-100 to-amber-200 dark:from-amber-900/40 dark:to-amber-800/40 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                                <i class="bi bi-clock-history text-amber-600 dark:text-amber-400"></i>
                            </div>
                        </div>
                        <p class="text-2xl font-bold text-amber-600 dark:text-amber-400">{{ $stats['pending_permits'] ?? 0 }}</p>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Pending</p>
                    </div>

                    <!-- Approved Permits -->
                    <div class="group bg-white/70 dark:bg-slate-800/70 backdrop-blur-sm rounded-xl p-4 border border-slate-200/60 dark:border-slate-700/60 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
                        <div class="flex items-center gap-2 mb-2">
                            <div class="w-8 h-8 bg-gradient-to-br from-emerald-100 to-emerald-200 dark:from-emerald-900/40 dark:to-emerald-800/40 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                                <i class="bi bi-check-circle text-emerald-600 dark:text-emerald-400"></i>
                            </div>
                        </div>
                        <p class="text-2xl font-bold text-emerald-600 dark:text-emerald-400">{{ $stats['approved_permits'] ?? 0 }}</p>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Disetujui</p>
                    </div>

                    <!-- Rejected Permits -->
                    <div class="group bg-white/70 dark:bg-slate-800/70 backdrop-blur-sm rounded-xl p-4 border border-slate-200/60 dark:border-slate-700/60 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
                        <div class="flex items-center gap-2 mb-2">
                            <div class="w-8 h-8 bg-gradient-to-br from-rose-100 to-rose-200 dark:from-rose-900/40 dark:to-rose-800/40 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                                <i class="bi bi-x-circle text-rose-600 dark:text-rose-400"></i>
                            </div>
                        </div>
                        <p class="text-2xl font-bold text-rose-600 dark:text-rose-400">{{ $stats['rejected_permits'] ?? 0 }}</p>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Ditolak</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center text-slate-400 dark:text-slate-500 text-xs py-6">
            <p>&copy; {{ date('Y') }} SPOG KAPAL • Super Admin Panel</p>
        </div>
    </div>
</div>

<!-- Custom Styles - Minimal -->
<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap');
body { font-family: 'Inter', sans-serif; }
* { scroll-behavior: smooth; }
::-webkit-scrollbar { width: 5px; height: 5px; }
::-webkit-scrollbar-track { background: transparent; }
::-webkit-scrollbar-thumb { background: rgba(14, 165, 233, 0.4); border-radius: 3px; }
::-webkit-scrollbar-thumb:hover { background: rgba(14, 165, 233, 0.6); }
</style>
@endsection
