<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 - Akses Ditolak</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-red-50 to-orange-50 min-h-screen flex items-center justify-center p-4">
    <div class="bg-white p-8 rounded-2xl shadow-2xl w-full max-w-md text-center">
        <div class="mb-6">
            <i class="bi bi-shield-lock text-8xl text-red-500"></i>
        </div>

        <h1 class="text-4xl font-bold text-gray-800 mb-2">403</h1>
        <h2 class="text-2xl font-semibold text-gray-700 mb-4">Akses Ditolak</h2>
        <p class="text-gray-600 mb-8">
            {{ $exception->getMessage() ?: 'Anda tidak memiliki izin untuk mengakses halaman ini.' }}
        </p>

        <div class="space-y-3">
            @auth
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}"
                        class="block w-full px-4 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold">
                        <i class="bi bi-house mr-2"></i>Kembali ke Dashboard Admin
                    </a>
                @else
                    <a href="{{ route('dashboard') }}"
                        class="block w-full px-4 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold">
                        <i class="bi bi-house mr-2"></i>Kembali ke Dashboard
                    </a>
                @endif
            @else
                <a href="{{ route('login') }}"
                    class="block w-full px-4 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold">
                    <i class="bi bi-box-arrow-in-right mr-2"></i>Login
                </a>
            @endauth

            <a href="{{ url('/') }}"
                class="block w-full px-4 py-3 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 font-semibold">
                <i class="bi bi-house-door mr-2"></i>Halaman Utama
            </a>
        </div>
    </div>
</body>
</html>
