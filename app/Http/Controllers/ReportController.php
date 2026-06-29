<?php

namespace App\Http\Controllers;

use App\Models\ShipPermit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ReportController extends Controller
{
    /**
     * Tampilkan halaman laporan bulanan
     */
    public function index(Request $request)
    {
        // Default: bulan dan tahun saat ini
        $month = $request->get('month', date('m'));
        $year = $request->get('year', date('Y'));

        // Filter data berdasarkan bulan dan tahun
        $permits = ShipPermit::whereYear('application_date', $year)
            ->whereMonth('application_date', $month)
            ->orderBy('application_date', 'desc')
            ->get();

        // Statistik summary
        $stats = [
            'total' => $permits->count(),
            'pending' => $permits->where('status', 'pending')->count(),
            'approved' => $permits->where('status', 'approved')->count(),
            'rejected' => $permits->where('status', 'rejected')->count(),
            'approval_rate' => $permits->count() > 0
                ? round(($permits->where('status', 'approved')->count() / $permits->count()) * 100)
                : 0,
        ];

        // Data untuk grafik: Status per hari dalam bulan
        $chartData = $this->getChartData($year, $month);

        // Data untuk grafik: Jenis kapal terbanyak
        $shipTypeData = $this->getShipTypeData($year, $month);

        // Data untuk grafik: Pemohon terbanyak
        $topApplicants = $this->getTopApplicants($year, $month);

        // List bulan dan tahun untuk dropdown
        $months = $this->getMonthList();
        $years = $this->getYearList();

        return view('admin.reports.monthly', compact(
            'permits',
            'stats',
            'chartData',
            'shipTypeData',
            'topApplicants',
            'month',
            'year',
            'months',
            'years'
        ));
    }

    /**
     * Export laporan ke PDF
     */
    public function exportPdf(Request $request)
    {
        $month = $request->get('month', date('m'));
        $year = $request->get('year', date('Y'));

        $permits = ShipPermit::whereYear('application_date', $year)
            ->whereMonth('application_date', $month)
            ->orderBy('application_date', 'desc')
            ->get();

        $stats = [
            'total' => $permits->count(),
            'pending' => $permits->where('status', 'pending')->count(),
            'approved' => $permits->where('status', 'approved')->count(),
            'rejected' => $permits->where('status', 'rejected')->count(),
            'approval_rate' => $permits->count() > 0
                ? round(($permits->where('status', 'approved')->count() / $permits->count()) * 100)
                : 0,
        ];

        $monthName = $this->getMonthList()[$month] ?? '';

        $data = [
            'title' => "Laporan Bulanan SPOG - {$monthName} {$year}",
            'period' => "{$monthName} {$year}",
            'generated_at' => now()->format('d F Y H:i'),
            'stats' => $stats,
            'permits' => $permits,
            'office' => 'KANTOR KESYAHBANDARAN DAN OTORITAS PELABUHAN KELAS I PANJANG',
        ];

        $pdf = Pdf::loadView('admin.reports.pdf', $data)
            ->setPaper('a4', 'portrait')
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('isRemoteEnabled', true);

        return $pdf->download("Laporan_SPOG_{$monthName}_{$year}.pdf");
    }

    /**
 * Export laporan ke Excel
 */
public function exportExcel(Request $request)
{
    $month = $request->get('month', date('m'));
    $year = $request->get('year', date('Y'));

    $permits = ShipPermit::whereYear('application_date', $year)
        ->whereMonth('application_date', $month)
        ->orderBy('application_date', 'desc')
        ->get();

    // ✅ CALCULATE STATS
    $stats = [
        'total' => $permits->count(),
        'pending' => $permits->where('status', 'pending')->count(),
        'approved' => $permits->where('status', 'approved')->count(),
        'rejected' => $permits->where('status', 'rejected')->count(),
        'approval_rate' => $permits->count() > 0
            ? round(($permits->where('status', 'approved')->count() / $permits->count()) * 100)
            : 0,
    ];

    // Create spreadsheet
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Header
    $sheet->mergeCells('A1:H1');
    $sheet->setCellValue('A1', 'LAPORAN BULANAN SPOG');
    $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
    $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');

    $sheet->mergeCells('A2:H2');
    $sheet->setCellValue('A2', "Periode: {$this->getMonthList()[$month]} {$year}");
    $sheet->getStyle('A2')->getFont()->setItalic(true);
    $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');

    // Column headers
    $headers = ['No', 'Tanggal', 'Nama Kapal', 'Jenis Kapal', 'Pemohon', 'Email', 'Status', 'Jml Penumpang'];
    $sheet->fromArray($headers, null, 'A4');

    // Style headers
    $sheet->getStyle('A4:H4')->getFont()->setBold(true);
    $sheet->getStyle('A4:H4')->getFill()->setFillType('solid')->getStartColor()->setARGB('FFD4AF37');

    // Data rows
    $row = 5;
    foreach ($permits as $index => $permit) {
        $sheet->setCellValue('A' . $row, $index + 1);
        $sheet->setCellValue('B' . $row, $permit->application_date->format('d/m/Y'));
        $sheet->setCellValue('C' . $row, $permit->ship_name ?? $permit->ship_type);
        $sheet->setCellValue('D' . $row, $permit->ship_type);
        $sheet->setCellValue('E' . $row, $permit->name);
        $sheet->setCellValue('F' . $row, $permit->email);
        $sheet->setCellValue('G' . $row, ucfirst($permit->status));
        $sheet->setCellValue('H' . $row, $permit->passenger_count);
        $row++;
    }

    // Auto-size columns
    foreach (range('A', 'H') as $col) {
        $sheet->getColumnDimension($col)->setAutoSize(true);
    }

    // Summary section
    $summaryRow = $row + 2;
    $sheet->setCellValue('A' . $summaryRow, 'RINGKASAN:');
    $sheet->getStyle('A' . $summaryRow)->getFont()->setBold(true);

    $sheet->setCellValue('A' . ($summaryRow + 1), 'Total Permohonan:');
    $sheet->setCellValue('B' . ($summaryRow + 1), $stats['total']);

    $sheet->setCellValue('A' . ($summaryRow + 2), 'Disetujui:');
    $sheet->setCellValue('B' . ($summaryRow + 2), $stats['approved']);

    $sheet->setCellValue('A' . ($summaryRow + 3), 'Ditolak:');
    $sheet->setCellValue('B' . ($summaryRow + 3), $stats['rejected']);

    $sheet->setCellValue('A' . ($summaryRow + 4), 'Pending:');
    $sheet->setCellValue('B' . ($summaryRow + 4), $stats['pending']);

    $sheet->setCellValue('A' . ($summaryRow + 5), 'Tingkat Persetujuan:');
    $sheet->setCellValue('B' . ($summaryRow + 5), $stats['approval_rate'] . '%');

    // Style summary
    $sheet->getStyle('A' . ($summaryRow + 1) . ':B' . ($summaryRow + 5))->getFont()->setBold(true);

    $filename = "Laporan_SPOG_" . $this->getMonthList()[$month] . "_{$year}.xlsx";

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $filename . '"');
    header('Cache-Control: max-age=0');

    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit;
}

    /**
     * Get chart data: Status per hari dalam bulan
     */
    private function getChartData($year, $month)
    {
        $data = ShipPermit::selectRaw('DATE(application_date) as date,
                    COUNT(*) as total,
                    SUM(CASE WHEN status = "approved" THEN 1 ELSE 0 END) as approved,
                    SUM(CASE WHEN status = "rejected" THEN 1 ELSE 0 END) as rejected,
                    SUM(CASE WHEN status = "pending" THEN 1 ELSE 0 END) as pending')
            ->whereYear('application_date', $year)
            ->whereMonth('application_date', $month)
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $labels = [];
        $total = [];
        $approved = [];
        $rejected = [];
        $pending = [];

        foreach ($data as $item) {
            $labels[] = date('d', strtotime($item->date));
            $total[] = $item->total;
            $approved[] = $item->approved;
            $rejected[] = $item->rejected;
            $pending[] = $item->pending;
        }

        return [
            'labels' => $labels,
            'datasets' => [
                ['label' => 'Total', 'data' => $total, 'color' => '#FCD34D'],
                ['label' => 'Approved', 'data' => $approved, 'color' => '#10B981'],
                ['label' => 'Rejected', 'data' => $rejected, 'color' => '#EF4444'],
                ['label' => 'Pending', 'data' => $pending, 'color' => '#F59E0B'],
            ]
        ];
    }

    /**
     * Get ship type distribution data
     */
    private function getShipTypeData($year, $month)
    {
        $data = ShipPermit::selectRaw('ship_type, COUNT(*) as count')
            ->whereYear('application_date', $year)
            ->whereMonth('application_date', $month)
            ->groupBy('ship_type')
            ->orderByDesc('count')
            ->limit(5)
            ->get();

        $labels = $data->pluck('ship_type')->toArray();
        $values = $data->pluck('count')->toArray();

        return ['labels' => $labels, 'values' => $values];
    }

    /**
     * Get top applicants data
     */
    private function getTopApplicants($year, $month)
    {
        return ShipPermit::selectRaw('name, email, COUNT(*) as count')
            ->whereYear('application_date', $year)
            ->whereMonth('application_date', $month)
            ->groupBy('name', 'email')
            ->orderByDesc('count')
            ->limit(5)
            ->get();
    }

    /**
     * Get month list for dropdown
     */
    private function getMonthList()
    {
        return [
            '01' => 'Januari', '02' => 'Februari', '03' => 'Maret',
            '04' => 'April', '05' => 'Mei', '06' => 'Juni',
            '07' => 'Juli', '08' => 'Agustus', '09' => 'September',
            '10' => 'Oktober', '11' => 'November', '12' => 'Desember',
        ];
    }

    /**
     * Get year list for dropdown
     */
    private function getYearList()
    {
        $years = [];
        $currentYear = date('Y');
        for ($i = $currentYear; $i >= $currentYear - 5; $i--) {
            $years[$i] = $i;
        }
        return $years;
    }
}
