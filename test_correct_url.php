<?php
require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== CORRECT URL TEST ===\n";

// Test with correct port
$correctUrl = 'http://localhost:8000/images/default-library-org-chart.png';
echo "Testing URL: {$correctUrl}\n";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $correctUrl);
curl_setopt($ch, CURLOPT_NOBODY, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
$result = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$finalUrl = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
curl_close($ch);

echo "HTTP Code: {$httpCode}\n";
echo "Final URL: {$finalUrl}\n";
echo "Status: " . ($httpCode == 200 ? 'SUCCESS' : 'FAILED') . "\n";

// Test file existence
$filePath = public_path('images/default-library-org-chart.png');
echo "\nFile path: {$filePath}\n";
echo "File exists: " . (file_exists($filePath) ? 'YES' : 'NO') . "\n";
echo "File size: " . (file_exists($filePath) ? filesize($filePath) . ' bytes' : 'N/A') . "\n";

echo "=== END TEST ===\n";
?>
