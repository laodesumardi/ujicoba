<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = News::query();

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
                  ->orWhere('excerpt', 'like', '%' . $request->search . '%')
                  ->orWhere('content', 'like', '%' . $request->search . '%');
            });
        }

        $news = $query->latest()->paginate(20);

        $categories = [
            'akademik' => 'Akademik',
            'ekstrakurikuler' => 'Ekstrakurikuler',
            'libur' => 'Libur Nasional',
            'jadwal' => 'Perubahan Jadwal',
            'osis' => 'Kegiatan OSIS',
            'lomba' => 'Lomba & Kompetisi'
        ];

        return view('admin.news.index', compact('news', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = [
            'akademik' => 'Akademik',
            'ekstrakurikuler' => 'Ekstrakurikuler',
            'libur' => 'Libur Nasional',
            'jadwal' => 'Perubahan Jadwal',
            'osis' => 'Kegiatan OSIS',
            'lomba' => 'Lomba & Kompetisi'
        ];

        return view('admin.news.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'category' => 'required|string|in:akademik,ekstrakurikuler,libur,jadwal,osis,lomba',
            'type' => 'required|in:news,announcement',
            'status' => 'required|in:draft,published,archived',
            'is_featured' => 'boolean',
            'is_pinned' => 'boolean',
            'published_at' => 'nullable|date',
            'author_name' => 'nullable|string|max:255',
            'author_email' => 'nullable|email|max:255',
            'tags' => 'nullable|string'
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->title);
        $data['is_featured'] = $request->has('is_featured');
        $data['is_pinned'] = $request->has('is_pinned');

        // Handle tags
        if ($request->tags) {
            $data['tags'] = array_map('trim', explode(',', $request->tags));
        }

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            $image = $request->file('featured_image');
            $filename = time() . '_' . Str::slug($request->title) . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('news', $filename, 'public');
            $data['featured_image'] = $path;
        }

        // Set published_at if status is published and no date set
        if ($data['status'] === 'published' && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        News::create($data);

        // Copy uploaded files to public/storage for immediate access
        if ($request->hasFile('featured_image')) {
            $sourcePath = storage_path('app/public/' . $data['featured_image']);
            $destPath = public_path('storage/' . $data['featured_image']);
            $destDir = dirname($destPath);
            
            if (!is_dir($destDir)) {
                mkdir($destDir, 0755, true);
            }
            
            if (copy($sourcePath, $destPath)) {
                \Log::info('News featured image copied to public storage: ' . $data['featured_image']);
            } else {
                \Log::error('Failed to copy news featured image to public storage: ' . $data['featured_image']);
            }
        }

        return redirect()->route('admin.news.index')
                       ->with('success', 'Berita berhasil dibuat!');
    }

    /**
     * Display the specified resource.
     */
    public function show(News $news)
    {
        return view('admin.news.show', compact('news'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(News $news)
    {
        $categories = [
            'akademik' => 'Akademik',
            'ekstrakurikuler' => 'Ekstrakurikuler',
            'libur' => 'Libur Nasional',
            'jadwal' => 'Perubahan Jadwal',
            'osis' => 'Kegiatan OSIS',
            'lomba' => 'Lomba & Kompetisi'
        ];

        return view('admin.news.edit', compact('news', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, News $news)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'category' => 'required|string|in:akademik,ekstrakurikuler,libur,jadwal,osis,lomba',
            'type' => 'required|in:news,announcement',
            'status' => 'required|in:draft,published,archived',
            'is_featured' => 'boolean',
            'is_pinned' => 'boolean',
            'published_at' => 'nullable|date',
            'author_name' => 'nullable|string|max:255',
            'author_email' => 'nullable|email|max:255',
            'tags' => 'nullable|string'
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->title);
        $data['is_featured'] = $request->has('is_featured');
        $data['is_pinned'] = $request->has('is_pinned');

        // Handle tags
        if ($request->tags) {
            $data['tags'] = array_map('trim', explode(',', $request->tags));
        }

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            // Delete old image
            if ($news->featured_image && Storage::disk('public')->exists($news->featured_image)) {
                Storage::disk('public')->delete($news->featured_image);
            }

            $image = $request->file('featured_image');
            $filename = time() . '_' . Str::slug($request->title) . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('news', $filename, 'public');
            $data['featured_image'] = $path;
        }

        // Set published_at if status is published and no date set
        if ($data['status'] === 'published' && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        $news->update($data);

        // Copy uploaded files to public/storage for immediate access
        if ($request->hasFile('featured_image')) {
            $sourcePath = storage_path('app/public/' . $data['featured_image']);
            $destPath = public_path('storage/' . $data['featured_image']);
            $destDir = dirname($destPath);
            
            if (!is_dir($destDir)) {
                mkdir($destDir, 0755, true);
            }
            
            if (copy($sourcePath, $destPath)) {
                \Log::info('News featured image copied to public storage: ' . $data['featured_image']);
            } else {
                \Log::error('Failed to copy news featured image to public storage: ' . $data['featured_image']);
            }
        }

        return redirect()->route('admin.news.index')
                       ->with('success', 'Berita berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(News $news)
    {
        // Delete featured image
        if ($news->featured_image && Storage::disk('public')->exists($news->featured_image)) {
            Storage::disk('public')->delete($news->featured_image);
        }

        $news->delete();

        return redirect()->route('admin.news.index')
                       ->with('success', 'Berita berhasil dihapus!');
    }

    /**
     * Toggle featured status.
     */
    public function toggleFeatured(News $news)
    {
        $news->update(['is_featured' => !$news->is_featured]);

        return response()->json([
            'success' => true,
            'is_featured' => $news->is_featured
        ]);
    }

        /**
         * Toggle pinned status.
         */
        public function togglePinned(News $news)
        {
            $news->update(['is_pinned' => !$news->is_pinned]);

            return response()->json([
                'success' => true,
                'is_pinned' => $news->is_pinned
            ]);
        }

        /**
         * Show the form for editing news section.
         */
        public function editSection()
        {
            // Get or create news section data
            $newsSection = \App\Models\HomeSection::where('section_key', 'news')->first();
            
            if (!$newsSection) {
                $newsSection = \App\Models\HomeSection::create([
                    'section_key' => 'news',
                    'title' => 'Berita & Pengumuman Terbaru',
                    'subtitle' => 'Informasi terkini dari SMP Negeri 01 Namrole',
                    'content' => 'Dapatkan informasi terbaru tentang kegiatan sekolah, pengumuman penting, dan berita terkini dari SMP Negeri 01 Namrole.',
                    'is_active' => true,
                    'sort_order' => 7
                ]);
            }

            return view('admin.news.edit-section', compact('newsSection'));
        }

        /**
         * Update news section.
         */
        public function updateSection(Request $request)
        {
            $request->validate([
                'title' => 'required|string|max:255',
                'subtitle' => 'nullable|string|max:255',
                'content' => 'nullable|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
                'image_alt' => 'nullable|string|max:255',
                'image_position' => 'nullable|string|in:top,center,bottom',
                'is_active' => 'boolean'
            ]);

            $newsSection = \App\Models\HomeSection::where('section_key', 'news')->first();
            
            if ($newsSection) {
                $data = [
                    'title' => $request->title,
                    'subtitle' => $request->subtitle,
                    'content' => $request->content,
                    'is_active' => $request->has('is_active')
                ];

                // Handle image upload
                if ($request->hasFile('image')) {
                    // Delete old image if exists
                    if ($newsSection->image && Storage::disk('public')->exists($newsSection->image)) {
                        Storage::disk('public')->delete($newsSection->image);
                    }

                    $image = $request->file('image');
                    $filename = time() . '_news_section.' . $image->getClientOriginalExtension();
                    $path = $image->storeAs('home-sections', $filename, 'public');
                    $data['image'] = $path;
                }

                // Handle image metadata
                if ($request->has('image_alt')) {
                    $data['image_alt'] = $request->image_alt;
                }
                if ($request->has('image_position')) {
                    $data['image_position'] = $request->image_position;
                }

                $newsSection->update($data);
            }

            return redirect()->route('admin.news.index')
                           ->with('success', 'Section berita berhasil diperbarui!');
        }
    }
