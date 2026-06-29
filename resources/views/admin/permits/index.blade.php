@extends('layouts.app')
@section('title', 'Kelola Permohonan')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header Section - Elegant with gradient background -->
    <div class="mb-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="relative">
                    <div class="absolute inset-0 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl blur-lg opacity-50"></div>
                    <div class="relative w-14 h-14 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl flex items-center justify-center shadow-lg">
                        <i class="bi bi-folder-check text-2xl text-white"></i>
                    </div>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-1">Kelola Permohonan</h1>
                    <p class="text-gray-600 dark:text-gray-400 font-medium">Manajemen semua permohonan SPOG dalam satu tempat</p>
                </div>
            </div>
            <a href="{{ route('admin.dashboard') }}"
               class="inline-flex items-center gap-2 px-5 py-2.5 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 rounded-xl font-semibold hover:bg-gray-50 dark:hover:bg-gray-700 transition-all shadow-sm hover:shadow-md border border-gray-200 dark:border-gray-700">
                <i class="bi bi-arrow-left"></i>
                <span>Kembali</span>
            </a>
        </div>
    </div>

    <!-- Stats Summary - Elegant gradient cards with icons -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <!-- Total -->
        <div class="group relative bg-gradient-to-br from-slate-50 via-white to-slate-100 dark:from-gray-800 dark:via-gray-700 dark:to-gray-800 rounded-2xl p-5 border border-gray-200 dark:border-gray-600 shadow-sm hover:shadow-md transition-all">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">Total Permohonan</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ number_format($permits->total()) }}</p>
                </div>
                <div class="w-12 h-12 bg-gradient-to-br from-slate-400 to-slate-600 rounded-xl flex items-center justify-center shadow-md group-hover:scale-110 transition-transform">
                    <i class="bi bi-list-ul text-xl text-white"></i>
                </div>
            </div>
        </div>

        <!-- Pending -->
        <div class="group relative bg-gradient-to-br from-amber-50 via-white to-orange-50 dark:from-gray-800 dark:via-gray-700 dark:to-gray-800 rounded-2xl p-5 border border-amber-200 dark:border-gray-600 shadow-sm hover:shadow-md transition-all">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-amber-700 dark:text-amber-400 mb-1">Menunggu</p>
                    <p class="text-3xl font-bold text-amber-700 dark:text-amber-300">{{ number_format($permits->where('status', 'pending')->count()) }}</p>
                </div>
                <div class="w-12 h-12 bg-gradient-to-br from-amber-400 to-orange-500 rounded-xl flex items-center justify-center shadow-md group-hover:scale-110 transition-transform">
                    <i class="bi bi-clock-history text-xl text-white"></i>
                </div>
            </div>
            @if($permits->where('status', 'pending')->count() > 0)
            <div class="absolute top-3 right-3 w-2.5 h-2.5 bg-amber-500 rounded-full animate-pulse shadow-sm"></div>
            @endif
        </div>

        <!-- Approved -->
        <div class="group relative bg-gradient-to-br from-emerald-50 via-white to-green-50 dark:from-gray-800 dark:via-gray-700 dark:to-gray-800 rounded-2xl p-5 border border-emerald-200 dark:border-gray-600 shadow-sm hover:shadow-md transition-all">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-emerald-700 dark:text-emerald-400 mb-1">Disetujui</p>
                    <p class="text-3xl font-bold text-emerald-700 dark:text-emerald-300">{{ number_format($permits->where('status', 'approved')->count()) }}</p>
                </div>
                <div class="w-12 h-12 bg-gradient-to-br from-emerald-400 to-green-600 rounded-xl flex items-center justify-center shadow-md group-hover:scale-110 transition-transform">
                    <i class="bi bi-check-circle text-xl text-white"></i>
                </div>
            </div>
        </div>

        <!-- Rejected -->
        <div class="group relative bg-gradient-to-br from-rose-50 via-white to-red-50 dark:from-gray-800 dark:via-gray-700 dark:to-gray-800 rounded-2xl p-5 border border-rose-200 dark:border-gray-600 shadow-sm hover:shadow-md transition-all">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-rose-700 dark:text-rose-400 mb-1">Ditolak</p>
                    <p class="text-3xl font-bold text-rose-700 dark:text-rose-300">{{ number_format($permits->where('status', 'rejected')->count()) }}</p>
                </div>
                <div class="w-12 h-12 bg-gradient-to-br from-rose-400 to-red-600 rounded-xl flex items-center justify-center shadow-md group-hover:scale-110 transition-transform">
                    <i class="bi bi-x-circle text-xl text-white"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Table Section - Modern card design -->
    <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
        <!-- Table Header -->
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-600">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                    <i class="bi bi-table text-indigo-600"></i>
                    Daftar Permohonan
                </h3>
                <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                    <i class="bi bi-info-circle"></i>
                    <span>Menampilkan {{ $permits->count() }} dari {{ $permits->total() }} data</span>
                </div>
            </div>
        </div>

        <!-- Table Content -->
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr class="bg-gray-50 dark:bg-gray-700/50">
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 dark:text-gray-400 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Kapal</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Pemohon</th>
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
                            <div class="flex items-center gap-3">
                                <div class="relative">
                                    <div class="absolute inset-0 bg-gradient-to-br from-indigo-400 to-purple-500 rounded-lg blur-sm opacity-50"></div>
                                    <div class="relative w-10 h-10 bg-gradient-to-br from-indigo-400 to-purple-500 rounded-lg flex items-center justify-center shadow-sm">
                                        <i class="bi bi-ship text-white"></i>
                                    </div>
                                </div>
                                <div class="min-w-0">
                                    <p class="font-semibold text-gray-900 dark:text-white truncate">{{ $permit->ship_type }}</p>
                                    @if($permit->ship_name)
                                    <p class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ $permit->ship_name }}</p>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="min-w-0">
                                <p class="font-medium text-gray-900 dark:text-white truncate">{{ $permit->name }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ Str::limit($permit->email, 20) }}</p>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex flex-col">
                                <span class="text-sm font-medium text-gray-900 dark:text-white">
                                            {{ $permit->application_date ? $permit->application_date->format('d M Y') : '-' }}
                                        </span>
                                <span class="text-xs text-gray-500 dark:text-gray-400">{{ $permit->application_date->format('H:i') }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-xs font-bold border transition-all
                                {{ $permit->status === 'pending' ? 'bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-300 border-amber-200 dark:border-amber-700' : '' }}
                                {{ $permit->status === 'approved' ? 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300 border-emerald-200 dark:border-emerald-700' : '' }}
                                {{ $permit->status === 'rejected' ? 'bg-rose-100 dark:bg-rose-900/30 text-rose-700 dark:text-rose-300 border-rose-200 dark:border-rose-700' : '' }}">
                                @if($permit->status === 'pending')
                                <span class="w-1.5 h-1.5 bg-amber-500 rounded-full animate-pulse"></span>
                                @endif
                                {{ ucfirst($permit->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-1.5">
                                <!-- View Button -->
                                <a href="{{ route('admin.permits.show', $permit->id) }}"
                                   class="inline-flex items-center justify-center w-9 h-9 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-xl hover:bg-blue-200 dark:hover:bg-blue-900/50 transition-all shadow-sm hover:shadow-md group/btn"
                                   title="Lihat Detail">
                                    <i class="bi bi-eye text-sm group-hover/btn:scale-110 transition-transform"></i>
                                </a>

                                <!-- Edit Button -->
                                <a href="{{ route('admin.permits.edit', $permit->id) }}"
                                   class="inline-flex items-center justify-center w-9 h-9 bg-amber-100 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400 rounded-xl hover:bg-amber-200 dark:hover:bg-amber-900/50 transition-all shadow-sm hover:shadow-md group/btn"
                                   title="Edit Data">
                                    <i class="bi bi-pencil text-sm group-hover/btn:scale-110 transition-transform"></i>
                                </a>

                                <!-- Delete Button -->
                                <button onclick="confirmDelete({{ $permit->id }}, '{{ addslashes($permit->ship_type) }}')"
                                   class="inline-flex items-center justify-center w-9 h-9 bg-rose-100 dark:bg-rose-900/30 text-rose-600 dark:text-rose-400 rounded-xl hover:bg-rose-200 dark:hover:bg-rose-900/50 transition-all shadow-sm hover:shadow-md group/btn"
                                   title="Hapus Data">
                                    <i class="bi bi-trash text-sm group-hover/btn:scale-110 transition-transform"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center gap-4">
                                <div class="relative">
                                    <div class="absolute inset-0 bg-gradient-to-br from-indigo-400 to-purple-500 rounded-3xl blur-2xl opacity-30"></div>
                                    <div class="relative w-20 h-20 bg-gradient-to-br from-indigo-400 to-purple-500 rounded-3xl flex items-center justify-center shadow-lg">
                                        <i class="bi bi-inbox text-3xl text-white"></i>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <p class="text-lg font-semibold text-gray-900 dark:text-white mb-1">Belum ada permohonan</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Data permohonan akan muncul disini setelah user mengajukan</p>
                                </div>
                                <a href="{{ route('admin.dashboard') }}"
                                   class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-indigo-500 to-purple-600 text-white rounded-xl font-semibold hover:shadow-lg transition-all">
                                    <i class="bi bi-arrow-left"></i>
                                    <span>Kembali ke Dashboard</span>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination - Elegant styling -->
        @if($permits->hasPages())
        <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    Halaman {{ $permits->currentPage() }} dari {{ $permits->lastPage() }}
                </p>
                <div class="flex justify-center sm:justify-end">
                    {{ $permits->links() }}
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Delete Confirmation Modal - Elegant with backdrop blur -->
<div id="deleteModal" x-data="{ show: false, permitId: null, permitName: '' }"
     x-show="show" x-cloak
     class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay with blur -->
        <div x-show="show"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 transition-opacity bg-gray-900/75 backdrop-blur-sm"
             @click="show = false"></div>

        <!-- Modal panel with elegant design -->
        <div x-show="show"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             class="inline-block w-full max-w-md p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white dark:bg-gray-800 shadow-2xl rounded-3xl border border-gray-200 dark:border-gray-700">

            <!-- Modal Header -->
            <div class="flex items-center gap-4 mb-5 pb-4 border-b border-gray-200 dark:border-gray-700">
                <div class="relative">
                    <div class="absolute inset-0 bg-rose-500 rounded-full blur-lg opacity-30"></div>
                    <div class="relative w-12 h-12 bg-gradient-to-br from-rose-500 to-red-600 rounded-full flex items-center justify-center shadow-lg">
                        <i class="bi bi-exclamation-triangle text-xl text-white"></i>
                    </div>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Hapus Data?</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Tindakan ini tidak dapat dibatalkan</p>
                </div>
            </div>

            <!-- Warning Content -->
            <div class="bg-gradient-to-r from-rose-50 to-red-50 dark:from-rose-900/20 dark:to-red-900/20 rounded-2xl p-4 mb-6 border border-rose-200 dark:border-rose-700">
                <p class="text-sm text-rose-800 dark:text-rose-300">
                    Anda akan menghapus data permohonan untuk kapal:
                    <br>
                    <strong class="text-lg font-mono text-rose-900 dark:text-rose-200" x-text="permitName"></strong>
                </p>
            </div>

            <!-- Action Buttons -->
            <div class="flex gap-3">
                <button @click="show = false"
                        class="flex-1 px-4 py-3 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-xl font-semibold hover:bg-gray-200 dark:hover:bg-gray-600 transition-all">
                    Batal
                </button>
                <form :action="'/admin/permits/' + permitId" method="POST" class="flex-1">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="w-full px-4 py-3 bg-gradient-to-r from-rose-500 to-red-600 text-white rounded-xl font-semibold shadow-md hover:shadow-lg hover:scale-105 transition-all flex items-center justify-center gap-2">
                        <i class="bi bi-trash"></i>
                        <span>Ya, Hapus</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function confirmDelete(id, name) {
    const modal = document.getElementById('deleteModal');
    const alpineComponent = Alpine.$data(modal);
    alpineComponent.permitId = id;
    alpineComponent.permitName = name;
    alpineComponent.show = true;

    // Prevent body scroll when modal is open
    document.body.style.overflow = 'hidden';
}

// Close modal and restore scroll
document.addEventListener('alpine:initialized', () => {
    Alpine.magic('closeModal', () => {
        return () => {
            document.body.style.overflow = '';
        };
    });
});

// Restore scroll when modal closes via Alpine
document.addEventListener('click', (e) => {
    if (e.target.closest('#deleteModal') && !e.target.closest('.bg-white')) {
        document.body.style.overflow = '';
    }
});
</script>
@endpush
