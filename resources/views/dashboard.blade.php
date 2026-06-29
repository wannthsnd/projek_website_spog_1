@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
<!-- Hero Section - Dynamic based on role -->
<div class="relative overflow-hidden rounded-3xl gradient-dark p-8 md:p-12 mb-8 shadow-2xl">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-0 left-0 w-96 h-96 bg-yellow-400 rounded-full blur-3xl -translate-x-1/2 -translate-y-1/2"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-blue-400 rounded-full blur-3xl translate-x-1/2 translate-y-1/2"></div>
    </div>
    <div class="relative z-10">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
            <div>
                <!-- ✅ FIX: Selamat Datang dengan Nama User -->
                <h1 class="text-3xl md:text-5xl font-extrabold text-white mb-3 animate-fade-in-up">
                    @auth
                        Selamat Datang, <span class="text-transparent bg-clip-text gradient-primary">{{ auth()->user()->name }}!</span>
                    @else
                        Selamat Datang <span class="text-transparent bg-clip-text gradient-primary">di SPOG Kapal Non Konvensi</span>
                    @endauth
                </h1>
                <p class="text-gray-200 text-lg max-w-2xl animate-fade-in-up" style="animation-delay: 0.1s">
                    @auth
                        {{ auth()->user()->isSuperAdmin() ? 'Kelola seluruh sistem SPOG dengan kontrol penuh.' : (auth()->user()->isAdmin() ? 'Kelola permohonan SPOG di wilayah UPT Anda.' : 'Kelola permohonan SPOG Anda dengan mudah dan efisien.') }}
                    @else
                        Sistem pengelolaan Surat Persetujuan Olah Gerak Kapal (SPOG) yang modern, efisien, dan terpercaya.
                    @endauth
                </p>
                <!-- ✅ UPT Info Badge for Authenticated Users -->
                @auth
                    @if(auth()->user()->hasUpt())
                    <div class="mt-4 inline-flex items-center gap-2 px-4 py-2 bg-white/20 backdrop-blur-sm rounded-xl border border-white/30">
                        <i class="bi bi-building text-white"></i>
                        <span class="text-white font-semibold text-sm">
                            UPT: {{ auth()->user()->upt->name }} ({{ auth()->user()->upt->code }})
                        </span>
                    </div>
                    @endif
                @endauth
            </div>
            @guest
            @else
                <a href="{{ route('permohonan.create') }}"
                   class="btn-shine gradient-primary text-white px-8 py-4 rounded-2xl font-extrabold shadow-2xl hover:shadow-yellow-500/50 hover:scale-105 transition-all duration-300 flex items-center gap-3 animate-fade-in-up"
                   style="animation-delay: 0.2s">
                    <i class="bi bi-plus-circle text-2xl"></i>
                    <div class="text-left">
                        <p class="text-xs opacity-90">Buat Baru</p>
                        <p class="text-lg">Permohonan SPOG</p>
                    </div>
                </a>
            @endguest
        </div>
    </div>
</div>

@auth
<!-- Statistics Cards - Dynamic based on role -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- ✅ SUPER ADMIN: Global Stats -->
    @if(auth()->user()->isSuperAdmin())
        <!-- Total Users Global -->
        <div class="group relative bg-white dark:bg-gray-800 rounded-3xl p-6 shadow-xl card-hover border-2 border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 gradient-primary opacity-10 rounded-full -translate-y-1/2 translate-x-1/2 group-hover:scale-150 transition-transform duration-500"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 gradient-primary rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <i class="bi bi-people text-2xl text-white"></i>
                    </div>
                    <span class="text-xs font-extrabold text-gray-800 dark:text-gray-200 bg-gray-200 dark:bg-gray-700 px-3 py-1 rounded-full">Global</span>
                </div>
                <h3 class="text-4xl font-extrabold text-gray-900 dark:text-white mb-2">{{ number_format($stats['total_users'] ?? 0) }}</h3>
                <p class="text-gray-800 dark:text-gray-300 text-sm font-extrabold">Total Users</p>
            </div>
        </div>
        <!-- Total Admins Global -->
        <div class="group relative bg-white dark:bg-gray-800 rounded-3xl p-6 shadow-xl card-hover border-2 border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-emerald-400 opacity-10 rounded-full -translate-y-1/2 translate-x-1/2 group-hover:scale-150 transition-transform duration-500"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-emerald-400 to-green-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <i class="bi bi-person-gear text-2xl text-white"></i>
                    </div>
                    <span class="text-xs font-extrabold text-emerald-800 dark:text-emerald-400 bg-emerald-200 dark:bg-emerald-900/30 px-3 py-1 rounded-full">Global</span>
                </div>
                <h3 class="text-4xl font-extrabold text-gray-900 dark:text-white mb-2">{{ number_format($stats['total_admins'] ?? 0) }}</h3>
                <p class="text-gray-800 dark:text-gray-300 text-sm font-extrabold">Total Admins</p>
            </div>
        </div>
        <!-- Total Permits Global -->
        <a href="{{ route('super-admin.permits.index') }}" class="group relative bg-white dark:bg-gray-800 rounded-3xl p-6 shadow-xl card-hover border-2 border-gray-200 dark:border-gray-700 overflow-hidden block">
            <div class="absolute top-0 right-0 w-32 h-32 bg-amber-400 opacity-10 rounded-full -translate-y-1/2 translate-x-1/2 group-hover:scale-150 transition-transform duration-500"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-amber-400 to-orange-500 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <i class="bi bi-folder-check text-2xl text-white"></i>
                    </div>
                    <span class="text-xs font-extrabold text-amber-800 dark:text-amber-400 bg-amber-200 dark:bg-amber-900/30 px-3 py-1 rounded-full">Global</span>
                </div>
                <h3 class="text-4xl font-extrabold text-gray-900 dark:text-white mb-2">{{ number_format($stats['total_permits'] ?? 0) }}</h3>
                <p class="text-gray-800 dark:text-gray-300 text-sm font-extrabold">Total Permohonan</p>
            </div>
        </a>
        <!-- Pending Permits Global -->
        <a href="{{ route('super-admin.permits.index') }}?status=pending" class="group relative bg-white dark:bg-gray-800 rounded-3xl p-6 shadow-xl card-hover border-2 border-gray-200 dark:border-gray-700 overflow-hidden block">
            <div class="absolute top-0 right-0 w-32 h-32 bg-red-400 opacity-10 rounded-full -translate-y-1/2 translate-x-1/2 group-hover:scale-150 transition-transform duration-500"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-red-400 to-rose-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <i class="bi bi-clock-history text-2xl text-white"></i>
                    </div>
                    @if(($stats['pending_permits'] ?? 0) > 0)
                        <span class="text-xs font-extrabold text-red-800 dark:text-red-400 bg-red-200 dark:bg-red-900/30 px-3 py-1 rounded-full animate-pulse">Pending</span>
                    @else
                        <span class="text-xs font-extrabold text-gray-800 dark:text-gray-400 bg-gray-200 dark:bg-gray-700 px-3 py-1 rounded-full">Pending</span>
                    @endif
                </div>
                <h3 class="text-4xl font-extrabold text-gray-900 dark:text-white mb-2">{{ number_format($stats['pending_permits'] ?? 0) }}</h3>
                <p class="text-gray-800 dark:text-gray-300 text-sm font-extrabold">Menunggu Persetujuan</p>
            </div>
        </a>

    <!-- ✅ ADMIN UPT: Scoped Stats (Auto-filtered by Global Scope) -->
    @elseif(auth()->user()->isAdmin())
        <!-- Total Permits UPT -->
        <div class="group relative bg-white dark:bg-gray-800 rounded-3xl p-6 shadow-xl card-hover border-2 border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 gradient-primary opacity-10 rounded-full -translate-y-1/2 translate-x-1/2 group-hover:scale-150 transition-transform duration-500"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 gradient-primary rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <i class="bi bi-clipboard-data text-2xl text-white"></i>
                    </div>
                    <span class="text-xs font-extrabold text-gray-800 dark:text-gray-200 bg-gray-200 dark:bg-gray-700 px-3 py-1 rounded-full">{{ auth()->user()->upt?->code ?? 'UPT' }}</span>
                </div>
                <h3 class="text-4xl font-extrabold text-gray-900 dark:text-white mb-2">{{ number_format($totalPermohonan ?? 0) }}</h3>
                <p class="text-gray-800 dark:text-gray-300 text-sm font-extrabold">Permohonan Masuk</p>
            </div>
        </div>
        <!-- Pending UPT -->
        <div class="group relative bg-white dark:bg-gray-800 rounded-3xl p-6 shadow-xl card-hover border-2 border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-yellow-400 opacity-10 rounded-full -translate-y-1/2 translate-x-1/2 group-hover:scale-150 transition-transform duration-500"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <i class="bi bi-clock-history text-2xl text-white"></i>
                    </div>
                    @if(($totalPending ?? 0) > 0)
                        <span class="text-xs font-extrabold text-yellow-800 dark:text-yellow-400 bg-yellow-200 dark:bg-yellow-900/30 px-3 py-1 rounded-full animate-pulse">Pending</span>
                    @else
                        <span class="text-xs font-extrabold text-gray-800 dark:text-gray-400 bg-gray-200 dark:bg-gray-700 px-3 py-1 rounded-full">Pending</span>
                    @endif
                </div>
                <h3 class="text-4xl font-extrabold text-gray-900 dark:text-white mb-2">{{ number_format($totalPending ?? 0) }}</h3>
                <p class="text-gray-800 dark:text-gray-300 text-sm font-extrabold">Menunggu Persetujuan</p>
            </div>
        </div>
        <!-- Approved UPT -->
        <div class="group relative bg-white dark:bg-gray-800 rounded-3xl p-6 shadow-xl card-hover border-2 border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-green-400 opacity-10 rounded-full -translate-y-1/2 translate-x-1/2 group-hover:scale-150 transition-transform duration-500"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-green-400 to-emerald-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <i class="bi bi-check-circle text-2xl text-white"></i>
                    </div>
                    <span class="text-xs font-extrabold text-green-800 dark:text-green-400 bg-green-200 dark:bg-green-900/30 px-3 py-1 rounded-full">Approved</span>
                </div>
                <h3 class="text-4xl font-extrabold text-gray-900 dark:text-white mb-2">{{ number_format($totalApproved ?? 0) }}</h3>
                <p class="text-gray-800 dark:text-gray-300 text-sm font-extrabold">Telah Disetujui</p>
            </div>
        </div>
        <!-- Rejected UPT -->
        <div class="group relative bg-white dark:bg-gray-800 rounded-3xl p-6 shadow-xl card-hover border-2 border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-red-400 opacity-10 rounded-full -translate-y-1/2 translate-x-1/2 group-hover:scale-150 transition-transform duration-500"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-red-400 to-rose-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <i class="bi bi-x-circle text-2xl text-white"></i>
                    </div>
                    <span class="text-xs font-extrabold text-red-800 dark:text-red-400 bg-red-200 dark:bg-red-900/30 px-3 py-1 rounded-full">Rejected</span>
                </div>
                <h3 class="text-4xl font-extrabold text-gray-900 dark:text-white mb-2">{{ number_format($totalRejected ?? 0) }}</h3>
                <p class="text-gray-800 dark:text-gray-300 text-sm font-extrabold">Ditolak</p>
            </div>
        </div>

    <!-- ✅ REGULAR USER: Personal Stats -->
    @else
        <!-- My Permits -->
        <div class="group relative bg-white dark:bg-gray-800 rounded-3xl p-6 shadow-xl card-hover border-2 border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 gradient-primary opacity-10 rounded-full -translate-y-1/2 translate-x-1/2 group-hover:scale-150 transition-transform duration-500"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 gradient-primary rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <i class="bi bi-clipboard-data text-2xl text-white"></i>
                    </div>
                    <span class="text-xs font-extrabold text-gray-800 dark:text-gray-200 bg-gray-200 dark:bg-gray-700 px-3 py-1 rounded-full">Personal</span>
                </div>
                @php
                    $myPermits = auth()->user()->shipPermits()->count();
                @endphp
                <h3 class="text-4xl font-extrabold text-gray-900 dark:text-white mb-2">{{ number_format($myPermits) }}</h3>
                <p class="text-gray-800 dark:text-gray-300 text-sm font-extrabold">Permohonan Saya</p>
            </div>
        </div>
        <!-- My Pending -->
        <div class="group relative bg-white dark:bg-gray-800 rounded-3xl p-6 shadow-xl card-hover border-2 border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-yellow-400 opacity-10 rounded-full -translate-y-1/2 translate-x-1/2 group-hover:scale-150 transition-transform duration-500"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <i class="bi bi-clock-history text-2xl text-white"></i>
                    </div>
                    @php
                        $myPending = auth()->user()->shipPermits()->where('status', 'pending')->count();
                    @endphp
                    @if($myPending > 0)
                        <span class="text-xs font-extrabold text-yellow-800 dark:text-yellow-400 bg-yellow-200 dark:bg-yellow-900/30 px-3 py-1 rounded-full animate-pulse">Pending</span>
                    @else
                        <span class="text-xs font-extrabold text-gray-800 dark:text-gray-400 bg-gray-200 dark:bg-gray-700 px-3 py-1 rounded-full">Pending</span>
                    @endif
                </div>
                <h3 class="text-4xl font-extrabold text-gray-900 dark:text-white mb-2">{{ number_format($myPending) }}</h3>
                <p class="text-gray-800 dark:text-gray-300 text-sm font-extrabold">Menunggu Persetujuan</p>
            </div>
        </div>
        <!-- My Approved -->
        <div class="group relative bg-white dark:bg-gray-800 rounded-3xl p-6 shadow-xl card-hover border-2 border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-green-400 opacity-10 rounded-full -translate-y-1/2 translate-x-1/2 group-hover:scale-150 transition-transform duration-500"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-green-400 to-emerald-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <i class="bi bi-check-circle text-2xl text-white"></i>
                    </div>
                    @php
                        $myApproved = auth()->user()->shipPermits()->where('status', 'approved')->count();
                    @endphp
                    <span class="text-xs font-extrabold text-green-800 dark:text-green-400 bg-green-200 dark:bg-green-900/30 px-3 py-1 rounded-full">Approved</span>
                </div>
                <h3 class="text-4xl font-extrabold text-gray-900 dark:text-white mb-2">{{ number_format($myApproved) }}</h3>
                <p class="text-gray-800 dark:text-gray-300 text-sm font-extrabold">Telah Disetujui</p>
            </div>
        </div>
        <!-- My Rejected -->
        <div class="group relative bg-white dark:bg-gray-800 rounded-3xl p-6 shadow-xl card-hover border-2 border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-red-400 opacity-10 rounded-full -translate-y-1/2 translate-x-1/2 group-hover:scale-150 transition-transform duration-500"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-red-400 to-rose-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <i class="bi bi-x-circle text-2xl text-white"></i>
                    </div>
                    @php
                        $myRejected = auth()->user()->shipPermits()->where('status', 'rejected')->count();
                    @endphp
                    <span class="text-xs font-extrabold text-red-800 dark:text-red-400 bg-red-200 dark:bg-red-900/30 px-3 py-1 rounded-full">Rejected</span>
                </div>
                <h3 class="text-4xl font-extrabold text-gray-900 dark:text-white mb-2">{{ number_format($myRejected) }}</h3>
                <p class="text-gray-800 dark:text-gray-300 text-sm font-extrabold">Ditolak</p>
            </div>
        </div>
    @endif
</div>
@endauth

<!-- Persyaratan SPOG Section -->
<div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl border-2 border-gray-200 dark:border-gray-700 overflow-hidden mb-8">
    <div class="p-6 md:p-8 border-b-2 border-gray-200 dark:border-gray-700">
        <div class="flex items-center gap-4 mb-6">
            <div class="w-14 h-14 gradient-primary rounded-2xl flex items-center justify-center shadow-lg">
                <i class="bi bi-file-earmark-check text-2xl text-white"></i>
            </div>
            <div>
                <h2 class="text-2xl md:text-3xl font-extrabold text-gray-900 dark:text-white">
                    Persyaratan Penerbitan SPOG
                </h2>
                <p class="text-gray-800 dark:text-gray-300 font-extrabold">Surat Persetujuan Olah Gerak Kapal</p>
            </div>
        </div>
        <!-- Dasar Hukum -->
        <div class="bg-blue-50 dark:bg-blue-900/20 rounded-xl p-5 mb-6 border-2 border-blue-300 dark:border-blue-700">
            <h3 class="font-extrabold text-blue-900 dark:text-blue-300 mb-4 flex items-center gap-2 text-lg">
                <i class="bi bi-book-half text-xl"></i>
                DASAR HUKUM:
            </h3>
            <ol class="list-decimal list-inside space-y-3 text-sm text-blue-900 dark:text-blue-300">
                <li class="leading-relaxed font-extrabold">
                    <strong>Undang-Undang Nomor 66 Tahun 2024</strong> Perubahan Ketiga atas Undang-Undang Nomor 17 Tahun 2008 tentang Pelayaran
                </li>
                <li class="leading-relaxed font-extrabold">
                    <strong>Peraturan Menteri Perhubungan Nomor 28 Tahun 2022</strong> Tentang Tata Cara Penerbitan Surat Persetujuan Berlayar dan Persetujuan Kegiatan Kapal di Pelabuhan
                </li>
                <li class="leading-relaxed font-extrabold">
                    <strong>Peraturan Menteri Perhubungan Nomor 16 Tahun 2023</strong> tentang Perubahan Keempat Atas Peraturan Menteri Perhubungan Nomor PM 36 Tahun 2012 Tentang Organisasi Dan Tata Kerja Kantor Kesyahbandaran Dan Otoritas Pelabuhan
                </li>
            </ol>
        </div>
        <!-- Persyaratan -->
        <div class="mb-6">
            <h3 class="text-xl font-extrabold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                <i class="bi bi-list-check text-primary-600 text-2xl"></i>
                7 Persyaratan Penerbitan SPOG:
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-gradient-to-br from-yellow-50 to-orange-50 dark:from-yellow-900/20 dark:to-orange-900/20 rounded-xl p-5 border-2 border-yellow-300 dark:border-yellow-700 hover:shadow-lg transition-shadow">
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 gradient-primary rounded-lg flex items-center justify-center flex-shrink-0 shadow-md">
                            <span class="text-white font-extrabold">1</span>
                        </div>
                        <div>
                            <h4 class="font-extrabold text-gray-900 dark:text-white mb-1">Surat Permohonan</h4>
                            <p class="text-sm text-gray-900 dark:text-gray-300 leading-relaxed font-extrabold">
                                Pemilik Kapal, Operator Kapal atau Nakhoda mengajukan permohonan kepada Syahbandar. Format Contoh Terlampir
                            </p>
                        </div>
                    </div>
                </div>
                <div class="bg-gradient-to-br from-yellow-50 to-orange-50 dark:from-yellow-900/20 dark:to-orange-900/20 rounded-xl p-5 border-2 border-yellow-300 dark:border-yellow-700 hover:shadow-lg transition-shadow">
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 gradient-primary rounded-lg flex items-center justify-center flex-shrink-0 shadow-md">
                            <span class="text-white font-extrabold">2</span>
                        </div>
                        <div>
                            <h4 class="font-extrabold text-gray-900 dark:text-white mb-1">Surat Pernyataan Nakhoda</h4>
                            <p class="text-sm text-gray-900 dark:text-gray-300 leading-relaxed font-extrabold">
                                Master Declaration untuk olah gerak Kapal dengan menggunakan format contoh terlampir
                            </p>
                        </div>
                    </div>
                </div>
                <div class="bg-gradient-to-br from-yellow-50 to-orange-50 dark:from-yellow-900/20 dark:to-orange-900/20 rounded-xl p-5 border-2 border-yellow-300 dark:border-yellow-700 hover:shadow-lg transition-shadow">
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 gradient-primary rounded-lg flex items-center justify-center flex-shrink-0 shadow-md">
                            <span class="text-white font-extrabold">3</span>
                        </div>
                        <div>
                            <h4 class="font-extrabold text-gray-900 dark:text-white mb-1">Fotokopi Data Awak Kapal</h4>
                            <p class="text-sm text-gray-900 dark:text-gray-300 leading-relaxed font-extrabold">
                                Termasuk SKK 30 mil yang masih berlaku
                            </p>
                        </div>
                    </div>
                </div>
                <div class="bg-gradient-to-br from-yellow-50 to-orange-50 dark:from-yellow-900/20 dark:to-orange-900/20 rounded-xl p-5 border-2 border-yellow-300 dark:border-yellow-700 hover:shadow-lg transition-shadow">
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 gradient-primary rounded-lg flex items-center justify-center flex-shrink-0 shadow-md">
                            <span class="text-white font-extrabold">4</span>
                        </div>
                        <div>
                            <h4 class="font-extrabold text-gray-900 dark:text-white mb-1">Surat dan Dokumen Kapal Asli</h4>
                            <p class="text-sm text-gray-900 dark:text-gray-300 leading-relaxed font-extrabold">
                                Dokumen kapal yang masih berlaku
                            </p>
                        </div>
                    </div>
                </div>
                <div class="bg-gradient-to-br from-yellow-50 to-orange-50 dark:from-yellow-900/20 dark:to-orange-900/20 rounded-xl p-5 border-2 border-yellow-300 dark:border-yellow-700 hover:shadow-lg transition-shadow">
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 gradient-primary rounded-lg flex items-center justify-center flex-shrink-0 shadow-md">
                            <span class="text-white font-extrabold">5</span>
                        </div>
                        <div>
                            <h4 class="font-extrabold text-gray-900 dark:text-white mb-1">Daftar Penumpang (Manifest)</h4>
                            <p class="text-sm text-gray-900 dark:text-gray-300 leading-relaxed font-extrabold">
                                Melampirkan identitas diri bagi kapal penumpang. Jumlah Penumpang tidak melebihi kapasitas yang telah ditentukan
                            </p>
                        </div>
                    </div>
                </div>
                <div class="bg-gradient-to-br from-yellow-50 to-orange-50 dark:from-yellow-900/20 dark:to-orange-900/20 rounded-xl p-5 border-2 border-yellow-300 dark:border-yellow-700 hover:shadow-lg transition-shadow">
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 gradient-primary rounded-lg flex items-center justify-center flex-shrink-0 shadow-md">
                            <span class="text-white font-extrabold">6</span>
                        </div>
                        <div>
                            <h4 class="font-extrabold text-gray-900 dark:text-white mb-1">Daftar Muatan (Manifest)</h4>
                            <p class="text-sm text-gray-900 dark:text-gray-300 leading-relaxed font-extrabold">
                                Bagi kapal barang
                            </p>
                        </div>
                    </div>
                </div>
                <div class="bg-gradient-to-br from-yellow-50 to-orange-50 dark:from-yellow-900/20 dark:to-orange-900/20 rounded-xl p-5 border-2 border-yellow-300 dark:border-yellow-700 hover:shadow-lg transition-shadow md:col-span-2">
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 gradient-primary rounded-lg flex items-center justify-center flex-shrink-0 shadow-md">
                            <span class="text-white font-extrabold">7</span>
                        </div>
                        <div>
                            <h4 class="font-extrabold text-gray-900 dark:text-white mb-1">SPOG Diberikan Berdasarkan Jenis Kapal</h4>
                            <p class="text-sm text-gray-900 dark:text-gray-300 leading-relaxed font-extrabold">
                                SPOG diberikan kepada kapal berdasarkan jenis kapal dan peruntukannya
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Pernyataan Nakhoda (Master Declaration) -->
        <div class="bg-purple-50 dark:bg-purple-900/20 rounded-xl p-5 mb-6 border-2 border-purple-300 dark:border-purple-700">
            <h3 class="font-extrabold text-purple-900 dark:text-purple-300 mb-4 flex items-center gap-2 text-lg">
                <i class="bi bi-shield-check text-xl"></i>
                PERNYATAAN NAKHODA (MASTER DECLARATION):
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm text-purple-900 dark:text-purple-300">
                <div class="flex items-start gap-2">
                    <i class="bi bi-check-circle-fill text-purple-600 dark:text-purple-400 mt-0.5"></i>
                    <span class="font-extrabold">Mempunyai sertifikat yang masih berlaku</span>
                </div>
                <div class="flex items-start gap-2">
                    <i class="bi bi-check-circle-fill text-purple-600 dark:text-purple-400 mt-0.5"></i>
                    <span class="font-extrabold">Tidak mengganggu alur masuk dan keluar kapal</span>
                </div>
                <div class="flex items-start gap-2">
                    <i class="bi bi-check-circle-fill text-purple-600 dark:text-purple-400 mt-0.5"></i>
                    <span class="font-extrabold">Tidak mengganggu kelancaran kegiatan kapal lainnya</span>
                </div>
                <div class="flex items-start gap-2">
                    <i class="bi bi-check-circle-fill text-purple-600 dark:text-purple-400 mt-0.5"></i>
                    <span class="font-extrabold">Kapal harus mempunyai alat keselamatan yang cukup (life jacket)</span>
                </div>
                <div class="flex items-start gap-2">
                    <i class="bi bi-check-circle-fill text-purple-600 dark:text-purple-400 mt-0.5"></i>
                    <span class="font-extrabold">Nakhoda memiliki Surat Keterangan Kecakapan (SKK) 30 mil yang masih berlaku</span>
                </div>
                <div class="flex items-start gap-2">
                    <i class="bi bi-check-circle-fill text-purple-600 dark:text-purple-400 mt-0.5"></i>
                    <span class="font-extrabold">Kegiatan hanya di Perairan Bandar</span>
                </div>
                <div class="flex items-start gap-2">
                    <i class="bi bi-check-circle-fill text-purple-600 dark:text-purple-400 mt-0.5"></i>
                    <span class="font-extrabold">Data manifest sesuai KTP/Identitas lain bagi yang belum memiliki KTP</span>
                </div>
                <div class="flex items-start gap-2">
                    <i class="bi bi-check-circle-fill text-purple-600 dark:text-purple-400 mt-0.5"></i>
                    <span class="font-extrabold">Pemilik/operator telah mengasuransikan seluruh jiwa yang ada di kapal</span>
                </div>
            </div>
        </div>
        <!-- Info Tambahan -->
        <div class="bg-green-50 dark:bg-green-900/20 rounded-xl p-5 border-2 border-green-300 dark:border-green-700">
            <div class="flex items-start gap-3">
                <i class="bi bi-info-circle-fill text-green-600 dark:text-green-400 text-xl mt-0.5"></i>
                <div>
                    <h4 class="font-extrabold text-green-900 dark:text-green-300 mb-2">Catatan Penting:</h4>
                    <ul class="text-sm text-green-900 dark:text-green-300 space-y-1 list-disc list-inside font-extrabold">
                        <li>SPOG diberikan kepada kapal berdasarkan jenis kapal dan peruntukannya</li>
                        <li>Pemilik/operator telah mengasuransikan seluruh jiwa yang ada di kapal</li>
                        <li>Nakhoda memiliki Surat Keterangan Kecakapan (SKK) 30 mil yang masih berlaku</li>
                        <li>Kapal harus mempunyai alat keselamatan yang cukup (life jacket)</li>
                        <li>Kegiatan hanya di Perairan Bandar</li>
                        <li>Data manifest sesuai KTP/Identitas lain bagi yang belum memiliki KTP</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions - Role Based -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    @guest
        <!-- ✅ LOGIN CARD -->
        <a href="{{ route('login') }}"
           class="group relative overflow-hidden bg-gradient-to-br from-blue-500 to-blue-600 rounded-3xl p-8 text-white shadow-xl card-hover border-2 border-blue-400">
            <div class="absolute inset-0 bg-white opacity-0 group-hover:opacity-10 transition-opacity"></div>
            <div class="relative z-10">
                <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                    <i class="bi bi-box-arrow-in-right text-3xl"></i>
                </div>
                <h3 class="text-2xl font-extrabold mb-2">Login</h3>
                <p class="text-blue-100 font-extrabold">Masuk untuk mengajukan permohonan</p>
            </div>
        </a>

        <!-- ✅ DAFTAR AKUN CARD -->
        <a href="{{ route('register') }}"
           class="group relative overflow-hidden gradient-primary rounded-3xl p-8 text-white shadow-xl card-hover border-2 border-primary-400">
            <div class="absolute inset-0 bg-white opacity-0 group-hover:opacity-10 transition-opacity"></div>
            <div class="relative z-10">
                <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                    <i class="bi bi-person-plus text-3xl"></i>
                </div>
                <h3 class="text-2xl font-extrabold mb-2">Daftar Akun</h3>
                <p class="text-primary-100 font-extrabold">Buat akun untuk mengajukan permohonan</p>
            </div>
        </a>

        <!-- ✅ BANTUAN CARD (Functional dengan Modal) -->
        <button onclick="document.getElementById('bantuanModal').classList.remove('hidden')"
                class="group relative overflow-hidden bg-gradient-to-br from-green-500 to-emerald-600 rounded-3xl p-8 text-white shadow-xl card-hover border-2 border-green-400 text-left">
            <div class="absolute inset-0 bg-white opacity-0 group-hover:opacity-10 transition-opacity"></div>
            <div class="relative z-10">
                <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                    <i class="bi bi-question-circle text-3xl"></i>
                </div>
                <h3 class="text-2xl font-extrabold mb-2">Bantuan</h3>
                <p class="text-green-100 font-extrabold">Panduan dan informasi lebih lanjut</p>
            </div>
        </button>
    @else
        <!-- ✅ SUPER ADMIN Quick Actions -->
        @if(auth()->user()->isSuperAdmin())
            <a href="{{ route('super-admin.dashboard') }}"
               class="group relative overflow-hidden gradient-super-admin rounded-3xl p-8 text-white shadow-xl card-hover border-2 border-purple-400">
                <div class="absolute inset-0 bg-white opacity-0 group-hover:opacity-10 transition-opacity"></div>
                <div class="relative z-10">
                    <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                        <i class="bi bi-shield-lock text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-extrabold mb-2">Super Admin Panel</h3>
                    <p class="text-purple-100 font-extrabold">Kelola seluruh sistem dan UPT</p>
                </div>
            </a>
            <a href="{{ route('super-admin.upts.index') }}"
               class="group relative overflow-hidden bg-gradient-to-br from-indigo-500 to-purple-600 rounded-3xl p-8 text-white shadow-xl card-hover border-2 border-indigo-400">
                <div class="absolute inset-0 bg-white opacity-0 group-hover:opacity-10 transition-opacity"></div>
                <div class="relative z-10">
                    <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                        <i class="bi bi-building text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-extrabold mb-2">Kelola UPT</h3>
                    <p class="text-indigo-100 font-extrabold">Tambah dan kelola Unit Pelaksana Teknis</p>
                </div>
            </a>
            <a href="{{ route('super-admin.users.index') }}"
               class="group relative overflow-hidden bg-gradient-to-br from-blue-500 to-cyan-600 rounded-3xl p-8 text-white shadow-xl card-hover border-2 border-blue-400">
                <div class="absolute inset-0 bg-white opacity-0 group-hover:opacity-10 transition-opacity"></div>
                <div class="relative z-10">
                    <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                        <i class="bi bi-people text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-extrabold mb-2">Kelola Users</h3>
                    <p class="text-blue-100 font-extrabold">Kelola akun pengguna seluruh sistem</p>
                </div>
            </a>

        <!-- ✅ ADMIN UPT Quick Actions -->
        @elseif(auth()->user()->isAdmin())
            <a href="{{ route('admin.dashboard') }}"
               class="group relative overflow-hidden gradient-secondary rounded-3xl p-8 text-white shadow-xl card-hover border-2 border-blue-400">
                <div class="absolute inset-0 bg-white opacity-0 group-hover:opacity-10 transition-opacity"></div>
                <div class="relative z-10">
                    <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                        <i class="bi bi-gear-wide-connected text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-extrabold mb-2">Admin Panel</h3>
                    <p class="text-blue-100 font-extrabold">Kelola permohonan UPT {{ auth()->user()->upt?->code ?? '-' }}</p>
                </div>
            </a>
            <a href="{{ route('admin.data.pemohon') }}"
               class="group relative overflow-hidden bg-gradient-to-br from-amber-500 to-orange-600 rounded-3xl p-8 text-white shadow-xl card-hover border-2 border-amber-400">
                <div class="absolute inset-0 bg-white opacity-0 group-hover:opacity-10 transition-opacity"></div>
                <div class="relative z-10">
                    <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                        <i class="bi bi-people text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-extrabold mb-2">Data Pemohon</h3>
                    <p class="text-amber-100 font-extrabold">Lihat permohonan wilayah Anda</p>
                </div>
            </a>
            <a href="{{ route('admin.reports.monthly') }}"
               class="group relative overflow-hidden bg-gradient-to-br from-emerald-500 to-green-600 rounded-3xl p-8 text-white shadow-xl card-hover border-2 border-emerald-400">
                <div class="absolute inset-0 bg-white opacity-0 group-hover:opacity-10 transition-opacity"></div>
                <div class="relative z-10">
                    <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                        <i class="bi bi-bar-chart-line text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-extrabold mb-2">Laporan Bulanan</h3>
                    <p class="text-emerald-100 font-extrabold">Export laporan UPT Anda</p>
                </div>
            </a>

        <!-- ✅ REGULAR USER Quick Actions -->
        @else
            <a href="{{ route('permohonan.create') }}"
               class="group relative overflow-hidden gradient-primary rounded-3xl p-8 text-white shadow-xl card-hover border-2 border-primary-400">
                <div class="absolute inset-0 bg-white opacity-0 group-hover:opacity-10 transition-opacity"></div>
                <div class="relative z-10">
                    <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                        <i class="bi bi-file-earmark-plus text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-extrabold mb-2">Ajukan Permohonan</h3>
                    <p class="text-primary-100 font-extrabold">Buat permohonan SPOG baru</p>
                </div>
            </a>
            <a href="{{ route('data.pemohon') }}"
               class="group relative overflow-hidden bg-gradient-to-br from-amber-500 to-orange-600 rounded-3xl p-8 text-white shadow-xl card-hover border-2 border-amber-400">
                <div class="absolute inset-0 bg-white opacity-0 group-hover:opacity-10 transition-opacity"></div>
                <div class="relative z-10">
                    <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                        <i class="bi bi-people text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-extrabold mb-2">Riwayat Permohonan</h3>
                    <p class="text-amber-100 font-extrabold">Lihat status permohonan Anda</p>
                </div>
            </a>
            <a href="{{ route('profile') }}"
               class="group relative overflow-hidden bg-gradient-to-br from-purple-500 to-indigo-600 rounded-3xl p-8 text-white shadow-xl card-hover border-2 border-purple-400">
                <div class="absolute inset-0 bg-white opacity-0 group-hover:opacity-10 transition-opacity"></div>
                <div class="relative z-10">
                    <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                        <i class="bi bi-person-circle text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-extrabold mb-2">Profil Akun</h3>
                    <p class="text-purple-100 font-extrabold">Kelola informasi akun Anda</p>
                </div>
            </a>
        @endif
    @endguest
</div>

<!-- ✅ BANTUAN MODAL (Hidden by default) -->
<div id="bantuanModal" class="hidden fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-2xl max-w-3xl w-full max-h-[80vh] overflow-y-auto animate-fade-in-up">
        <!-- Modal Header -->
        <div class="sticky top-0 bg-gradient-to-r from-green-500 to-emerald-600 text-white px-8 py-6 rounded-t-3xl">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                        <i class="bi bi-question-circle text-2xl"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-extrabold">Pusat Bantuan</h2>
                        <p class="text-green-100">Panduan dan informasi SPOG</p>
                    </div>
                </div>
                <button onclick="document.getElementById('bantuanModal').classList.add('hidden')"
                        class="p-2 hover:bg-white/20 rounded-xl transition-colors">
                    <i class="bi bi-x text-2xl"></i>
                </button>
            </div>
        </div>

        <!-- Modal Content -->
        <div class="p-8 space-y-6">
            <!-- Contact Info -->
            <div class="bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-2xl p-6 border-2 border-blue-300 dark:border-blue-700">
                <h3 class="text-lg font-extrabold text-blue-900 dark:text-blue-300 mb-4 flex items-center gap-2">
                    <i class="bi bi-headset text-xl"></i>
                    Hubungi Kami
                </h3>
                <div class="space-y-3">
                    <div class="flex items-center gap-3">
                        <i class="bi bi-geo-alt text-blue-600 dark:text-blue-400"></i>
                        <span class="text-blue-900 dark:text-blue-300 font-extrabold">Kementerian Perhubungan RI</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <i class="bi bi-telephone text-blue-600 dark:text-blue-400"></i>
                        <span class="text-blue-900 dark:text-blue-300 font-extrabold">1500-xxx (Call Center)</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <i class="bi bi-envelope text-blue-600 dark:text-blue-400"></i>
                        <span class="text-blue-900 dark:text-blue-300 font-extrabold">info@pnbp-maritime.go.id</span>
                    </div>
                </div>
            </div>

            <!-- FAQ Section -->
            <div>
                <h3 class="text-lg font-extrabold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                    <i class="bi bi-question-circle text-green-600"></i>
                    Pertanyaan Umum (FAQ)
                </h3>
                <div class="space-y-3">
                    <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-4">
                        <h4 class="font-extrabold text-gray-900 dark:text-white mb-2">Apa itu SPOG?</h4>
                        <p class="text-sm text-gray-700 dark:text-gray-300 font-extrabold">SPOG (Surat Persetujuan Olah Gerak) adalah dokumen resmi yang diterbitkan oleh Syahbandar untuk memberikan izin kepada kapal non konvensi dan CVS untuk melakukan olah gerak di perairan bandar.</p>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-4">
                        <h4 class="font-extrabold text-gray-900 dark:text-white mb-2">Berapa lama proses pengurusan SPOG?</h4>
                        <p class="text-sm text-gray-700 dark:text-gray-300 font-extrabold">Proses pengurusan SPOG biasanya memakan waktu 1-3 hari kerja setelah semua persyaratan lengkap dan diverifikasi oleh petugas.</p>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-4">
                        <h4 class="font-extrabold text-gray-900 dark:text-white mb-2">Apa saja persyaratan untuk mengajukan SPOG?</h4>
                        <p class="text-sm text-gray-700 dark:text-gray-300 font-extrabold">Persyaratan meliputi: Surat Permohonan, Surat Pernyataan Nakhoda, Fotokopi Data Awak Kapal, Dokumen Kapal Asli, Manifest Penumpang/Muatan, dan SKK 30 mil yang masih berlaku.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Footer -->
        <div class="sticky bottom-0 bg-gray-50 dark:bg-gray-700/50 px-8 py-4 border-t border-gray-200 dark:border-gray-700 rounded-b-3xl">
            <button onclick="document.getElementById('bantuanModal').classList.add('hidden')"
                    class="w-full py-3 bg-gradient-to-r from-green-500 to-emerald-600 text-white rounded-xl font-extrabold hover:shadow-lg transition-all">
                Tutup
            </button>
        </div>
    </div>
</div>
@endsection
