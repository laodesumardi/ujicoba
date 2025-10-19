<?php

echo "🧪 Testing Hosting Images\n";
echo "========================\n\n";

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

// 3. Test storage structure
echo "\n🔗 Testing storage structure...\n";

$storageTests = [
    'storage/app/public' => 'Storage app public',
    'storage/app/public/home-sections' => 'Home sections storage',
    'public/storage' => 'Public storage link',
    'public/storage/home-sections' => 'Home sections public',
    'public/images' => 'Public images'
];

foreach ($storageTests as $path => $description) {
    if (is_dir($path)) {
        echo "   ✅ {$description}: {$path}\n";
        
        // Check if directory is writable
        if (is_writable($path)) {
            echo "      ✅ Writable\n";
        } else {
            echo "      ❌ Not writable\n";
        }
        
        // Count files in directory
        $files = glob($path . '/*');
        $fileCount = count($files);
        echo "      📁 Files: {$fileCount}\n";
        
        if ($fileCount > 0) {
            echo "      📄 Sample files:\n";
            for ($i = 0; $i < min(3, $fileCount); $i++) {
                $fileName = basename($files[$i]);
                $fileSize = filesize($files[$i]);
                echo "         - {$fileName} ({$fileSize} bytes)\n";
            }
        }
    } else {
        echo "   ❌ {$description}: {$path} (missing)\n";
    }
}

// 4. Test home sections data
echo "\n📊 Testing home sections data...\n";

try {
    $sections = DB::table('home_sections')->get();
    echo "   📊 Total sections: " . count($sections) . "\n";
    
    $sectionsWithImages = 0;
    $sectionsWithoutImages = 0;
    $totalImages = 0;
    
    foreach ($sections as $section) {
        echo "   🔍 Section ID {$section->id}: {$section->title}\n";
        echo "      📝 Content: " . substr($section->content ?? '', 0, 50) . "...\n";
        echo "      🔗 Section Key: {$section->section_key}\n";
        echo "      ✅ Active: " . ($section->is_active ? 'Yes' : 'No') . "\n";
        
        if ($section->image) {
            echo "      🖼️  Image: {$section->image}\n";
            $sectionsWithImages++;
            
            // Test image paths
            $storagePath = storage_path('app/public/' . $section->image);
            $publicPath = public_path('storage/' . $section->image);
            
            if (file_exists($storagePath)) {
                echo "         ✅ Storage: {$storagePath}\n";
                $totalImages++;
            } else {
                echo "         ❌ Storage: {$storagePath} (missing)\n";
            }
            
            if (file_exists($publicPath)) {
                echo "         ✅ Public: {$publicPath}\n";
            } else {
                echo "         ❌ Public: {$publicPath} (missing)\n";
            }
            
            // Test image URL
            $imageUrl = asset('storage/' . $section->image);
            echo "         🌐 URL: {$imageUrl}\n";
            
        } else {
            echo "      🖼️  Image: None\n";
            $sectionsWithoutImages++;
        }
    }
    
    echo "\n   📊 Summary:\n";
    echo "   - Total sections: " . count($sections) . "\n";
    echo "   - Sections with images: {$sectionsWithImages}\n";
    echo "   - Sections without images: {$sectionsWithoutImages}\n";
    echo "   - Total images found: {$totalImages}\n";
    
} catch (Exception $e) {
    echo "   ❌ Error testing home sections: " . $e->getMessage() . "\n";
}

// 5. Test image URLs
echo "\n🌐 Testing image URLs...\n";

try {
    $testSection = DB::table('home_sections')->whereNotNull('image')->first();
    if ($testSection) {
        $imageUrl = asset('storage/' . $testSection->image);
        echo "   🔗 Test URL: {$imageUrl}\n";
        
        // Test URL accessibility
        $context = stream_context_create([
            'http' => [
                'timeout' => 10,
                'method' => 'HEAD',
                'user_agent' => 'Mozilla/5.0 (compatible; ImageTest/1.0)'
            ]
        ]);
        
        $headers = @get_headers($imageUrl, 1, $context);
        if ($headers) {
            $statusCode = $headers[0];
            echo "   📊 Status: {$statusCode}\n";
            
            if (strpos($statusCode, '200') !== false) {
                echo "   ✅ Image URL is accessible\n";
                
                // Get content type
                if (isset($headers['Content-Type'])) {
                    echo "   📄 Content-Type: {$headers['Content-Type']}\n";
                }
                
                // Get content length
                if (isset($headers['Content-Length'])) {
                    echo "   📏 Content-Length: {$headers['Content-Length']} bytes\n";
                }
            } else {
                echo "   ❌ Image URL is not accessible\n";
            }
        } else {
            echo "   ❌ Could not test URL accessibility\n";
        }
    } else {
        echo "   ℹ️  No sections with images found for testing\n";
    }
} catch (Exception $e) {
    echo "   ❌ Error testing image URLs: " . $e->getMessage() . "\n";
}

// 6. Test admin access
echo "\n🔐 Testing admin access...\n";

try {
    $adminUsers = DB::table('users')->where('role', 'admin')->get();
    echo "   📊 Admin users: " . count($adminUsers) . "\n";
    
    foreach ($adminUsers as $admin) {
        echo "   👤 Admin: {$admin->name}\n";
        echo "      📧 Email: {$admin->email}\n";
        echo "      📅 Created: {$admin->created_at}\n";
    }
    
    if (count($adminUsers) === 0) {
        echo "   ❌ No admin users found\n";
        echo "   🔧 You need to create an admin user to access the admin panel\n";
    }
    
} catch (Exception $e) {
    echo "   ❌ Error testing admin access: " . $e->getMessage() . "\n";
}

// 7. Test Laravel configuration
echo "\n⚙️  Testing Laravel configuration...\n";

$configTests = [
    'app.env' => 'Environment',
    'app.debug' => 'Debug mode',
    'session.lifetime' => 'Session lifetime',
    'session.secure' => 'Secure cookies',
    'session.same_site' => 'Same site cookies',
    'filesystems.disks.public.root' => 'Public disk root'
];

foreach ($configTests as $key => $description) {
    try {
        $value = config($key);
        echo "   ✅ {$description}: {$value}\n";
    } catch (Exception $e) {
        echo "   ❌ {$description}: Error reading config\n";
    }
}

// 8. Test file permissions
echo "\n🔐 Testing file permissions...\n";

$permissionTests = [
    'storage/app/public' => 'Storage app public',
    'storage/app/public/home-sections' => 'Home sections storage',
    'public/storage' => 'Public storage',
    'public/storage/home-sections' => 'Home sections public'
];

foreach ($permissionTests as $path => $description) {
    if (is_dir($path)) {
        $perms = fileperms($path);
        $permString = substr(sprintf('%o', $perms), -4);
        echo "   📁 {$description}: {$permString}\n";
        
        if (is_writable($path)) {
            echo "      ✅ Writable\n";
        } else {
            echo "      ❌ Not writable\n";
        }
    } else {
        echo "   ❌ {$description}: Directory not found\n";
    }
}

echo "\n✅ Hosting images test completed!\n";
echo "🔧 Test results summary:\n";
echo "   - Storage structure tested\n";
echo "   - Home sections data tested\n";
echo "   - Image URLs tested\n";
echo "   - Admin access tested\n";
echo "   - Laravel configuration tested\n";
echo "   - File permissions tested\n";
echo "\n🌐 Next steps:\n";
echo "   - Check any ❌ errors above\n";
echo "   - Run fix scripts if needed\n";
echo "   - Test admin panel access\n";
echo "   - Verify image uploads work\n";
