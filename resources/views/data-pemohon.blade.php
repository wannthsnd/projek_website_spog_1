@extends('layouts.app')
@section('title', 'Data Pemohon')

@push('styles')
<style>
    .filter-active {
        background: linear-gradient(135deg, #FCD34D, #F59E0B);
        color: white;
    }
    .table-row-hover:hover {
        transform: scale(1.01);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
</style>
@endpush

@section('content')
<!-- Header -->
<div class="mb-8">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h1 class="text-4xl font-bold text-gray-800 dark:text-white mb-2 flex items-center gap-3">
                <div class="w-12 h-12 gradient-primary rounded-2xl flex items-center justify-center">
                    <i class="bi bi-people text-2xl text-white"></i>
                </div>
                Data Pemohon
            </h1>
            <p class="text-gray-600 dark:text-gray-400 text-lg">Daftar semua permohonan Surat Perizinan Berlayar</p>
        </div>
        <a href="{{ route('permohonan.create') }}"
           class="btn-shine gradient-primary text-white px-6 py-3 rounded-xl font-bold shadow-lg hover:shadow-xl hover:scale-105 transition-all flex items-center gap-2">
            <i class="bi bi-plus-circle text-xl"></i>
            <span>Tambah Data</span>
        </a>
    </div>
</div>

<!-- Filters & Search -->
<div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-6 mb-8 border border-gray-100 dark:border-gray-700">
    <div class="flex flex-col md:flex-row gap-4">
        <div class="flex-1 relative">
            <i class="bi bi-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-xl"></i>
            <input type="text" id="searchInput"
                class="w-full pl-12 pr-4 py-3 bg-gray-50 dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:outline-none focus:border-primary-500 transition-all text-gray-800 dark:text-white"
                placeholder="Cari nama kapal, email, atau pemohon...">
        </div>
        <div class="flex gap-2 flex-wrap">
            <button onclick="filterStatus('')" class="filter-btn px-6 py-3 rounded-xl font-semibold transition-all filter-active" data-status="">
                Semua
            </button>
            <button onclick="filterStatus('pending')" class="filter-btn px-6 py-3 rounded-xl font-semibold transition-all bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-400" data-status="pending">
                <i class="bi bi-clock mr-2"></i>Pending
            </button>
            <button onclick="filterStatus('approved')" class="filter-btn px-6 py-3 rounded-xl font-semibold transition-all bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400" data-status="approved">
                <i class="bi bi-check-circle mr-2"></i>Approved
            </button>
            <button onclick="filterStatus('rejected')" class="filter-btn px-6 py-3 rounded-xl font-semibold transition-all bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400" data-status="rejected">
                <i class="bi bi-x-circle mr-2"></i>Rejected
            </button>
        </div>
    </div>
</div>

<!-- Table -->
<div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-700 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead class="gradient-dark">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">No</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Kapal</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Pemohon</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Email</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Tanggal</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Status</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($data as $index => $permit)
                <tr class="table-row-hover transition-all bg-white dark:bg-gray-800" data-status="{{ $permit->status }}">
                    <td class="px-6 py-4 text-sm font-semibold text-gray-800 dark:text-white">{{ $data->firstItem() + $index }}</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 gradient-primary rounded-lg flex items-center justify-center">
                                <i class="bi bi-ship text-white"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-800 dark:text-white">{{ $permit->ship_type }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $permit->departure_location }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center text-sm font-bold text-gray-600 dark:text-gray-400">
                                {{ substr($permit->name, 0, 1) }}
                            </div>
                            <span class="text-gray-800 dark:text-white font-medium">{{ $permit->name }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">{{ $permit->email }}</td>
                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">{{ $permit->application_date->format('d M Y') }}</td>
                    <td class="px-6 py-4">
                        <span class="px-4 py-2 rounded-full text-xs font-bold {{ $permit->status_badge }}">
                            {{ ucfirst($permit->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex gap-2">
                            <a href="{{ route('permohonan.detail', $permit->id) }}"
                               class="p-2 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-lg hover:bg-blue-200 dark:hover:bg-blue-900/50 transition-colors"
                               title="Lihat Detail">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('permohonan.download', [$permit->id, 1]) }}"
                               class="p-2 bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400 rounded-lg hover:bg-green-200 dark:hover:bg-green-900/50 transition-colors"
                               title="Download">
                                <i class="bi bi-download"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-12 text-center">
                        <div class="w-20 h-20 mx-auto mb-4 gradient-primary rounded-full flex items-center justify-center floating">
                            <i class="bi bi-inbox text-3xl text-white"></i>
                        </div>
                        <p class="text-gray-500 dark:text-gray-400 text-lg">Belum ada data permohonan</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($data->hasPages())
    <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
        {{ $data->links() }}
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
function filterStatus(status) {
    // Update button styles
    document.querySelectorAll('.filter-btn').forEach(btn => {
        if (btn.dataset.status === status) {
            btn.classList.add('filter-active');
            btn.classList.remove('bg-yellow-100', 'bg-green-100', 'bg-red-100');
        } else {
            btn.classList.remove('filter-active');
            if (btn.dataset.status === 'pending') {
                btn.classList.add('bg-yellow-100');
            } else if (btn.dataset.status === 'approved') {
                btn.classList.add('bg-green-100');
            } else if (btn.dataset.status === 'rejected') {
                btn.classList.add('bg-red-100');
            }
        }
    });

    // Filter rows
    document.querySelectorAll('tbody tr[data-status]').forEach(row => {
        if (!status || row.dataset.status === status) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}

// Search functionality
document.getElementById('searchInput').addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    document.querySelectorAll('tbody tr[data-status]').forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(searchTerm) ? '' : 'none';
    });
});
</script>
@endpush
