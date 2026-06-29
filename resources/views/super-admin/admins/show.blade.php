@extends('layouts.app')
@section('title', 'Detail Admin - ' . $admin->name)

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header -->
    <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div class="flex items-center gap-4">
            <a href="{{ route('super-admin.admins.index') }}"
               class="group relative w-12 h-12 bg-white dark:bg-gray-800 rounded-xl flex items-center justify-center hover:bg-gray-50 dark:hover:bg-gray-700 transition-all shadow-sm hover:shadow-md border border-gray-200 dark:border-gray-700">
                <i class="bi bi-arrow-left text-lg text-gray-700 dark:text-gray-300 group-hover:-translate-x-0.5 transition-transform"></i>
            </a>
            <div>
                <h1 class="text-2xl lg:text-3xl font-bold text-gray-900 dark:text-white mb-1">Detail Admin</h1>
                <p class="text-gray-600 dark:text-gray-400 font-medium">Informasi lengkap administrator UPT</p>
            </div>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('super-admin.admins.edit', $admin->id) }}"
               class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-amber-500 to-orange-500 text-white rounded-xl font-semibold hover:from-amber-600 hover:to-orange-600 transition-all shadow-md">
                <i class="bi bi-pencil"></i>
                <span>Edit Admin</span>
            </a>
            <a href="{{ route('super-admin.admins.index') }}"
               class="inline-flex items-center gap-2 px-5 py-2.5 bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white rounded-xl font-semibold hover:bg-gray-300 dark:hover:bg-gray-600 transition-all">
                <i class="bi bi-arrow-left"></i>
                <span>Kembali</span>
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column - Admin Info -->
        <div class="lg:col-span-1">
            <!-- Admin Profile Card -->
            <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl border border-gray-100 dark:border-gray-700 overflow-hidden mb-6">
                <!-- Header with Gradient -->
                <div class="px-8 py-6 bg-gradient-to-r from-emerald-500 via-green-500 to-emerald-600">
                    <div class="flex flex-col items-center text-center">
                        <div class="relative mb-4">
                            <div class="absolute inset-0 bg-white/30 rounded-full blur-xl"></div>
                            <div class="relative w-24 h-24 bg-white rounded-full flex items-center justify-center shadow-lg">
                                <span class="text-4xl font-bold text-emerald-600">
                                    {{ substr($admin->name, 0, 1) }}
                                </span>
                            </div>
                        </div>
                        <h2 class="text-2xl font-bold text-white mb-1">{{ $admin->name }}</h2>
                        <p class="text-emerald-100 font-medium">{{ $admin->email }}</p>
                        <div class="mt-4 flex gap-2">
                            @if($admin->is_active)
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-400/30 backdrop-blur-sm border border-emerald-300/50 text-emerald-50 rounded-lg text-sm font-semibold">
                                <span class="w-2 h-2 bg-emerald-300 rounded-full animate-pulse"></span>
                                Aktif
                            </span>
                            @else
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-gray-400/30 backdrop-blur-sm border border-gray-300/50 text-gray-50 rounded-lg text-sm font-semibold">
                                <span class="w-2 h-2 bg-gray-300 rounded-full"></span>
                                Nonaktif
                            </span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Admin Details -->
                <div class="p-6 space-y-4">
                    <!-- UPT Info -->
                    @if($admin->upt)
                    <div class="p-4 bg-gradient-to-br from-purple-50 to-indigo-50 dark:from-purple-900/20 dark:to-indigo-900/20 rounded-xl border border-purple-200 dark:border-purple-700">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="w-10 h-10 bg-gradient-to-br from-purple-400 to-indigo-500 rounded-lg flex items-center justify-center shadow-md">
                                <i class="bi bi-building text-white"></i>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-purple-600 dark:text-purple-400 uppercase">UPT</p>
                                <p class="text-sm font-bold text-gray-900 dark:text-white">{{ $admin->upt->name }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 text-xs text-gray-600 dark:text-gray-400 ml-13 pl-13">
                            <span class="font-mono font-bold text-purple-600 dark:text-purple-400">{{ $admin->upt->code }}</span>
                            <span>•</span>
                            <span>{{ $admin->upt->region ?? 'Regional' }}</span>
                        </div>
                    </div>
                    @endif

                    <!-- Account Info -->
                    <div class="space-y-3">
                        <h3 class="text-sm font-bold text-gray-900 dark:text-white uppercase tracking-wider">Informasi Akun</h3>

                        <div class="flex items-start gap-3 p-3 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                            <i class="bi bi-calendar text-gray-500 dark:text-gray-400 mt-1"></i>
                            <div>
                                <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Terdaftar</p>
                                <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $admin->created_at->format('d M Y') }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $admin->created_at->diffForHumans() }}</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3 p-3 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                            <i class="bi bi-clock text-gray-500 dark:text-gray-400 mt-1"></i>
                            <div>
                                <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Terakhir Login</p>
                                <p class="text-sm font-medium text-gray-900 dark:text-white">
                                    @if($admin->last_login_at)
                                        {{ \Carbon\Carbon::parse($admin->last_login_at)->format('d M Y, H:i') }}
                                    @else
                                        Belum pernah
                                    @endif
                                </p>
                                @if($admin->last_login_at)
                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ \Carbon\Carbon::parse($admin->last_login_at)->diffForHumans() }}</p>
                                @endif
                            </div>
                        </div>

                        <div class="flex items-start gap-3 p-3 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                            <i class="bi bi-shield text-gray-500 dark:text-gray-400 mt-1"></i>
                            <div>
                                <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Role</p>
                                <p class="text-sm font-medium text-gray-900 dark:text-white capitalize">{{ $admin->role }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistics Card -->
            <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl border border-gray-100 dark:border-gray-700 p-6">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Statistik UPT</h3>
                <div class="space-y-3">
                    <div class="p-4 bg-gradient-to-br from-blue-50 to-cyan-50 dark:from-blue-900/20 dark:to-cyan-900/20 rounded-xl border border-blue-200 dark:border-blue-700">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs font-semibold text-blue-700 dark:text-blue-300 uppercase">Total Users</p>
                                <p class="text-2xl font-bold text-blue-900 dark:text-blue-100">{{ $stats['total_users'] }}</p>
                            </div>
                            <div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-cyan-500 rounded-lg flex items-center justify-center shadow-md">
                                <i class="bi bi-people text-white"></i>
                            </div>
                        </div>
                    </div>

                    <div class="p-4 bg-gradient-to-br from-amber-50 to-orange-50 dark:from-amber-900/20 dark:to-orange-900/20 rounded-xl border border-amber-200 dark:border-amber-700">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs font-semibold text-amber-700 dark:text-amber-300 uppercase">Total Permohonan</p>
                                <p class="text-2xl font-bold text-amber-900 dark:text-amber-100">{{ $stats['total_permits'] }}</p>
                            </div>
                            <div class="w-10 h-10 bg-gradient-to-br from-amber-400 to-orange-500 rounded-lg flex items-center justify-center shadow-md">
                                <i class="bi bi-folder-check text-white"></i>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-2">
                        <div class="p-3 bg-gradient-to-br from-rose-50 to-red-50 dark:from-rose-900/20 dark:to-red-900/20 rounded-xl border border-rose-200 dark:border-rose-700 text-center">
                            <p class="text-xs font-semibold text-rose-700 dark:text-rose-300 uppercase mb-1">Pending</p>
                            <p class="text-xl font-bold text-rose-900 dark:text-rose-100">{{ $stats['pending_permits'] }}</p>
                        </div>
                        <div class="p-3 bg-gradient-to-br from-emerald-50 to-green-50 dark:from-emerald-900/20 dark:to-green-900/20 rounded-xl border border-emerald-200 dark:border-emerald-700 text-center">
                            <p class="text-xs font-semibold text-emerald-700 dark:text-emerald-300 uppercase mb-1">Approved</p>
                            <p class="text-xl font-bold text-emerald-900 dark:text-emerald-100">{{ $stats['approved_permits'] }}</p>
                        </div>
                        <div class="p-3 bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-700/50 dark:to-gray-600/50 rounded-xl border border-gray-200 dark:border-gray-600 text-center">
                            <p class="text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase mb-1">Rejected</p>
                            <p class="text-xl font-bold text-gray-900 dark:text-gray-100">{{ $stats['rejected_permits'] }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column - Recent Activity -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Recent Users -->
            <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-blue-50/50 via-cyan-50/50 to-blue-50/50 dark:from-gray-700/50 dark:via-gray-600/50 dark:to-gray-700/50">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                        <i class="bi bi-people text-blue-600"></i>
                        User Terbaru di UPT Ini
                    </h3>
                </div>
                <div class="p-5">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @forelse($recentUsers as $user)
                        <div class="flex items-center gap-3 p-3 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                            <div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-cyan-500 rounded-lg flex items-center justify-center text-white font-bold">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-semibold text-gray-900 dark:text-white text-sm truncate">{{ $user->name }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ $user->email }}</p>
                            </div>
                        </div>
                        @empty
                        <p class="text-center text-gray-500 dark:text-gray-400 py-8 col-span-2">Belum ada user</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Recent Permits -->
            <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-amber-50/50 via-orange-50/50 to-amber-50/50 dark:from-gray-700/50 dark:via-gray-600/50 dark:to-gray-700/50">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                        <i class="bi bi-folder-check text-amber-600"></i>
                        Permohonan Terbaru di UPT Ini
                    </h3>
                </div>
                <div class="p-5">
                    <div class="space-y-3">
                        @forelse($recentPermits as $permit)
                        <div class="flex items-center gap-3 p-3 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                            <div class="w-10 h-10 bg-gradient-to-br from-amber-400 to-orange-500 rounded-lg flex items-center justify-center">
                                <i class="bi bi-ship text-white"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-semibold text-gray-900 dark:text-white text-sm truncate">{{ $permit->ship_type }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ $permit->user?->name ?? 'Unknown' }}</p>
                            </div>
                            <span class="px-3 py-1 {{ $permit->status_badge }} text-xs font-semibold rounded-full">
                                {{ ucfirst($permit->status) }}
                            </span>
                        </div>
                        @empty
                        <p class="text-center text-gray-500 dark:text-gray-400 py-8">Belum ada permohonan</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
