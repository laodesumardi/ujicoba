<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Display the teacher's profile.
     */
    public function show()
    {
        $teacher = Auth::user();
        
        return view('teacher.profile.show', compact('teacher'));
    }

    /**
     * Show the form for editing the teacher's profile.
     */
    public function edit()
    {
        $teacher = Auth::user();
        
        return view('teacher.profile.edit', compact('teacher'));
    }

    /**
     * Update the teacher's profile.
     */
    public function update(Request $request)
    {
        $teacher = Auth::user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $teacher->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|string|in:Laki-laki,Perempuan',
            'religion' => 'nullable|string|in:Islam,Kristen,Katolik,Hindu,Buddha,Konghucu',
            'subject' => 'nullable|string|max:255',
            'position' => 'nullable|string|max:255',
            'employment_status' => 'nullable|string|in:Aktif,Non-Aktif,Cuti',
            'join_date' => 'nullable|date',
            'education' => 'nullable|string|max:255',
            'certification' => 'nullable|string|max:255',
            'experience_years' => 'nullable|integer|min:0',
            'bio' => 'nullable|string|max:1000',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'current_password' => 'nullable|string',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        // Update basic information
        $teacher->name = $request->name;
        $teacher->email = $request->email;
        
        // Update teacher information
        $teacher->phone = $request->phone;
        $teacher->address = $request->address;
        $teacher->date_of_birth = $request->date_of_birth;
        $teacher->gender = $request->gender;
        $teacher->religion = $request->religion;
        
        // Update professional information
        $teacher->subject = $request->subject;
        $teacher->position = $request->position;
        $teacher->employment_status = $request->employment_status;
        $teacher->join_date = $request->join_date;
        $teacher->education = $request->education;
        $teacher->certification = $request->certification;
        $teacher->experience_years = $request->experience_years;
        $teacher->bio = $request->bio;

        // Handle photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($teacher->photo && Storage::disk('public')->exists($teacher->photo)) {
                Storage::disk('public')->delete($teacher->photo);
            }
            
            // Store new photo
            $photoPath = $request->file('photo')->store('teachers/photos', 'public');
            $teacher->photo = $photoPath;
        }

        // Update password if provided
        if ($request->filled('password')) {
            if ($request->filled('current_password')) {
                if (!Hash::check($request->current_password, $teacher->password)) {
                    return redirect()->back()
                        ->withErrors(['current_password' => 'Password saat ini tidak benar.'])
                        ->withInput();
                }
            }
            
            $teacher->password = Hash::make($request->password);
        }

        $teacher->save();

        return redirect()->route('teacher.profile')
            ->with('success', 'Profil berhasil diperbarui!');
    }

    /**
     * Delete teacher's photo.
     */
    public function deletePhoto()
    {
        $teacher = Auth::user();
        
        if ($teacher->photo && Storage::disk('public')->exists($teacher->photo)) {
            Storage::disk('public')->delete($teacher->photo);
            $teacher->photo = null;
            $teacher->save();
        }
        
        return redirect()->route('teacher.profile')
            ->with('success', 'Foto profil berhasil dihapus!');
    }
}