<?php

echo "🖼️  Fixing Images for Hosting - Home Sections\n";
echo "==============================================\n\n";

// 1. Check if we're in Laravel project
if (!file_exists('artisan')) {
    echo "❌ Error: Not in Laravel project directory\n";
    echo "Please run this script from your Laravel project root\n";
    exit(1);
}

echo "✅ Laravel project detected\n";

// 2. Bootstrap Laravel
try {
    require_once 'vendor/autoload.php';
    $app = require_once 'bootstrap/app.php';
    $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
    echo "✅ Laravel bootstrapped successfully\n";
} catch (Exception $e) {
    echo "❌ Error bootstrapping Laravel: " . $e->getMessage() . "\n";
    exit(1);
}

// 3. Check storage link
echo "\n🔗 Checking storage link...\n";
$storageLink = 'public/storage';
if (is_link($storageLink)) {
    echo "   ✅ Storage link exists\n";
} else {
    echo "   ❌ Storage link missing\n";
    echo "   🔧 Creating storage link...\n";
    
    // Try to create storage link
    if (symlink('../storage/app/public', $storageLink)) {
        echo "   ✅ Storage link created\n";
    } else {
        echo "   ❌ Failed to create storage link\n";
        echo "   🔧 Creating manual storage directory...\n";
        
        // Create storage directory manually
        if (!is_dir($storageLink)) {
            mkdir($storageLink, 0755, true);
            echo "   ✅ Storage directory created\n";
        }
    }
}

// 4. Fix home sections images
echo "\n🏠 Fixing home sections images...\n";

try {
    // Get all home sections
    $sections = DB::table('home_sections')->get();
    echo "   📊 Found " . count($sections) . " home sections\n";
    
    $fixed = 0;
    $created = 0;
    
    foreach ($sections as $section) {
        if ($section->image) {
            echo "   🔍 Processing section: {$section->title}\n";
            echo "   📁 Current image path: {$section->image}\n";
            
            // Check if image exists in storage
            $storagePath = storage_path('app/public/' . $section->image);
            $publicPath = public_path('storage/' . $section->image);
            
            if (file_exists($storagePath)) {
                echo "   ✅ Image exists in storage\n";
                
                // Create directory if not exists
                $publicDir = dirname($publicPath);
                if (!is_dir($publicDir)) {
                    mkdir($publicDir, 0755, true);
                    echo "   📁 Created directory: " . basename($publicDir) . "\n";
                }
                
                // Copy image to public storage
                if (!file_exists($publicPath)) {
                    if (copy($storagePath, $publicPath)) {
                        echo "   ✅ Image copied to public storage\n";
                        $created++;
                    } else {
                        echo "   ❌ Failed to copy image to public storage\n";
                    }
                } else {
                    echo "   ✅ Image already exists in public storage\n";
                }
                
                // Test image URL
                $imageUrl = asset('storage/' . $section->image);
                echo "   🌐 Image URL: {$imageUrl}\n";
                
                $fixed++;
            } else {
                echo "   ❌ Image not found in storage: {$storagePath}\n";
                
                // Set image to null if not found
                DB::table('home_sections')
                    ->where('id', $section->id)
                    ->update(['image' => null]);
                echo "   🔄 Set image to null for section: {$section->title}\n";
            }
        } else {
            echo "   ℹ️  Section has no image: {$section->title}\n";
        }
    }
    
    echo "\n   📊 Summary:\n";
    echo "   - Sections processed: " . count($sections) . "\n";
    echo "   - Images fixed: {$fixed}\n";
    echo "   - Images created: {$created}\n";
    
} catch (Exception $e) {
    echo "   ❌ Error processing home sections: " . $e->getMessage() . "\n";
}

// 5. Create default images if missing
echo "\n🖼️  Creating default images...\n";

$defaultImages = [
    'public/images/default-section.png' => 'Default section image',
    'public/images/default-hero.png' => 'Default hero image',
    'public/images/default-teacher.png' => 'Default teacher image',
    'public/images/default-facility.png' => 'Default facility image'
];

foreach ($defaultImages as $path => $description) {
    if (!file_exists($path)) {
        echo "   🔧 Creating {$description}...\n";
        
        // Create a simple default image (1x1 pixel PNG)
        $image = imagecreate(1, 1);
        $white = imagecolorallocate($image, 255, 255, 255);
        imagefill($image, 0, 0, $white);
        
        if (imagepng($image, $path)) {
            echo "   ✅ Created: {$path}\n";
        } else {
            echo "   ❌ Failed to create: {$path}\n";
        }
        
        imagedestroy($image);
    } else {
        echo "   ✅ Already exists: {$path}\n";
    }
}

// 6. Fix storage permissions
echo "\n🔐 Fixing storage permissions...\n";

$directories = [
    'storage/app/public',
    'storage/app/public/home-sections',
    'public/storage',
    'public/storage/home-sections'
];

foreach ($directories as $dir) {
    if (is_dir($dir)) {
        chmod($dir, 0755);
        echo "   ✅ Set permission 755 for: {$dir}\n";
    } else {
        if (mkdir($dir, 0755, true)) {
            echo "   ✅ Created directory: {$dir}\n";
        } else {
            echo "   ❌ Failed to create directory: {$dir}\n";
        }
    }
}

// 7. Test image URLs
echo "\n🌐 Testing image URLs...\n";

try {
    $testSection = DB::table('home_sections')->whereNotNull('image')->first();
    if ($testSection) {
        $imageUrl = asset('storage/' . $testSection->image);
        echo "   🔗 Test URL: {$imageUrl}\n";
        
        // Check if URL is accessible
        $context = stream_context_create([
            'http' => [
                'timeout' => 5,
                'method' => 'HEAD'
            ]
        ]);
        
        $headers = @get_headers($imageUrl, 1, $context);
        if ($headers && strpos($headers[0], '200') !== false) {
            echo "   ✅ Image URL is accessible\n";
        } else {
            echo "   ❌ Image URL is not accessible\n";
        }
    } else {
        echo "   ℹ️  No sections with images found\n";
    }
} catch (Exception $e) {
    echo "   ❌ Error testing image URLs: " . $e->getMessage() . "\n";
}

// 8. Clear cache
echo "\n🧹 Clearing cache...\n";

try {
    // Clear config cache
    if (file_exists('bootstrap/cache/config.php')) {
        unlink('bootstrap/cache/config.php');
        echo "   ✅ Config cache cleared\n";
    }
    
    // Clear route cache
    if (file_exists('bootstrap/cache/routes.php')) {
        unlink('bootstrap/cache/routes.php');
        echo "   ✅ Route cache cleared\n";
    }
    
    // Clear view cache
    $viewCachePath = 'storage/framework/views';
    if (is_dir($viewCachePath)) {
        $files = glob($viewCachePath . '/*');
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }
        echo "   ✅ View cache cleared\n";
    }
    
    echo "   ✅ All caches cleared\n";
} catch (Exception $e) {
    echo "   ❌ Error clearing cache: " . $e->getMessage() . "\n";
}

echo "\n✅ Hosting images fix completed!\n";
echo "🔧 Key improvements applied:\n";
echo "   - Fixed storage link and permissions\n";
echo "   - Copied images from storage to public storage\n";
echo "   - Created default images for fallbacks\n";
echo "   - Set proper directory permissions\n";
echo "   - Cleared all caches\n";
echo "\n🌐 Test your admin panel now:\n";
echo "   - Admin: https://uji.odetune.shop/admin/home-sections/1/edit\n";
echo "   - Check if images appear in edit forms\n";
echo "   - Test image upload functionality\n";
echo "\n📱 Mobile testing:\n";
echo "   - Test on mobile devices\n";
echo "   - Check image loading on mobile\n";
echo "   - Verify form submissions work\n";
