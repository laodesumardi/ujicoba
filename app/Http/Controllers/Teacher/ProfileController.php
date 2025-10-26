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
     * Display the teacher profile.
     */
    public function show()
    {
        $user = Auth::user();
        
        // Ambil data statistik dari database
        $stats = [
            'total_courses' => $user->courses()->count(),
            'total_students' => $user->courses()->withCount('enrollments')->get()->sum('enrollments_count'),
            'total_assignments' => $user->courses()->withCount('assignments')->get()->sum('assignments_count'),
            'total_forums' => $user->courses()->withCount('forums')->get()->sum('forums_count'),
        ];
        
        // Ambil data courses yang diajar
        $courses = $user->courses()
            ->with(['enrollments' => function($query) {
                $query->where('status', 'approved');
            }])
            ->withCount(['enrollments' => function($query) {
                $query->where('status', 'approved');
            }])
            ->latest()
            ->get();
        
        // Ambil recent assignments
        $recentAssignments = $user->courses()
            ->with(['assignments' => function($query) {
                $query->latest()->take(5);
            }])
            ->get()
            ->pluck('assignments')
            ->flatten()
            ->take(5);
        
        // Ambil recent forums
        $recentForums = $user->courses()
            ->with(['forums' => function($query) {
                $query->with('author')->latest()->take(5);
            }])
            ->get()
            ->pluck('forums')
            ->flatten()
            ->take(5);
        
        return view('teacher.profile.show', compact('user', 'stats', 'courses', 'recentAssignments', 'recentForums'));
    }

    /**
     * Show the form for editing the profile.
     */
    public function edit()
    {
        $user = Auth::user();
        
        return view('teacher.profile.edit', compact('user'));
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
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'subject' => 'nullable|string|max:255',
            'position' => 'nullable|string|max:255',
            'class_level' => 'nullable|string|in:VII,VIII,IX',
            'class_section' => 'nullable|string|in:A,B,C,D',
            'employment_status' => 'nullable|string|in:full-time,part-time,contract',
            'education' => 'nullable|string|max:255',
            'certification' => 'nullable|string|max:500',
            'experience_years' => 'nullable|integer|min:0|max:50',
            'bio' => 'nullable|string|max:1000',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'current_password' => 'nullable|string',
            'password' => 'nullable|string|min:8|confirmed',
        ]);
        
        $data = $request->only([
            'name', 'email', 'phone', 'address', 'subject', 'position',
            'class_level', 'class_section', 'employment_status', 'education', 
            'certification', 'experience_years', 'bio'
        ]);
        
        // Handle password change
        if ($request->filled('password')) {
            if (!$request->filled('current_password')) {
                return back()->withErrors(['current_password' => 'Password lama harus diisi untuk mengubah password.']);
            }
            
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Password lama tidak sesuai.']);
            }
            
            $data['password'] = Hash::make($request->password);
        }
        
        // Handle photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }
            
            $photo = $request->file('photo');
            $filename = time() . '_' . $user->id . '.' . $photo->getClientOriginalExtension();
            $path = $photo->storeAs('teachers/photos', $filename, 'public');
            $data['photo'] = $path;
        }
        
        $user->update($data);
        
        return redirect()->route('teacher.profile')
            ->with('success', 'Profil berhasil diperbarui!');
    }

    /**
     * Delete profile photo.
     */
    public function deletePhoto()
    {
        $user = Auth::user();
        
        if ($user->photo) {
            // Delete file from storage
            Storage::disk('public')->delete($user->photo);
            
            // Update database
            $user->update(['photo' => null]);
        }
        
        return redirect()->route('teacher.profile')
            ->with('success', 'Foto profil berhasil dihapus!');
    }
}