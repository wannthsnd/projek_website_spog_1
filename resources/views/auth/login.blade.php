<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Login | SPOG KAPAL DAN CVS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Plus Jakarta Sans', 'sans-serif'] },
                    animation: {
                        'float': 'float 7s ease-in-out infinite',
                        'float-delayed': 'float 9s ease-in-out 3s infinite',
                        'pulse-soft': 'pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                        'shine': 'shine 3s linear infinite',
                        'wave': 'wave 12s ease-in-out infinite',
                        'fade-up': 'fadeUp 0.6s ease-out forwards',
                    },
                    keyframes: {
                        float: { '0%, 100%': { transform: 'translateY(0) rotate(0deg)' }, '50%': { transform: 'translateY(-12px) rotate(1.5deg)' } },
                        pulse: { '0%, 100%': { opacity: 0.5, transform: 'scale(1)' }, '50%': { opacity: 0.2, transform: 'scale(1.08)' } },
                        shine: { '0%': { transform: 'translateX(-100%)' }, '100%': { transform: 'translateX(100%)' } },
                        wave: { '0%, 100%': { transform: 'translateX(0)' }, '50%': { transform: 'translateX(-20%)' } },
                        fadeUp: { '0%': { opacity: 0, transform: 'translateY(20px)' }, '100%': { opacity: 1, transform: 'translateY(0)' } }
                    }
                }
            }
        }
    </script>
    <style>
        :root {
            --ocean-dark: #0b1f3a; --ocean-mid: #133a5c; --teal: #0d9488;
            --teal-light: #14b8a6; --gold: #fbbf24; --gold-soft: #fcd34d;
        }

        .bg-ocean {
            background: radial-gradient(ellipse at 20% 50%, #0f3460 0%, #0b1f3a 50%, #061526 100%);
            position: relative;
        }
        .bg-ocean::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at 80% 20%, rgba(13,148,136,0.25) 0%, transparent 50%),
                        radial-gradient(circle at 20% 80%, rgba(251,191,36,0.15) 0%, transparent 50%);
            pointer-events: none;
        }

        .glass {
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(24px) saturate(180%);
            -webkit-backdrop-filter: blur(24px) saturate(180%);
            border: 1px solid rgba(255, 255, 255, 0.6);
            box-shadow: 0 20px 50px -12px rgba(0, 0, 0, 0.15), 0 0 0 1px rgba(255,255,255,0.1);
        }

        .glass-dark {
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
        }

        .input-soft {
            background: rgba(241, 245, 249, 0.6);
            border: 1.5px solid rgba(226, 232, 240, 0.6);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .input-soft:focus {
            background: white;
            border-color: var(--teal);
            box-shadow: 0 0 0 4px rgba(13, 148, 136, 0.12), 0 4px 12px rgba(13, 148, 136, 0.08);
            transform: translateY(-1px);
        }

        .btn-maritime {
            background: linear-gradient(135deg, #0c2d48 0%, #0d9488 100%);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }
        .btn-maritime::before {
            content: '';
            position: absolute;
            top: 0; left: -100%;
            width: 100%; height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            animation: shine 3.5s infinite;
        }
        .btn-maritime:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 28px rgba(13, 148, 136, 0.35);
        }
        .btn-maritime:active { transform: translateY(-1px) scale(0.98); }

        .logo-float { animation: float 8s ease-in-out infinite; }
        .particle {
            position: absolute; border-radius: 50%;
            background: radial-gradient(circle, rgba(255,255,255,0.4), transparent 70%);
            animation: drift 25s ease-in-out infinite;
            opacity: 0.6; pointer-events: none;
        }
        @keyframes drift {
            0% { transform: translateY(100vh) rotate(0deg); opacity: 0; }
            10% { opacity: 0.5; }
            90% { opacity: 0.5; }
            100% { transform: translateY(-80px) rotate(360deg); opacity: 0; }
        }

        .wave-bottom {
            position: absolute; bottom: 0; left: 0; right: 0;
            height: 120px; opacity: 0.15;
            background: url("image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1440 120'%3E%3Cpath fill='%23ffffff' fill-opacity='0.5' d='M0,64L48,69.3C96,75,192,85,288,85.3C384,85,480,75,576,69.3C672,64,768,64,864,69.3C960,75,1056,85,1152,85.3C1248,85,1344,75,1392,69.3L1440,64L1440,120L1392,120C1344,120,1248,120,1152,120C1056,120,960,120,864,120C768,120,672,120,576,120C480,120,384,120,288,120C192,120,96,120,48,120L0,120Z'%3E%3C/path%3E%3C/svg%3E") no-repeat bottom;
            background-size: cover;
            animation: wave 14s ease-in-out infinite;
        }

        body { font-family: 'Plus Jakarta Sans', sans-serif; -webkit-font-smoothing: antialiased; }
        @media (max-width: 640px) { .particle { display: none; } input, button { font-size: 16px !important; } }
        .glass::-webkit-scrollbar { width: 5px; }
        .glass::-webkit-scrollbar-track { background: transparent; }
        .glass::-webkit-scrollbar-thumb { background: rgba(13,148,136,0.3); border-radius: 10px; }
    </style>
</head>
<body class="bg-ocean min-h-screen flex items-center justify-center p-4 relative overflow-hidden">

    <!-- Organic Background Elements -->
    <div class="absolute inset-0 pointer-events-none overflow-hidden">
        <div class="absolute top-1/4 left-1/4 w-64 h-64 sm:w-96 sm:h-96 bg-teal/20 rounded-full blur-3xl animate-pulse-soft"></div>
        <div class="absolute bottom-1/3 right-1/4 w-72 h-72 sm:w-[28rem] sm:h-[28rem] bg-blue-600/15 rounded-full blur-3xl animate-pulse-soft" style="animation-delay: 2s;"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-48 h-48 sm:w-80 sm:h-80 bg-gold/10 rounded-full blur-3xl animate-pulse-soft" style="animation-delay: 4s;"></div>
        <div id="particles" class="absolute inset-0"></div>
        <div class="wave-bottom"></div>
    </div>

    <!-- 🏛️ LOGO KEMENHUB & KPLP - Integrated & Elegant -->
    <div class="fixed top-4 left-4 sm:top-6 sm:left-6 z-30 animate-fade-up">
        <div class="glass-dark rounded-2xl px-4 py-3 flex items-center gap-4 group hover:bg-slate-800/70 transition-all duration-500">
            <!-- Kemenhub -->
            <div class="flex flex-col items-center gap-2 cursor-pointer">
                <div class="relative">
                    <div class="absolute inset-0 bg-gold/30 rounded-lg blur-md opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <img src="{{ asset('images/kemenhub.png') }}" alt="Kemenhub"
                         class="relative h-10 sm:h-11 w-auto filter drop-shadow-lg transition-transform duration-300 group-hover:scale-105 logo-float"
                         onerror="this.outerHTML='<div class=\'w-10 h-10 sm:w-11 sm:h-11 bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-lg flex items-center justify-center shadow-lg\'><i class=\'bi bi-building text-white\'></i></div>'">
                </div>
                <span class="text-white/90 font-semibold text-[10px] sm:text-xs text-center leading-tight tracking-wide">Kementerian<br>Perhubungan RI</span>
            </div>

            <!-- Divider -->
            <div class="w-px h-12 sm:h-14 bg-gradient-to-b from-transparent via-white/40 to-transparent"></div>

            <!-- KPLP -->
            <div class="flex flex-col items-center gap-2 cursor-pointer">
                <div class="relative">
                    <div class="absolute inset-0 bg-teal/30 rounded-lg blur-md opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <img src="{{ asset('images/kplp.png') }}" alt="KPLP"
                         class="relative h-10 sm:h-11 w-auto filter drop-shadow-lg transition-transform duration-300 group-hover:scale-105 logo-float" style="animation-delay: 1s;"
                         onerror="this.outerHTML='<div class=\'w-10 h-10 sm:w-11 sm:h-11 bg-gradient-to-br from-teal-400 to-teal-600 rounded-lg flex items-center justify-center shadow-lg\'><i class=\'bi bi-anchor text-white\'></i></div>'">
                </div>
                <span class="text-white/90 font-semibold text-[10px] sm:text-xs text-center leading-tight tracking-wide">Kesatuan Pengawasan Laut<br>dan Pelayaran</span>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="relative z-20 w-full max-w-sm sm:max-w-md mx-auto animate-fade-up" style="animation-delay: 0.2s;">

        <!-- Header Brand -->
        <div class="text-center mb-6 sm:mb-8">
            <div class="inline-flex items-center justify-center relative mb-4">
                <div class="absolute inset-0 bg-gradient-to-r from-teal-400/40 to-gold/30 rounded-3xl blur-2xl opacity-70 animate-pulse-soft"></div>
                <div class="relative w-16 h-16 sm:w-18 sm:h-18 bg-gradient-to-br from-slate-800 via-teal-800 to-slate-900 rounded-3xl flex items-center justify-center shadow-2xl border border-white/20 overflow-hidden">
                    <i class="bi bi-ship text-3xl sm:text-4xl text-white animate-float" style="animation-duration: 5s;"></i>
                    <div class="absolute inset-0 bg-gradient-to-tr from-transparent via-white/10 to-transparent"></div>
                </div>
                <div class="absolute -top-1 -right-1">
                    <div class="relative">
                        <div class="absolute inset-0 bg-green-400 rounded-full animate-ping opacity-70"></div>
                        <div class="relative w-3 h-3 bg-green-400 rounded-full border-2 border-slate-900"></div>
                    </div>
                </div>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight mb-1">
                SPOG KAPAL <span class="text-transparent bg-clip-text bg-gradient-to-r from-gold to-gold-light">CVS</span>
            </h1>
            <p class="text-teal-100/80 text-sm font-medium">Sistem Permohonan Olah Gerak Kapal</p>
        </div>

        <!-- Login Card - Organic & Rapih -->
        <div class="glass rounded-3xl overflow-hidden shadow-2xl">
            <!-- Card Header -->
            <div class="bg-gradient-to-r from-slate-50 to-teal-50/50 px-6 py-5 border-b border-gray-100/60">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-teal-500 to-teal-600 rounded-xl flex items-center justify-center shadow-md text-white">
                        <i class="bi bi-person-lock text-lg"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-gray-800">Login Akun</h2>
                        <p class="text-gray-500 text-xs">Masukkan kredensial Anda untuk melanjutkan</p>
                    </div>
                </div>
            </div>

            <!-- Card Body -->
            <div class="p-5 sm:p-6 max-h-[65vh] overflow-y-auto">
                <!-- Alerts -->
                @if($errors->any())
                <div class="bg-red-50/80 border-l-4 border-red-500 rounded-xl p-3.5 mb-5 flex items-start gap-3 animate-fade-up">
                    <i class="bi bi-exclamation-triangle text-red-500 text-lg mt-0.5"></i>
                    <p class="text-red-700 text-sm font-medium leading-relaxed">{{ $errors->first() }}</p>
                </div>
                @endif
                @if(session('success'))
                <div class="bg-green-50/80 border-l-4 border-green-500 rounded-xl p-3.5 mb-5 flex items-start gap-3 animate-fade-up">
                    <i class="bi bi-check-circle text-green-500 text-lg mt-0.5"></i>
                    <p class="text-green-700 text-sm font-medium leading-relaxed">{{ session('success') }}</p>
                </div>
                @endif

                <form action="{{ route('login.post') }}" method="POST" class="space-y-5">
                    @csrf

                    <!-- Email -->
                    <div class="group">
                        <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2 ml-1">
                            <i class="bi bi-envelope-fill text-teal mr-2"></i>Alamat Email
                        </label>
                        <div class="relative">
                            <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-teal transition-colors">
                                <i class="bi bi-envelope text-base"></i>
                            </div>
                            <input type="email" name="email" value="{{ old('email') }}"
                                class="input-soft w-full pl-11 pr-4 py-3.5 rounded-xl focus:outline-none text-gray-900 placeholder-gray-400 text-sm"
                                placeholder="nama@contoh.com" required autocomplete="email">
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="group">
                        <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2 ml-1">
                            <i class="bi bi-lock-fill text-teal mr-2"></i>Password
                        </label>
                        <div class="relative">
                            <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-teal transition-colors">
                                <i class="bi bi-lock text-base"></i>
                            </div>
                            <input type="password" name="password" id="password"
                                class="input-soft w-full pl-11 pr-11 py-3.5 rounded-xl focus:outline-none text-gray-900 placeholder-gray-400 text-sm"
                                placeholder="••••••••" required autocomplete="current-password">
                            <button type="button" onclick="togglePassword()"
                                class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-teal transition-all p-1.5 hover:bg-teal/5 rounded-lg">
                                <i class="bi bi-eye text-base" id="toggleIcon"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Options -->
                    <div class="flex items-center justify-between pt-1">
                        <label class="flex items-center gap-2.5 cursor-pointer select-none group">
                            <input type="checkbox" name="remember" class="w-4 h-4 rounded-md border-gray-300 text-teal focus:ring-2 focus:ring-teal/30 accent-teal transition-all">
                            <span class="text-gray-600 text-xs sm:text-sm font-medium group-hover:text-gray-800 transition-colors">Ingat saya</span>
                        </label>
                        <a href="{{ route('password.request') }}" class="text-teal hover:text-teal-dark font-semibold text-xs sm:text-sm hover:underline transition-colors">Lupa password?</a>
                    </div>

                    <!-- Submit -->
                    <button type="submit"
                        class="w-full btn-maritime text-white font-bold py-3.5 rounded-xl shadow-lg flex items-center justify-center gap-2 text-sm border border-teal/20 mt-2">
                        <i class="bi bi-shield-lock text-base"></i>
                        <span>Masuk ke Sistem</span>
                        <i class="bi bi-arrow-right text-base"></i>
                    </button>
                </form>

                <!-- Register -->
                <div class="text-center pt-5 mt-5 border-t border-gray-200/60">
                    <p class="text-xs sm:text-sm text-gray-600">
                        Belum punya akun?
                        <a href="{{ route('register') }}" class="text-teal hover:text-teal-dark font-bold hover:underline inline-flex items-center gap-1 transition-colors">
                            Daftar Sekarang <i class="bi bi-arrow-right text-xs"></i>
                        </a>
                    </p>
                </div>
            </div>
        </div>

        <!-- Back Button -->
        <div class="text-center mt-5 sm:mt-6 animate-fade-up" style="animation-delay: 0.4s;">
            <a href="{{ route('dashboard') }}"
                class="inline-flex items-center gap-2 text-white/80 hover:text-white font-medium transition-all duration-300 text-xs sm:text-sm glass-dark px-5 py-2.5 rounded-full hover:bg-slate-800/80 hover:scale-[1.02] active:scale-[0.98]">
                <i class="bi bi-arrow-left"></i>
                <span>Kembali ke Beranda</span>
            </a>
        </div>

        <!-- Footer -->
        <div class="text-center mt-6 text-white/50 text-[11px] sm:text-xs animate-fade-up" style="animation-delay: 0.5s;">
            <p class="font-medium">&copy; {{ date('Y') }} SPOG KAPAL DAN CVS</p>
            <p class="mt-0.5">Kementerian Perhubungan Republik Indonesia</p>
        </div>
    </div>

    <script>
        function togglePassword() {
            const input = document.getElementById('password'), icon = document.getElementById('toggleIcon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('bi-eye', 'bi-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.replace('bi-eye-slash', 'bi-eye');
            }
        }

        function createParticles() {
            const container = document.getElementById('particles');
            if (!container) return;
            const count = window.innerWidth < 640 ? 12 : window.innerWidth < 1024 ? 24 : 36;
            for (let i = 0; i < count; i++) {
                const p = document.createElement('div');
                const size = Math.random() * 2.5 + 1;
                p.className = 'particle';
                p.style.cssText = `width:${size}px;height:${size}px;left:${Math.random()*100}%;top:${Math.random()*100}%;animation-delay:${Math.random()*12}s;animation-duration:${18+Math.random()*15}s`;
                container.appendChild(p);
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            createParticles();
            document.querySelectorAll('input').forEach(input => {
                input.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') { e.preventDefault(); this.closest('form').requestSubmit(); }
                });
            });
        });
    </script>
</body>
</html>
