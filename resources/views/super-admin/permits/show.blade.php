@extends('layouts.app')
@section('title', 'Detail Permohonan #' . $permit->id)

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="flex items-center gap-4">
                <a href="{{ route('super-admin.permits.index') }}"
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
                    <p class="text-gray-600 dark:text-gray-400 font-medium">Informasi lengkap permohonan SPOG</p>
                </div>
            </div>

            <div class="flex flex-wrap gap-3 items-center">
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
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="xl:col-span-2 space-y-6">

            <!-- Applicant Information -->
            <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-600">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                        <div class="w-8 h-8 bg-gradient-to-br from-amber-400 to-orange-500 rounded-lg flex items-center justify-center shadow-sm">
                            <i class="bi bi-person-badge text-white text-sm"></i>
                        </div>
                        Informasi Pemohon
                    </h3>
                </div>
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

            <!-- Ship & Voyage Data -->
            <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-600">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                        <div class="w-8 h-8 bg-gradient-to-br from-blue-400 to-indigo-500 rounded-lg flex items-center justify-center shadow-sm">
                            <i class="bi bi-ship text-white text-sm"></i>
                        </div>
                        Data Kapal & Perjalanan
                    </h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl sm:col-span-2">
                            <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Nama Kapal</p>
                            <p class="text-base font-bold text-gray-900 dark:text-white">{{ $permit->ship_name ?? '-' }}</p>
                        </div>
                        <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                            <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Nama Nahkoda</p>
                            <p class="text-base font-bold text-gray-900 dark:text-white">{{ $permit->captain_name }}</p>
                        </div>
                        <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                            <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Milik / Agen</p>
                            <p class="text-base font-bold text-gray-900 dark:text-white">{{ $permit->owner_agent }}</p>
                        </div>
                        <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                            <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Bergerak Dari</p>
                            <p class="text-base font-bold text-gray-900 dark:text-white">{{ $permit->departure_location }}</p>
                        </div>
                        <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                            <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Waktu Gerak</p>
                            <p class="text-base font-bold text-gray-900 dark:text-white">{{ $permit->movement_time }}</p>
                        </div>
                        <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl sm:col-span-2">
                            <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Tanggal Pengajuan</p>
                            <p class="text-base font-bold text-gray-900 dark:text-white">
                                {{ $permit->application_date->format('l, d F Y') }}
                                <span class="text-sm font-normal text-gray-500 dark:text-gray-400 ml-2">
                                    {{ $permit->application_date->format('H:i') }} WIB
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Purpose -->
            <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-600">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                        <div class="w-8 h-8 bg-gradient-to-br from-purple-400 to-pink-500 rounded-lg flex items-center justify-center shadow-sm">
                            <i class="bi bi-file-text text-white text-sm"></i>
                        </div>
                        Keperluan Olah Gerak
                    </h3>
                </div>
                <div class="p-6">
                    <div class="p-4 bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-700/50 dark:to-gray-600/50 rounded-xl border border-gray-200 dark:border-gray-600">
                        <p class="text-gray-800 dark:text-gray-200 leading-relaxed whitespace-pre-wrap">{{ $permit->purpose }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">

            <!-- Status Timeline -->
            <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-600">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                        <div class="w-8 h-8 bg-gradient-to-br from-emerald-400 to-green-600 rounded-lg flex items-center justify-center shadow-sm">
                            <i class="bi bi-clock-history text-white text-sm"></i>
                        </div>
                        Status & Aksi
                    </h3>
                </div>
                <div class="p-6 space-y-4">
                    @if($permit->status === 'pending')
                    <form action="{{ route('super-admin.permits.update-status', $permit->id) }}" method="POST" class="space-y-3">
                        @csrf
                        <button type="submit" name="status" value="approved"
                                class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-gradient-to-r from-emerald-500 to-green-600 text-white rounded-xl font-semibold hover:from-emerald-600 hover:to-green-700 transition-all shadow-md hover:shadow-lg">
                            <i class="bi bi-check-circle"></i>
                            <span>Setujui Permohonan</span>
                        </button>
                        <button type="submit" name="status" value="rejected"
                                class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-gradient-to-r from-rose-500 to-red-600 text-white rounded-xl font-semibold hover:from-rose-600 hover:to-red-700 transition-all shadow-md hover:shadow-lg">
                            <i class="bi bi-x-circle"></i>
                            <span>Tolak Permohonan</span>
                        </button>
                    </form>
                    @else
                    <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl text-center">
                        <p class="text-sm text-gray-600 dark:text-gray-400">Status permohonan sudah diproses</p>
                    </div>
                    @endif

                    <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                        <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-2">Dibuat</p>
                        <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $permit->created_at->format('d M Y, H:i') }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $permit->created_at->diffForHumans() }}</p>
                    </div>

                    <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                        <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-2">Terakhir Diupdate</p>
                        <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $permit->updated_at->format('d M Y, H:i') }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $permit->updated_at->diffForHumans() }}</p>
                    </div>
                </div>
            </div>

            <!-- Documents -->
            <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-600">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                        <div class="w-8 h-8 bg-gradient-to-br from-red-400 to-orange-500 rounded-lg flex items-center justify-center shadow-sm">
                            <i class="bi bi-files text-white text-sm"></i>
                        </div>
                        Dokumen Pendukung
                    </h3>
                </div>
                <div class="p-4 space-y-3">
                    @php
                    $docNames = [
                        1 => 'Surat Pernyataan Nahkoda',
                        2 => 'Data Awak Kapal',
                        3 => 'Dokumen Kapal Asli',
                        4 => 'Manifest Penumpang',
                        5 => 'Manifest Muatan',

                    ];
                    @endphp

                    @foreach($docNames as $num => $name)
                    @php
                        $docField = "document_{$num}";
                    @endphp
                    @if($permit->$docField)
                    <div class="flex items-center gap-3 p-3 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                        <div class="w-10 h-10 bg-gradient-to-br from-red-400 to-orange-500 rounded-lg flex items-center justify-center">
                            <i class="bi bi-file-pdf text-white"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-gray-900 dark:text-white text-sm truncate">Dokumen {{ $num }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ $name }}</p>
                        </div>
                        <a href="{{ route('admin.permits.download', [$permit->id, $num, 'view']) }}"
                           target="_blank"
                           class="inline-flex items-center justify-center w-8 h-8 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-lg hover:bg-blue-200 dark:hover:bg-blue-900/50 transition-all">
                            <i class="bi bi-eye text-sm"></i>
                        </a>
                    </div>
                    @endif
                    @endforeach
                </div>
            </div>

            <!-- User Info -->
            @if($permit->user)
            <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-600">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                        <div class="w-8 h-8 bg-gradient-to-br from-blue-400 to-cyan-500 rounded-lg flex items-center justify-center shadow-sm">
                            <i class="bi bi-person text-white text-sm"></i>
                        </div>
                        Informasi User
                    </h3>
                </div>
                <div class="p-6">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-400 to-cyan-500 rounded-xl flex items-center justify-center text-white font-bold text-lg">
                            {{ substr($permit->user->name, 0, 1) }}
                        </div>
                        <div>
                            <p class="font-bold text-gray-900 dark:text-white">{{ $permit->user->name }}</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ ucfirst($permit->user->role) }}</p>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <div class="flex justify-between py-2 border-b border-gray-200 dark:border-gray-700">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Email</span>
                            <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $permit->user->email }}</span>
                        </div>
                        <div class="flex justify-between py-2">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Terdaftar</span>
                            <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $permit->user->created_at->format('d M Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
