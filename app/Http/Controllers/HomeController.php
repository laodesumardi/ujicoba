<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HomeSection;
use App\Models\News;

class HomeController extends Controller
{
    public function index()
    {
        $sections = HomeSection::where('is_active', true)
            ->orderBy('sort_order')
            ->get()
            ->keyBy('section_key');

        // Get latest news for homepage
        $latestNews = News::published()
            ->latest('published_at')
            ->limit(6)
            ->get();

        // Get featured news
        $featuredNews = News::published()
            ->featured()
            ->latest('published_at')
            ->limit(3)
            ->get();

        // Get pinned news
        $pinnedNews = News::published()
            ->pinned()
            ->latest('published_at')
            ->limit(3)
            ->get();

        return view('welcome', compact('sections', 'latestNews', 'featuredNews', 'pinnedNews'));
    }
}