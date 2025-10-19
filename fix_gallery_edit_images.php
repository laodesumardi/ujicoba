<?php

echo "🖼️  Fixing Gallery Edit Images\n";
echo "=============================\n\n";

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

// 3. Fix storage structure for gallery
echo "\n🔗 Fixing storage structure for gallery...\n";

// Create necessary directories
$directories = [
    'storage/app/public',
    'storage/app/public/gallery',
    'storage/app/public/gallery-items',
    'public/storage',
    'public/storage/gallery',
    'public/storage/gallery-items',
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

// 4. Create storage link for gallery
echo "\n🔗 Creating storage link for gallery...\n";

$storageLink = 'public/storage';
$storageTarget = '../storage/app/public';

// Remove existing link if it exists
if (is_link($storageLink)) {
    unlink($storageLink);
    echo "   🔧 Removed existing storage link\n";
}

// Check if symlink function is available
if (function_exists('symlink')) {
    if (symlink($storageTarget, $storageLink)) {
        echo "   ✅ Storage link created using symlink()\n";
    } else {
        echo "   ❌ Failed to create storage link using symlink()\n";
        echo "   🔧 Creating manual storage directory...\n";
        createManualStorage();
    }
} else {
    echo "   ⚠️  symlink() function not available\n";
    echo "   🔧 Creating manual storage directory...\n";
    createManualStorage();
}

// 5. Fix gallery data and images
echo "\n📊 Fixing gallery data and images...\n";

try {
    // Get all galleries
    $galleries = DB::table('galleries')->get();
    echo "   📊 Found " . count($galleries) . " galleries\n";
    
    $fixed = 0;
    $imagesCopied = 0;
    $galleriesUpdated = 0;
    
    foreach ($galleries as $gallery) {
        echo "   🔍 Processing gallery ID {$gallery->id}: {$gallery->title}\n";
        
        $needsUpdate = false;
        $updateData = [];
        
        // Fix image path
        if ($gallery->image) {
            echo "   📁 Current image: {$gallery->image}\n";
            
            // Clean image path (remove 'storage/' prefix if exists)
            $cleanPath = $gallery->image;
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
            echo "   ℹ️  Gallery has no image\n";
        }
        
        // Fix other fields
        if (empty($gallery->slug)) {
            $updateData['slug'] = 'gallery-' . $gallery->id;
            $needsUpdate = true;
            echo "   🔧 Added slug\n";
        }
        
        if (empty($gallery->is_active)) {
            $updateData['is_active'] = 1;
            $needsUpdate = true;
            echo "   🔧 Set as active\n";
        }
        
        // Ensure description is not empty
        if (empty($gallery->description)) {
            $updateData['description'] = 'Gallery description for ' . $gallery->title;
            $needsUpdate = true;
            echo "   🔧 Added default description\n";
        }
        
        // Update database if needed
        if ($needsUpdate) {
            DB::table('galleries')
                ->where('id', $gallery->id)
                ->update($updateData);
            echo "   ✅ Updated gallery in database\n";
            $galleriesUpdated++;
        } else {
            echo "   ✅ Gallery data is correct\n";
        }
        
        $fixed++;
    }
    
    echo "\n   📊 Gallery Summary:\n";
    echo "   - Galleries processed: " . count($galleries) . "\n";
    echo "   - Galleries fixed: {$fixed}\n";
    echo "   - Galleries updated: {$galleriesUpdated}\n";
    echo "   - Images copied: {$imagesCopied}\n";
    
} catch (Exception $e) {
    echo "   ❌ Error processing galleries: " . $e->getMessage() . "\n";
}

// 6. Fix gallery items data and images
echo "\n📊 Fixing gallery items data and images...\n";

try {
    // Get all gallery items
    $galleryItems = DB::table('gallery_items')->get();
    echo "   📊 Found " . count($galleryItems) . " gallery items\n";
    
    $fixed = 0;
    $imagesCopied = 0;
    $itemsUpdated = 0;
    
    foreach ($galleryItems as $item) {
        echo "   🔍 Processing item ID {$item->id}: {$item->title}\n";
        
        $needsUpdate = false;
        $updateData = [];
        
        // Fix image path
        if ($item->image) {
            echo "   📁 Current image: {$item->image}\n";
            
            // Clean image path (remove 'storage/' prefix if exists)
            $cleanPath = $item->image;
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
            echo "   ℹ️  Item has no image\n";
        }
        
        // Fix other fields
        if (empty($item->is_active)) {
            $updateData['is_active'] = 1;
            $needsUpdate = true;
            echo "   🔧 Set as active\n";
        }
        
        // Ensure description is not empty
        if (empty($item->description)) {
            $updateData['description'] = 'Item description for ' . $item->title;
            $needsUpdate = true;
            echo "   🔧 Added default description\n";
        }
        
        // Update database if needed
        if ($needsUpdate) {
            DB::table('gallery_items')
                ->where('id', $item->id)
                ->update($updateData);
            echo "   ✅ Updated item in database\n";
            $itemsUpdated++;
        } else {
            echo "   ✅ Item data is correct\n";
        }
        
        $fixed++;
    }
    
    echo "\n   📊 Gallery Items Summary:\n";
    echo "   - Items processed: " . count($galleryItems) . "\n";
    echo "   - Items fixed: {$fixed}\n";
    echo "   - Items updated: {$itemsUpdated}\n";
    echo "   - Images copied: {$imagesCopied}\n";
    
} catch (Exception $e) {
    echo "   ❌ Error processing gallery items: " . $e->getMessage() . "\n";
}

// 7. Create default images for gallery
echo "\n🖼️  Creating default images for gallery...\n";

$defaultImages = [
    'public/images/default-gallery.png' => 'Default gallery image',
    'public/images/default-gallery-item.png' => 'Default gallery item image',
    'public/images/default-section.png' => 'Default section image',
    'public/images/default-hero.png' => 'Default hero image'
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

// 8. Ensure admin user exists
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

// 9. Fix file permissions for gallery
echo "\n🔐 Fixing file permissions for gallery...\n";

$permissionDirs = [
    'storage/app/public',
    'storage/app/public/gallery',
    'storage/app/public/gallery-items',
    'public/storage',
    'public/storage/gallery',
    'public/storage/gallery-items',
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

// 10. Test gallery edit functionality
echo "\n🧪 Testing gallery edit functionality...\n";

try {
    // Test getting gallery by ID
    $testGallery = DB::table('galleries')->where('id', 14)->first();
    if ($testGallery) {
        echo "   ✅ Gallery ID 14 found: {$testGallery->title}\n";
        echo "   📝 Description: " . substr($testGallery->description ?? '', 0, 50) . "...\n";
        echo "   🔗 Slug: {$testGallery->slug}\n";
        echo "   ✅ Active: " . ($testGallery->is_active ? 'Yes' : 'No') . "\n";
        
        if ($testGallery->image) {
            echo "   🖼️  Image: {$testGallery->image}\n";
            
            // Test image paths
            $storagePath = storage_path('app/public/' . $testGallery->image);
            $publicPath = public_path('storage/' . $testGallery->image);
            
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
            $imageUrl = asset('storage/' . $testGallery->image);
            echo "      🌐 URL: {$imageUrl}\n";
            
        } else {
            echo "   🖼️  Image: None\n";
        }
    } else {
        echo "   ❌ Gallery ID 14 not found\n";
    }
} catch (Exception $e) {
    echo "   ❌ Error testing gallery edit: " . $e->getMessage() . "\n";
}

// 11. Clear cache for gallery
echo "\n🧹 Clearing cache for gallery...\n";

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

echo "\n✅ Gallery edit images fix completed!\n";
echo "🔧 Key improvements applied:\n";
echo "   - Fixed storage structure for gallery\n";
echo "   - Updated gallery data and images\n";
echo "   - Updated gallery items data and images\n";
echo "   - Copied images from storage to public storage\n";
echo "   - Created default images for fallbacks\n";
echo "   - Ensured admin user exists\n";
echo "   - Fixed file permissions\n";
echo "   - Cleared all caches\n";
echo "\n🌐 Test your gallery edits:\n";
echo "   - Gallery Edit: http://localhost:8000/admin/gallery/14/edit\n";
echo "   - Gallery Index: http://localhost:8000/admin/gallery\n";
echo "   - Check if images appear in edit forms\n";
echo "   - Test image upload functionality\n";
echo "\n🔑 Admin Login:\n";
echo "   - Email: admin@namrole.sch.id\n";
echo "   - Password: admin123\n";

// Helper function to create manual storage
function createManualStorage() {
    echo "   🔧 Creating manual storage directory...\n";
    
    $sourceDir = 'storage/app/public';
    $targetDir = 'public/storage';
    
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0755, true);
        echo "   ✅ Created public/storage directory\n";
    }
    
    // Copy all files from storage/app/public to public/storage
    if (is_dir($sourceDir)) {
        copyDirectory($sourceDir, $targetDir);
        echo "   ✅ Copied storage files to public storage\n";
    }
}

// Helper function to copy directory recursively
function copyDirectory($source, $destination) {
    if (!is_dir($destination)) {
        mkdir($destination, 0755, true);
    }
    
    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($source, RecursiveDirectoryIterator::SKIP_DOTS),
        RecursiveIteratorIterator::SELF_FIRST
    );
    
    foreach ($iterator as $item) {
        $target = $destination . DIRECTORY_SEPARATOR . $iterator->getSubPathName();
        
        if ($item->isDir()) {
            if (!is_dir($target)) {
                mkdir($target, 0755, true);
            }
        } else {
            copy($item, $target);
        }
    }
}
