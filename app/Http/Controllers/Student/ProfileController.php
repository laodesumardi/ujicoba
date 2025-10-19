<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Display the student profile.
     */
    public function show()
    {
        $user = Auth::user();
        
        return view('student.profile.show', compact('user'));
    }

    /**
     * Show the form for editing the profile.
     */
    public function edit()
    {
        $user = Auth::user();
        
        return view('student.profile.edit', compact('user'));
    }

    /**
     * Update the profile.
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'student_id' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'class_level' => 'required|string|in:VII,VIII,IX',
            'class_section' => 'nullable|string|in:A,B,C,D',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|string|in:Laki-laki,Perempuan',
            'religion' => 'nullable|string|in:Islam,Kristen,Katolik,Hindu,Buddha,Konghucu',
            'parent_name' => 'nullable|string|max:255',
            'parent_phone' => 'nullable|string|max:20',
            'parent_email' => 'nullable|email|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Max 2MB
            'current_password' => 'nullable|string',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        // Update basic information
        $user->name = $request->name;
        $user->email = $request->email;
        
        // Update student information
        $user->student_id = $request->student_id;
        $user->phone = $request->phone;
        $user->address = $request->address;
        
        // Update class information
        $user->class_level = $request->class_level;
        $user->class_section = $request->class_section;
        
        // Update personal information
        $user->date_of_birth = $request->date_of_birth;
        $user->gender = $request->gender;
        $user->religion = $request->religion;
        
        // Update parent information
        $user->parent_name = $request->parent_name;
        $user->parent_phone = $request->parent_phone;
        $user->parent_email = $request->parent_email;

        // Handle photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($user->photo && \Storage::disk('public')->exists($user->photo)) {
                \Storage::disk('public')->delete($user->photo);
            }
            
            // Store new photo
            $path = $request->file('photo')->store('students/photos', 'public');
            $user->photo = $path;
            
            // Copy uploaded files to public/storage for immediate access
            $sourcePath = storage_path('app/public/' . $path);
            $destPath = public_path('storage/' . $path);
            $destDir = dirname($destPath);
            
            if (!is_dir($destDir)) {
                mkdir($destDir, 0755, true);
            }
            
            if (copy($sourcePath, $destPath)) {
                \Log::info('Student photo copied to public storage: ' . $path);
            } else {
                \Log::error('Failed to copy student photo to public storage: ' . $path);
            }
        }

        // Update password if provided
        if ($request->filled('password')) {
            if ($request->filled('current_password')) {
                if (!Hash::check($request->current_password, $user->password)) {
                    return redirect()->back()
                        ->withErrors(['current_password' => 'Password saat ini tidak benar.'])
                        ->withInput();
                }
            }
            
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('student.profile')
            ->with('success', 'Profil berhasil diperbarui!');
    }

    /**
     * Delete the student's profile photo.
     */
    public function deletePhoto()
    {
        $user = Auth::user();

        if ($user->photo && \Storage::disk('public')->exists($user->photo)) {
            \Storage::disk('public')->delete($user->photo);
            $user->photo = null;
            $user->save();
            return redirect()->route('student.profile.edit')->with('success', 'Foto profil berhasil dihapus.');
        }

        return redirect()->route('student.profile.edit')->with('error', 'Tidak ada foto profil untuk dihapus.');
    }
}