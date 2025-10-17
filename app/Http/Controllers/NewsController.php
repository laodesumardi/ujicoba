<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use App\Models\HomeSection;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    /**
     * Display a listing of news.
     */
    public function index(Request $request)
    {
        $query = News::published()->latest('published_at');

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
                  ->orWhere('excerpt', 'like', '%' . $request->search . '%')
                  ->orWhere('content', 'like', '%' . $request->search . '%');
            });
        }

        $news = $query->paginate(12);

        // Get news section data
        $newsSection = HomeSection::where('section_key', 'news')->first();

        // Get categories for filter
        $categories = [
            'akademik' => 'Akademik',
            'ekstrakurikuler' => 'Ekstrakurikuler',
            'libur' => 'Libur Nasional',
            'jadwal' => 'Perubahan Jadwal',
            'osis' => 'Kegiatan OSIS',
            'lomba' => 'Lomba & Kompetisi'
        ];

        return view('news.index', compact('news', 'categories', 'newsSection'));
    }

    /**
     * Display the specified news.
     */
    public function show($slug)
    {
        $news = News::where('slug', $slug)->published()->firstOrFail();
        
        // Increment views
        $news->incrementViews();

        // Get related news
        $relatedNews = News::published()
            ->where('id', '!=', $news->id)
            ->where('category', $news->category)
            ->latest('published_at')
            ->limit(4)
            ->get();

        // Get news section data
        $newsSection = HomeSection::where('section_key', 'news')->first();

        return view('news.show', compact('news', 'relatedNews', 'newsSection'));
    }

    /**
     * Display news by category.
     */
    public function category($category)
    {
        $news = News::published()
            ->byCategory($category)
            ->latest('published_at')
            ->paginate(12);

        $categoryLabel = News::getCategoryLabelStatic($category);

        return view('news.category', compact('news', 'category', 'categoryLabel'));
    }

    /**
     * Display announcements.
     */
    public function announcements()
    {
        $news = News::published()
            ->byType('announcement')
            ->latest('published_at')
            ->paginate(12);

        return view('news.announcements', compact('news'));
    }

    /**
     * Get featured news for homepage.
     */
    public function getFeaturedNews($limit = 6)
    {
        return News::published()
            ->featured()
            ->latest('published_at')
            ->limit($limit)
            ->get();
    }

    /**
     * Get latest news for homepage.
     */
    public function getLatestNews($limit = 6)
    {
        return News::published()
            ->latest('published_at')
            ->limit($limit)
            ->get();
    }

    /**
     * Get pinned news.
     */
    public function getPinnedNews($limit = 3)
    {
        return News::published()
            ->pinned()
            ->latest('published_at')
            ->limit($limit)
            ->get();
    }
}
