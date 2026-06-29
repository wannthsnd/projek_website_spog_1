@extends('layouts.app')
@section('title', 'Detail Permohonan #' . str_pad($permit->id, 4, '0', STR_PAD_LEFT))

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

    <!-- Header Section -->
    <div class="mb-6 lg:mb-8">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.permits.index') }}"
                   class="group relative w-12 h-12 bg-white dark:bg-gray-800 rounded-xl flex items-center justify-center hover:bg-gray-50 dark:hover:bg-gray-700 transition-all shadow-sm hover:shadow-md border border-gray-200 dark:border-gray-700 flex-shrink-0">
                    <i class="bi bi-arrow-left text-lg text-gray-700 dark:text-gray-300 group-hover:-translate-x-0.5 transition-transform"></i>
                </a>
                <div class="min-w-0">
                    <div class="flex flex-wrap items-center gap-3 mb-1">
                        <h1 class="text-xl lg:text-2xl font-bold text-gray-900 dark:text-white truncate">Detail Permohonan</h1>
                        <span class="px-3 py-1 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 text-xs lg:text-sm font-mono font-bold rounded-lg whitespace-nowrap">
                            #{{ str_pad($permit->id, 4, '0', STR_PAD_LEFT) }}
                        </span>
                    </div>
                    <p class="text-gray-600 dark:text-gray-400 text-sm font-medium">Informasi lengkap permohonan SPOG</p>
                </div>
            </div>

            <div class="flex flex-wrap gap-3 items-center">
                <!-- Status Badge -->
                <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-xs lg:text-sm font-bold border shadow-sm whitespace-nowrap
                    {{ $permit->status === 'pending' ? 'bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-300 border-amber-200 dark:border-amber-700' : '' }}
                    {{ $permit->status === 'approved' ? 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300 border-emerald-200 dark:border-emerald-700' : '' }}
                    {{ $permit->status === 'rejected' ? 'bg-rose-100 dark:bg-rose-900/30 text-rose-700 dark:text-rose-300 border-rose-200 dark:border-rose-700' : '' }}">
                    @if($permit->status === 'pending')
                    <span class="w-2 h-2 bg-amber-500 rounded-full animate-pulse flex-shrink-0"></span>
                    @elseif($permit->status === 'approved')
                    <i class="bi bi-check-circle-fill text-emerald-500 flex-shrink-0"></i>
                    @else
                    <i class="bi bi-x-circle-fill text-rose-500 flex-shrink-0"></i>
                    @endif
                    <span class="hidden xs:inline">{{ ucfirst($permit->status) }}</span>
                    <span class="xs:hidden">{{ ucfirst(substr($permit->status, 0, 3)) }}.</span>
                </span>

                <!-- Edit Button -->
                <a href="{{ route('admin.permits.edit', $permit->id) }}"
                   class="inline-flex items-center gap-2 px-4 lg:px-5 py-2 lg:py-2.5 bg-gradient-to-r from-amber-500 to-orange-500 text-white rounded-xl text-xs lg:text-sm font-semibold hover:from-amber-600 hover:to-orange-600 transition-all shadow-md hover:shadow-lg whitespace-nowrap">
                    <i class="bi bi-pencil"></i>
                    <span class="hidden sm:inline">Edit</span>
                </a>
            </div>
        </div>
    </div>

    <!-- REJECTION NOTES SECTION -->
    @if($permit->status === 'rejected' && $permit->rejection_notes)
    <div class="mb-6 bg-gradient-to-br from-rose-50 to-red-50 dark:from-rose-900/20 dark:to-red-900/10 rounded-2xl lg:rounded-3xl p-4 lg:p-6 border-2 border-rose-300 dark:border-rose-700 shadow-lg">
        <div class="flex flex-col sm:flex-row sm:items-start gap-4">
            <div class="relative flex-shrink-0 mx-auto sm:mx-0">
                <div class="absolute inset-0 bg-rose-500 rounded-xl blur-lg opacity-30"></div>
                <div class="relative w-12 h-12 bg-gradient-to-br from-rose-500 to-red-600 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="bi bi-x-circle text-2xl text-white"></i>
                </div>
            </div>
            <div class="flex-1 min-w-0 text-center sm:text-left">
                <h3 class="text-base lg:text-lg font-bold text-rose-900 dark:text-rose-300 mb-2">
                    Catatan Penolakan dari Admin
                </h3>
                <div class="bg-white/60 dark:bg-black/20 rounded-xl p-4 mb-3 border border-rose-200 dark:border-rose-700">
                    <p class="text-sm text-rose-800 dark:text-rose-200 whitespace-pre-line font-medium leading-relaxed break-words">
                        {{ $permit->rejection_notes }}
                    </p>
                </div>
                <div class="flex flex-wrap justify-center sm:justify-start items-center gap-3 text-xs text-rose-700 dark:text-rose-400">
                    @if($permit->rejected_by)
                    <span class="flex items-center gap-1 bg-rose-100 dark:bg-rose-900/30 px-3 py-1.5 rounded-full">
                        <i class="bi bi-person"></i>
                        <span class="truncate max-w-[150px]">{{ $permit->rejected_by }}</span>
                    </span>
                    @endif
                    @if($permit->rejected_at)
                    <span class="flex items-center gap-1 bg-rose-100 dark:bg-rose-900/30 px-3 py-1.5 rounded-full">
                        <i class="bi bi-clock"></i>
                        <span>{{ \Carbon\Carbon::parse($permit->rejected_at)->format('d M Y, H:i') }}</span>
                    </span>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Main Grid Layout -->
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

        <!-- Left Column - Main Content -->
        <div class="xl:col-span-2 space-y-6">

            <!-- Applicant Information Card -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl lg:rounded-3xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="px-5 lg:px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-600">
                    <h3 class="text-base lg:text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                        <div class="w-8 h-8 bg-gradient-to-br from-amber-400 to-orange-500 rounded-lg flex items-center justify-center shadow-sm flex-shrink-0">
                            <i class="bi bi-person-badge text-white text-sm"></i>
                        </div>
                        <span class="truncate">Informasi Pemohon</span>
                    </h3>
                </div>
                <div class="p-5 lg:p-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl min-w-0">
                            <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Nama Lengkap</p>
                            <p class="text-sm lg:text-base font-bold text-gray-900 dark:text-white truncate">{{ $permit->name }}</p>
                        </div>
                        <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl min-w-0">
                            <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Email</p>
                            <p class="text-sm lg:text-base font-bold text-gray-900 dark:text-white break-all">{{ $permit->email }}</p>
                        </div>
                        <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl min-w-0">
                            <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Jenis Kapal</p>
                            <p class="text-sm lg:text-base font-bold text-gray-900 dark:text-white truncate">{{ $permit->ship_type }}</p>
                        </div>
                        <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl min-w-0">
                            <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Jumlah Penumpang</p>
                            <p class="text-sm lg:text-base font-bold text-gray-900 dark:text-white">{{ number_format($permit->passenger_count) }} Orang</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Ship & Voyage Data Card - ✅ SESUAI LAYOUT USER -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl lg:rounded-3xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="px-5 lg:px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-600">
                    <h3 class="text-base lg:text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                        <div class="w-8 h-8 bg-gradient-to-br from-blue-400 to-indigo-500 rounded-lg flex items-center justify-center shadow-sm flex-shrink-0">
                            <i class="bi bi-ship text-white text-sm"></i>
                        </div>
                        <span class="truncate">Data Kapal & Perjalanan</span>
                    </h3>
                </div>
                <div class="p-5 lg:p-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- ✅ NAMA KAPAL - Full Width -->
                        <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl min-w-0 sm:col-span-2">
                            <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Nama Kapal</p>
                            <p class="text-sm lg:text-base font-bold text-gray-900 dark:text-white truncate">{{ $permit->ship_name ?? '-' }}</p>
                        </div>

                        <!-- ✅ JENIS KAPAL -->
                        <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl min-w-0">
                            <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Jenis Kapal</p>
                            <p class="text-sm lg:text-base font-bold text-gray-900 dark:text-white truncate">{{ $permit->ship_type }}</p>
                        </div>

                        <!-- ✅ ISI KOTOR (GT) -->
                        <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl min-w-0">
                            <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Isi Kotor (GT)</p>
                            <p class="text-sm lg:text-base font-bold text-gray-900 dark:text-white">{{ number_format($permit->gross_tonnage ?? 0) }} GT</p>
                        </div>

                        <!-- ✅ BENDERA -->
                        <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl min-w-0">
                            <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Bendera</p>
                            <p class="text-sm lg:text-base font-bold text-gray-900 dark:text-white">{{ $permit->flag ?? 'Indonesia' }}</p>
                        </div>

                        <!-- ✅ NAMA NAKHODA -->
                        <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl min-w-0">
                            <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Nama Nakhoda</p>
                            <p class="text-sm lg:text-base font-bold text-gray-900 dark:text-white truncate">{{ $permit->captain_name }}</p>
                        </div>

                        <!-- ✅ MILIK / AGEN -->
                        <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl min-w-0">
                            <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Milik / Agen</p>
                            <p class="text-sm lg:text-base font-bold text-gray-900 dark:text-white truncate">{{ $permit->owner_agent }}</p>
                        </div>

                        <!-- ✅ BERGERAK DARI -->
                        <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl min-w-0">
                            <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Bergerak Dari</p>
                            <p class="text-sm lg:text-base font-bold text-gray-900 dark:text-white truncate">{{ $permit->departure_location }}</p>
                        </div>

                        <!-- ✅ KE (DALAM DLKR/DLKP) -->
                        <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl min-w-0">
                            <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Ke (Dalam DLKr/DLKp)</p>
                            <p class="text-sm lg:text-base font-bold text-gray-900 dark:text-white truncate">{{ $permit->destination ?? '-' }}</p>
                        </div>

                        <!-- ✅ WAKTU GERAK -->
                        <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl min-w-0">
                            <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Waktu Gerak</p>
                            <p class="text-sm lg:text-base font-bold text-gray-900 dark:text-white">{{ $permit->movement_time }}</p>
                        </div>

                        <!-- ✅ TANGGAL PENGAJUAN - Full Width -->
                        <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl min-w-0 sm:col-span-2">
                            <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Tanggal Pengajuan</p>
                            <p class="text-sm lg:text-base font-bold text-gray-900 dark:text-white">
                                {{ $permit->application_date->format('l, d F Y') }}
                                <span class="text-xs lg:text-sm font-normal text-gray-500 dark:text-gray-400 ml-2">
                                    {{ $permit->application_date->format('H:i') }} WIB
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Purpose Card -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl lg:rounded-3xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="px-5 lg:px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-600">
                    <h3 class="text-base lg:text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                        <div class="w-8 h-8 bg-gradient-to-br from-purple-400 to-pink-500 rounded-lg flex items-center justify-center shadow-sm flex-shrink-0">
                            <i class="bi bi-file-text text-white text-sm"></i>
                        </div>
                        <span class="truncate">Keperluan Olah Gerak</span>
                    </h3>
                </div>
                <div class="p-5 lg:p-6">
                    <div class="p-4 bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-700/50 dark:to-gray-600/50 rounded-xl border border-gray-200 dark:border-gray-600">
                        <p class="text-sm text-gray-800 dark:text-gray-200 leading-relaxed whitespace-pre-wrap break-words">{{ $permit->purpose }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column - Sidebar -->
        <div class="space-y-6">

            <!-- Documents Card - 5 Documents Only -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl lg:rounded-3xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="px-5 lg:px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-600">
                    <h3 class="text-base lg:text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                        <div class="w-8 h-8 bg-gradient-to-br from-red-400 to-orange-500 rounded-lg flex items-center justify-center shadow-sm flex-shrink-0">
                            <i class="bi bi-files text-white text-sm"></i>
                        </div>
                        <span class="truncate">Dokumen Pendukung</span>
                    </h3>
                </div>
                <div class="p-4 space-y-3">
                    @php
                    $docNames = [
                        1 => 'Surat Permohonan',
                        3 => 'Fotokopi Data Awak Kapal',
                        4 => 'Surat dan Dokumen Kapal Asli',
                        5 => 'Daftar Penumpang (Manifest)',
                        6 => 'Daftar Muatan (Manifest)'
                    ];
                    @endphp

                    @foreach($docNames as $num => $name)
                    <div class="group flex items-center gap-3 p-3 bg-gray-50 dark:bg-gray-700/50 rounded-xl border border-gray-200 dark:border-gray-600 hover:border-amber-400 dark:hover:border-amber-500 hover:shadow-md transition-all">
                        <div class="relative flex-shrink-0">
                            <div class="absolute inset-0 bg-red-400 rounded-lg blur-sm opacity-30"></div>
                            <div class="relative w-10 h-10 bg-gradient-to-br from-red-400 to-orange-500 rounded-lg flex items-center justify-center shadow-sm">
                                <i class="bi bi-file-pdf text-white"></i>
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-gray-900 dark:text-white text-sm truncate">Dokumen {{ $loop->iteration }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ $name }}</p>
                        </div>
                        <div class="flex gap-1.5 flex-shrink-0">
                            <a href="{{ route('admin.permits.download', [$permit->id, $num, 'view']) }}"
                               target="_blank"
                               class="inline-flex items-center justify-center w-8 h-8 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-lg hover:bg-blue-200 dark:hover:bg-blue-900/50 transition-all"
                               title="Lihat Dokumen">
                                <i class="bi bi-eye text-sm"></i>
                            </a>
                            <a href="{{ route('admin.permits.download', [$permit->id, $num, 'download']) }}"
                               class="inline-flex items-center justify-center w-8 h-8 bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400 rounded-lg hover:bg-green-200 dark:hover:bg-green-900/50 transition-all"
                               title="Unduh Dokumen">
                                <i class="bi bi-download text-sm"></i>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- SPOG Letter Card -->
            @if($permit->status === 'approved')
            <div class="bg-gradient-to-br from-emerald-50 via-white to-green-50 dark:from-emerald-900/20 dark:via-gray-800 dark:to-green-900/10 rounded-2xl lg:rounded-3xl p-5 border border-emerald-200 dark:border-emerald-700 shadow-lg">
                <div class="flex items-start gap-3 mb-4">
                    <div class="relative flex-shrink-0">
                        <div class="absolute inset-0 bg-emerald-400 rounded-xl blur-lg opacity-30"></div>
                        <div class="relative w-10 h-10 bg-gradient-to-br from-emerald-400 to-green-600 rounded-xl flex items-center justify-center shadow-sm">
                            <i class="bi bi-file-earmark-check text-white"></i>
                        </div>
                    </div>
                    <div class="min-w-0">
                        <h3 class="text-base font-bold text-emerald-900 dark:text-emerald-300 truncate">Surat SPOG Resmi</h3>
                        <p class="text-xs text-emerald-700 dark:text-emerald-400 mt-0.5">Permohonan telah disetujui</p>
                    </div>
                </div>

                <a href="{{ route('admin.permits.download.spog', $permit->id) }}"
                   class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-gradient-to-r from-emerald-500 to-green-600 text-white rounded-xl font-semibold hover:from-emerald-600 hover:to-green-700 transition-all shadow-md hover:shadow-lg">
                    <i class="bi bi-download"></i>
                    <span>Unduh Surat SPOG</span>
                </a>

                <p class="text-xs text-emerald-700 dark:text-emerald-500 mt-3 text-center flex items-center justify-center gap-1">
                    <i class="bi bi-info-circle"></i>
                    File PDF • Berlaku sesuai tanggal pengajuan
                </p>
            </div>
            @else
            <div class="bg-gradient-to-br from-gray-50 via-white to-gray-100 dark:from-gray-800 dark:via-gray-700 dark:to-gray-600 rounded-2xl lg:rounded-3xl p-5 border border-gray-200 dark:border-gray-600 shadow-lg">
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 bg-gray-200 dark:bg-gray-600 rounded-xl flex items-center justify-center flex-shrink-0">
                        <i class="bi bi-file-earmark-lock text-gray-500 dark:text-gray-400"></i>
                    </div>
                    <div class="min-w-0">
                        <h3 class="text-base font-bold text-gray-900 dark:text-white truncate">Surat SPOG</h3>
                        <p class="text-xs text-gray-600 dark:text-gray-400 mt-0.5">Akan tersedia setelah disetujui</p>
                    </div>
                </div>
            </div>
            @endif

            <!-- Status Timeline Card -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl lg:rounded-3xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="px-5 lg:px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-600">
                    <h3 class="text-base lg:text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                        <div class="w-8 h-8 bg-gradient-to-br from-emerald-400 to-green-600 rounded-lg flex items-center justify-center shadow-sm flex-shrink-0">
                            <i class="bi bi-clock-history text-white text-sm"></i>
                        </div>
                        <span class="truncate">Status Permohonan</span>
                    </h3>
                </div>
                <div class="p-5 lg:p-6">
                    <div class="flex items-center gap-3 p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl border border-gray-200 dark:border-gray-600 mb-4">
                        <div class="relative flex-shrink-0">
                            <div class="absolute inset-0 {{ $permit->status === 'pending' ? 'bg-amber-400' : ($permit->status === 'approved' ? 'bg-emerald-400' : 'bg-rose-400') }} rounded-full blur-sm opacity-50"></div>
                            <div class="relative w-3 h-3 {{ $permit->status === 'pending' ? 'bg-amber-500' : ($permit->status === 'approved' ? 'bg-emerald-500' : 'bg-rose-500') }} rounded-full {{ $permit->status === 'pending' ? 'animate-pulse' : '' }}"></div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-bold text-gray-900 dark:text-white capitalize truncate">{{ $permit->status }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Status saat ini</p>
                        </div>
                    </div>

                    @if($permit->status === 'approved')
                    <div class="p-4 bg-gradient-to-r from-emerald-50 to-green-50 dark:from-emerald-900/20 dark:to-green-900/10 rounded-xl border border-emerald-200 dark:border-emerald-700">
                        <p class="text-sm text-emerald-800 dark:text-emerald-300 flex items-start gap-2">
                            <i class="bi bi-check-circle-fill text-emerald-500 mt-0.5 flex-shrink-0"></i>
                            <span>Permohonan telah disetujui. Surat SPOG resmi dapat diunduh di atas.</span>
                        </p>
                    </div>
                    @elseif($permit->status === 'rejected')
                    <div class="p-4 bg-gradient-to-r from-rose-50 to-red-50 dark:from-rose-900/20 dark:to-red-900/10 rounded-xl border border-rose-200 dark:border-rose-700">
                        <p class="text-sm text-rose-800 dark:text-rose-300 flex items-start gap-2">
                            <i class="bi bi-x-circle-fill text-rose-500 mt-0.5 flex-shrink-0"></i>
                            <span>Permohonan ditolak. Silakan periksa catatan penolakan di atas dan ajukan kembali setelah diperbaiki.</span>
                        </p>
                    </div>
                    @else
                    <div class="p-4 bg-gradient-to-r from-amber-50 to-orange-50 dark:from-amber-900/20 dark:to-orange-900/10 rounded-xl border border-amber-200 dark:border-amber-700">
                        <p class="text-sm text-amber-800 dark:text-amber-300 flex items-start gap-2">
                            <i class="bi bi-clock-fill text-amber-500 mt-0.5 flex-shrink-0"></i>
                            <span>Permohonan sedang diproses. Mohon tunggu konfirmasi dari administrator.</span>
                        </p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Quick Actions Card -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl lg:rounded-3xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="px-5 lg:px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-600">
                    <h3 class="text-base lg:text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                        <div class="w-8 h-8 bg-gradient-to-br from-blue-400 to-indigo-500 rounded-lg flex items-center justify-center shadow-sm flex-shrink-0">
                            <i class="bi bi-gear text-white text-sm"></i>
                        </div>
                        <span class="truncate">Aksi Cepat</span>
                    </h3>
                </div>
                <div class="p-4 space-y-3">
                    <a href="{{ route('admin.permits.edit', $permit->id) }}"
                       class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-gradient-to-r from-amber-500 to-orange-500 text-white rounded-xl text-sm font-semibold hover:from-amber-600 hover:to-orange-600 transition-all shadow-sm hover:shadow-md">
                        <i class="bi bi-pencil"></i>
                        <span>Edit Data</span>
                    </a>

                    @if($permit->status === 'pending')
                    <form action="{{ route('admin.permits.approve', $permit->id) }}" method="POST">
                        @csrf
                        <button type="submit"
                           class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-gradient-to-r from-emerald-500 to-green-600 text-white rounded-xl text-sm font-semibold hover:from-emerald-600 hover:to-green-700 transition-all shadow-sm hover:shadow-md">
                            <i class="bi bi-check-circle"></i>
                            <span>Setujui Permohonan</span>
                        </button>
                    </form>

                    <button type="button" onclick="openRejectModal()"
                       class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-gradient-to-r from-rose-500 to-red-600 text-white rounded-xl text-sm font-semibold hover:from-rose-600 hover:to-red-700 transition-all shadow-sm hover:shadow-md">
                        <i class="bi bi-x-circle"></i>
                        <span>Tolak Permohonan</span>
                    </button>
                    @endif

                    <button onclick="confirmDelete({{ $permit->id }}, '{{ addslashes($permit->ship_type) }}')"
                       class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-xl text-sm font-semibold hover:bg-gray-200 dark:hover:bg-gray-600 transition-all border border-gray-200 dark:border-gray-600">
                        <i class="bi bi-trash text-rose-500"></i>
                        <span class="text-rose-600 dark:text-rose-400">Hapus Data</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ✅ REJECT MODAL - Compact & Elegant -->
@if($permit->status === 'pending')
<div id="rejectModal" class="hidden fixed inset-0 bg-black/60 backdrop-blur-sm z-[9999] flex items-center justify-center p-4 overflow-y-auto">
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-full max-w-lg my-auto border border-gray-200 dark:border-gray-700">

        <!-- Modal Header -->
        <div class="bg-gradient-to-r from-rose-600 to-red-600 px-6 py-4 flex items-center justify-between flex-shrink-0 rounded-t-2xl">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                    <i class="bi bi-x-circle text-2xl text-white"></i>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-white">Tolak Permohonan</h2>
                    <p class="text-rose-100 text-xs">Berikan alasan penolakan</p>
                </div>
            </div>
            <button onclick="closeRejectModal()" class="p-2 hover:bg-white/20 rounded-lg transition-colors text-white">
                <i class="bi bi-x text-xl"></i>
            </button>
        </div>

        <!-- Modal Body -->
        <form id="rejectForm" method="POST" action="{{ route('admin.permits.reject', $permit->id) }}">
            @csrf
            @method('POST')

            <div class="p-5 space-y-4 max-h-[calc(100vh-280px)] overflow-y-auto">

                <!-- Permit Info -->
                <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-4">
                    <div class="grid grid-cols-2 gap-3 text-sm">
                        <div>
                            <span class="text-gray-500 dark:text-gray-400 text-xs">Kapal:</span>
                            <p class="font-semibold text-gray-900 dark:text-white truncate">{{ $permit->ship_type }}</p>
                        </div>
                        <div>
                            <span class="text-gray-500 dark:text-gray-400 text-xs">Pemohon:</span>
                            <p class="font-semibold text-gray-900 dark:text-white truncate">{{ $permit->name }}</p>
                        </div>
                        <div>
                            <span class="text-gray-500 dark:text-gray-400 text-xs">Email:</span>
                            <p class="font-semibold text-gray-900 dark:text-white truncate">{{ $permit->email }}</p>
                        </div>
                        <div>
                            <span class="text-gray-500 dark:text-gray-400 text-xs">ID:</span>
                            <p class="font-semibold text-gray-900 dark:text-white">#{{ str_pad($permit->id, 4, '0', STR_PAD_LEFT) }}</p>
                        </div>
                    </div>
                </div>

                <!-- Rejection Notes -->
                <div>
                    <label class="block text-sm font-bold text-gray-900 dark:text-white mb-2">
                        Catatan Penolakan <span class="text-red-500">*</span>
                    </label>
                    <textarea name="rejection_notes"
                              id="rejectionNotes"
                              rows="5"
                              required
                              minlength="10"
                              maxlength="1000"
                              placeholder="Contoh:&#10;• Dokumen tidak lengkap&#10;• Data tidak sesuai&#10;• dll."
                              class="w-full px-3 py-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl focus:outline-none focus:border-rose-500 focus:ring-2 focus:ring-rose-500/20 text-gray-900 dark:text-white text-sm resize-none"></textarea>
                    <div class="flex items-center justify-between mt-1.5">
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            <i class="bi bi-info-circle mr-1"></i>
                            Min. 10 karakter
                        </p>
                        <span id="charCount" class="text-xs text-gray-400 dark:text-gray-500 font-medium">0/1000</span>
                    </div>
                </div>

                <!-- Warning -->
                <div class="bg-rose-50 dark:bg-rose-900/20 rounded-xl p-3 border border-rose-200 dark:border-rose-700">
                    <p class="text-xs text-rose-800 dark:text-rose-200">
                        <i class="bi bi-exclamation-triangle mr-1"></i>
                        User akan menerima notifikasi dengan catatan ini dan dapat mengajukan kembali.
                    </p>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="bg-gray-50 dark:bg-gray-700/50 px-5 py-4 border-t border-gray-200 dark:border-gray-700 flex items-center justify-end gap-3 flex-shrink-0 rounded-b-2xl">
                <button type="button"
                        onclick="closeRejectModal()"
                        class="px-5 py-2.5 bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white rounded-xl text-sm font-semibold hover:bg-gray-300 dark:hover:bg-gray-600 transition-all">
                    Batal
                </button>
                <button type="submit"
                        class="px-5 py-2.5 bg-gradient-to-r from-rose-500 to-red-600 text-white rounded-xl text-sm font-bold hover:shadow-lg transition-all">
                    <i class="bi bi-x-circle mr-2"></i>
                    Tolak Permohonan
                </button>
            </div>
        </form>
    </div>
</div>
@endif

<!-- Delete Confirmation Modal -->
<div id="deleteModal" x-data="{ show: false, permitId: null, permitName: '' }"
     x-show="show" x-cloak
     class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div x-show="show"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 transition-opacity bg-gray-900/75 backdrop-blur-sm"
             @click="show = false"></div>

        <div x-show="show"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             class="inline-block w-full max-w-md p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white dark:bg-gray-800 shadow-2xl rounded-2xl border border-gray-200 dark:border-gray-700">

            <div class="flex items-center gap-4 mb-5 pb-4 border-b border-gray-200 dark:border-gray-700">
                <div class="relative flex-shrink-0">
                    <div class="absolute inset-0 bg-rose-500 rounded-full blur-lg opacity-30"></div>
                    <div class="relative w-12 h-12 bg-gradient-to-br from-rose-500 to-red-600 rounded-full flex items-center justify-center shadow-lg">
                        <i class="bi bi-exclamation-triangle text-xl text-white"></i>
                    </div>
                </div>
                <div class="min-w-0">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white truncate">Hapus Data?</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Tindakan ini tidak dapat dibatalkan</p>
                </div>
            </div>

            <div class="bg-gradient-to-r from-rose-50 to-red-50 dark:from-rose-900/20 dark:to-red-900/10 rounded-xl p-4 mb-6 border border-rose-200 dark:border-rose-700">
                <p class="text-sm text-rose-800 dark:text-rose-300">
                    Anda akan menghapus data permohonan untuk kapal:
                    <br>
                    <strong class="text-base font-mono text-rose-900 dark:text-rose-200 break-all" x-text="permitName"></strong>
                </p>
            </div>

            <div class="flex gap-3">
                <button @click="show = false"
                        class="flex-1 px-4 py-2.5 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-xl text-sm font-semibold hover:bg-gray-200 dark:hover:bg-gray-600 transition-all">
                    Batal
                </button>
                <form :action="'/admin/permits/' + permitId" method="POST" class="flex-1">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="w-full px-4 py-2.5 bg-gradient-to-r from-rose-500 to-red-600 text-white rounded-xl text-sm font-semibold shadow-md hover:shadow-lg hover:scale-105 transition-all flex items-center justify-center gap-2">
                        <i class="bi bi-trash"></i>
                        <span>Ya, Hapus</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Character counter
document.getElementById('rejectionNotes')?.addEventListener('input', function() {
    const count = this.value.length;
    document.getElementById('charCount').textContent = count + '/1000';

    if (count < 10) {
        this.classList.add('border-red-500');
    } else {
        this.classList.remove('border-red-500');
    }
});

// Modal Functions
function openRejectModal() {
    document.getElementById('rejectModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeRejectModal() {
    document.getElementById('rejectModal').classList.add('hidden');
    document.body.style.overflow = '';
    const notes = document.getElementById('rejectionNotes');
    if (notes) {
        notes.value = '';
        document.getElementById('charCount').textContent = '0/1000';
    }
}

// Close modal when clicking outside
document.getElementById('rejectModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closeRejectModal();
    }
});

// Close modal with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeRejectModal();
    }
});

// Delete Modal Functions
function confirmDelete(id, name) {
    const modal = document.getElementById('deleteModal');
    if (window.Alpine) {
        const alpineComponent = Alpine.$data(modal);
        alpineComponent.permitId = id;
        alpineComponent.permitName = name;
        alpineComponent.show = true;
        document.body.style.overflow = 'hidden';
    }
}

document.addEventListener('click', (e) => {
    const deleteModal = document.getElementById('deleteModal');
    if (deleteModal && e.target.closest('#deleteModal') && !e.target.closest('.bg-white')) {
        document.body.style.overflow = '';
    }
});
</script>
@endpush
@endsection
