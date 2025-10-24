<?php
require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$library = App\Models\Library::find(1);

echo "=== LIBRARY PUBLIC DEBUG ===\n";
echo "ID: " . $library->id . "\n";
echo "Name: " . $library->name . "\n";
echo "Organization Chart field: " . ($library->organization_chart ?? 'NULL') . "\n";
echo "Organization Chart URL: " . $library->organization_chart_url . "\n";

// Test if field is truthy
echo "Field is truthy: " . ($library->organization_chart ? 'YES' : 'NO') . "\n";

// Test file existence
$filePath = public_path($library->organization_chart);
echo "File path: " . $filePath . "\n";
echo "File exists: " . (file_exists($filePath) ? 'YES' : 'NO') . "\n";

// Test URL accessibility
$url = $library->organization_chart_url;
echo "Full URL: " . $url . "\n";

// Test asset helper
$assetUrl = asset($library->organization_chart);
echo "Asset URL: " . $assetUrl . "\n";

// Test if default image exists
$defaultPath = public_path('images/default-library-org-chart.png');
echo "Default image path: " . $defaultPath . "\n";
echo "Default image exists: " . (file_exists($defaultPath) ? 'YES' : 'NO') . "\n";

echo "=== END DEBUG ===\n";
?>
