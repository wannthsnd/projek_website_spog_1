<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $title }}</title>
    <style>
        @page {
            margin: 1.5cm 2cm;
            size: A4;
        }
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 9pt;
            line-height: 1.3;
            color: #000;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 8px;
            margin-bottom: 10px;
        }
        .header h1 {
            font-size: 13pt;
            font-weight: bold;
            margin-bottom: 3px;
            text-transform: uppercase;
        }
        .header h2 {
            font-size: 11pt;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .header p {
            font-size: 8.5pt;
            margin: 1px 0;
        }
        .period {
            text-align: center;
            font-size: 10pt;
            font-weight: bold;
            margin: 8px 0;
            padding: 5px;
            border: 1px solid #000;
        }
        .stats {
            margin: 8px 0;
        }
        .stats-table {
            width: 100%;
            border-collapse: collapse;
            margin: 5px 0;
            font-size: 9pt;
        }
        .stats-table td {
            padding: 4px 6px;
            border: 1px solid #000;
            text-align: center;
        }
        .stats-table .label {
            font-weight: bold;
            background-color: #f5f5f5;
            width: 45%;
            text-align: left;
            padding-left: 10px;
        }
        .stats-table .value {
            font-weight: bold;
        }
        .stats-table .total { background-color: #fff3cd; }
        .stats-table .approved { background-color: #d4edda; color: #155724; }
        .stats-table .rejected { background-color: #f8d7da; color: #721c24; }
        .stats-table .pending { background-color: #fff3cd; color: #856404; }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 8px 0;
            font-size: 8.5pt;
        }
        th {
            background-color: #D4AF37;
            color: #000;
            font-weight: bold;
            padding: 5px 6px;
            text-align: left;
            border: 1px solid #000;
        }
        td {
            padding: 4px 6px;
            border: 1px solid #000;
            vertical-align: top;
        }
        tr:nth-child(even) {
            background-color: #fafafa;
        }
        .status-approved { color: #155724; font-weight: bold; }
        .status-rejected { color: #721c24; font-weight: bold; }
        .status-pending { color: #856404; font-weight: bold; }
        .footer {
            margin-top: 15px;
            text-align: center;
            font-size: 8pt;
            border-top: 1px solid #000;
            padding-top: 5px;
        }
        .signature {
            margin-top: 20px;
            text-align: right;
        }
        .signature-box {
            display: inline-block;
            text-align: center;
            min-width: 180px;
        }
        .signature-line {
            margin-top: 35px;
            border-top: 1px solid #000;
            padding-top: 3px;
            font-weight: bold;
            font-size: 9pt;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .mb-1 { margin-bottom: 5px; }
        .mb-2 { margin-bottom: 8px; }
        .compact { margin: 3px 0; }
        .wrapper {
            padding: 0 5px;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <!-- Header -->
        <div class="header">
            <h1>LAPORAN BULANAN</h1>
            <h2>SURAT PERSETUJUAN OLAH GERAK KAPAL (SPOG)</h2>
            <p>{{ $office }}</p>
            <p>Dicetak: {{ $generated_at }}</p>
        </div>

        <!-- Period -->
        <div class="period">Periode: {{ $period }}</div>

        <!-- Statistics -->
        <div class="stats">
            <table class="stats-table">
                <tr>
                    <td class="label total">Total Permohonan</td>
                    <td class="value total">{{ number_format($stats['total']) }}</td>
                </tr>
                <tr>
                    <td class="label approved">Disetujui</td>
                    <td class="value approved">{{ number_format($stats['approved']) }}</td>
                </tr>
                <tr>
                    <td class="label rejected">Ditolak</td>
                    <td class="value rejected">{{ number_format($stats['rejected']) }}</td>
                </tr>
                <tr>
                    <td class="label pending">Pending</td>
                    <td class="value pending">{{ number_format($stats['pending']) }}</td>
                </tr>
                <tr>
                    <td class="label"><strong>Tingkat Persetujuan</strong></td>
                    <td class="value"><strong>{{ number_format($stats['approval_rate'], 1) }}%</strong></td>
                </tr>
            </table>
        </div>

        <!-- Data Table -->
        <div class="mb-2">
            <table>
                <thead>
                    <tr>
                        <th style="width: 4%;">No</th>
                        <th style="width: 10%;">Tanggal</th>
                        <th style="width: 18%;">Nama Kapal</th>
                        <th style="width: 13%;">Jenis</th>
                        <th style="width: 22%;">Pemohon</th>
                        <th style="width: 13%;">Status</th>
                        <th style="width: 8%; text-align: center;">Psg</th>
                        <th style="width: 12%; text-align: right;">GT</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($permits as $index => $permit)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $permit->application_date->format('d/m/Y') }}</td>
                        <td>{{ $permit->ship_name ?? $permit->ship_type }}</td>
                        <td>{{ $permit->ship_type }}</td>
                        <td>
                            {{ $permit->name }}<br>
                            <small style="font-size: 7.5pt;">{{ $permit->email }}</small>
                        </td>
                        <td>
                            @if($permit->status === 'approved')
                                <span class="status-approved">✓ Approved</span>
                            @elseif($permit->status === 'rejected')
                                <span class="status-rejected">✗ Rejected</span>
                            @else
                                <span class="status-pending">⏳ Pending</span>
                            @endif
                        </td>
                        <td style="text-align: center;">{{ number_format($permit->passenger_count) }}</td>
                        <td style="text-align: right;">{{ number_format($permit->gross_tonnage ?? 0) }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center" style="padding: 10px;">
                            <em>Tidak ada data permohonan untuk periode ini</em>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Footer & Signature -->
        <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-top: 10px;">
            <div class="footer">
                <p><strong>{{ $office }}</strong></p>
                <p>Laporan otomatis Sistem SPOG • {{ $generated_at }}</p>
            </div>
            <div class="signature">
                <div class="signature-box">
                    <p style="font-size: 8.5pt;">Kepala Kantor KSOP Kelas I Panjang</p>
                    <div class="signature-line">
                        (___________________)<br>
                        <span style="font-size: 8pt;">NIP. ___________________</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
