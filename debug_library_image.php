<?php
/**
 * Debug script untuk library image
 */

require_once __DIR__ . '/vendor/autoload.php';

// Bootstrap Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Library;
use App\Helpers\StorageHelper;

echo "=== DEBUG LIBRARY IMAGE ===\n";

try {
    // Get library with ID 1
    $library = Library::find(1);
    
    if (!$library) {
        echo "Library with ID 1 not found!\n";
        exit;
    }
    
    echo "Library found: {$library->name}\n";
    echo "Organization Chart field: " . ($library->organization_chart ?? 'NULL') . "\n";
    
    if ($library->organization_chart) {
        echo "Organization Chart URL: " . $library->organization_chart_url . "\n";
        
        // Check if file exists in storage
        $storagePath = storage_path('app/public/' . $library->organization_chart);
        echo "Storage path: {$storagePath}\n";
        echo "Storage exists: " . (file_exists($storagePath) ? 'YES' : 'NO') . "\n";
        
        // Check if file exists in public
        $publicPath = public_path('storage/' . $library->organization_chart);
        echo "Public path: {$publicPath}\n";
        echo "Public exists: " . (file_exists($publicPath) ? 'YES' : 'NO') . "\n";
        
        // Try StorageHelper
        $storageHelperUrl = StorageHelper::getImageUrl($library->organization_chart);
        echo "StorageHelper URL: {$storageHelperUrl}\n";
        
        // Check if URL is accessible
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $storageHelperUrl);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        $result = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        echo "HTTP Status Code: {$httpCode}\n";
        
    } else {
        echo "No organization chart image set!\n";
    }
    
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
}

echo "\n=== END DEBUG ===\n";
?>
