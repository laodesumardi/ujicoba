<?php

require 'vendor/autoload.php';

$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "Library count: " . App\Models\Library::count() . PHP_EOL;

if (App\Models\Library::count() > 0) {
    $lib = App\Models\Library::first();
    echo "First library: " . $lib->name . PHP_EOL;
    echo "Logo: " . ($lib->logo ?? 'null') . PHP_EOL;
    echo "Banner: " . ($lib->banner_image ?? 'null') . PHP_EOL;
    echo "Gallery: " . json_encode($lib->gallery_images) . PHP_EOL;
    echo "Organization Chart: " . ($lib->organization_chart ?? 'null') . PHP_EOL;
    
    // Check if files exist
    if ($lib->logo) {
        $logoPath = storage_path('app/public/' . $lib->logo);
        echo "Logo file exists: " . (file_exists($logoPath) ? 'YES' : 'NO') . PHP_EOL;
        echo "Logo path: " . $logoPath . PHP_EOL;
    }
    
    if ($lib->banner_image) {
        $bannerPath = storage_path('app/public/' . $lib->banner_image);
        echo "Banner file exists: " . (file_exists($bannerPath) ? 'YES' : 'NO') . PHP_EOL;
        echo "Banner path: " . $bannerPath . PHP_EOL;
    }
    
    if ($lib->organization_chart) {
        $orgPath = storage_path('app/public/' . $lib->organization_chart);
        echo "Organization chart file exists: " . (file_exists($orgPath) ? 'YES' : 'NO') . PHP_EOL;
        echo "Organization chart path: " . $orgPath . PHP_EOL;
    }
    
    if ($lib->gallery_images && is_array($lib->gallery_images)) {
        foreach ($lib->gallery_images as $index => $image) {
            $galleryPath = storage_path('app/public/' . $image);
            echo "Gallery image " . ($index + 1) . " exists: " . (file_exists($galleryPath) ? 'YES' : 'NO') . PHP_EOL;
            echo "Gallery image " . ($index + 1) . " path: " . $galleryPath . PHP_EOL;
        }
    }
}
