<?php
/**
 * Script untuk memeriksa data berita
 */

require_once __DIR__ . '/vendor/autoload.php';

// Bootstrap Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\News;

echo "=== CHECK NEWS DATA ===\n";

try {
    // Check total news
    $totalNews = News::count();
    echo "Total news: $totalNews\n";
    
    // Check published news
    $publishedNews = News::where('status', 'published')->count();
    echo "Published news: $publishedNews\n";
    
    // Check news with published_at
    $scheduledNews = News::where('status', 'published')
        ->where('published_at', '>', now())
        ->count();
    echo "Scheduled news: $scheduledNews\n";
    
    // Check available news (published and not scheduled)
    $availableNews = News::where('status', 'published')
        ->where(function($q) {
            $q->whereNull('published_at')
              ->orWhere('published_at', '<=', now());
        })
        ->count();
    echo "Available news: $availableNews\n";
    
    // Show sample news
    echo "\nSample news:\n";
    $sampleNews = News::limit(5)->get(['id', 'title', 'status', 'published_at', 'created_at']);
    foreach ($sampleNews as $news) {
        echo "- ID: {$news->id}, Title: {$news->title}, Status: {$news->status}, Published: {$news->published_at}\n";
    }
    
    // Check categories
    echo "\nCategories:\n";
    $categories = News::selectRaw('category, COUNT(*) as count')
        ->groupBy('category')
        ->get();
    foreach ($categories as $cat) {
        echo "- {$cat->category}: {$cat->count} articles\n";
    }
    
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

echo "\n=== END CHECK ===\n";
?>
