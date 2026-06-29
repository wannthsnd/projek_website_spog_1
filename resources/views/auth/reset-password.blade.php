@extends('layouts.app')
@section('title', 'Reset Password')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 bg-gradient-to-br from-blue-50 via-sky-100/50 to-indigo-50/30 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900">
    <div class="w-full max-w-md">
        <!-- Logo & Title -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 gradient-primary rounded-2xl shadow-lg mb-4">
                <i class="bi bi-key text-3xl text-white"></i>
            </div>
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Reset Password</h2>
            <p class="text-gray-600 dark:text-gray-400 font-medium">
                Masukkan password baru untuk akun Anda
            </p>
        </div>

        <!-- Reset Password Form -->
        <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl p-8 border-2 border-gray-200 dark:border-gray-700">
            @if($errors->any())
            <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-700 rounded-xl">
                <p class="text-sm font-semibold text-red-700 dark:text-red-400 flex items-center gap-2">
                    <i class="bi bi-exclamation-triangle"></i>
                    {{ $errors->first() }}
                </p>
            </div>
            @endif

            <form action="{{ route('password.update') }}" method="POST">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">

                <div class="mb-4">
                    <label for="email" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        <i class="bi bi-envelope text-primary-600 mr-2"></i>
                        Email
                    </label>
                    <input type="email"
                           name="email"
                           id="email"
                           value="{{ old('email', $email) }}"
                           class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl focus:outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 text-gray-900 dark:text-white font-medium"
                           required
                           readonly>
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        <i class="bi bi-lock text-primary-600 mr-2"></i>
                        Password Baru
                        <span class="text-red-500">*</span>
                    </label>
                    <input type="password"
                           name="password"
                           id="password"
                           class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl focus:outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 text-gray-900 dark:text-white font-medium placeholder-gray-400"
                           placeholder="Minimal 8 karakter"
                           required
                           autocomplete="new-password"
                           minlength="8">
                    @error('password')
                        <p class="text-red-500 text-xs mt-1 flex items-center gap-1">
                            <i class="bi bi-exclamation-circle"></i> {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        <i class="bi bi-lock-fill text-primary-600 mr-2"></i>
                        Konfirmasi Password Baru
                        <span class="text-red-500">*</span>
                    </label>
                    <input type="password"
                           name="password_confirmation"
                           id="password_confirmation"
                           class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl focus:outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 text-gray-900 dark:text-white font-medium placeholder-gray-400"
                           placeholder="Ulangi password baru"
                           required
                           autocomplete="new-password">
                    @error('password_confirmation')
                        <p class="text-red-500 text-xs mt-1 flex items-center gap-1">
                            <i class="bi bi-exclamation-circle"></i> {{ $message }}
                        </p>
                    @enderror
                </div>

                <button type="submit"
                        class="w-full gradient-primary text-white font-semibold py-3.5 rounded-xl shadow-lg hover:shadow-xl hover:scale-105 transition-all duration-300 flex items-center justify-center gap-2">
                    <i class="bi bi-check-circle"></i>
                    <span>Reset Password</span>
                </button>
            </form>

            <!-- Back to Login -->
            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600 dark:text-gray-400 font-medium">
                    Batal?
                    <a href="{{ route('login') }}" class="text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300 font-semibold hover:underline">
                        Kembali ke Login
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Password Match Validation -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const password = document.getElementById('password');
    const confirmation = document.getElementById('password_confirmation');

    if (password && confirmation) {
        confirmation.addEventListener('input', function() {
            if (this.value !== password.value) {
                this.setCustomValidity('Password tidak cocok');
            } else {
                this.setCustomValidity('');
            }
        });
    }
});
</script>
@endsection
