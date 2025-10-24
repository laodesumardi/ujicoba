<?php
/**
 * Script untuk membuat gambar default library dan mengupdate database
 */

require_once __DIR__ . '/vendor/autoload.php';

// Bootstrap Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Library;
use Illuminate\Support\Facades\Storage;

echo "=== CREATE DEFAULT LIBRARY IMAGE ===\n";

try {
    // Get library with ID 1
    $library = Library::find(1);
    
    if (!$library) {
        echo "Library with ID 1 not found!\n";
        exit;
    }
    
    echo "Library found: {$library->name}\n";
    
    // Create a simple default organization chart image
    $imageData = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNkYPhfDwAChwGA60e6kgAAAABJRU5ErkJggg==');
    
    // Create a more meaningful default image (1x1 transparent PNG)
    $defaultImagePath = public_path('images/default-library-org-chart.png');
    
    if (!file_exists($defaultImagePath)) {
        // Create default image directory if not exists
        $imagesDir = dirname($defaultImagePath);
        if (!is_dir($imagesDir)) {
            mkdir($imagesDir, 0755, true);
        }
        
        // Create a simple 200x200 image with text
        $width = 200;
        $height = 200;
        $image = imagecreate($width, $height);
        
        // Set background color (light blue)
        $bgColor = imagecolorallocate($image, 240, 248, 255);
        imagefill($image, 0, 0, $bgColor);
        
        // Set text color (dark blue)
        $textColor = imagecolorallocate($image, 25, 25, 112);
        
        // Add text
        $text = "Library\nOrganization\nChart";
        $fontSize = 3;
        $textWidth = imagefontwidth($fontSize) * strlen("Library Organization Chart");
        $textHeight = imagefontheight($fontSize) * 3;
        $x = ($width - $textWidth) / 2;
        $y = ($height - $textHeight) / 2;
        
        imagestring($image, $fontSize, $x, $y, "Library", $textColor);
        imagestring($image, $fontSize, $x, $y + 20, "Organization", $textColor);
        imagestring($image, $fontSize, $x, $y + 40, "Chart", $textColor);
        
        // Save image
        imagepng($image, $defaultImagePath);
        imagedestroy($image);
        
        echo "Created default library organization chart image\n";
    }
    
    // Update library record to use the default image
    $library->organization_chart = 'images/default-library-org-chart.png';
    $library->save();
    
    echo "Updated library organization_chart field\n";
    echo "New organization_chart: {$library->organization_chart}\n";
    echo "Organization Chart URL: {$library->organization_chart_url}\n";
    
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
}

echo "\n=== END ===\n";
?>
