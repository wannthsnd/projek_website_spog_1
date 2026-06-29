@extends('layouts.app')
@section('title', 'Pengaturan Admin')

@section('content')
<div class="max-w-3xl mx-auto">
    <!-- Header -->
    <div class="mb-8 flex items-center gap-4">
        <a href="{{ route('admin.dashboard') }}"
           class="w-12 h-12 bg-gray-200 dark:bg-gray-700 rounded-xl flex items-center justify-center hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors">
            <i class="bi bi-arrow-left text-xl text-gray-900 dark:text-white"></i>
        </a>
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-1">Pengaturan Admin</h1>
            <p class="text-gray-600 dark:text-gray-400 font-medium">Kelola preferensi panel administrator</p>
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

        <form action="{{ route('admin.settings.update') }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Theme Settings -->
            <div class="mb-8">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                    <i class="bi bi-palette text-blue-600"></i>
                    Tampilan
                </h3>

                <div class="grid grid-cols-3 gap-3">
                    <!-- Light Theme -->
                    <label class="cursor-pointer">
                        <input type="radio" name="theme" value="light"
                            {{ ($settings['theme'] ?? 'system') === 'light' ? 'checked' : '' }}
                            class="peer sr-only">
                        <div class="p-4 text-center border-2 border-gray-200 dark:border-gray-600 rounded-xl peer-checked:border-blue-500 peer-checked:bg-blue-50 dark:peer-checked:bg-blue-900/20 transition-all hover:border-blue-300">
                            <i class="bi bi-sun text-2xl text-yellow-500 mb-2"></i>
                            <p class="text-sm font-semibold text-gray-900 dark:text-white">Light</p>
                        </div>
                    </label>

                    <!-- Dark Theme -->
                    <label class="cursor-pointer">
                        <input type="radio" name="theme" value="dark"
                            {{ ($settings['theme'] ?? 'system') === 'dark' ? 'checked' : '' }}
                            class="peer sr-only">
                        <div class="p-4 text-center border-2 border-gray-200 dark:border-gray-600 rounded-xl peer-checked:border-blue-500 peer-checked:bg-blue-50 dark:peer-checked:bg-blue-900/20 transition-all hover:border-blue-300">
                            <i class="bi bi-moon text-2xl text-blue-500 mb-2"></i>
                            <p class="text-sm font-semibold text-gray-900 dark:text-white">Dark</p>
                        </div>
                    </label>

                    <!-- System Theme -->
                    <label class="cursor-pointer">
                        <input type="radio" name="theme" value="system"
                            {{ ($settings['theme'] ?? 'system') === 'system' ? 'checked' : '' }}
                            class="peer sr-only">
                        <div class="p-4 text-center border-2 border-gray-200 dark:border-gray-600 rounded-xl peer-checked:border-blue-500 peer-checked:bg-blue-50 dark:peer-checked:bg-blue-900/20 transition-all hover:border-blue-300">
                            <i class="bi bi-display text-2xl text-gray-500 mb-2"></i>
                            <p class="text-sm font-semibold text-gray-900 dark:text-white">System</p>
                        </div>
                    </label>
                </div>
                @error('theme')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Dashboard View Setting (Admin Only) -->
            <div class="mb-8">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                    <i class="bi bi-grid-3x3-gap text-blue-600"></i>
                    Tampilan Dashboard
                </h3>

                <div class="grid grid-cols-2 gap-3">
                    <!-- Grid View -->
                    <label class="cursor-pointer">
                        <input type="radio" name="default_dashboard_view" value="grid"
                            {{ ($settings['default_dashboard_view'] ?? 'grid') === 'grid' ? 'checked' : '' }}
                            class="peer sr-only">
                        <div class="p-4 text-center border-2 border-gray-200 dark:border-gray-600 rounded-xl peer-checked:border-blue-500 peer-checked:bg-blue-50 dark:peer-checked:bg-blue-900/20 transition-all hover:border-blue-300">
                            <i class="bi bi-grid-3x3-gap text-2xl text-blue-500 mb-2"></i>
                            <p class="text-sm font-semibold text-gray-900 dark:text-white">Grid View</p>
                        </div>
                    </label>

                    <!-- List View -->
                    <label class="cursor-pointer">
                        <input type="radio" name="default_dashboard_view" value="list"
                            {{ ($settings['default_dashboard_view'] ?? 'grid') === 'list' ? 'checked' : '' }}
                            class="peer sr-only">
                        <div class="p-4 text-center border-2 border-gray-200 dark:border-gray-600 rounded-xl peer-checked:border-blue-500 peer-checked:bg-blue-50 dark:peer-checked:bg-blue-900/20 transition-all hover:border-blue-300">
                            <i class="bi bi-list-ul text-2xl text-blue-500 mb-2"></i>
                            <p class="text-sm font-semibold text-gray-900 dark:text-white">List View</p>
                        </div>
                    </label>
                </div>
                @error('default_dashboard_view')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Notification Settings -->
            <div class="mb-8">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                    <i class="bi bi-bell text-blue-600"></i>
                    Notifikasi
                </h3>

                <div class="space-y-4">
                    <!-- Email Notifications -->
                    <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                        <div>
                            <p class="font-semibold text-gray-900 dark:text-white">Notifikasi Email</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Terima alert permohonan baru dan sistem</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="email_notifications" value="1"
                                {{ ($settings['email_notifications'] ?? true) ? 'checked' : '' }}
                                class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                        </label>
                    </div>

                    <!-- SMS Notifications -->
                    <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                        <div>
                            <p class="font-semibold text-gray-900 dark:text-white">Notifikasi SMS</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Terima alert kritis via SMS</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="sms_notifications" value="1"
                                {{ ($settings['sms_notifications'] ?? false) ? 'checked' : '' }}
                                class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Save Button -->
            <div class="flex justify-end gap-3 pt-6 border-t border-gray-200 dark:border-gray-700">
                <a href="{{ route('admin.dashboard') }}"
                   class="px-6 py-3 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-xl font-semibold hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                    Batal
                </a>
                <button type="submit"
                        class="px-6 py-3 gradient-secondary text-white rounded-xl font-semibold shadow-md hover:shadow-lg hover:scale-105 transition-all duration-300 flex items-center gap-2">
                    <i class="bi bi-check-circle"></i>
                    <span>Simpan Pengaturan</span>
                </button>
            </div>
        </form>
    </div>

    <!-- System Info -->
    <div class="mt-6 bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-lg p-6">
        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
            <i class="bi bi-info-circle text-blue-600"></i>
            Informasi Sistem
        </h3>
        <div class="space-y-3 text-sm">
            <div class="flex justify-between py-2 border-b border-gray-200 dark:border-gray-700">
                <span class="text-gray-600 dark:text-gray-400">Versi Aplikasi</span>
                <span class="font-semibold text-gray-900 dark:text-white">1.0.0</span>
            </div>
            <div class="flex justify-between py-2 border-b border-gray-200 dark:border-gray-700">
                <span class="text-gray-600 dark:text-gray-400">Laravel Version</span>
                <span class="font-semibold text-gray-900 dark:text-white">{{ app()->version() }}</span>
            </div>
            <div class="flex justify-between py-2">
                <span class="text-gray-600 dark:text-gray-400">PHP Version</span>
                <span class="font-semibold text-gray-900 dark:text-white">{{ phpversion() }}</span>
            </div>
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
