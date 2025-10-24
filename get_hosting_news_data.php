<?php
/**
 * Script untuk mengambil data berita dari database hosting
 */

require_once __DIR__ . '/vendor/autoload.php';

// Bootstrap Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\News;

echo "=== GET HOSTING NEWS DATA ===\n";

try {
    // Get all news data
    $allNews = News::all();
    $publishedNews = News::where('status', 'published')->get();
    $featuredNews = News::where('status', 'published')->where('is_featured', true)->get();
    $pinnedNews = News::where('status', 'published')->where('is_pinned', true)->get();
    
    echo "=== NEWS STATISTICS ===\n";
    echo "Total news in database: " . $allNews->count() . "\n";
    echo "Published news: " . $publishedNews->count() . "\n";
    echo "Featured news: " . $featuredNews->count() . "\n";
    echo "Pinned news: " . $pinnedNews->count() . "\n";
    
    // Show all published news
    echo "\n=== PUBLISHED NEWS ===\n";
    foreach ($publishedNews as $news) {
        echo "ID: {$news->id}\n";
        echo "Title: {$news->title}\n";
        echo "Category: {$news->category}\n";
        echo "Type: {$news->type}\n";
        echo "Status: {$news->status}\n";
        echo "Featured: " . ($news->is_featured ? 'Yes' : 'No') . "\n";
        echo "Pinned: " . ($news->is_pinned ? 'Yes' : 'No') . "\n";
        echo "Published At: {$news->published_at}\n";
        echo "Created At: {$news->created_at}\n";
        echo "Views: {$news->views}\n";
        echo "---\n";
    }
    
    // Show categories
    echo "\n=== CATEGORIES ===\n";
    $categories = News::selectRaw('category, COUNT(*) as count')
        ->where('status', 'published')
        ->groupBy('category')
        ->get();
    foreach ($categories as $cat) {
        echo "{$cat->category}: {$cat->count} articles\n";
    }
    
    // Show types
    echo "\n=== TYPES ===\n";
    $types = News::selectRaw('type, COUNT(*) as count')
        ->where('status', 'published')
        ->groupBy('type')
        ->get();
    foreach ($types as $type) {
        echo "{$type->type}: {$type->count} articles\n";
    }
    
    // Test the published scope
    echo "\n=== TESTING PUBLISHED SCOPE ===\n";
    $scopeNews = News::published()->get();
    echo "News from published scope: " . $scopeNews->count() . "\n";
    
    // Test the query that should be used in the controller
    echo "\n=== TESTING CONTROLLER QUERY ===\n";
    $controllerNews = News::published()->latest('published_at')->get();
    echo "News from controller query: " . $controllerNews->count() . "\n";
    
    if ($controllerNews->count() > 0) {
        echo "Sample news from controller query:\n";
        foreach ($controllerNews->take(3) as $news) {
            echo "- {$news->title} ({$news->category})\n";
        }
    }
    
    // Check for any issues
    echo "\n=== CHECKING FOR ISSUES ===\n";
    
    // Check for news with null published_at
    $nullPublishedAt = News::where('status', 'published')->whereNull('published_at')->count();
    echo "Published news with null published_at: $nullPublishedAt\n";
    
    // Check for news with future published_at
    $futurePublished = News::where('status', 'published')->where('published_at', '>', now())->count();
    echo "Published news with future published_at: $futurePublished\n";
    
    // Check for news with past published_at
    $pastPublished = News::where('status', 'published')->where('published_at', '<=', now())->count();
    echo "Published news with past published_at: $pastPublished\n";
    
    // If no news found, create sample data
    if ($publishedNews->count() == 0) {
        echo "\n=== NO PUBLISHED NEWS FOUND ===\n";
        echo "Creating sample news data...\n";
        
        $sampleNews = [
            [
                'title' => 'Selamat Datang di SMP Negeri 01 Namrole',
                'excerpt' => 'SMP Negeri 01 Namrole adalah sekolah menengah pertama yang berkomitmen untuk memberikan pendidikan berkualitas.',
                'content' => '<p>SMP Negeri 01 Namrole adalah sekolah menengah pertama yang berkomitmen untuk memberikan pendidikan berkualitas dan membentuk karakter siswa yang unggul.</p>',
                'category' => 'akademik',
                'type' => 'news',
                'status' => 'published',
                'is_featured' => true,
                'is_pinned' => true,
                'published_at' => now(),
                'author_name' => 'Admin SMP Negeri 01 Namrole',
                'author_email' => 'admin@smpnegeri01namrole.sch.id'
            ],
            [
                'title' => 'Penerimaan Siswa Baru Tahun Ajaran 2025/2026',
                'excerpt' => 'Informasi lengkap mengenai pendaftaran siswa baru untuk tahun ajaran 2025/2026.',
                'content' => '<p>Pendaftaran siswa baru untuk tahun ajaran 2025/2026 akan dibuka mulai tanggal 1 Januari 2025.</p>',
                'category' => 'akademik',
                'type' => 'announcement',
                'status' => 'published',
                'is_featured' => true,
                'is_pinned' => true,
                'published_at' => now(),
                'author_name' => 'Admin SMP Negeri 01 Namrole',
                'author_email' => 'admin@smpnegeri01namrole.sch.id'
            ]
        ];
        
        foreach ($sampleNews as $newsData) {
            $news = News::create($newsData);
            echo "Created: {$news->title}\n";
        }
        
        echo "Sample news created successfully!\n";
    }
    
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
}

echo "\n=== END GET HOSTING NEWS DATA ===\n";
?>
