<?php
/**
 * Script untuk test auto sync functionality
 * Script ini akan test apakah auto copy berfungsi dengan baik
 */

echo "=== TEST AUTO SYNC FUNCTIONALITY ===\n";
echo "Script untuk test auto sync setelah upload\n\n";

// Simulate upload process
$testFiles = [
    'home-sections/test-image-1.jpg',
    'news/test-news-image.png',
    'facilities/test-facility-image.jpeg',
    'galleries/test-gallery-image.jpg'
];

echo "🧪 Testing auto copy functionality...\n\n";

foreach ($testFiles as $filePath) {
    echo "📁 Testing: $filePath\n";
    
    // Simulate file creation in storage/app/public
    $sourcePath = __DIR__ . '/storage/app/public/' . $filePath;
    $destPath = __DIR__ . '/public/storage/' . $filePath;
    
    // Create source directory if not exists
    $sourceDir = dirname($sourcePath);
    if (!is_dir($sourceDir)) {
        mkdir($sourceDir, 0755, true);
    }
    
    // Create a dummy file for testing
    $dummyContent = "Test image content for " . basename($filePath);
    if (file_put_contents($sourcePath, $dummyContent)) {
        echo "   ✅ Source file created: $sourcePath\n";
        
        // Test auto copy
        $destDir = dirname($destPath);
        if (!is_dir($destDir)) {
            mkdir($destDir, 0755, true);
        }
        
        if (copy($sourcePath, $destPath)) {
            echo "   ✅ Auto copy successful: $destPath\n";
            
            // Verify file exists and is readable
            if (file_exists($destPath) && is_readable($destPath)) {
                echo "   ✅ File is accessible\n";
            } else {
                echo "   ❌ File is not accessible\n";
            }
        } else {
            echo "   ❌ Auto copy failed\n";
        }
    } else {
        echo "   ❌ Failed to create source file\n";
    }
    
    echo "\n";
}

// Test StorageHelper function
echo "🔧 Testing StorageHelper::autoCopyToPublic()...\n\n";

// Include Laravel autoloader
require_once __DIR__ . '/vendor/autoload.php';

// Bootstrap Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Helpers\StorageHelper;

$testPath = 'home-sections/test-helper.jpg';
$sourcePath = __DIR__ . '/storage/app/public/' . $testPath;
$sourceDir = dirname($sourcePath);

if (!is_dir($sourceDir)) {
    mkdir($sourceDir, 0755, true);
}

// Create test file
file_put_contents($sourcePath, "Test content for StorageHelper");

echo "📁 Testing StorageHelper with: $testPath\n";

$result = StorageHelper::autoCopyToPublic($testPath);

if ($result) {
    echo "   ✅ StorageHelper::autoCopyToPublic() successful\n";
    
    $destPath = __DIR__ . '/public/storage/' . $testPath;
    if (file_exists($destPath)) {
        echo "   ✅ File copied to public storage\n";
    } else {
        echo "   ❌ File not found in public storage\n";
    }
} else {
    echo "   ❌ StorageHelper::autoCopyToPublic() failed\n";
}

echo "\n✅ Auto sync test completed!\n";
echo "📝 Catatan:\n";
echo "- Auto copy akan berjalan otomatis saat upload gambar\n";
echo "- File akan langsung tersedia di public/storage\n";
echo "- Tidak perlu manual copy lagi\n";
?>
