@props(['unreadCount' => 0])

<div class="relative" x-data="{ open: false }">
    <!-- Notification Button -->
    <button @click="open = !open" @click.outside="open = false"
            class="relative p-3 text-gray-800 dark:text-gray-100 hover:text-primary-600 dark:hover:text-primary-400 transition-all bg-white/90 dark:bg-gray-800/90 rounded-xl hover:shadow-md border border-gray-300 dark:border-gray-600">
        <i class="bi bi-bell text-xl"></i>
        @if($unreadCount > 0)
        <span class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 text-white text-xs font-bold rounded-full flex items-center justify-center border-2 border-white dark:border-gray-800">
            {{ $unreadCount > 9 ? '9+' : $unreadCount }}
        </span>
        @endif
    </button>

    <!-- Dropdown Menu - LEBIH BESAR & JELAS -->
    <div x-show="open"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 translate-y-2"
         class="absolute right-0 mt-3 w-[520px] bg-white/95 dark:bg-gray-800/95 rounded-2xl shadow-2xl border border-gray-200/60 dark:border-gray-700/60 z-50 max-h-[650px] overflow-y-auto backdrop-blur-md">

        <!-- Header - FONT LEBIH BESAR -->
        <div class="px-6 py-4 border-b border-gray-200/60 dark:border-gray-700/60 bg-gray-50/50 dark:bg-gray-700/50 sticky top-0 rounded-t-2xl">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Notifikasi</h3>
                @if($unreadCount > 0)
                <a href="{{ route('notifications.mark-all-read') }}"
                   class="text-sm text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 font-semibold hover:underline">
                    Tandai semua dibaca
                </a>
                @endif
            </div>
        </div>

        <!-- Notifications List - SPASI & FONT LEBIH BESAR -->
        <div>
            @forelse(Auth::user()->notifications()->latest()->take(5)->get() as $notification)
            <a href="{{ route('notifications.read', $notification->id) }}"
               class="block px-6 py-5 hover:bg-gray-50/80 dark:hover:bg-gray-700/50 transition-colors {{ !$notification->read_at ? 'bg-blue-50/50 dark:bg-blue-900/15 border-l-4 border-blue-500' : 'border-l-4 border-transparent' }}">
                <div class="flex items-start gap-4">
                    <!-- Icon - LEBIH BESAR -->
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0
                        {{ $notification->data['color'] === 'green' ? 'bg-green-100 dark:bg-green-900/40 text-green-700 dark:text-green-300' :
                           ($notification->data['color'] === 'red' ? 'bg-red-100 dark:bg-red-900/40 text-red-700 dark:text-red-300' :
                           ($notification->data['color'] === 'yellow' ? 'bg-yellow-100 dark:bg-yellow-900/40 text-yellow-700 dark:text-yellow-300' : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300')) }}">
                        <i class="bi bi-{{ $notification->data['icon'] ?? 'bell' }} text-xl"></i>
                    </div>

                    <!-- Content - FONT LEBIH BESAR & JELAS -->
                    <div class="flex-1 min-w-0">
                        <p class="text-base font-bold text-gray-900 dark:text-white mb-1.5 {{ !$notification->read_at ? '' : 'opacity-90' }}">
                            {{ $notification->data['title'] }}
                        </p>
                        <p class="text-base text-gray-700 dark:text-gray-200 leading-relaxed">
                            {{ Str::limit($notification->data['message'], 100) }}
                        </p>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-2 font-medium">
                            {{ $notification->created_at->diffForHumans() }}
                        </p>
                    </div>

                    <!-- Unread Indicator - LEBIH BESAR -->
                    @if(!$notification->read_at)
                    <div class="w-3 h-3 bg-blue-500 rounded-full flex-shrink-0 mt-2.5"></div>
                    @endif
                </div>
            </a>
            @empty
            <div class="px-6 py-12 text-center">
                <div class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="bi bi-bell-slash text-3xl text-gray-500 dark:text-gray-400"></i>
                </div>
                <p class="text-base font-semibold text-gray-800 dark:text-gray-200">Tidak ada notifikasi</p>
            </div>
            @endforelse
        </div>

        <!-- Footer - FONT LEBIH BESAR -->
        <div class="px-6 py-4 border-t border-gray-200/60 dark:border-gray-700/60 bg-gray-50/50 dark:bg-gray-700/50 sticky bottom-0 text-center rounded-b-2xl">
            <a href="{{ route('notifications.index') }}"
               class="inline-flex items-center gap-2 text-base font-semibold text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 hover:underline">
                Lihat semua notifikasi <i class="bi bi-arrow-right"></i>
            </a>
        </div>
    </div>
</div>
