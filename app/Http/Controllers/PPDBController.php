<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PPDB;
use App\Models\PPDBRegistration;
use App\Models\Notification;
use Barryvdh\DomPDF\Facade\Pdf;

class PPDBController extends Controller
{
    /**
     * Display PPDB information page
     */
    public function index()
    {
        $ppdb = PPDB::active()->first();
        
        if (!$ppdb) {
            return view('ppdb.index', compact('ppdb'));
        }
        
        return view('ppdb.index', compact('ppdb'));
    }


    /**
     * Show registration form
     */
    public function register()
    {
        $ppdb = PPDB::active()->first();
        
        if (!$ppdb || !$ppdb->isRegistrationOpen()) {
            return redirect()->route('ppdb.index')
                           ->with('error', 'Pendaftaran PPDB belum dibuka atau sudah ditutup.');
        }
        
        return view('ppdb.register', compact('ppdb'));
    }

    /**
     * Store registration data
     */
    public function store(Request $request)
    {
        $ppdb = PPDB::active()->first();
        
        if (!$ppdb || !$ppdb->isRegistrationOpen()) {
            return redirect()->route('ppdb.index')
                           ->with('error', 'Pendaftaran PPDB belum dibuka atau sudah ditutup.');
        }

        $request->validate([
            'student_name' => 'required|string|max:255',
            'birth_place' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'gender' => 'required|in:L,P',
            'religion' => 'required|string|max:255',
            'address' => 'required|string',
            'phone_number' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'parent_name' => 'required|string|max:255',
            'parent_phone' => 'required|string|max:20',
            'parent_occupation' => 'required|string|max:255',
            'previous_school' => 'nullable|string|max:255',
            'achievements' => 'nullable|string',
            'motivation' => 'nullable|string',
            'photo' => 'nullable|file|mimes:jpeg,png,jpg|max:2048',
            'birth_certificate' => 'nullable|file|mimes:pdf,jpeg,png,jpg|max:5120',
            'family_card' => 'nullable|file|mimes:pdf,jpeg,png,jpg|max:5120',
            'report_card' => 'nullable|file|mimes:pdf,jpeg,png,jpg|max:5120',
        ]);

        $data = $request->all();
        $data['registration_number'] = PPDBRegistration::generateRegistrationNumber();

        // Handle file uploads
        if ($request->hasFile('photo')) {
            $data['photo'] = $this->uploadFile($request->file('photo'), 'photos');
        }
        if ($request->hasFile('birth_certificate')) {
            $data['birth_certificate'] = $this->uploadFile($request->file('birth_certificate'), 'documents');
        }
        if ($request->hasFile('family_card')) {
            $data['family_card'] = $this->uploadFile($request->file('family_card'), 'documents');
        }
        if ($request->hasFile('report_card')) {
            $data['report_card'] = $this->uploadFile($request->file('report_card'), 'documents');
        }

        $registration = PPDBRegistration::create($data);

        return redirect()->route('ppdb.success')
                       ->with('success', 'Pendaftaran berhasil! Nomor pendaftaran Anda: ' . $data['registration_number'])
                       ->with('registration_id', $registration->id);
    }

    /**
     * Show registration success page
     */
    public function success()
    {
        // Create notification for admin when someone visits success page
        Notification::createSystem(
            'PPDB Success Page Accessed',
            'Seseorang telah mengakses halaman sukses PPDB',
            'green'
        );
        
        return view('ppdb.success');
    }

    /**
     * Download registration form as PDF
     */
    public function downloadForm($id)
    {
        $registration = PPDBRegistration::findOrFail($id);
        
        // Generate PDF using DomPDF
        $pdf = Pdf::loadView('ppdb.registration-form-pdf', compact('registration'));
        
        $filename = 'Form_Pendaftaran_' . $registration->registration_number . '.pdf';
        
        return $pdf->download($filename);
    }

    /**
     * Check registration status
     */
    public function checkStatus(Request $request)
    {
        // Handle AJAX request for email-based status check
        if ($request->ajax() || $request->wantsJson()) {
            $request->validate([
                'email' => 'required|email'
            ]);

            $registration = PPDBRegistration::where('email', $request->email)->first();
            
            if (!$registration) {
                return response()->json([
                    'status' => 'not_found',
                    'message' => 'Email tidak ditemukan dalam database PPDB.'
                ]);
            }

            return response()->json([
                'status' => $registration->status,
                'message' => $this->getStatusMessage($registration->status),
                'registration_number' => $registration->registration_number
            ]);
        }

        // Handle regular form submission
        $registrationNumber = $request->input('registration_number');
        
        if (!$registrationNumber) {
            return view('ppdb.check-status');
        }

        $registration = PPDBRegistration::where('registration_number', $registrationNumber)->first();
        
        return view('ppdb.check-status', compact('registration'));
    }

    /**
     * Get status message based on PPDB status
     */
    private function getStatusMessage($status)
    {
        switch ($status) {
            case 'pending':
                return 'Pendaftaran Anda sedang dalam proses review. Silakan tunggu konfirmasi dari admin.';
            case 'approved':
                return 'Pendaftaran Anda telah disetujui! Anda sekarang dapat melakukan registrasi sebagai siswa.';
            case 'rejected':
                return 'Maaf, pendaftaran Anda ditolak. Silakan hubungi admin untuk informasi lebih lanjut.';
            default:
                return 'Status pendaftaran tidak diketahui.';
        }
    }

    /**
     * Refresh CSRF token for mobile
     */
    public function refreshToken()
    {
        return response()->json([
            'token' => csrf_token(),
            'success' => true
        ]);
    }

    /**
     * Upload file helper
     */
    private function uploadFile($file, $folder)
    {
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs("ppdb/{$folder}", $filename, 'public');
        return $path;
    }
}
