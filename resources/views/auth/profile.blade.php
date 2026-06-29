@extends('layouts.app')
@section('title', 'Profil Saya')

@section('content')
<div class="max-w-5xl mx-auto">
    <!-- Header Section - Elegant with gradient -->
    <div class="mb-10">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
            <div class="flex items-center gap-5">
                <div class="relative group">
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-600 via-cyan-600 to-blue-600 rounded-2xl blur-xl opacity-40 group-hover:opacity-60 transition-opacity duration-500"></div>
                    <a href="{{ route('dashboard') }}"
                       class="relative w-14 h-14 bg-white dark:bg-gray-800 rounded-2xl flex items-center justify-center shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-200 dark:border-gray-700 group-hover:scale-105">
                        <i class="bi bi-arrow-left text-xl text-gray-700 dark:text-gray-300"></i>
                    </a>
                </div>
                <div>
                    <h1 class="text-2xl lg:text-3xl font-bold bg-gradient-to-r from-blue-600 via-cyan-600 to-blue-600 bg-clip-text text-transparent mb-2">
                        Profil Saya
                    </h1>
                    <p class="text-gray-600 dark:text-gray-400 font-medium flex items-center gap-2">
                        <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                        Kelola informasi akun Anda
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Profile Card - Left Column -->
        <div class="lg:col-span-1">
            <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl border border-gray-100 dark:border-gray-700 overflow-hidden">
                <!-- Card Header with Gradient -->
                <div class="px-6 py-5 bg-gradient-to-r from-blue-500 via-cyan-500 to-blue-500">
                    <div class="text-center">
                        <div class="relative inline-block mb-4">
                            <div class="absolute inset-0 bg-white/20 rounded-full blur-lg"></div>
                            <div class="relative w-24 h-24 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center text-white text-3xl font-bold shadow-lg border-4 border-white/30">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <span class="absolute bottom-2 right-2 w-5 h-5 bg-emerald-400 border-3 border-white dark:border-gray-800 rounded-full shadow-sm" title="Aktif"></span>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-1">{{ Auth::user()->name }}</h3>
                        <p class="text-white/90 text-sm break-all">{{ Auth::user()->email }}</p>
                        <span class="inline-flex items-center px-3 py-1 bg-white/20 backdrop-blur-sm text-white text-xs font-bold rounded-full capitalize mt-3">
                            <i class="bi bi-shield-check mr-1"></i>
                            {{ Auth::user()->role }}
                        </span>
                    </div>
                </div>

                <!-- Card Body -->
                <div class="p-6 space-y-5">
                    <!-- ✅ UPT Information - PENTING -->
                    @if(Auth::user()->upt)
                    <div class="p-4 bg-gradient-to-br from-purple-50 to-indigo-50 dark:from-purple-900/20 dark:to-indigo-900/20 rounded-2xl border border-purple-200 dark:border-purple-700">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-purple-400 to-indigo-500 rounded-xl flex items-center justify-center shadow-md">
                                <i class="bi bi-building text-white"></i>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-purple-700 dark:text-purple-300 uppercase tracking-wider">UPT Anda</p>
                                <p class="font-bold text-gray-900 dark:text-white">{{ Auth::user()->upt->name }}</p>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-2 text-xs">
                            <div class="flex items-center gap-1.5">
                                <i class="bi bi-tag text-purple-500"></i>
                                <span class="font-mono font-bold text-purple-700 dark:text-purple-300">{{ Auth::user()->upt->code }}</span>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <i class="bi bi-geo-alt text-purple-500"></i>
                                <span class="text-gray-700 dark:text-gray-300">{{ Auth::user()->upt->region ?? '-' }}</span>
                            </div>
                        </div>
                        <p class="text-[10px] text-gray-500 dark:text-gray-400 mt-3 italic">
                            <i class="bi bi-info-circle mr-1"></i>
                            UPT ditentukan saat registrasi dan tidak dapat diubah
                        </p>
                    </div>
                    @else
                    <div class="p-4 bg-gradient-to-br from-amber-50 to-orange-50 dark:from-amber-900/20 dark:to-orange-900/20 rounded-2xl border border-amber-200 dark:border-amber-700">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-amber-400 to-orange-500 rounded-xl flex items-center justify-center shadow-md">
                                <i class="bi bi-exclamation-triangle text-white"></i>
                            </div>
                            <div>
                                <p class="font-bold text-gray-900 dark:text-white">UPT Belum Ditentukan</p>
                                <p class="text-xs text-gray-600 dark:text-gray-400">Silakan hubungi administrator untuk penugasan UPT</p>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Statistics -->
                    <div class="grid grid-cols-2 gap-3">
                        <div class="p-4 bg-gradient-to-br from-blue-50 to-cyan-50 dark:from-blue-900/20 dark:to-cyan-900/20 rounded-xl border border-blue-200 dark:border-blue-700 text-center">
                            <div class="flex items-center justify-center gap-1 mb-2">
                                <i class="bi bi-folder-check text-blue-600 dark:text-blue-400"></i>
                                <p class="text-xs font-semibold text-blue-700 dark:text-blue-300">Total Permohonan</p>
                            </div>
                            <p class="text-2xl font-bold text-blue-900 dark:text-blue-100">
                                {{ $user->ship_permits_count ?? 0 }}
                            </p>
                        </div>
                        <div class="p-4 bg-gradient-to-br from-emerald-50 to-green-50 dark:from-emerald-900/20 dark:to-green-900/20 rounded-xl border border-emerald-200 dark:border-emerald-700 text-center">
                            <div class="flex items-center justify-center gap-1 mb-2">
                                <i class="bi bi-check-circle text-emerald-600 dark:text-emerald-400"></i>
                                <p class="text-xs font-semibold text-emerald-700 dark:text-emerald-300">Disetujui</p>
                            </div>
                            <p class="text-2xl font-bold text-emerald-900 dark:text-emerald-100">
                                {{ $user->activePermits()->count() }}
                            </p>
                        </div>
                    </div>

                    <!-- Account Info -->
                    <div class="space-y-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <div class="flex justify-between items-center py-2">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Bergabung</span>
                            <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ Auth::user()->created_at->format('d M Y') }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Terakhir Login</span>
                            <span class="text-sm font-semibold text-gray-900 dark:text-white">
                                {{-- ✅ FIXED: Gunakan Carbon::parse() untuk last_login_at --}}
                                {{ Auth::user()->last_login_at ? \Carbon\Carbon::parse(Auth::user()->last_login_at)->format('d M Y, H:i') : '-' }}
                            </span>
                        </div>
                        <div class="flex justify-between items-center py-2">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Status Akun</span>
                            @if(Auth::user()->is_active)
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300 text-xs font-bold rounded-full">
                                <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>
                                Aktif
                            </span>
                            @else
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 text-xs font-bold rounded-full">
                                <span class="w-1.5 h-1.5 bg-gray-500 rounded-full"></span>
                                Nonaktif
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Profile Forms - Right Column -->
        <div class="lg:col-span-2 space-y-6">

            <!-- Update Profile Form -->
            <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl border border-gray-100 dark:border-gray-700 overflow-hidden">
                <!-- Form Header -->
                <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-blue-50/50 via-cyan-50/50 to-blue-50/50 dark:from-gray-700/50 dark:via-gray-600/50 dark:to-gray-700/50">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-cyan-500 rounded-xl flex items-center justify-center shadow-md">
                            <i class="bi bi-person-circle text-white"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white">Informasi Profil</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Perbarui data pribadi Anda</p>
                        </div>
                    </div>
                </div>

                <!-- Form Body -->
                <div class="p-6">
                    @if(session('success'))
                    <div class="mb-5 p-4 bg-gradient-to-r from-emerald-50 to-green-50 dark:from-emerald-900/20 dark:to-green-900/20 border border-emerald-200 dark:border-emerald-700 rounded-xl flex items-start gap-3">
                        <i class="bi bi-check-circle text-emerald-600 dark:text-emerald-400 text-lg mt-0.5"></i>
                        <p class="text-sm font-semibold text-emerald-700 dark:text-emerald-400">{{ session('success') }}</p>
                    </div>
                    @endif

                    @if($errors->any())
                    <div class="mb-5 p-4 bg-gradient-to-r from-rose-50 to-red-50 dark:from-rose-900/20 dark:to-red-900/20 border border-rose-200 dark:border-rose-700 rounded-xl">
                        <p class="text-sm font-semibold text-rose-700 dark:text-rose-400 flex items-start gap-2">
                            <i class="bi bi-exclamation-triangle mt-0.5"></i>
                            {{ $errors->first() }}
                        </p>
                    </div>
                    @endif

                    <form action="{{ route('profile.update') }}" method="POST" novalidate>
                        @csrf
                        @method('PUT')

                        <div class="space-y-5">
                            <!-- Name -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    Nama Lengkap <span class="text-red-500">*</span>
                                </label>
                                <input type="text"
                                       name="name"
                                       value="{{ old('name', Auth::user()->name) }}"
                                       class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 text-gray-900 dark:text-white font-medium placeholder-gray-400 transition-all @error('name') border-red-500 @enderror"
                                       placeholder="Masukkan nama lengkap Anda"
                                       required
                                       autocomplete="name"
                                       minlength="3"
                                       maxlength="255">
                                @error('name')
                                    <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                                        <i class="bi bi-exclamation-circle"></i> {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    Email <span class="text-red-500">*</span>
                                </label>
                                <input type="email"
                                       name="email"
                                       value="{{ old('email', Auth::user()->email) }}"
                                       class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 text-gray-900 dark:text-white font-medium placeholder-gray-400 transition-all @error('email') border-red-500 @enderror"
                                       placeholder="contoh@email.com"
                                       required
                                       autocomplete="email">
                                @error('email')
                                    <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                                        <i class="bi bi-exclamation-circle"></i> {{ $message }}
                                    </p>
                                @enderror
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1.5">
                                    <i class="bi bi-info-circle mr-1"></i>
                                    Email digunakan untuk login dan notifikasi sistem
                                </p>
                            </div>

                            <!-- UPT Info (Read Only) -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    Unit Pelaksana Teknis (UPT)
                                </label>
                                <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl border border-gray-200 dark:border-gray-600">
                                    @if(Auth::user()->upt)
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-gradient-to-br from-purple-400 to-indigo-500 rounded-lg flex items-center justify-center">
                                            <i class="bi bi-building text-white"></i>
                                        </div>
                                        <div>
                                            <p class="font-semibold text-gray-900 dark:text-white">{{ Auth::user()->upt->name }}</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                                Kode: <span class="font-mono font-bold">{{ Auth::user()->upt->code }}</span> • {{ Auth::user()->upt->region ?? 'Regional' }}
                                            </p>
                                        </div>
                                    </div>
                                    @else
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Belum terikat dengan UPT</p>
                                    @endif
                                </div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">
                                    <i class="bi bi-lock mr-1"></i>
                                    UPT ditentukan saat registrasi dan hanya dapat diubah oleh administrator
                                </p>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700 flex justify-end gap-3">
                            <a href="{{ route('dashboard') }}"
                               class="px-6 py-3 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-xl font-semibold hover:bg-gray-200 dark:hover:bg-gray-600 transition-all">
                                Batal
                            </a>
                            <button type="submit"
                                    class="px-6 py-3 bg-gradient-to-r from-blue-500 to-cyan-600 text-white rounded-xl font-semibold shadow-md hover:shadow-lg hover:scale-105 transition-all duration-300">
                                <i class="bi bi-check-circle mr-2"></i>
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Update Password Form -->
            <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl border border-gray-100 dark:border-gray-700 overflow-hidden">
                <!-- Form Header -->
                <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-purple-50/50 via-indigo-50/50 to-purple-50/50 dark:from-gray-700/50 dark:via-gray-600/50 dark:to-gray-700/50">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-purple-400 to-indigo-500 rounded-xl flex items-center justify-center shadow-md">
                            <i class="bi bi-lock text-white"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white">Ubah Password</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Perbarui kata sandi akun Anda</p>
                        </div>
                    </div>
                </div>

                <!-- Form Body -->
                <div class="p-6">
                    <form action="{{ route('profile.password') }}" method="POST" novalidate>
                        @csrf
                        @method('PUT')

                        <div class="space-y-5">
                            <!-- Current Password -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    Password Saat Ini <span class="text-red-500">*</span>
                                </label>
                                <input type="password"
                                       name="current_password"
                                       class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 text-gray-900 dark:text-white font-medium placeholder-gray-400 transition-all @error('current_password') border-red-500 @enderror"
                                       placeholder="••••••••"
                                       required
                                       autocomplete="current-password">
                                @error('current_password')
                                    <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                                        <i class="bi bi-exclamation-circle"></i> {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- New Password -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    Password Baru <span class="text-red-500">*</span>
                                </label>
                                <input type="password"
                                       name="password"
                                       id="newPassword"
                                       class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 text-gray-900 dark:text-white font-medium placeholder-gray-400 transition-all @error('password') border-red-500 @enderror"
                                       placeholder="Minimal 8 karakter"
                                       required
                                       autocomplete="new-password"
                                       minlength="8">
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1.5">
                                    <i class="bi bi-info-circle mr-1"></i>
                                    Minimal 8 karakter, kombinasi huruf dan angka
                                </p>
                                @error('password')
                                    <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                                        <i class="bi bi-exclamation-circle"></i> {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Confirm Password -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    Konfirmasi Password Baru <span class="text-red-500">*</span>
                                </label>
                                <input type="password"
                                       name="password_confirmation"
                                       id="passwordConfirmation"
                                       class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 text-gray-900 dark:text-white font-medium placeholder-gray-400 transition-all @error('password_confirmation') border-red-500 @enderror"
                                       placeholder="Ulangi password baru"
                                       required
                                       autocomplete="new-password">
                                @error('password_confirmation')
                                    <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                                        <i class="bi bi-exclamation-circle"></i> {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700 flex justify-end gap-3">
                            <button type="reset"
                                    class="px-6 py-3 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-xl font-semibold hover:bg-gray-200 dark:hover:bg-gray-600 transition-all">
                                Reset
                            </button>
                            <button type="submit"
                                    class="px-6 py-3 bg-gradient-to-r from-purple-500 to-indigo-600 text-white rounded-xl font-semibold shadow-md hover:shadow-lg hover:scale-105 transition-all duration-300">
                                <i class="bi bi-key mr-2"></i>
                                Ubah Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Account Security Info -->
            <div class="bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 dark:from-gray-800 dark:via-gray-700 dark:to-gray-800 rounded-3xl p-6 border border-blue-200 dark:border-gray-600">
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-indigo-500 rounded-xl flex items-center justify-center flex-shrink-0 shadow-md">
                        <i class="bi bi-shield-check text-white"></i>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-gray-900 dark:text-white mb-2">Keamanan Akun</h4>
                        <ul class="text-xs text-gray-700 dark:text-gray-300 space-y-1.5">
                            <li class="flex items-start gap-2">
                                <i class="bi bi-check-circle text-blue-500 mt-0.5"></i>
                                <span>Gunakan password yang kuat dan unik untuk keamanan akun</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i class="bi bi-check-circle text-blue-500 mt-0.5"></i>
                                <span>Jangan bagikan password Anda kepada siapapun</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i class="bi bi-check-circle text-blue-500 mt-0.5"></i>
                                <span>UPT Anda menentukan wilayah pengelolaan permohonan SPOG</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i class="bi bi-check-circle text-blue-500 mt-0.5"></i>
                                <span>Hubungi administrator jika ingin mengubah UPT atau email</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Password Match Validation Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const newPassword = document.getElementById('newPassword');
    const passwordConfirmation = document.getElementById('passwordConfirmation');

    if (newPassword && passwordConfirmation) {
        passwordConfirmation.addEventListener('input', function() {
            if (this.value !== newPassword.value) {
                this.setCustomValidity('Password tidak cocok');
                this.classList.add('border-red-500');
            } else {
                this.setCustomValidity('');
                this.classList.remove('border-red-500');
            }
        });

        newPassword.addEventListener('input', function() {
            if (passwordConfirmation.value && passwordConfirmation.value !== this.value) {
                passwordConfirmation.setCustomValidity('Password tidak cocok');
                passwordConfirmation.classList.add('border-red-500');
            } else {
                passwordConfirmation.setCustomValidity('');
                passwordConfirmation.classList.remove('border-red-500');
            }
        });
    }
});
</script>
@endsection
