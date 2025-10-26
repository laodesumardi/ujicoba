<?php

namespace App\Http\Controllers\PPDB;

use App\Http\Controllers\Controller;
use App\Models\PPDBRegistration;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class PanitiaController extends Controller
{
    // Middleware akan diterapkan di route

    /**
     * Dashboard panitia PPDB
     */
    public function dashboard()
    {
        $stats = [
            'total_registrations' => PPDBRegistration::count(),
            'pending_registrations' => PPDBRegistration::where('status', 'pending')->count(),
            'approved_registrations' => PPDBRegistration::where('status', 'approved')->count(),
            'rejected_registrations' => PPDBRegistration::where('status', 'rejected')->count(),
            'today_registrations' => PPDBRegistration::whereDate('created_at', today())->count(),
            'this_month_registrations' => PPDBRegistration::whereMonth('created_at', now()->month)->count(),
        ];

        $recent_registrations = PPDBRegistration::latest()
            ->limit(10)
            ->get();

        $status_distribution = PPDBRegistration::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status');

        return view('ppdb.panitia.dashboard', compact('stats', 'recent_registrations', 'status_distribution'));
    }

    /**
     * Daftar semua pendaftaran
     */
    public function index(Request $request)
    {
        $query = PPDBRegistration::query();

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan tanggal
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('student_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('registration_number', 'like', "%{$search}%");
            });
        }

        $registrations = $query->latest()->paginate(20);

        return view('ppdb.panitia.index', compact('registrations'));
    }

    /**
     * Detail pendaftaran
     */
    public function show(PPDBRegistration $registration)
    {
        $registration->load('user');
        return view('ppdb.panitia.show', compact('registration'));
    }

    /**
     * Update status pendaftaran
     */
    public function updateStatus(Request $request, PPDBRegistration $registration)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
            'notes' => 'nullable|string|max:1000'
        ]);

        $registration->update([
            'status' => $request->status,
            'notes' => $request->notes,
            'processed_at' => now(),
            'processed_by' => auth()->id()
        ]);

        // Jika disetujui, buat akun siswa
        if ($request->status === 'approved' && !$this->hasUserAccount($registration)) {
            $this->createStudentAccount($registration);
        }

        return redirect()->back()->with('success', 'Status pendaftaran berhasil diperbarui.');
    }

    /**
     * Buat akun siswa untuk pendaftaran yang disetujui
     */
    private function createStudentAccount(PPDBRegistration $registration)
    {
        if (empty($registration->email)) {
            \Log::warning("Cannot create account for registration {$registration->id}: No email provided");
            return;
        }

        // Cek apakah email sudah terdaftar
        if (User::where('email', $registration->email)->exists()) {
            \Log::warning("Email {$registration->email} already exists for registration {$registration->id}");
            return;
        }

        // Generate username dari nama
        $username = strtolower(str_replace(' ', '', $registration->name));
        $originalUsername = $username;
        $counter = 1;
        
        while (User::where('username', $username)->exists()) {
            $username = $originalUsername . $counter;
            $counter++;
        }

        // Buat user baru
        $user = User::create([
            'name' => $registration->name,
            'email' => $registration->email,
            'username' => $username,
            'password' => Hash::make('password123'), // Default password
            'role' => 'student',
            'is_active' => true,
            'student_id' => $registration->student_id,
            'class' => $registration->class ?? 'VII A',
            'phone' => $registration->phone,
            'address' => $registration->address,
            'date_of_birth' => $registration->date_of_birth,
            'gender' => $registration->gender,
            'religion' => $registration->religion,
            'parent_name' => $registration->parent_name,
            'parent_phone' => $registration->parent_phone,
            'parent_email' => $registration->parent_email,
        ]);

        // Update registration dengan user_id
        $registration->update(['user_id' => $user->id]);

        \Log::info("Student account created for registration {$registration->id}: {$user->email}");
    }

    /**
     * Cek apakah pendaftaran sudah memiliki akun user
     */
    private function hasUserAccount(PPDBRegistration $registration)
    {
        if (empty($registration->email)) {
            return false;
        }
        
        return User::where('email', $registration->email)->exists();
    }

    /**
     * Manual create account untuk pendaftaran yang sudah disetujui
     */
    public function createManualAccount(PPDBRegistration $registration)
    {
        if ($this->hasUserAccount($registration)) {
            return redirect()->back()->with('error', 'Akun sudah dibuat untuk pendaftaran ini.');
        }

        $this->createStudentAccount($registration);

        return redirect()->back()->with('success', 'Akun siswa berhasil dibuat secara manual.');
    }

    /**
     * Update data pendaftaran
     */
    public function update(Request $request, PPDBRegistration $registration)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('ppdb_registrations')->ignore($registration->id),
                Rule::unique('users', 'email')
            ],
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:male,female',
            'religion' => 'nullable|string|max:50',
            'parent_name' => 'nullable|string|max:255',
            'parent_phone' => 'nullable|string|max:20',
            'parent_email' => 'nullable|email|max:255',
            'class' => 'nullable|string|max:20',
        ]);

        $registration->update($request->all());

        return redirect()->back()->with('success', 'Data pendaftaran berhasil diperbarui.');
    }

    /**
     * Export data pendaftaran
     */
    public function export(Request $request)
    {
        $query = PPDBRegistration::query();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $registrations = $query->orderBy('created_at', 'desc')->get();

        // Generate CSV content
        $csvData = [];
        
        // CSV Header
        $csvData[] = [
            'No. Pendaftaran',
            'Nama Siswa',
            'Tempat Lahir',
            'Tanggal Lahir',
            'Jenis Kelamin',
            'Alamat',
            'Nama Orang Tua',
            'Telepon Orang Tua',
            'Email',
            'Status',
            'Tanggal Daftar',
            'Catatan'
        ];

        // CSV Data
        foreach ($registrations as $index => $registration) {
            $csvData[] = [
                $registration->registration_number,
                $registration->student_name,
                $registration->birth_place,
                $registration->birth_date ? $registration->birth_date->format('d/m/Y') : '',
                $registration->gender,
                $registration->address,
                $registration->parent_name,
                $registration->parent_phone,
                $registration->email,
                $this->getStatusText($registration->status),
                $registration->created_at->format('d/m/Y H:i'),
                $registration->notes ?? ''
            ];
        }

        // Convert to CSV string
        $csvContent = '';
        foreach ($csvData as $row) {
            $csvContent .= implode(',', array_map(function($field) {
                return '"' . str_replace('"', '""', $field) . '"';
            }, $row)) . "\n";
        }

        // Generate filename
        $filename = 'ppdb_registrations_' . now()->format('Y-m-d_H-i-s') . '.csv';

        // Return CSV download response
        return response($csvContent)
            ->header('Content-Type', 'text/csv; charset=UTF-8')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"')
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    /**
     * Get status text in Indonesian
     */
    private function getStatusText($status)
    {
        switch ($status) {
            case 'pending':
                return 'Menunggu Review';
            case 'approved':
                return 'Diterima';
            case 'rejected':
                return 'Ditolak';
            default:
                return ucfirst($status);
        }
    }

    /**
     * Hapus pendaftaran
     */
    public function destroy(PPDBRegistration $registration)
    {
        // Hapus user terkait jika ada
        $user = User::where('email', $registration->email)->first();
        if ($user) {
            $user->delete();
        }

        $registration->delete();

        return redirect()->route('ppdb.panitia.index')->with('success', 'Pendaftaran berhasil dihapus.');
    }
}
