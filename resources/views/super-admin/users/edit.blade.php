@extends('layouts.app')
@section('title', 'Edit User')

@section('content')
<div class="max-w-3xl mx-auto">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center gap-4">
            <a href="{{ route('super-admin.users.index') }}"
               class="group relative w-12 h-12 bg-white dark:bg-gray-800 rounded-xl flex items-center justify-center hover:bg-gray-50 dark:hover:bg-gray-700 transition-all shadow-sm hover:shadow-md border border-gray-200 dark:border-gray-700">
                <i class="bi bi-arrow-left text-lg text-gray-700 dark:text-gray-300 group-hover:-translate-x-0.5 transition-transform"></i>
            </a>
            <div>
                <h1 class="text-2xl lg:text-3xl font-bold text-gray-900 dark:text-white mb-1">Edit User</h1>
                <p class="text-gray-600 dark:text-gray-400 font-medium">Update informasi user</p>
            </div>
        </div>
    </div>

    <!-- Edit Form -->
    <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-lg border border-gray-200 dark:border-gray-700 p-8">
        <form action="{{ route('super-admin.users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Name -->
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                    Nama Lengkap <span class="text-red-500">*</span>
                </label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                       class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 text-gray-900 dark:text-white font-medium">
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                    Email <span class="text-red-500">*</span>
                </label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                       class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 text-gray-900 dark:text-white font-medium">
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password (Optional) -->
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                    Password Baru <span class="text-gray-400 font-normal">(Kosongkan jika tidak ingin mengubah)</span>
                </label>
                <input type="password" name="password"
                       class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 text-gray-900 dark:text-white font-medium">
                @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Role -->
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                    Role <span class="text-red-500">*</span>
                </label>
                <select name="role" required
                        class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 text-gray-900 dark:text-white font-medium">
                    <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>User</option>
                    <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
                @error('role')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Is Active -->
            <div class="mb-6">
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $user->is_active) ? 'checked' : '' }}
                           class="w-5 h-5 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                    <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">User Aktif</span>
                </label>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Nonaktifkan user untuk menonaktifkan akses login</p>
            </div>

            <!-- Action Buttons -->
            <div class="flex gap-3 pt-6 border-t border-gray-200 dark:border-gray-700">
                <a href="{{ route('super-admin.users.index') }}"
                   class="flex-1 px-6 py-3 bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white rounded-xl font-semibold hover:bg-gray-300 dark:hover:bg-gray-600 transition-all text-center">
                    Batal
                </a>
                <button type="submit"
                        class="flex-1 px-6 py-3 bg-gradient-to-r from-blue-500 to-cyan-600 text-white rounded-xl font-semibold hover:from-blue-600 hover:to-cyan-700 transition-all shadow-md hover:shadow-lg">
                    <i class="bi bi-check-circle mr-2"></i>
                    Update User
                </button>
            </div>
        </form>
    </div>

    <!-- Delete User Section -->
    <div class="mt-6 bg-gradient-to-br from-rose-50 via-white to-red-50 dark:from-gray-800 dark:via-gray-700 dark:to-gray-800 rounded-3xl p-6 border border-rose-200 dark:border-gray-600">
        <h3 class="text-lg font-bold text-rose-900 dark:text-rose-300 mb-2 flex items-center gap-2">
            <i class="bi bi-exclamation-triangle"></i>
            Zona Berbahaya
        </h3>
        <p class="text-sm text-rose-700 dark:text-rose-400 mb-4">
            Menghapus user adalah tindakan permanen dan tidak dapat dibatalkan.
        </p>
        <form action="{{ route('super-admin.users.destroy', $user->id) }}" method="POST"
              onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini? Tindakan ini tidak dapat dibatalkan.')">
            @csrf
            @method('DELETE')
            <button type="submit"
                    class="px-6 py-3 bg-gradient-to-r from-rose-500 to-red-600 text-white rounded-xl font-semibold hover:from-rose-600 hover:to-red-700 transition-all shadow-md hover:shadow-lg">
                <i class="bi bi-trash mr-2"></i>
                Hapus User
            </button>
        </form>
    </div>
</div>
@endsection
