<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Achievement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AchievementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $achievements = Achievement::orderBy('sort_order')->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.achievements.index', compact('achievements'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.achievements.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string|in:academic,sports,arts,science,leadership,community',
            'level' => 'required|string|in:school,district,provincial,national,international',
            'year' => 'required|string|max:4',
            'student_name' => 'nullable|string|max:255',
            'student_class' => 'nullable|string|max:50',
            'teacher_name' => 'nullable|string|max:255',
            'position' => 'nullable|string|max:100',
            'event_name' => 'nullable|string|max:255',
            'organizer' => 'nullable|string|max:255',
            'certificate_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_featured' => 'boolean',
            'is_public' => 'boolean',
            'sort_order' => 'nullable|integer|min:0'
        ]);

        $data = $request->all();

        // Handle certificate image upload
        if ($request->hasFile('certificate_image')) {
            $certificate = $request->file('certificate_image');
            $certificateName = time() . '_' . uniqid() . '.' . $certificate->getClientOriginalExtension();
            $certificate->storeAs('public/achievements/certificates', $certificateName);
            $data['certificate_image'] = $certificateName;
        }

        // Handle photo upload
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photoName = time() . '_' . uniqid() . '.' . $photo->getClientOriginalExtension();
            $photo->storeAs('public/achievements/photos', $photoName);
            $data['photo'] = $photoName;
        }

        Achievement::create($data);

        return redirect()->route('admin.achievements.index')
            ->with('success', 'Prestasi berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Achievement $achievement)
    {
        return view('admin.achievements.show', compact('achievement'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Achievement $achievement)
    {
        return view('admin.achievements.edit', compact('achievement'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Achievement $achievement)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string|in:academic,sports,arts,science,leadership,community',
            'level' => 'required|string|in:school,district,provincial,national,international',
            'year' => 'required|string|max:4',
            'student_name' => 'nullable|string|max:255',
            'student_class' => 'nullable|string|max:50',
            'teacher_name' => 'nullable|string|max:255',
            'position' => 'nullable|string|max:100',
            'event_name' => 'nullable|string|max:255',
            'organizer' => 'nullable|string|max:255',
            'certificate_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_featured' => 'boolean',
            'is_public' => 'boolean',
            'sort_order' => 'nullable|integer|min:0'
        ]);

        $data = $request->all();

        // Handle certificate image upload
        if ($request->hasFile('certificate_image')) {
            // Delete old certificate
            if ($achievement->certificate_image) {
                Storage::delete('public/achievements/certificates/' . $achievement->certificate_image);
            }
            
            $certificate = $request->file('certificate_image');
            $certificateName = time() . '_' . uniqid() . '.' . $certificate->getClientOriginalExtension();
            $certificate->storeAs('public/achievements/certificates', $certificateName);
            $data['certificate_image'] = $certificateName;
        }

        // Handle photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo
            if ($achievement->photo) {
                Storage::delete('public/achievements/photos/' . $achievement->photo);
            }
            
            $photo = $request->file('photo');
            $photoName = time() . '_' . uniqid() . '.' . $photo->getClientOriginalExtension();
            $photo->storeAs('public/achievements/photos', $photoName);
            $data['photo'] = $photoName;
        }

        $achievement->update($data);

        return redirect()->route('admin.achievements.index')
            ->with('success', 'Prestasi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Achievement $achievement)
    {
        // Delete associated files
        if ($achievement->certificate_image) {
            Storage::delete('public/achievements/certificates/' . $achievement->certificate_image);
        }
        if ($achievement->photo) {
            Storage::delete('public/achievements/photos/' . $achievement->photo);
        }

        $achievement->delete();

        return redirect()->route('admin.achievements.index')
            ->with('success', 'Prestasi berhasil dihapus.');
    }

    /**
     * Toggle featured status
     */
    public function toggleFeatured(Achievement $achievement)
    {
        $achievement->update(['is_featured' => !$achievement->is_featured]);
        
        $status = $achievement->is_featured ? 'ditampilkan' : 'disembunyikan';
        return redirect()->back()
            ->with('success', "Prestasi berhasil {$status} dari halaman utama.");
    }
}
