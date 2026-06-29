@extends('layouts.app')
@section('title', 'Kelola Admin - Super Admin')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header Section - Elegant with gradient -->
    <div class="mb-10">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
            <div class="flex items-center gap-5">
                <div class="relative group">
                    <div class="absolute inset-0 bg-gradient-to-br from-emerald-600 via-green-600 to-emerald-600 rounded-2xl blur-xl opacity-40 group-hover:opacity-60 transition-opacity duration-500"></div>
                    <a href="{{ route('super-admin.dashboard') }}"
                       class="relative w-14 h-14 bg-white dark:bg-gray-800 rounded-2xl flex items-center justify-center shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-200 dark:border-gray-700 group-hover:scale-105">
                        <i class="bi bi-arrow-left text-xl text-gray-700 dark:text-gray-300"></i>
                    </a>
                </div>
                <div>
                    <h1 class="text-2xl lg:text-3xl font-bold bg-gradient-to-r from-emerald-600 via-green-600 to-emerald-600 bg-clip-text text-transparent mb-2">
                        Kelola Admin
                    </h1>
                    <p class="text-gray-600 dark:text-gray-400 font-medium flex items-center gap-2">
                        <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                        Manajemen administrator per UPT
                    </p>
                </div>
            </div>

            <a href="{{ route('super-admin.admins.create') }}"
               class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-emerald-500 to-green-600 text-white rounded-xl font-semibold hover:from-emerald-600 hover:to-green-700 transition-all shadow-lg hover:shadow-xl hover:scale-105">
                <i class="bi bi-plus-circle"></i>
                <span>Tambah Admin</span>
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md transition-all">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">Total Admin</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ number_format($admins->total()) }}</p>
                </div>
                <div class="w-12 h-12 bg-gradient-to-br from-emerald-400 to-green-600 rounded-xl flex items-center justify-center shadow-md">
                    <i class="bi bi-person-gear text-xl text-white"></i>
                </div>
            </div>
        </div>
        <div class="bg-gradient-to-br from-blue-50 via-white to-cyan-50 dark:from-gray-800 dark:via-gray-700 dark:to-gray-800 rounded-2xl p-5 border border-blue-200 dark:border-gray-600 shadow-sm hover:shadow-md transition-all">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-blue-700 dark:text-blue-400 mb-1">UPT Terdaftar</p>
                    <p class="text-3xl font-bold text-blue-700 dark:text-blue-300">{{ $admins->pluck('upt_id')->unique()->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-gradient-to-br from-blue-400 to-cyan-500 rounded-xl flex items-center justify-center shadow-md">
                    <i class="bi bi-building text-xl text-white"></i>
                </div>
            </div>
        </div>
        <div class="bg-gradient-to-br from-purple-50 via-white to-indigo-50 dark:from-gray-800 dark:via-gray-700 dark:to-gray-800 rounded-2xl p-5 border border-purple-200 dark:border-gray-600 shadow-sm hover:shadow-md transition-all">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-purple-700 dark:text-purple-400 mb-1">Admin Aktif</p>
                    <p class="text-3xl font-bold text-purple-700 dark:text-purple-300">{{ $admins->where('is_active', 1)->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-gradient-to-br from-purple-400 to-indigo-500 rounded-xl flex items-center justify-center shadow-md">
                    <i class="bi bi-check-circle text-xl text-white"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Search & Filter Card -->
    <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl border border-gray-100 dark:border-gray-700 p-6 mb-8">
        <form method="GET" action="{{ route('super-admin.admins.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="md:col-span-2">
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Cari Admin</label>
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Nama atau email admin..."
                       class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 text-gray-900 dark:text-white">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Filter UPT</label>
                <select name="upt_id" class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 text-gray-900 dark:text-white">
                    <option value="">Semua UPT</option>
                    @foreach($upts as $upt)
                    <option value="{{ $upt->id }}" {{ request('upt_id') == $upt->id ? 'selected' : '' }}>
                        {{ $upt->name }} ({{ $upt->code }})
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit" class="w-full px-6 py-3 bg-gradient-to-r from-emerald-500 to-green-600 text-white rounded-xl font-semibold hover:from-emerald-600 hover:to-green-700 transition-all shadow-md hover:shadow-lg">
                    <i class="bi bi-search mr-2"></i>Filter
                </button>
            </div>
        </form>
    </div>

    <!-- Admins Table - Premium Design -->
    <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl border border-gray-100 dark:border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-gradient-to-r from-emerald-50/50 via-green-50/50 to-emerald-50/50 dark:from-gray-700/50 dark:via-gray-600/50 dark:to-gray-700/50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Admin</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 dark:text-gray-400 uppercase tracking-wider">UPT</th>
                        <th class="px-6 py-4 text-center text-xs font-bold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-center text-xs font-bold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Terdaftar</th>
                        <th class="px-6 py-4 text-right text-xs font-bold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($admins as $admin)
                    <tr class="group hover:bg-gradient-to-r hover:from-emerald-50/50 hover:to-green-50/50 dark:hover:from-gray-700/30 dark:hover:to-gray-600/30 transition-all duration-300">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="relative">
                                    <div class="absolute inset-0 bg-gradient-to-br from-emerald-400 to-green-600 rounded-xl blur-sm opacity-50 group-hover:opacity-70 transition-opacity"></div>
                                    <div class="relative w-11 h-11 bg-gradient-to-br from-emerald-400 to-green-600 rounded-xl flex items-center justify-center shadow-lg">
                                        <span class="text-white font-bold">{{ substr($admin->name, 0, 1) }}</span>
                                    </div>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900 dark:text-white">{{ $admin->name }}</p>
                                    @if($admin->isSuperAdmin())
                                    <span class="text-xs text-purple-600 dark:text-purple-400 font-medium">Super Admin</span>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300">{{ $admin->email }}</td>
                        <td class="px-6 py-4">
                            @if($admin->upt)
                            <div class="flex items-center gap-2">
                                <span class="px-3 py-1 bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300 text-xs font-mono font-bold rounded-lg shadow-sm">
                                    {{ $admin->upt->code }}
                                </span>
                                <span class="text-sm text-gray-700 dark:text-gray-300 hidden sm:inline">
                                    {{ $admin->upt->name }}
                                </span>
                            </div>
                            @else
                            <span class="text-xs text-gray-500">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($admin->is_active)
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300 text-xs font-bold rounded-full shadow-sm">
                                <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full animate-pulse"></span>
                                Aktif
                            </span>
                            @else
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 text-xs font-bold rounded-full shadow-sm">
                                <span class="w-1.5 h-1.5 bg-gray-500 rounded-full"></span>
                                Nonaktif
                            </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center text-sm text-gray-700 dark:text-gray-300">
                            {{ $admin->created_at->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <!-- ✅ View Detail Button -->
                                <a href="{{ route('super-admin.admins.show', $admin->id) }}"
                                   class="inline-flex items-center justify-center w-9 h-9 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-xl hover:bg-blue-200 dark:hover:bg-blue-900/50 transition-all shadow-sm hover:shadow-md group/btn"
                                   title="Lihat Detail">
                                    <i class="bi bi-eye text-sm group-hover/btn:scale-110 transition-transform"></i>
                                </a>
                                <!-- Edit Button -->
                                <a href="{{ route('super-admin.admins.edit', $admin->id) }}"
                                   class="inline-flex items-center justify-center w-9 h-9 bg-amber-100 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400 rounded-xl hover:bg-amber-200 dark:hover:bg-amber-900/50 transition-all shadow-sm hover:shadow-md group/btn"
                                   title="Edit Admin">
                                    <i class="bi bi-pencil text-sm group-hover/btn:scale-110 transition-transform"></i>
                                </a>
                                <!-- Delete Button -->
                                @if(!$admin->isSuperAdmin())
                                <form action="{{ route('super-admin.admins.destroy', $admin->id) }}" method="POST"
                                      onsubmit="return confirm('Yakin ingin menghapus admin ini?')" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="inline-flex items-center justify-center w-9 h-9 bg-rose-100 dark:bg-rose-900/30 text-rose-600 dark:text-rose-400 rounded-xl hover:bg-rose-200 dark:hover:bg-rose-900/50 transition-all shadow-sm hover:shadow-md group/btn"
                                            title="Hapus Admin">
                                        <i class="bi bi-trash text-sm group-hover/btn:scale-110 transition-transform"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center gap-4">
                                <div class="relative">
                                    <div class="absolute inset-0 bg-gradient-to-br from-emerald-400 to-green-600 rounded-full blur-xl opacity-30"></div>
                                    <div class="relative w-20 h-20 bg-gradient-to-br from-emerald-100 to-green-100 dark:from-gray-700 dark:to-gray-600 rounded-full flex items-center justify-center shadow-lg">
                                        <i class="bi bi-inbox text-3xl text-emerald-400 dark:text-gray-400"></i>
                                    </div>
                                </div>
                                <p class="text-gray-600 dark:text-gray-400 font-medium">Belum ada admin</p>
                                <a href="{{ route('super-admin.admins.create') }}"
                                   class="px-5 py-2.5 bg-gradient-to-r from-emerald-500 to-green-600 text-white rounded-xl font-semibold text-sm hover:shadow-lg transition-all">
                                    <i class="bi bi-plus-circle mr-2"></i>Tambah Admin Pertama
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($admins->hasPages())
        <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-700/30">
            {{ $admins->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
