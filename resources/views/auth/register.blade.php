@extends('layouts.app')
@section('title', 'Daftar Akun - SPOG KAPAL')

@section('content')
<div class="min-h-screen flex items-center justify-center py-8 px-4 sm:px-6 lg:px-8 relative overflow-hidden bg-animated">

    <!-- Animated Background Elements (Sama dengan Login) -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-20 left-20 w-72 h-72 bg-yellow-400/10 rounded-full blur-3xl animate-float"></div>
        <div class="absolute bottom-20 right-20 w-96 h-96 bg-blue-400/10 rounded-full blur-3xl animate-float-delayed"></div>
        <div class="absolute top-1/2 left-1/3 w-48 h-48 bg-amber-300/10 rounded-full blur-2xl animate-pulse-slow"></div>
        <div class="particle w-2 h-2 top-1/4 left-1/4"></div>
        <div class="particle w-4 h-4 top-3/4 left-3/4"></div>
        <div class="particle w-6 h-6 top-1/2 left-1/4"></div>
        <div class="particle w-3 h-3 top-1/4 right-1/4"></div>
    </div>

    <div class="relative z-10 w-full max-w-lg mx-auto">

        <!-- Logo & Brand Header -->
        <div class="text-center mb-6">
            <div class="inline-flex items-center justify-center relative mb-4">
                <div class="absolute inset-0 gradient-primary rounded-2xl blur-lg opacity-50 logo-pulse"></div>
                <div class="relative w-16 h-16 gradient-primary rounded-2xl flex items-center justify-center shadow-2xl">
                    <i class="bi bi-person-plus text-3xl text-white"></i>
                </div>
                <div class="absolute -top-1 -right-1 w-3 h-3 bg-green-400 rounded-full border-2 border-white animate-pulse"></div>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold mb-2">
                <span class="bg-gradient-to-r from-white via-yellow-200 to-white bg-clip-text text-transparent">
                    Daftar Akun Baru
                </span>
            </h1>
            <p class="text-blue-200/90 text-sm font-medium">Bergabung dengan SPOG KAPAL DAN CVS</p>
        </div>

        <!-- Premium Registration Card - RESPONSIVE -->
        <div class="glass-card rounded-3xl p-6 sm:p-8 w-full max-h-[calc(100vh-200px)] overflow-y-auto">

            <!-- Form Header -->
            <div class="text-center mb-6 pb-4 border-b border-gray-200">
                <h2 class="text-xl font-bold text-gray-900 mb-1">
                    Buat Akun Anda 🚀
                </h2>
                <p class="text-gray-500 text-sm">Lengkapi data berikut untuk mulai mengajukan permohonan</p>
            </div>

            <!-- Alert Messages -->
            @if($errors->any())
            <div class="bg-red-50/80 border border-red-200 rounded-xl p-4 mb-5 flex items-start gap-3">
                <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <i class="bi bi-exclamation-triangle text-red-600"></i>
                </div>
                <p class="text-red-700 text-sm font-medium">{{ $errors->first() }}</p>
            </div>
            @endif

            <!-- Registration Form -->
            <form method="POST" action="{{ route('register.post') }}" class="space-y-5">
                @csrf

                <!-- Name Field -->
                <div class="group">
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-2 ml-1">
                        <i class="bi bi-person-fill text-amber-500 mr-2"></i>Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <input id="name" name="name" type="text" required value="{{ old('name') }}"
                           placeholder="Masukkan nama lengkap Anda"
                           class="input-glow w-full px-4 py-3.5 bg-gray-50/80 border-2 border-gray-200 rounded-xl focus:outline-none transition-all text-gray-900 placeholder-gray-400 text-sm @error('name') border-red-500 @enderror">
                    @error('name') <p class="text-red-500 text-xs mt-1.5 ml-1 font-medium">{{ $message }}</p> @enderror
                </div>

                <!-- Email Field -->
                <div class="group">
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-2 ml-1">
                        <i class="bi bi-envelope-fill text-amber-500 mr-2"></i>Alamat Email <span class="text-red-500">*</span>
                    </label>
                    <input id="email" name="email" type="email" required value="{{ old('email') }}"
                           placeholder="contoh@email.com"
                           class="input-glow w-full px-4 py-3.5 bg-gray-50/80 border-2 border-gray-200 rounded-xl focus:outline-none transition-all text-gray-900 placeholder-gray-400 text-sm @error('email') border-red-500 @enderror">
                    @error('email') <p class="text-red-500 text-xs mt-1.5 ml-1 font-medium">{{ $message }}</p> @enderror
                </div>

                <!-- ✅ UPT Selector - Enhanced Styling -->
                <div class="group">
                    <label for="upt_id" class="block text-sm font-semibold text-gray-700 mb-2 ml-1">
                        <i class="bi bi-building-fill text-amber-500 mr-2"></i>Unit Pelaksana Teknis (UPT) <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <select id="upt_id" name="upt_id" required
                                class="input-glow w-full px-4 py-3.5 bg-gray-50/80 border-2 border-gray-200 rounded-xl focus:outline-none transition-all text-gray-900 text-sm appearance-none cursor-pointer @error('upt_id') border-red-500 @enderror">
                            <option value="">Pilih UPT sesuai daerah Anda...</option>
                            @foreach($upts as $upt)
                            <option value="{{ $upt->id }}" {{ old('upt_id') == $upt->id ? 'selected' : '' }}>
                                {{ $upt->name }} ({{ $upt->code }}) - {{ $upt->region ?? 'Regional' }}
                            </option>
                            @endforeach
                        </select>
                        <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-gray-400">
                            <i class="bi bi-chevron-down"></i>
                        </div>
                    </div>
                    @error('upt_id') <p class="text-red-500 text-xs mt-1.5 ml-1 font-medium">{{ $message }}</p> @enderror
                    <p class="text-xs text-gray-500 mt-2 ml-1">
                        <i class="bi bi-info-circle mr-1"></i>
                        Pilih UPT yang menangani wilayah domisili atau operasional kapal Anda
                    </p>
                </div>

                <!-- Password Field with Strength -->
                <div class="group">
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-2 ml-1">
                        <i class="bi bi-lock-fill text-amber-500 mr-2"></i>Password <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input id="password" name="password" type="password" required minlength="8"
                               placeholder="Minimal 8 karakter"
                               class="input-glow w-full px-4 py-3.5 bg-gray-50/80 border-2 border-gray-200 rounded-xl focus:outline-none transition-all text-gray-900 placeholder-gray-400 text-sm @error('password') border-red-500 @enderror"
                               oninput="checkPasswordStrength(this.value)">
                        <button type="button" onclick="togglePassword('password', 'toggleIcon1')"
                            class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-amber-500 transition-colors">
                            <i class="bi bi-eye" id="toggleIcon1"></i>
                        </button>
                    </div>
                    <!-- Password Strength Indicator -->
                    <div class="mt-2 ml-1">
                        <div class="flex gap-1 mb-1">
                            <div class="h-1 flex-1 bg-gray-200 rounded-full overflow-hidden">
                                <div id="strengthBar" class="h-full w-0 bg-gradient-to-r from-red-400 via-yellow-400 to-green-400 transition-all duration-300"></div>
                            </div>
                        </div>
                        <p id="strengthText" class="text-xs text-gray-500">Kekuatan password: <span class="font-medium">-</span></p>
                    </div>
                    @error('password') <p class="text-red-500 text-xs mt-1.5 ml-1 font-medium">{{ $message }}</p> @enderror
                </div>

                <!-- Confirm Password Field -->
                <div class="group">
                    <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2 ml-1">
                        <i class="bi bi-lock-fill text-amber-500 mr-2"></i>Konfirmasi Password <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input id="password_confirmation" name="password_confirmation" type="password" required minlength="8"
                               placeholder="Ulangi password Anda"
                               class="input-glow w-full px-4 py-3.5 bg-gray-50/80 border-2 border-gray-200 rounded-xl focus:outline-none transition-all text-gray-900 placeholder-gray-400 text-sm"
                               oninput="checkPasswordMatch(this.value)">
                        <button type="button" onclick="togglePassword('password_confirmation', 'toggleIcon2')"
                            class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-amber-500 transition-colors">
                            <i class="bi bi-eye" id="toggleIcon2"></i>
                        </button>
                    </div>
                    <p id="matchText" class="text-xs mt-1.5 ml-1"></p>
                </div>

                <!-- Terms & Conditions -->
                <div class="flex items-start gap-3 pt-2">
                    <input type="checkbox" id="terms" name="terms" required
                           class="w-4 h-4 rounded-lg border-gray-300 text-amber-500 focus:ring-amber-400 focus:ring-2 mt-1 cursor-pointer">
                    <label for="terms" class="text-sm text-gray-700 cursor-pointer select-none">
                        Saya menyetujui
                        <a href="#" class="text-amber-600 hover:text-amber-700 font-semibold hover:underline transition-colors">Syarat & Ketentuan</a>
                        serta
                        <a href="#" class="text-amber-600 hover:text-amber-700 font-semibold hover:underline transition-colors">Kebijakan Privasi</a>
                        SPOG KAPAL
                    </label>
                </div>
                @error('terms') <p class="text-red-500 text-xs -mt-2 ml-7">{{ $message }}</p> @enderror

                <!-- Premium Submit Button -->
                <button type="submit"
                        class="w-full gradient-primary text-gray-900 font-bold py-3.5 rounded-xl shadow-lg hover:shadow-2xl hover:scale-[1.02] transition-all duration-300 btn-shine flex items-center justify-center gap-2 text-base group mt-2">
                    <span class="group-hover:translate-x-1 transition-transform">Buat Akun Sekarang</span>
                    <i class="bi bi-arrow-right group-hover:translate-x-1 transition-transform"></i>
                </button>
            </form>

            <!-- Login Link -->
            <div class="text-center pt-5 mt-5 border-t border-gray-200">
                <p class="text-sm text-gray-600">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" class="text-amber-600 hover:text-amber-700 font-bold transition-colors hover:underline">
                        Masuk disini →
                    </a>
                </p>
            </div>
        </div>

        <!-- Info Card - Compact -->
        <div class="mt-6 bg-white/10 backdrop-blur-sm rounded-2xl p-4 border border-white/20">
            <div class="flex items-start gap-3">
                <div class="w-8 h-8 bg-amber-500/20 rounded-lg flex items-center justify-center flex-shrink-0">
                    <i class="bi bi-info-circle text-amber-300"></i>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-white mb-1">Penting!</h4>
                    <ul class="text-xs text-white/80 space-y-1">
                        <li class="flex items-start gap-2">
                            <i class="bi bi-check-circle text-amber-300 mt-0.5"></i>
                            <span>Pilih UPT sesuai wilayah operasional kapal</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="bi bi-check-circle text-amber-300 mt-0.5"></i>
                            <span>Permohonan diproses oleh admin UPT terpilih</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Back to Login -->
        <div class="text-center mt-6">
            <a href="{{ route('login') }}"
                class="inline-flex items-center gap-2 text-white/80 hover:text-white font-medium transition-all text-sm bg-white/10 hover:bg-white/20 px-5 py-2.5 rounded-full backdrop-blur-sm border border-white/20">
                <i class="bi bi-arrow-left"></i>
                <span>Kembali ke Login</span>
            </a>
        </div>

        <!-- Footer -->
        <div class="text-center mt-8 text-white/60 text-xs font-medium">
            <p>&copy; {{ date('Y') }} SPOG KAPAL DAN CVS</p>
            <p class="mt-1 text-white/40">Powered by Kemenhub RI</p>
        </div>
    </div>
</div>

<!-- Scripts -->
<script>
// Toggle Password Visibility
function togglePassword(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon = document.getElementById(iconId);
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.replace('bi-eye', 'bi-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.replace('bi-eye-slash', 'bi-eye');
    }
}

// Password Strength Checker
function checkPasswordStrength(password) {
    const strengthBar = document.getElementById('strengthBar');
    const strengthText = document.getElementById('strengthText');

    let strength = 0;
    if (password.length >= 8) strength++;
    if (password.match(/[a-z]/)) strength++;
    if (password.match(/[A-Z]/)) strength++;
    if (password.match(/[0-9]/)) strength++;
    if (password.match(/[^a-zA-Z0-9]/)) strength++;

    const widths = ['0%', '25%', '50%', '75%', '100%'];
    const colors = ['#ef4444', '#f97316', '#eab308', '#84cc16', '#22c55e'];
    const texts = ['Sangat Lemah', 'Lemah', 'Cukup', 'Kuat', 'Sangat Kuat'];

    strengthBar.style.width = widths[strength];
    strengthBar.style.background = `linear-gradient(to right, ${colors[strength]}, ${colors[strength]})`;
    strengthText.innerHTML = `Kekuatan password: <span class="font-medium" style="color: ${colors[strength]}">${texts[strength]}</span>`;
}

// Password Match Checker
function checkPasswordMatch(confirmPassword) {
    const password = document.getElementById('password').value;
    const matchText = document.getElementById('matchText');

    if (confirmPassword.length > 0) {
        if (password === confirmPassword) {
            matchText.textContent = '✓ Password cocok';
            matchText.className = 'text-xs mt-1.5 ml-1 text-green-600 font-medium';
        } else {
            matchText.textContent = '✗ Password tidak cocok';
            matchText.className = 'text-xs mt-1.5 ml-1 text-red-600 font-medium';
        }
    } else {
        matchText.textContent = '';
    }
}

// Enter key submit
document.addEventListener('DOMContentLoaded', function() {
    const inputs = document.querySelectorAll('input');
    inputs.forEach(input => {
        input.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                this.closest('form').requestSubmit();
            }
        });
    });
});
</script>

<!-- Custom Styles for Register Page -->
<style>
    /* Reuse styles from login page for consistency */
    .gradient-primary { background: linear-gradient(135deg, #FCD34D 0%, #F59E0B 50%, #D97706 100%); }
    .bg-animated {
        background: radial-gradient(ellipse at bottom, #1E3A8A 0%, #0C4A6E 50%, #0F172A 100%);
        background-size: 400% 400%;
        animation: gradientShift 15s ease infinite;
    }
    @keyframes gradientShift {
        0%, 100% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
    }
    .glass-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    }
    .particle {
        position: absolute;
        border-radius: 50%;
        background: rgba(252, 211, 77, 0.4);
        animation: float 6s ease-in-out infinite;
    }
    .particle:nth-child(2) { animation-delay: 1s; width: 4px; height: 4px; }
    .particle:nth-child(3) { animation-delay: 2s; width: 6px; height: 6px; }
    .particle:nth-child(4) { animation-delay: 3s; width: 3px; height: 3px; }
    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-20px); }
    }
    .input-glow:focus {
        box-shadow: 0 0 0 4px rgba(252, 211, 77, 0.2);
        border-color: #FCD34D;
    }
    .btn-shine {
        position: relative;
        overflow: hidden;
    }
    .btn-shine::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
        animation: shine 2s infinite;
    }
    @keyframes shine {
        0% { transform: translateX(-100%); }
        100% { transform: translateX(100%); }
    }
    .logo-pulse {
        animation: pulse-slow;
        box-shadow: 0 0 0 0 rgba(252, 211, 77, 0.7);
    }
    .logo-pulse:hover {
        animation: none;
        box-shadow: 0 0 0 10px rgba(252, 211, 77, 0);
    }
    @keyframes pulse-slow {
        0%, 100% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.05); opacity: 0.8; }
    }
    /* Custom select styling */
    select {
        background-image: none !important;
    }
</style>
@endsection
