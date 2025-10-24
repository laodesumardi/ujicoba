<?php
require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$library = App\Models\Library::find(1);
echo "Organization Chart: " . ($library->organization_chart ?? 'NULL') . "\n";
echo "URL: " . $library->organization_chart_url . "\n";
echo "File exists: " . (file_exists(public_path($library->organization_chart)) ? 'YES' : 'NO') . "\n";
?>
