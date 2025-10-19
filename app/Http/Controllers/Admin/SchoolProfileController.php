<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SchoolProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sections = SchoolProfile::orderBy('sort_order')->get();
        return view('admin.school-profile.index', compact('sections'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.school-profile.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'section_key' => 'required|string|max:255|unique:school_profiles,section_key',
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
            'image_alt' => 'nullable|string|max:255',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0'
        ], [
            'image.file' => 'The image must be a valid file.',
            'image.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif, svg, webp.',
            'image.max' => 'The image may not be greater than 5MB.',
        ]);

        $data = $request->all();

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            
            // Validate file
            if (!$image->isValid()) {
                return redirect()->back()->withErrors(['image' => 'Invalid file upload.']);
            }
            
            // Generate safe filename
            $originalName = $image->getClientOriginalName();
            $extension = $image->getClientOriginalExtension();
            $safeName = preg_replace('/[^a-zA-Z0-9._-]/', '_', pathinfo($originalName, PATHINFO_FILENAME));
            $imageName = time() . '_' . $safeName . '.' . $extension;
            
            try {
                // Store in uploads directory
                $uploadsPath = public_path('uploads/school-profiles');
                if (!is_dir($uploadsPath)) {
                    mkdir($uploadsPath, 0755, true);
                }
                $image->move($uploadsPath, $imageName);
                
                // Store in storage directory
                $storagePath = storage_path('app/public/school-profiles');
                if (!is_dir($storagePath)) {
                    mkdir($storagePath, 0755, true);
                }
                copy($uploadsPath . '/' . $imageName, $storagePath . '/' . $imageName);
                
                $data['image'] = 'storage/school-profiles/' . $imageName;
            } catch (Exception $e) {
                return redirect()->back()->withErrors(['image' => 'Failed to upload image: ' . $e->getMessage()]);
            }
        }

        SchoolProfile::create($data);

        return redirect()->route('admin.school-profile.index')
            ->with('success', 'Profil sekolah berhasil dibuat!');
    }

    /**
     * Display the specified resource.
     */
    public function show(SchoolProfile $schoolProfile)
    {
        return view('admin.school-profile.show', compact('schoolProfile'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SchoolProfile $schoolProfile)
    {
        // Determine if this is a section-based profile or complete profile
        $isSectionBased = !empty($schoolProfile->section_key);
        
        if ($isSectionBased) {
            // For section-based profiles, use the section edit form
            return view('admin.school-profile.edit-section', compact('schoolProfile'));
        } else {
            // For complete profiles, use the full edit form
            return view('admin.school-profile.edit', compact('schoolProfile'));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SchoolProfile $schoolProfile)
    {
        // Determine if this is a section-based profile or complete profile
        $isSectionBased = !empty($schoolProfile->section_key);
        
        if ($isSectionBased) {
            // Handle section-based profile update
            $request->validate([
                'title' => 'required|string|max:255',
                'content' => 'required|string',
                'image' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
                'image_alt' => 'nullable|string|max:255',
                'is_active' => 'boolean'
            ], [
                'image.file' => 'The image must be a valid file.',
                'image.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif, svg, webp.',
                'image.max' => 'The image may not be greater than 5MB.',
            ]);

            $data = $request->all();

            // Handle image upload for section-based profiles
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                
                // Validate file
                if (!$image->isValid()) {
                    return redirect()->back()->withErrors(['image' => 'Invalid file upload.']);
                }
                
                // Delete old image if exists
                if ($schoolProfile->image) {
                    $oldImagePath = public_path($schoolProfile->image);
                    $oldStoragePath = storage_path('app/public/school-profiles/' . basename($schoolProfile->image));
                    
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                    if (file_exists($oldStoragePath)) {
                        unlink($oldStoragePath);
                    }
                }
                
                // Generate safe filename
                $originalName = $image->getClientOriginalName();
                $extension = $image->getClientOriginalExtension();
                $safeName = preg_replace('/[^a-zA-Z0-9._-]/', '_', pathinfo($originalName, PATHINFO_FILENAME));
                $imageName = time() . '_' . $safeName . '.' . $extension;
                
                try {
                    // Store in uploads directory
                    $uploadsPath = public_path('uploads/school-profiles');
                    if (!is_dir($uploadsPath)) {
                        mkdir($uploadsPath, 0755, true);
                    }
                    $image->move($uploadsPath, $imageName);
                    
                    // Store in storage directory
                    $storagePath = storage_path('app/public/school-profiles');
                    if (!is_dir($storagePath)) {
                        mkdir($storagePath, 0755, true);
                    }
                    copy($uploadsPath . '/' . $imageName, $storagePath . '/' . $imageName);
                    
                    $data['image'] = 'storage/school-profiles/' . $imageName;
                } catch (Exception $e) {
                    return redirect()->back()->withErrors(['image' => 'Failed to upload image: ' . $e->getMessage()]);
                }
            }

            $schoolProfile->update($data);

            // Copy uploaded files to public/storage for immediate access
            if ($request->hasFile('image')) {
                $sourcePath = storage_path('app/public/school-profiles/' . basename($data['image']));
                $destPath = public_path('storage/school-profiles/' . basename($data['image']));
                $destDir = dirname($destPath);
                
                if (!is_dir($destDir)) {
                    mkdir($destDir, 0755, true);
                }
                
                if (copy($sourcePath, $destPath)) {
                    \Log::info('School profile image copied to public storage: ' . basename($data['image']));
                } else {
                    \Log::error('Failed to copy school profile image to public storage: ' . basename($data['image']));
                }
            }

            return redirect()->route('admin.school-profile.index')
                ->with('success', 'Section berhasil diperbarui!');
        } else {
            // Handle complete profile update
            $request->validate([
                'school_name' => 'required|string|max:255',
                'history' => 'required|string',
                'established_year' => 'required|string',
                'location' => 'required|string|max:255',
                'vision' => 'required|string',
                'mission' => 'required|string',
                'headmaster_name' => 'required|string|max:255',
                'headmaster_position' => 'required|string|max:255',
                'headmaster_education' => 'required|string|max:255',
                'accreditation_status' => 'required|string|max:255',
                'accreditation_number' => 'required|string|max:255',
                'accreditation_year' => 'required|string',
                'accreditation_score' => 'required|integer',
                'accreditation_valid_until' => 'required|string',
            ]);

            $schoolProfile->update($request->all());

            return redirect()->route('admin.school-profile.index')
                ->with('success', 'Profil sekolah berhasil diperbarui!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SchoolProfile $schoolProfile)
    {
        $schoolProfile->delete();

        return redirect()->route('admin.school-profile.index')
            ->with('success', 'Profil sekolah berhasil dihapus!');
    }

    /**
     * Edit hero section specifically
     */
    public function editHero()
    {
        $heroSection = SchoolProfile::where('section_key', 'hero')->first();
        
        if (!$heroSection) {
            // Create hero section if doesn't exist
            $heroSection = SchoolProfile::create([
                'section_key' => 'hero',
                'title' => 'Hero Section',
                'content' => 'Welcome to SMP Negeri 01 Namrole',
                'is_active' => true,
                'sort_order' => 0
            ]);
        }
        
        return view('admin.school-profile.edit-hero', compact('heroSection'));
    }

    /**
     * Update hero section
     */
    public function updateHero(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
            'image_alt' => 'nullable|string|max:255',
            'button_text' => 'nullable|string|max:255',
            'button_link' => 'nullable|string|max:255',
            'background_color' => 'nullable|string|max:50',
            'text_color' => 'nullable|string|max:50',
            'is_active' => 'boolean'
        ], [
            'image.file' => 'The image must be a valid file.',
            'image.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif, svg, webp.',
            'image.max' => 'The image may not be greater than 5MB.',
        ]);

        $heroSection = SchoolProfile::where('section_key', 'hero')->first();
        
        if (!$heroSection) {
            return redirect()->back()->withErrors(['error' => 'Hero section not found.']);
        }

        $data = $request->all();

        // Handle image upload for hero section
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            
            // Validate file
            if (!$image->isValid()) {
                return redirect()->back()->withErrors(['image' => 'Invalid file upload.']);
            }
            
            // Delete old image if exists
            if ($heroSection->image && Storage::disk('public')->exists($heroSection->image)) {
                Storage::disk('public')->delete($heroSection->image);
            }
            
            // Generate safe filename
            $originalName = $image->getClientOriginalName();
            $extension = $image->getClientOriginalExtension();
            $safeName = preg_replace('/[^a-zA-Z0-9._-]/', '_', pathinfo($originalName, PATHINFO_FILENAME));
            $imageName = time() . '_' . $safeName . '.' . $extension;
            
            try {
                // Store in storage using Laravel Storage facade
                $path = $image->storeAs('school-profiles', $imageName, 'public');
                $data['image'] = $path;
                
                // Copy file to public storage for immediate access
                $sourcePath = storage_path('app/public/' . $path);
                $destPath = public_path('storage/' . $path);
                $destDir = dirname($destPath);
                if (!is_dir($destDir)) {
                    mkdir($destDir, 0755, true);
                }
                if (copy($sourcePath, $destPath)) {
                    \Log::info('Hero image uploaded and copied to public storage: ' . $path);
                } else {
                    \Log::error('Failed to copy hero image to public storage: ' . $path);
                }
            } catch (Exception $e) {
                return redirect()->back()->withErrors(['image' => 'Failed to upload image: ' . $e->getMessage()]);
            }
        }

        $heroSection->update($data);

        return redirect()->route('admin.school-profile.index')
            ->with('success', 'Hero section updated successfully.');
    }

    /**
     * Edit struktur organisasi section
     */
    public function editStruktur()
    {
        $strukturSection = SchoolProfile::where('section_key', 'struktur')->first();
        
        if (!$strukturSection) {
            // Create struktur section if doesn't exist
            $strukturSection = SchoolProfile::create([
                'section_key' => 'struktur',
                'title' => 'Struktur Organisasi SMP Negeri 01 Namrole',
                'content' => 'Struktur organisasi sekolah yang menunjukkan hierarki kepemimpinan dan pembagian tugas di SMP Negeri 01 Namrole.',
                'image' => 'Struktur Organisasi.png',
                'is_active' => true,
                'sort_order' => 3
            ]);
        }
        
        return view('admin.school-profile.edit-struktur', compact('strukturSection'));
    }

    /**
     * Update struktur organisasi section
     */
    public function updateStruktur(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'description' => 'nullable|string',
            'image' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
            'image_alt' => 'nullable|string|max:255',
            'is_active' => 'boolean'
        ], [
            'image.file' => 'The image must be a valid file.',
            'image.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif, svg, webp.',
            'image.max' => 'The image may not be greater than 5MB.',
        ]);

        $strukturSection = SchoolProfile::where('section_key', 'struktur')->first();
        
        if (!$strukturSection) {
            return redirect()->back()->withErrors(['error' => 'Struktur organisasi section not found.']);
        }

        $data = $request->all();

        // Handle image upload for struktur section
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            
            // Validate file
            if (!$image->isValid()) {
                return redirect()->back()->withErrors(['image' => 'Invalid file upload.']);
            }
            
            // Delete old image if exists
            if ($strukturSection->image) {
                $oldImagePath = public_path($strukturSection->image);
                $oldStoragePath = storage_path('app/public/school-profiles/' . basename($strukturSection->image));
                
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
                if (file_exists($oldStoragePath)) {
                    unlink($oldStoragePath);
                }
            }
            
            // Generate safe filename
            $originalName = $image->getClientOriginalName();
            $extension = $image->getClientOriginalExtension();
            $safeName = preg_replace('/[^a-zA-Z0-9._-]/', '_', pathinfo($originalName, PATHINFO_FILENAME));
            $imageName = time() . '_' . $safeName . '.' . $extension;
            
            try {
                // Store in uploads directory
                $uploadsPath = public_path('uploads/school-profiles');
                if (!is_dir($uploadsPath)) {
                    mkdir($uploadsPath, 0755, true);
                }
                $image->move($uploadsPath, $imageName);
                
                // Store in storage directory
                $storagePath = storage_path('app/public/school-profiles');
                if (!is_dir($storagePath)) {
                    mkdir($storagePath, 0755, true);
                }
                copy($uploadsPath . '/' . $imageName, $storagePath . '/' . $imageName);
                
                $data['image'] = 'storage/school-profiles/' . $imageName;
            } catch (Exception $e) {
                return redirect()->back()->withErrors(['image' => 'Failed to upload image: ' . $e->getMessage()]);
            }
        }

        $strukturSection->update($data);

        // Copy uploaded files to public/storage for immediate access
        if ($request->hasFile('image')) {
            $sourcePath = storage_path('app/public/school-profiles/' . basename($data['image']));
            $destPath = public_path('storage/school-profiles/' . basename($data['image']));
            $destDir = dirname($destPath);
            
            if (!is_dir($destDir)) {
                mkdir($destDir, 0755, true);
            }
            
            if (copy($sourcePath, $destPath)) {
                \Log::info('Struktur image copied to public storage: ' . basename($data['image']));
            } else {
                \Log::error('Failed to copy struktur image to public storage: ' . basename($data['image']));
            }
        }

        return redirect()->route('admin.school-profile.index')
            ->with('success', 'Struktur organisasi updated successfully.');
    }
}
