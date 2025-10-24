<?php
require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$library = App\Models\Library::find(1);

echo "=== FINAL URL TEST ===\n";
echo "Organization Chart field: " . ($library->organization_chart ?? 'NULL') . "\n";
echo "Organization Chart URL: " . $library->organization_chart_url . "\n";

// Test different URL generation methods
echo "\n=== URL COMPARISON ===\n";

// Method 1: Direct asset
$directAsset = asset('images/default-library-org-chart.png');
echo "Direct asset: {$directAsset}\n";

// Method 2: Manual URL with port
$manualUrl = 'http://localhost:8000/images/default-library-org-chart.png';
echo "Manual URL with port: {$manualUrl}\n";

// Test accessibility
echo "\n=== ACCESSIBILITY TEST ===\n";

$urls = [
    'Library accessor' => $library->organization_chart_url,
    'Direct asset' => $directAsset,
    'Manual with port' => $manualUrl
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
