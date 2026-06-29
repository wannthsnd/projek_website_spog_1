@extends('layouts.app')
@section('title', 'Edit Permohonan - ' . $permit->ship_type)

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center gap-4">
            <a href="{{ route('permohonan.detail', $permit->id) }}"
               class="w-12 h-12 bg-white dark:bg-gray-800 rounded-xl flex items-center justify-center hover:bg-gray-50 dark:hover:bg-gray-700 transition-all shadow-sm border border-gray-200 dark:border-gray-700">
                <i class="bi bi-arrow-left text-lg text-gray-700 dark:text-gray-300"></i>
            </a>
            <div>
                <h1 class="text-2xl lg:text-3xl font-bold text-gray-900 dark:text-white mb-1">Edit Permohonan</h1>
                <p class="text-gray-600 dark:text-gray-400 font-medium">{{ $permit->ship_type }} - {{ $permit->ship_name ?? 'Tanpa Nama' }}</p>
            </div>
        </div>
    </div>

    <!-- Status Alert -->
    @if($permit->status === 'rejected')
    <div class="mb-6 p-4 bg-rose-50 dark:bg-rose-900/20 border border-rose-200 dark:border-rose-700 rounded-xl">
        <div class="flex items-start gap-3">
            <i class="bi bi-exclamation-circle text-rose-600 dark:text-rose-400 text-xl"></i>
            <div>
                <p class="font-semibold text-rose-800 dark:text-rose-300">Permohonan Ditolak</p>
                <p class="text-sm text-rose-700 dark:text-rose-400 mt-1">{{ $permit->rejection_notes ?? 'Tidak ada catatan penolakan.' }}</p>
                <p class="text-xs text-rose-600 dark:text-rose-500 mt-2">Silakan perbaiki data dan submit ulang. Status akan berubah menjadi Pending.</p>
            </div>
        </div>
    </div>
    @endif

    <!-- Success/Error Messages -->
    @if(session('success'))
    <div class="mb-6 p-4 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-700 rounded-xl">
        <p class="text-emerald-800 dark:text-emerald-300 font-medium">{{ session('success') }}</p>
    </div>
    @endif

    @if(session('error'))
    <div class="mb-6 p-4 bg-rose-50 dark:bg-rose-900/20 border border-rose-200 dark:border-rose-700 rounded-xl">
        <p class="text-rose-800 dark:text-rose-300 font-medium">{{ session('error') }}</p>
    </div>
    @endif

    <!-- Form -->
    <form action="{{ route('permohonan.update', $permit->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Identitas Pemohon -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                <i class="bi bi-person text-amber-500"></i>
                Identitas Pemohon
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Email <span class="text-red-500">*</span>
                    </label>
                    <input type="email" name="email" value="{{ old('email', $permit->email) }}" required
                        class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl focus:outline-none focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 text-gray-900 dark:text-white @error('email') border-red-500 @enderror">
                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" value="{{ old('name', $permit->name) }}" required
                        class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl focus:outline-none focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 text-gray-900 dark:text-white @error('name') border-red-500 @enderror">
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <!-- Data Kapal -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                <i class="bi bi-ship text-amber-500"></i>
                Data Kapal
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- ✅ TAMBAHKAN: Nama Kapal -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Nama Kapal <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="ship_name" value="{{ old('ship_name', $permit->ship_name) }}" required
                        class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl focus:outline-none focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 text-gray-900 dark:text-white @error('ship_name') border-red-500 @enderror">
                    @error('ship_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Jenis Kapal <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="ship_type" value="{{ old('ship_type', $permit->ship_type) }}" required
                        class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl focus:outline-none focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 text-gray-900 dark:text-white @error('ship_type') border-red-500 @enderror">
                    @error('ship_type') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- ✅ TAMBAHKAN: Bendera -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Bendera <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="flag" value="{{ old('flag', $permit->flag) }}" required
                        class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl focus:outline-none focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 text-gray-900 dark:text-white @error('flag') border-red-500 @enderror"
                        placeholder="Contoh: Indonesia">
                    @error('flag') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- ✅ TAMBAHKAN: Gross Tonnage -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Isi Kotor (GT) <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="gross_tonnage" value="{{ old('gross_tonnage', $permit->gross_tonnage) }}" required min="1"
                        class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl focus:outline-none focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 text-gray-900 dark:text-white @error('gross_tonnage') border-red-500 @enderror">
                    @error('gross_tonnage') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Jumlah Penumpang <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="passenger_count" value="{{ old('passenger_count', $permit->passenger_count) }}" required min="1"
                        class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl focus:outline-none focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 text-gray-900 dark:text-white @error('passenger_count') border-red-500 @enderror">
                    @error('passenger_count') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Nama Nakhoda <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="captain_name" value="{{ old('captain_name', $permit->captain_name) }}" required
                        class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl focus:outline-none focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 text-gray-900 dark:text-white @error('captain_name') border-red-500 @enderror">
                    @error('captain_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Pemilik/Agent <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="owner_agent" value="{{ old('owner_agent', $permit->owner_agent) }}" required
                        class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl focus:outline-none focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 text-gray-900 dark:text-white @error('owner_agent') border-red-500 @enderror">
                    @error('owner_agent') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Bergerak Dari <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="departure_location" value="{{ old('departure_location', $permit->departure_location) }}" required
                        class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl focus:outline-none focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 text-gray-900 dark:text-white @error('departure_location') border-red-500 @enderror">
                    @error('departure_location') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- ✅ TAMBAHKAN: Tujuan -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Tujuan <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="destination" value="{{ old('destination', $permit->destination) }}" required
                        class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl focus:outline-none focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 text-gray-900 dark:text-white @error('destination') border-red-500 @enderror"
                        placeholder="Contoh: Dalam DLKr Pelabuhan Tanjung Priok">
                    @error('destination') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Waktu Gerak <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="movement_time" value="{{ old('movement_time', $permit->movement_time) }}" required
                        class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl focus:outline-none focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 text-gray-900 dark:text-white @error('movement_time') border-red-500 @enderror"
                        placeholder="Contoh: 08:00 WIB">
                    @error('movement_time') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Keperluan <span class="text-red-500">*</span>
                    </label>
                    <textarea name="purpose" rows="4" required
                        class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl focus:outline-none focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 text-gray-900 dark:text-white resize-none @error('purpose') border-red-500 @enderror">{{ old('purpose', $permit->purpose) }}</textarea>
                    @error('purpose') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Tanggal Pengajuan <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="application_date" value="{{ old('application_date', $permit->application_date ? $permit->application_date->format('Y-m-d') : date('Y-m-d')) }}" required
                        class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl focus:outline-none focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 text-gray-900 dark:text-white @error('application_date') border-red-500 @enderror">
                    @error('application_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <!-- Dokumen (Optional saat edit) -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                <i class="bi bi-files text-amber-500"></i>
                Dokumen (Opsional - Upload hanya jika ingin mengganti)
            </h3>

            @php
            $documents = [
                1 => 'Surat Permohonan',
                2 => 'Surat Pernyataan Nakhoda',
                3 => 'Fotokopi Data Awak Kapal',
                4 => 'Dokumen Kapal Asli',
                5 => 'Manifest Penumpang',
                6 => 'Manifest Muatan',
                7 => 'SPOG Sesuai Jenis'
            ];
            @endphp

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($documents as $num => $name)
                <div class="p-4 border border-gray-200 dark:border-gray-700 rounded-xl bg-gray-50 dark:bg-gray-700/50">
                    <p class="font-medium text-gray-900 dark:text-white text-sm mb-2">{{ $num }}. {{ $name }}</p>

                    @php
                        $docField = "document_{$num}";
                        $hasDoc = !empty($permit->$docField);
                    @endphp

                    @if($hasDoc)
                    <div class="mb-3">
                        <a href="{{ route('permohonan.download', ['id' => $permit->id, 'document' => $num, 'action' => 'view']) }}"
                           target="_blank"
                           class="text-xs text-amber-600 dark:text-amber-400 hover:underline flex items-center gap-1">
                            <i class="bi bi-eye"></i>
                            Lihat dokumen saat ini
                        </a>
                    </div>
                    @endif

                    <input type="file" name="document_{{ $num }}" accept=".pdf"
                        class="w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-amber-50 dark:file:bg-amber-900/30 file:text-amber-700 dark:file:text-amber-300 hover:file:bg-amber-100 dark:hover:file:bg-amber-900/50">
                    <p class="text-xs text-gray-400 mt-1">Kosongkan jika tidak ingin mengganti</p>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex gap-4">
            <a href="{{ route('permohonan.detail', $permit->id) }}"
               class="flex-1 px-6 py-3 bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white rounded-xl font-semibold hover:bg-gray-300 dark:hover:bg-gray-600 transition-all text-center">
                Batal
            </a>
            <button type="submit"
                    class="flex-1 px-6 py-3 bg-gradient-to-r from-amber-500 to-orange-500 text-white rounded-xl font-semibold hover:from-amber-600 hover:to-orange-600 transition-all shadow-md hover:shadow-lg">
                <i class="bi bi-check-circle mr-2"></i>
                Update Permohonan
            </button>
        </div>
    </form>
</div>
@endsection
