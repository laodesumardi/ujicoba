<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Facility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FacilityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $facilities = Facility::ordered()->paginate(10);
        return view('admin.facilities.index', compact('facilities'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.facilities.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'icon' => 'nullable|string|max:255',
            'category' => 'required|string|in:general,academic,sports,library,laboratory,technology,welfare',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
            'is_featured' => 'boolean'
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');
        $data['is_featured'] = $request->has('is_featured');

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('facilities', $filename, 'public');
            $data['image'] = 'facilities/' . $filename;
            
            // Copy file to public storage for immediate access
            $sourcePath = storage_path('app/public/facilities/' . $filename);
            $destPath = public_path('storage/facilities/' . $filename);
            $destDir = dirname($destPath);
            
            // Ensure destination directory exists
            if (!is_dir($destDir)) {
                mkdir($destDir, 0755, true);
            }
            
            if (copy($sourcePath, $destPath)) {
                \Log::info('Image uploaded and copied to public storage: ' . $filename);
            } else {
                \Log::error('Failed to copy image to public storage: ' . $filename);
            }
        } else {
            // Set image to null if no image uploaded
            $data['image'] = null;
            \Log::info('No image uploaded, setting to null');
        }

        Facility::create($data);

        return redirect()->route('admin.facilities.index')
            ->with('success', 'Fasilitas berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Facility $facility)
    {
        return view('admin.facilities.show', compact('facility'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Facility $facility)
    {
        return view('admin.facilities.edit', compact('facility'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Facility $facility)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'icon' => 'nullable|string|max:255',
            'category' => 'required|string|in:general,academic,sports,library,laboratory,technology,welfare',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
            'is_featured' => 'boolean'
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');
        $data['is_featured'] = $request->has('is_featured');

        if ($request->hasFile('image')) {
            // Delete old image if it's a local file
            if ($facility->image && !str_starts_with($facility->image, 'http') && Storage::disk('public')->exists($facility->image)) {
                Storage::disk('public')->delete($facility->image);
            }
            
            $file = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('facilities', $filename, 'public');
            $data['image'] = 'facilities/' . $filename;
            \Log::info('Image updated: ' . $filename);
        } else {
            // Keep existing image or use default if none
            if (!$facility->image || str_starts_with($facility->image, 'http')) {
                $data['image'] = 'facilities/facility_technology_1760796308.png';
                \Log::info('No image uploaded, using default');
            } else {
                \Log::info('Keeping existing image: ' . $facility->image);
            }
        }

        $facility->update($data);

        // Copy uploaded files to public/storage for immediate access
        if ($request->hasFile('image')) {
            $sourcePath = storage_path('app/public/' . $data['image']);
            $destPath = public_path('storage/' . $data['image']);
            $destDir = dirname($destPath);
            
            if (!is_dir($destDir)) {
                mkdir($destDir, 0755, true);
            }
            
            if (copy($sourcePath, $destPath)) {
                \Log::info('Facility image copied to public storage: ' . $data['image']);
            } else {
                \Log::error('Failed to copy facility image to public storage: ' . $data['image']);
            }
        }

        return redirect()->route('admin.facilities.index')
            ->with('success', 'Fasilitas berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Facility $facility)
    {
        // Delete image if exists
        if ($facility->image && Storage::exists('public/' . $facility->image)) {
            Storage::delete('public/' . $facility->image);
        }

        $facility->delete();

        return redirect()->route('admin.facilities.index')
            ->with('success', 'Fasilitas berhasil dihapus.');
    }
}
