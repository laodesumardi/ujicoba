<?php

echo "🏠 Fixing Admin Home Sections Images for Hosting\n";
echo "================================================\n\n";

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

// 3. Fix storage structure for hosting
echo "\n🔗 Fixing storage structure for hosting...\n";

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

// 4. Create storage link if not exists
echo "\n🔗 Creating storage link...\n";
$storageLink = 'public/storage';

// Check if symlink function is available
if (function_exists('symlink')) {
    if (!is_link($storageLink)) {
        if (symlink('../storage/app/public', $storageLink)) {
            echo "   ✅ Storage link created\n";
        } else {
            echo "   ❌ Failed to create storage link\n";
            echo "   🔧 Creating manual storage directory...\n";
            
            // Create storage directory manually
            if (!is_dir($storageLink)) {
                mkdir($storageLink, 0755, true);
                echo "   ✅ Storage directory created manually\n";
            }
        }
    } else {
        echo "   ✅ Storage link already exists\n";
    }
} else {
    echo "   ⚠️  symlink() function not available on this hosting\n";
    echo "   🔧 Creating manual storage directory...\n";
    
    // Create storage directory manually
    if (!is_dir($storageLink)) {
        mkdir($storageLink, 0755, true);
        echo "   ✅ Storage directory created manually\n";
    } else {
        echo "   ✅ Storage directory already exists\n";
    }
}

// 5. Fix home sections data and images
echo "\n📊 Fixing home sections data and images...\n";

try {
    // Get all home sections
    $sections = DB::table('home_sections')->get();
    echo "   📊 Found " . count($sections) . " home sections\n";
    
    $fixed = 0;
    $imagesCopied = 0;
    $defaultImagesCreated = 0;
    
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
        
        // Fix other fields
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
        
        // Update database if needed
        if ($needsUpdate) {
            DB::table('home_sections')
                ->where('id', $section->id)
                ->update($updateData);
            echo "   ✅ Updated section in database\n";
            $fixed++;
        } else {
            echo "   ✅ Section data is correct\n";
        }
    }
    
    echo "\n   📊 Summary:\n";
    echo "   - Sections processed: " . count($sections) . "\n";
    echo "   - Sections updated: {$fixed}\n";
    echo "   - Images copied: {$imagesCopied}\n";
    
} catch (Exception $e) {
    echo "   ❌ Error processing home sections: " . $e->getMessage() . "\n";
}

// 6. Create default images
echo "\n🖼️  Creating default images...\n";

$defaultImages = [
    'public/images/default-section.png' => 'Default section image',
    'public/images/default-hero.png' => 'Default hero image',
    'public/images/default-teacher.png' => 'Default teacher image',
    'public/images/default-facility.png' => 'Default facility image',
    'public/images/default-logo.png' => 'Default logo image'
];

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
            $defaultImagesCreated++;
        } else {
            echo "   ❌ Failed to create: {$path}\n";
        }
        
        imagedestroy($image);
    } else {
        echo "   ✅ Already exists: {$path}\n";
    }
}

// 7. Ensure admin user exists
echo "\n👤 Ensuring admin user exists...\n";

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

// 8. Fix file permissions
echo "\n🔐 Fixing file permissions...\n";

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

// 9. Test image URLs
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
        echo "   ℹ️  No sections with images found for testing\n";
    }
} catch (Exception $e) {
    echo "   ❌ Error testing image URLs: " . $e->getMessage() . "\n";
}

// 10. Clear cache
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

echo "\n✅ Admin home sections fix completed!\n";
echo "🔧 Key improvements applied:\n";
echo "   - Fixed storage structure and permissions\n";
echo "   - Updated home sections data and images\n";
echo "   - Copied images from storage to public storage\n";
echo "   - Created default images for fallbacks\n";
echo "   - Ensured admin user exists\n";
echo "   - Cleared all caches\n";
echo "\n🌐 Test your admin panel:\n";
echo "   - Login: https://uji.odetune.shop/login\n";
echo "   - Admin Home Sections: https://uji.odetune.shop/admin/home-sections\n";
echo "   - Check if images appear in the admin panel\n";
echo "\n📱 Mobile testing:\n";
echo "   - Test admin access on mobile\n";
echo "   - Check image display on mobile\n";
echo "   - Verify form submissions work\n";
echo "\n🔑 Admin Login Credentials:\n";
echo "   - Email: admin@namrole.sch.id\n";
echo "   - Password: admin123\n";
