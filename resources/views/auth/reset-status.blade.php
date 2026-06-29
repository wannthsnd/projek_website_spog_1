@extends('layouts.app')
@section('title', 'Status Reset Password')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4 bg-gradient-to-br from-sky-100 via-blue-100/70 to-indigo-100/50">
    <div class="w-full max-w-lg">
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="w-16 h-16 gradient-primary rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg">
                <i class="bi bi-key text-3xl text-white"></i>
            </div>
            <h2 class="text-2xl font-bold text-gray-900 mb-2">Status Reset Password</h2>
            <p class="text-gray-600 text-sm">Cek status permintaan reset password Anda</p>
        </div>

        <!-- Check Form -->
        <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-200 mb-6">
            <form id="checkStatusForm">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Email Terdaftar
                    </label>
                    <input type="email" name="email" id="checkEmail"
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-xl focus:outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 text-gray-900 font-medium placeholder-gray-400"
                        placeholder="contoh@email.com" required autocomplete="email">
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit" id="checkStatusBtn"
                    class="w-full gradient-primary text-white font-semibold py-3 rounded-xl shadow hover:shadow-lg hover:scale-105 transition-all duration-300 flex items-center justify-center gap-2">
                    <i class="bi bi-search"></i>
                    <span>Cek Status</span>
                </button>
            </form>
        </div>

        <!-- Loading State (Hidden by default) -->
        <div id="loadingState" class="hidden bg-white rounded-2xl shadow-lg p-6 border border-gray-200 mb-6 text-center">
            <div class="flex flex-col items-center gap-3">
                <div class="w-10 h-10 border-4 border-primary-300 border-t-primary-600 rounded-full animate-spin"></div>
                <p class="text-gray-600 font-medium">Memeriksa status...</p>
            </div>
        </div>

        <!-- Status Result (Hidden by default) -->
        <div id="statusResult" class="hidden bg-white rounded-2xl shadow-lg p-6 border border-gray-200">
            <!-- Status Badge -->
            <div class="mb-6 text-center">
                <div id="statusBadge" class="inline-flex items-center gap-2 px-4 py-2 rounded-full font-bold text-sm">
                    <!-- Dynamic content -->
                </div>
            </div>

            <!-- Temporary Password (Shown when approved) -->
            <div id="passwordSection" class="hidden mb-6">
                <div class="p-4 bg-green-50 border-2 border-green-300 rounded-xl">
                    <p class="text-sm font-semibold text-green-800 mb-2 flex items-center gap-2">
                        <i class="bi bi-check-circle"></i>
                        Request Disetujui!
                    </p>
                    <p class="text-xs text-green-700 mb-3">
                        Temporary Password Anda:
                    </p>
                    <div class="flex items-center gap-2">
                        <input type="text" id="temporaryPassword" readonly
                            class="flex-1 px-4 py-3 bg-white border-2 border-green-400 rounded-xl text-center text-2xl font-mono font-bold text-green-700 tracking-wider"
                            placeholder="••••••••">
                        <button onclick="copyPassword()"
                            class="px-4 py-3 bg-green-600 text-white rounded-xl font-semibold hover:bg-green-700 transition-colors shadow-md"
                            title="Salin Password" id="copyBtn">
                            <i class="bi bi-clipboard"></i>
                        </button>
                    </div>
                    <p class="text-xs text-green-600 mt-2 flex items-center gap-1">
                        <i class="bi bi-info-circle"></i>
                        Klik tombol salin untuk menyalin password
                    </p>
                </div>

                <!-- Auto Login Form -->
                <div class="mt-4">
                    <form action="{{ route('login.temporary') }}" method="POST" id="autoLoginForm">
                        @csrf
                        <input type="hidden" name="email" id="autoLoginEmail" value="">
                        <input type="hidden" name="temporary_password" id="autoLoginPassword" value="">
                        <button type="submit"
                            class="w-full block text-center gradient-primary text-white font-semibold py-3 rounded-xl shadow hover:shadow-lg hover:scale-105 transition-all duration-300 flex items-center justify-center gap-2">
                            <i class="bi bi-box-arrow-in-right"></i>
                            <span>Login Otomatis Sekarang</span>
                        </button>
                    </form>
                    <p class="text-xs text-center text-gray-500 mt-2">
                        <i class="bi bi-info-circle mr-1"></i>
                        Klik tombol di atas untuk login otomatis dengan temporary password
                    </p>
                </div>
            </div>

            <!-- Info Section -->
            <div class="space-y-3 text-sm border-t border-gray-200 pt-4">
                <div class="flex justify-between py-2">
                    <span class="text-gray-600">Diajukan:</span>
                    <span class="font-semibold text-gray-900" id="createdAt">-</span>
                </div>
                <div class="flex justify-between py-2">
                    <span class="text-gray-600">Kadaluarsa:</span>
                    <span class="font-semibold text-gray-900" id="expiresAt">-</span>
                </div>
                <div class="flex justify-between py-2" id="verifierRow" style="display: none;">
                    <span class="text-gray-600">Diverifikasi oleh:</span>
                    <span class="font-semibold text-gray-900" id="verifiedBy">-</span>
                </div>
            </div>

            <!-- Admin Notes -->
            <div id="adminNotesSection" class="hidden mt-4 p-3 bg-blue-50 border border-blue-200 rounded-xl">
                <p class="text-xs font-semibold text-blue-800 mb-1 flex items-center gap-1">
                    <i class="bi bi-chat-left-text"></i>
                    Catatan Admin:
                </p>
                <p class="text-sm text-blue-700" id="adminNotes">-</p>
            </div>

            <!-- Refresh Button -->
            <div class="mt-6 text-center pt-4 border-t border-gray-200">
                <button onclick="checkStatus()" id="refreshBtn"
                    class="inline-flex items-center gap-2 text-primary-600 hover:text-primary-700 font-semibold text-sm transition-colors">
                    <i class="bi bi-arrow-clockwise"></i>
                    <span>Refresh Status</span>
                </button>
                <p id="autoRefreshText" class="text-xs text-gray-400 mt-2 hidden">
                    Auto-refresh dalam <span id="countdown">30</span> detik...
                </p>
            </div>
        </div>

        <!-- Back to Login -->
        <div class="text-center text-sm mt-6">
            <a href="{{ route('login') }}" class="text-primary-600 hover:text-primary-700 font-semibold hover:underline">
                ← Kembali ke Login
            </a>
            <span class="mx-2 text-gray-300">|</span>
            <a href="{{ route('password.request') }}" class="text-primary-600 hover:text-primary-700 font-semibold hover:underline">
                Ajukan Reset Baru
            </a>
        </div>
    </div>
</div>

<script>
let currentEmail = '';
let autoRefreshTimer = null;
let countdown = 30;

// Handle form submission
document.getElementById('checkStatusForm').addEventListener('submit', function(e) {
    e.preventDefault();
    checkStatus();
});

// Main function to check status
function checkStatus() {
    const email = document.getElementById('checkEmail').value;

    if (!email) {
        alert('Silakan masukkan email Anda');
        return;
    }

    currentEmail = email;

    // Show loading, hide result
    document.getElementById('checkStatusBtn').disabled = true;
    document.getElementById('checkStatusBtn').innerHTML = '<i class="bi bi-hourglass-split"></i> Memeriksa...';
    document.getElementById('loadingState').classList.remove('hidden');
    document.getElementById('statusResult').classList.add('hidden');

    // Clear auto-refresh if running
    if (autoRefreshTimer) {
        clearTimeout(autoRefreshTimer);
        autoRefreshTimer = null;
    }

    fetch('{{ route("password.check-status") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ email: email })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        // Hide loading
        document.getElementById('loadingState').classList.add('hidden');
        document.getElementById('checkStatusBtn').disabled = false;
        document.getElementById('checkStatusBtn').innerHTML = '<i class="bi bi-search"></i> <span>Cek Status</span>';

        if (data.error) {
            alert(data.error);
            return;
        }

        // Show result
        document.getElementById('statusResult').classList.remove('hidden');
        updateStatusDisplay(data);
    })
    .catch(error => {
        console.error('Error:', error);
        document.getElementById('loadingState').classList.add('hidden');
        document.getElementById('checkStatusBtn').disabled = false;
        document.getElementById('checkStatusBtn').innerHTML = '<i class="bi bi-search"></i> <span>Cek Status</span>';
        alert('Terjadi kesalahan koneksi. Silakan coba lagi.');
    });
}

// Update display based on status
function updateStatusDisplay(data) {
    const statusBadge = document.getElementById('statusBadge');
    const passwordSection = document.getElementById('passwordSection');
    const adminNotesSection = document.getElementById('adminNotesSection');
    const autoRefreshText = document.getElementById('autoRefreshText');

    // Reset sections
    passwordSection.classList.add('hidden');
    adminNotesSection.classList.add('hidden');
    autoRefreshText.classList.add('hidden');

    // Update status badge based on status
    let statusHtml = '';
    switch(data.status) {
        case 'pending':
            statusHtml = '<span class="bg-yellow-100 text-yellow-800 px-4 py-2 rounded-full flex items-center gap-2"><i class="bi bi-clock"></i>Menunggu Persetujuan Admin</span>';
            // Start auto-refresh for pending status
            if (!data.is_expired) {
                startAutoRefresh();
            }
            break;
        case 'approved':
            statusHtml = '<span class="bg-green-100 text-green-800 px-4 py-2 rounded-full flex items-center gap-2"><i class="bi bi-check-circle"></i>Disetujui</span>';
            passwordSection.classList.remove('hidden');

            // Set temporary password value
            const tempPassword = data.temporary_password || '';
            document.getElementById('temporaryPassword').value = tempPassword;

            // Auto-fill login form
            document.getElementById('autoLoginEmail').value = currentEmail;
            document.getElementById('autoLoginPassword').value = tempPassword;

            // Show admin notes if exists
            if (data.admin_notes) {
                adminNotesSection.classList.remove('hidden');
                document.getElementById('adminNotes').textContent = data.admin_notes;
            }
            break;
        case 'completed':
            statusHtml = '<span class="bg-blue-100 text-blue-800 px-4 py-2 rounded-full flex items-center gap-2"><i class="bi bi-check-circle"></i>Password Sudah Diganti</span>';
            break;
        case 'rejected':
            statusHtml = '<span class="bg-red-100 text-red-800 px-4 py-2 rounded-full flex items-center gap-2"><i class="bi bi-x-circle"></i>Ditolak</span>';
            if (data.admin_notes) {
                adminNotesSection.classList.remove('hidden');
                document.getElementById('adminNotes').textContent = data.admin_notes;
            }
            break;
        case 'not_found':
            statusHtml = '<span class="bg-gray-100 text-gray-800 px-4 py-2 rounded-full flex items-center gap-2"><i class="bi bi-question-circle"></i>Tidak Ditemukan</span>';
            break;
        default:
            statusHtml = '<span class="bg-gray-100 text-gray-800 px-4 py-2 rounded-full">Status Tidak Diketahui</span>';
    }
    statusBadge.innerHTML = statusHtml;

    // Update info fields
    document.getElementById('createdAt').textContent = data.created_at || '-';
    document.getElementById('expiresAt').textContent = data.expires_at || '-';

    // Update verifier info
    const verifierRow = document.getElementById('verifierRow');
    if (data.verified_by) {
        document.getElementById('verifiedBy').textContent = data.verified_by;
        verifierRow.style.display = 'flex';
    } else {
        verifierRow.style.display = 'none';
    }

    // Show expired warning if applicable
    if (data.is_expired && data.status !== 'completed') {
        const expiredWarning = document.createElement('div');
        expiredWarning.className = 'mt-4 p-3 bg-red-50 border border-red-200 rounded-xl text-red-700 text-sm';
        expiredWarning.innerHTML = '<i class="bi bi-exclamation-triangle mr-1"></i>Request ini sudah kadaluarsa. Silakan ajukan permintaan reset password baru.';

        // Remove existing warning if any
        const existingWarning = document.getElementById('expiredWarning');
        if (existingWarning) existingWarning.remove();

        expiredWarning.id = 'expiredWarning';
        statusBadge.parentNode.appendChild(expiredWarning);
    }
}

// Start auto-refresh for pending status
function startAutoRefresh() {
    countdown = 30;
    const autoRefreshText = document.getElementById('autoRefreshText');
    const countdownEl = document.getElementById('countdown');

    autoRefreshText.classList.remove('hidden');

    autoRefreshTimer = setInterval(() => {
        countdown--;
        countdownEl.textContent = countdown;

        if (countdown <= 0) {
            clearInterval(autoRefreshTimer);
            checkStatus(); // Auto refresh
        }
    }, 1000);
}

// Copy password to clipboard
function copyPassword() {
    const passwordInput = document.getElementById('temporaryPassword');
    const copyBtn = document.getElementById('copyBtn');

    if (!passwordInput.value) {
        alert('Tidak ada password untuk disalin');
        return;
    }

    // Select and copy
    passwordInput.select();
    passwordInput.setSelectionRange(0, 99999); // For mobile

    navigator.clipboard.writeText(passwordInput.value).then(() => {
        // Show success feedback
        const originalHTML = copyBtn.innerHTML;
        copyBtn.innerHTML = '<i class="bi bi-check-lg"></i>';
        copyBtn.classList.remove('bg-green-600');
        copyBtn.classList.add('bg-blue-600');

        setTimeout(() => {
            copyBtn.innerHTML = originalHTML;
            copyBtn.classList.remove('bg-blue-600');
            copyBtn.classList.add('bg-green-600');
        }, 2000);
    }).catch(err => {
        // Fallback for older browsers
        document.execCommand('copy');
        const originalHTML = copyBtn.innerHTML;
        copyBtn.innerHTML = '<i class="bi bi-check-lg"></i>';
        setTimeout(() => {
            copyBtn.innerHTML = originalHTML;
        }, 2000);
    });
}

// Auto-check if email is in URL parameter
window.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const email = urlParams.get('email');

    if (email) {
        document.getElementById('checkEmail').value = email;
        // Auto-check after a short delay
        setTimeout(() => {
            checkStatus();
        }, 500);
    }

    // Show session messages
    @if(session('success'))
        const successMsg = document.createElement('div');
        successMsg.className = 'fixed top-20 right-4 z-50 max-w-md animate-fade-in-up';
        successMsg.innerHTML = `
            <div class="bg-gradient-to-r from-green-500 to-emerald-600 text-white px-5 py-3.5 rounded-2xl shadow-lg flex items-center gap-3">
                <i class="bi bi-check-circle text-lg"></i>
                <div>
                    <p class="font-bold text-sm">Berhasil!</p>
                    <p class="text-xs opacity-90">{{ session('success') }}</p>
                </div>
            </div>
        `;
        document.body.appendChild(successMsg);
        setTimeout(() => successMsg.remove(), 5000);
    @endif

    @if(session('info'))
        const infoMsg = document.createElement('div');
        infoMsg.className = 'fixed top-20 right-4 z-50 max-w-md animate-fade-in-up';
        infoMsg.innerHTML = `
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white px-5 py-3.5 rounded-2xl shadow-lg flex items-center gap-3">
                <i class="bi bi-info-circle text-lg"></i>
                <div>
                    <p class="font-bold text-sm">Info</p>
                    <p class="text-xs opacity-90">{{ session('info') }}</p>
                </div>
            </div>
        `;
        document.body.appendChild(infoMsg);
        setTimeout(() => infoMsg.remove(), 5000);
    @endif
});

// Cleanup on page unload
window.addEventListener('beforeunload', function() {
    if (autoRefreshTimer) {
        clearInterval(autoRefreshTimer);
    }
});
</script>
@endsection
