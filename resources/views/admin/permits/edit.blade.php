@extends('layouts.app')
@section('title', 'Edit Permohonan - Admin')

@section('content')
<div class="max-w-5xl mx-auto">
    <!-- Header -->
    <div class="mb-8 flex items-center justify-between">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.permits.show', $permit->id) }}"
               class="w-12 h-12 bg-gray-200 dark:bg-gray-700 rounded-xl flex items-center justify-center hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors">
                <i class="bi bi-arrow-left text-xl text-gray-900 dark:text-white"></i>
            </a>
            <div>
                <h1 class="text-3xl font-semibold text-gray-900 dark:text-white mb-1">Edit Permohonan</h1>
                <p class="text-gray-800 dark:text-gray-200 font-semibold">Perbarui data permohonan #{{ $permit->id }}</p>
            </div>
        </div>
        <span class="px-4 py-2 rounded-full text-sm font-extrabold {{ $permit->status_badge }}">
            {{ ucfirst($permit->status) }}
        </span>
    </div>

    <!-- Form Edit -->
    <form action="{{ route('admin.permits.update', $permit->id) }}" method="POST" enctype="multipart/form-data"
          class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl p-8 border-2 border-gray-200 dark:border-gray-700">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Email -->
            <div class="space-y-2">
                <label class="block text-sm font-semibold text-gray-900 dark:text-white">
                    <i class="bi bi-envelope text-primary-600 mr-2"></i>Email
                </label>
                <input type="email" name="email" value="{{ old('email', $permit->email) }}"semibold
                    class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border-2 border-gray-300 dark:border-gray-600 rounded-xl focus:outline-none focus:border-primary-500 transition-all text-gray-900 dark:text-white font-"
                    required>
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Nama Pemohon -->
            <div class="space-y-2">
                <label class="block text-sm font-semibold text-gray-900 dark:text-white">
                    <i class="bi bi-person text-primary-600 mr-2"></i>Nama Pemohon
                </label>
                <input type="text" name="name" value="{{ old('name', $permit->name) }}"
                    class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border-2 border-gray-300 dark:border-gray-600 rounded-xl focus:outline-none focus:border-primary-500 transition-all text-gray-900 dark:text-white font-semibold"
                    required>
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Nama Kapal -->
            <div class="space-y-2">
                <label class="block text-sm font-semibold text-gray-900 dark:text-white">
                    <i class="bi bi-ship text-primary-600 mr-2"></i>Nama Kapal
                </label>
                <input type="text" name="ship_name" value="{{ old('ship_name', $permit->ship_name) }}"
                    class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border-2 border-gray-300 dark:border-gray-600 rounded-xl focus:outline-none focus:border-primary-500 transition-all text-gray-900 dark:text-white font-semibold"
                    placeholder="Contoh: KM. Bahari Jaya" required>
                @error('ship_name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Jenis Kapal -->
            <div class="space-y-2">
                <label class="block text-sm font-semibold text-gray-900 dark:text-white">
                    <i class="bi bi-truck text-primary-600 mr-2"></i>Jenis Kapal
                </label>
                <select name="ship_type"
                    class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border-2 border-gray-300 dark:border-gray-600 rounded-xl focus:outline-none focus:border-primary-500 transition-all text-gray-900 dark:text-white font-semibold"
                    required>
                    <option value="">-- Pilih Jenis Kapal --</option>
                    <option value="Kapal Penumpang" {{ old('ship_type', $permit->ship_type) == 'Kapal Penumpang' ? 'selected' : '' }}>Kapal Penumpang</option>
                    <option value="Kapal Barang" {{ old('ship_type', $permit->ship_type) == 'Kapal Barang' ? 'selected' : '' }}>Kapal Barang</option>
                    <option value="Kapal Nelayan" {{ old('ship_type', $permit->ship_type) == 'Kapal Nelayan' ? 'selected' : '' }}>Kapal Nelayan</option>
                    <option value="Kapal Wisata" {{ old('ship_type', $permit->ship_type) == 'Kapal Wisata' ? 'selected' : '' }}>Kapal Wisata</option>
                    <option value="Kapal Cepat" {{ old('ship_type', $permit->ship_type) == 'Kapal Cepat' ? 'selected' : '' }}>Kapal Cepat</option>
                    <option value="Kapal Tradisional" {{ old('ship_type', $permit->ship_type) == 'Kapal Tradisional' ? 'selected' : '' }}>Kapal Tradisional</option>
                    <option value="Lainnya" {{ old('ship_type', $permit->ship_type) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                </select>
                @error('ship_type')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Jumlah Penumpang -->
            <div class="space-y-2">
                <label class="block text-sm font-semibold text-gray-900 dark:text-white">
                    <i class="bi bi-people text-primary-600 mr-2"></i>Jumlah Penumpang
                </label>
                <input type="number" name="passenger_count" value="{{ old('passenger_count', $permit->passenger_count) }}"
                    class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border-2 border-gray-300 dark:border-gray-600 rounded-xl focus:outline-none focus:border-primary-500 transition-all text-gray-900 dark:text-white font-semibold"
                    min="1" required>
                @error('passenger_count')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Nama Nahkoda -->
            <div class="space-y-2">
                <label class="block text-sm font-semibold text-gray-900 dark:text-white">
                    <i class="bi bi-person-badge text-primary-600 mr-2"></i>Nama Nahkoda
                </label>
                <input type="text" name="captain_name" value="{{ old('captain_name', $permit->captain_name) }}"
                    class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border-2 border-gray-300 dark:border-gray-600 rounded-xl focus:outline-none focus:border-primary-500 transition-all text-gray-900 dark:text-white font-semibold"
                    required>
                @error('captain_name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Milik / Agen -->
            <div class="space-y-2">
                <label class="block text-sm font-semibold text-gray-900 dark:text-white">
                    <i class="bi bi-building text-primary-600 mr-2"></i>Milik / Agen
                </label>
                <input type="text" name="owner_agent" value="{{ old('owner_agent', $permit->owner_agent) }}"
                    class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border-2 border-gray-300 dark:border-gray-600 rounded-xl focus:outline-none focus:border-primary-500 transition-all text-gray-900 dark:text-white font-semibold"
                    required>
                @error('owner_agent')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Bergerak Dari -->
            <div class="space-y-2">
                <label class="block text-sm font-semibold text-gray-900 dark:text-white">
                    <i class="bi bi-geo-alt text-primary-600 mr-2"></i>Bergerak Dari
                </label>
                <input type="text" name="departure_location" value="{{ old('departure_location', $permit->departure_location) }}"
                    class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border-2 border-gray-300 dark:border-gray-600 rounded-xl focus:outline-none focus:border-primary-500 transition-all text-gray-900 dark:text-white font-semibold"
                    required>
                @error('departure_location')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Waktu Gerak -->
            <div class="space-y-2">
                <label class="block text-sm font-semibold text-gray-900 dark:text-white">
                    <i class="bi bi-clock text-primary-600 mr-2"></i>Waktu Gerak
                </label>
                <input type="text" name="movement_time" value="{{ old('movement_time', $permit->movement_time) }}"
                    class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border-2 border-gray-300 dark:border-gray-600 rounded-xl focus:outline-none focus:border-primary-500 transition-all text-gray-900 dark:text-white font-semibold"
                    required>
                @error('movement_time')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Status -->
            <div class="space-y-2">
                <label class="block text-sm font-semibold text-gray-900 dark:text-white">
                    <i class="bi bi-flag text-primary-600 mr-2"></i>Status
                </label>
                <select name="status"
                    class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border-2 border-gray-300 dark:border-gray-600 rounded-xl focus:outline-none focus:border-primary-500 transition-all text-gray-900 dark:text-white font-semibold"
                    required>
                    <option value="pending" {{ old('status', $permit->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ old('status', $permit->status) == 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="rejected" {{ old('status', $permit->status) == 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
                @error('status')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Keperluan (Full Width) -->
            <div class="space-y-2 md:col-span-2">
                <label class="block text-sm font-semibold text-gray-900 dark:text-white">
                    <i class="bi bi-file-text text-primary-600 mr-2"></i>Keperluan
                </label>
                <textarea name="purpose" rows="4"
                    class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border-2 border-gray-300 dark:border-gray-600 rounded-xl focus:outline-none focus:border-primary-500 transition-all text-gray-900 dark:text-white font-semibold"
                    required>{{ old('purpose', $permit->purpose) }}</textarea>
                @error('purpose')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tanggal Pengajuan (Full Width) -->
            <div class="space-y-2 md:col-span-2">
                <label class="block text-sm font-semibold text-gray-900 dark:text-white">
                    <i class="bi bi-calendar text-primary-600 mr-2"></i>Tanggal Pengajuan
                </label>
                <input type="date" name="application_date" value="{{ old('application_date', $permit->application_date ? $permit->application_date->format('Y-m-d') : '') }}"
                    class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border-2 border-gray-300 dark:border-gray-600 rounded-xl focus:outline-none focus:border-primary-500 transition-all text-gray-900 dark:text-white font-semibold"
                    required>
                @error('application_date')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Dokumen Section -->
        <div class="mt-8 border-t-2 border-gray-200 dark:border-gray-700 pt-8">
            <h3 class="text-2xl font-semibold text-gray-900 dark:text-white mb-6 flex items-center gap-3">
                <i class="bi bi-files text-primary-600 text-3xl"></i>
                Upload Dokumen (Kosongkan jika tidak ingin mengubah)
            </h3>

            @php
            $documents = [
                1 => 'Surat Pernyataan Nahkoda',
                2 => 'Master Declaration',
                3 => 'Data Awak Kapal',
                4 => 'Dokumen Kapal Asli',
                5 => 'Manifest Penumpang',
                6 => 'Manifest Muatan',
                7 => 'SPOG Sesuai Jenis Kapal'
            ];
            @endphp

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($documents as $num => $label)
                <div class="bg-gray-50 dark:bg-gray-700 rounded-xl p-4 border-2 border-gray-300 dark:border-gray-600 hover:border-primary-400 transition-all">
                    <label class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">
                        Dokumen {{ $num }}: {{ $label }}
                    </label>
                    @if($permit->{"document_{$num}"})
                    <div class="mb-3 p-3 bg-green-50 dark:bg-green-900/20 rounded-lg border-2 border-green-300 dark:border-green-700">
                        <p class="text-xs font-semibold text-green-800 dark:text-green-400">
                            <i class="bi bi-check-circle mr-1"></i>Dokumen sudah ada
                        </p>
                        <a href="{{ route('admin.permits.download', [$permit->id, $num, 'view']) }}"
                           target="_blank"
                           class="text-xs text-blue-600 dark:text-blue-400 hover:underline font-semibold mt-1 inline-block">
                            <i class="bi bi-eye mr-1"></i>Lihat dokumen
                        </a>
                    </div>
                    @endif
                    <input type="file" name="document_{{ $num }}" accept=".pdf"
                        class="w-full px-4 py-3 bg-white dark:bg-gray-800 border-2 border-gray-300 dark:border-gray-600 rounded-xl focus:outline-none focus:border-primary-500 transition-all text-gray-900 dark:text-white font-extrabold cursor-pointer">
                    <p class="text-xs text-gray-600 dark:text-gray-400 mt-2 font-semibold">Format: PDF (Maks. 10MB)</p>
                    @error("document_{$num}")
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                @endforeach
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="mt-8 flex gap-4">
            <a href="{{ route('admin.permits.show', $permit->id) }}"
               class="flex-1 px-6 py-4 bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white rounded-xl font-extrabold hover:bg-gray-300 dark:hover:bg-gray-600 transition-all text-center">
                Batal
            </a>
            <button type="submit"
               class="flex-1 px-6 py-4 gradient-primary text-white rounded-xl font-extrabold shadow-xl hover:shadow-2xl hover:scale-105 transition-all duration-300 flex items-center justify-center gap-3">
                <i class="bi bi-check-circle text-xl"></i>
                <span>Simpan Perubahan</span>
            </button>
        </div>
    </form>
</div>
@endsection
