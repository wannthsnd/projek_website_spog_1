@extends('layouts.app')
@section('title', 'Tambah User Baru')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center gap-4">
            <a href="{{ route('super-admin.users.index') }}"
               class="w-12 h-12 bg-white dark:bg-gray-800 rounded-xl flex items-center justify-center hover:bg-gray-50 dark:hover:bg-gray-700 transition-all shadow-sm border border-gray-200 dark:border-gray-700">
                <i class="bi bi-arrow-left text-lg text-gray-700 dark:text-gray-300"></i>
            </a>
            <div>
                <h1 class="text-2xl lg:text-3xl font-bold text-gray-900 dark:text-white mb-1">Tambah User Baru</h1>
                <p class="text-gray-600 dark:text-gray-400 font-medium">Isi form di bawah untuk menambahkan user baru</p>
            </div>
        </div>
    </div>

    <!-- Form -->
    <form action="{{ route('super-admin.users.store') }}" method="POST" class="bg-white dark:bg-gray-800 rounded-3xl shadow-lg border border-gray-200 dark:border-gray-700 p-6 lg:p-8">
        @csrf

        <!-- Personal Information -->
        <div class="mb-8">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                <i class="bi bi-person text-blue-500"></i>
                Informasi Pribadi
            </h3>

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                           class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 text-gray-900 dark:text-white @error('name') border-red-500 @enderror"
                           placeholder="Masukkan nama lengkap">
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Email <span class="text-red-500">*</span>
                    </label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                           class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 text-gray-900 dark:text-white @error('email') border-red-500 @enderror"
                           placeholder="email@example.com">
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Account Information -->
        <div class="mb-8">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                <i class="bi bi-shield-lock text-purple-500"></i>
                Informasi Akun
            </h3>

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Password <span class="text-red-500">*</span>
                    </label>
                    <input type="password" name="password" required
                           class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 text-gray-900 dark:text-white @error('password') border-red-500 @enderror"
                           placeholder="Minimal 8 karakter">
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Konfirmasi Password <span class="text-red-500">*</span>
                    </label>
                    <input type="password" name="password_confirmation" required
                           class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 text-gray-900 dark:text-white"
                           placeholder="Ulangi password">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        UPT <span class="text-red-500">*</span>
                    </label>
                    <select name="upt_id" required
                            class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 text-gray-900 dark:text-white @error('upt_id') border-red-500 @enderror">
                        <option value="">Pilih UPT</option>
                        @foreach($upts as $upt)
                            <option value="{{ $upt->id }}" {{ old('upt_id') == $upt->id ? 'selected' : '' }}>
                                {{ $upt->name }} ({{ $upt->code }})
                            </option>
                        @endforeach
                    </select>
                    @error('upt_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Status Akun
                    </label>
                    <div class="flex items-center gap-3">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                                   class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                            <span class="text-sm text-gray-700 dark:text-gray-300">Aktif</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="is_active" value="0" {{ old('is_active') === false ? 'checked' : '' }}
                                   class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                            <span class="text-sm text-gray-700 dark:text-gray-300">Non-Aktif</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex gap-4 pt-6 border-t border-gray-200 dark:border-gray-700">
            <a href="{{ route('super-admin.users.index') }}"
               class="flex-1 px-6 py-3 bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white rounded-xl font-semibold hover:bg-gray-300 dark:hover:bg-gray-600 transition-all text-center">
                Batal
            </a>
            <button type="submit"
                    class="flex-1 px-6 py-3 bg-gradient-to-r from-blue-500 to-cyan-600 text-white rounded-xl font-semibold hover:from-blue-600 hover:to-cyan-700 transition-all shadow-md hover:shadow-lg">
                <i class="bi bi-check-circle mr-2"></i>
                Simpan User
            </button>
        </div>
    </form>
</div>
@endsection
