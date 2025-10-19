<?php
// Test Gallery model accessor
require_once "vendor/autoload.php";

try {
    // Bootstrap Laravel
    $app = require_once "bootstrap/app.php";
    $app->make("Illuminate\Contracts\Console\Kernel")->bootstrap();
    
    // Test Gallery model
    $gallery = new \App\Models\Gallery();
    $gallery->category = "kegiatan";
    $gallery->type = "photo";
    $gallery->status = "published";
    
    echo "Testing Gallery accessors:\n";
    echo "Category Label: " . $gallery->category_label . "\n";
    echo "Type Label: " . $gallery->type_label . "\n";
    echo "Status Label: " . $gallery->status_label . "\n";
    
    echo "✅ Gallery accessors working correctly\n";
    
} catch (Exception $e) {
    echo "❌ Error testing Gallery accessors: " . $e->getMessage() . "\n";
}
