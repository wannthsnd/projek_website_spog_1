<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Bulanan SPOG - {{ $monthYear }}</title>
    <style>
        @page {
            margin: 1cm 1.5cm;
            size: A4 portrait;
        }
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 9pt;
            line-height: 1.2;
            margin: 0;
            padding: 0;
        }
        .header {
            text-align: center;
            margin-bottom: 10px;
            border-bottom: 2px solid #333;
            padding-bottom: 8px;
        }
        .header h1 {
            margin: 0;
            font-size: 14pt;
            font-weight: bold;
            text-transform: uppercase;
        }
        .header h2 {
            margin: 2px 0 0 0;
            font-size: 11pt;
            font-weight: bold;
        }
        .header p {
            margin: 2px 0 0 0;
            font-size: 9pt;
        }
        .section {
            margin-bottom: 12px;
        }
        .section-title {
            font-size: 11pt;
            font-weight: bold;
            margin-bottom: 6px;
            background-color: #f0f0f0;
            padding: 4px 6px;
            border-left: 3px solid #333;
        }
        .stats-grid {
            display: table;
            width: 100%;
            margin-bottom: 8px;
        }
        .stat-box {
            display: table-cell;
            width: 25%;
            text-align: center;
            padding: 6px;
            border: 1px solid #ddd;
            background-color: #f9f9f9;
        }
        .stat-value {
            font-size: 16pt;
            font-weight: bold;
            color: #333;
        }
        .stat-label {
            font-size: 8pt;
            color: #666;
            margin-top: 2px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
            font-size: 8pt;
        }
        th {
            background-color: #333;
            color: white;
            padding: 4px 3px;
            text-align: left;
            font-size: 8pt;
            font-weight: bold;
        }
        td {
            padding: 3px;
            border: 1px solid #ddd;
            font-size: 8pt;
            vertical-align: top;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .text-center {
            text-align: center;
        }
        .badge {
            display: inline-block;
            padding: 2px 5px;
            border-radius: 2px;
            font-size: 7pt;
            font-weight: bold;
        }
        .badge-success {
            background-color: #d4edda;
            color: #155724;
        }
        .badge-warning {
            background-color: #fff3cd;
            color: #856404;
        }
        .badge-danger {
            background-color: #f8d7da;
            color: #721c24;
        }
        .footer {
            margin-top: 10px;
            text-align: right;
            font-size: 8pt;
            border-top: 1px solid #ddd;
            padding-top: 5px;
        }
        .compact-text {
            font-size: 8pt;
            line-height: 1.1;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>LAPORAN BULANAN PERMOHONAN SPOG</h1>
        <h2>Sistem Pelaporan Terintegrasi SPOG KAPAL</h2>
        <p>Periode: {{ $monthYear }}</p>
    </div>

    <!-- Statistik Summary -->
    <div class="section">
        <div class="section-title">STATISTIK SUMMARY</div>
        <div class="stats-grid">
            <div class="stat-box">
                <div class="stat-value">{{ number_format($stats['total_permits']) }}</div>
                <div class="stat-label">Total Permohonan</div>
            </div>
            <div class="stat-box">
                <div class="stat-value">{{ number_format($stats['approved']) }}</div>
                <div class="stat-label">Disetujui</div>
            </div>
            <div class="stat-box">
                <div class="stat-value">{{ number_format($stats['pending']) }}</div>
                <div class="stat-label">Pending</div>
            </div>
            <div class="stat-box">
                <div class="stat-value">{{ $stats['approval_rate'] }}%</div>
                <div class="stat-label">Approval Rate</div>
            </div>
        </div>
    </div>

    <!-- Detail Permohonan -->
    <div class="section">
        <div class="section-title">DETAIL PERMOHONAN</div>
        <table>
            <thead>
                <tr>
                    <th width="3%">No</th>
                    <th width="8%">Tanggal</th>
                    <th width="12%">Kapal</th>
                    <th width="10%">Jenis</th>
                    <th width="15%">Pemohon</th>
                    <th width="12%">UPT</th>
                    <th width="8%">Status</th>
                    <th width="7%" class="text-center">Pnp</th>
                    <th width="7%" class="text-center">GT</th>
                </tr>
            </thead>
            <tbody>
                @forelse($permits as $index => $permit)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $permit->application_date->format('d/m/Y') }}</td>
                    <td class="compact-text">{{ $permit->ship_name }}</td>
                    <td class="compact-text">{{ $permit->ship_type }}</td>
                    <td class="compact-text">
                        {{ Str::limit($permit->user?->name ?? '-', 20) }}<br>
                        <span style="color: #666; font-size: 7pt;">{{ Str::limit($permit->user?->email ?? '-', 25) }}</span>
                    </td>
                    <td class="compact-text">{{ Str::limit($permit->upt?->name ?? '-', 15) }}</td>
                    <td class="text-center">
                        @if($permit->status === 'approved')
                            <span class="badge badge-success">Approved</span>
                        @elseif($permit->status === 'pending')
                            <span class="badge badge-warning">Pending</span>
                        @else
                            <span class="badge badge-danger">Rejected</span>
                        @endif
                    </td>
                    <td class="text-center">{{ number_format($permit->passenger_count) }}</td>
                    <td class="text-center">{{ number_format($permit->gross_tonnage) }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center">Tidak ada data permohonan untuk periode ini</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p><strong>Dicetak:</strong> {{ now()->format('d F Y H:i') }} WIB | <strong>Sistem:</strong> SPOG KAPAL DAN CVS</p>
    </div>
</body>
</html>
