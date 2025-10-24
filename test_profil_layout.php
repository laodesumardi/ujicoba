<?php
/**
 * Script untuk test tampilan profil
 * Script ini akan test apakah halaman profil tampil dengan baik
 */

echo "=== TEST PROFIL LAYOUT ===\n";
echo "Script untuk test tampilan halaman profil\n\n";

// Base URL
$baseUrl = 'http://localhost:8000';

// Test URLs
$testUrls = [
    'Profil Page' => '/profil',
    'Home Page' => '/',
    'Admin Login' => '/admin/login'
];

echo "🔗 Testing profil page URLs:\n\n";

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
        curl_close($ch);
        
        if ($httpCode == 200) {
            echo "   ✅ Status: OK ($httpCode)\n";
        } elseif ($httpCode == 404) {
            echo "   ❌ Status: Not Found ($httpCode)\n";
        } elseif ($httpCode == 500) {
            echo "   ❌ Status: Server Error ($httpCode)\n";
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

use App\Models\SchoolProfile;
use App\Models\Accreditation;
use App\Models\Achievement;

try {
    // Test SchoolProfile data
    $sections = SchoolProfile::where('is_active', true)->get();
    echo "📁 SchoolProfile sections: " . $sections->count() . " active sections\n";
    
    // Test Accreditation data
    $accreditation = Accreditation::active()->first();
    if ($accreditation) {
        echo "📁 Accreditation: {$accreditation->status} (Score: {$accreditation->score})\n";
    } else {
        echo "📁 No accreditation data found\n";
    }
    
    // Test Achievement data
    $achievements = Achievement::active()->get();
    echo "📁 Achievements: " . $achievements->count() . " active achievements\n";
    
    // Test route generation
    $profilRoute = route('profil');
    echo "📁 Profil route: $profilRoute\n";
    
} catch (\Exception $e) {
    echo "❌ Error testing data: " . $e->getMessage() . "\n";
}

echo "\n✅ Profil layout test completed!\n";
echo "📝 Catatan:\n";
echo "- Halaman profil menggunakan data dari database\n";
echo "- Fallback values untuk data yang kosong\n";
echo "- Responsive design dengan Tailwind CSS\n";
echo "- Tab navigation untuk berbagai section\n";
?>
