@extends('layouts.app')
@section('title', 'Kelola Permohonan - Super Admin')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="flex items-center gap-4">
                <a href="{{ route('super-admin.dashboard') }}"
                   class="group relative w-12 h-12 bg-white dark:bg-gray-800 rounded-xl flex items-center justify-center hover:bg-gray-50 dark:hover:bg-gray-700 transition-all shadow-sm hover:shadow-md border border-gray-200 dark:border-gray-700">
                    <i class="bi bi-arrow-left text-lg text-gray-700 dark:text-gray-300 group-hover:-translate-x-0.5 transition-transform"></i>
                </a>
                <div>
                    <h1 class="text-2xl lg:text-3xl font-bold text-gray-900 dark:text-white mb-1">Kelola Permohonan</h1>
                    <p class="text-gray-600 dark:text-gray-400 font-medium">Manajemen semua permohonan SPOG dalam sistem</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 border border-gray-200 dark:border-gray-700 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">Total Permohonan</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ number_format($permits->total()) }}</p>
                </div>
                <div class="w-12 h-12 bg-gradient-to-br from-blue-400 to-cyan-500 rounded-xl flex items-center justify-center shadow-md">
                    <i class="bi bi-folder-check text-xl text-white"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-amber-50 via-white to-orange-50 dark:from-gray-800 dark:via-gray-700 dark:to-gray-800 rounded-2xl p-5 border border-amber-200 dark:border-gray-600 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-amber-700 dark:text-amber-400 mb-1">Pending</p>
                    <p class="text-3xl font-bold text-amber-700 dark:text-amber-300">{{ $permits->where('status', 'pending')->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-gradient-to-br from-amber-400 to-orange-500 rounded-xl flex items-center justify-center shadow-md">
                    <i class="bi bi-clock-history text-xl text-white"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-emerald-50 via-white to-green-50 dark:from-gray-800 dark:via-gray-700 dark:to-gray-800 rounded-2xl p-5 border border-emerald-200 dark:border-gray-600 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-emerald-700 dark:text-emerald-400 mb-1">Approved</p>
                    <p class="text-3xl font-bold text-emerald-700 dark:text-emerald-300">{{ $permits->where('status', 'approved')->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-gradient-to-br from-emerald-400 to-green-600 rounded-xl flex items-center justify-center shadow-md">
                    <i class="bi bi-check-circle text-xl text-white"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-rose-50 via-white to-red-50 dark:from-gray-800 dark:via-gray-700 dark:to-gray-800 rounded-2xl p-5 border border-rose-200 dark:border-gray-600 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-rose-700 dark:text-rose-400 mb-1">Rejected</p>
                    <p class="text-3xl font-bold text-rose-700 dark:text-rose-300">{{ $permits->where('status', 'rejected')->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-gradient-to-br from-rose-400 to-red-600 rounded-xl flex items-center justify-center shadow-md">
                    <i class="bi bi-x-circle text-xl text-white"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters & Search -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6 mb-6">
        <form method="GET" action="{{ route('super-admin.permits.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="md:col-span-2">
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Cari Pemohon</label>
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Nama atau email..."
                       class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 text-gray-900 dark:text-white">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Status</label>
                <select name="status" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 text-gray-900 dark:text-white">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit" class="w-full px-4 py-2.5 bg-gradient-to-r from-blue-500 to-cyan-600 text-white rounded-xl font-semibold hover:from-blue-600 hover:to-cyan-700 transition-all shadow-md hover:shadow-lg">
                    <i class="bi bi-search mr-2"></i>Filter
                </button>
            </div>
        </form>
    </div>

    <!-- Permits Table -->
    <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-gray-50 dark:bg-gray-700/50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 dark:text-gray-400 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Pemohon</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Kapal</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-right text-xs font-bold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($permits as $permit)
                    <tr class="group hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-all">
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-1 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 text-xs font-mono font-bold rounded-lg">
                                #{{ str_pad($permit->id, 4, '0', STR_PAD_LEFT) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="min-w-0">
                                <p class="font-semibold text-gray-900 dark:text-white truncate">{{ $permit->name }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ $permit->email }}</p>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 bg-gradient-to-br from-amber-400 to-orange-500 rounded-lg flex items-center justify-center">
                                    <i class="bi bi-ship text-white text-sm"></i>
                                </div>
                                <span class="font-medium text-gray-900 dark:text-white">{{ $permit->ship_type }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $permit->application_date->format('d M Y') }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $permit->application_date->diffForHumans() }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-xs font-bold border
                                {{ $permit->status === 'pending' ? 'bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-300 border-amber-200 dark:border-amber-700' : '' }}
                                {{ $permit->status === 'approved' ? 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300 border-emerald-200 dark:border-emerald-700' : '' }}
                                {{ $permit->status === 'rejected' ? 'bg-rose-100 dark:bg-rose-900/30 text-rose-700 dark:text-rose-300 border-rose-200 dark:border-rose-700' : '' }}">
                                @if($permit->status === 'pending')
                                <span class="w-1.5 h-1.5 bg-amber-500 rounded-full animate-pulse"></span>
                                @elseif($permit->status === 'approved')
                                <i class="bi bi-check-circle-fill text-emerald-500"></i>
                                @else
                                <i class="bi bi-x-circle-fill text-rose-500"></i>
                                @endif
                                {{ ucfirst($permit->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('super-admin.permits.show', $permit->id) }}"
                                   class="inline-flex items-center justify-center w-9 h-9 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-xl hover:bg-blue-200 dark:hover:bg-blue-900/50 transition-all"
                                   title="Lihat Detail">
                                    <i class="bi bi-eye text-sm"></i>
                                </a>
                                <form action="{{ route('super-admin.permits.destroy', $permit->id) }}" method="POST"
                                      onsubmit="return confirm('Yakin ingin menghapus permohonan ini?')" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="inline-flex items-center justify-center w-9 h-9 bg-rose-100 dark:bg-rose-900/30 text-rose-600 dark:text-rose-400 rounded-xl hover:bg-rose-200 dark:hover:bg-rose-900/50 transition-all"
                                            title="Hapus">
                                        <i class="bi bi-trash text-sm"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center gap-4">
                                <div class="w-20 h-20 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center">
                                    <i class="bi bi-inbox text-3xl text-gray-400 dark:text-gray-500"></i>
                                </div>
                                <p class="text-gray-600 dark:text-gray-400">Tidak ada permohonan yang ditemukan</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($permits->hasPages())
        <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
            {{ $permits->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
