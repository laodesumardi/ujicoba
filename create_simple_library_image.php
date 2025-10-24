<?php
/**
 * Script untuk membuat gambar library yang lebih sederhana
 */

require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Library;

echo "=== CREATE SIMPLE LIBRARY IMAGE ===\n";

try {
    // Get library with ID 1
    $library = Library::find(1);
    
    if (!$library) {
        echo "Library with ID 1 not found!\n";
        exit;
    }
    
    echo "Library found: {$library->name}\n";
    
    // Create a simple 300x200 image with text
    $width = 300;
    $height = 200;
    $image = imagecreate($width, $height);
    
    // Set background color (light blue)
    $bgColor = imagecolorallocate($image, 240, 248, 255);
    imagefill($image, 0, 0, $bgColor);
    
    // Set text color (dark blue)
    $textColor = imagecolorallocate($image, 25, 25, 112);
    
    // Add border
    $borderColor = imagecolorallocate($image, 100, 149, 237);
    imagerectangle($image, 0, 0, $width-1, $height-1, $borderColor);
    
    // Add text
    $text = "STRUKTUR ORGANISASI";
    $fontSize = 5;
    $textWidth = imagefontwidth($fontSize) * strlen($text);
    $x = ($width - $textWidth) / 2;
    $y = 50;
    imagestring($image, $fontSize, $x, $y, $text, $textColor);
    
    $text2 = "PERPUSTAKAAN";
    $textWidth2 = imagefontwidth($fontSize) * strlen($text2);
    $x2 = ($width - $textWidth2) / 2;
    $y2 = 80;
    imagestring($image, $fontSize, $x2, $y2, $text2, $textColor);
    
    $text3 = "SMP NEGERI 01 NAMROLE";
    $fontSize3 = 3;
    $textWidth3 = imagefontwidth($fontSize3) * strlen($text3);
    $x3 = ($width - $textWidth3) / 2;
    $y3 = 120;
    imagestring($image, $fontSize3, $x3, $y3, $text3, $textColor);
    
    // Save image
    $imagePath = public_path('images/default-library-org-chart.png');
    imagepng($image, $imagePath);
    imagedestroy($image);
    
    echo "Created simple library organization chart image\n";
    echo "Image path: {$imagePath}\n";
    echo "Image exists: " . (file_exists($imagePath) ? 'YES' : 'NO') . "\n";
    
    // Test URL
    $url = asset('images/default-library-org-chart.png');
    echo "Asset URL: {$url}\n";
    
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
}

echo "\n=== END ===\n";
?>
