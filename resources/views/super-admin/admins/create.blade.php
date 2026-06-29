@extends('layouts.app')
@section('title', 'Tambah Admin - Super Admin')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Header -->
    <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div class="flex items-center gap-4">
            <a href="{{ route('super-admin.admins.index') }}"
               class="group relative w-12 h-12 bg-white dark:bg-gray-800 rounded-xl flex items-center justify-center hover:bg-gray-50 dark:hover:bg-gray-700 transition-all shadow-sm hover:shadow-md border border-gray-200 dark:border-gray-700">
                <i class="bi bi-arrow-left text-lg text-gray-700 dark:text-gray-300 group-hover:-translate-x-0.5 transition-transform"></i>
            </a>
            <div>
                <h1 class="text-2xl lg:text-3xl font-bold text-gray-900 dark:text-white mb-1">Tambah Admin</h1>
                <p class="text-gray-600 dark:text-gray-400 font-medium">Buat akun administrator untuk UPT tertentu</p>
            </div>
        </div>
    </div>

    <!-- Form Card -->
    <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl border border-gray-100 dark:border-gray-700 overflow-hidden">
        <!-- Form Header -->
        <div class="px-8 py-6 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-emerald-50 via-green-50 to-emerald-50 dark:from-gray-700/50 dark:via-gray-600/50 dark:to-gray-700/50">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-gradient-to-br from-emerald-400 to-green-500 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="bi bi-person-gear text-2xl text-white"></i>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">Informasi Admin</h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Lengkapi data administrator di bawah ini</p>
                </div>
            </div>
        </div>

        <!-- Form Body -->
        <form action="{{ route('super-admin.admins.store') }}" method="POST" class="p-8">
            @csrf

            <div class="space-y-6">
                <!-- Name & Email Row -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Name -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Nama Lengkap <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="name" value="{{ old('name') }}" required
                               placeholder="Contoh: Budi Santoso"
                               class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 text-gray-900 dark:text-white font-medium @error('name') border-red-500 @enderror">
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Email <span class="text-red-500">*</span>
                        </label>
                        <input type="email" name="email" value="{{ old('email') }}" required
                               placeholder="admin.upt@example.com"
                               class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 text-gray-900 dark:text-white font-medium @error('email') border-red-500 @enderror">
                        @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Password Row -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Password -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Password <span class="text-red-500">*</span>
                        </label>
                        <input type="password" name="password" required minlength="8"
                               class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 text-gray-900 dark:text-white font-medium @error('password') border-red-500 @enderror">
                        @error('password')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Konfirmasi Password <span class="text-red-500">*</span>
                        </label>
                        <input type="password" name="password_confirmation" required minlength="8"
                               class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 text-gray-900 dark:text-white font-medium">
                        @error('password_confirmation')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- ✅ UPT Selector - PENTING -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Unit Pelaksana Teknis (UPT) <span class="text-red-500">*</span>
                    </label>
                    <select name="upt_id" required
                            class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 text-gray-900 dark:text-white font-medium @error('upt_id') border-red-500 @enderror">
                        <option value="">Pilih UPT...</option>
                        @foreach($upts as $upt)
                        <option value="{{ $upt->id }}" {{ old('upt_id') == $upt->id ? 'selected' : '' }}>
                            {{ $upt->name }} ({{ $upt->code }}) - {{ $upt->region ?? 'Regional' }}
                        </option>
                        @endforeach
                    </select>
                    @error('upt_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">
                        <i class="bi bi-info-circle mr-1"></i>
                        Admin hanya dapat mengelola data dari UPT yang dipilih
                    </p>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex gap-4 pt-8 mt-8 border-t border-gray-200 dark:border-gray-700">
                <a href="{{ route('super-admin.admins.index') }}"
                   class="flex-1 px-6 py-3.5 bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white rounded-xl font-semibold hover:bg-gray-300 dark:hover:bg-gray-600 transition-all text-center">
                    Batal
                </a>
                <button type="submit"
                        class="flex-1 px-6 py-3.5 bg-gradient-to-r from-emerald-500 to-green-600 text-white rounded-xl font-semibold hover:from-emerald-600 hover:to-green-700 transition-all shadow-lg hover:shadow-xl hover:scale-105">
                    <i class="bi bi-check-circle mr-2"></i>
                    Buat Admin
                </button>
            </div>
        </form>
    </div>

    <!-- Info Card -->
    <div class="mt-6 bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 dark:from-gray-800 dark:via-gray-700 dark:to-gray-800 rounded-2xl p-6 border border-blue-200 dark:border-gray-600">
        <div class="flex items-start gap-4">
            <div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-indigo-500 rounded-xl flex items-center justify-center flex-shrink-0 shadow-lg">
                <i class="bi bi-info-circle text-white"></i>
            </div>
            <div>
                <h3 class="text-sm font-bold text-gray-900 dark:text-white mb-1">Informasi Penting</h3>
                <ul class="text-xs text-gray-700 dark:text-gray-300 space-y-1.5">
                    <li class="flex items-start gap-2">
                        <i class="bi bi-check-circle text-blue-500 mt-0.5"></i>
                        <span>Admin hanya dapat mengakses data permohonan dari UPT yang ditugaskan</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <i class="bi bi-check-circle text-blue-500 mt-0.5"></i>
                        <span>UPT dapat diubah nanti melalui menu edit admin</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <i class="bi bi-check-circle text-blue-500 mt-0.5"></i>
                        <span>Pastikan email admin unik dan belum terdaftar di sistem</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
