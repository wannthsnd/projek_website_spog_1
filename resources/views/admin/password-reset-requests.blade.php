@extends('layouts.app')
@section('title', 'Permintaan Reset Password')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header Section - Elegant with gradient -->
    <div class="mb-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-indigo-600 rounded-2xl flex items-center justify-center shadow-lg">
                    <i class="bi bi-key text-2xl text-white"></i>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-1">Permintaan Reset Password</h1>
                    <p class="text-gray-600 dark:text-gray-400 font-medium">Kelola dan verifikasi permintaan dari user</p>
                </div>
            </div>
            <a href="{{ route('admin.dashboard') }}"
               class="inline-flex items-center gap-2 px-5 py-2.5 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 rounded-xl font-semibold hover:bg-gray-50 dark:hover:bg-gray-700 transition-all shadow-sm hover:shadow-md border border-gray-200 dark:border-gray-700">
                <i class="bi bi-arrow-left"></i>
                <span>Kembali</span>
            </a>
        </div>
    </div>

    <!-- Stats Cards - Elegant gradient cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
        <!-- Total Requests -->
        <div class="group relative bg-gradient-to-br from-slate-50 via-white to-slate-100 dark:from-gray-800 dark:via-gray-700 dark:to-gray-800 rounded-2xl p-5 border border-gray-200 dark:border-gray-600 shadow-sm hover:shadow-md transition-all">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">Total Permintaan</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ number_format($requests->total()) }}</p>
                </div>
                <div class="w-12 h-12 bg-gradient-to-br from-slate-400 to-slate-600 rounded-xl flex items-center justify-center shadow-md">
                    <i class="bi bi-list-ul text-xl text-white"></i>
                </div>
            </div>
        </div>

        <!-- Pending -->
        <div class="group relative bg-gradient-to-br from-amber-50 via-white to-orange-50 dark:from-gray-800 dark:via-gray-700 dark:to-gray-800 rounded-2xl p-5 border border-amber-200 dark:border-gray-600 shadow-sm hover:shadow-md transition-all">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-amber-700 dark:text-amber-400 mb-1">Menunggu Verifikasi</p>
                    <p class="text-3xl font-bold text-amber-700 dark:text-amber-300">{{ number_format($pendingCount) }}</p>
                </div>
                <div class="w-12 h-12 bg-gradient-to-br from-amber-400 to-orange-500 rounded-xl flex items-center justify-center shadow-md">
                    <i class="bi bi-clock-history text-xl text-white"></i>
                </div>
            </div>
            @if($pendingCount > 0)
            <div class="absolute top-3 right-3 w-2 h-2 bg-amber-500 rounded-full animate-pulse"></div>
            @endif
        </div>

        <!-- Completed -->
        <div class="group relative bg-gradient-to-br from-emerald-50 via-white to-green-50 dark:from-gray-800 dark:via-gray-700 dark:to-gray-800 rounded-2xl p-5 border border-emerald-200 dark:border-gray-600 shadow-sm hover:shadow-md transition-all">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-emerald-700 dark:text-emerald-400 mb-1">Selesai</p>
                    <p class="text-3xl font-bold text-emerald-700 dark:text-emerald-300">{{ number_format($requests->where('status', 'completed')->count()) }}</p>
                </div>
                <div class="w-12 h-12 bg-gradient-to-br from-emerald-400 to-green-600 rounded-xl flex items-center justify-center shadow-md">
                    <i class="bi bi-check-circle text-xl text-white"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Flash Messages - Elegant styling -->
    @if(session('success'))
    <div class="mb-6 p-4 bg-gradient-to-r from-emerald-50 to-green-50 dark:from-emerald-900/20 dark:to-green-900/20 border border-emerald-200 dark:border-emerald-700 rounded-2xl flex items-start gap-3 shadow-sm">
        <div class="w-10 h-10 bg-emerald-100 dark:bg-emerald-900/40 rounded-xl flex items-center justify-center flex-shrink-0">
            <i class="bi bi-check-circle text-emerald-600 dark:text-emerald-400 text-lg"></i>
        </div>
        <div class="flex-1">
            <p class="text-sm font-semibold text-emerald-800 dark:text-emerald-300">{{ session('success') }}</p>
            @if(session('temporary_password'))
            <div class="mt-3 p-3 bg-white dark:bg-gray-800 rounded-xl border-2 border-dashed border-emerald-300 dark:border-emerald-600">
                <p class="text-xs font-medium text-emerald-700 dark:text-emerald-400 mb-2 flex items-center gap-1">
                    <i class="bi bi-key"></i>
                    Temporary Password (Berikan ke user):
                </p>
                <div class="flex items-center gap-2">
                    <code class="flex-1 text-lg font-mono font-bold text-emerald-700 dark:text-emerald-300 bg-emerald-50 dark:bg-emerald-900/30 px-3 py-2 rounded-lg">
                        {{ session('temporary_password') }}
                    </code>
                    <button onclick="navigator.clipboard.writeText('{{ session('temporary_password') }}')"
                            class="px-3 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-sm font-medium transition-colors">
                        <i class="bi bi-clipboard"></i>
                    </button>
                </div>
            </div>
            @endif
        </div>
    </div>
    @endif

    @if(session('error'))
    <div class="mb-6 p-4 bg-gradient-to-r from-red-50 to-rose-50 dark:from-red-900/20 dark:to-rose-900/20 border border-red-200 dark:border-red-700 rounded-2xl flex items-start gap-3 shadow-sm">
        <div class="w-10 h-10 bg-red-100 dark:bg-red-900/40 rounded-xl flex items-center justify-center flex-shrink-0">
            <i class="bi bi-exclamation-triangle text-red-600 dark:text-red-400 text-lg"></i>
        </div>
        <p class="text-sm font-semibold text-red-800 dark:text-red-300">{{ session('error') }}</p>
    </div>
    @endif

    <!-- Requests Table - Elegant card design -->
    <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
        <!-- Table Header -->
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-600">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                <i class="bi bi-table text-purple-600"></i>
                Daftar Permintaan
            </h3>
        </div>

        <!-- Table Content -->
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50 dark:bg-gray-700/50">
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Email & User</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Diajukan</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Kadaluarsa</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Verifikator</th>
                        <th class="px-6 py-4 text-right text-xs font-bold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($requests as $request)
                    <tr class="group hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-all {{ $request->isPending() ? 'bg-amber-50/40 dark:bg-amber-900/10 border-l-4 border-amber-400' : '' }}">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                @if($request->isPending())
                                <span class="w-2.5 h-2.5 bg-amber-500 rounded-full animate-pulse shadow-sm"></span>
                                @endif
                                <div class="min-w-0">
                                    <p class="font-semibold text-gray-900 dark:text-white truncate">{{ $request->email }}</p>
                                    @if($request->user)
                                    <p class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ $request->user->name }}</p>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @if($request->isPending())
                            <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-300 text-xs font-bold rounded-full border border-amber-200 dark:border-amber-700">
                                <span class="w-1.5 h-1.5 bg-amber-500 rounded-full animate-pulse"></span>
                                Pending
                            </span>
                            @elseif($request->isApproved())
                            <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300 text-xs font-bold rounded-full border border-emerald-200 dark:border-emerald-700">
                                Approved
                            </span>
                            @elseif($request->isCompleted())
                            <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 text-xs font-bold rounded-full border border-blue-200 dark:border-blue-700">
                                Completed
                            </span>
                            @else
                            <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 bg-rose-100 dark:bg-rose-900/30 text-rose-700 dark:text-rose-300 text-xs font-bold rounded-full border border-rose-200 dark:border-rose-700">
                                Rejected
                            </span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $request->created_at->format('d M Y') }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $request->created_at->format('H:i') }}</p>
                        </td>
                        <td class="px-6 py-4">
                            @if($request->isExpired())
                            <span class="inline-flex items-center px-2.5 py-1 bg-rose-100 dark:bg-rose-900/30 text-rose-700 dark:text-rose-300 text-xs font-bold rounded-full">
                                Expired
                            </span>
                            @else
                            <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $request->expires_at->format('d M Y') }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $request->expires_at->diffForHumans() }}</p>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $request->verified_by ?? '-' }}</p>
                        </td>
                        <td class="px-6 py-4 text-right">
                            @if($request->isPending() && !$request->isExpired())
                            <div class="flex items-center justify-end gap-2 opacity-100 group-hover:opacity-100 transition-opacity">
                                <button onclick="approveRequest({{ $request->id }})"
                                    class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-gradient-to-r from-emerald-500 to-green-600 text-white text-xs font-bold rounded-xl hover:from-emerald-600 hover:to-green-700 transition-all shadow-md hover:shadow-lg">
                                    <i class="bi bi-check-lg"></i>
                                    <span class="hidden sm:inline">Approve</span>
                                </button>
                                <button onclick="rejectRequest({{ $request->id }})"
                                    class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-gradient-to-r from-rose-500 to-red-600 text-white text-xs font-bold rounded-xl hover:from-rose-600 hover:to-red-700 transition-all shadow-md hover:shadow-lg">
                                    <i class="bi bi-x-lg"></i>
                                    <span class="hidden sm:inline">Reject</span>
                                </button>
                            </div>
                            @else
                            <span class="text-gray-400 dark:text-gray-500 text-xs">—</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center gap-4">
                                <div class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-2xl flex items-center justify-center">
                                    <i class="bi bi-inbox text-3xl text-gray-400 dark:text-gray-500"></i>
                                </div>
                                <div>
                                    <p class="text-lg font-semibold text-gray-900 dark:text-white mb-1">Tidak ada permintaan</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Semua permintaan sudah diproses</p>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination - Elegant styling -->
    @if($requests->hasPages())
    <div class="mt-6 flex justify-center">
        {{ $requests->links() }}
    </div>
    @endif
</div>

<!-- Approve Modal - Elegant design -->
<div id="approveModal" class="hidden fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-2xl max-w-md w-full overflow-hidden border border-gray-200 dark:border-gray-700">
        <!-- Modal Header -->
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-emerald-50 to-green-50 dark:from-emerald-900/20 dark:to-green-900/20">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-emerald-100 dark:bg-emerald-900/40 rounded-xl flex items-center justify-center">
                    <i class="bi bi-check-circle text-emerald-600 dark:text-emerald-400"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Approve Reset Password</h3>
            </div>
        </div>

        <!-- Modal Body -->
        <form id="approveForm" method="POST" class="p-6">
            @csrf
            <div class="mb-5">
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                    Catatan Admin <span class="text-gray-400 font-normal">(Opsional)</span>
                </label>
                <textarea name="notes"
                          class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 text-gray-900 dark:text-white font-medium placeholder-gray-400 resize-none transition-all"
                          rows="3"
                          placeholder="Contoh: Verifikasi via telepon dengan user..."></textarea>
            </div>

            <!-- Action Buttons -->
            <div class="flex gap-3">
                <button type="button" onclick="closeModal()"
                        class="flex-1 px-4 py-3 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-xl font-semibold hover:bg-gray-200 dark:hover:bg-gray-600 transition-all">
                    Batal
                </button>
                <button type="submit"
                        class="flex-1 px-4 py-3 bg-gradient-to-r from-emerald-500 to-green-600 text-white rounded-xl font-semibold shadow-md hover:shadow-lg hover:scale-105 transition-all flex items-center justify-center gap-2">
                    <i class="bi bi-check-circle"></i>
                    <span>Approve</span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Reject Modal - Elegant design -->
<div id="rejectModal" class="hidden fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-2xl max-w-md w-full overflow-hidden border border-gray-200 dark:border-gray-700">
        <!-- Modal Header -->
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-rose-50 to-red-50 dark:from-rose-900/20 dark:to-red-900/20">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-rose-100 dark:bg-rose-900/40 rounded-xl flex items-center justify-center">
                    <i class="bi bi-x-circle text-rose-600 dark:text-rose-400"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Reject Reset Password</h3>
            </div>
        </div>

        <!-- Modal Body -->
        <form id="rejectForm" method="POST" class="p-6">
            @csrf
            <div class="mb-5">
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                    Alasan Penolakan <span class="text-gray-400 font-normal">(Wajib)</span>
                </label>
                <textarea name="notes"
                          class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl focus:outline-none focus:border-rose-500 focus:ring-2 focus:ring-rose-500/20 text-gray-900 dark:text-white font-medium placeholder-gray-400 resize-none transition-all"
                          rows="3"
                          placeholder="Contoh: Data tidak sesuai dengan registrasi..."
                          required></textarea>
            </div>

            <!-- Action Buttons -->
            <div class="flex gap-3">
                <button type="button" onclick="closeModal()"
                        class="flex-1 px-4 py-3 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-xl font-semibold hover:bg-gray-200 dark:hover:bg-gray-600 transition-all">
                    Batal
                </button>
                <button type="submit"
                        class="flex-1 px-4 py-3 bg-gradient-to-r from-rose-500 to-red-600 text-white rounded-xl font-semibold shadow-md hover:shadow-lg hover:scale-105 transition-all flex items-center justify-center gap-2">
                    <i class="bi bi-x-circle"></i>
                    <span>Reject</span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- JavaScript - Keep functionality intact -->
<script>
function approveRequest(id) {
    document.getElementById('approveForm').action = '/admin/password-reset-requests/' + id + '/approve';
    document.getElementById('approveModal').classList.remove('hidden');
    // Prevent body scroll when modal is open
    document.body.style.overflow = 'hidden';
}

function rejectRequest(id) {
    document.getElementById('rejectForm').action = '/admin/password-reset-requests/' + id + '/reject';
    document.getElementById('rejectModal').classList.remove('hidden');
    // Prevent body scroll when modal is open
    document.body.style.overflow = 'hidden';
}

function closeModal() {
    document.getElementById('approveModal').classList.add('hidden');
    document.getElementById('rejectModal').classList.add('hidden');
    // Restore body scroll
    document.body.style.overflow = '';
}

// Close modal when clicking outside
document.querySelectorAll('#approveModal, #rejectModal').forEach(modal => {
    modal.addEventListener('click', function(e) {
        if (e.target === this) {
            closeModal();
        }
    });
});

// Close modal with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeModal();
    }
});
</script>
@endsection
