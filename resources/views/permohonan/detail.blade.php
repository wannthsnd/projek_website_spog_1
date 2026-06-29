@extends('layouts.app')
@section('title', 'Detail Permohonan #' . str_pad($permit->id, 4, '0', STR_PAD_LEFT))

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header Section -->
    <div class="mb-8">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div class="flex items-center gap-4">
                <a href="{{ route('data.pemohon') }}"
                   class="group relative w-12 h-12 bg-white dark:bg-gray-800 rounded-xl flex items-center justify-center hover:bg-gray-50 dark:hover:bg-gray-700 transition-all shadow-sm hover:shadow-md border border-gray-200 dark:border-gray-700">
                    <i class="bi bi-arrow-left text-lg text-gray-700 dark:text-gray-300 group-hover:-translate-x-0.5 transition-transform"></i>
                </a>
                <div>
                    <div class="flex items-center gap-3 mb-1">
                        <h1 class="text-2xl lg:text-3xl font-bold text-gray-900 dark:text-white">Detail Permohonan</h1>
                        <span class="px-3 py-1 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 text-sm font-mono font-bold rounded-lg">
                            #{{ str_pad($permit->id, 4, '0', STR_PAD_LEFT) }}
                        </span>
                    </div>
                    <p class="text-gray-600 dark:text-gray-400 font-medium">Informasi lengkap permohonan SPOG Anda</p>
                </div>
            </div>

            <div class="flex flex-wrap gap-3 items-center">
                <!-- Status Badge -->
                <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-sm font-bold border shadow-sm
                    {{ $permit->status === 'pending' ? 'bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-300 border-amber-200 dark:border-amber-700' : '' }}
                    {{ $permit->status === 'approved' ? 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300 border-emerald-200 dark:border-emerald-700' : '' }}
                    {{ $permit->status === 'rejected' ? 'bg-rose-100 dark:bg-rose-900/30 text-rose-700 dark:text-rose-300 border-rose-200 dark:border-rose-700' : '' }}">
                    @if($permit->status === 'pending')
                    <span class="w-2 h-2 bg-amber-500 rounded-full animate-pulse"></span>
                    @elseif($permit->status === 'approved')
                    <i class="bi bi-check-circle-fill text-emerald-500"></i>
                    @else
                    <i class="bi bi-x-circle-fill text-rose-500"></i>
                    @endif
                    {{ ucfirst($permit->status) }}
                </span>

                <!-- ✅ EDIT BUTTON - Owner Only, When Pending OR Rejected -->
                @auth
                    @if(auth()->user()->email === $permit->email && in_array($permit->status, ['pending', 'rejected']))
                    <a href="{{ route('permohonan.edit.user', $permit->id) }}"
                       class="inline-flex items-center gap-2 px-5 py-2.5 {{ $permit->status === 'rejected' ? 'bg-gradient-to-r from-amber-500 to-orange-500 hover:from-amber-600 hover:to-orange-600' : 'bg-gradient-to-r from-primary-500 to-primary-600 hover:from-primary-600 hover:to-primary-700' }} text-white rounded-xl font-semibold transition-all shadow-md hover:shadow-lg hover:scale-105">
                        <i class="bi bi-pencil"></i>
                        <span class="hidden sm:inline">{{ $permit->status === 'rejected' ? 'Perbaiki Data' : 'Edit Data' }}</span>
                    </a>
                    @endif
                @endauth
            </div>
        </div>
    </div>

    <!-- ✅ REJECTION NOTES SECTION (Hanya muncul jika status = rejected) -->
    @if($permit->status === 'rejected' && $permit->rejection_notes)
    <div class="mb-6 bg-gradient-to-br from-rose-50 via-white to-red-50 dark:from-rose-900/20 dark:via-gray-800 dark:to-red-900/10 rounded-3xl p-6 border-2 border-rose-300 dark:border-rose-700 shadow-lg">
        <div class="flex items-start gap-4">
            <div class="w-14 h-14 bg-gradient-to-br from-rose-500 to-red-600 rounded-2xl flex items-center justify-center flex-shrink-0 shadow-lg">
                <i class="bi bi-x-circle text-3xl text-white"></i>
            </div>
            <div class="flex-1">
                <h3 class="text-xl font-bold text-rose-900 dark:text-rose-300 mb-3">
                    Permohonan Ditolak
                </h3>

                <!-- Rejection Notes Box -->
                <div class="bg-white/60 dark:bg-black/20 rounded-2xl p-5 mb-4 border border-rose-200 dark:border-rose-700">
                    <p class="text-sm font-semibold text-rose-800 dark:text-rose-300 mb-3 flex items-center gap-2">
                        <i class="bi bi-chat-left-text"></i>
                        Catatan dari Administrator:
                    </p>
                    <p class="text-rose-900 dark:text-rose-200 whitespace-pre-line leading-relaxed font-medium">
                        {{ $permit->rejection_notes }}
                    </p>
                </div>

                <!-- Rejection Metadata -->
                <div class="flex flex-wrap items-center gap-4 text-xs text-rose-700 dark:text-rose-300 mb-4">
                    @if($permit->rejected_by)
                    <span class="flex items-center gap-1.5 px-3 py-1.5 bg-rose-100 dark:bg-rose-900/30 rounded-full font-semibold">
                        <i class="bi bi-person"></i>
                        {{ $permit->rejected_by }}
                    </span>
                    @endif
                    @if($permit->rejected_at)
                    <span class="flex items-center gap-1.5 px-3 py-1.5 bg-rose-100 dark:bg-rose-900/30 rounded-full font-semibold">
                        <i class="bi bi-clock"></i>
                        {{ \Carbon\Carbon::parse($permit->rejected_at)->format('d M Y, H:i') }} WIB
                    </span>
                    @endif
                </div>

                <!-- Next Steps Guidance -->
                <div class="p-4 bg-rose-100/50 dark:bg-rose-900/30 rounded-2xl border border-rose-300 dark:border-rose-700">
                    <p class="text-sm font-bold text-rose-900 dark:text-rose-300 mb-2 flex items-center gap-2">
                        <i class="bi bi-lightbulb-fill"></i>
                        Langkah Selanjutnya:
                    </p>
                    <ul class="text-sm text-rose-800 dark:text-rose-200 space-y-1.5 list-disc list-inside font-medium">
                        <li>Periksa dan perbaiki data/dokumen yang tidak sesuai sesuai catatan di atas</li>
                        <li>Pastikan semua persyaratan SPOG telah lengkap dan valid</li>
                        <li>Klik tombol "Perbaiki Data" di atas untuk mengedit permohonan</li>
                        <li>Setelah diperbaiki, status akan kembali menjadi "Pending" untuk review ulang</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    @endif

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        <!-- Main Content - Left Column -->
        <div class="xl:col-span-2 space-y-6">

            <!-- Applicant Information Card -->
            <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                <!-- Card Header -->
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-600">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                        <div class="w-8 h-8 bg-gradient-to-br from-amber-400 to-orange-500 rounded-lg flex items-center justify-center shadow-sm">
                            <i class="bi bi-person-badge text-white text-sm"></i>
                        </div>
                        Informasi Pemohon
                    </h3>
                </div>

                <!-- Card Content -->
                <div class="p-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                            <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Nama Lengkap</p>
                            <p class="text-base font-bold text-gray-900 dark:text-white">{{ $permit->name }}</p>
                        </div>
                        <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                            <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Email</p>
                            <p class="text-base font-bold text-gray-900 dark:text-white break-all">{{ $permit->email }}</p>
                        </div>
                        <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                            <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Jenis Kapal</p>
                            <p class="text-base font-bold text-gray-900 dark:text-white">{{ $permit->ship_type }}</p>
                        </div>
                        <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                            <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Jumlah Penumpang</p>
                            <p class="text-base font-bold text-gray-900 dark:text-white">{{ number_format($permit->passenger_count) }} Orang</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Ship & Voyage Data Card -->
            <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                <!-- Card Header -->
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-600">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                        <div class="w-8 h-8 bg-gradient-to-br from-blue-400 to-indigo-500 rounded-lg flex items-center justify-center shadow-sm">
                            <i class="bi bi-ship text-white text-sm"></i>
                        </div>
                        Data Kapal & Perjalanan
                    </h3>
                </div>

                <!-- Card Content -->
                <div class="p-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl sm:col-span-2">
                            <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Nama Kapal</p>
                            <p class="text-base font-bold text-gray-900 dark:text-white">{{ $permit->ship_name ?? '-' }}</p>
                        </div>
                        <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                            <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Jenis Kapal</p>
                            <p class="text-base font-bold text-gray-900 dark:text-white">{{ $permit->ship_type }}</p>
                        </div>
                        <!-- ✅ GT (Gross Tonnage) -->
                        <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                            <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Isi Kotor (GT)</p>
                            <p class="text-base font-bold text-gray-900 dark:text-white">{{ number_format($permit->gross_tonnage ?? 0) }} GT</p>
                        </div>
                        <!-- ✅ Bendera -->
                        <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                            <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Bendera</p>
                            <p class="text-base font-bold text-gray-900 dark:text-white">{{ $permit->flag ?? 'Indonesia' }}</p>
                        </div>
                        <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                            <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Nama Nakhoda</p>
                            <p class="text-base font-bold text-gray-900 dark:text-white">{{ $permit->captain_name }}</p>
                        </div>
                        <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                            <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Milik / Agen</p>
                            <p class="text-base font-bold text-gray-900 dark:text-white">{{ $permit->owner_agent }}</p>
                        </div>
                        <!-- ✅ RUTE LENGKAP: Dari ... Ke ... (dalam DLKr/DLKp) -->
                        <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                            <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Bergerak Dari</p>
                            <p class="text-base font-bold text-gray-900 dark:text-white">{{ $permit->departure_location }}</p>
                        </div>
                        <!-- ✅ DESTINATION - FIELD BARU (PENTING UNTUK SPOG) -->
                        <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                            <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Ke (dalam DLKr/DLKp)</p>
                            <p class="text-base font-bold text-gray-900 dark:text-white">{{ $permit->destination ?? '-' }}</p>
                        </div>
                        <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                            <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Waktu Gerak</p>
                            <p class="text-base font-bold text-gray-900 dark:text-white">{{ $permit->movement_time }}</p>
                        </div>
                        <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl sm:col-span-2">
                            <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Tanggal Pengajuan</p>
                            <p class="text-base font-bold text-gray-900 dark:text-white">
                                {{ \Carbon\Carbon::parse($permit->application_date)->format('l, d F Y') }}
                                <span class="text-sm font-normal text-gray-500 dark:text-gray-400 ml-2">
                                    {{ \Carbon\Carbon::parse($permit->application_date)->format('H:i') }} WIB
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Purpose Card -->
            <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                <!-- Card Header -->
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-600">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                        <div class="w-8 h-8 bg-gradient-to-br from-purple-400 to-pink-500 rounded-lg flex items-center justify-center shadow-sm">
                            <i class="bi bi-file-text text-white text-sm"></i>
                        </div>
                        Keperluan Olah Gerak
                    </h3>
                </div>

                <!-- Card Content -->
                <div class="p-6">
                    <div class="p-4 bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-700/50 dark:to-gray-600/50 rounded-xl border border-gray-200 dark:border-gray-600">
                        <p class="text-gray-800 dark:text-gray-200 leading-relaxed whitespace-pre-wrap">{{ $permit->purpose }}</p>
                    </div>
                </div>
            </div>

            <!-- SPOG Info Card -->
            <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                <!-- Card Header -->
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-600">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                        <div class="w-8 h-8 bg-gradient-to-br from-indigo-400 to-purple-500 rounded-lg flex items-center justify-center shadow-sm">
                            <i class="bi bi-info-circle text-white text-sm"></i>
                        </div>
                        Informasi SPOG
                    </h3>
                </div>

                <!-- Card Content -->
                <div class="p-6">
                    <div class="p-4 bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/10 rounded-xl border border-blue-200 dark:border-blue-700">
                        <p class="text-sm text-blue-800 dark:text-blue-300 leading-relaxed flex items-start gap-2">
                            <i class="bi bi-check-circle-fill text-blue-500 mt-0.5 flex-shrink-0"></i>
                            <span>SPOG diberikan kepada kapal berdasarkan jenis kapal dan peruntukannya sesuai Peraturan Menteri Perhubungan Nomor 28 Tahun 2022.</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar - Right Column -->
        <div class="space-y-6">

            <!-- Documents Card - Elegant with dual actions -->
            <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                <!-- Card Header -->
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-600">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                        <div class="w-8 h-8 bg-gradient-to-br from-red-400 to-orange-500 rounded-lg flex items-center justify-center shadow-sm">
                            <i class="bi bi-files text-white text-sm"></i>
                        </div>
                        Dokumen Pendukung
                    </h3>
                </div>

                <!-- Card Content -->
                <div class="p-4 space-y-3">
                    @php
                    // ✅ HANYA 5 DOKUMEN (tanpa document_2 dan document_7)
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
                        <!-- Document Icon -->
                        <div class="relative flex-shrink-0">
                            <div class="absolute inset-0 bg-red-400 rounded-lg blur-sm opacity-30"></div>
                            <div class="relative w-10 h-10 bg-gradient-to-br from-red-400 to-orange-500 rounded-lg flex items-center justify-center shadow-sm">
                                <i class="bi bi-file-pdf text-white"></i>
                            </div>
                        </div>

                        <!-- Document Info -->
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-gray-900 dark:text-white text-sm truncate">Dokumen {{ $loop->iteration }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ $name }}</p>
                        </div>

                        <!-- Action Buttons - Compact & Elegant -->
                        <div class="flex gap-1.5">
                            <!-- View Button -->
                            <a href="{{ route('permohonan.download', [$permit->id, $num, 'view']) }}"
                               target="_blank"
                               class="inline-flex items-center justify-center w-8 h-8 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-lg hover:bg-blue-200 dark:hover:bg-blue-900/50 transition-all group/btn"
                               title="Lihat Dokumen">
                                <i class="bi bi-eye text-sm group-hover/btn:scale-110 transition-transform"></i>
                            </a>

                            <!-- Download Button -->
                            <a href="{{ route('permohonan.download', [$permit->id, $num, 'download']) }}"
                               class="inline-flex items-center justify-center w-8 h-8 bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400 rounded-lg hover:bg-green-200 dark:hover:bg-green-900/50 transition-all group/btn"
                               title="Unduh Dokumen">
                                <i class="bi bi-download text-sm group-hover/btn:scale-110 transition-transform"></i>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- ✅ SPOG Letter Card - Conditional display for approved status -->
            @if($permit->status === 'approved')
            @auth
                @if(auth()->user()->email === $permit->email)
                <div class="bg-gradient-to-br from-emerald-50 via-white to-green-50 dark:from-emerald-900/20 dark:via-gray-800 dark:to-green-900/10 rounded-3xl p-5 border border-emerald-200 dark:border-emerald-700 shadow-lg">
                    <div class="flex items-start gap-3 mb-4">
                        <div class="relative flex-shrink-0">
                            <div class="absolute inset-0 bg-emerald-400 rounded-xl blur-lg opacity-30"></div>
                            <div class="relative w-10 h-10 bg-gradient-to-br from-emerald-400 to-green-600 rounded-xl flex items-center justify-center shadow-sm">
                                <i class="bi bi-file-earmark-check text-white"></i>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-emerald-900 dark:text-emerald-300">Surat SPOG Siap Diunduh</h3>
                            <p class="text-xs text-emerald-700 dark:text-emerald-400 mt-0.5">Permohonan Anda telah disetujui</p>
                        </div>
                    </div>

                    <a href="{{ route('permohonan.download.spog', $permit->id) }}"
                       class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-gradient-to-r from-emerald-500 to-green-600 text-white rounded-xl font-semibold hover:from-emerald-600 hover:to-green-700 transition-all shadow-md hover:shadow-lg">
                        <i class="bi bi-download"></i>
                        <span>Unduh Surat SPOG</span>
                    </a>

                    <p class="text-xs text-emerald-700 dark:text-emerald-500 mt-3 text-center flex items-center justify-center gap-1">
                        <i class="bi bi-info-circle"></i>
                        File PDF • Berlaku sesuai tanggal pengajuan
                    </p>
                </div>
                @endif
            @endauth
            @endif

            <!-- Status Timeline Card -->
            <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                <!-- Card Header -->
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-600">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                        <div class="w-8 h-8 bg-gradient-to-br from-emerald-400 to-green-600 rounded-lg flex items-center justify-center shadow-sm">
                            <i class="bi bi-clock-history text-white text-sm"></i>
                        </div>
                        Status Permohonan
                    </h3>
                </div>

                <!-- Card Content -->
                <div class="p-6">
                    <!-- Current Status -->
                    <div class="flex items-center gap-3 p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl border border-gray-200 dark:border-gray-600 mb-4">
                        <div class="relative">
                            <div class="absolute inset-0 {{ $permit->status === 'pending' ? 'bg-amber-400' : ($permit->status === 'approved' ? 'bg-emerald-400' : 'bg-rose-400') }} rounded-full blur-sm opacity-50"></div>
                            <div class="relative w-3 h-3 {{ $permit->status === 'pending' ? 'bg-amber-500' : ($permit->status === 'approved' ? 'bg-emerald-500' : 'bg-rose-500') }} rounded-full {{ $permit->status === 'pending' ? 'animate-pulse' : '' }}"></div>
                        </div>
                        <div class="flex-1">
                            <p class="font-bold text-gray-900 dark:text-white capitalize">{{ $permit->status }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Status saat ini</p>
                        </div>
                    </div>

                    <!-- Status Message -->
                    @if($permit->status === 'approved')
                    <div class="p-4 bg-gradient-to-r from-emerald-50 to-green-50 dark:from-emerald-900/20 dark:to-green-900/10 rounded-xl border border-emerald-200 dark:border-emerald-700">
                        <p class="text-sm text-emerald-800 dark:text-emerald-300 flex items-start gap-2">
                            <i class="bi bi-check-circle-fill text-emerald-500 mt-0.5"></i>
                            <span>Permohonan telah disetujui. Surat SPOG resmi dapat diunduh di atas.</span>
                        </p>
                    </div>
                    @elseif($permit->status === 'rejected')
                    <div class="p-4 bg-gradient-to-r from-rose-50 to-red-50 dark:from-rose-900/20 dark:to-red-900/10 rounded-xl border border-rose-200 dark:border-rose-700">
                        <p class="text-sm text-rose-800 dark:text-rose-300 flex items-start gap-2">
                            <i class="bi bi-x-circle-fill text-rose-500 mt-0.5"></i>
                            <span>Permohonan ditolak. Silakan klik tombol "Perbaiki Data" untuk mengedit dan ajukan kembali.</span>
                        </p>
                    </div>
                    @else
                    <div class="p-4 bg-gradient-to-r from-amber-50 to-orange-50 dark:from-amber-900/20 dark:to-orange-900/10 rounded-xl border border-amber-200 dark:border-amber-700">
                        <p class="text-sm text-amber-800 dark:text-amber-300 flex items-start gap-2">
                            <i class="bi bi-clock-fill text-amber-500 mt-0.5"></i>
                            <span>Permohonan sedang diproses. Mohon tunggu konfirmasi dari administrator.</span>
                        </p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Master Declaration Card -->
            <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                <!-- Card Header -->
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-600">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                        <div class="w-8 h-8 bg-gradient-to-br from-blue-400 to-indigo-500 rounded-lg flex items-center justify-center shadow-sm">
                            <i class="bi bi-shield-check text-white text-sm"></i>
                        </div>
                        Pernyataan Nakhoda
                    </h3>
                </div>

                <!-- Card Content -->
                <div class="p-6">
                    <ul class="space-y-3">
                        <li class="flex items-start gap-3 p-3 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                            <i class="bi bi-check-circle-fill text-emerald-500 mt-0.5 flex-shrink-0"></i>
                            <span class="text-sm font-medium text-gray-900 dark:text-white">Sertifikat masih berlaku</span>
                        </li>
                        <li class="flex items-start gap-3 p-3 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                            <i class="bi bi-check-circle-fill text-emerald-500 mt-0.5 flex-shrink-0"></i>
                            <span class="text-sm font-medium text-gray-900 dark:text-white">Tidak mengganggu alur kapal</span>
                        </li>
                        <li class="flex items-start gap-3 p-3 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                            <i class="bi bi-check-circle-fill text-emerald-500 mt-0.5 flex-shrink-0"></i>
                            <span class="text-sm font-medium text-gray-900 dark:text-white">Alat keselamatan lengkap (life jacket)</span>
                        </li>
                        <li class="flex items-start gap-3 p-3 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                            <i class="bi bi-check-circle-fill text-emerald-500 mt-0.5 flex-shrink-0"></i>
                            <span class="text-sm font-medium text-gray-900 dark:text-white">SKK 30 mil Nakhoda masih berlaku</span>
                        </li>
                        <li class="flex items-start gap-3 p-3 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                            <i class="bi bi-check-circle-fill text-emerald-500 mt-0.5 flex-shrink-0"></i>
                            <span class="text-sm font-medium text-gray-900 dark:text-white">Kegiatan hanya di Perairan Bandar</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
