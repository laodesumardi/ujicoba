<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeSection;
use Illuminate\Http\Request;

class HomeSectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sections = HomeSection::orderBy('sort_order')->get();
        return view('admin.home-sections.index', compact('sections'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.home-sections.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'section_key' => 'required|string|unique:home_sections,section_key',
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string',
            'description' => 'nullable|string',
            'image' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
            'image_alt' => 'nullable|string|max:255',
            'image_position' => 'nullable|string|in:center,left,right,top,bottom',
            'button_text' => 'nullable|string|max:255',
            'button_link' => 'nullable|string|max:255',
            'background_color' => 'nullable|string|max:50',
            'text_color' => 'nullable|string|max:50',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0'
        ], [
            'image.file' => 'The image must be a valid file.',
            'image.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif, svg, webp.',
            'image.max' => 'The image may not be greater than 5MB.',
        ]);

        $data = $request->all();

        // Handle image upload - only for hero section
        if ($request->hasFile('image') && $data['section_key'] === 'hero') {
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
                $uploadsPath = public_path('uploads/home-sections');
                if (!is_dir($uploadsPath)) {
                    mkdir($uploadsPath, 0755, true);
                }
                $image->move($uploadsPath, $imageName);
                
                // Store in storage directory
                $storagePath = storage_path('app/public/home-sections');
                if (!is_dir($storagePath)) {
                    mkdir($storagePath, 0755, true);
                }
                copy($uploadsPath . '/' . $imageName, $storagePath . '/' . $imageName);
                
                $data['image'] = 'storage/home-sections/' . $imageName;
            } catch (Exception $e) {
                return redirect()->back()->withErrors(['image' => 'Failed to upload image: ' . $e->getMessage()]);
            }
        } else {
            // Remove image field for non-hero sections
            unset($data['image']);
        }

        HomeSection::create($data);

        return redirect()->route('admin.home-sections.index')
            ->with('success', 'Home section created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(HomeSection $homeSection)
    {
        return view('admin.home-sections.show', compact('homeSection'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HomeSection $homeSection)
    {
        return view('admin.home-sections.edit', compact('homeSection'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, HomeSection $homeSection)
    {
        $request->validate([
            'section_key' => 'required|string|unique:home_sections,section_key,' . $homeSection->id,
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string',
            'description' => 'nullable|string',
            'image' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
            'image_alt' => 'nullable|string|max:255',
            'image_position' => 'nullable|string|in:center,left,right,top,bottom',
            'button_text' => 'nullable|string|max:255',
            'button_link' => 'nullable|string|max:255',
            'background_color' => 'nullable|string|max:50',
            'text_color' => 'nullable|string|max:50',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0'
        ], [
            'image.file' => 'The image must be a valid file.',
            'image.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif, svg, webp.',
            'image.max' => 'The image may not be greater than 5MB.',
        ]);

        $data = $request->all();

        // Handle image upload - only for hero section
        if ($request->hasFile('image') && $data['section_key'] === 'hero') {
            $image = $request->file('image');
            
            // Validate file
            if (!$image->isValid()) {
                return redirect()->back()->withErrors(['image' => 'Invalid file upload.']);
            }
            
            // Delete old image if exists
            if ($homeSection->image) {
                $oldImagePath = public_path($homeSection->image);
                $oldStoragePath = storage_path('app/public/home-sections/' . basename($homeSection->image));
                
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
                $uploadsPath = public_path('uploads/home-sections');
                if (!is_dir($uploadsPath)) {
                    mkdir($uploadsPath, 0755, true);
                }
                $image->move($uploadsPath, $imageName);
                
                // Store in storage directory
                $storagePath = storage_path('app/public/home-sections');
                if (!is_dir($storagePath)) {
                    mkdir($storagePath, 0755, true);
                }
                copy($uploadsPath . '/' . $imageName, $storagePath . '/' . $imageName);
                
                $data['image'] = 'storage/home-sections/' . $imageName;
            } catch (Exception $e) {
                return redirect()->back()->withErrors(['image' => 'Failed to upload image: ' . $e->getMessage()]);
            }
        } else {
            // Remove image field for non-hero sections
            unset($data['image']);
        }

        $homeSection->update($data);

        return redirect()->route('admin.home-sections.index')
            ->with('success', 'Home section updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HomeSection $homeSection)
    {
        $homeSection->delete();

        return redirect()->route('admin.home-sections.index')
            ->with('success', 'Home section deleted successfully.');
    }
}