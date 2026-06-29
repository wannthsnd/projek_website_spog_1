<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Surat Persetujuan Olah Gerak Kapal - {{ $permit->ship_name }}</title>
    <style>
        @page {
            margin: 1cm 1.5cm;
            size: A4;
        }
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 10.5pt;
            line-height: 1.2;
            margin: 0;
            padding: 0;
        }
        .header {
            width: 100%;
            border-bottom: 2px solid #000;
            padding-bottom: 5px;
            margin-bottom: 10px;
        }
        .header-top {
            width: 100%;
            margin-bottom: 8px;
        }
        .header-table {
            width: 100%;
            border: 0;
            border-collapse: collapse;
        }
        .header-table td {
            vertical-align: middle;
            padding: 0;
            border: 0;
        }

        /* ✅ FIX LEBAR KOLOM LOGO - AGAR TEKS TIDAK BERGESER */
        .header-table tr td:first-child {
            width: 150px;  /* Fix lebar kolom logo */
            min-width: 150px;
            max-width: 150px;
        }

        .header-logo {
            width: 150px;  /* Container logo */
            text-align: center;
            padding-right: 15px;
        }
        .header-logo img {
            width: 180px;  /* Ukuran logo - bisa diubah */
            height: 110px; /* Ukuran logo - bisa diubah */
            object-fit: contain;
        }
        .header-text {
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 14pt;
            font-weight: bold;
            text-transform: uppercase;
            line-height: 1.2;
        }
        .header h2 {
            margin: 0;
            font-size: 12pt;
            font-weight: bold;
            line-height: 1.2;
        }
        .header h3 {
            margin: 0;
            font-size: 12pt;
            font-weight: bold;
            line-height: 1.2;
        }
        .header h4 {
            margin: 0;
            font-size: 12pt;
            font-weight: bold;
            line-height: 1.2;
        }
        .contact-info {
            width: 100%;
            font-size: 9pt;
            border-collapse: collapse;
        }
        .contact-info td {
            vertical-align: top;
            padding: 2px 10px;
            border-right: 1px solid #000;
        }
        .contact-info td:last-child {
            border-right: none;
        }
        .contact-info .col-address {
            width: 30%;
            text-align: right;
        }
        .contact-info .col-contact {
            width: 40%;
            text-align: center;
        }
        .contact-info .col-fax {
            width: 30%;
            text-align: left;
        }
        .contact-info .label {
            font-weight: bold;
        }
        .contact-info div {
            margin: 1px 0;
            line-height: 1.3;
        }
        .title {
            text-align: center;
            margin: 10px 0;
        }
        .title h3 {
            margin: 0;
            font-size: 12pt;
            font-weight: bold;
            text-decoration: underline;
        }
        .doc-number {
            text-align: center;
            margin: 5px 0 8px 0;
            font-size: 10.5pt;
        }
        .section {
            margin: 5px 0;
            text-align: justify;
            font-size: 10.5pt;
        }
        .legal-basis {
            margin: 5px 0;
            font-size: 9.5pt;
        }
        .legal-basis ol {
            margin: 2px 0;
            padding-left: 18px;
        }
        .legal-basis li {
            margin: 1px 0;
            text-align: justify;
            line-height: 1.15;
        }
        .ship-details {
            margin: 5px 0;
        }
        .ship-details table {
            width: 100%;
            border-collapse: collapse;
        }
        .ship-details td {
            padding: 1px 3px;
            vertical-align: top;
            font-size: 10.5pt;
        }
        .ship-details .label {
            width: 115px;
        }
        .ship-details .separator {
            width: 12px;
            text-align: center;
        }
        .conditions {
            margin: 5px 0;
        }
        .conditions ol {
            margin: 2px 0;
            padding-left: 18px;
        }
        .conditions li {
            margin: 1px 0;
            text-align: justify;
            line-height: 1.15;
            font-size: 10pt;
        }
        .signature-section {
            margin-top: 10px;
            page-break-inside: avoid;
        }
        .signature-box {
            float: right;
            text-align: center;
            width: 180px;
        }
        .signature-space {
            height: 35px;
        }
        .bold {
            font-weight: bold;
        }
        .clear {
            clear: both;
        }
        .compact {
            margin: 2px 0;
        }
        .no-break {
            page-break-inside: avoid;
        }
    </style>
</head>
<body>
    <!-- Header Kop Surat dengan Logo -->
    <div class="header">
        <div class="header-top">
            <table class="header-table">
                <tr>
                    <td class="header-logo">
                        <img src="{{ public_path('images/kemenhub.png') }}" alt="Logo">
                    </td>
                    <td class="header-text">
                        <h1>KEMENTERIAN PERHUBUNGAN</h1>
                        <h2>DIREKTORAT JENDERAL PERHUBUNGAN LAUT</h2>
                        <h3>KSOP KELAS I PANJANG</h3>
                        <h4>{{ strtoupper($permit->upt->name ?? 'UPT PELABUHAN BALI') }}</h4>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Alamat dan Kontak dengan Format 3 Kolom -->
        <table class="contact-info">
            <tr>
                <td class="col-address">
                    @php
                        $alamat = trim($permit->upt->alamat ?? $permit->upt->address ?? '');
                        $kota = trim($permit->upt->kota ?? $permit->upt->city ?? '');
                        $kodePos = trim($permit->upt->kode_pos ?? $permit->upt->postal_code ?? '');
                    @endphp
                    @if(!empty($alamat))
                        <div>{{ $alamat }}</div>
                    @else
                        <div>Jl. Yos Sudarso</div>
                    @endif
                    @if(!empty($kota) || !empty($kodePos))
                        <div>
                            {{ $kota }}
                            @if(!empty($kota) && !empty($kodePos)) @endif
                            @if(!empty($kodePos))
                                Kode Pos {{ $kodePos }}
                            @endif
                        </div>
                    @else
                        <div>Kode Pos 35241</div>
                    @endif
                </td>
                <td class="col-contact">
                    @php
                        $telepon = trim($permit->upt->telepon ?? $permit->upt->phone ?? '');
                        $email = trim($permit->upt->email ?? '');
                        $website = trim($permit->upt->website ?? '');
                    @endphp
                    <div>
                        <span class="label">Telp</span> :
                        @if(!empty($telepon))
                            {{ $telepon }}
                        @else
                            (0721) 31303, 33221
                        @endif
                    </div>
                    <div>
                        <span class="label">e-mail</span> :
                        @if(!empty($email))
                            {{ $email }}
                        @else
                            upt.pelabuhanbali@gmail.com
                        @endif
                    </div>
                    <div>
                        <span class="label">web-site</span> :
                        @if(!empty($website))
                            {{ $website }}
                        @else
                            ksop-panjang.id
                        @endif
                    </div>
                </td>
                <td class="col-fax">
                    @php
                        $tgm = trim($permit->upt->tgm ?? '');
                        $tlx = trim($permit->upt->tlx ?? '');
                        $fax = trim($permit->upt->fax ?? '');
                    @endphp
                    <div>
                        TGM
                        @if(!empty($tgm))
                            {{ $tgm }}
                        @else
                            ...........
                        @endif
                    </div>
                    <div>
                        TLX
                        @if(!empty($tlx))
                            {{ $tlx }}
                        @else
                            ...........
                        @endif
                    </div>
                    <div>
                        <span class="label">FAX</span>
                        @if(!empty($fax))
                            {{ $fax }}
                        @else
                            (0721) 31392
                        @endif
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <!-- Judul Dokumen -->
    <div class="title">
        <h3>SURAT PERSETUJUAN OLAH GERAK KAPAL</h3>
    </div>

    <!-- Nomor Dokumen -->
    <div class="doc-number">
        Nomor: KSOP/{{ $permit->upt->code ?? 'XXX' }}/{{ date('m') }}/{{ date('Y') }}/{{ str_pad($permit->id, 4, '0', STR_PAD_LEFT) }}
    </div>

    <!-- Dasar Hukum -->
    <div class="legal-basis">
        <strong>DASAR HUKUM:</strong>
        <ol style="margin: 2px 0; padding-left: 18px;">
            <li>UU No. 17 Tahun 2008 tentang Pelayaran;</li>
            <li>PP No. 31 Tahun 2021 tentang Penyelenggaraan Bidang Pelayaran;</li>
            <li>PP No. 5 Tahun 2010 tentang Kenavigasian;</li>
            <li>Permenhub No. 28 Tahun 2022 tentang Tata Cara Penerbitan SPB dan Persetujuan Kegiatan Kapal;</li>
            <li>Permenhub No. 16 Tahun 2023 tentang Perubahan Keempat Atas Permenhub No. PM 36 Tahun 2012;</li>
            <li>Peraturan Bandar (Havenreglement) 1925;</li>
            <li>Peraturan Pencegahan Tubrukan di Laut (Colreg) 1972.</li>
        </ol>
    </div>

    <!-- Isi Surat -->
    <div class="section compact">
        Yang bertandatangan di bawah ini <strong>Kepala Kantor Kesyahbandaran dan Otoritas Pelabuhan</strong>, sesuai surat permohonan dari <strong>{{ $permit->owner_agent }}</strong> Tanggal: {{ \Carbon\Carbon::parse($permit->application_date)->format('d F Y') }}, Perihal: Persetujuan Olah Gerak Kapal
    </div>

    <div class="section compact">
        Dengan ini memberikan persetujuan kepada kapal tersebut dibawah ini:
    </div>

    <!-- Detail Kapal -->
    <div class="ship-details">
        <table>
            <tr>
                <td class="label">Nama Kapal</td>
                <td class="separator">:</td>
                <td class="bold">{{ strtoupper($permit->ship_name) }}</td>
            </tr>
            <tr>
                <td class="label">Jenis Kapal</td>
                <td class="separator">:</td>
                <td>{{ $permit->ship_type }}</td>
            </tr>
            <tr>
                <td class="label">Bendera</td>
                <td class="separator">:</td>
                <td>{{ $permit->flag ?? 'Indonesia' }}</td>
            </tr>
            <tr>
                <td class="label">Isi Kotor</td>
                <td class="separator">:</td>
                <td>{{ number_format($permit->gross_tonnage ?? 0) }} GT</td>
            </tr>
            <tr>
                <td class="label">Nakhoda</td>
                <td class="separator">:</td>
                <td class="bold">{{ $permit->captain_name }}</td>
            </tr>
            <tr>
                <td class="label">Milik / Agen</td>
                <td class="separator">:</td>
                <td>{{ $permit->owner_agent }}</td>
            </tr>
        </table>
    </div>

    <div class="section compact">
        Untuk bergerak dari <strong>{{ $permit->departure_location }}</strong> ke <strong>{{ $permit->destination }}</strong> (dalam DLKr/DLKp)
    </div>

    <div class="section compact">
        <table>
            <tr>
                <td class="label">Keperluan</td>
                <td class="separator">:</td>
                <td>{{ $permit->purpose }}</td>
            </tr>
        </table>
    </div>

    <!-- Ketentuan -->
    <div class="section compact">
        <strong>Kedua:</strong> Persetujuan ini diberikan untuk maksud dan tujuan diatas dengan ketentuan sebagai berikut:
    </div>

    <div class="conditions">
        <ol style="margin: 2px 0; padding-left: 18px;">
            <li>Radio VHF harus stand by pada chanel 12/16;</li>
            <li>Tidak mengganggu alur masuk dan keluar kapal;</li>
            <li>Tidak mengganggu kelancaran kegiatan kapal lainnya;</li>
            <li>Memasang semboyan sosok benda/penerangan sesuai ketentuan yang berlaku;</li>
            <li>Diawaki dengan cukup sesuai ketentuan;</li>
            <li>Kegiatan hanya di Perairan Bandar;</li>
            <li>Dokumen kapal harus tetap disimpan di Kantor;</li>
            <li>Mematuhi semua peraturan dan ketentuan yang berlaku di Wilayah kerja Kantor {{ $permit->upt->name ?? 'Kesyahbandaran' }};</li>
            <li>Nakhoda bertanggungjawab setiap kegiatan pergerakan kapal.</li>
        </ol>
    </div>

    <div class="section compact no-break">
        Persetujuan ini mulai tanggal <strong>{{ \Carbon\Carbon::parse($permit->application_date)->format('d F Y') }}</strong> s/d <strong>{{ \Carbon\Carbon::parse($permit->application_date)->addDays(7)->format('d F Y') }}</strong>
    </div>

    <!-- Tanda Tangan -->
    <div class="signature-section no-break">
        <table style="width: 100%; margin-top: 8px;">
            <tr>
                <td style="width: 60%;"></td>
                <td style="width: 40%; text-align: center;">
                    @php
                        $kepalaKantor = trim($permit->upt->kepala_kantor ?? '');
                        $nipKepala = trim($permit->upt->nip_kepala ?? '');
                    @endphp
                    <div>
                        Dikeluarkan di :
                        @if(!empty($permit->upt->kota))
                            {{ $permit->upt->kota }}
                        @else
                            _________________
                        @endif
                    </div>
                    <div>Pada Tanggal : _________________</div>
                    <div class="signature-space"></div>
                    <div class="bold" style="margin-top: 5px;">KEPALA KANTOR</div>
                    <div class="signature-space"></div>
                    <div class="bold">
                        @if(!empty($kepalaKantor))
                            ({{ $kepalaKantor }})
                        @else
                            (_________________________)
                        @endif
                    </div>
                    <div>
                        NIP.
                        @if(!empty($nipKepala))
                            {{ $nipKepala }}
                        @else
                            _________________________
                        @endif
                    </div>
                </td>
            </tr>
        </table>
        <div class="clear"></div>
    </div>
</body>
</html>
