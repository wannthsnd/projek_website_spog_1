@extends('layouts.app')
@section('title', 'Super Admin Login - SPOG KAPAL')

@section('content')
<!-- Full Screen Background -->
<div class="fixed inset-0 z-0 overflow-hidden" style="background: linear-gradient(135deg, #0a1628 0%, #0c2440 25%, #1a4a7a 50%, #0f766e 75%, #0a1628 100%); background-size: 400% 400%; animation: gradientShift 15s ease infinite;">

    <!-- Animated Background Elements -->
    <div class="absolute inset-0 overflow-hidden">
        <!-- Gradient Orbs - Responsive Sizes -->
        <div class="absolute top-0 left-1/4 w-72 h-72 sm:w-96 sm:h-96 bg-teal-600/20 rounded-full blur-3xl animate-pulse-slow"></div>
        <div class="absolute bottom-0 right-1/4 w-64 h-64 sm:w-80 sm:h-80 bg-blue-700/20 rounded-full blur-3xl animate-pulse-slow" style="animation-delay: 2s;"></div>
        <div class="absolute top-1/2 left-1/2 w-56 h-56 sm:w-64 sm:h-64 bg-amber-500/10 rounded-full blur-3xl animate-pulse-slow" style="animation-delay: 4s;"></div>
        <div class="absolute top-1/3 right-1/3 w-60 h-60 sm:w-72 sm:h-72 bg-indigo-600/15 rounded-full blur-3xl animate-pulse-slow" style="animation-delay: 6s;"></div>

        <!-- Grid Pattern Overlay -->
        <div class="absolute inset-0 opacity-5" style="background-image: linear-gradient(rgba(255,255,255,0.15) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.15) 1px, transparent 1px); background-size: 60px 60px;"></div>

        <!-- Floating Particles -->
        <div id="particles" class="absolute inset-0"></div>

        <!-- Wave Decoration Bottom -->
        <div class="absolute bottom-0 left-0 right-0 h-32 sm:h-40 opacity-10">
            <svg viewBox="0 0 1440 320" class="w-full h-full" preserveAspectRatio="none">
                <path fill="rgba(251,191,36,0.3)" fill-opacity="0.5" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,112C672,96,768,96,864,112C960,128,1056,160,1152,160C1248,160,1344,128,1392,112L1440,96L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
            </svg>
        </div>

        <!-- Corner Accents -->
        <div class="absolute top-0 right-0 w-48 h-48 sm:w-64 sm:h-64 bg-gradient-to-bl from-teal-500/10 to-transparent"></div>
        <div class="absolute bottom-0 left-0 w-48 h-48 sm:w-64 sm:h-64 bg-gradient-to-tr from-amber-500/10 to-transparent"></div>
    </div>
</div>

<!-- Content Layer -->
<div class="relative z-10 min-h-screen flex items-center justify-center px-3 sm:px-4 md:px-6 py-6 sm:py-8">

    <!-- Top Branding - Responsive -->
    <div class="fixed top-3 left-3 sm:top-6 sm:left-6 z-20">
        <div class="flex items-center gap-2 sm:gap-4 bg-white/5 backdrop-blur-xl px-3 py-2 sm:px-6 sm:py-3 rounded-xl sm:rounded-2xl border border-white/10 shadow-2xl hover:bg-white/10 transition-all duration-300">
            <div class="flex items-center gap-2 sm:gap-3">
                <img src="{{ asset('images/kemenhub.png') }}" alt="Kemenhub" class="h-8 w-auto sm:h-12 filter brightness-0 invert drop-shadow-lg">
                <div class="hidden xs:block">
                    <div class="text-white font-bold text-xs sm:text-sm">Kementerian</div>
                    <div class="text-white/70 text-xs">Perhubungan RI</div>
                </div>
            </div>
            <div class="w-px h-6 sm:h-10 bg-white/20 hidden xs:block"></div>
            <div class="flex items-center gap-2 sm:gap-3">
                <img src="{{ asset('images/kplp.png') }}" alt="KPLP" class="h-8 w-auto sm:h-12 filter brightness-0 invert drop-shadow-lg">
                <div class="hidden xs:block">
                    <div class="text-white font-bold text-xs sm:text-sm">KPLP</div>
                    <div class="text-white/70 text-xs">Direktorat Jenderal</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="w-full max-w-xs sm:max-w-sm md:max-w-md">

        <!-- Premium Header - Responsive -->
        <div class="text-center mb-6 sm:mb-8">
            <div class="inline-flex items-center justify-center relative mb-4 sm:mb-6">
                <!-- Glow Ring -->
                <div class="absolute inset-0 bg-gradient-to-r from-teal-500 via-amber-500 to-blue-600 rounded-full blur-2xl opacity-50 animate-pulse"></div>

                <!-- Badge Container -->
                <div class="relative w-16 h-16 sm:w-20 sm:h-20 md:w-24 md:h-24 bg-gradient-to-br from-slate-800 via-teal-900 to-slate-900 rounded-2xl sm:rounded-3xl flex items-center justify-center shadow-2xl border-2 border-amber-500/50">
                    <i class="bi bi-shield-lock-fill text-2xl sm:text-3xl md:text-4xl text-white"></i>
                    <div class="absolute -top-1 -right-1 sm:-top-2 sm:-right-2 px-2 py-0.5 sm:px-3 sm:py-1 bg-gradient-to-r from-amber-500 to-amber-600 text-slate-900 text-xs font-bold rounded-full border-2 border-slate-900 shadow-lg">
                        ADMIN
                    </div>
                </div>
            </div>

            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold mb-1 sm:mb-2 text-white">
                Super <span class="text-transparent bg-clip-text bg-gradient-to-r from-amber-400 to-amber-600">Admin</span>
            </h1>
            <p class="text-teal-200 font-medium text-sm sm:text-lg md:text-xl">Panel Kontrol Eksekutif</p>
            <p class="text-teal-300/60 text-xs sm:text-sm mt-2 sm:mt-3 flex items-center justify-center gap-1 sm:gap-2 px-2">
                <i class="bi bi-shield-check text-amber-400 text-sm sm:text-base"></i>
                <span>SPOG KAPAL • Direktorat KPLP</span>
            </p>
        </div>

        <!-- Premium Login Card - Responsive -->
        <div class="bg-white/5 backdrop-blur-2xl rounded-2xl sm:rounded-3xl shadow-2xl p-4 sm:p-6 md:p-8 border border-white/10 relative overflow-hidden">
            <!-- Top Accent Bar -->
            <div class="absolute top-0 left-0 right-0 h-1 sm:h-1.5 bg-gradient-to-r from-slate-800 via-teal-600 to-amber-500"></div>

            <!-- Decorative Elements -->
            <div class="absolute top-8 right-8 sm:top-10 sm:right-10 w-16 h-16 sm:w-20 sm:h-20 bg-teal-500/10 rounded-full blur-2xl"></div>
            <div class="absolute bottom-8 left-8 sm:bottom-10 sm:left-10 w-12 h-12 sm:w-16 sm:h-16 bg-amber-500/10 rounded-full blur-2xl"></div>

            <!-- Alerts -->
            @if(session('success'))
            <div class="mb-4 sm:mb-6 p-3 sm:p-4 bg-teal-500/20 border border-teal-400/30 rounded-xl sm:rounded-2xl flex items-start gap-2 sm:gap-3 animate-fade-in backdrop-blur-sm">
                <div class="w-8 h-8 sm:w-10 sm:h-10 bg-teal-500/30 rounded-lg sm:rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="bi bi-check-circle-fill text-teal-300 text-base sm:text-lg"></i>
                </div>
                <div>
                    <p class="text-sm font-bold text-teal-100">Berhasil!</p>
                    <p class="text-xs text-teal-200/80">{{ session('success') }}</p>
                </div>
            </div>
            @endif

            @if(session('error') || $errors->any())
            <div class="mb-4 sm:mb-6 p-3 sm:p-4 bg-red-500/20 border border-red-400/30 rounded-xl sm:rounded-2xl flex items-start gap-2 sm:gap-3 animate-fade-in backdrop-blur-sm">
                <div class="w-8 h-8 sm:w-10 sm:h-10 bg-red-500/30 rounded-lg sm:rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="bi bi-exclamation-triangle-fill text-red-300 text-base sm:text-lg"></i>
                </div>
                <div>
                    <p class="text-sm font-bold text-red-100">Error</p>
                    <p class="text-xs text-red-200/80">{{ session('error') ?? $errors->first() }}</p>
                </div>
            </div>
            @endif

            <!-- Login Form -->
            <form action="{{ route('super-admin.login.post') }}" method="POST" class="space-y-4 sm:space-y-5 md:space-y-6 relative z-10">
                @csrf

                <!-- Email Input -->
                <div class="group">
                    <label for="email" class="block text-xs sm:text-sm font-semibold text-teal-100 mb-1.5 sm:mb-2 ml-1">
                        <i class="bi bi-envelope-fill text-teal-400 mr-1.5 sm:mr-2"></i>Email Super Admin
                    </label>
                    <div class="relative">
                        <div class="absolute left-3 sm:left-4 top-1/2 -translate-y-1/2 text-teal-400/70 group-focus-within:text-teal-400 transition-colors">
                            <i class="bi bi-envelope text-base sm:text-lg"></i>
                        </div>
                        <input type="email"
                               name="email"
                               id="email"
                               value="{{ old('email') }}"
                               class="w-full pl-10 sm:pl-12 pr-3 sm:pr-4 py-3 sm:py-4 bg-white/5 border-2 border-white/10 rounded-xl sm:rounded-2xl focus:outline-none transition-all text-sm sm:text-base text-white placeholder-white/30 focus:border-teal-500 focus:bg-white/10 focus:shadow-lg focus:shadow-teal-500/20 @error('email') border-red-400/50 @enderror"
                               placeholder="admin@spog-kapal.go.id"
                               required autofocus autocomplete="email">
                    </div>
                </div>

                <!-- Password Input -->
                <div class="group">
                    <label for="password" class="block text-xs sm:text-sm font-semibold text-teal-100 mb-1.5 sm:mb-2 ml-1">
                        <i class="bi bi-lock-fill text-teal-400 mr-1.5 sm:mr-2"></i>Password
                    </label>
                    <div class="relative">
                        <div class="absolute left-3 sm:left-4 top-1/2 -translate-y-1/2 text-teal-400/70 group-focus-within:text-teal-400 transition-colors">
                            <i class="bi bi-lock text-base sm:text-lg"></i>
                        </div>
                        <input type="password"
                               name="password"
                               id="password"
                               class="w-full pl-10 sm:pl-12 pr-10 sm:pr-12 py-3 sm:py-4 bg-white/5 border-2 border-white/10 rounded-xl sm:rounded-2xl focus:outline-none transition-all text-sm sm:text-base text-white placeholder-white/30 focus:border-teal-500 focus:bg-white/10 focus:shadow-lg focus:shadow-teal-500/20 @error('password') border-red-400/50 @enderror"
                               placeholder="••••••••••••"
                               required autocomplete="current-password">
                        <button type="button" onclick="togglePasswordVisibility()"
                                class="absolute right-3 sm:right-4 top-1/2 -translate-y-1/2 text-teal-400/70 hover:text-teal-300 focus:outline-none transition-all p-1.5 sm:p-2 hover:bg-white/10 rounded-lg">
                            <i class="bi bi-eye text-base sm:text-lg" id="toggleIcon"></i>
                        </button>
                    </div>
                </div>

                <!-- Remember & Forgot -->
                <div class="flex items-center justify-between pt-1 sm:pt-2">
                    <label class="flex items-center gap-2 sm:gap-3 cursor-pointer group">
                        <div class="relative">
                            <input type="checkbox" name="remember"
                                   class="peer w-4 h-4 sm:w-5 sm:h-5 rounded-lg border-2 border-teal-400/50 text-teal-500 focus:ring-teal-400 bg-white/5 cursor-pointer transition-all checked:bg-teal-500 checked:border-teal-500">
                            <i class="bi bi-check absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 text-white text-xs opacity-0 peer-checked:opacity-100 transition-opacity pointer-events-none"></i>
                        </div>
                        <span class="text-xs sm:text-sm text-teal-200 group-hover:text-white transition-colors">Ingat sesi ini</span>
                    </label>
                    <a href="{{ route('password.request') }}" class="text-xs sm:text-sm text-teal-300 hover:text-amber-400 font-semibold transition-colors hover:underline">
                        Lupa password?
                    </a>
                </div>

                <!-- Submit Button -->
                <button type="submit"
                        class="w-full bg-gradient-to-r from-slate-800 via-teal-700 to-teal-600 text-white font-bold py-3 sm:py-4 rounded-xl sm:rounded-2xl shadow-xl hover:shadow-2xl hover:shadow-teal-500/30 hover:scale-[1.02] active:scale-[0.98] transition-all duration-300 flex items-center justify-center gap-2 sm:gap-3 group border border-teal-500/30 relative overflow-hidden text-sm sm:text-base">
                    <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent -translate-x-full group-hover:translate-x-full transition-transform duration-700"></div>
                    <i class="bi bi-shield-check text-xl sm:text-2xl text-amber-400 group-hover:rotate-12 transition-transform"></i>
                    <span>Masuk ke Panel Super Admin</span>
                    <i class="bi bi-arrow-right-circle text-xl sm:text-2xl group-hover:translate-x-1 transition-transform"></i>
                </button>
            </form>

            <!-- Divider -->
            <div class="relative my-6 sm:my-8">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-white/10"></div>
                </div>
                <div class="relative flex justify-center">
                    <span class="px-3 sm:px-4 bg-slate-900/50 text-teal-300/60 text-xs font-medium rounded-full">atau</span>
                </div>
            </div>

            <!-- Back Link -->
            <div class="text-center">
                <a href="{{ route('login') }}"
                   class="inline-flex items-center gap-1.5 sm:gap-2 text-xs sm:text-sm text-teal-300 hover:text-amber-400 font-semibold transition-all hover:underline group">
                    <i class="bi bi-arrow-left group-hover:-translate-x-1 transition-transform"></i>
                    <span>Kembali ke Login Pengguna</span>
                </a>
            </div>
        </div>

        <!-- Security Notice - Responsive -->
        <div class="mt-6 sm:mt-8 text-center px-2">
            <div class="inline-flex items-center gap-2 sm:gap-3 px-4 sm:px-6 py-2 sm:py-3 bg-white/5 rounded-xl sm:rounded-2xl border border-amber-500/20 backdrop-blur-sm hover:bg-white/10 transition-all">
                <div class="relative">
                    <i class="bi bi-shield-check text-xl sm:text-2xl text-amber-400"></i>
                    <div class="absolute -top-0.5 sm:-top-1 -right-0.5 sm:-right-1 w-2.5 h-2.5 sm:w-3 sm:h-3 bg-green-500 rounded-full border-2 border-slate-900 animate-pulse"></div>
                </div>
                <div class="text-left">
                    <p class="text-xs font-bold text-teal-100">Keamanan Terjamin</p>
                    <p class="text-xs text-teal-300/70 hidden sm:block">Enkripsi end-to-end & audit log aktif</p>
                </div>
            </div>
            <p class="text-xs text-teal-300/40 mt-3 sm:mt-4">
                &copy; {{ date('Y') }} SPOG KAPAL • Direktorat KPLP
            </p>
        </div>
    </div>
</div>

<script>
// Toggle Password Visibility
function togglePasswordVisibility() {
    const passwordInput = document.getElementById('password');
    const toggleIcon = document.getElementById('toggleIcon');

    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        toggleIcon.classList.remove('bi-eye');
        toggleIcon.classList.add('bi-eye-slash');
    } else {
        passwordInput.type = 'password';
        toggleIcon.classList.remove('bi-eye-slash');
        toggleIcon.classList.add('bi-eye');
    }
}

// Create Floating Particles - Responsive Count
function createParticles() {
    const container = document.getElementById('particles');
    const screenWidth = window.innerWidth;
    const particleCount = screenWidth < 640 ? 20 : screenWidth < 1024 ? 30 : 40;

    for (let i = 0; i < particleCount; i++) {
        const particle = document.createElement('div');
        const size = Math.random() * 3 + 1;
        const colors = ['bg-teal-400/30', 'bg-amber-400/30', 'bg-blue-400/30', 'bg-white/20'];
        particle.className = `absolute rounded-full ${colors[Math.floor(Math.random() * colors.length)]}`;
        particle.style.width = size + 'px';
        particle.style.height = size + 'px';
        particle.style.left = Math.random() * 100 + '%';
        particle.style.top = Math.random() * 100 + '%';
        particle.style.animation = `float ${Math.random() * 20 + 15}s linear infinite`;
        particle.style.animationDelay = Math.random() * 10 + 's';
        container.appendChild(particle);
    }
}

// Form Submit Handler
document.addEventListener('DOMContentLoaded', function() {
    createParticles();

    const form = document.querySelector('form');
    const submitBtn = form.querySelector('button[type="submit"]');

    form.addEventListener('submit', function(e) {
        submitBtn.innerHTML = '<i class="bi bi-hourglass-split text-lg sm:text-xl animate-spin"></i><span>Memproses...</span>';
        submitBtn.disabled = true;
        submitBtn.classList.add('opacity-75', 'cursor-not-allowed');
    });

    // Enter key support
    const inputs = document.querySelectorAll('input');
    inputs.forEach(input => {
        input.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                form.requestSubmit();
            }
        });
    });
});

// Security Console Warning
console.log('%c🛡️ SUPER ADMIN ACCESS', 'color: #fbbf24; font-size: 24px; font-weight: bold;');
console.log('%c🔐 Restricted Executive Panel', 'color: #2dd4bf; font-size: 14px; font-weight: 600;');
console.log('%c⚠️ All activities are logged and monitored', 'color: #f87171; font-size: 12px;');
</script>

<style>
/* Animated Background Gradient */
@keyframes gradientShift {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

/* Float Animation for Particles */
@keyframes float {
    0% { transform: translateY(100vh) rotate(0deg); opacity: 0; }
    10% { opacity: 1; }
    90% { opacity: 1; }
    100% { transform: translateY(-100px) rotate(720deg); opacity: 0; }
}

/* Pulse Animation */
@keyframes pulse-slow {
    0%, 100% { opacity: 0.4; transform: scale(1); }
    50% { opacity: 0.25; transform: scale(1.1); }
}

/* Fade In Animation */
@keyframes fade-in {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

.animate-pulse-slow { animation: pulse-slow 4s ease-in-out infinite; }
.animate-fade-in { animation: fade-in 0.4s ease-out; }

/* Custom Scrollbar */
::-webkit-scrollbar { width: 8px; }
::-webkit-scrollbar-track { background: rgba(13, 148, 136, 0.1); }
::-webkit-scrollbar-thumb { background: rgba(13, 148, 136, 0.5); border-radius: 4px; }
::-webkit-scrollbar-thumb:hover { background: rgba(13, 148, 136, 0.8); }

/* Focus Visible */
input:focus-visible, button:focus-visible {
    outline: 2px solid rgba(13, 148, 136, 0.8);
    outline-offset: 2px;
}

/* Extra Small Devices */
@media (max-width: 475px) {
    .fixed.top-3.left-3 {
        top: 2px;
        left: 2px;
    }

    .fixed.top-3.left-3 img {
        height: 1.75rem;
    }
}

/* Landscape Mode on Mobile */
@media (max-height: 600px) and (orientation: landscape) {
    .relative.z-10 {
        padding-top: 4rem;
    }

    .text-center.mb-6 {
        margin-bottom: 1rem;
    }

    .w-16.h-16 {
        width: 3rem;
        height: 3rem;
    }
}
</style>
@endsection
