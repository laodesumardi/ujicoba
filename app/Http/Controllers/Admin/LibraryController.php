<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Library;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Helpers\StorageHelper;

class LibraryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $libraries = Library::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.libraries.index', compact('libraries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.libraries.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'opening_hours' => 'nullable|string',
            'services' => 'nullable|string',
            'rules' => 'nullable|string',
            'librarian_name' => 'nullable|string|max:255',
            'librarian_phone' => 'nullable|string|max:20',
            'librarian_email' => 'nullable|email|max:255',
            'organization_chart' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'facilities' => 'nullable|string',
            'collection_info' => 'nullable|string',
            'membership_info' => 'nullable|string',
            'vision' => 'nullable|string',
            'mission' => 'nullable|string',
            'goals' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:1024',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean'
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');

        // Handle organization chart upload
        if ($request->hasFile('organization_chart')) {
            $file = $request->file('organization_chart');
            $filename = 'organization_chart_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('libraries', $filename, 'public');
            $data['organization_chart'] = $path;
            
            // Auto copy to public for hosting
            StorageHelper::copyToPublic($path);
        }

        // Handle logo upload
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $filename = 'logo_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('libraries', $filename, 'public');
            $data['logo'] = $path;
            
            // Auto copy to public for hosting
            StorageHelper::copyToPublic($path);
        }

        // Handle banner image upload
        if ($request->hasFile('banner_image')) {
            $file = $request->file('banner_image');
            $filename = 'banner_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('libraries', $filename, 'public');
            $data['banner_image'] = $path;
            
            // Auto copy to public for hosting
            StorageHelper::copyToPublic($path);
        }

        // Handle gallery images upload
        if ($request->hasFile('gallery_images')) {
            $galleryImages = [];
            foreach ($request->file('gallery_images') as $file) {
                $filename = 'gallery_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('libraries', $filename, 'public');
                $galleryImages[] = $path;
                
                // Auto copy to public for hosting
                StorageHelper::copyToPublic($path);
            }
            $data['gallery_images'] = $galleryImages;
        }

        Library::create($data);

        return redirect()->route('admin.libraries.index')
            ->with('success', 'Perpustakaan berhasil dibuat!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Library $library)
    {
        return view('admin.libraries.show', compact('library'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Library $library)
    {
        return view('admin.libraries.edit', compact('library'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Library $library)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'opening_hours' => 'nullable|string',
            'services' => 'nullable|string',
            'rules' => 'nullable|string',
            'librarian_name' => 'nullable|string|max:255',
            'librarian_phone' => 'nullable|string|max:20',
            'librarian_email' => 'nullable|email|max:255',
            'organization_chart' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'facilities' => 'nullable|string',
            'collection_info' => 'nullable|string',
            'membership_info' => 'nullable|string',
            'vision' => 'nullable|string',
            'mission' => 'nullable|string',
            'goals' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:1024',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean'
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');

        // Handle organization chart upload
        if ($request->hasFile('organization_chart')) {
            // Delete old file
            if ($library->organization_chart) {
                Storage::disk('public')->delete($library->organization_chart);
            }
            
            $file = $request->file('organization_chart');
            $filename = 'organization_chart_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('libraries', $filename, 'public');
            $data['organization_chart'] = $path;
            
            // Auto copy to public for hosting
            StorageHelper::copyToPublic($path);
        }

        // Handle logo upload
        if ($request->hasFile('logo')) {
            // Delete old file
            if ($library->logo) {
                Storage::disk('public')->delete($library->logo);
            }
            
            $file = $request->file('logo');
            $filename = 'logo_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('libraries', $filename, 'public');
            $data['logo'] = $path;
            
            // Auto copy to public for hosting
            StorageHelper::copyToPublic($path);
        }

        // Handle banner image upload
        if ($request->hasFile('banner_image')) {
            // Delete old file
            if ($library->banner_image) {
                Storage::disk('public')->delete($library->banner_image);
            }
            
            $file = $request->file('banner_image');
            $filename = 'banner_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('libraries', $filename, 'public');
            $data['banner_image'] = $path;
            
            // Auto copy to public for hosting
            StorageHelper::copyToPublic($path);
        }

        // Handle gallery images upload
        if ($request->hasFile('gallery_images')) {
            // Delete old gallery images
            if ($library->gallery_images) {
                foreach ($library->gallery_images as $image) {
                    Storage::disk('public')->delete($image);
                }
            }
            
            $galleryImages = [];
            foreach ($request->file('gallery_images') as $file) {
                $filename = 'gallery_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('libraries', $filename, 'public');
                $galleryImages[] = $path;
                
                // Auto copy to public for hosting
                StorageHelper::copyToPublic($path);
            }
            $data['gallery_images'] = $galleryImages;
        }

        $library->update($data);

        return redirect()->route('admin.libraries.index')
            ->with('success', 'Perpustakaan berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Library $library)
    {
        // Delete associated files
        if ($library->organization_chart) {
            Storage::disk('public')->delete($library->organization_chart);
        }
        if ($library->logo) {
            Storage::disk('public')->delete($library->logo);
        }
        if ($library->banner_image) {
            Storage::disk('public')->delete($library->banner_image);
        }
        if ($library->gallery_images) {
            foreach ($library->gallery_images as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        $library->delete();

        return redirect()->route('admin.libraries.index')
            ->with('success', 'Perpustakaan berhasil dihapus!');
    }
}