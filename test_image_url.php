<?php

require 'vendor/autoload.php';

$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$lib = App\Models\Library::first();
if ($lib) {
    echo "Library: " . $lib->name . PHP_EOL;
    echo "Logo URL: " . $lib->logo_url . PHP_EOL;
    echo "Banner URL: " . $lib->banner_image_url . PHP_EOL;
    echo "Organization Chart URL: " . $lib->organization_chart_url . PHP_EOL;
    echo "Gallery URLs: " . json_encode($lib->gallery_images_urls) . PHP_EOL;
    
    // Test if URLs are accessible
    $logoUrl = $lib->logo_url;
    echo "Testing logo URL: " . $logoUrl . PHP_EOL;
    
    // Check if the route exists
    $route = route('image.serve.model', ['model' => 'library', 'id' => $lib->id, 'field' => 'logo']);
    echo "Route URL: " . $route . PHP_EOL;
}
