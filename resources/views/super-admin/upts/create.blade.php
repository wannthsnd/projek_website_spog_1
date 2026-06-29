@extends('layouts.app')
@section('title', 'Tambah UPT')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-cyan-50/40 to-teal-50/30 dark:from-slate-900 dark:via-slate-800 dark:to-slate-900 transition-colors duration-300 py-6 sm:py-8">

    <!-- Subtle Background Elements -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-cyan-400/10 dark:bg-cyan-500/5 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute top-1/2 -left-40 w-96 h-96 bg-teal-400/10 dark:bg-teal-500/5 rounded-full blur-3xl animate-pulse" style="animation-delay: 1.5s;"></div>
    </div>

    <div class="relative max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <a href="{{ route('super-admin.upts.index') }}"
                       class="group w-12 h-12 bg-white/70 dark:bg-slate-800/70 backdrop-blur-sm hover:bg-white dark:hover:bg-slate-700 rounded-xl flex items-center justify-center shadow-sm border border-slate-200/60 dark:border-slate-700/60 transition-all duration-200 hover:-translate-x-0.5">
                        <i class="bi bi-arrow-left text-slate-700 dark:text-slate-300 group-hover:text-cyan-600 dark:group-hover:text-cyan-400 transition-colors"></i>
                    </a>
                    <div>
                        <h1 class="text-xl sm:text-2xl font-bold bg-gradient-to-r from-slate-900 via-cyan-900 to-slate-900 dark:from-white dark:via-cyan-200 dark:to-white bg-clip-text text-transparent">
                            Tambah UPT Baru
                        </h1>
                        <p class="text-slate-600 dark:text-slate-400 text-sm">Unit Pelaksana Teknis • Formulir Pendaftaran</p>
                    </div>
                </div>

                <!-- Status Badge -->
                <span class="hidden sm:inline-flex items-center gap-2 px-3 py-1.5 bg-cyan-100/80 dark:bg-cyan-900/40 text-cyan-700 dark:text-cyan-300 text-xs font-medium rounded-lg border border-cyan-200/60 dark:border-cyan-700/60">
                    <span class="w-1.5 h-1.5 bg-cyan-500 rounded-full animate-pulse"></span>
                    Form Aktif
                </span>
            </div>
        </div>

        <!-- Form -->
        <form action="{{ route('super-admin.upts.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Section: Informasi Dasar -->
            <div class="bg-white/70 dark:bg-slate-800/70 backdrop-blur-sm rounded-2xl shadow-sm border border-slate-200/60 dark:border-slate-700/60 p-5 sm:p-6 hover:shadow-md transition-shadow duration-200">
                <div class="flex items-center gap-3 mb-5 pb-4 border-b border-slate-200/60 dark:border-slate-700/60">
                    <div class="w-9 h-9 bg-gradient-to-br from-cyan-100 to-cyan-200 dark:from-cyan-900/40 dark:to-cyan-800/40 rounded-lg flex items-center justify-center">
                        <i class="bi bi-building text-cyan-600 dark:text-cyan-400"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-semibold text-slate-900 dark:text-white">Informasi Dasar</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Data identitas UPT</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <!-- Nama UPT -->
                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-2 uppercase tracking-wide">
                            Nama UPT <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="name" value="{{ old('name') }}" required
                               class="w-full px-4 py-3 bg-white/80 dark:bg-slate-700/80 border border-slate-300/60 dark:border-slate-600/60 rounded-xl focus:outline-none focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20 text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 transition-all @error('name') border-red-400 focus:border-red-500 focus:ring-red-500/20 @enderror"
                               placeholder="Contoh: KANTOR KESYAHBANDARAN DAN OTORITAS PELABUHAN KELAS I PANJANG">
                        @error('name')
                            <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                                <i class="bi bi-exclamation-circle"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Kode UPT -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-2 uppercase tracking-wide">
                            Kode UPT <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="code" value="{{ old('code') }}" required
                               class="w-full px-4 py-3 bg-white/80 dark:bg-slate-700/80 border border-slate-300/60 dark:border-slate-600/60 rounded-xl focus:outline-none focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20 text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 uppercase tracking-wider transition-all @error('code') border-red-400 focus:border-red-500 focus:ring-red-500/20 @enderror"
                               placeholder="KSOP-001">
                        @error('code')
                            <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                                <i class="bi bi-exclamation-circle"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Region/Wilayah -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-2 uppercase tracking-wide">
                            Region/Wilayah <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="region" value="{{ old('region') }}" required
                               class="w-full px-4 py-3 bg-white/80 dark:bg-slate-700/80 border border-slate-300/60 dark:border-slate-600/60 rounded-xl focus:outline-none focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20 text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 transition-all @error('region') border-red-400 focus:border-red-500 focus:ring-red-500/20 @enderror"
                               placeholder="Bali & Nusa Tenggara">
                        @error('region')
                            <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                                <i class="bi bi-exclamation-circle"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Section: Informasi Kontak -->
            <div class="bg-white/70 dark:bg-slate-800/70 backdrop-blur-sm rounded-2xl shadow-sm border border-slate-200/60 dark:border-slate-700/60 p-5 sm:p-6 hover:shadow-md transition-shadow duration-200">
                <div class="flex items-center gap-3 mb-5 pb-4 border-b border-slate-200/60 dark:border-slate-700/60">
                    <div class="w-9 h-9 bg-gradient-to-br from-teal-100 to-teal-200 dark:from-teal-900/40 dark:to-teal-800/40 rounded-lg flex items-center justify-center">
                        <i class="bi bi-geo-alt text-teal-600 dark:text-teal-400"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-semibold text-slate-900 dark:text-white">Informasi Kontak</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Alamat dan komunikasi</p>
                    </div>
                </div>

                <div class="space-y-5">
                    <!-- Alamat -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-2 uppercase tracking-wide">
                            Alamat Lengkap
                        </label>
                        <textarea name="alamat" rows="3"
                                  class="w-full px-4 py-3 bg-white/80 dark:bg-slate-700/80 border border-slate-300/60 dark:border-slate-600/60 rounded-xl focus:outline-none focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20 text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 resize-none transition-all @error('alamat') border-red-400 focus:border-red-500 focus:ring-red-500/20 @enderror"
                                  placeholder="Jl. Yos Sudarso Panjang...">{{ old('alamat') }}</textarea>
                        @error('alamat')
                            <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                                <i class="bi bi-exclamation-circle"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                        <!-- Kota -->
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-2 uppercase tracking-wide">
                                Kota/Kabupaten
                            </label>
                            <input type="text" name="kota" value="{{ old('kota') }}"
                                   class="w-full px-4 py-3 bg-white/80 dark:bg-slate-700/80 border border-slate-300/60 dark:border-slate-600/60 rounded-xl focus:outline-none focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20 text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 transition-all @error('kota') border-red-400 focus:border-red-500 focus:ring-red-500/20 @enderror"
                                   placeholder="Bandar Lampung">
                            @error('kota')
                                <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                                    <i class="bi bi-exclamation-circle"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Kode Pos -->
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-2 uppercase tracking-wide">
                                Kode Pos
                            </label>
                            <input type="text" name="kode_pos" value="{{ old('kode_pos') }}"
                                   class="w-full px-4 py-3 bg-white/80 dark:bg-slate-700/80 border border-slate-300/60 dark:border-slate-600/60 rounded-xl focus:outline-none focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20 text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 transition-all @error('kode_pos') border-red-400 focus:border-red-500 focus:ring-red-500/20 @enderror"
                                   placeholder="35241">
                            @error('kode_pos')
                                <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                                    <i class="bi bi-exclamation-circle"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Telepon -->
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-2 uppercase tracking-wide">
                                Telepon
                            </label>
                            <input type="text" name="telepon" value="{{ old('telepon') }}"
                                   class="w-full px-4 py-3 bg-white/80 dark:bg-slate-700/80 border border-slate-300/60 dark:border-slate-600/60 rounded-xl focus:outline-none focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20 text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 transition-all @error('telepon') border-red-400 focus:border-red-500 focus:ring-red-500/20 @enderror"
                                   placeholder="(0721) 31303">
                            @error('telepon')
                                <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                                    <i class="bi bi-exclamation-circle"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-2 uppercase tracking-wide">
                                Email
                            </label>
                            <input type="email" name="email" value="{{ old('email') }}"
                                   class="w-full px-4 py-3 bg-white/80 dark:bg-slate-700/80 border border-slate-300/60 dark:border-slate-600/60 rounded-xl focus:outline-none focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20 text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 transition-all @error('email') border-red-400 focus:border-red-500 focus:ring-red-500/20 @enderror"
                                   placeholder="ksop@example.com">
                            @error('email')
                                <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                                    <i class="bi bi-exclamation-circle"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Website -->
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-2 uppercase tracking-wide">
                                Website
                            </label>
                            <input type="url" name="website" value="{{ old('website') }}"
                                   class="w-full px-4 py-3 bg-white/80 dark:bg-slate-700/80 border border-slate-300/60 dark:border-slate-600/60 rounded-xl focus:outline-none focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20 text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 transition-all @error('website') border-red-400 focus:border-red-500 focus:ring-red-500/20 @enderror"
                                   placeholder="https://ksop-panjang.id">
                            @error('website')
                                <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                                    <i class="bi bi-exclamation-circle"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- TGM -->
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-2 uppercase tracking-wide">
                                TGM
                            </label>
                            <input type="text" name="tgm" value="{{ old('tgm') }}"
                                   class="w-full px-4 py-3 bg-white/80 dark:bg-slate-700/80 border border-slate-300/60 dark:border-slate-600/60 rounded-xl focus:outline-none focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20 text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 transition-all @error('tgm') border-red-400 focus:border-red-500 focus:ring-red-500/20 @enderror"
                                   placeholder="...">
                            @error('tgm')
                                <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                                    <i class="bi bi-exclamation-circle"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- TLX -->
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-2 uppercase tracking-wide">
                                TLX (Telex)
                            </label>
                            <input type="text" name="tlx" value="{{ old('tlx') }}"
                                   class="w-full px-4 py-3 bg-white/80 dark:bg-slate-700/80 border border-slate-300/60 dark:border-slate-600/60 rounded-xl focus:outline-none focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20 text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 transition-all @error('tlx') border-red-400 focus:border-red-500 focus:ring-red-500/20 @enderror"
                                   placeholder="...">
                            @error('tlx')
                                <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                                    <i class="bi bi-exclamation-circle"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Fax -->
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-2 uppercase tracking-wide">
                                Fax
                            </label>
                            <input type="text" name="fax" value="{{ old('fax') }}"
                                   class="w-full px-4 py-3 bg-white/80 dark:bg-slate-700/80 border border-slate-300/60 dark:border-slate-600/60 rounded-xl focus:outline-none focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20 text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 transition-all @error('fax') border-red-400 focus:border-red-500 focus:ring-red-500/20 @enderror"
                                   placeholder="(0721) 31392">
                            @error('fax')
                                <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                                    <i class="bi bi-exclamation-circle"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section: Informasi Kepala Kantor -->
            <div class="bg-white/70 dark:bg-slate-800/70 backdrop-blur-sm rounded-2xl shadow-sm border border-slate-200/60 dark:border-slate-700/60 p-5 sm:p-6 hover:shadow-md transition-shadow duration-200">
                <div class="flex items-center gap-3 mb-5 pb-4 border-b border-slate-200/60 dark:border-slate-700/60">
                    <div class="w-9 h-9 bg-gradient-to-br from-emerald-100 to-emerald-200 dark:from-emerald-900/40 dark:to-emerald-800/40 rounded-lg flex items-center justify-center">
                        <i class="bi bi-person-badge text-emerald-600 dark:text-emerald-400"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-semibold text-slate-900 dark:text-white">Informasi Kepala Kantor</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Data pejabat penanggung jawab</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <!-- Kepala Kantor -->
                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-2 uppercase tracking-wide">
                            Nama Kepala Kantor
                        </label>
                        <input type="text" name="kepala_kantor" value="{{ old('kepala_kantor') }}"
                               class="w-full px-4 py-3 bg-white/80 dark:bg-slate-700/80 border border-slate-300/60 dark:border-slate-600/60 rounded-xl focus:outline-none focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20 text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 transition-all @error('kepala_kantor') border-red-400 focus:border-red-500 focus:ring-red-500/20 @enderror"
                               placeholder="Nama lengkap Kepala Kantor">
                        @error('kepala_kantor')
                            <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                                <i class="bi bi-exclamation-circle"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- NIP Kepala -->
                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-2 uppercase tracking-wide">
                            NIP Kepala Kantor
                        </label>
                        <input type="text" name="nip_kepala" value="{{ old('nip_kepala') }}"
                               class="w-full px-4 py-3 bg-white/80 dark:bg-slate-700/80 border border-slate-300/60 dark:border-slate-600/60 rounded-xl focus:outline-none focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20 text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 transition-all @error('nip_kepala') border-red-400 focus:border-red-500 focus:ring-red-500/20 @enderror"
                               placeholder="Nomor Induk Pegawai">
                        @error('nip_kepala')
                            <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                                <i class="bi bi-exclamation-circle"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Section: Status UPT -->
            <div class="bg-white/70 dark:bg-slate-800/70 backdrop-blur-sm rounded-2xl shadow-sm border border-slate-200/60 dark:border-slate-700/60 p-5 sm:p-6 hover:shadow-md transition-shadow duration-200">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-9 h-9 bg-gradient-to-br from-amber-100 to-amber-200 dark:from-amber-900/40 dark:to-amber-800/40 rounded-lg flex items-center justify-center">
                        <i class="bi bi-toggle-on text-amber-600 dark:text-amber-400"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-semibold text-slate-900 dark:text-white">Status UPT</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Aktifkan atau nonaktifkan UPT</p>
                    </div>
                </div>

                <label class="flex items-center gap-3 cursor-pointer group">
                    <div class="relative">
                        <input type="checkbox" name="is_active" value="1" id="is_active" {{ old('is_active', true) ? 'checked' : '' }}
                               class="sr-only peer">
                        <div class="w-11 h-6 bg-slate-200 dark:bg-slate-600 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-cyan-500/30 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-cyan-500 dark:peer-checked:bg-cyan-600"></div>
                    </div>
                    <span class="text-sm font-medium text-slate-700 dark:text-slate-300 group-hover:text-slate-900 dark:group-hover:text-white transition-colors">
                        UPT Aktif
                    </span>
                </label>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-2 ml-14">
                    Centang jika UPT ini aktif dan dapat digunakan dalam sistem
                </p>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 pt-4">
                <a href="{{ route('super-admin.upts.index') }}"
                   class="flex-1 px-6 py-3.5 bg-white/70 dark:bg-slate-800/70 hover:bg-white dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 rounded-xl font-semibold transition-all duration-200 text-center border border-slate-200/60 dark:border-slate-700/60 hover:border-cyan-400/60 dark:hover:border-cyan-600/60 hover:shadow-sm">
                    Batal
                </a>
                <button type="submit"
                        class="flex-1 px-6 py-3.5 bg-gradient-to-r from-cyan-600 to-teal-600 hover:from-cyan-700 hover:to-teal-700 text-white rounded-xl font-semibold shadow-lg shadow-cyan-500/20 hover:shadow-cyan-500/40 hover:-translate-y-0.5 transition-all duration-200 flex items-center justify-center gap-2">
                    <i class="bi bi-check-circle"></i>
                    Simpan UPT
                </button>
            </div>
        </form>

        <!-- Footer -->
        <div class="text-center text-slate-400 dark:text-slate-500 text-xs py-6">
            <p>&copy; {{ date('Y') }} SPOG KAPAL • Super Admin Panel</p>
        </div>
    </div>
</div>

<!-- Custom Styles - Minimal & Clean -->
<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap');
body { font-family: 'Inter', sans-serif; }
* { scroll-behavior: smooth; }
::-webkit-scrollbar { width: 5px; height: 5px; }
::-webkit-scrollbar-track { background: transparent; }
::-webkit-scrollbar-thumb { background: rgba(14, 165, 233, 0.4); border-radius: 3px; }
::-webkit-scrollbar-thumb:hover { background: rgba(14, 165, 233, 0.6); }

/* Form input focus animation */
input:focus, textarea:focus {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(14, 165, 233, 0.15);
}

/* Smooth checkbox toggle */
.peer:checked ~ div:after {
    transform: translateX(100%);
}
</style>
@endsection
