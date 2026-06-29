@extends('layouts.app')
@section('title', 'Ubah Password')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4 bg-gradient-to-br from-sky-100 via-blue-100/70 to-indigo-100/50">
    <div class="w-full max-w-2xl">
        <!-- Header -->
        <div class="mb-8 flex items-center gap-4">
            <a href="{{ route('profile') }}"
               class="w-12 h-12 bg-white dark:bg-gray-800 rounded-xl flex items-center justify-center hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors shadow-md">
                <i class="bi bi-arrow-left text-xl text-gray-900 dark:text-white"></i>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-1">Ubah Password</h1>
                <p class="text-gray-600 dark:text-gray-400 font-medium">Kelola keamanan akun Anda</p>
            </div>
        </div>

        <!-- Password Change Form -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-lg p-8">
            @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-700 rounded-xl flex items-center gap-3">
                <i class="bi bi-check-circle text-green-600 dark:text-green-400 text-xl"></i>
                <p class="text-sm font-semibold text-green-700 dark:text-green-400">{{ session('success') }}</p>
            </div>
            @endif

            @if($errors->any())
            <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-700 rounded-xl">
                <p class="text-sm font-semibold text-red-700 dark:text-red-400 flex items-center gap-2">
                    <i class="bi bi-exclamation-triangle"></i>
                    {{ $errors->first() }}
                </p>
            </div>
            @endif

            <form action="{{ route('profile.password.update') }}" method="POST">
                @csrf
                @method('PUT')

                @if(!session()->get('must_change_password', false))
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        <i class="bi bi-lock text-primary-600 mr-2"></i>
                        Password Saat Ini <span class="text-red-500">*</span>
                    </label>
                    <input type="password" name="current_password"
                        class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl focus:outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 text-gray-900 dark:text-white font-medium placeholder-gray-400"
                        placeholder="••••••••"
                        required autocomplete="current-password">
                    @error('current_password')
                        <p class="text-red-500 text-xs mt-1 flex items-center gap-1">
                            <i class="bi bi-exclamation-circle"></i> {{ $message }}
                        </p>
                    @enderror
                </div>
                @endif

                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        <i class="bi bi-key text-primary-600 mr-2"></i>
                        Password Baru <span class="text-red-500">*</span>
                    </label>
                    <input type="password" name="password" id="newPassword"
                        class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl focus:outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 text-gray-900 dark:text-white font-medium placeholder-gray-400"
                        placeholder="Minimal 8 karakter"
                        required minlength="8" autocomplete="new-password">
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                        <i class="bi bi-info-circle mr-1"></i>
                        Minimal 8 karakter, kombinasi huruf dan angka
                    </p>
                    @error('password')
                        <p class="text-red-500 text-xs mt-1 flex items-center gap-1">
                            <i class="bi bi-exclamation-circle"></i> {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="mb-8">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        <i class="bi bi-key-fill text-primary-600 mr-2"></i>
                        Konfirmasi Password Baru <span class="text-red-500">*</span>
                    </label>
                    <input type="password" name="password_confirmation" id="passwordConfirmation"
                        class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl focus:outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 text-gray-900 dark:text-white font-medium placeholder-gray-400"
                        placeholder="Ulangi password baru"
                        required autocomplete="new-password">
                    @error('password_confirmation')
                        <p class="text-red-500 text-xs mt-1 flex items-center gap-1">
                            <i class="bi bi-exclamation-circle"></i> {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="flex justify-end gap-3">
                    <a href="{{ route('profile') }}"
                       class="px-6 py-3 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-xl font-semibold hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                        Batal
                    </a>
                    <button type="submit"
                            class="px-6 py-3 gradient-primary text-white rounded-xl font-semibold shadow-md hover:shadow-lg hover:scale-105 transition-all duration-300 flex items-center gap-2">
                        <i class="bi bi-check-circle"></i>
                        <span>Ubah Password</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Security Tips -->
        <div class="mt-6 bg-blue-50 dark:bg-blue-900/20 rounded-2xl border border-blue-200 dark:border-blue-700 p-6">
            <h3 class="text-sm font-bold text-blue-900 dark:text-blue-300 mb-3 flex items-center gap-2">
                <i class="bi bi-shield-check"></i>
                Tips Password Aman:
            </h3>
            <ul class="text-xs text-blue-800 dark:text-blue-200 space-y-1.5">
                <li class="flex items-start gap-2">
                    <i class="bi bi-check2 text-blue-600 dark:text-blue-400 mt-0.5"></i>
                    <span>Gunakan minimal 8 karakter dengan kombinasi huruf, angka, dan simbol</span>
                </li>
                <li class="flex items-start gap-2">
                    <i class="bi bi-check2 text-blue-600 dark:text-blue-400 mt-0.5"></i>
                    <span>Jangan gunakan password yang sama dengan akun lain</span>
                </li>
                <li class="flex items-start gap-2">
                    <i class="bi bi-check2 text-blue-600 dark:text-blue-400 mt-0.5"></i>
                    <span>Ganti password secara berkala untuk keamanan</span>
                </li>
            </ul>
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
            } else {
                this.setCustomValidity('');
            }
        });
    }
});
</script>
@endsection
