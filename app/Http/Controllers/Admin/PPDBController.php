<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PPDB;
use App\Models\PPDBRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PPDBController extends Controller
{
    /**
     * Display a listing of PPDB information.
     */
    public function index()
    {
        $ppdbInfo = PPDB::first();
        return view('admin.ppdb.index', compact('ppdbInfo'));
    }

    /**
     * Show the form for creating PPDB information.
     */
    public function create()
    {
        return view('admin.ppdb.create');
    }

    /**
     * Store a newly created PPDB information.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'requirements' => 'nullable|string',
            'schedule' => 'nullable|string',
            'technical_guide' => 'nullable|string',
            'faq' => 'nullable|string',
            'contact_person' => 'nullable|string|max:255',
            'contact_phone' => 'nullable|string|max:20',
            'contact_email' => 'nullable|email|max:255',
            'registration_link' => 'nullable|url|max:255',
            'registration_start' => 'nullable|date',
            'registration_end' => 'nullable|date|after_or_equal:registration_start',
            'quota' => 'nullable|integer|min:0',
            'is_active' => 'boolean'
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');

        PPDB::create($data);

        return redirect()->route('admin.ppdb.index')
                       ->with('success', 'Informasi PPDB berhasil dibuat!');
    }

    /**
     * Display the specified PPDB information.
     */
    public function show(PPDB $ppdb)
    {
        return view('admin.ppdb.show', compact('ppdb'));
    }

    /**
     * Show the form for editing PPDB information.
     */
    public function edit(PPDB $ppdb)
    {
        return view('admin.ppdb.edit', compact('ppdb'));
    }

    /**
     * Update the specified PPDB information.
     */
    public function update(Request $request, PPDB $ppdb)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'requirements' => 'nullable|string',
            'schedule' => 'nullable|string',
            'technical_guide' => 'nullable|string',
            'faq' => 'nullable|string',
            'contact_person' => 'nullable|string|max:255',
            'contact_phone' => 'nullable|string|max:20',
            'contact_email' => 'nullable|email|max:255',
            'registration_link' => 'nullable|url|max:255',
            'registration_start' => 'nullable|date',
            'registration_end' => 'nullable|date|after_or_equal:registration_start',
            'quota' => 'nullable|integer|min:0',
            'is_active' => 'boolean'
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');

        $ppdb->update($data);

        return redirect()->route('admin.ppdb.index')
                       ->with('success', 'Informasi PPDB berhasil diperbarui!');
    }

    /**
     * Remove the specified PPDB information.
     */
    public function destroy(PPDB $ppdb)
    {
        $ppdb->delete();
        return redirect()->route('admin.ppdb.index')
                       ->with('success', 'Informasi PPDB berhasil dihapus!');
    }

    /**
     * Display PPDB registrations.
     */
    public function registrations()
    {
        $registrations = PPDBRegistration::orderBy('created_at', 'desc')->paginate(20);
        return view('admin.ppdb.registrations', compact('registrations'));
    }

    /**
     * Show specific registration details.
     */
    public function showRegistration(PPDBRegistration $registration)
    {
        return view('admin.ppdb.show-registration', compact('registration'));
    }

    /**
     * Update registration status.
     */
    public function updateRegistrationStatus(Request $request, PPDBRegistration $registration)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
            'notes' => 'nullable|string'
        ]);

        $registration->update([
            'status' => $request->status,
            'notes' => $request->notes
        ]);

        return redirect()->route('admin.ppdb.registrations')
                       ->with('success', 'Status pendaftaran berhasil diperbarui!');
    }

    /**
     * Download registration documents.
     */
    public function downloadDocument(PPDBRegistration $registration, $type)
    {
        $validTypes = ['photo', 'birth_certificate', 'family_card', 'report_card'];
        
        if (!in_array($type, $validTypes)) {
            abort(404);
        }

        $filePath = $registration->$type;
        
        if (!$filePath || !Storage::disk('public')->exists($filePath)) {
            abort(404);
        }

        return Storage::disk('public')->download($filePath);
    }

    /**
     * Export registrations to CSV.
     */
    public function exportRegistrations()
    {
        $registrations = PPDBRegistration::all();
        
        $filename = 'ppdb_registrations_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($registrations) {
            $file = fopen('php://output', 'w');
            
            // CSV Header
            fputcsv($file, [
                'No. Pendaftaran',
                'Nama Siswa',
                'Tempat Lahir',
                'Tanggal Lahir',
                'Jenis Kelamin',
                'Agama',
                'Alamat',
                'No. Telepon',
                'Email',
                'Nama Orang Tua',
                'No. Telepon Orang Tua',
                'Pekerjaan Orang Tua',
                'Sekolah Asal',
                'Prestasi',
                'Motivasi',
                'Status',
                'Catatan',
                'Tanggal Daftar'
            ]);

            // CSV Data
            foreach ($registrations as $registration) {
                fputcsv($file, [
                    $registration->registration_number,
                    $registration->student_name,
                    $registration->birth_place,
                    $registration->birth_date->format('d/m/Y'),
                    $registration->gender == 'L' ? 'Laki-laki' : 'Perempuan',
                    $registration->religion,
                    $registration->address,
                    $registration->phone_number,
                    $registration->email,
                    $registration->parent_name,
                    $registration->parent_phone,
                    $registration->parent_occupation,
                    $registration->previous_school,
                    $registration->achievements,
                    $registration->motivation,
                    ucfirst($registration->status),
                    $registration->notes,
                    $registration->created_at->format('d/m/Y H:i')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
