@extends('layouts.app')
@section('title', 'Lupa Password')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4 bg-gradient-to-br from-blue-50 via-sky-100 to-indigo-50">
    <div class="w-full max-w-md">
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="w-16 h-16 gradient-primary rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg">
                <i class="bi bi-shield-lock text-3xl text-white"></i>
            </div>
            <h2 class="text-2xl font-bold text-gray-900 mb-2">Lupa Password?</h2>
            <p class="text-gray-600 text-sm">Ajukan permintaan reset password, admin akan memverifikasi</p>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-200">
            @if(session('success'))
            <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-xl">
                <p class="text-sm font-semibold text-green-700 flex items-center gap-2">
                    <i class="bi bi-check-circle"></i> {{ session('success') }}
                </p>
            </div>
            @endif

            @if(session('info'))
            <div class="mb-4 p-4 bg-blue-50 border border-blue-200 rounded-xl">
                <p class="text-sm font-semibold text-blue-700 flex items-center gap-2">
                    <i class="bi bi-info-circle"></i> {{ session('info') }}
                </p>
            </div>
            @endif

            @if($errors->any())
            <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-xl">
                <p class="text-sm font-semibold text-red-700">{{ $errors->first() }}</p>
            </div>
            @endif

            <form action="{{ route('password.submit') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Email Terdaftar <span class="text-red-500">*</span>
                    </label>
                    <input type="email" name="email" value="{{ old('email') }}"
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-xl focus:outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20"
                        placeholder="contoh@email.com" required>
                </div>

                <div class="mb-4 p-3 bg-yellow-50 border border-yellow-200 rounded-xl">
                    <p class="text-xs text-yellow-800">
                        <i class="bi bi-info-circle mr-1"></i>
                        <strong>Proses Reset Password:</strong>
                        <ol class="list-decimal list-inside mt-1 space-y-1">
                            <li>Ajukan permintaan reset</li>
                            <li>Hubungi admin untuk verifikasi (telepon/WA)</li>
                            <li>Admin akan memberikan temporary password</li>
                            <li>Login dengan temporary password</li>
                            <li>Ganti password Anda</li>
                        </ol>
                    </p>
                </div>

                <button type="submit" class="w-full gradient-primary text-white font-semibold py-3 rounded-xl shadow hover:shadow-lg transition-all">
                    Ajukan Reset Password
                </button>
            </form>

            <div class="mt-6 text-center text-sm">
    <a href="{{ route('login') }}" class="text-primary-600 hover:underline font-medium">← Kembali ke Login</a>
    <span class="mx-2 text-gray-400">|</span>
    <a href="{{ route('password.status') }}" class="text-primary-600 hover:underline font-medium">Cek Status Reset</a>
</div>
        </div>
    </div>
</div>
@endsection
