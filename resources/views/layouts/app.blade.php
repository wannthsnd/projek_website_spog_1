<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
x-data="{
darkMode: localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches),
notifOpen: false,
mobileMenu: false
}"
:class="{ 'dark': darkMode }">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title', 'SPOG KAPAL DAN CVS')</title>
<!-- Tailwind CSS -->
<script src="https://cdn.tailwindcss.com"></script>
<!-- Alpine.js -->
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<!-- Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<script>
tailwind.config = {
darkMode: 'class',
theme: {
extend: {
fontFamily: {
sans: ['Plus Jakarta Sans', 'sans-serif'],
},
colors: {
primary: {
50: '#FFF9E6', 100: '#FFF3CC', 200: '#FFE799',
300: '#FFDB66', 400: '#FFCF33', 500: '#FCD34D',
600: '#E5B830', 700: '#B8860B', 800: '#8C6608', 900: '#5F4405',
},
accent: {
50: '#F0F9FF', 100: '#E0F2FE', 200: '#BAE6FD',
300: '#7DD3FC', 400: '#38BDF8', 500: '#0EA5E9',
600: '#0284C7', 700: '#0369A1', 800: '#075985', 900: '#0C4A6E',
},
navy: {
50: '#E6F0FF', 100: '#CCE0FF', 200: '#99C0FF',
300: '#66A0FF', 400: '#3380FF', 500: '#0A2463',
600: '#071A4A', 700: '#041131',
},
super: {
50: '#F5F3FF', 100: '#EDE9FE', 200: '#DDD6FE',
300: '#C4B5FD', 400: '#A78BFA', 500: '#8B5CF6',
600: '#7C3AED', 700: '#6D28D9', 800: '#5B21B6', 900: '#4C1D95',
}
},
boxShadow: {
'soft': '0 2px 15px -3px rgba(0, 0, 0, 0.07), 0 10px 20px -2px rgba(0, 0, 0, 0.04)',
'soft-lg': '0 10px 40px -10px rgba(0, 0, 0, 0.08), 0 2px 6px -1px rgba(0, 0, 0, 0.02)',
'glow': '0 0 20px rgba(252, 211, 77, 0.3)',
'glow-lg': '0 0 40px rgba(252, 211, 77, 0.4)',
'super': '0 0 20px rgba(139, 92, 246, 0.4)',
},
animation: {
'fade-in': 'fadeIn 0.5s ease-in',
'fade-in-up': 'fadeInUp 0.6s ease-out',
'fade-in-down': 'fadeInDown 0.6s ease-out',
'slide-in-right': 'slideInRight 0.4s ease-out',
'bounce-slow': 'bounce 3s infinite',
'pulse-slow': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
'shimmer': 'shimmer 2s linear infinite',
},
keyframes: {
fadeIn: { '0%': { opacity: '0' }, '100%': { opacity: '1' } },
fadeInUp: { '0%': { opacity: '0', transform: 'translateY(20px)' }, '100%': { opacity: '1', transform: 'translateY(0)' } },
fadeInDown: { '0%': { opacity: '0', transform: 'translateY(-20px)' }, '100%': { opacity: '1', transform: 'translateY(0)' } },
slideInRight: { '0%': { transform: 'translateX(100%)' }, '100%': { transform: 'translateX(0)' } },
shimmer: { '0%': { backgroundPosition: '-1000px 0' }, '100%': { backgroundPosition: '1000px 0' } }
}
}
}
}
</script>
<style>
[x-cloak] { display: none !important; }
/* Gradient Styles */
.gradient-primary {
background: linear-gradient(135deg, #FCD34D 0%, #F59E0B 50%, #D4AF37 100%);
}
.gradient-primary-light {
background: linear-gradient(135deg, #FFF9E6 0%, #FFE799 50%, #FCD34D 100%);
}
.gradient-secondary {
background: linear-gradient(135deg, #3B82F6 0%, #1D4ED8 100%);
}
.gradient-combo {
background: linear-gradient(135deg, #FCD34D 0%, #3B82F6 100%);
}
.gradient-dark {
background: linear-gradient(135deg, #0A2463 0%, #071a4a 100%);
}
.gradient-super-admin {
background: linear-gradient(135deg, #8B5CF6 0%, #7C3AED 50%, #6D28D9 100%);
}
.gradient-surface {
background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
}
/* Text Gradient */
.text-gradient {
background: linear-gradient(135deg, #FCD34D 0%, #3B82F6 100%);
-webkit-background-clip: text;
-webkit-text-fill-color: transparent;
background-clip: text;
}
/* Glass Effects */
.glass-effect {
background: rgba(255, 255, 255, 0.95);
backdrop-filter: blur(16px);
-webkit-backdrop-filter: blur(16px);
border: 1px solid rgba(255, 255, 255, 0.5);
}
.glass-dark {
background: rgba(17, 24, 39, 0.95);
backdrop-filter: blur(16px);
-webkit-backdrop-filter: blur(16px);
}
/* Card Styles */
.card-hover {
transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}
.card-hover:hover {
transform: translateY(-4px) scale(1.01);
box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
}
.card-elevated {
box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.07), 0 2px 4px -1px rgba(0, 0, 0, 0.04);
border: 1px solid rgba(0, 0, 0, 0.04);
}
.card-elevated-lg {
box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.08), 0 4px 6px -2px rgba(0, 0, 0, 0.04);
border: 1px solid rgba(0, 0, 0, 0.05);
}
/* Button Shine Effect */
.btn-shine {
position: relative;
overflow: hidden;
}
.btn-shine::after {
content: '';
position: absolute;
top: 0;
left: -100%;
width: 100%;
height: 100%;
background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
transition: left 0.5s;
}
.btn-shine:hover::after {
left: 100%;
}
/* Navigation Active State */
.nav-link-active {
position: relative;
}
.nav-link-active::after {
content: '';
position: absolute;
bottom: -4px;
left: 50%;
transform: translateX(-50%);
width: 32px;
height: 3px;
background: linear-gradient(135deg, #FCD34D, #F59E0B);
border-radius: 2px;
animation: slideIn 0.3s ease-out;
}
@keyframes slideIn {
from { width: 0; }
to { width: 32px; }
}
/* Floating Animation */
.floating {
animation: floating 3s ease-in-out infinite;
}
@keyframes floating {
0%, 100% { transform: translateY(0px); }
50% { transform: translateY(-10px); }
}
/* Smooth Transitions */
* {
transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease, box-shadow 0.3s ease;
}
/* Custom Scrollbar */
::-webkit-scrollbar {
width: 8px;
height: 8px;
}
::-webkit-scrollbar-track {
background: #f1f5f9;
border-radius: 4px;
}
::-webkit-scrollbar-thumb {
background: linear-gradient(135deg, #FCD34D, #F59E0B);
border-radius: 4px;
}
::-webkit-scrollbar-thumb:hover {
background: linear-gradient(135deg, #F59E0B, #D4AF37);
}
/* Input Focus States */
input:focus, textarea:focus, select:focus {
outline: none;
box-shadow: 0 0 0 3px rgba(252, 211, 77, 0.2);
}
/* Table Row Hover */
.table-row-hover:hover {
background: linear-gradient(90deg, rgba(252, 211, 77, 0.08) 0%, rgba(252, 211, 77, 0.03) 100%);
}
</style>
@stack('styles')
</head>
<body class="font-sans antialiased bg-gradient-to-br from-sky-100 via-blue-100/70 to-indigo-100/50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 min-h-screen">
<!-- Decorative Background Elements - Subtle & Elegant -->
<div class="fixed inset-0 pointer-events-none overflow-hidden">
<div class="absolute top-0 left-1/4 w-96 h-96 bg-blue-200/20 rounded-full blur-3xl"></div>
<div class="absolute bottom-0 right-1/4 w-80 h-80 bg-indigo-200/20 rounded-full blur-3xl"></div>
</div>

<!-- Navigation -->
<nav class="bg-white/90 dark:bg-gray-900/90 backdrop-blur-xl shadow-soft-lg sticky top-0 z-50 border-b border-gray-200/60 dark:border-gray-700">
<div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
<div class="flex justify-between items-center h-24">
<!-- Logo -->
<a href="{{ route('dashboard') }}" class="flex items-center gap-4 group">
<div class="relative">
<div class="absolute inset-0 gradient-primary rounded-2xl blur-lg opacity-50 group-hover:opacity-70 transition-opacity"></div>
<div class="relative w-12 h-12 gradient-primary rounded-2xl flex items-center justify-center shadow-md group-hover:scale-110 transition-transform duration-300">
<i class="bi bi-ship text-2xl text-white"></i>
</div>
</div>
<div class="hidden sm:block">
<h1 class="text-xl font-bold text-gray-900 dark:text-white">SPOG KAPAL</h1>
<p class="text-xs font-medium text-gray-600 dark:text-gray-400">Sistem Pelaporan Terintegrasi</p>
</div>
</a>

<!-- Desktop Menu -->
<div class="hidden lg:flex items-center space-x-1">
<a href="{{ route('dashboard') }}"
class="px-6 py-3 rounded-xl font-semibold transition-all duration-300 {{ request()->routeIs('dashboard') ? 'nav-link-active gradient-primary text-white shadow-md' : 'text-gray-700 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-800' }}">
<i class="bi bi-speedometer2 mr-2"></i>Dashboard
</a>
@auth
<a href="{{ route('data.pemohon') }}"
class="px-6 py-3 rounded-xl font-semibold transition-all duration-300 {{ request()->routeIs('data.pemohon') ? 'nav-link-active gradient-primary text-white shadow-md' : 'text-gray-700 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-800' }}">
<i class="bi bi-people mr-2"></i>Data Pemohon
</a>
<a href="{{ route('permohonan.create') }}"
class="px-6 py-3 rounded-xl font-semibold transition-all duration-300 {{ request()->routeIs('permohonan.create') ? 'nav-link-active gradient-primary text-white shadow-md' : 'text-gray-700 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-800' }}">
<i class="bi bi-plus-circle mr-2"></i>Tambah Data
</a>
@endauth
</div>

<!-- Right Section -->
<div class="flex items-center gap-2">
<!-- Dark Mode Toggle -->
<button @click="darkMode = !darkMode; localStorage.theme = darkMode ? 'dark' : 'light'"
class="p-2.5 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-800 transition-all duration-300 group relative shadow-sm hover:shadow-md" title="Toggle Dark Mode">
<i class="bi bi-sun text-lg text-yellow-600" x-show="darkMode" x-cloak></i>
<i class="bi bi-moon text-lg text-gray-700 dark:text-white" x-show="!darkMode"></i>
</button>

@auth
<!-- Notification Dropdown -->
<div class="relative" x-data="{ open: false }">
<button @click="open = !open" @click.outside="open = false"
class="relative p-3 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-800 transition-all duration-300 group shadow-sm hover:shadow-md" title="Notifikasi">
<i class="bi bi-bell text-lg text-gray-700 dark:text-white"></i>
@php $unreadCount = Auth::user()->unreadNotifications->count(); @endphp
@if($unreadCount > 0)
<span class="absolute -top-1 -right-1 w-5 h-5 bg-gradient-to-br from-red-500 to-red-600 text-white text-xs font-bold rounded-full flex items-center justify-center animate-pulse border-2 border-white dark:border-gray-900 shadow-sm">
{{ $unreadCount > 9 ? '9+' : $unreadCount }}
</span>
@endif
</button>

<!-- Notification Dropdown Menu -->
<div x-show="open" x-cloak
x-transition:enter="transition ease-out duration-200"
x-transition:enter-start="opacity-0 scale-95 translate-y-1"
x-transition:enter-end="opacity-100 scale-100 translate-y-0"
class="absolute right-0 mt-3 w-[520px] bg-white/98 dark:bg-gray-800/98 backdrop-blur-xl rounded-2xl shadow-soft-lg border border-gray-200/60 dark:border-gray-700/60 z-50 max-h-[650px] overflow-y-auto">
<!-- Header -->
<div class="px-6 py-4 border-b border-gray-200/60 dark:border-gray-700/60 bg-gray-50/80 dark:from-gray-700/50 dark:to-gray-600/50 sticky top-0 rounded-t-2xl">
<div class="flex items-center justify-between">
<h3 class="text-lg font-bold text-gray-900 dark:text-white">Notifikasi</h3>
@if($unreadCount > 0)
<a href="{{ route('notifications.mark-all-read') }}" class="text-sm text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 font-semibold hover:underline">Tandai semua</a>
@endif
</div>
</div>

<!-- Notifications List -->
<div class="max-h-[520px] overflow-y-auto">
@forelse(Auth::user()->notifications()->latest()->take(5)->get() as $notification)
<a href="{{ route('notifications.read', $notification->id) }}"
class="block px-6 py-4 hover:bg-gray-50/80 dark:hover:bg-gray-700/50 transition-colors {{ !$notification->read_at ? 'bg-blue-50/50 dark:bg-blue-900/15 border-l-4 border-blue-500' : 'border-l-4 border-transparent' }}">
<div class="flex items-start gap-4">
<!-- Icon -->
<div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0 shadow-sm
{{ $notification->data['color'] === 'green' ? 'bg-green-100 dark:bg-green-900/40 text-green-700 dark:text-green-300' :
($notification->data['color'] === 'red' ? 'bg-red-100 dark:bg-red-900/40 text-red-700 dark:text-red-300' :
($notification->data['color'] === 'yellow' ? 'bg-yellow-100 dark:bg-yellow-900/40 text-yellow-700 dark:text-yellow-300' : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300')) }}">
<i class="bi bi-{{ $notification->data['icon'] ?? 'bell' }} text-xl"></i>
</div>
<!-- Content -->
<div class="flex-1 min-w-0">
<p class="text-base font-bold text-gray-900 dark:text-white mb-1 {{ !$notification->read_at ? '' : 'opacity-90' }}">
{{ $notification->data['title'] }}
</p>
<p class="text-sm text-gray-700 dark:text-gray-200 leading-relaxed line-clamp-2">
{{ $notification->data['message'] }}
</p>
<p class="text-xs text-gray-500 dark:text-gray-400 mt-2 font-medium">
{{ $notification->created_at->diffForHumans() }}
</p>
</div>
@if(!$notification->read_at)
<div class="w-3 h-3 bg-blue-500 rounded-full flex-shrink-0 mt-2 shadow-sm"></div>
@endif
</div>
</a>
@empty
<div class="px-6 py-10 text-center">
<div class="w-14 h-14 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-3 shadow-sm">
<i class="bi bi-bell-slash text-2xl text-gray-500 dark:text-gray-400"></i>
</div>
<p class="text-sm font-semibold text-gray-800 dark:text-gray-200">Tidak ada notifikasi</p>
</div>
@endforelse
</div>

<!-- Footer -->
<div class="px-6 py-4 border-t border-gray-200/60 dark:border-gray-700/60 bg-gray-50/80 dark:from-gray-700/50 dark:to-gray-600/50 sticky bottom-0 text-center rounded-b-2xl">
<a href="{{ route('notifications.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 hover:underline">
Lihat semua notifikasi <i class="bi bi-arrow-right"></i>
</a>
</div>
</div>
</div>

<!-- ✅ SUPER ADMIN PANEL BUTTON -->
@if(auth()->check() && auth()->user()->isSuperAdmin())
@php
$pendingUsers = \App\Models\User::where('is_active', false)->count();
$pendingPermits = \App\Models\ShipPermit::where('status', 'pending')->count();
$totalAlerts = $pendingUsers + $pendingPermits;
@endphp
<a href="{{ route('super-admin.dashboard') }}"
class="hidden sm:flex items-center gap-2 px-4 py-2.5 gradient-super-admin text-white rounded-xl font-semibold shadow-md hover:shadow-lg hover:scale-105 transition-all duration-300 btn-shine text-sm relative">
<i class="bi bi-shield-lock"></i>
<span>Super Admin</span>
@if($totalAlerts > 0)
<span class="absolute -top-2 -right-2 w-5 h-5 bg-rose-500 text-white text-[10px] font-bold rounded-full flex items-center justify-center animate-pulse border-2 border-white">
{{ $totalAlerts > 9 ? '9+' : $totalAlerts }}
</span>
@endif
</a>
@endif

<!-- Admin Panel Button with Reset Badge -->
@if(auth()->user()->isAdmin())
@php
$pendingResetCount = \App\Models\PasswordResetRequest::where('status', 'pending')
->where('expires_at', '>', now())
->count();
@endphp
<a href="{{ route('admin.dashboard') }}"
class="hidden sm:flex items-center gap-2 px-4 py-2.5 gradient-secondary text-white rounded-xl font-semibold shadow-md hover:shadow-lg hover:scale-105 transition-all duration-300 btn-shine text-sm relative">
<i class="bi bi-gear-wide-connected"></i>
<span>Admin</span>
@if($pendingResetCount > 0)
<span data-reset-badge
class="absolute -top-2 -right-2 w-5 h-5 bg-red-500 text-white text-[10px] font-bold rounded-full flex items-center justify-center animate-pulse border-2 border-white">
{{ $pendingResetCount > 9 ? '9+' : $pendingResetCount }}
</span>
@endif
</a>
@endif

<!-- Reset Password Menu with Badge (Admin Only) -->
@if(auth()->user()->isAdmin())
@php
$pendingResetCount = \App\Models\PasswordResetRequest::where('status', 'pending')
->where('expires_at', '>', now())
->count();
@endphp
<a href="{{ route('admin.password-reset-requests') }}"
class="hidden sm:flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-purple-500 to-purple-600 text-white rounded-xl font-semibold shadow-md hover:shadow-lg hover:scale-105 transition-all duration-300 btn-shine text-sm relative">
<i class="bi bi-key"></i>
<span>Reset Password</span>
@if($pendingResetCount > 0)
<span data-reset-badge
class="absolute -top-2 -right-2 w-5 h-5 bg-red-500 text-white text-[10px] font-bold rounded-full flex items-center justify-center animate-pulse border-2 border-white">
{{ $pendingResetCount > 9 ? '9+' : $pendingResetCount }}
</span>
@endif
</a>
@endif

<!-- User Menu Dropdown -->
<div x-data="{ open: false }" class="relative">
<button @click="open = !open" @click.away="open = false"
class="flex items-center gap-3 p-2 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-800 transition-all duration-300 group shadow-sm hover:shadow-md">
<div class="relative">
<div class="absolute inset-0 gradient-primary rounded-full blur opacity-50 group-hover:opacity-70 transition-opacity"></div>
<div class="relative w-11 h-11 gradient-primary rounded-full flex items-center justify-center text-white font-bold text-base shadow-md">
{{ substr(auth()->user()->name, 0, 1) }}
</div>
</div>
<div class="hidden md:block text-left">
<p class="text-sm font-semibold text-gray-900 dark:text-white">{{ auth()->user()->name }}</p>
<p class="text-xs font-medium text-gray-600 dark:text-gray-400 capitalize">
@if(auth()->user()->isSuperAdmin())
Super Admin
@elseif(auth()->user()->isAdmin())
Admin
@else
User
@endif
</p>
</div>
<i class="bi bi-chevron-down text-gray-700 dark:text-white text-xs font-semibold" :class="{ 'rotate-180': open }"></i>
</button>

<div x-show="open" x-cloak
x-transition:enter="transition ease-out duration-200"
x-transition:enter-start="opacity-0 scale-95"
x-transition:enter-end="opacity-100 scale-100"
class="absolute right-0 mt-2 w-64 bg-white dark:bg-gray-800 rounded-2xl shadow-soft-lg border border-gray-200 dark:border-gray-700 py-3 z-50">
<!-- User Info Header -->
<div class="px-5 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50/80 dark:from-gray-700/50 dark:to-gray-600/50">
<p class="text-base font-bold text-gray-900 dark:text-white">{{ auth()->user()->name }}</p>
<p class="text-sm text-gray-600 dark:text-gray-400">{{ auth()->user()->email }}</p>
<span class="inline-block mt-2 px-2 py-0.5
@if(auth()->user()->isSuperAdmin())
gradient-super-admin text-white
@elseif(auth()->user()->isAdmin())
gradient-secondary text-white
@else
bg-gray-100 text-gray-700
@endif
text-[10px] font-bold rounded-full">
@if(auth()->user()->isSuperAdmin())
Super Admin
@elseif(auth()->user()->isAdmin())
Admin
@else
User
@endif
</span>
</div>

<!-- Menu Items -->
<a href="{{ route('profile') }}" class="flex items-center gap-3 px-5 py-3.5 text-sm font-semibold text-gray-700 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
<i class="bi bi-person-circle text-lg text-gray-500 dark:text-gray-400"></i>Profil
</a>
<a href="{{ route('notifications.index') }}" class="flex items-center gap-3 px-5 py-3.5 text-sm font-semibold text-gray-700 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors relative">
<i class="bi bi-bell text-lg text-gray-500 dark:text-gray-400"></i>Notifikasi
@if(Auth::user()->unreadNotifications->count() > 0)
<span class="absolute right-5 top-4 px-2 py-0.5 bg-gradient-to-br from-red-500 to-red-600 text-white text-xs rounded-full font-bold shadow-sm">{{ Auth::user()->unreadNotifications->count() }}</span>
@endif
</a>
<a href="{{ route('settings') }}" class="flex items-center gap-3 px-5 py-3.5 text-sm font-semibold text-gray-700 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
<i class="bi bi-gear text-lg text-gray-500 dark:text-gray-400"></i>Pengaturan
</a>

<!-- Super Admin Quick Links -->
@if(auth()->user()->isSuperAdmin())
<div class="border-t border-gray-200 dark:border-gray-700 my-2"></div>
<p class="px-5 py-2 text-xs font-semibold text-purple-600 dark:text-purple-400 uppercase tracking-wider">Super Admin Panel</p>
<a href="{{ route('super-admin.dashboard') }}" class="flex items-center gap-3 px-5 py-3.5 text-sm font-semibold text-gray-700 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
<i class="bi bi-speedometer text-lg text-purple-500"></i>Dashboard
</a>
<a href="{{ route('super-admin.users.index') }}" class="flex items-center gap-3 px-5 py-3.5 text-sm font-semibold text-gray-700 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
<i class="bi bi-people text-lg text-purple-500"></i>Kelola Users
</a>
<a href="{{ route('super-admin.admins.index') }}" class="flex items-center gap-3 px-5 py-3.5 text-sm font-semibold text-gray-700 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
<i class="bi bi-person-gear text-lg text-emerald-500"></i>Kelola Admins
</a>
<a href="{{ route('super-admin.permits.index') }}" class="flex items-center gap-3 px-5 py-3.5 text-sm font-semibold text-gray-700 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
<i class="bi bi-folder-check text-lg text-amber-500"></i>Semua Permohonan
</a>
@endif

<!-- Divider -->
<div class="border-t border-gray-200 dark:border-gray-700 my-2"></div>

<!-- Logout -->
<form method="POST" action="{{ route('logout') }}">
@csrf
<button type="submit" class="w-full flex items-center gap-3 px-5 py-3.5 text-sm font-semibold text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors text-left">
<i class="bi bi-box-arrow-right text-lg text-red-500 dark:text-red-400"></i>Keluar
</button>
</form>
</div>
</div>
@else

<!-- ✅ SUPER ADMIN LOGIN LINK (For Guests) -->
<a href="{{ route('super-admin.login') }}"
class="hidden lg:flex items-center gap-1.5 px-3 py-2 text-xs text-purple-600 dark:text-purple-400 rounded-lg hover:bg-purple-50 dark:hover:bg-purple-900/20 transition-all duration-300 font-medium">
<i class="bi bi-shield-lock"></i>
<span>Super Admin</span>
</a>
<a href="{{ route('register') }}" class="flex items-center gap-1.5 px-4 py-2.5 gradient-primary text-white rounded-xl font-semibold shadow-md hover:shadow-lg hover:scale-105 transition-all duration-300 btn-shine text-sm">
<i class="bi bi-person-plus"></i>
<span class="hidden sm:inline">Daftar</span>
</a>
@endauth

<!-- Mobile Menu Button -->
<button @click="mobileMenu = !mobileMenu" class="lg:hidden p-2.5 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-800 transition-all shadow-sm hover:shadow-md">
<i class="bi bi-list text-xl text-gray-700 dark:text-white" x-show="!mobileMenu"></i>
<i class="bi bi-x text-xl text-gray-700 dark:text-white" x-show="mobileMenu" x-cloak></i>
</button>
</div>
</div>
</div>

<!-- Mobile Menu -->
<div x-show="mobileMenu" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
class="lg:hidden bg-white/98 dark:bg-gray-900/98 backdrop-blur-xl border-t border-gray-200 dark:border-gray-700 shadow-soft-lg">
<div class="px-4 py-4 space-y-2">
<a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold {{ request()->routeIs('dashboard') ? 'gradient-primary text-white shadow-md' : 'text-gray-700 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-800' }} text-sm">
<i class="bi bi-speedometer2"></i>Dashboard
</a>
@auth
<a href="{{ route('data.pemohon') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold {{ request()->routeIs('data.pemohon') ? 'gradient-primary text-white shadow-md' : 'text-gray-700 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-800' }} text-sm">
<i class="bi bi-people"></i>Data Pemohon
</a>
<a href="{{ route('permohonan.create') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold {{ request()->routeIs('permohonan.create') ? 'gradient-primary text-white shadow-md' : 'text-gray-700 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-800' }} text-sm">
<i class="bi bi-plus-circle"></i>Tambah Data
</a>

<!-- ✅ SUPER ADMIN MOBILE LINKS -->
@if(auth()->user()->isSuperAdmin())
@php
$pendingUsers = \App\Models\User::where('is_active', false)->count();
$pendingPermits = \App\Models\ShipPermit::where('status', 'pending')->count();
$totalAlerts = $pendingUsers + $pendingPermits;
@endphp
<div class="border-t border-gray-200 dark:border-gray-700 my-2"></div>
<p class="px-4 py-2 text-xs font-semibold text-purple-600 dark:text-purple-400 uppercase tracking-wider">Super Admin Panel</p>
<a href="{{ route('super-admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold gradient-super-admin text-white shadow-md text-sm">
<i class="bi bi-shield-lock"></i>Dashboard
@if($totalAlerts > 0)
<span class="ml-auto px-2 py-0.5 bg-rose-500 text-white text-[10px] rounded-full shadow-sm">{{ $totalAlerts }}</span>
@endif
</a>
<a href="{{ route('super-admin.users.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold text-gray-700 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-800 text-sm">
<i class="bi bi-people"></i>Kelola Users
</a>
<a href="{{ route('super-admin.admins.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold text-gray-700 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-800 text-sm">
<i class="bi bi-person-gear"></i>Kelola Admins
</a>
<a href="{{ route('super-admin.permits.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold text-gray-700 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-800 text-sm">
<i class="bi bi-folder-check"></i>Semua Permohonan
</a>
@endif

<!-- Admin Links for Mobile -->
@if(auth()->user()->isAdmin())
@php
$pendingResetCount = \App\Models\PasswordResetRequest::where('status', 'pending')
->where('expires_at', '>', now())
->count();
@endphp
<div class="border-t border-gray-200 dark:border-gray-700 my-2"></div>
<a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold text-gray-700 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-800 text-sm">
<i class="bi bi-gear-wide-connected"></i>Admin Panel
@if($pendingResetCount > 0)
<span class="ml-auto px-2 py-0.5 bg-red-500 text-white text-[10px] rounded-full shadow-sm">{{ $pendingResetCount }}</span>
@endif
</a>
<a href="{{ route('admin.password-reset-requests') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold text-gray-700 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-800 text-sm">
<i class="bi bi-key"></i>Reset Password
@if($pendingResetCount > 0)
<span class="ml-auto px-2 py-0.5 bg-red-500 text-white text-[10px] rounded-full shadow-sm">{{ $pendingResetCount }}</span>
@endif
</a>
@endif

<a href="{{ route('notifications.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold text-gray-700 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-800 text-sm">
<i class="bi bi-bell"></i>Notifikasi
@php $unreadCount = Auth::user()->unreadNotifications->count(); @endphp
@if($unreadCount > 0)
<span class="ml-auto px-2 py-0.5 bg-gradient-to-br from-red-500 to-red-600 text-white text-[10px] rounded-full shadow-sm">{{ $unreadCount }}</span>
@endif
</a>
@else
<div class="border-t border-gray-200 dark:border-gray-700 my-2"></div>
<a href="{{ route('login') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold text-gray-700 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-800 text-sm">
<i class="bi bi-box-arrow-in-right"></i>Masuk
</a>
<!-- ✅ SUPER ADMIN LOGIN LINK (Mobile) -->
<a href="{{ route('super-admin.login') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold text-purple-600 dark:text-purple-400 hover:bg-purple-50 dark:hover:bg-purple-900/20 text-sm">
<i class="bi bi-shield-lock"></i>Super Admin Login
</a>
<a href="{{ route('register') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold gradient-primary text-white text-sm shadow-md">
<i class="bi bi-person-plus"></i>Daftar
</a>
@endauth
</div>
</div>
</nav>

<!-- Flash Messages -->
@if(session('success'))
<div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2"
class="fixed top-24 right-4 z-50 max-w-md animate-fade-in-up">
<div class="bg-gradient-to-r from-green-500 to-emerald-600 text-white px-5 py-3.5 rounded-2xl shadow-soft-lg flex items-center gap-3">
<div class="w-9 h-9 bg-white/20 rounded-full flex items-center justify-center flex-shrink-0">
<i class="bi bi-check-circle text-lg"></i>
</div>
<div class="flex-1">
<p class="font-bold text-sm">Berhasil!</p>
<p class="text-xs opacity-90">{{ session('success') }}</p>
</div>
<button @click="show = false" class="p-1.5 hover:bg-white/20 rounded-lg transition-colors">
<i class="bi bi-x text-sm"></i>
</button>
</div>
</div>
@endif

@if(session('error'))
<div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
x-transition:enter="transition ease-out duration-300"
class="fixed top-24 right-4 z-50 max-w-md">
<div class="bg-gradient-to-r from-red-500 to-rose-600 text-white px-5 py-3.5 rounded-2xl shadow-soft-lg flex items-center gap-3">
<div class="w-9 h-9 bg-white/20 rounded-full flex items-center justify-center flex-shrink-0">
<i class="bi bi-exclamation-triangle text-lg"></i>
</div>
<div class="flex-1">
<p class="font-bold text-sm">Error!</p>
<p class="text-xs opacity-90">{{ session('error') }}</p>
</div>
<button @click="show = false" class="p-1.5 hover:bg-white/20 rounded-lg transition-colors">
<i class="bi bi-x text-sm"></i>
</button>
</div>
</div>
@endif

<!-- Main Content -->
<main class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 animate-fade-in-up relative z-10">
@yield('content')
</main>

<!-- Footer -->
<footer class="bg-white/90 dark:bg-gray-900/90 backdrop-blur-xl border-t border-gray-200 dark:border-gray-700 mt-auto">
<div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
<div>
<div class="flex items-center gap-2.5 mb-3">
<div class="w-9 h-9 gradient-primary rounded-xl flex items-center justify-center shadow-md">
<i class="bi bi-ship text-white text-sm"></i>
</div>
<div>
<h3 class="font-bold text-gray-900 dark:text-white text-sm">SPOG KAPAL NON & CVS</h3>
<p class="text-[10px] font-medium text-gray-600 dark:text-gray-400">Sistem Pelaporan Terintegrasi</p>
</div>
</div>
<p class="text-[11px] font-medium text-gray-700 dark:text-gray-300 leading-relaxed">Platform modern untuk pengelolaan Surat Perizinan Olah Gerak Kapal (SPOG) yang efisien dan terpercaya.</p>
</div>
<div>
<h4 class="font-bold text-gray-900 dark:text-white mb-3 text-sm">Tautan Cepat</h4>
<ul class="space-y-1.5 text-[11px]">
<li><a href="{{ route('dashboard') }}" class="font-semibold text-gray-700 dark:text-white hover:text-primary-600 dark:hover:text-primary-400 transition-colors">Dashboard</a></li>
@auth
<li><a href="{{ route('data.pemohon') }}" class="font-semibold text-gray-700 dark:text-white hover:text-primary-600 dark:hover:text-primary-400 transition-colors">Data Pemohon</a></li>
<li><a href="{{ route('permohonan.create') }}" class="font-semibold text-gray-700 dark:text-white hover:text-primary-600 dark:hover:text-primary-400 transition-colors">Tambah Permohonan</a></li>
@else
<li><a href="{{ route('register') }}" class="font-semibold text-gray-700 dark:text-white hover:text-primary-600 dark:hover:text-primary-400 transition-colors">Daftar Akun</a></li>
@endauth
</ul>
</div>
<div>
<h4 class="font-bold text-gray-900 dark:text-white mb-3 text-sm">Kontak</h4>
<ul class="space-y-1.5 text-[11px]">
<li class="flex items-center gap-2">
<i class="bi bi-geo-alt text-primary-600 text-xs"></i>
<span class="font-semibold text-gray-700 dark:text-white">Kementerian Perhubungan RI</span>
</li>
<li class="flex items-center gap-2">
<i class="bi bi-envelope text-primary-600 text-xs"></i>
<span class="font-semibold text-gray-700 dark:text-white">info@pnbp-maritime.go.id</span>
</li>
<li class="flex items-center gap-2">
<i class="bi bi-telephone text-primary-600 text-xs"></i>
<span class="font-semibold text-gray-700 dark:text-white">1500-xxx</span>
</li>
</ul>
</div>
</div>
<div class="border-t border-gray-200 dark:border-gray-700 mt-6 pt-4 text-center">
<p class="text-[11px] font-semibold text-gray-700 dark:text-white">
&copy; {{ date('Y') }} <span class="text-gradient">SPOG</span>. All rights reserved. | Dibuat dengan <i class="bi bi-heart-fill text-red-600"></i> untuk Indonesia
</p>
</div>
</div>
</footer>

<!-- ✅ MODAL CATATAN PENTING (LOCALSTORAGE - Tampil sekali) -->
@if(auth()->check())
<div id="catatanPentingModal" class="hidden fixed inset-0 bg-black/70 backdrop-blur-sm z-[9999] flex items-center justify-center p-4">
    <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto animate-fade-in-up border-2 border-emerald-500/30">
        <!-- Modal Header -->
        <div class="sticky top-0 bg-gradient-to-r from-emerald-600 to-teal-600 text-white px-8 py-6 rounded-t-3xl">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur-sm">
                    <i class="bi bi-info-circle text-3xl"></i>
                </div>
                <div class="flex-1">
                    <h2 class="text-2xl font-extrabold">Catatan Penting</h2>
                    <p class="text-emerald-100 text-sm">Harap dibaca sebelum melanjutkan</p>
                </div>
                <button onclick="closeCatatanPenting()"
                        class="p-2 hover:bg-white/20 rounded-xl transition-colors">
                    <i class="bi bi-x text-2xl"></i>
                </button>
            </div>
        </div>

        <!-- Modal Content -->
        <div class="p-8">
            <div class="bg-gradient-to-br from-emerald-50 to-teal-50 dark:from-emerald-900/20 dark:to-teal-900/20 rounded-2xl p-6 border-2 border-emerald-300 dark:border-emerald-700">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-xl flex items-center justify-center flex-shrink-0 shadow-lg">
                        <i class="bi bi-lightbulb text-2xl text-white"></i>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-xl font-extrabold text-emerald-900 dark:text-emerald-300 mb-4">
                            Informasi Penting SPOG:
                        </h3>
                        <ul class="space-y-3 text-sm text-emerald-900 dark:text-emerald-200">
                            <li class="flex items-start gap-3">
                                <i class="bi bi-check-circle-fill text-emerald-600 dark:text-emerald-400 mt-0.5 flex-shrink-0"></i>
                                <span class="font-semibold">SPOG diberikan kepada kapal berdasarkan jenis kapal dan peruntukannya</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <i class="bi bi-check-circle-fill text-emerald-600 dark:text-emerald-400 mt-0.5 flex-shrink-0"></i>
                                <span class="font-semibold">Pemilik/operator telah mengasuransikan seluruh jiwa yang ada di kapal</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <i class="bi bi-check-circle-fill text-emerald-600 dark:text-emerald-400 mt-0.5 flex-shrink-0"></i>
                                <span class="font-semibold">Nakhoda memiliki Surat Keterangan Kecakapan (SKK) 30 mil yang masih berlaku</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <i class="bi bi-check-circle-fill text-emerald-600 dark:text-emerald-400 mt-0.5 flex-shrink-0"></i>
                                <span class="font-semibold">Kapal harus mempunyai alat keselamatan yang cukup (life jacket)</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <i class="bi bi-check-circle-fill text-emerald-600 dark:text-emerald-400 mt-0.5 flex-shrink-0"></i>
                                <span class="font-semibold">Kegiatan hanya di Perairan Bandar</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <i class="bi bi-check-circle-fill text-emerald-600 dark:text-emerald-400 mt-0.5 flex-shrink-0"></i>
                                <span class="font-semibold">Data manifest sesuai KTP/Identitas lain bagi yang belum memiliki KTP</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Info Tambahan -->
            <div class="mt-6 bg-blue-50 dark:bg-blue-900/20 rounded-2xl p-5 border-2 border-blue-300 dark:border-blue-700">
                <div class="flex items-start gap-3">
                    <i class="bi bi-exclamation-triangle text-blue-600 dark:text-blue-400 text-xl mt-0.5 flex-shrink-0"></i>
                    <div>
                        <h4 class="font-bold text-blue-900 dark:text-blue-300 mb-2">Perhatian:</h4>
                        <p class="text-sm text-blue-900 dark:text-blue-200 font-semibold">
                            Pastikan semua persyaratan telah lengkap sebelum mengajukan permohonan SPOG.
                            Permohonan yang tidak lengkap akan ditolak atau diproses lebih lama.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Footer -->
        <div class="sticky bottom-0 bg-gray-50 dark:bg-gray-700/50 px-8 py-5 border-t border-gray-200 dark:border-gray-700 rounded-b-3xl">
            <div class="flex items-center justify-between gap-4">
                <label class="flex items-center gap-3 cursor-pointer group">
                    <input type="checkbox" id="dontShowAgain"
                           class="w-5 h-5 rounded-lg border-gray-300 text-emerald-600 focus:ring-emerald-500 focus:ring-2">
                    <span class="text-sm font-semibold text-gray-700 dark:text-gray-300 group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors">
                        Jangan tampilkan lagi
                    </span>
                </label>
                <button onclick="closeCatatanPenting()"
                        class="px-8 py-3 bg-gradient-to-r from-emerald-500 to-teal-600 text-white rounded-xl font-extrabold hover:shadow-lg hover:scale-105 transition-all">
                    <i class="bi bi-check-circle mr-2"></i>
                    Saya Mengerti
                </button>
            </div>
        </div>
    </div>
</div>

<script>
// Check if modal should be shown using LOCALSTORAGE
document.addEventListener('DOMContentLoaded', function() {
    const showModal = localStorage.getItem('showCatatanPenting');

    // Show modal if not set or set to 'true'
    if (showModal === null || showModal === 'true') {
        setTimeout(function() {
            document.getElementById('catatanPentingModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden'; // Prevent scrolling
        }, 500); // Delay 500ms for better UX
    }
});

function closeCatatanPenting() {
    const dontShowAgain = document.getElementById('dontShowAgain').checked;

    if (dontShowAgain) {
        // Don't show again (localStorage - persistent)
        localStorage.setItem('showCatatanPenting', 'false');
    } else {
        // Show again next time (localStorage - persistent)
        localStorage.setItem('showCatatanPenting', 'true');
    }

    document.getElementById('catatanPentingModal').classList.add('hidden');
    document.body.style.overflow = ''; // Restore scrolling
}

// Close modal when clicking outside
document.getElementById('catatanPentingModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeCatatanPenting();
    }
});
</script>
@endif

<!-- Real-time Badge Update Script (For Admin Reset Badges) -->
@if(auth()->check() && auth()->user()->isAdmin())
<script>
document.addEventListener('DOMContentLoaded', function() {
function updateResetBadge() {
fetch('{{ route("admin.api.pending-reset-count") }}')
.then(response => response.json())
.then(data => {
const count = data.count;
document.querySelectorAll('[data-reset-badge]').forEach(el => {
if (count > 0) {
el.textContent = count > 9 ? '9+' : count;
el.classList.remove('hidden');
el.classList.add('animate-pulse');
} else {
el.classList.add('hidden');
el.classList.remove('animate-pulse');
}
});
})
.catch(error => console.log('Badge update error:', error));
}
updateResetBadge();
setInterval(updateResetBadge, 30000);
});
</script>
@endif

@stack('scripts')
</body>
</html>
