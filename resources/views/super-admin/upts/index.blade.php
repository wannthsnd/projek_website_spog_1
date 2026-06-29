@extends('layouts.app')
@section('title', 'Kelola UPT')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header Section - Elegant with gradient -->
    <div class="mb-10">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
            <div class="flex items-center gap-5">
                <div class="relative group">
                    <div class="absolute inset-0 bg-gradient-to-br from-purple-600 via-indigo-600 to-blue-600 rounded-2xl blur-xl opacity-40 group-hover:opacity-60 transition-opacity duration-500"></div>
                    <a href="{{ route('super-admin.dashboard') }}"
                       class="relative w-14 h-14 bg-white dark:bg-gray-800 rounded-2xl flex items-center justify-center shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-200 dark:border-gray-700 group-hover:scale-105">
                        <i class="bi bi-arrow-left text-xl text-gray-700 dark:text-gray-300"></i>
                    </a>
                </div>
                <div>
                    <h1 class="text-2xl lg:text-3xl font-bold bg-gradient-to-r from-purple-600 via-indigo-600 to-blue-600 bg-clip-text text-transparent mb-2">
                        Kelola UPT
                    </h1>
                    <p class="text-gray-600 dark:text-gray-400 font-medium flex items-center gap-2">
                        <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                        Manajemen Unit Pelaksana Teknis
                    </p>
                </div>
            </div>

            <a href="{{ route('super-admin.upts.create') }}"
               class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-purple-500 to-indigo-600 text-white rounded-xl font-semibold hover:from-purple-600 hover:to-indigo-700 transition-all shadow-lg hover:shadow-xl hover:scale-105">
                <i class="bi bi-plus-circle"></i>
                <span>Tambah UPT</span>
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 border border-gray-200 dark:border-gray-700 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">Total UPT</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ number_format($upts->total()) }}</p>
                </div>
                <div class="w-12 h-12 bg-gradient-to-br from-purple-400 to-indigo-500 rounded-xl flex items-center justify-center shadow-md">
                    <i class="bi bi-building text-xl text-white"></i>
                </div>
            </div>
        </div>
        <div class="bg-gradient-to-br from-emerald-50 via-white to-green-50 dark:from-gray-800 dark:via-gray-700 dark:to-gray-800 rounded-2xl p-5 border border-emerald-200 dark:border-gray-600 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-emerald-700 dark:text-emerald-400 mb-1">Aktif</p>
                    <p class="text-3xl font-bold text-emerald-700 dark:text-emerald-300">{{ $upts->where('is_active', true)->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-gradient-to-br from-emerald-400 to-green-500 rounded-xl flex items-center justify-center shadow-md">
                    <i class="bi bi-check-circle text-xl text-white"></i>
                </div>
            </div>
        </div>
        <div class="bg-gradient-to-br from-gray-50 via-white to-gray-100 dark:from-gray-800 dark:via-gray-700 dark:to-gray-800 rounded-2xl p-5 border border-gray-200 dark:border-gray-600 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-700 dark:text-gray-400 mb-1">Nonaktif</p>
                    <p class="text-3xl font-bold text-gray-700 dark:text-gray-300">{{ $upts->where('is_active', false)->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-gradient-to-br from-gray-400 to-gray-600 rounded-xl flex items-center justify-center shadow-md">
                    <i class="bi bi-x-circle text-xl text-white"></i>
                </div>
            </div>
        </div>
        <div class="bg-gradient-to-br from-blue-50 via-white to-cyan-50 dark:from-gray-800 dark:via-gray-700 dark:to-gray-800 rounded-2xl p-5 border border-blue-200 dark:border-gray-600 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-blue-700 dark:text-blue-400 mb-1">Total Users</p>
                    <p class="text-3xl font-bold text-blue-700 dark:text-blue-300">{{ $upts->sum(fn($u) => $u->activeUsersCount()) }}</p>
                </div>
                <div class="w-12 h-12 bg-gradient-to-br from-blue-400 to-cyan-500 rounded-xl flex items-center justify-center shadow-md">
                    <i class="bi bi-people text-xl text-white"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Search & Filter Card -->
    <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl border border-gray-100 dark:border-gray-700 p-6 mb-8">
        <form method="GET" action="{{ route('super-admin.upts.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="md:col-span-2">
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Cari UPT</label>
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Nama, kode, atau region..."
                       class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 text-gray-900 dark:text-white">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Status</label>
                <select name="status" class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 text-gray-900 dark:text-white">
                    <option value="">Semua Status</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit" class="w-full px-6 py-3 bg-gradient-to-r from-purple-500 to-indigo-600 text-white rounded-xl font-semibold hover:from-purple-600 hover:to-indigo-700 transition-all shadow-md hover:shadow-lg">
                    <i class="bi bi-search mr-2"></i>Filter
                </button>
            </div>
        </form>
    </div>

    <!-- UPT Table - Premium Design -->
    <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl border border-gray-100 dark:border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-gradient-to-r from-purple-50 via-indigo-50 to-purple-50 dark:from-gray-700/50 dark:via-gray-600/50 dark:to-gray-700/50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 dark:text-gray-400 uppercase tracking-wider">UPT</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Kode</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Region</th>
                        <th class="px-6 py-4 text-center text-xs font-bold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Users</th>
                        <th class="px-6 py-4 text-center text-xs font-bold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-right text-xs font-bold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($upts as $upt)
                    <tr class="group hover:bg-gradient-to-r hover:from-purple-50/50 hover:to-indigo-50/50 dark:hover:from-gray-700/30 dark:hover:to-gray-600/30 transition-all duration-300">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="relative">
                                    <div class="absolute inset-0 bg-gradient-to-br from-purple-400 to-indigo-500 rounded-xl blur-sm opacity-50 group-hover:opacity-70 transition-opacity"></div>
                                    <div class="relative w-11 h-11 bg-gradient-to-br from-purple-400 to-indigo-500 rounded-xl flex items-center justify-center shadow-lg">
                                        <i class="bi bi-building text-white"></i>
                                    </div>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900 dark:text-white">{{ $upt->name }}</p>
                                    @if($upt->email)
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $upt->email }}</p>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300 text-sm font-mono font-bold rounded-lg shadow-sm">
                                {{ $upt->code }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300">{{ $upt->region ?? '-' }}</td>
                        <td class="px-6 py-4 text-center">
                            <span class="inline-flex items-center justify-center w-8 h-8 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 text-sm font-bold rounded-full shadow-sm">
                                {{ $upt->activeUsersCount() }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($upt->is_active)
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
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <!-- View Detail Button -->
                                <a href="{{ route('super-admin.upts.show', $upt->id) }}"
                                   class="inline-flex items-center justify-center w-9 h-9 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-xl hover:bg-blue-200 dark:hover:bg-blue-900/50 transition-all shadow-sm hover:shadow-md group/btn"
                                   title="Lihat Detail">
                                    <i class="bi bi-eye text-sm group-hover/btn:scale-110 transition-transform"></i>
                                </a>
                                <!-- Edit Button -->
                                <a href="{{ route('super-admin.upts.edit', $upt->id) }}"
                                   class="inline-flex items-center justify-center w-9 h-9 bg-amber-100 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400 rounded-xl hover:bg-amber-200 dark:hover:bg-amber-900/50 transition-all shadow-sm hover:shadow-md group/btn"
                                   title="Edit UPT">
                                    <i class="bi bi-pencil text-sm group-hover/btn:scale-110 transition-transform"></i>
                                </a>
                                <!-- Delete Button -->
                                <form action="{{ route('super-admin.upts.destroy', $upt->id) }}" method="POST"
                                      onsubmit="return confirm('Yakin ingin menghapus UPT ini?')" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="inline-flex items-center justify-center w-9 h-9 bg-rose-100 dark:bg-rose-900/30 text-rose-600 dark:text-rose-400 rounded-xl hover:bg-rose-200 dark:hover:bg-rose-900/50 transition-all shadow-sm hover:shadow-md group/btn"
                                            title="Hapus UPT">
                                        <i class="bi bi-trash text-sm group-hover/btn:scale-110 transition-transform"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center gap-4">
                                <div class="relative">
                                    <div class="absolute inset-0 bg-gradient-to-br from-purple-400 to-indigo-500 rounded-full blur-xl opacity-30"></div>
                                    <div class="relative w-20 h-20 bg-gradient-to-br from-purple-100 to-indigo-100 dark:from-gray-700 dark:to-gray-600 rounded-full flex items-center justify-center shadow-lg">
                                        <i class="bi bi-inbox text-3xl text-purple-400 dark:text-gray-400"></i>
                                    </div>
                                </div>
                                <p class="text-gray-600 dark:text-gray-400 font-medium">Belum ada UPT</p>
                                <a href="{{ route('super-admin.upts.create') }}"
                                   class="px-5 py-2.5 bg-gradient-to-r from-purple-500 to-indigo-600 text-white rounded-xl font-semibold text-sm hover:shadow-lg transition-all">
                                    <i class="bi bi-plus-circle mr-2"></i>Tambah UPT Pertama
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($upts->hasPages())
        <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-700/30">
            {{ $upts->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
