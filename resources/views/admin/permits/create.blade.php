<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Permohonan - Admin Panel</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

    <style>
        :root {
            --primary: #3b82f6;
            --secondary: #8b5cf6;
            --success: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
            --info: #06b6d4;
            --light: #f8fafc;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
            --gray-400: #9ca3af;
            --gray-500: #6b7280;
            --gray-600: #4b5563;
            --gray-700: #374151;
            --gray-800: #1f2937;
            --dark: #111827;
            --gradient-primary: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%);
            --gradient-success: linear-gradient(135deg, #10b981 0%, #0ea5e9 100%);
            --gradient-warning: linear-gradient(135deg, #f59e0b 0%, #f97316 100%);
            --gradient-danger: linear-gradient(135deg, #ef4444 0%, #f97316 100%);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f8f9fa;
            color: var(--gray-800);
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            background: var(--gradient-primary);
            color: white;
            min-height: 100vh;
            position: fixed;
            width: 280px;
            transition: all 0.3s ease;
            box-shadow: 2px 0 15px rgba(0, 0, 0, 0.1);
        }

        .sidebar-header {
            padding: 25px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-header h4 {
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            font-size: 1.3rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sidebar-header i {
            font-size: 1.8rem;
        }

        .sidebar-menu {
            padding: 20px 0;
        }

        .sidebar-menu a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 15px 25px;
            transition: all 0.3s ease;
            font-weight: 500;
            font-size: 0.95rem;
        }

        .sidebar-menu a:hover, .sidebar-menu a.active {
            background: rgba(255, 255, 255, 0.15);
            border-left: 4px solid white;
            padding-left: 21px;
        }

        .sidebar-menu a i {
            margin-right: 12px;
            font-size: 1.1rem;
        }

        .sidebar-menu .logout-btn {
            color: #ff6b6b !important;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            margin-top: 20px;
            padding-top: 20px;
        }

        /* Content */
        .content {
            margin-left: 280px;
            padding: 30px;
        }

        .navbar {
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            padding: 15px 25px;
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar h5 {
            font-family: 'Montserrat', sans-serif;
            font-weight: 600;
            color: var(--gray-800);
        }

        .card {
            border-radius: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            border: none;
            margin-bottom: 25px;
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
        }

        .card-header {
            border-radius: 20px 20px 0 0 !important;
            border: none;
            padding: 20px 25px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            font-family: 'Montserrat', sans-serif;
            font-weight: 600;
            font-size: 1.2rem;
        }

        .card-body {
            padding: 25px;
        }

        /* Form Controls */
        .form-section {
            margin-bottom: 25px;
            padding: 20px;
            border-radius: 15px;
            background: var(--gray-100);
            border-left: 4px solid var(--primary);
            transition: all 0.3s ease;
        }

        .form-section:hover {
            background: white;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            transform: translateX(5px);
        }

        .form-section-title {
            font-family: 'Montserrat', sans-serif;
            font-weight: 600;
            font-size: 1.2rem;
            color: var(--primary);
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .form-section-title i {
            font-size: 1.4rem;
        }

        .form-section-description {
            font-size: 0.9rem;
            color: var(--gray-600);
            margin-bottom: 15px;
            line-height: 1.6;
        }

        .form-label {
            font-weight: 600;
            color: var(--gray-800);
            margin-bottom: 8px;
            display: block;
            font-size: 0.95rem;
        }

        .form-control, .form-select {
            border-radius: 10px;
            border: 2px solid var(--gray-300);
            padding: 12px 15px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            background: white;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
            background: white;
        }

        .form-control::placeholder {
            color: var(--gray-400);
        }

        textarea.form-control {
            resize: vertical;
            min-height: 100px;
        }

        .required::after {
            content: " *";
            color: var(--danger);
            font-weight: bold;
        }

        .btn-submit {
            width: 100%;
            padding: 16px;
            font-size: 1.1rem;
            font-weight: 700;
            border-radius: 15px;
            background: var(--gradient-primary);
            color: white;
            border: none;
            transition: all 0.3s ease;
            box-shadow: 0 6px 20px rgba(59, 130, 246, 0.4);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .btn-submit:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(59, 130, 246, 0.5);
            color: white;
        }

        .alert {
            border-radius: 12px;
            border: none;
            padding: 16px 20px;
            margin-bottom: 20px;
            font-family: 'Poppins', sans-serif;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        .alert-success {
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
            color: #065f46;
        }

        .alert-danger {
            background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
            color: #991b1b;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .sidebar {
                width: 250px;
            }
            .content {
                margin-left: 250px;
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                position: relative;
                min-height: auto;
            }
            .content {
                margin-left: 0;
            }
        }

        @media (max-width: 480px) {
            .content {
                padding: 15px;
            }
            .navbar {
                padding: 10px 15px;
            }
            .card-body {
                padding: 15px;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <h4><i class="bi bi-ship"></i> SPOG Admin</h4>
        </div>
        <div class="sidebar-menu">
            <a href="{{ route('admin.dashboard') }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
            <a href="{{ route('admin.permits') }}">
                <i class="bi bi-list-task"></i> Data Permohonan
            </a>
            <a href="{{ route('admin.permits.create') }}" class="active">
                <i class="bi bi-plus-circle"></i> Tambah Permohonan
            </a>
            <a href="{{ route('home') }}" target="_blank">
                <i class="bi bi-house-door"></i> Lihat Website
            </a>
            <a href="{{ route('admin.logout') }}" class="logout-btn">
                <i class="bi bi-box-arrow-right"></i> Logout
            </a>
        </div>
    </div>

    <!-- Content -->
    <div class="content">
        <!-- Navbar -->
        <div class="navbar">
            <h5><i class="bi bi-plus-circle"></i> Tambah Permohonan Baru</h5>
        </div>

        <!-- Alerts -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill"></i>
                <strong>Gagal!</strong>
                <ul class="mb-0 mt-2">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Form Card -->
        <div class="card">
            <div class="card-header">
                <i class="bi bi-file-earmark-plus"></i> Formulir Permohonan SPOG
            </div>
            <div class="card-body">
                <!-- ✅ Form Action yang Benar -->
                <form action="{{ route('admin.permits.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Identitas Pemohon -->
                    <div class="form-section">
                        <h5 class="form-section-title">
                            <i class="bi bi-person-badge"></i>
                            Identitas Pemohon
                        </h5>
                        <p class="form-section-description">
                            Masukkan informasi kontak Anda untuk komunikasi lebih lanjut
                        </p>

                        <div class="mb-3">
                            <label class="form-label required">Email</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email') }}" placeholder="contoh@email.com" required>
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Data Kapal -->
                    <div class="form-section">
                        <h5 class="form-section-title">
                            <i class="bi bi-ship"></i>
                            Data Kapal
                        </h5>
                        <p class="form-section-description">
                            Informasi lengkap mengenai kapal yang akan melakukan olah gerak
                        </p>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label required">Nama Kapal</label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                       value="{{ old('name') }}" placeholder="Contoh: KM. Sinar Jaya" required>
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label required">Jenis Kapal</label>
                                <input type="text" name="ship_type" class="form-control @error('ship_type') is-invalid @enderror"
                                       value="{{ old('ship_type') }}" placeholder="Contoh: Kapal Penumpang" required>
                                @error('ship_type')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label required">Jumlah Jiwa di Atas Kapal</label>
                                <input type="number" name="passenger_count" class="form-control @error('passenger_count') is-invalid @enderror"
                                       value="{{ old('passenger_count') }}" min="1" placeholder="Contoh: 50" required>
                                @error('passenger_count')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label required">Nama Nahkoda</label>
                                <input type="text" name="captain_name" class="form-control @error('captain_name') is-invalid @enderror"
                                       value="{{ old('captain_name') }}" placeholder="Contoh: Budi Santoso" required>
                                @error('captain_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label required">Milik / Agen</label>
                                <input type="text" name="owner_agent" class="form-control @error('owner_agent') is-invalid @enderror"
                                       value="{{ old('owner_agent') }}" placeholder="Contoh: PT. Samudra Jaya" required>
                                @error('owner_agent')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label required">Bergerak Dari</label>
                                <input type="text" name="departure_location" class="form-control @error('departure_location') is-invalid @enderror"
                                       value="{{ old('departure_location') }}" placeholder="Contoh: Pelabuhan Tanjung Priok" required>
                                @error('departure_location')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label required">Waktu Gerak</label>
                            <input type="text" name="movement_time" class="form-control @error('movement_time') is-invalid @enderror"
                                   value="{{ old('movement_time') }}" placeholder="Contoh: 08:00 WIB" required>
                            @error('movement_time')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label required">Keperluan</label>
                            <textarea name="purpose" class="form-control @error('purpose') is-invalid @enderror"
                                      rows="3" placeholder="Jelaskan tujuan olah gerak kapal..." required>{{ old('purpose') }}</textarea>
                            @error('purpose')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Dokumen Persyaratan -->
                    <div class="form-section">
                        <h5 class="form-section-title">
                            <i class="bi bi-files"></i>
                            Dokumen Persyaratan
                        </h5>
                        <p class="form-section-description">
                            Upload dokumen dalam format PDF dengan ukuran maksimal 10 MB per file
                        </p>

                        <!-- Dokumen 1 -->
                        <div class="mb-4">
                            <label class="form-label required">Dokumen 1: Surat Pernyataan Nahkoda Untuk Persetujuan Olah Gerak</label>
                            <div class="file-upload-container" onclick="document.getElementById('document_1').click()">
                                <i class="bi bi-cloud-upload file-upload-icon"></i>
                                <div class="file-upload-text">Klik untuk Upload File PDF</div>
                                <div class="file-upload-subtext">Maksimal 10 MB</div>
                                <input type="file" name="document_1" id="document_1" class="file-upload-input @error('document_1') is-invalid @enderror"
                                       accept=".pdf" required onchange="showFileName(this, 'file-name-1')">
                            </div>
                            <div id="file-name-1" class="mt-2 text-muted"></div>
                            @error('document_1')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Dokumen 2 -->
                        <div class="mb-4">
                            <label class="form-label required">Dokumen 2: Surat Pernyataan Nahkoda (Master Declaration)</label>
                            <div class="file-upload-container" onclick="document.getElementById('document_2').click()">
                                <i class="bi bi-cloud-upload file-upload-icon"></i>
                                <div class="file-upload-text">Klik untuk Upload File PDF</div>
                                <div class="file-upload-subtext">Maksimal 10 MB</div>
                                <input type="file" name="document_2" id="document_2" class="file-upload-input @error('document_2') is-invalid @enderror"
                                       accept=".pdf" required onchange="showFileName(this, 'file-name-2')">
                            </div>
                            <div id="file-name-2" class="mt-2 text-muted"></div>
                            @error('document_2')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Dokumen 3 -->
                        <div class="mb-4">
                            <label class="form-label required">Dokumen 3: Fotokopi Data Awak Kapal</label>
                            <div class="file-upload-container" onclick="document.getElementById('document_3').click()">
                                <i class="bi bi-cloud-upload file-upload-icon"></i>
                                <div class="file-upload-text">Klik untuk Upload File PDF</div>
                                <div class="file-upload-subtext">Maksimal 10 MB</div>
                                <input type="file" name="document_3" id="document_3" class="file-upload-input @error('document_3') is-invalid @enderror"
                                       accept=".pdf" required onchange="showFileName(this, 'file-name-3')">
                            </div>
                            <div id="file-name-3" class="mt-2 text-muted"></div>
                            @error('document_3')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Dokumen 4 -->
                        <div class="mb-4">
                            <label class="form-label required">Dokumen 4: Surat dan Dokumen Kapal Asli</label>
                            <div class="file-upload-container" onclick="document.getElementById('document_4').click()">
                                <i class="bi bi-cloud-upload file-upload-icon"></i>
                                <div class="file-upload-text">Klik untuk Upload File PDF</div>
                                <div class="file-upload-subtext">Maksimal 10 MB</div>
                                <input type="file" name="document_4" id="document_4" class="file-upload-input @error('document_4') is-invalid @enderror"
                                       accept=".pdf" required onchange="showFileName(this, 'file-name-4')">
                            </div>
                            <div id="file-name-4" class="mt-2 text-muted"></div>
                            @error('document_4')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Dokumen 5 -->
                        <div class="mb-4">
                            <label class="form-label required">Dokumen 5: Daftar Penumpang (Manifest)</label>
                            <div class="file-upload-container" onclick="document.getElementById('document_5').click()">
                                <i class="bi bi-cloud-upload file-upload-icon"></i>
                                <div class="file-upload-text">Klik untuk Upload File PDF</div>
                                <div class="file-upload-subtext">Maksimal 10 MB</div>
                                <input type="file" name="document_5" id="document_5" class="file-upload-input @error('document_5') is-invalid @enderror"
                                       accept=".pdf" required onchange="showFileName(this, 'file-name-5')">
                            </div>
                            <div id="file-name-5" class="mt-2 text-muted"></div>
                            @error('document_5')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Dokumen 6 -->
                        <div class="mb-4">
                            <label class="form-label required">Dokumen 6: Daftar Muatan (Manifest)</label>
                            <div class="file-upload-container" onclick="document.getElementById('document_6').click()">
                                <i class="bi bi-cloud-upload file-upload-icon"></i>
                                <div class="file-upload-text">Klik untuk Upload File PDF</div>
                                <div class="file-upload-subtext">Maksimal 10 MB</div>
                                <input type="file" name="document_6" id="document_6" class="file-upload-input @error('document_6') is-invalid @enderror"
                                       accept=".pdf" required onchange="showFileName(this, 'file-name-6')">
                            </div>
                            <div id="file-name-6" class="mt-2 text-muted"></div>
                            @error('document_6')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Dokumen 7 -->
                        <div class="mb-4">
                            <label class="form-label required">Dokumen 7: SPOG Diberikan Kepada Kapal</label>
                            <div class="file-upload-container" onclick="document.getElementById('document_7').click()">
                                <i class="bi bi-cloud-upload file-upload-icon"></i>
                                <div class="file-upload-text">Klik untuk Upload File PDF</div>
                                <div class="file-upload-subtext">Maksimal 10 MB</div>
                                <input type="file" name="document_7" id="document_7" class="file-upload-input @error('document_7') is-invalid @enderror"
                                       accept=".pdf" required onchange="showFileName(this, 'file-name-7')">
                            </div>
                            <div id="file-name-7" class="mt-2 text-muted"></div>
                            @error('document_7')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Tanggal Permohonan -->
                    <div class="form-section">
                        <h5 class="form-section-title">
                            <i class="bi bi-calendar-check"></i>
                            Tanggal Permohonan
                        </h5>

                        <div class="mb-3">
                            <label class="form-label required">Tanggal Permohonan</label>
                            <input type="date" name="application_date" class="form-control @error('application_date') is-invalid @enderror"
                                   value="{{ old('application_date', date('Y-m-d')) }}" required>
                            @error('application_date')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-submit">
                        <i class="bi bi-check-circle"></i>
                        SIMPAN DATA PERMOHONAN
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function showFileName(input, elementId) {
            const fileName = input.files[0]?.name || '';
            document.getElementById(elementId).textContent = fileName ? 'File terpilih: ' + fileName : '';
        }
    </script>
</body>
</html>
