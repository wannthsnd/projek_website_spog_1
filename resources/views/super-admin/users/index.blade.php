@extends('layouts.app')
@section('title', 'Kelola Users')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="flex items-center gap-4">
                <a href="{{ route('super-admin.dashboard') }}" class="w-12 h-12 bg-white dark:bg-gray-800 rounded-xl flex items-center justify-center hover:bg-gray-50 dark:hover:bg-gray-700 transition-all shadow-sm border border-gray-200 dark:border-gray-700">
                    <i class="bi bi-arrow-left text-lg text-gray-700 dark:text-gray-300"></i>
                </a>
                <div>
                    <h1 class="text-2xl lg:text-3xl font-bold text-gray-900 dark:text-white mb-1">Kelola Users</h1>
                    <p class="text-gray-600 dark:text-gray-400 font-medium">Manajemen semua user dalam sistem</p>
                </div>
            </div>
            <a href="{{ route('super-admin.users.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-blue-500 to-cyan-600 text-white rounded-xl font-semibold hover:from-blue-600 hover:to-cyan-700 transition-all shadow-md hover:shadow-lg">
                <i class="bi bi-person-plus"></i>
                <span>Tambah User</span>
            </a>
        </div>
    </div>

    <!-- Search & Filter -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-4 mb-6">
        <form method="GET" class="flex flex-col md:flex-row gap-4">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau email..."
                   class="flex-1 px-4 py-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl focus:outline-none focus:border-blue-500">
            <select name="status" class="px-4 py-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl">
                <option value="">Semua Status</option>
                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif</option>
                <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Non-aktif</option>
            </select>
            <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white rounded-xl font-semibold hover:bg-blue-700 transition-all">
                <i class="bi bi-search mr-1"></i> Filter
            </button>
        </form>
    </div>

    <!-- Users Table -->
    <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr class="bg-gray-50 dark:bg-gray-700/50">
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 dark:text-gray-400 uppercase">User</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 dark:text-gray-400 uppercase">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 dark:text-gray-400 uppercase">Terdaftar</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 dark:text-gray-400 uppercase">Login Terakhir</th>
                        <th class="px-6 py-4 text-right text-xs font-bold text-gray-600 dark:text-gray-400 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($users as $user)
                    <tr class="group hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-all">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-cyan-500 rounded-lg flex items-center justify-center text-white font-bold">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                <div class="min-w-0">
                                    <p class="font-semibold text-gray-900 dark:text-white truncate">{{ $user->name }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ $user->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold border
                                    {{ $user->is_active ? 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300 border-emerald-200 dark:border-emerald-700' : 'bg-rose-100 dark:bg-rose-900/30 text-rose-700 dark:text-rose-300 border-rose-200 dark:border-rose-700' }}">
                                    {{ $user->is_active ? 'Aktif' : 'Non-aktif' }}
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300">
                            {{ $user->created_at->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300">
                            @if($user->last_login_at)
                                @php
                                    $lastLogin = $user->last_login_at;
                                    // Handle if last_login_at is a string
                                    if (is_string($lastLogin)) {
                                        $lastLogin = \Carbon\Carbon::parse($lastLogin);
                                    }
                                    echo $lastLogin->format('d M Y H:i');
                                @endphp
                            @else
                                -
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-1.5">
                                <a href="{{ route('super-admin.users.edit', $user->id) }}" class="inline-flex items-center justify-center w-8 h-8 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-lg hover:bg-blue-200 dark:hover:bg-blue-900/50 transition-all" title="Edit">
                                    <i class="bi bi-pencil text-sm"></i>
                                </a>
                                <form action="{{ route('super-admin.users.toggle-status', $user->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center justify-center w-8 h-8 {{ $user->is_active ? 'bg-amber-100 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400 hover:bg-amber-200' : 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 hover:bg-emerald-200' }} rounded-lg transition-all" title="{{ $user->is_active ? 'Suspend' : 'Activate' }}">
                                        <i class="bi {{ $user->is_active ? 'bi-pause' : 'bi-play' }} text-sm"></i>
                                    </button>
                                </form>
                                <form action="{{ route('super-admin.users.destroy', $user->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus user ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="inline-flex items-center justify-center w-8 h-8 bg-rose-100 dark:bg-rose-900/30 text-rose-600 dark:text-rose-400 rounded-lg hover:bg-rose-200 dark:hover:bg-rose-900/50 transition-all" title="Hapus">
                                        <i class="bi bi-trash text-sm"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-16 text-center">
                            <p class="text-gray-500 dark:text-gray-400">Tidak ada user ditemukan</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($users->hasPages())
        <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
            {{ $users->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
