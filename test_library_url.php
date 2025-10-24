<?php
require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$library = App\Models\Library::find(1);

echo "=== LIBRARY URL TEST ===\n";
echo "Organization Chart field: " . ($library->organization_chart ?? 'NULL') . "\n";
echo "Organization Chart URL: " . $library->organization_chart_url . "\n";

// Test different URL generation methods
echo "\n=== URL GENERATION TEST ===\n";

// Method 1: Direct asset
$directAsset = asset('images/default-library-org-chart.png');
echo "Direct asset: {$directAsset}\n";

// Method 2: Using StorageHelper
$storageHelperUrl = \App\Helpers\StorageHelper::getImageUrl('images/default-library-org-chart.png');
echo "StorageHelper URL: {$storageHelperUrl}\n";

// Method 3: Manual URL construction
$manualUrl = url('images/default-library-org-chart.png');
echo "Manual URL: {$manualUrl}\n";

// Test if URLs are accessible
echo "\n=== URL ACCESSIBILITY TEST ===\n";

$urls = [
    'Direct asset' => $directAsset,
    'StorageHelper' => $storageHelperUrl,
    'Manual URL' => $manualUrl,
    'Library accessor' => $library->organization_chart_url
];

foreach ($urls as $name => $url) {
    echo "Testing {$name}: {$url}\n";
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    $result = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $finalUrl = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
    curl_close($ch);
    
    echo "  HTTP Code: {$httpCode}\n";
    echo "  Final URL: {$finalUrl}\n";
    echo "  Status: " . ($httpCode == 200 ? 'SUCCESS' : 'FAILED') . "\n\n";
}

echo "=== END TEST ===\n";
?>
