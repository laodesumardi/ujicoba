<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gallery;
use App\Models\GalleryItem;
use App\Models\HomeSection;

class GalleryController extends Controller
{
    /**
     * Display a listing of galleries.
     */
    public function index(Request $request)
    {
        $query = Gallery::published()->orderBy('sort_order')->orderBy('created_at', 'desc');

        // Filter by category
        if ($request->has('category') && $request->category) {
            $query->byCategory($request->category);
        }

        // Filter by type
        if ($request->has('type') && $request->type) {
            $query->byType($request->type);
        }

        // Search
        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        $galleries = $query->paginate(12);

        // Get gallery section data
        $gallerySection = HomeSection::where('section_key', 'gallery')->first();

        // Get categories for filter
        $categories = [
            'kegiatan' => 'Kegiatan Siswa',
            'event' => 'Event Besar',
            'profil' => 'Profil Sekolah',
            'testimoni' => 'Testimoni',
            'prestasi' => 'Prestasi',
            'fasilitas' => 'Fasilitas',
            'lainnya' => 'Lainnya'
        ];

        // Get types for filter
        $types = [
            'photo' => 'Foto',
            'video' => 'Video',
            'mixed' => 'Campuran'
        ];

        return view('gallery.index', compact('galleries', 'categories', 'types', 'gallerySection'));
    }

    /**
     * Display the specified gallery.
     */
    public function show($slug)
    {
        $gallery = Gallery::where('slug', $slug)->published()->firstOrFail();
        
        // Get gallery items
        $items = $gallery->items()->orderBy('sort_order')->get();
        
        // Get related galleries
        $relatedGalleries = Gallery::published()
            ->where('id', '!=', $gallery->id)
            ->where('category', $gallery->category)
            ->orderBy('created_at', 'desc')
            ->limit(4)
            ->get();

        return view('gallery.show', compact('gallery', 'items', 'relatedGalleries'));
    }

    /**
     * Display galleries by category.
     */
    public function category($category)
    {
        $galleries = Gallery::published()
            ->byCategory($category)
            ->orderBy('sort_order')
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        $categories = [
            'kegiatan' => 'Kegiatan Siswa',
            'event' => 'Event Besar',
            'profil' => 'Profil Sekolah',
            'testimoni' => 'Testimoni',
            'prestasi' => 'Prestasi',
            'fasilitas' => 'Fasilitas',
            'lainnya' => 'Lainnya'
        ];
        
        $categoryLabel = $categories[$category] ?? ucfirst($category);

        return view('gallery.category', compact('galleries', 'category', 'categoryLabel'));
    }

    /**
     * Display featured galleries.
     */
    public function featured()
    {
        $galleries = Gallery::published()
            ->featured()
            ->orderBy('sort_order')
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('gallery.featured', compact('galleries'));
    }

    /**
     * Get featured galleries for homepage.
     */
    public function getFeaturedGalleries($limit = 6)
    {
        return Gallery::published()
            ->featured()
            ->orderBy('sort_order')
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get latest galleries for homepage.
     */
    public function getLatestGalleries($limit = 6)
    {
        return Gallery::published()
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }
}
