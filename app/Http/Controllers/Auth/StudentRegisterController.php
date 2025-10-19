<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class StudentRegisterController extends Controller
{
    /**
     * Show the student registration form.
     */
    public function showRegistrationForm()
    {
        return view('auth.student-register');
    }

    /**
     * Handle student registration.
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Password::defaults()],
            'class_level' => 'required|string|in:VII,VIII,IX',
            'class_section' => 'required|string|in:A,B,C,D',
            'student_id' => 'required|string|max:20|unique:users,student_id',
            'phone' => 'nullable|string|max:20',
            'address' => 'required|string|max:500',
            'date_of_birth' => 'required|date|before:today',
            'gender' => 'required|string|in:L,P',
            'religion' => 'required|string|in:Islam,Kristen,Katolik,Hindu,Buddha,Konghucu',
            'previous_school' => 'nullable|string|max:255',
            'previous_school_address' => 'nullable|string|max:500',
            'graduation_year' => 'nullable|integer|min:2015|max:2024',
            'transfer_reason' => 'nullable|string|in:Mutasi,Pindah Domisili,Siswa Baru,Lainnya',
            'blood_type' => 'nullable|string|in:A,B,AB,O,Tidak Tahu',
            'allergies' => 'nullable|string|max:255',
            'medical_conditions' => 'nullable|string|max:1000',
            'parent_name' => 'nullable|string|max:255',
            'parent_phone' => 'nullable|string|max:20',
            'parent_email' => 'nullable|email|max:255',
        ], [
            'name.required' => 'Nama lengkap harus diisi.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Password harus diisi.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'class_level.required' => 'Kelas harus dipilih.',
            'class_level.in' => 'Kelas tidak valid.',
            'student_id.required' => 'NIS harus diisi.',
            'student_id.unique' => 'NIS sudah terdaftar.',
            'phone.max' => 'Nomor telepon maksimal 20 karakter.',
            'address.max' => 'Alamat maksimal 500 karakter.',
            'date_of_birth.before' => 'Tanggal lahir harus sebelum hari ini.',
            'parent_name.max' => 'Nama orang tua maksimal 255 karakter.',
            'parent_phone.max' => 'Nomor telepon orang tua maksimal 20 karakter.',
            'parent_email.email' => 'Format email orang tua tidak valid.',
        ]);

        // Create student user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'student',
            'student_id' => $request->student_id,
            'class_level' => $request->class_level,
            'class_section' => $request->class_section,
            'phone' => $request->phone,
            'address' => $request->address,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
            'religion' => $request->religion,
            'previous_school' => $request->previous_school,
            'previous_school_address' => $request->previous_school_address,
            'graduation_year' => $request->graduation_year,
            'transfer_reason' => $request->transfer_reason,
            'blood_type' => $request->blood_type,
            'allergies' => $request->allergies,
            'medical_conditions' => $request->medical_conditions,
            'parent_name' => $request->parent_name,
            'parent_phone' => $request->parent_phone,
            'parent_email' => $request->parent_email,
            'is_active' => true,
        ]);

        // Create notification for admin
        Notification::createPPDBRegistration($user->name, $user->id);

        // Auto login after registration
        Auth::login($user);

        return redirect()->route('student.dashboard')
            ->with('success', 'Registrasi berhasil! Selamat datang di portal siswa SMP Negeri 01 Namrole.');
    }
}