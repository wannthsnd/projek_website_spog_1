@extends('layouts.app')
@section('title', 'Notifikasi')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Header -->
    <div class="mb-8 flex items-center justify-between">
        <div class="flex items-center gap-4">
            <a href="{{ route('dashboard') }}"
               class="w-12 h-12 bg-gray-200 dark:bg-gray-700 rounded-xl flex items-center justify-center hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors">
                <i class="bi bi-arrow-left text-xl text-gray-900 dark:text-white"></i>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-1">Notifikasi</h1>
                <p class="text-gray-700 dark:text-gray-300 font-bold">Pemberitahuan terbaru untuk Anda</p>
            </div>
        </div>

        @if(Auth::user()->unreadNotifications->count() > 0)
        <form action="{{ route('notifications.mark-all-read') }}" method="POST">
            @csrf
            <button type="submit"
                    class="px-4 py-2 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 rounded-xl font-bold hover:bg-blue-200 dark:hover:bg-blue-900/50 transition-colors text-sm border border-blue-200 dark:border-blue-700">
                <i class="bi bi-check-all mr-1"></i>Tandai Semua Dibaca
            </button>
        </form>
        @endif
    </div>

    <!-- Notifications List -->
    <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
        @forelse($notifications as $notification)
        <div class="p-4 border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors {{ !$notification->read_at ? 'bg-blue-50/50 dark:bg-blue-900/10 border-l-4 border-blue-500' : '' }}">
            <div class="flex items-start gap-4">
                <!-- Icon -->
                <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0
                    {{ $notification->data['color'] === 'green' ? 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400' :
                       ($notification->data['color'] === 'red' ? 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400' :
                       ($notification->data['color'] === 'yellow' ? 'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-400' : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-400')) }}">
                    <i class="bi bi-{{ $notification->data['icon'] ?? 'bell' }} text-xl"></i>
                </div>

                <!-- Content -->
                <div class="flex-1 min-w-0">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <h3 class="font-bold text-gray-900 dark:text-white {{ !$notification->read_at ? '' : 'opacity-90' }}">
                                {{ $notification->data['title'] }}
                            </h3>
                            <p class="text-sm text-gray-700 dark:text-gray-300 mt-1">
                                {{ $notification->data['message'] }}
                            </p>
                        </div>

                        <!-- Actions -->
                        <div class="flex items-center gap-2 flex-shrink-0">
                            @if(!$notification->read_at)
                            <span class="w-2.5 h-2.5 bg-blue-500 rounded-full border-2 border-white dark:border-gray-800"></span>
                            @endif
                            <form action="{{ route('notifications.destroy', $notification->id) }}" method="POST" onsubmit="return confirm('Hapus notifikasi ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-gray-500 dark:text-gray-400 hover:text-red-600 dark:hover:text-red-400 transition-colors">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Action Button -->
                    @if(!empty($notification->data['action_url']))
                    <a href="{{ route('notifications.read', $notification->id) }}"
                       class="inline-flex items-center gap-2 mt-3 px-4 py-2 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 rounded-lg font-bold text-sm hover:bg-blue-200 dark:hover:bg-blue-900/50 transition-colors border border-blue-200 dark:border-blue-700">
                        <i class="bi bi-arrow-right"></i>
                        {{ $notification->data['action_text'] ?? 'Lihat Detail' }}
                    </a>
                    @endif

                    <!-- Timestamp -->
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-3">
                        {{ $notification->created_at->format('d M Y, H:i') }} • {{ $notification->created_at->diffForHumans() }}
                    </p>
                </div>
            </div>
        </div>
        @empty
        <div class="p-12 text-center">
            <div class="w-20 h-20 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="bi bi-bell-slash text-3xl text-gray-500 dark:text-gray-400"></i>
            </div>
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Tidak Ada Notifikasi</h3>
            <p class="text-gray-600 dark:text-gray-400 font-bold">Anda akan menerima notifikasi ketika ada perubahan pada permohonan Anda.</p>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($notifications->hasPages())
    <div class="mt-6">
        {{ $notifications->links() }}
    </div>
    @endif

    <!-- Delete All Button -->
    @if($notifications->total() > 0)
    <div class="mt-6 text-center">
        <form action="{{ route('notifications.destroy-all') }}" method="POST" onsubmit="return confirm('Hapus SEMUA notifikasi? Tindakan ini tidak dapat dibatalkan.')">
            @csrf
            @method('DELETE')
            <button type="submit"
                    class="px-6 py-3 bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400 rounded-xl font-bold hover:bg-red-200 dark:hover:bg-red-900/50 transition-colors text-sm border border-red-200 dark:border-red-700">
                <i class="bi bi-trash mr-2"></i>Hapus Semua Notifikasi
            </button>
        </form>
    </div>
    @endif
</div>
@endsection
