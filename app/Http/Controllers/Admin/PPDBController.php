<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PPDB;
use App\Models\PPDBRegistration;
use App\Notifications\StudentAccountCreated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Notification;

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

        $oldStatus = $registration->status;
        
        $registration->update([
            'status' => $request->status,
            'notes' => $request->notes
        ]);

        // Jika status berubah menjadi approved, buat akun siswa otomatis
        if ($request->status === 'approved' && $oldStatus !== 'approved') {
            $this->createStudentAccount($registration);
        }

        return redirect()->route('admin.ppdb.registrations')
                       ->with('success', 'Status pendaftaran berhasil diperbarui!');
    }

    /**
     * Create student account automatically when PPDB is approved
     */
    private function createStudentAccount(PPDBRegistration $registration)
    {
        // Cek apakah email ada, jika tidak ada skip pembuatan akun
        if (empty($registration->email)) {
            \Log::warning('PPDB Registration ID ' . $registration->id . ' tidak memiliki email, skip pembuatan akun');
            return;
        }
        
        // Gunakan email sebagai username (email sekarang wajib)
        $username = $registration->email;
        
        // Generate password acak
        $password = $this->generateRandomPassword();
        
        // Cek apakah user sudah ada berdasarkan email
        $existingUser = \App\Models\User::where('email', $registration->email)->first();
        
        if ($existingUser) {
            // Update existing user dengan role student
            $existingUser->update([
                'role' => 'student',
                'student_id' => $registration->registration_number,
                'name' => $registration->student_name,
                'phone' => $registration->phone_number,
                'date_of_birth' => $registration->birth_date,
                'gender' => $registration->gender,
                'address' => $registration->address,
                'username' => $username,
                'class_level' => 'VII', // Default class level
                'class_section' => 'A', // Default class section
            ]);
        } else {
            // Buat user baru
            \App\Models\User::create([
                'name' => $registration->student_name,
                'email' => $registration->email,
                'password' => \Hash::make($password),
                'role' => 'student',
                'student_id' => $registration->registration_number,
                'phone' => $registration->phone_number,
                'date_of_birth' => $registration->birth_date,
                'gender' => $registration->gender,
                'address' => $registration->address,
                'username' => $username,
                'is_active' => true,
                'class_level' => 'VII', // Default class level
                'class_section' => 'A', // Default class section
            ]);
        }
        
        // Simpan informasi login di PPDB registration
        $registration->update([
            'student_username' => $username,
            'student_password' => $password, // Simpan password plain untuk ditampilkan
        ]);
        
        // Kirim email notifikasi ke siswa
        try {
            Notification::route('mail', $registration->email)
                ->notify(new StudentAccountCreated(
                    $registration->student_name,
                    $username,
                    $password,
                    url('/login')
                ));
        } catch (\Exception $e) {
            // Log error jika email gagal dikirim, tapi jangan stop proses
            \Log::error('Failed to send student account notification: ' . $e->getMessage());
        }
    }

    /**
     * Generate random password for student account
     */
    private function generateRandomPassword()
    {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $password = '';
        $length = 8;
        
        for ($i = 0; $i < $length; $i++) {
            $password .= $characters[rand(0, strlen($characters) - 1)];
        }
        
        return $password;
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

    /**
     * Update PPDB registration data
     */
    public function updateRegistration(Request $request, PPDBRegistration $registration)
    {
        $request->validate([
            'student_name' => 'required|string|max:255',
            'birth_place' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'gender' => 'required|in:L,P',
            'religion' => 'required|string|max:255',
            'address' => 'required|string',
            'phone_number' => 'required|string|max:20',
            'email' => [
                'required',
                'email',
                'max:255',
                function ($attribute, $value, $fail) use ($registration) {
                    // Cek apakah email sudah terdaftar di tabel users (kecuali untuk registration ini)
                    if (\App\Models\User::where('email', $value)->exists()) {
                        $fail('Email ' . $value . ' sudah terdaftar. Silakan gunakan email lain atau hubungi admin jika ini adalah email Anda.');
                    }
                    
                    // Cek apakah email sudah terdaftar di PPDB registrations (kecuali untuk registration ini)
                    if (\App\Models\PPDBRegistration::where('email', $value)->where('id', '!=', $registration->id)->exists()) {
                        $fail('Email ' . $value . ' sudah digunakan untuk pendaftaran PPDB lainnya. Silakan gunakan email lain.');
                    }
                }
            ],
            'parent_name' => 'required|string|max:255',
            'parent_phone' => 'required|string|max:20',
            'parent_occupation' => 'required|string|max:255',
            'previous_school' => 'nullable|string|max:255',
            'achievements' => 'nullable|string',
            'motivation' => 'nullable|string',
        ]);

        $registration->update($request->all());

        return redirect()->route('admin.ppdb.show-registration', $registration)
            ->with('success', 'Data pendaftaran berhasil diperbarui!');
    }

    /**
     * Manually create student account for approved PPDB without email
     */
    public function createManualAccount(PPDBRegistration $registration)
    {
        // Cek apakah sudah ada akun
        if ($registration->student_username) {
            return redirect()->route('admin.ppdb.registrations')
                ->with('error', 'Akun untuk pendaftaran ini sudah dibuat sebelumnya.');
        }
        
        // Generate username dari nama + ID
        $username = strtolower(str_replace(' ', '', $registration->student_name)) . $registration->id;
        $password = $this->generateRandomPassword();
        
        // Buat user baru
        $user = \App\Models\User::create([
            'name' => $registration->student_name,
            'email' => $username . '@student.local', // Email dummy
            'password' => \Hash::make($password),
            'role' => 'student',
            'student_id' => $registration->registration_number,
            'phone' => $registration->phone_number,
            'date_of_birth' => $registration->birth_date,
            'gender' => $registration->gender,
            'address' => $registration->address,
            'username' => $username,
            'is_active' => true,
            'class_level' => 'VII',
            'class_section' => 'A',
        ]);
        
        // Update PPDB registration
        $registration->update([
            'student_username' => $username,
            'student_password' => $password,
        ]);
        
        return redirect()->route('admin.ppdb.registrations')
            ->with('success', 'Akun berhasil dibuat! Username: ' . $username . ', Password: ' . $password);
    }

    /**
     * Delete PPDB registration.
     */
    public function deleteRegistration(PPDBRegistration $registration)
    {
        try {
            // Delete associated files if they exist
            $files = [
                $registration->photo,
                $registration->birth_certificate,
                $registration->family_card,
                $registration->report_card
            ];

            foreach ($files as $file) {
                if ($file && Storage::disk('public')->exists($file)) {
                    Storage::disk('public')->delete($file);
                }
            }

            // Delete the registration
            $registration->delete();

            return redirect()->route('admin.ppdb.registrations')
                ->with('success', 'Pendaftaran PPDB berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('admin.ppdb.registrations')
                ->with('error', 'Gagal menghapus pendaftaran PPDB: ' . $e->getMessage());
        }
    }
}
