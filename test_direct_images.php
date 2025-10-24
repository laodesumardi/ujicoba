<?php
/**
 * Script untuk test direct image serving
 * Script ini akan test apakah gambar bisa diakses langsung tanpa link
 */

echo "=== TEST DIRECT IMAGE SERVING ===\n";
echo "Script untuk test direct image serving\n\n";

// Base URL hosting
$baseUrl = 'https://smpnegeri01namrole.sch.id';

// Test direct image serving URLs
$testUrls = [
    'Direct folder access' => '/image/home-sections/1760823551_Screenshot_2025-10-17_153943.png',
    'Model-based access' => '/image/home-section/1/image',
    'News image' => '/image/news/1/featured_image',
    'Facility image' => '/image/facility/1/image',
    'Gallery image' => '/image/gallery/1/image'
];

echo "🔗 Testing direct image serving URLs:\n\n";

foreach ($testUrls as $name => $path) {
    $fullUrl = $baseUrl . $path;
    echo "📁 $name:\n";
    echo "   URL: $fullUrl\n";
    
    // Test dengan curl jika tersedia
    if (function_exists('curl_init')) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $fullUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_HEADER, true);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $contentType = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
        curl_close($ch);
        
        if ($httpCode == 200) {
            echo "   ✅ Status: OK ($httpCode)\n";
            echo "   📄 Content-Type: $contentType\n";
            
            // Check if it's an image
            if (strpos($contentType, 'image/') === 0) {
                echo "   🖼️  Valid image content\n";
            } else {
                echo "   ⚠️  Not an image content\n";
            }
        } elseif ($httpCode == 403) {
            echo "   ❌ Status: Forbidden ($httpCode) - Permission issue\n";
        } elseif ($httpCode == 404) {
            echo "   ❌ Status: Not Found ($httpCode) - Route or file not found\n";
        } else {
            echo "   ⚠️  Status: $httpCode\n";
        }
    } else {
        echo "   ⚠️  cURL tidak tersedia, tidak bisa test HTTP\n";
    }
    
    echo "\n";
}

// Test local route generation
echo "🧪 Testing local route generation...\n\n";

// Include Laravel autoloader
require_once __DIR__ . '/vendor/autoload.php';

// Bootstrap Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\HomeSection;
use App\Models\News;
use App\Models\Facility;
use App\Models\Gallery;

try {
    // Test HomeSection route
    $homeSection = HomeSection::first();
    if ($homeSection) {
        $imageUrl = $homeSection->image_url;
        echo "📁 HomeSection Image URL: $imageUrl\n";
        
        if (strpos($imageUrl, '/image/') !== false) {
            echo "   ✅ Direct image route generated\n";
        } else {
            echo "   ❌ Not using direct image route\n";
        }
    } else {
        echo "📁 No HomeSection records found\n";
    }
    
    // Test News route
    $news = News::first();
    if ($news) {
        $imageUrl = $news->featured_image_url;
        echo "📁 News Image URL: $imageUrl\n";
        
        if (strpos($imageUrl, '/image/') !== false) {
            echo "   ✅ Direct image route generated\n";
        } else {
            echo "   ❌ Not using direct image route\n";
        }
    } else {
        echo "📁 No News records found\n";
    }
    
} catch (\Exception $e) {
    echo "❌ Error testing routes: " . $e->getMessage() . "\n";
}

echo "\n✅ Direct image serving test completed!\n";
echo "📝 Catatan:\n";
echo "- Direct image serving menggunakan route /image/{model}/{id}/{field}\n";
echo "- Gambar di-serve langsung tanpa perlu link ke public/storage\n";
echo "- Fallback ke default image jika file tidak ditemukan\n";
echo "- Cache headers untuk performa yang lebih baik\n";
?>
