@extends('layouts.app')
@section('title', 'Tambah Permohonan')

@push('styles')
<style>
    .step-active {
        background: linear-gradient(135deg, #FCD34D 0%, #F59E0B 100%);
        transform: scale(1.1);
    }
    .step-completed {
        background: linear-gradient(135deg, #10B981 0%, #059669 100%);
    }
    .upload-zone {
        transition: all 0.3s ease;
    }
    .upload-zone:hover {
        border-color: #FCD34D;
        transform: translateY(-2px);
        box-shadow: 0 10px 30px rgba(252, 211, 77, 0.2);
    }
    .upload-zone.dragover {
        border-color: #FCD34D;
        background: rgba(252, 211, 77, 0.1);
    }
    /* Time picker styling */
    input[type="time"] {
        cursor: pointer;
    }
    input[type="time"]::-webkit-calendar-picker-indicator {
        filter: invert(0.5);
        cursor: pointer;
    }
    .dark input[type="time"]::-webkit-calendar-picker-indicator {
        filter: invert(0.8);
    }
</style>
@endpush

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-8 text-center">
        <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-amber-400 to-orange-500 rounded-3xl shadow-2xl mb-6">
            <i class="bi bi-file-earmark-plus text-4xl text-white"></i>
        </div>
        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-3">
            Ajukan <span class="text-amber-600 dark:text-amber-400">Permohonan SPOG</span>
        </h1>
        <p class="text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
            Isi formulir berikut sesuai persyaratan Permenhub No. 28 Tahun 2022
        </p>
    </div>

    <!-- Stepper -->
    <div class="relative mb-8">
        <div class="absolute top-1/2 left-0 right-0 h-1 bg-gray-200 dark:bg-gray-700 -translate-y-1/2 rounded-full"></div>
        <div class="relative flex justify-between">
            @foreach(['Identitas', 'Data Kapal', 'Dokumen', 'Konfirmasi'] as $i => $step)
            <div class="flex flex-col items-center z-10">
                <div class="step-indicator w-12 h-12 rounded-full bg-gray-300 dark:bg-gray-600 flex items-center justify-center text-white font-bold shadow transition-all duration-300 step-active" data-step="{{ $i + 1 }}">
                    <i class="bi bi-check-lg text-lg" style="display: none;" id="check-{{ $i + 1 }}"></i>
                    <span id="num-{{ $i + 1 }}">{{ $i + 1 }}</span>
                </div>
                <p class="mt-2 font-medium text-gray-700 dark:text-gray-300 text-xs md:text-sm">{{ $step }}</p>
            </div>
            @endforeach
        </div>
    </div>

    <form action="{{ route('permohonan.store') }}" method="POST" enctype="multipart/form-data" id="permohonanForm">
        @csrf

        <!-- Step 1: Identitas -->
        <div class="step-content bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 md:p-8 border border-gray-200 dark:border-gray-700" id="step-1">
            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                <i class="bi bi-person-badge text-amber-500"></i>
                Identitas Pemohon
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Email <span class="text-red-500">*</span>
                    </label>
                    <input type="email" name="email" value="{{ old('email', auth()->user()->email ?? '') }}" required
                        class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl focus:outline-none focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 text-gray-900 dark:text-white @error('email') border-red-500 @enderror"
                        placeholder="email@example.com">
                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" value="{{ old('name', auth()->user()->name ?? '') }}" required
                        class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl focus:outline-none focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 text-gray-900 dark:text-white @error('name') border-red-500 @enderror"
                        placeholder="Nama Lengkap Pemohon">
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Nama Kapal <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="ship_name" value="{{ old('ship_name') }}" required
                        class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl focus:outline-none focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 text-gray-900 dark:text-white @error('ship_name') border-red-500 @enderror"
                        placeholder="KM. Sinar Jaya">
                    @error('ship_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Jenis Kapal <span class="text-red-500">*</span>
                    </label>
                    <select name="ship_type" required
                        class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl focus:outline-none focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 text-gray-900 dark:text-white @error('ship_type') border-red-500 @enderror">
                        <option value="">Pilih Jenis Kapal</option>
                        <option value="Kapal Penumpang" {{ old('ship_type') == 'Kapal Penumpang' ? 'selected' : '' }}>Kapal Penumpang</option>
                        <option value="Kapal Barang" {{ old('ship_type') == 'Kapal Barang' ? 'selected' : '' }}>Kapal Barang</option>
                        <option value="Kapal Ikan" {{ old('ship_type') == 'Kapal Ikan' ? 'selected' : '' }}>Kapal Ikan</option>
                        <option value="Kapal Wisata" {{ old('ship_type') == 'Kapal Wisata' ? 'selected' : '' }}>Kapal Wisata</option>
                        <option value="Kapal Lainnya" {{ old('ship_type') == 'Kapal Lainnya' ? 'selected' : '' }}>Kapal Lainnya</option>
                    </select>
                    @error('ship_type') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="flex justify-end mt-8">
                <button type="button" onclick="nextStep(1)"
                    class="px-6 py-3 bg-gradient-to-r from-amber-500 to-orange-500 text-white rounded-xl font-semibold hover:from-amber-600 hover:to-orange-600 transition-all shadow-md hover:shadow-lg flex items-center gap-2">
                    <span>Lanjut</span>
                    <i class="bi bi-arrow-right"></i>
                </button>
            </div>
        </div>

        <!-- Step 2: Data Kapal -->
        <div class="step-content bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 md:p-8 border border-gray-200 dark:border-gray-700 hidden" id="step-2">
            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                <i class="bi bi-ship text-amber-500"></i>
                Data Kapal & Perjalanan
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <!-- Bendera -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Bendera Kapal <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="flag" value="{{ old('flag', 'Indonesia') }}" required
                        class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl focus:outline-none focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 text-gray-900 dark:text-white @error('flag') border-red-500 @enderror"
                        placeholder="Indonesia">
                    @error('flag') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Isi Kotor (GT) -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Isi Kotor (GT) <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="gross_tonnage" value="{{ old('gross_tonnage') }}" required min="1"
                        class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl focus:outline-none focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 text-gray-900 dark:text-white @error('gross_tonnage') border-red-500 @enderror"
                        placeholder="500">
                    @error('gross_tonnage') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Nakhoda -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Nama Nakhoda <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="captain_name" value="{{ old('captain_name') }}" required
                        class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl focus:outline-none focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 text-gray-900 dark:text-white @error('captain_name') border-red-500 @enderror"
                        placeholder="Budi Santoso">
                    @error('captain_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Milik/Agent -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Pemilik/Agent <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="owner_agent" value="{{ old('owner_agent') }}" required
                        class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl focus:outline-none focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 text-gray-900 dark:text-white @error('owner_agent') border-red-500 @enderror"
                        placeholder="PT. Samudra Jaya">
                    @error('owner_agent') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Bergerak Dari -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Bergerak Dari <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="departure_location" value="{{ old('departure_location') }}" required
                        class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl focus:outline-none focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 text-gray-900 dark:text-white @error('departure_location') border-red-500 @enderror"
                        placeholder="Pelabuhan Tanjung Priok">
                    @error('departure_location') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- ✅ Ke (Destination) - BARU -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Ke (DLKr/DLKp) <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="destination" value="{{ old('destination') }}" required
                        class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl focus:outline-none focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 text-gray-900 dark:text-white @error('destination') border-red-500 @enderror"
                        placeholder="Dalam DLKr/DLKp">
                    @error('destination') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Jumlah Penumpang -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Jumlah Penumpang <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="passenger_count" value="{{ old('passenger_count') }}" required min="1"
                        class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl focus:outline-none focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 text-gray-900 dark:text-white @error('passenger_count') border-red-500 @enderror"
                        placeholder="50">
                    @error('passenger_count') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- ✅ Waktu Gerak - TIME PICKER (Tidak Manual) -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Waktu Gerak <span class="text-red-500">*</span>
                    </label>
                    <input type="time" name="movement_time" value="{{ old('movement_time') }}" required
                        class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl focus:outline-none focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 text-gray-900 dark:text-white @error('movement_time') border-red-500 @enderror">
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Pilih waktu dari kalender</p>
                    @error('movement_time') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Keperluan -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Keperluan Olah Gerak <span class="text-red-500">*</span>
                    </label>
                    <textarea name="purpose" rows="4" required
                        class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl focus:outline-none focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 text-gray-900 dark:text-white resize-none @error('purpose') border-red-500 @enderror"
                        placeholder="Jelaskan keperluan olah gerak kapal...">{{ old('purpose') }}</textarea>
                    @error('purpose') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="flex gap-4 mt-8">
                <button type="button" onclick="prevStep(2)"
                    class="px-6 py-3 bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white rounded-xl font-semibold hover:bg-gray-300 dark:hover:bg-gray-600 transition-all flex items-center gap-2">
                    <i class="bi bi-arrow-left"></i>
                    <span>Kembali</span>
                </button>
                <button type="button" onclick="nextStep(2)"
                    class="px-6 py-3 bg-gradient-to-r from-amber-500 to-orange-500 text-white rounded-xl font-semibold hover:from-amber-600 hover:to-orange-600 transition-all shadow-md hover:shadow-lg flex items-center gap-2">
                    <span>Lanjut</span>
                    <i class="bi bi-arrow-right"></i>
                </button>
            </div>
        </div>

        <!-- Step 3: Dokumen -->
        <div class="step-content bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 md:p-8 border border-gray-200 dark:border-gray-700 hidden" id="step-3">
            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                <i class="bi bi-files text-amber-500"></i>
                Unggah Dokumen (PDF, Max 10MB)
            </h3>

            @php
            // 5 Dokumen Wajib sesuai PM 28/2022
            $documents = [
                1 => ['icon' => 'file-earmark-text', 'name' => 'Surat Permohonan'],
                3 => ['icon' => 'file-earmark-person', 'name' => 'Fotokopi Data Awak Kapal'],
                4 => ['icon' => 'file-earmark-ruled', 'name' => 'Dokumen Kapal Asli'],
                5 => ['icon' => 'file-earmark-bar-graph', 'name' => 'Manifest Penumpang'],
                6 => ['icon' => 'file-earmark-bar-graph', 'name' => 'Manifest Muatan']
            ];
            @endphp

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-6">
                @foreach($documents as $num => $doc)
                <div class="upload-zone border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-xl p-5 cursor-pointer hover:border-amber-500 transition-all"
                     onclick="document.getElementById('document_{{ $num }}').click()">
                    <input type="file" id="document_{{ $num }}" name="document_{{ $num }}" accept=".pdf"
                        class="hidden" onchange="updateFileName(this, {{ $num }})" required>

                    <div class="text-center">
                        <div class="w-14 h-14 mx-auto mb-3 bg-gradient-to-br from-amber-400 to-orange-500 rounded-xl flex items-center justify-center">
                            <i class="bi bi-{{ $doc['icon'] }} text-xl text-white"></i>
                        </div>
                        <p class="font-medium text-gray-900 dark:text-white mb-1 text-sm">{{ $doc['name'] }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Dokumen {{ $loop->iteration }}</p>
                        <p id="file_name_{{ $num }}" class="text-xs text-green-600 dark:text-green-400 mt-2 hidden font-medium"></p>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Tanggal Pengajuan -->
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                    Tanggal Pengajuan <span class="text-red-500">*</span>
                </label>
                <input type="date" name="application_date" value="{{ old('application_date', date('Y-m-d')) }}" required
                    class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl focus:outline-none focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 text-gray-900 dark:text-white @error('application_date') border-red-500 @enderror">
                @error('application_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex gap-4 mt-8">
                <button type="button" onclick="prevStep(3)"
                    class="px-6 py-3 bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white rounded-xl font-semibold hover:bg-gray-300 dark:hover:bg-gray-600 transition-all flex items-center gap-2">
                    <i class="bi bi-arrow-left"></i>
                    <span>Kembali</span>
                </button>
                <button type="button" onclick="nextStep(3)"
                    class="px-6 py-3 bg-gradient-to-r from-amber-500 to-orange-500 text-white rounded-xl font-semibold hover:from-amber-600 hover:to-orange-600 transition-all shadow-md hover:shadow-lg flex items-center gap-2">
                    <span>Konfirmasi</span>
                    <i class="bi bi-arrow-right"></i>
                </button>
            </div>
        </div>

        <!-- Step 4: Konfirmasi -->
        <div class="step-content bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 md:p-8 border border-gray-200 dark:border-gray-700 hidden" id="step-4">
            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                <i class="bi bi-check-circle text-amber-500"></i>
                Konfirmasi Permohonan
            </h3>

            <div class="bg-amber-50 dark:bg-amber-900/20 rounded-xl p-5 mb-6 border border-amber-200 dark:border-amber-700">
                <h4 class="font-semibold text-amber-800 dark:text-amber-300 mb-3 flex items-center gap-2">
                    <i class="bi bi-exclamation-circle"></i>
                    Periksa kembali data berikut:
                </h4>
                <ul class="space-y-2 text-sm text-gray-700 dark:text-gray-300" id="confirmation-data">
                    <!-- Filled by JavaScript -->
                </ul>
            </div>

            <div class="bg-blue-50 dark:bg-blue-900/20 rounded-xl p-5 mb-6 border border-blue-200 dark:border-blue-700">
                <p class="text-sm text-gray-700 dark:text-gray-300 flex items-start gap-2">
                    <i class="bi bi-info-circle text-blue-600 dark:text-blue-400 mt-0.5"></i>
                    <span>Dengan mengirimkan formulir ini, Anda menyatakan bahwa semua data yang diisi adalah benar dan dapat dipertanggungjawabkan sesuai Permenhub No. 28 Tahun 2022.</span>
                </p>
            </div>

            <div class="flex gap-4">
                <button type="button" onclick="prevStep(4)"
                    class="px-6 py-3 bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white rounded-xl font-semibold hover:bg-gray-300 dark:hover:bg-gray-600 transition-all flex items-center gap-2">
                    <i class="bi bi-arrow-left"></i>
                    <span>Kembali</span>
                </button>
                <button type="submit"
                    class="px-6 py-3 bg-gradient-to-r from-emerald-500 to-green-600 text-white rounded-xl font-semibold hover:from-emerald-600 hover:to-green-700 transition-all shadow-md hover:shadow-lg flex items-center gap-2">
                    <i class="bi bi-send"></i>
                    <span>Kirim Permohonan</span>
                </button>
            </div>
        </div>
    </form>
</div>

<script>
let currentStep = 1;
const totalSteps = 4;

function updateStepUI(step) {
    // Hide all steps
    document.querySelectorAll('.step-content').forEach(el => {
        el.classList.add('hidden');
        el.style.opacity = '0';
    });

    // Show current step
    const currentEl = document.getElementById(`step-${step}`);
    currentEl.classList.remove('hidden');
    setTimeout(() => {
        currentEl.style.opacity = '1';
    }, 50);

    // Update stepper indicators
    for (let i = 1; i <= totalSteps; i++) {
        const indicator = document.querySelector(`[data-step="${i}"]`);
        const checkIcon = document.getElementById(`check-${i}`);
        const numIcon = document.getElementById(`num-${i}`);

        if (i < step) {
            indicator.classList.remove('bg-gray-300', 'dark:bg-gray-600');
            indicator.classList.add('step-completed');
            checkIcon.style.display = 'block';
            numIcon.style.display = 'none';
        } else if (i === step) {
            indicator.classList.remove('bg-gray-300', 'dark:bg-gray-600', 'step-completed');
            indicator.classList.add('step-active');
            checkIcon.style.display = 'none';
            numIcon.style.display = 'block';
        } else {
            indicator.classList.remove('step-active', 'step-completed');
            indicator.classList.add('bg-gray-300', 'dark:bg-gray-600');
            checkIcon.style.display = 'none';
            numIcon.style.display = 'block';
        }
    }
    currentStep = step;
}

function nextStep(step) {
    if (validateStep(step)) {
        updateStepUI(step + 1);
        if (step + 1 === 4) updateConfirmation();
    }
}

function prevStep(step) {
    updateStepUI(step - 1);
}

function validateStep(step) {
    const stepContent = document.getElementById(`step-${step}`);
    const inputs = stepContent.querySelectorAll('input[required], textarea[required], select[required]');
    let valid = true;

    inputs.forEach(input => {
        if (!input.value.trim() && input.type !== 'file') {
            input.classList.add('border-red-500');
            valid = false;
        } else {
            input.classList.remove('border-red-500');
        }
    });

    if (!valid) {
        alert('Mohon lengkapi semua field yang wajib diisi (*)');
        return false;
    }
    return true;
}

function updateFileName(input, num) {
    const fileName = input.files[0]?.name;
    const fileNameEl = document.getElementById(`file_name_${num}`);
    const uploadZone = input.closest('.upload-zone');

    if (fileName) {
        fileNameEl.textContent = '✓ ' + fileName;
        fileNameEl.classList.remove('hidden');
        uploadZone.classList.add('border-green-500', 'bg-green-50', 'dark:bg-green-900/20');
    }
}

function updateConfirmation() {
    const formatTime = (time) => {
        if (!time) return '-';
        const [h, m] = time.split(':');
        const period = h >= 12 ? 'PM' : 'AM';
        const hour = h > 12 ? h - 12 : h;
        return `${hour}:${m} ${period}`;
    };

    const data = [
        `<strong>Email:</strong> ${document.querySelector('[name="email"]').value}`,
        `<strong>Nama:</strong> ${document.querySelector('[name="name"]').value}`,
        `<strong>Kapal:</strong> ${document.querySelector('[name="ship_name"]').value} (${document.querySelector('[name="ship_type"]').value})`,
        `<strong>Bendera:</strong> ${document.querySelector('[name="flag"]').value}`,
        `<strong>GT:</strong> ${document.querySelector('[name="gross_tonnage"]').value}`,
        `<strong>Nakhoda:</strong> ${document.querySelector('[name="captain_name"]').value}`,
        `<strong>Rute:</strong> ${document.querySelector('[name="departure_location"]').value} → ${document.querySelector('[name="destination"]').value}`,
        `<strong>Waktu:</strong> ${formatTime(document.querySelector('[name="movement_time"]').value)}`,
        `<strong>Penumpang:</strong> ${document.querySelector('[name="passenger_count"]').value} orang`,
        `<strong>Tanggal:</strong> ${new Date(document.querySelector('[name="application_date"]').value).toLocaleDateString('id-ID')}`
    ];
    document.getElementById('confirmation-data').innerHTML =
        data.map(item => `<li class="flex items-start gap-2"><i class="bi bi-check2 text-green-500"></i><span>${item}</span></li>`).join('');
}

// Initialize
document.addEventListener('DOMContentLoaded', () => {
    updateStepUI(1);
});
</script>
@endsection
