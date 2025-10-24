<?php
/**
 * Script untuk test direct image routes di hosting
 * Script ini akan test apakah direct image serving berfungsi di hosting
 */

echo "=== TEST HOSTING DIRECT IMAGES ===\n";
echo "Script untuk test direct image routes di hosting\n\n";

// Base URL hosting
$baseUrl = 'https://smpnegeri01namrole.sch.id';

// Test direct image serving URLs
$testUrls = [
    'Home Section Image' => '/image/home-section/1/image',
    'News Image' => '/image/news/1/featured_image',
    'Facility Image' => '/image/facility/1/image',
    'Gallery Image' => '/image/gallery/1/image',
    'Direct folder access' => '/image/home-sections/1760823551_Screenshot_2025-10-17_153943.png'
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

// Test home page access
echo "🏠 Testing home page access:\n";
$homeUrl = $baseUrl . '/';
echo "   URL: $homeUrl\n";

if (function_exists('curl_init')) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $homeUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    
    curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    if ($httpCode == 200) {
        echo "   ✅ Home page accessible\n";
    } else {
        echo "   ❌ Home page not accessible ($httpCode)\n";
    }
} else {
    echo "   ⚠️  cURL tidak tersedia\n";
}

echo "\n✅ Direct image hosting test completed!\n";
echo "📝 Catatan:\n";
echo "- Direct image serving menggunakan route /image/{model}/{id}/{field}\n";
echo "- Gambar di-serve langsung tanpa perlu symbolic link\n";
echo "- Fallback ke default image jika file tidak ditemukan\n";
echo "- Cache headers untuk performa yang lebih baik\n";
?>
