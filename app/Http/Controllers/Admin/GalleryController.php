<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\GalleryItem;
use App\Models\HomeSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Gallery::query();

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Filter by category
        if ($request->has('category') && $request->category) {
            $query->where('category', $request->category);
        }

        // Filter by type
        if ($request->has('type') && $request->type) {
            $query->where('type', $request->type);
        }

        // Search
        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        $galleries = $query->orderBy('sort_order')->orderBy('created_at', 'desc')->paginate(20);

        $categories = [
            'kegiatan' => 'Kegiatan Siswa',
            'event' => 'Event Besar',
            'profil' => 'Profil Sekolah',
            'testimoni' => 'Testimoni',
            'prestasi' => 'Prestasi',
            'fasilitas' => 'Fasilitas',
            'lainnya' => 'Lainnya'
        ];

        $types = [
            'photo' => 'Foto',
            'video' => 'Video',
            'mixed' => 'Campuran'
        ];

        return view('admin.gallery.index', compact('galleries', 'categories', 'types'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = [
            'kegiatan' => 'Kegiatan Siswa',
            'event' => 'Event Besar',
            'profil' => 'Profil Sekolah',
            'testimoni' => 'Testimoni',
            'prestasi' => 'Prestasi',
            'fasilitas' => 'Fasilitas',
            'lainnya' => 'Lainnya'
        ];

        $types = [
            'photo' => 'Foto',
            'video' => 'Video',
            'mixed' => 'Campuran'
        ];

        return view('admin.gallery.create', compact('categories', 'types'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'type' => 'required|in:photo,video,mixed',
            'category' => 'required|string',
            'status' => 'required|in:draft,published,archived',
            'is_featured' => 'boolean',
            'is_public' => 'boolean',
            'sort_order' => 'nullable|integer|min:0'
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->title);
        $data['is_featured'] = $request->has('is_featured');
        $data['is_public'] = $request->has('is_public');

        // Handle cover image upload
        if ($request->hasFile('cover_image')) {
            $image = $request->file('cover_image');
            $filename = time() . '_' . Str::slug($request->title) . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('galleries', $filename, 'public');
            $data['cover_image'] = $path;
        }

        Gallery::create($data);

        // Copy uploaded files to public/storage for immediate access
        if ($request->hasFile('cover_image')) {
            $sourcePath = storage_path('app/public/' . $data['cover_image']);
            $destPath = public_path('storage/' . $data['cover_image']);
            $destDir = dirname($destPath);
            
            if (!is_dir($destDir)) {
                mkdir($destDir, 0755, true);
            }
            
            if (copy($sourcePath, $destPath)) {
                \Log::info('Gallery cover image copied to public storage: ' . $data['cover_image']);
            } else {
                \Log::error('Failed to copy gallery cover image to public storage: ' . $data['cover_image']);
            }
        }

        return redirect()->route('admin.gallery.index')
                        ->with('success', 'Galeri berhasil dibuat!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Gallery $gallery)
    {
        $items = $gallery->items()->orderBy('sort_order')->get();
        return view('admin.gallery.show', compact('gallery', 'items'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Gallery $gallery)
    {
        $categories = [
            'kegiatan' => 'Kegiatan Siswa',
            'event' => 'Event Besar',
            'profil' => 'Profil Sekolah',
            'testimoni' => 'Testimoni',
            'prestasi' => 'Prestasi',
            'fasilitas' => 'Fasilitas',
            'lainnya' => 'Lainnya'
        ];

        $types = [
            'photo' => 'Foto',
            'video' => 'Video',
            'mixed' => 'Campuran'
        ];

        return view('admin.gallery.edit', compact('gallery', 'categories', 'types'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Gallery $gallery)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'type' => 'required|in:photo,video,mixed',
            'category' => 'required|string',
            'status' => 'required|in:draft,published,archived',
            'is_featured' => 'boolean',
            'is_public' => 'boolean',
            'sort_order' => 'nullable|integer|min:0'
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->title);
        $data['is_featured'] = $request->has('is_featured');
        $data['is_public'] = $request->has('is_public');

        // Handle cover image upload
        if ($request->hasFile('cover_image')) {
            // Delete old cover image
            if ($gallery->cover_image && Storage::disk('public')->exists($gallery->cover_image)) {
                Storage::disk('public')->delete($gallery->cover_image);
            }

            $image = $request->file('cover_image');
            $filename = time() . '_' . Str::slug($request->title) . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('galleries', $filename, 'public');
            $data['cover_image'] = $path;
        }

        $gallery->update($data);

        // Copy uploaded files to public/storage for immediate access
        if ($request->hasFile('cover_image')) {
            $sourcePath = storage_path('app/public/' . $data['cover_image']);
            $destPath = public_path('storage/' . $data['cover_image']);
            $destDir = dirname($destPath);
            
            if (!is_dir($destDir)) {
                mkdir($destDir, 0755, true);
            }
            
            if (copy($sourcePath, $destPath)) {
                \Log::info('Gallery cover image copied to public storage: ' . $data['cover_image']);
            } else {
                \Log::error('Failed to copy gallery cover image to public storage: ' . $data['cover_image']);
            }
        }

        return redirect()->route('admin.gallery.index')
                        ->with('success', 'Galeri berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Gallery $gallery)
    {
        // Delete cover image
        if ($gallery->cover_image && Storage::disk('public')->exists($gallery->cover_image)) {
            Storage::disk('public')->delete($gallery->cover_image);
        }

        // Delete gallery items and their files
        foreach ($gallery->items as $item) {
            if ($item->file_path && Storage::disk('public')->exists($item->file_path)) {
                Storage::disk('public')->delete($item->file_path);
            }
            if ($item->thumbnail_path && Storage::disk('public')->exists($item->thumbnail_path)) {
                Storage::disk('public')->delete($item->thumbnail_path);
            }
        }

        $gallery->delete();

        return redirect()->route('admin.gallery.index')
                        ->with('success', 'Galeri berhasil dihapus!');
    }

    /**
     * Edit section for gallery.
     */
    public function editSection()
    {
        $section = HomeSection::where('section_key', 'gallery')->first();
        
        if (!$section) {
            // Create default section if not exists
            $section = HomeSection::create([
                'section_key' => 'gallery',
                'title' => 'Galeri Foto & Video',
                'subtitle' => 'Dokumentasi kegiatan dan dinamika sekolah',
                'content' => 'Lihat dokumentasi lengkap kegiatan, event, dan dinamika sekolah SMP Negeri 01 Namrole',
                'is_active' => true,
                'sort_order' => 6
            ]);
        }

        return view('admin.gallery.edit-section', compact('section'));
    }

    /**
     * Update section for gallery.
     */
    public function updateSection(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'content' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'image_alt' => 'nullable|string|max:255',
            'image_position' => 'nullable|in:left,right,center,top,bottom',
            'is_active' => 'boolean'
        ]);

        $section = HomeSection::where('section_key', 'gallery')->first();
        
        if (!$section) {
            return redirect()->back()->with('error', 'Section tidak ditemukan!');
        }

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($section->image && Storage::disk('public')->exists($section->image)) {
                Storage::disk('public')->delete($section->image);
            }

            $image = $request->file('image');
            $filename = time() . '_gallery.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('home-sections', $filename, 'public');
            $data['image'] = $path;
        }

        $section->update($data);

        return redirect()->route('admin.gallery.index')
                        ->with('success', 'Section galeri berhasil diperbarui!');
    }
}
