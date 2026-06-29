@extends('layouts.app')
@section('title', 'Data Pemohon - Admin')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header Section -->
    <div class="mb-8">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white mb-1">
                    👥 Data Pemohon
                </h1>
                <p class="text-gray-600 dark:text-gray-400 font-medium">
                    Daftar lengkap semua pemohon SPOG yang terdaftar dalam sistem
                </p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.dashboard') }}"
                   class="px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-xl font-medium text-sm hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors flex items-center gap-2">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
                <a href="{{ route('admin.permits.index') }}"
                   class="px-4 py-2 bg-gradient-to-r from-primary-400 to-primary-600 text-white rounded-xl font-bold text-sm shadow-lg hover:shadow-xl transition-all flex items-center gap-2">
                    <i class="bi bi-folder"></i> Kelola Permohonan
                </a>
            </div>
        </div>
    </div>

    <!-- Search & Filter Bar -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-4 mb-6">
        <div class="flex flex-col md:flex-row gap-4 items-center justify-between">
            <!-- Search -->
            <div class="relative w-full md:w-96">
                <i class="bi bi-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                <input type="text"
                       placeholder="Cari nama pemohon, email, atau nama kapal..."
                       class="w-full pl-12 pr-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 transition-all text-gray-900 dark:text-white font-medium"
                       id="searchInput">
            </div>

            <!-- Filters -->
            <div class="flex items-center gap-3 w-full md:w-auto">
                <select id="statusFilter" class="px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:outline-none focus:border-primary-500 text-gray-900 dark:text-white font-medium text-sm">
                    <option value="">Semua Status</option>
                    <option value="pending">⏳ Pending</option>
                    <option value="approved">✅ Approved</option>
                    <option value="rejected">❌ Rejected</option>
                </select>

                <select id="shipTypeFilter" class="px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:outline-none focus:border-primary-500 text-gray-900 dark:text-white font-medium text-sm">
                    <option value="">Semua Jenis Kapal</option>
                    <option value="Kapal Penumpang">Kapal Penumpang</option>
                    <option value="Kapal Barang">Kapal Barang</option>
                    <option value="Kapal Nelayan">Kapal Nelayan</option>
                    <option value="Kapal Wisata">Kapal Wisata</option>
                </select>

                <button onclick="clearFilters()" class="px-4 py-3 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-xl font-medium text-sm hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors" title="Reset Filter">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Stats Summary Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <div class="group relative bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-700 rounded-2xl p-5 shadow-lg hover:shadow-xl transition-all border border-gray-200 dark:border-gray-600 hover:scale-[1.02]">
            <div class="absolute top-0 right-0 w-20 h-20 bg-primary-400/10 rounded-full blur-xl group-hover:bg-primary-400/20 transition-colors"></div>
            <div class="relative z-10">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-10 h-10 bg-gradient-to-br from-primary-400 to-primary-600 rounded-lg flex items-center justify-center shadow-md">
                        <i class="bi bi-people text-white text-lg"></i>
                    </div>
                    <span class="text-xs font-bold text-gray-600 dark:text-gray-400">Total</span>
                </div>
                <p class="text-3xl font-extrabold text-gray-900 dark:text-white">{{ number_format($data->total()) }}</p>
                <p class="text-xs text-gray-600 dark:text-gray-400 font-medium mt-1">Total Pemohon</p>
            </div>
        </div>

        <div class="group relative bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-700 rounded-2xl p-5 shadow-lg hover:shadow-xl transition-all border border-gray-200 dark:border-gray-600 hover:scale-[1.02]">
            <div class="absolute top-0 right-0 w-20 h-20 bg-yellow-400/10 rounded-full blur-xl group-hover:bg-yellow-400/20 transition-colors"></div>
            <div class="relative z-10">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-10 h-10 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-lg flex items-center justify-center shadow-md">
                        <i class="bi bi-clock-history text-white text-lg"></i>
                    </div>
                    <span class="text-xs font-bold text-yellow-600 dark:text-yellow-400">Pending</span>
                </div>
                <p class="text-3xl font-extrabold text-gray-900 dark:text-white">{{ number_format($data->where('status', 'pending')->count()) }}</p>
                <p class="text-xs text-gray-600 dark:text-gray-400 font-medium mt-1">Menunggu Review</p>
            </div>
        </div>

        <div class="group relative bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-700 rounded-2xl p-5 shadow-lg hover:shadow-xl transition-all border border-gray-200 dark:border-gray-600 hover:scale-[1.02]">
            <div class="absolute top-0 right-0 w-20 h-20 bg-green-400/10 rounded-full blur-xl group-hover:bg-green-400/20 transition-colors"></div>
            <div class="relative z-10">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-10 h-10 bg-gradient-to-br from-green-400 to-emerald-600 rounded-lg flex items-center justify-center shadow-md">
                        <i class="bi bi-check-circle text-white text-lg"></i>
                    </div>
                    <span class="text-xs font-bold text-green-600 dark:text-green-400">Approved</span>
                </div>
                <p class="text-3xl font-extrabold text-gray-900 dark:text-white">{{ number_format($data->where('status', 'approved')->count()) }}</p>
                <p class="text-xs text-gray-600 dark:text-gray-400 font-medium mt-1">Telah Disetujui</p>
            </div>
        </div>

        <div class="group relative bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-700 rounded-2xl p-5 shadow-lg hover:shadow-xl transition-all border border-gray-200 dark:border-gray-600 hover:scale-[1.02]">
            <div class="absolute top-0 right-0 w-20 h-20 bg-red-400/10 rounded-full blur-xl group-hover:bg-red-400/20 transition-colors"></div>
            <div class="relative z-10">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-10 h-10 bg-gradient-to-br from-red-400 to-rose-600 rounded-lg flex items-center justify-center shadow-md">
                        <i class="bi bi-x-circle text-white text-lg"></i>
                    </div>
                    <span class="text-xs font-bold text-red-600 dark:text-red-400">Rejected</span>
                </div>
                <p class="text-3xl font-extrabold text-gray-900 dark:text-white">{{ number_format($data->where('status', 'rejected')->count()) }}</p>
                <p class="text-xs text-gray-600 dark:text-gray-400 font-medium mt-1">Ditolak</p>
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
        <!-- Table Header -->
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-purple-50 to-purple-100 dark:from-gray-700 dark:to-gray-600">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-extrabold text-gray-900 dark:text-white flex items-center gap-2">
                    <i class="bi bi-people text-purple-600"></i>
                    Daftar Pemohon
                </h3>
                <span class="text-sm text-gray-600 dark:text-gray-400 font-medium">
                    Menampilkan {{ $data->firstItem() ?? 0 }} - {{ $data->lastItem() ?? 0 }} dari {{ $data->total() }}
                </span>
            </div>
        </div>

        <!-- Table Content -->
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 dark:bg-gray-700/50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Pemohon</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Kapal</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Penumpang</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-right text-xs font-bold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700" id="pemohonTable">
                    @forelse($data as $permit)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors group" data-status="{{ $permit->status }}" data-ship-type="{{ $permit->ship_type }}">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-11 h-11 bg-gradient-to-br from-primary-400 to-primary-600 rounded-xl flex items-center justify-center text-white font-bold text-base shadow-md">
                                    {{ substr($permit->name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="font-bold text-gray-900 dark:text-white text-sm">{{ $permit->name }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ Str::limit($permit->captain_name, 20) }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                                    <i class="bi bi-ship text-blue-600 dark:text-blue-400 text-sm"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $permit->ship_name ?? $permit->ship_type }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $permit->ship_type }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <i class="bi bi-envelope text-gray-400 text-xs"></i>
                                <span class="text-sm text-gray-700 dark:text-gray-300 font-medium">{{ Str::limit($permit->email, 25) }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <i class="bi bi-people text-gray-400 text-xs"></i>
                                <span class="text-sm font-medium text-gray-900 dark:text-white">{{ number_format($permit->passenger_count) }}</span>
                                <span class="text-xs text-gray-500 dark:text-gray-400">orang</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $permit->application_date->format('d M Y') }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $permit->application_date->diffForHumans() }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold {{ $permit->status_badge }}">
                                @if($permit->status === 'pending')
                                    <i class="bi bi-clock mr-1"></i>
                                @elseif($permit->status === 'approved')
                                    <i class="bi bi-check-circle mr-1"></i>
                                @else
                                    <i class="bi bi-x-circle mr-1"></i>
                                @endif
                                {{ ucfirst($permit->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                <a href="{{ route('admin.permits.show', $permit->id) }}"
                                   class="p-2 text-gray-500 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-lg transition-colors" title="Lihat Detail">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('admin.permits.edit', $permit->id) }}"
                                   class="p-2 text-gray-500 hover:text-yellow-600 dark:text-gray-400 dark:hover:text-yellow-400 hover:bg-yellow-50 dark:hover:bg-yellow-900/20 rounded-lg transition-colors" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.permits.destroy', $permit->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus data ini? Tindakan ini tidak dapat dibatalkan.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-gray-500 hover:text-red-600 dark:text-gray-400 dark:hover:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-16 text-center">
                            <div class="w-20 h-20 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="bi bi-people text-3xl text-gray-400"></i>
                            </div>
                            <p class="text-gray-600 dark:text-gray-400 font-medium mb-2">Belum ada data pemohon</p>
                            <p class="text-sm text-gray-500 dark:text-gray-500">Data pemohon yang terdaftar akan muncul di sini</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($data->hasPages())
        <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50">
            <div class="flex items-center justify-between">
                <p class="text-sm text-gray-600 dark:text-gray-400 font-medium">
                    Halaman {{ $data->currentPage() }} dari {{ $data->lastPage() }}
                </p>
                <div class="flex items-center gap-2">
                    @if($data->onFirstPage())
                        <span class="px-4 py-2 text-gray-400 dark:text-gray-500 rounded-lg bg-gray-100 dark:bg-gray-700 cursor-not-allowed">
                            <i class="bi bi-chevron-left"></i>
                        </span>
                    @else
                        <a href="{{ $data->previousPageUrl() }}" class="px-4 py-2 text-gray-700 dark:text-gray-300 rounded-lg bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors font-medium">
                            <i class="bi bi-chevron-left"></i>
                        </a>
                    @endif

                    @foreach($data->getUrlRange(1, $data->lastPage()) as $page => $url)
                        @if($page == $data->currentPage())
                            <span class="px-4 py-2 text-white rounded-lg bg-gradient-to-r from-primary-400 to-primary-600 font-bold shadow-md">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $url }}" class="px-4 py-2 text-gray-700 dark:text-gray-300 rounded-lg bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors font-medium">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach

                    @if($data->hasMorePages())
                        <a href="{{ $data->nextPageUrl() }}" class="px-4 py-2 text-gray-700 dark:text-gray-300 rounded-lg bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors font-medium">
                            <i class="bi bi-chevron-right"></i>
                        </a>
                    @else
                        <span class="px-4 py-2 text-gray-400 dark:text-gray-500 rounded-lg bg-gray-100 dark:bg-gray-700 cursor-not-allowed">
                            <i class="bi bi-chevron-right"></i>
                        </span>
                    @endif
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Quick Stats Info -->
    <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 rounded-2xl p-5 border border-blue-200 dark:border-blue-700">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center">
                    <i class="bi bi-graph-up text-white text-lg"></i>
                </div>
                <h4 class="font-bold text-blue-900 dark:text-blue-300">Statistik Bulan Ini</h4>
            </div>
            <p class="text-2xl font-extrabold text-blue-900 dark:text-blue-200">{{ $data->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])->count() }}</p>
            <p class="text-xs text-blue-700 dark:text-blue-400 font-medium mt-1">Permohonan baru bulan ini</p>
        </div>

        <div class="bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-800/20 rounded-2xl p-5 border border-green-200 dark:border-green-700">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center">
                    <i class="bi bi-percent text-white text-lg"></i>
                </div>
                <h4 class="font-bold text-green-900 dark:text-green-300">Tingkat Persetujuan</h4>
            </div>
            @php
            $total = $data->total() ?: 1;
            $approvedRate = round(($data->where('status', 'approved')->count() / $total) * 100);
            @endphp
            <p class="text-2xl font-extrabold text-green-900 dark:text-green-200">{{ $approvedRate }}%</p>
            <p class="text-xs text-green-700 dark:text-green-400 font-medium mt-1">Dari total permohonan</p>
        </div>

        <div class="bg-gradient-to-br from-purple-50 to-purple-100 dark:from-purple-900/20 dark:to-purple-800/20 rounded-2xl p-5 border border-purple-200 dark:border-purple-700">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-10 h-10 bg-purple-500 rounded-lg flex items-center justify-center">
                    <i class="bi bi-ship text-white text-lg"></i>
                </div>
                <h4 class="font-bold text-purple-900 dark:text-purple-300">Jenis Kapal Terbanyak</h4>
            </div>
            @php
            $topShipType = $data->groupBy('ship_type')->sortByDesc(fn($group) => $group->count())->keys()->first() ?? '-';
            @endphp
            <p class="text-lg font-extrabold text-purple-900 dark:text-purple-200">{{ $topShipType }}</p>
            <p class="text-xs text-purple-700 dark:text-purple-400 font-medium mt-1">Paling banyak diajukan</p>
        </div>
    </div>
</div>

<!-- Search & Filter Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const statusFilter = document.getElementById('statusFilter');
    const shipTypeFilter = document.getElementById('shipTypeFilter');
    const tableRows = document.querySelectorAll('#pemohonTable tr[data-status]');

    function filterTable() {
        const searchTerm = searchInput.value.toLowerCase();
        const statusValue = statusFilter.value;
        const shipTypeValue = shipTypeFilter.value;

        tableRows.forEach(row => {
            const pemohon = row.querySelector('td:nth-child(1)')?.textContent.toLowerCase() || '';
            const kapal = row.querySelector('td:nth-child(2)')?.textContent.toLowerCase() || '';
            const email = row.querySelector('td:nth-child(3)')?.textContent.toLowerCase() || '';
            const status = row.dataset.status;
            const shipType = row.dataset.shipType;

            const matchesSearch = pemohon.includes(searchTerm) || kapal.includes(searchTerm) || email.includes(searchTerm);
            const matchesStatus = !statusValue || status === statusValue;
            const matchesShipType = !shipTypeValue || shipType === shipTypeValue;

            row.style.display = (matchesSearch && matchesStatus && matchesShipType) ? '' : 'none';
        });
    }

    searchInput?.addEventListener('input', filterTable);
    statusFilter?.addEventListener('change', filterTable);
    shipTypeFilter?.addEventListener('change', filterTable);
});

function clearFilters() {
    document.getElementById('searchInput').value = '';
    document.getElementById('statusFilter').value = '';
    document.getElementById('shipTypeFilter').value = '';

    // Reset all rows
    document.querySelectorAll('#pemohonTable tr[data-status]').forEach(row => {
        row.style.display = '';
    });
}
</script>
@endsection
