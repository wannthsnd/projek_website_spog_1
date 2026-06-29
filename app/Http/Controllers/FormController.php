<?php

namespace App\Http\Controllers;

use App\Models\ShipPermit;
use App\Models\User;
use App\Notifications\PermitEditedAfterRejection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class FormController extends Controller
{
    /**
     * Tampilkan dashboard utama
     */
    public function dashboard()
    {
        if (auth()->check()) {
            $user = auth()->user();
            $query = ShipPermit::where('email', $user->email);

            $totalPermohonan = $query->count();
            $totalPending = (clone $query)->where('status', 'pending')->count();
            $totalApproved = (clone $query)->where('status', 'approved')->count();
            $totalRejected = (clone $query)->where('status', 'rejected')->count();

            $data = $query->latest()->take(4)->get();

            return view('dashboard', compact(
                'data',
                'totalPermohonan',
                'totalPending',
                'totalApproved',
                'totalRejected'
            ));
        }

        $data = ShipPermit::latest()->take(4)->get();
        return view('dashboard', compact('data'));
    }

    /**
     * Tampilkan data pemohon
     */
    public function dataPemohon()
    {
        $user = auth()->user();

        if ($user) {
            $data = ShipPermit::where('email', $user->email)->latest()->paginate(10);
        } else {
            $data = ShipPermit::latest()->paginate(10);
        }

        return view('data-pemohon', compact('data'));
    }

    /**
     * Tampilkan form create permohonan
     */
    public function create()
    {
        return view('permohonan.create');
    }

    /**
     * Simpan data permohonan baru
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255',
            'name' => 'required|string|max:255',
            'ship_name' => 'required|string|max:255',
            'ship_type' => 'required|string|max:255',
            'flag' => 'required|string|max:100',
            'gross_tonnage' => 'required|integer|min:1',
            'captain_name' => 'required|string|max:255',
            'owner_agent' => 'required|string|max:255',
            'departure_location' => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'purpose' => 'required|string',
            'passenger_count' => 'nullable|integer|min:1',
            'movement_time' => 'nullable|string|max:255',
            'application_date' => 'required|date',
            'document_1' => 'required|file|mimes:pdf|max:10240',
            'document_3' => 'required|file|mimes:pdf|max:10240',
            'document_4' => 'required|file|mimes:pdf|max:10240',
            'document_5' => 'required|file|mimes:pdf|max:10240',
            'document_6' => 'required|file|mimes:pdf|max:10240',
        ], [
            'ship_name.required' => 'Nama Kapal wajib diisi',
            'ship_type.required' => 'Jenis Kapal wajib dipilih',
            'flag.required' => 'Bendera Kapal wajib diisi',
            'gross_tonnage.required' => 'Isi Kotor (GT) wajib diisi',
            'captain_name.required' => 'Nama Nakhoda wajib diisi',
            'owner_agent.required' => 'Nama Pemilik/Agent wajib diisi',
            'departure_location.required' => 'Lokasi berangkat wajib diisi',
            'destination.required' => 'Tujuan wajib diisi',
            'purpose.required' => 'Keperluan olah gerak wajib diisi',
            'document_1.required' => 'Surat Permohonan wajib diunggah',
            'document_3.required' => 'Fotokopi Data Awak Kapal wajib diunggah',
            'document_4.required' => 'Dokumen Kapal Asli wajib diunggah',
            'document_5.required' => 'Manifest Penumpang wajib diunggah',
            'document_6.required' => 'Manifest Muatan wajib diunggah',
            '*.mimes' => 'Format file harus PDF',
            '*.max' => 'Ukuran file maksimal 10MB',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Upload dokumen
        $documentPaths = [];
        $documentFields = ['document_1', 'document_3', 'document_4', 'document_5', 'document_6'];

        foreach ($documentFields as $field) {
            if ($request->hasFile($field)) {
                $file = $request->file($field);
                $filename = time() . '_' . $field . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('documents', $filename, 'public');
                $documentPaths[$field] = $path;
            }
        }

        // Simpan ke database
        ShipPermit::create([
            'email' => $request->email,
            'name' => $request->name,
            'ship_name' => $request->ship_name,
            'ship_type' => $request->ship_type,
            'flag' => $request->flag,
            'gross_tonnage' => $request->gross_tonnage,
            'captain_name' => $request->captain_name,
            'owner_agent' => $request->owner_agent,
            'departure_location' => $request->departure_location,
            'destination' => $request->destination,
            'purpose' => $request->purpose,
            'passenger_count' => $request->passenger_count,
            'movement_time' => $request->movement_time,
            'application_date' => Carbon::parse($request->application_date),
            'document_1' => $documentPaths['document_1'] ?? null,
            'document_2' => null,
            'document_3' => $documentPaths['document_3'] ?? null,
            'document_4' => $documentPaths['document_4'] ?? null,
            'document_5' => $documentPaths['document_5'] ?? null,
            'document_6' => $documentPaths['document_6'] ?? null,
            'document_7' => null,
            'status' => 'pending',
            'upt_id' => auth()->user()->upt_id ?? null,
        ]);

        return redirect()->route('dashboard')
            ->with('success', '✅ Permohonan berhasil disimpan! Status: Menunggu persetujuan.');
    }

    /**
     * Tampilkan detail permohonan
     */
    public function detail($id)
    {
        $permit = ShipPermit::with('upt')->findOrFail($id);

        if (auth()->check() && !auth()->user()->isAdmin()) {
            if ($permit->email !== auth()->user()->email) {
                abort(403, 'Anda tidak memiliki akses untuk melihat permohonan ini.');
            }
        }

        return view('permohonan.detail', compact('permit'));
    }

    /**
     * Download dokumen
     */
    public function download($id, $document, $action = null)
    {
        $permit = ShipPermit::findOrFail($id);

        if (auth()->check() && !auth()->user()->isAdmin()) {
            if ($permit->email !== auth()->user()->email) {
                abort(403, 'Anda tidak memiliki akses untuk mengunduh dokumen ini.');
            }
        }

        if (!in_array($document, [1, 3, 4, 5, 6])) {
            return back()->with('error', 'Dokumen tidak valid!');
        }

        $documentField = "document_{$document}";

        if (empty($permit->$documentField)) {
            return back()->with('error', 'Dokumen tidak ditemukan!');
        }

        $path = Storage::disk('public')->path($permit->$documentField);
        $filename = 'document_' . $document . '_' . ($permit->ship_name ?? $permit->ship_type) . '.pdf';

        if ($action === 'view') {
            return response()->file($path, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . $filename . '"'
            ]);
        }

        if ($action === 'download') {
            return response()->download($path, $filename, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"'
            ]);
        }

        return Storage::disk('public')->download($permit->$documentField, $filename);
    }

    /**
     * Tampilkan form edit untuk user
     */
    public function editUser($id)
    {
        $permit = ShipPermit::findOrFail($id);

        if (auth()->check() && !auth()->user()->isAdmin()) {
            if ($permit->email !== auth()->user()->email) {
                abort(403, 'Anda tidak memiliki akses untuk mengedit permohonan ini.');
            }
        }

        if (!in_array($permit->status, ['pending', 'rejected'])) {
            return redirect()->route('permohonan.detail', $permit->id)
                ->with('error', 'Permohonan yang sudah disetujui tidak dapat diedit.');
        }

        return view('permohonan.edit-permit', compact('permit'));
    }

    /**
     * ✅ UPDATE data permohonan oleh user - FINAL FIX
     */
    public function updateUser(Request $request, $id)
    {
        \Log::info('=== UPDATE PERMIT START ===', [
            'permit_id' => $id,
            'user_id' => auth()->id(),
        ]);

        try {
            $permit = ShipPermit::findOrFail($id);
            $oldStatus = $permit->status;

            \Log::info('Permit found', [
                'current_status' => $permit->status,
                'email' => $permit->email,
            ]);

            // Cek akses
            if (auth()->check() && !auth()->user()->isAdmin()) {
                if ($permit->email !== auth()->user()->email) {
                    abort(403, 'Anda tidak memiliki akses untuk mengupdate permohonan ini.');
                }
            }

            // Cek status
            if (!in_array($permit->status, ['pending', 'rejected'])) {
                return redirect()->route('permohonan.detail', $permit->id)
                    ->with('error', 'Permohonan yang sudah disetujui tidak dapat diubah.');
            }

            // Validasi
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|max:255',
                'name' => 'required|string|max:255',
                'ship_name' => 'required|string|max:255',
                'ship_type' => 'required|string|max:255',
                'flag' => 'required|string|max:100',
                'gross_tonnage' => 'required|integer|min:1',
                'captain_name' => 'required|string|max:255',
                'owner_agent' => 'required|string|max:255',
                'departure_location' => 'required|string|max:255',
                'destination' => 'required|string|max:255',
                'purpose' => 'required|string',
                'passenger_count' => 'nullable|integer|min:1',
                'movement_time' => 'nullable|string|max:255',
                'application_date' => 'required|date',
                'document_1' => 'nullable|file|mimes:pdf|max:10240',
                'document_3' => 'nullable|file|mimes:pdf|max:10240',
                'document_4' => 'nullable|file|mimes:pdf|max:10240',
                'document_5' => 'nullable|file|mimes:pdf|max:10240',
                'document_6' => 'nullable|file|mimes:pdf|max:10240',
            ]);

            if ($validator->fails()) {
                \Log::error('Validation failed', ['errors' => $validator->errors()]);
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            \Log::info('Validation passed');

            // Siapkan data update
            $updateData = [
                'email' => $request->email,
                'name' => $request->name,
                'ship_name' => $request->ship_name,
                'ship_type' => $request->ship_type,
                'flag' => $request->flag,
                'gross_tonnage' => $request->gross_tonnage,
                'captain_name' => $request->captain_name,
                'owner_agent' => $request->owner_agent,
                'departure_location' => $request->departure_location,
                'destination' => $request->destination,
                'purpose' => $request->purpose,
                'passenger_count' => $request->passenger_count,
                'movement_time' => $request->movement_time,
                'application_date' => Carbon::parse($request->application_date),
                'updated_at' => now(),
            ];

            // Handle file uploads
            for ($i = 1; $i <= 7; $i++) {
                if ($i == 2 || $i == 7) continue;

                $field = "document_{$i}";
                if ($request->hasFile($field)) {
                    if (!empty($permit->$field)) {
                        Storage::disk('public')->delete($permit->$field);
                    }

                    $file = $request->file($field);
                    $filename = time() . '_' . $field . '_' . $file->getClientOriginalName();
                    $path = $file->storeAs('documents', $filename, 'public');
                    $updateData[$field] = $path;
                }
            }

            // Jika status rejected, ubah ke pending
            if ($oldStatus === 'rejected') {
                $updateData['status'] = 'pending';
                $updateData['rejection_notes'] = null;
                $updateData['rejected_at'] = null;
                $updateData['rejected_by'] = null;

                \Log::info('Status changed from rejected to pending');
            }

            // Update database
            $updated = $permit->update($updateData);

            if (!$updated) {
                return redirect()->back()->with('error', 'Gagal mengupdate data.');
            }

            // Reload dari database
            $permit->refresh();

            \Log::info('Permit updated', [
                'new_status' => $permit->status,
            ]);

            // Notify admin jika sebelumnya rejected
            if ($oldStatus === 'rejected') {
                try {
                    $adminUsers = User::where('role', 'admin')->get();
                    foreach ($adminUsers as $admin) {
                        $admin->notify(new PermitEditedAfterRejection($permit, auth()->user()));
                    }
                } catch (\Exception $e) {
                    \Log::error('Failed to send notification', ['error' => $e->getMessage()]);
                }
            }

            // Redirect ke detail dengan flash message
            return redirect()->route('permohonan.detail', $permit->id)
                ->with('success', '✅ Permohonan berhasil diupdate!' .
                    ($oldStatus === 'rejected' ? ' Status telah diubah menjadi Pending.' : ''));

        } catch (\Exception $e) {
            \Log::error('UPDATE FAILED', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()->back()
                ->with('error', 'Error: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Generate dan download surat SPOG
     */
    public function downloadSPOGUser($id)
    {
        $permit = ShipPermit::with('upt')->findOrFail($id);

        if (auth()->check() && !auth()->user()->isAdmin()) {
            if ($permit->email !== auth()->user()->email) {
                abort(403, 'Anda tidak memiliki akses untuk mengunduh surat ini.');
            }
        }

        if ($permit->status !== 'approved') {
            return back()->with('error', 'Surat SPOG hanya dapat diunduh setelah permohonan disetujui.');
        }

        $permitNumber = $this->generatePermitNumber($permit);

        $data = [
            'permit' => $permit,
            'permit_number' => $permitNumber,
            'generated_at' => now()->format('d F Y'),
            'office' => $permit->upt->name ?? 'KANTOR KESYAHBANDARAN DAN OTORITAS PELABUHAN',
            'office_type' => $this->getOfficeType($permit->upt->code ?? ''),
        ];

        $pdf = Pdf::loadView('pdf.spog', $data)
            ->setPaper('a4', 'portrait')
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('isRemoteEnabled', true)
            ->setOption('defaultFont', 'Times New Roman');

        $shipIdentifier = $permit->ship_name ?? $permit->ship_type;
        $filename = 'SPOG_' . strtoupper(str_replace(' ', '_', $shipIdentifier)) . '_' .
                    $permit->application_date->format('Ymd') . '.pdf';

        return $pdf->download($filename);
    }

    /**
     * Generate nomor surat
     */
    private function generatePermitNumber($permit)
    {
        $officeType = $this->getOfficeType($permit->upt->code ?? '');
        $code = $permit->upt->code ?? 'XXX';
        $month = $permit->application_date->format('m');
        $year = $permit->application_date->format('Y');
        $sequence = str_pad($permit->id, 4, '0', STR_PAD_LEFT);

        return "{$officeType}/{$code}/{$sequence}/{$month}/{$year}";
    }

    /**
     * Dapatkan jenis kantor
     */
    private function getOfficeType($code)
    {
        if (stripos($code, 'KHUSUS') !== false) {
            return 'KSOPKHUSUS';
        } elseif (stripos($code, 'KSU') !== false) {
            return 'KSU';
        } elseif (stripos($code, 'UPP') !== false) {
            return 'UPP';
        }
        return 'KSOP';
    }
}
