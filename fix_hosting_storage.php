<?php

echo "🔧 Fixing Storage for Hosting (No Symlink)\n";
echo "==========================================\n\n";

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

// 3. Create storage directories
echo "\n📁 Creating storage directories...\n";

$directories = [
    'storage/app/public',
    'storage/app/public/home-sections',
    'storage/app/public/teachers',
    'storage/app/public/facilities',
    'storage/app/public/school-profiles',
    'public/storage',
    'public/storage/home-sections',
    'public/storage/teachers',
    'public/storage/facilities',
    'public/storage/school-profiles',
    'public/images'
];

foreach ($directories as $dir) {
    if (!is_dir($dir)) {
        if (mkdir($dir, 0755, true)) {
            echo "   ✅ Created directory: {$dir}\n";
        } else {
            echo "   ❌ Failed to create directory: {$dir}\n";
        }
    } else {
        echo "   ✅ Directory exists: {$dir}\n";
    }
}

// 4. Copy files from storage to public storage
echo "\n📋 Copying files from storage to public storage...\n";

$copyDirectories = [
    'home-sections' => 'Home sections',
    'teachers' => 'Teachers',
    'facilities' => 'Facilities',
    'school-profiles' => 'School profiles'
];

$copiedFiles = 0;
$totalFiles = 0;

foreach ($copyDirectories as $dir => $description) {
    $sourceDir = "storage/app/public/{$dir}";
    $destDir = "public/storage/{$dir}";
    
    if (is_dir($sourceDir)) {
        echo "   📁 Processing {$description}...\n";
        
        $files = glob($sourceDir . '/*');
        $dirFiles = 0;
        
        foreach ($files as $file) {
            if (is_file($file)) {
                $fileName = basename($file);
                $destFile = $destDir . '/' . $fileName;
                
                if (!file_exists($destFile)) {
                    if (copy($file, $destFile)) {
                        echo "      ✅ Copied: {$fileName}\n";
                        $copiedFiles++;
                    } else {
                        echo "      ❌ Failed to copy: {$fileName}\n";
                    }
                } else {
                    echo "      ✅ Already exists: {$fileName}\n";
                }
                $dirFiles++;
                $totalFiles++;
            }
        }
        
        echo "   📊 {$description}: {$dirFiles} files processed\n";
    } else {
        echo "   ℹ️  {$description} directory not found\n";
    }
}

echo "\n   📊 Summary:\n";
echo "   - Total files processed: {$totalFiles}\n";
echo "   - Files copied: {$copiedFiles}\n";

// 5. Create default images
echo "\n🖼️  Creating default images...\n";

$defaultImages = [
    'public/images/default-section.png' => 'Default section image',
    'public/images/default-hero.png' => 'Default hero image',
    'public/images/default-teacher.png' => 'Default teacher image',
    'public/images/default-facility.png' => 'Default facility image',
    'public/images/default-logo.png' => 'Default logo image',
    'public/images/default-school-profile.png' => 'Default school profile image'
];

$createdImages = 0;

foreach ($defaultImages as $path => $description) {
    if (!file_exists($path)) {
        echo "   🔧 Creating {$description}...\n";
        
        // Create a simple default image (300x200 PNG)
        $image = imagecreate(300, 200);
        $bgColor = imagecolorallocate($image, 240, 240, 240);
        $textColor = imagecolorallocate($image, 100, 100, 100);
        $borderColor = imagecolorallocate($image, 200, 200, 200);
        
        // Fill background
        imagefill($image, 0, 0, $bgColor);
        
        // Add border
        imagerectangle($image, 0, 0, 299, 199, $borderColor);
        
        // Add text
        $text = 'Default Image';
        $fontSize = 5;
        $textWidth = imagefontwidth($fontSize) * strlen($text);
        $textHeight = imagefontheight($fontSize);
        $x = (300 - $textWidth) / 2;
        $y = (200 - $textHeight) / 2;
        
        imagestring($image, $fontSize, $x, $y, $text, $textColor);
        
        if (imagepng($image, $path)) {
            echo "   ✅ Created: {$path}\n";
            $createdImages++;
        } else {
            echo "   ❌ Failed to create: {$path}\n";
        }
        
        imagedestroy($image);
    } else {
        echo "   ✅ Already exists: {$path}\n";
    }
}

echo "\n   📊 Default images created: {$createdImages}\n";

// 6. Fix file permissions
echo "\n🔐 Fixing file permissions...\n";

$permissionDirs = [
    'storage/app/public',
    'storage/app/public/home-sections',
    'storage/app/public/teachers',
    'storage/app/public/facilities',
    'storage/app/public/school-profiles',
    'public/storage',
    'public/storage/home-sections',
    'public/storage/teachers',
    'public/storage/facilities',
    'public/storage/school-profiles',
    'public/images'
];

foreach ($permissionDirs as $dir) {
    if (is_dir($dir)) {
        chmod($dir, 0755);
        echo "   ✅ Set permission 755 for: {$dir}\n";
        
        // Set permission for files in directory
        $files = glob($dir . '/*');
        foreach ($files as $file) {
            if (is_file($file)) {
                chmod($file, 0644);
            }
        }
    }
}

// 7. Test image URLs
echo "\n🌐 Testing image URLs...\n";

try {
    // Test home sections
    $sections = DB::table('home_sections')->whereNotNull('image')->limit(3)->get();
    if (count($sections) > 0) {
        echo "   🏠 Testing home sections images...\n";
        foreach ($sections as $section) {
            $imageUrl = asset('storage/' . $section->image);
            echo "   🔗 URL: {$imageUrl}\n";
        }
    }
    
    // Test teachers
    $teachers = DB::table('users')->where('role', 'teacher')->whereNotNull('photo')->limit(3)->get();
    if (count($teachers) > 0) {
        echo "   👨‍🏫 Testing teachers images...\n";
        foreach ($teachers as $teacher) {
            $imageUrl = asset('storage/' . $teacher->photo);
            echo "   🔗 URL: {$imageUrl}\n";
        }
    }
    
    // Test facilities
    $facilities = DB::table('facilities')->whereNotNull('image')->limit(3)->get();
    if (count($facilities) > 0) {
        echo "   🏢 Testing facilities images...\n";
        foreach ($facilities as $facility) {
            $imageUrl = asset('storage/' . $facility->image);
            echo "   🔗 URL: {$imageUrl}\n";
        }
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

echo "\n✅ Hosting storage fix completed!\n";
echo "🔧 Key improvements applied:\n";
echo "   - Created all necessary storage directories\n";
echo "   - Copied files from storage to public storage\n";
echo "   - Created default images for fallbacks\n";
echo "   - Set proper file permissions\n";
echo "   - Cleared all caches\n";
echo "\n🌐 Test your website now:\n";
echo "   - Admin: https://uji.odetune.shop/admin/home-sections\n";
echo "   - Teachers: https://uji.odetune.shop/admin/teachers\n";
echo "   - Facilities: https://uji.odetune.shop/admin/facilities\n";
echo "\n📱 Mobile testing:\n";
echo "   - Test on mobile devices\n";
echo "   - Check image loading on mobile\n";
echo "   - Verify form submissions work\n";
