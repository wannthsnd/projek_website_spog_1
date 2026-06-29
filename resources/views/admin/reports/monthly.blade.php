@extends('layouts.app')
@section('title', 'Laporan Bulanan - Admin')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header Section -->
    <div class="mb-8">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white mb-1">
                    📊 Laporan Bulanan
                </h1>
                <p class="text-gray-600 dark:text-gray-400 font-medium">
                    Statistik dan analisis permohonan SPOG periode {{ $months[$month] }} {{ $year }}
                </p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.dashboard') }}"
                   class="px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-xl font-medium text-sm hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors flex items-center gap-2">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
                <div class="flex gap-2">
                    <a href="{{ route('admin.reports.monthly.export.pdf', ['month' => $month, 'year' => $year]) }}"
                       class="px-4 py-2 bg-gradient-to-r from-red-500 to-red-600 text-white rounded-xl font-bold text-sm hover:shadow-lg transition-all flex items-center gap-2 shadow-md">
                        <i class="bi bi-file-pdf"></i> PDF
                    </a>
                    <a href="{{ route('admin.reports.monthly.export.excel', ['month' => $month, 'year' => $year]) }}"
                       class="px-4 py-2 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-xl font-bold text-sm hover:shadow-lg transition-all flex items-center gap-2 shadow-md">
                        <i class="bi bi-file-earmark-excel"></i> Excel
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Form -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-4 mb-6">
        <form method="GET" class="flex flex-col md:flex-row gap-4 items-center justify-between">
            <div class="flex items-center gap-3">
                <label class="text-sm font-bold text-gray-700 dark:text-gray-300">Periode:</label>
                <select name="month" class="px-4 py-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 text-gray-900 dark:text-white font-medium text-sm">
                    @foreach($months as $value => $label)
                    <option value="{{ $value }}" {{ $month == $value ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                <select name="year" class="px-4 py-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 text-gray-900 dark:text-white font-medium text-sm">
                    @foreach($years as $value)
                    <option value="{{ $value }}" {{ $year == $value ? 'selected' : '' }}>{{ $value }}</option>
                    @endforeach
                </select>
                <button type="submit" class="px-4 py-2.5 gradient-primary text-white rounded-xl font-bold text-sm shadow-md hover:shadow-lg transition-all">
                    <i class="bi bi-funnel mr-1"></i> Filter
                </button>
            </div>
            <p class="text-sm text-gray-500 dark:text-gray-400">
                <i class="bi bi-info-circle mr-1"></i>
                Data diperbarui: {{ now()->format('d M Y H:i') }}
            </p>
        </form>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-700 rounded-2xl p-5 border border-gray-200 dark:border-gray-600 shadow-lg hover:shadow-xl transition-all">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-10 h-10 bg-gradient-to-br from-primary-400 to-primary-600 rounded-lg flex items-center justify-center shadow-md">
                    <i class="bi bi-clipboard-data text-white text-lg"></i>
                </div>
                <span class="text-xs font-bold text-gray-600 dark:text-gray-400">Total</span>
            </div>
            <p class="text-3xl font-extrabold text-gray-900 dark:text-white">{{ number_format($stats['total']) }}</p>
            <p class="text-xs text-gray-600 dark:text-gray-400 font-medium mt-1">Permohonan</p>
        </div>

        <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 dark:from-yellow-900/20 dark:to-yellow-800/20 rounded-2xl p-5 border border-yellow-200 dark:border-yellow-700 shadow-lg hover:shadow-xl transition-all">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-10 h-10 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-lg flex items-center justify-center shadow-md">
                    <i class="bi bi-clock-history text-white text-lg"></i>
                </div>
                <span class="text-xs font-bold text-yellow-700 dark:text-yellow-400">Pending</span>
            </div>
            <p class="text-3xl font-extrabold text-yellow-700 dark:text-yellow-400">{{ number_format($stats['pending']) }}</p>
            <p class="text-xs text-yellow-600 dark:text-yellow-500 font-medium mt-1">Menunggu Review</p>
        </div>

        <div class="bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-800/20 rounded-2xl p-5 border border-green-200 dark:border-green-700 shadow-lg hover:shadow-xl transition-all">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-10 h-10 bg-gradient-to-br from-green-400 to-emerald-600 rounded-lg flex items-center justify-center shadow-md">
                    <i class="bi bi-check-circle text-white text-lg"></i>
                </div>
                <span class="text-xs font-bold text-green-700 dark:text-green-400">Approved</span>
            </div>
            <p class="text-3xl font-extrabold text-green-700 dark:text-green-400">{{ number_format($stats['approved']) }}</p>
            <p class="text-xs text-green-600 dark:text-green-500 font-medium mt-1">Telah Disetujui</p>
        </div>

        <div class="bg-gradient-to-br from-red-50 to-red-100 dark:from-red-900/20 dark:to-red-800/20 rounded-2xl p-5 border border-red-200 dark:border-red-700 shadow-lg hover:shadow-xl transition-all">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-10 h-10 bg-gradient-to-br from-red-400 to-rose-600 rounded-lg flex items-center justify-center shadow-md">
                    <i class="bi bi-x-circle text-white text-lg"></i>
                </div>
                <span class="text-xs font-bold text-red-700 dark:text-red-400">Rejected</span>
            </div>
            <p class="text-3xl font-extrabold text-red-700 dark:text-red-400">{{ number_format($stats['rejected']) }}</p>
            <p class="text-xs text-red-600 dark:text-red-500 font-medium mt-1">Ditolak</p>
        </div>
    </div>

    <!-- Charts Section - IMPROVED -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Chart: Status per Hari - IMPROVED -->
        <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl border border-gray-200 dark:border-gray-700 p-6">
            <h3 class="text-lg font-extrabold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                <i class="bi bi-graph-up-arrow text-primary-500"></i>
                Tren Permohonan per Hari
            </h3>
            <div class="h-72">
                <div id="dailyChart"></div>
            </div>
            <!-- Chart Legend - Clear Labels -->
            <div class="flex flex-wrap gap-4 mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-amber-400"></span>
                    <span class="text-xs text-gray-600 dark:text-gray-400">Pending</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-emerald-500"></span>
                    <span class="text-xs text-gray-600 dark:text-gray-400">Approved</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-rose-500"></span>
                    <span class="text-xs text-gray-600 dark:text-gray-400">Rejected</span>
                </div>
            </div>
        </div>

        <!-- Chart: Jenis Kapal - IMPROVED -->
        <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl border border-gray-200 dark:border-gray-700 p-6">
            <h3 class="text-lg font-extrabold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                <i class="bi bi-pie-chart-fill text-accent-500"></i>
                Distribusi Jenis Kapal
            </h3>
            <div class="h-72">
                <div id="shipTypeChart"></div>
            </div>
            <!-- Chart Legend - Clear Labels -->
            <div class="flex flex-wrap gap-3 mt-4 pt-4 border-t border-gray-200 dark:border-gray-700" id="shipTypeLegend">
                <!-- Legend items will be generated by JS -->
            </div>
        </div>
    </div>

    <!-- Top Applicants & Approval Rate -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Top Applicants -->
        <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl border border-gray-200 dark:border-gray-700 p-6">
            <h3 class="text-lg font-extrabold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                <i class="bi bi-people-fill text-success-500"></i>
                Pemohon Terbanyak
            </h3>
            <div class="space-y-3">
                @forelse($topApplicants as $index => $applicant)
                @php
                    $badgeColors = ['yellow', 'gray', 'orange', 'primary', 'purple'];
                    $badgeColor = $badgeColors[$index] ?? 'primary';
                    $icons = ['trophy', 'award', 'medal'];
                @endphp
                <div class="flex items-center gap-3 p-4 bg-gradient-to-br from-gray-50 to-white dark:from-gray-700/50 dark:to-gray-800/50 rounded-2xl border border-gray-200 dark:border-gray-600 hover:shadow-md transition-all group">
                    <div class="w-10 h-10 bg-gradient-to-br from-{{ $badgeColor }}-400 to-{{ $badgeColor }}-600 rounded-xl flex items-center justify-center text-white font-bold text-sm shadow-lg group-hover:scale-110 transition-transform">
                        @if($index < 3)
                            <i class="bi bi-{{ $icons[$index] }}"></i>
                        @else
                            {{ $index + 1 }}
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-bold text-gray-900 dark:text-white text-sm truncate">{{ $applicant->name }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ $applicant->email }}</p>
                    </div>
                    <div class="text-right">
                        <span class="block text-lg font-extrabold bg-gradient-to-r from-primary-600 to-primary-800 bg-clip-text text-transparent">
                            {{ $applicant->count }}
                        </span>
                        <span class="text-[10px] text-gray-500 dark:text-gray-400 font-medium">permohonan</span>
                    </div>
                </div>
                @empty
                <p class="text-gray-500 dark:text-gray-400 text-center py-8">Tidak ada data pemohon</p>
                @endforelse
            </div>
        </div>

        <!-- Approval Rate & Summary - IMPROVED -->
        <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl border border-gray-200 dark:border-gray-700 p-6">
            <h3 class="text-lg font-extrabold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                <i class="bi bi-percent text-purple-500"></i>
                Ringkasan Statistik
            </h3>

            <!-- Approval Rate Circle - Simplified -->
            <div class="flex items-center justify-center mb-6">
                <div class="relative w-36 h-36">
                    <svg class="w-full h-full transform -rotate-90">
                        <circle cx="72" cy="72" r="60" stroke="#e5e7eb" stroke-width="12" fill="none" class="dark:stroke-gray-700"/>
                        <circle cx="72" cy="72" r="60" stroke="#10B981" stroke-width="12" fill="none"
                                stroke-dasharray="{{ $stats['approval_rate'] * 3.77 }} 377"
                                stroke-linecap="round"
                                class="transition-all duration-1000 ease-out"/>
                    </svg>
                    <div class="absolute inset-0 flex flex-col items-center justify-center">
                        <span class="text-3xl font-extrabold text-green-600 dark:text-green-400">{{ $stats['approval_rate'] }}%</span>
                        <span class="text-xs text-gray-500 dark:text-gray-400 font-medium">Approval</span>
                    </div>
                </div>
            </div>

            <div class="space-y-3">
                <div class="flex justify-between items-center p-4 bg-gradient-to-br from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 rounded-2xl border border-green-200 dark:border-green-700">
                    <span class="text-sm font-bold text-gray-700 dark:text-gray-300">Tingkat Persetujuan</span>
                    <span class="text-xl font-extrabold text-green-600 dark:text-green-400">{{ $stats['approval_rate'] }}%</span>
                </div>
                <div class="flex justify-between items-center p-4 bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-700/50 dark:to-gray-800/50 rounded-2xl border border-gray-200 dark:border-gray-600">
                    <span class="text-sm font-bold text-gray-700 dark:text-gray-300">Rata-rata per Hari</span>
                    <span class="text-xl font-extrabold text-gray-700 dark:text-gray-300">{{ $stats['total'] > 0 ? round($stats['total'] / date('t', mktime(0,0,0,$month,1,$year)), 1) : 0 }}</span>
                </div>
                <div class="flex justify-between items-center p-4 bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 rounded-2xl border border-blue-200 dark:border-blue-700">
                    <span class="text-sm font-bold text-gray-700 dark:text-gray-300">Total Penumpang</span>
                    <span class="text-xl font-extrabold text-blue-600 dark:text-blue-400">{{ number_format($permits->sum('passenger_count')) }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-primary-50 to-primary-100 dark:from-gray-700 dark:to-gray-600">
            <h3 class="text-lg font-extrabold text-gray-900 dark:text-white flex items-center gap-2">
                <i class="bi bi-table text-primary-600"></i>
                Detail Permohonan - {{ $months[$month] }} {{ $year }}
            </h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 dark:bg-gray-700/50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 dark:text-gray-400 uppercase">ID</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 dark:text-gray-400 uppercase">Tanggal</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 dark:text-gray-400 uppercase">Kapal</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 dark:text-gray-400 uppercase">Pemohon</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 dark:text-gray-400 uppercase">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 dark:text-gray-400 uppercase">Penumpang</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($permits as $permit)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 bg-primary-100 dark:bg-primary-900/30 text-primary-700 dark:text-primary-300 text-xs font-bold rounded-full">
                                #{{ str_pad($permit->id, 4, '0', STR_PAD_LEFT) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-white">
                            {{ $permit->application_date->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm font-bold text-gray-900 dark:text-white">{{ $permit->ship_name ?? $permit->ship_type }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $permit->ship_type }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $permit->name }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ Str::limit($permit->email, 20) }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold {{ $permit->status_badge }}">
                                {{ ucfirst($permit->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-white">
                            {{ number_format($permit->passenger_count) }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-16 text-center">
                            <p class="text-gray-500 dark:text-gray-400">Tidak ada data untuk periode ini</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ApexCharts Library -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<!-- Improved Chart Scripts -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const isDark = document.documentElement.classList.contains('dark');
    const textColor = isDark ? '#e5e7eb' : '#374151';
    const gridColor = isDark ? '#374151' : '#e5e7eb';

    // Daily Chart - IMPROVED: Clear, Readable, Elegant
    const dailyOptions = {
        series: @json($chartData['datasets']).map(ds => ({
            name: ds.label,
            data: ds.data
        })),
        chart: {
            type: 'area',
            height: 280,
            fontFamily: 'inherit',
            foreColor: textColor,
            toolbar: { show: false },
            animations: { enabled: true, easing: 'easeinout', speed: 600 }
        },
        colors: ['#F59E0B', '#10B981', '#EF4444'],
        fill: {
            type: 'gradient',
            gradient: {
                shadeIntensity: 1,
                opacityFrom: 0.3,
                opacityTo: 0.05,
                stops: [0, 90, 100]
            }
        },
        stroke: { curve: 'smooth', width: 2, lineCap: 'round' },
        dataLabels: { enabled: false },
        markers: {
            size: 3,
            colors: ['#fff'],
            strokeColors: ['#F59E0B', '#10B981', '#EF4444'],
            strokeWidth: 2,
            hover: { size: 5 }
        },
        xaxis: {
            categories: @json($chartData['labels']),
            axisBorder: { show: false },
            axisTicks: { show: false },
            labels: {
                style: { fontSize: '10px', colors: textColor, fontWeight: 500 },
                rotate: -45
            }
        },
        yaxis: {
            labels: {
                style: { fontSize: '10px', colors: textColor, fontWeight: 500 },
                formatter: (val) => val >= 10 ? Math.round(val) : val
            },
            tickAmount: 4,
            min: 0
        },
        grid: {
            borderColor: gridColor,
            strokeDashArray: 3,
            padding: { left: 0, right: 0, top: 0 }
        },
        tooltip: {
            theme: isDark ? 'dark' : 'light',
            style: { fontSize: '11px' },
            x: { format: 'dd MMM' },
            y: { formatter: (val) => val + ' permohonan' },
            shared: true,
            intersect: false
        },
        legend: { show: false }
    };

    const dailyChart = new ApexCharts(document.querySelector("#dailyChart"), dailyOptions);
    dailyChart.render();

    // Ship Type Chart - IMPROVED: Clear Legend, Percentages
    const shipTypeData = @json($shipTypeData);
    const totalShips = shipTypeData.values.reduce((a, b) => a + b, 0);

    const shipOptions = {
        series: shipTypeData.values,
        labels: shipTypeData.labels,
        chart: {
            type: 'donut',
            height: 280,
            fontFamily: 'inherit',
            foreColor: textColor,
            animations: { enabled: true, easing: 'easeinout', speed: 600 }
        },
        colors: ['#FCD34D', '#0EA5E9', '#10B981', '#8B5CF6', '#EC4899', '#F59E0B'],
        stroke: { width: 0 },
        dataLabels: { enabled: false },
        plotOptions: {
            pie: {
                donut: {
                    size: '70%',
                    labels: {
                        show: true,
                        name: {
                            show: true,
                            fontSize: '13px',
                            fontWeight: 600,
                            color: textColor,
                            offsetY: -10
                        },
                        value: {
                            show: true,
                            fontSize: '20px',
                            fontWeight: 700,
                            color: textColor,
                            formatter: (val) => val,
                            offsetY: 5
                        },
                        total: {
                            show: true,
                            label: 'Total',
                            fontSize: '11px',
                            fontWeight: 500,
                            color: '#6B7280',
                            formatter: () => totalShips
                        }
                    }
                }
            }
        },
        legend: { show: false },
        tooltip: {
            theme: isDark ? 'dark' : 'light',
            style: { fontSize: '11px' },
            y: {
                formatter: (val, opts) => {
                    const pct = ((val / totalShips) * 100).toFixed(1);
                    return val + ' kapal (' + pct + '%)';
                }
            }
        },
        responsive: [{
            breakpoint: 480,
            options: {
                chart: { height: 240 },
                plotOptions: {
                    pie: {
                        donut: {
                            labels: {
                                name: { fontSize: '11px' },
                                value: { fontSize: '16px' }
                            }
                        }
                    }
                }
            }
        }]
    };

    const shipChart = new ApexCharts(document.querySelector("#shipTypeChart"), shipOptions);
    shipChart.render();

    // Generate Custom Legend for Ship Type Chart - CLEAR & READABLE
    const legendContainer = document.getElementById('shipTypeLegend');
    if (legendContainer && shipTypeData.labels) {
        shipTypeData.labels.forEach((label, index) => {
            const value = shipTypeData.values[index];
            const pct = totalShips > 0 ? ((value / totalShips) * 100).toFixed(1) : 0;
            const colors = ['#FCD34D', '#0EA5E9', '#10B981', '#8B5CF6', '#EC4899', '#F59E0B'];

            const legendItem = document.createElement('div');
            legendItem.className = 'flex items-center gap-2';
            legendItem.innerHTML = `
                <span class="w-3 h-3 rounded-full" style="background-color: ${colors[index % colors.length]}"></span>
                <span class="text-xs text-gray-600 dark:text-gray-400">${label}: <strong class="text-gray-900 dark:text-white">${value}</strong> (${pct}%)</span>
            `;
            legendContainer.appendChild(legendItem);
        });
    }
});
</script>
@endsection
