<?php

echo "🖼️  Fixing Section Update Images for Hosting\n";
echo "===========================================\n\n";

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

// 3. Fix storage structure for section updates
echo "\n🔗 Fixing storage structure for section updates...\n";

// Create necessary directories
$directories = [
    'storage/app/public',
    'storage/app/public/home-sections',
    'public/storage',
    'public/storage/home-sections',
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

// 4. Fix home sections data for updates
echo "\n📊 Fixing home sections data for updates...\n";

try {
    // Get all home sections
    $sections = DB::table('home_sections')->get();
    echo "   📊 Found " . count($sections) . " home sections\n";
    
    $fixed = 0;
    $imagesCopied = 0;
    $sectionsUpdated = 0;
    
    foreach ($sections as $section) {
        echo "   🔍 Processing section ID {$section->id}: {$section->title}\n";
        
        $needsUpdate = false;
        $updateData = [];
        
        // Fix image path
        if ($section->image) {
            echo "   📁 Current image: {$section->image}\n";
            
            // Clean image path (remove 'storage/' prefix if exists)
            $cleanPath = $section->image;
            if (strpos($cleanPath, 'storage/') === 0) {
                $cleanPath = substr($cleanPath, 8);
                $updateData['image'] = $cleanPath;
                $needsUpdate = true;
                echo "   🔧 Fixed image path: {$cleanPath}\n";
            }
            
            // Check if image exists in storage
            $storagePath = storage_path('app/public/' . $cleanPath);
            $publicPath = public_path('storage/' . $cleanPath);
            
            if (file_exists($storagePath)) {
                echo "   ✅ Image exists in storage\n";
                
                // Copy to public storage
                if (!file_exists($publicPath)) {
                    $publicDir = dirname($publicPath);
                    if (!is_dir($publicDir)) {
                        mkdir($publicDir, 0755, true);
                    }
                    
                    if (copy($storagePath, $publicPath)) {
                        echo "   ✅ Image copied to public storage\n";
                        $imagesCopied++;
                    } else {
                        echo "   ❌ Failed to copy image to public storage\n";
                    }
                } else {
                    echo "   ✅ Image already in public storage\n";
                }
            } else {
                echo "   ❌ Image not found in storage\n";
                $updateData['image'] = null;
                $needsUpdate = true;
            }
        } else {
            echo "   ℹ️  Section has no image\n";
        }
        
        // Fix other fields for updates
        if (empty($section->section_key)) {
            $updateData['section_key'] = 'section-' . $section->id;
            $needsUpdate = true;
            echo "   🔧 Added section key\n";
        }
        
        if (empty($section->is_active)) {
            $updateData['is_active'] = 1;
            $needsUpdate = true;
            echo "   🔧 Set as active\n";
        }
        
        // Ensure content is not empty
        if (empty($section->content)) {
            $updateData['content'] = 'Default content for ' . $section->title;
            $needsUpdate = true;
            echo "   🔧 Added default content\n";
        }
        
        // Update database if needed
        if ($needsUpdate) {
            DB::table('home_sections')
                ->where('id', $section->id)
                ->update($updateData);
            echo "   ✅ Updated section in database\n";
            $sectionsUpdated++;
        } else {
            echo "   ✅ Section data is correct\n";
        }
        
        $fixed++;
    }
    
    echo "\n   📊 Summary:\n";
    echo "   - Sections processed: " . count($sections) . "\n";
    echo "   - Sections fixed: {$fixed}\n";
    echo "   - Sections updated: {$sectionsUpdated}\n";
    echo "   - Images copied: {$imagesCopied}\n";
    
} catch (Exception $e) {
    echo "   ❌ Error processing home sections: " . $e->getMessage() . "\n";
}

// 5. Create default images for section updates
echo "\n🖼️  Creating default images for section updates...\n";

$defaultImages = [
    'public/images/default-section.png' => 'Default section image',
    'public/images/default-hero.png' => 'Default hero image',
    'public/images/default-teacher.png' => 'Default teacher image',
    'public/images/default-facility.png' => 'Default facility image',
    'public/images/default-logo.png' => 'Default logo image'
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

// 6. Ensure admin user exists for updates
echo "\n👤 Ensuring admin user exists for updates...\n";

try {
    $adminUser = DB::table('users')->where('role', 'admin')->first();
    if ($adminUser) {
        echo "   ✅ Admin user found: {$adminUser->name}\n";
        echo "   📧 Email: {$adminUser->email}\n";
    } else {
        echo "   ❌ No admin user found\n";
        echo "   🔧 Creating default admin user...\n";
        
        $adminId = DB::table('users')->insertGetId([
            'name' => 'Administrator',
            'email' => 'admin@namrole.sch.id',
            'password' => bcrypt('admin123'),
            'role' => 'admin',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        
        if ($adminId) {
            echo "   ✅ Default admin user created\n";
            echo "   📧 Email: admin@namrole.sch.id\n";
            echo "   🔑 Password: admin123\n";
        } else {
            echo "   ❌ Failed to create admin user\n";
        }
    }
} catch (Exception $e) {
    echo "   ❌ Error checking admin user: " . $e->getMessage() . "\n";
}

// 7. Fix file permissions for updates
echo "\n🔐 Fixing file permissions for updates...\n";

$permissionDirs = [
    'storage/app/public',
    'storage/app/public/home-sections',
    'public/storage',
    'public/storage/home-sections',
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

// 8. Test section update functionality
echo "\n🧪 Testing section update functionality...\n";

try {
    // Test getting section by ID
    $testSection = DB::table('home_sections')->where('id', 1)->first();
    if ($testSection) {
        echo "   ✅ Section ID 1 found: {$testSection->title}\n";
        echo "   📝 Content: " . substr($testSection->content ?? '', 0, 50) . "...\n";
        echo "   🔗 Section Key: {$testSection->section_key}\n";
        echo "   ✅ Active: " . ($testSection->is_active ? 'Yes' : 'No') . "\n";
        
        if ($testSection->image) {
            echo "   🖼️  Image: {$testSection->image}\n";
            
            // Test image paths
            $storagePath = storage_path('app/public/' . $testSection->image);
            $publicPath = public_path('storage/' . $testSection->image);
            
            if (file_exists($storagePath)) {
                echo "      ✅ Storage: {$storagePath}\n";
            } else {
                echo "      ❌ Storage: {$storagePath} (missing)\n";
            }
            
            if (file_exists($publicPath)) {
                echo "      ✅ Public: {$publicPath}\n";
            } else {
                echo "      ❌ Public: {$publicPath} (missing)\n";
            }
            
            // Test image URL
            $imageUrl = asset('storage/' . $testSection->image);
            echo "      🌐 URL: {$imageUrl}\n";
            
        } else {
            echo "   🖼️  Image: None\n";
        }
    } else {
        echo "   ❌ Section ID 1 not found\n";
    }
} catch (Exception $e) {
    echo "   ❌ Error testing section update: " . $e->getMessage() . "\n";
}

// 9. Clear cache for updates
echo "\n🧹 Clearing cache for updates...\n";

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

echo "\n✅ Section update images fix completed!\n";
echo "🔧 Key improvements applied:\n";
echo "   - Fixed storage structure for section updates\n";
echo "   - Updated home sections data and images\n";
echo "   - Copied images from storage to public storage\n";
echo "   - Created default images for fallbacks\n";
echo "   - Ensured admin user exists\n";
echo "   - Fixed file permissions\n";
echo "   - Cleared all caches\n";
echo "\n🌐 Test your section updates:\n";
echo "   - Login: https://uji.odetune.shop/login\n";
echo "   - Edit Section: https://uji.odetune.shop/admin/home-sections/1/edit\n";
echo "   - Check if images appear in edit forms\n";
echo "   - Test image upload functionality\n";
echo "\n🔑 Admin Login:\n";
echo "   - Email: admin@namrole.sch.id\n";
echo "   - Password: admin123\n";
echo "\n📱 Mobile testing:\n";
echo "   - Test admin access on mobile\n";
echo "   - Check image display on mobile\n";
echo "   - Verify form submissions work\n";
