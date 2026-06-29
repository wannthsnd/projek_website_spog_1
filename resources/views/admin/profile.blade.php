@extends('layouts.app')
@section('title', 'Profil Admin')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Header -->
    <div class="mb-8 flex items-center gap-4">
        <a href="{{ route('admin.dashboard') }}"
           class="w-12 h-12 bg-gray-200 dark:bg-gray-700 rounded-xl flex items-center justify-center hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors">
            <i class="bi bi-arrow-left text-xl text-gray-900 dark:text-white"></i>
        </a>
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-1">Profil Admin</h1>
            <p class="text-gray-600 dark:text-gray-400 font-medium">Kelola informasi akun administrator</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Profile Card -->
        <div class="lg:col-span-1">
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm p-6 text-center">
                <div class="relative inline-block mb-4">
                    <div class="w-24 h-24 gradient-secondary rounded-full flex items-center justify-center text-white text-3xl font-bold shadow-lg mx-auto">
                        {{ substr($admin->name, 0, 1) }}
                    </div>
                    <span class="absolute bottom-1 right-1 w-6 h-6 bg-green-500 border-4 border-white dark:border-gray-800 rounded-full"></span>
                </div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-1">{{ $admin->name }}</h3>
                <p class="text-gray-600 dark:text-gray-400 text-sm mb-3">{{ $admin->email }}</p>
                <span class="inline-flex items-center px-3 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 text-xs font-bold rounded-full">
                    <i class="bi bi-shield-check mr-1"></i>Administrator
                </span>

                <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <div class="flex justify-between text-sm mb-2">
                        <span class="text-gray-600 dark:text-gray-400">Bergabung</span>
                        <span class="font-semibold text-gray-900 dark:text-white">{{ $admin->created_at->format('d M Y') }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600 dark:text-gray-400">Total Permohonan</span>
                        <span class="font-semibold text-gray-900 dark:text-white">{{ \App\Models\ShipPermit::count() }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Profile Form -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Update Profile Form -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm p-6">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                    <i class="bi bi-person-circle text-blue-600"></i>
                    Informasi Admin
                </h3>

                @if(session('success'))
                <div class="mb-4 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-700 rounded-xl">
                    <p class="text-sm font-semibold text-green-700 dark:text-green-400">{{ session('success') }}</p>
                </div>
                @endif

                <form action="{{ route('admin.profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Nama Lengkap</label>
                            <input type="text" name="name" value="{{ old('name', $admin->name) }}"
                                class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 text-gray-900 dark:text-white font-medium"
                                required>
                            @error('name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Email</label>
                            <input type="email" name="email" value="{{ old('email', $admin->email) }}"
                                class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 text-gray-900 dark:text-white font-medium"
                                required>
                            @error('email')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end">
                        <button type="submit" class="px-6 py-3 gradient-secondary text-white rounded-xl font-semibold shadow-md hover:shadow-lg hover:scale-105 transition-all duration-300">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>

            <!-- Update Password Form -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm p-6">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                    <i class="bi bi-lock text-blue-600"></i>
                    Ubah Password
                </h3>

                <form action="{{ route('admin.profile.password') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Password Saat Ini</label>
                            <input type="password" name="current_password"
                                class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 text-gray-900 dark:text-white font-medium"
                                required>
                            @error('current_password')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Password Baru</label>
                            <input type="password" name="password"
                                class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 text-gray-900 dark:text-white font-medium"
                                required>
                            @error('password')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Konfirmasi Password Baru</label>
                            <input type="password" name="password_confirmation"
                                class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 text-gray-900 dark:text-white font-medium"
                                required>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end">
                        <button type="submit" class="px-6 py-3 gradient-secondary text-white rounded-xl font-semibold shadow-md hover:shadow-lg hover:scale-105 transition-all duration-300">
                            Ubah Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
