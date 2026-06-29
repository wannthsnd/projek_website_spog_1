@extends('layouts.app')
@section('title', 'Pengaturan')

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
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-1">Pengaturan</h1>
                <p class="text-gray-600 dark:text-gray-400 font-medium">Kelola preferensi akun Anda</p>
            </div>
        </div>

        <!-- Settings Form -->
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

            <form action="{{ route('settings.update') }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Theme Settings -->
                <div class="mb-8">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                        <i class="bi bi-palette text-primary-600"></i>
                        Tampilan
                    </h3>

                    <div class="grid grid-cols-3 gap-3">
                        <!-- Light Theme -->
                        <label class="cursor-pointer">
                            <input type="radio" name="theme" value="light"
                                {{ ($settings['theme'] ?? 'system') === 'light' ? 'checked' : '' }}
                                class="peer sr-only">
                            <div class="p-4 text-center border-2 border-gray-200 dark:border-gray-600 rounded-xl peer-checked:border-primary-500 peer-checked:bg-primary-50 dark:peer-checked:bg-primary-900/20 transition-all hover:border-primary-300">
                                <i class="bi bi-sun text-2xl text-yellow-500 mb-2"></i>
                                <p class="text-sm font-semibold text-gray-900 dark:text-white">Light</p>
                            </div>
                        </label>

                        <!-- Dark Theme -->
                        <label class="cursor-pointer">
                            <input type="radio" name="theme" value="dark"
                                {{ ($settings['theme'] ?? 'system') === 'dark' ? 'checked' : '' }}
                                class="peer sr-only">
                            <div class="p-4 text-center border-2 border-gray-200 dark:border-gray-600 rounded-xl peer-checked:border-primary-500 peer-checked:bg-primary-50 dark:peer-checked:bg-primary-900/20 transition-all hover:border-primary-300">
                                <i class="bi bi-moon text-2xl text-blue-500 mb-2"></i>
                                <p class="text-sm font-semibold text-gray-900 dark:text-white">Dark</p>
                            </div>
                        </label>

                        <!-- System Theme -->
                        <label class="cursor-pointer">
                            <input type="radio" name="theme" value="system"
                                {{ ($settings['theme'] ?? 'system') === 'system' ? 'checked' : '' }}
                                class="peer sr-only">
                            <div class="p-4 text-center border-2 border-gray-200 dark:border-gray-600 rounded-xl peer-checked:border-primary-500 peer-checked:bg-primary-50 dark:peer-checked:bg-primary-900/20 transition-all hover:border-primary-300">
                                <i class="bi bi-display text-2xl text-gray-500 mb-2"></i>
                                <p class="text-sm font-semibold text-gray-900 dark:text-white">System</p>
                            </div>
                        </label>
                    </div>
                    @error('theme')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Notification Settings -->
                <div class="mb-8">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                        <i class="bi bi-bell text-primary-600"></i>
                        Notifikasi
                    </h3>

                    <div class="space-y-4">
                        <!-- Email Notifications -->
                        <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                            <div>
                                <p class="font-semibold text-gray-900 dark:text-white">Notifikasi Email</p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Terima update dan alert via email</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="email_notifications" value="1"
                                    {{ ($settings['email_notifications'] ?? true) ? 'checked' : '' }}
                                    class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-300 dark:peer-focus:ring-primary-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-primary-600"></div>
                            </label>
                        </div>

                        <!-- SMS Notifications -->
                        <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                            <div>
                                <p class="font-semibold text-gray-900 dark:text-white">Notifikasi SMS</p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Terima alert penting via SMS</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="sms_notifications" value="1"
                                    {{ ($settings['sms_notifications'] ?? false) ? 'checked' : '' }}
                                    class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-300 dark:peer-focus:ring-primary-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-primary-600"></div>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Save Button -->
                <div class="flex justify-end gap-3 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <a href="{{ route('profile') }}"
                       class="px-6 py-3 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-xl font-semibold hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                        Batal
                    </a>
                    <button type="submit"
                            class="px-6 py-3 gradient-primary text-white rounded-xl font-semibold shadow-md hover:shadow-lg hover:scale-105 transition-all duration-300 flex items-center gap-2">
                        <i class="bi bi-check-circle"></i>
                        <span>Simpan Pengaturan</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Info Box -->
        <div class="mt-6 bg-blue-50 dark:bg-blue-900/20 rounded-2xl border border-blue-200 dark:border-blue-700 p-6">
            <h3 class="text-sm font-bold text-blue-900 dark:text-blue-300 mb-3 flex items-center gap-2">
                <i class="bi bi-info-circle"></i>
                Informasi:
            </h3>
            <ul class="text-xs text-blue-800 dark:text-blue-200 space-y-1.5">
                <li class="flex items-start gap-2">
                    <i class="bi bi-check2 text-blue-600 dark:text-blue-400 mt-0.5"></i>
                    <span>Pengaturan tema akan diterapkan setelah halaman direfresh</span>
                </li>
                <li class="flex items-start gap-2">
                    <i class="bi bi-check2 text-blue-600 dark:text-blue-400 mt-0.5"></i>
                    <span>Notifikasi SMS memerlukan nomor telepon yang terverifikasi</span>
                </li>
                <li class="flex items-start gap-2">
                    <i class="bi bi-check2 text-blue-600 dark:text-blue-400 mt-0.5"></i>
                    <span>Anda dapat mengubah pengaturan ini kapan saja</span>
                </li>
            </ul>
        </div>
    </div>
</div>

<!-- Theme Change Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle theme change immediately (optional - for preview)
    document.querySelectorAll('input[name="theme"]').forEach(radio => {
        radio.addEventListener('change', function() {
            if (this.value === 'dark') {
                document.documentElement.classList.add('dark');
                localStorage.theme = 'dark';
            } else if (this.value === 'light') {
                document.documentElement.classList.remove('dark');
                localStorage.theme = 'light';
            } else {
                // System preference
                if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
                    document.documentElement.classList.add('dark');
                    localStorage.theme = 'dark';
                } else {
                    document.documentElement.classList.remove('dark');
                    localStorage.theme = 'light';
                }
            }
        });
    });
});
</script>
@endsection
