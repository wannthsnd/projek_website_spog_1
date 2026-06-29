<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | PNBP Maritime</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                    },
                    animation: {
                        'pulse-slow': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                        'float': 'float 6s ease-in-out infinite',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0px)' },
                            '50%': { transform: 'translateY(-20px)' },
                        }
                    }
                }
            }
        }
    </script>
    <style>
        .gradient-admin { background: linear-gradient(135deg, #3B82F6 0%, #1D4ED8 50%, #1E40AF 100%); }
        .glass-effect {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
        }
    </style>
</head>
<body class="font-sans bg-gradient-to-br from-slate-900 via-blue-900 to-slate-900 min-h-screen flex items-center justify-center p-4 relative overflow-hidden">
    <!-- Animated Background -->
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute top-10 left-10 w-96 h-96 bg-blue-500/10 rounded-full blur-3xl animate-float"></div>
        <div class="absolute bottom-10 right-10 w-96 h-96 bg-purple-500/10 rounded-full blur-3xl animate-float"></div>
        <div class="absolute top-1/2 left-1/2 w-80 h-80 bg-cyan-500/10 rounded-full blur-3xl animate-pulse-slow"></div>
    </div>

    <div class="relative z-10 w-full max-w-md">
        <!-- Logo & Title -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-20 h-20 gradient-admin rounded-3xl shadow-2xl mb-6 animate-float">
                <i class="bi bi-shield-lock text-4xl text-white"></i>
            </div>
            <h1 class="text-4xl font-bold text-white mb-2">Admin Panel</h1>
            <p class="text-blue-200">Panel Administrasi Sistem</p>
        </div>

        <!-- Login Card -->
        <div class="glass-effect rounded-3xl shadow-2xl p-8 md:p-10">
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-100 rounded-2xl mb-4">
                    <i class="bi bi-person-lock text-3xl text-blue-600"></i>
                </div>
                <h2 class="text-2xl font-bold text-gray-800 mb-2">Login Administrator</h2>
                <p class="text-gray-600">Masuk untuk mengelola sistem</p>
            </div>

            @if($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-lg">
                <div class="flex items-center gap-3">
                    <i class="bi bi-exclamation-triangle text-red-500 text-xl"></i>
                    <p class="text-red-700 text-sm">{{ $errors->first() }}</p>
                </div>
            </div>
            @endif

            @if(session('error'))
            <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-lg">
                <div class="flex items-center gap-3">
                    <i class="bi bi-exclamation-triangle text-red-500 text-xl"></i>
                    <p class="text-red-700 text-sm">{{ session('error') }}</p>
                </div>
            </div>
            @endif

            <form action="{{ route('admin.login.post') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="bi bi-envelope text-blue-500 mr-2"></i>Email Admin
                    </label>
                    <input type="email" name="email" value="{{ old('email') }}"
                        class="w-full px-5 py-4 bg-gray-50 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-blue-500 transition-all text-gray-800"
                        placeholder="admin@example.com" required>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="bi bi-lock text-blue-500 mr-2"></i>Password
                    </label>
                    <input type="password" name="password"
                        class="w-full px-5 py-4 bg-gray-50 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-blue-500 transition-all text-gray-800"
                        placeholder="••••••••" required>
                </div>

                <div class="flex items-center justify-between text-sm">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remember" class="w-4 h-4 rounded border-gray-300 text-blue-500 focus:ring-blue-500">
                        <span class="text-gray-600">Ingat saya</span>
                    </label>
                    <a href="#" class="text-blue-600 hover:text-blue-700 font-semibold">Bantuan?</a>
                </div>

                <button type="submit"
                    class="w-full gradient-admin text-white font-bold py-4 rounded-xl shadow-lg hover:shadow-xl hover:scale-105 transition-all duration-300 btn-shine">
                    <i class="bi bi-box-arrow-in-right mr-2"></i>Masuk sebagai Admin
                </button>
            </form>

            <div class="mt-8 pt-6 border-t border-gray-200 text-center">
                <a href="{{ route('dashboard') }}" class="text-blue-600 hover:text-blue-700 font-semibold text-sm">
                    <i class="bi bi-arrow-left mr-2"></i>Kembali ke Dashboard Utama
                </a>
            </div>
        </div>

        <!-- Security Notice -->
        <div class="mt-6 text-center">
            <div class="inline-flex items-center gap-2 px-4 py-2 bg-white/10 rounded-full backdrop-blur-sm">
                <i class="bi bi-shield-check text-green-400"></i>
                <span class="text-white/80 text-sm">Koneksi Aman & Terenkripsi</span>
            </div>
        </div>
    </div>

    <style>
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
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.5s;
        }
        .btn-shine:hover::after {
            left: 100%;
        }
    </style>
</body>
</html>
