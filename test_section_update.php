<?php

echo "🧪 Testing Section Update Functionality\n";
echo "=====================================\n\n";

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

// 3. Test section data
echo "\n📊 Testing section data...\n";

try {
    $sections = DB::table('home_sections')->get();
    echo "   📊 Found " . count($sections) . " home sections\n";
    
    $sectionsWithImages = 0;
    $sectionsWithoutImages = 0;
    $sectionsWithContent = 0;
    $sectionsWithoutContent = 0;
    
    foreach ($sections as $section) {
        echo "   🔍 Section ID {$section->id}: {$section->title}\n";
        echo "      📝 Content: " . (empty($section->content) ? 'Empty' : substr($section->content, 0, 50) . '...') . "\n";
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
        
        if (!empty($section->content)) {
            $sectionsWithContent++;
        } else {
            $sectionsWithoutContent++;
        }
    }
    
    echo "\n   📊 Summary:\n";
    echo "   - Total sections: " . count($sections) . "\n";
    echo "   - Sections with images: {$sectionsWithImages}\n";
    echo "   - Sections without images: {$sectionsWithoutImages}\n";
    echo "   - Sections with content: {$sectionsWithContent}\n";
    echo "   - Sections without content: {$sectionsWithoutContent}\n";
    
} catch (Exception $e) {
    echo "   ❌ Error testing sections: " . $e->getMessage() . "\n";
}

// 4. Test specific section for updates
echo "\n🔍 Testing specific section for updates...\n";

try {
    $sectionId = 1;
    $section = DB::table('home_sections')->where('id', $sectionId)->first();
    
    if ($section) {
        echo "   ✅ Section ID {$sectionId} found: {$section->title}\n";
        echo "   📝 Content: " . (empty($section->content) ? 'Empty' : substr($section->content, 0, 100) . '...') . "\n";
        echo "   🔗 Section Key: {$section->section_key}\n";
        echo "   ✅ Active: " . ($section->is_active ? 'Yes' : 'No') . "\n";
        
        if ($section->image) {
            echo "   🖼️  Image: {$section->image}\n";
            
            // Test image paths
            $storagePath = storage_path('app/public/' . $section->image);
            $publicPath = public_path('storage/' . $section->image);
            
            if (file_exists($storagePath)) {
                echo "      ✅ Storage: {$storagePath}\n";
                $fileSize = filesize($storagePath);
                echo "      📏 File size: {$fileSize} bytes\n";
            } else {
                echo "      ❌ Storage: {$storagePath} (missing)\n";
            }
            
            if (file_exists($publicPath)) {
                echo "      ✅ Public: {$publicPath}\n";
                $fileSize = filesize($publicPath);
                echo "      📏 File size: {$fileSize} bytes\n";
            } else {
                echo "      ❌ Public: {$publicPath} (missing)\n";
            }
            
            // Test image URL
            $imageUrl = asset('storage/' . $section->image);
            echo "      🌐 URL: {$imageUrl}\n";
            
            // Test URL accessibility
            $context = stream_context_create([
                'http' => [
                    'timeout' => 5,
                    'method' => 'HEAD'
                ]
            ]);
            
            $headers = @get_headers($imageUrl, 1, $context);
            if ($headers && strpos($headers[0], '200') !== false) {
                echo "      ✅ Image URL is accessible\n";
            } else {
                echo "      ❌ Image URL is not accessible\n";
            }
            
        } else {
            echo "   🖼️  Image: None\n";
        }
    } else {
        echo "   ❌ Section ID {$sectionId} not found\n";
    }
} catch (Exception $e) {
    echo "   ❌ Error testing specific section: " . $e->getMessage() . "\n";
}

// 5. Test storage structure
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

// 6. Test admin access
echo "\n👤 Testing admin access...\n";

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

// 7. Test routes
echo "\n🛣️  Testing routes...\n";

try {
    $routes = [
        'admin.home-sections.index' => 'Admin Home Sections Index',
        'admin.home-sections.create' => 'Admin Home Sections Create',
        'admin.home-sections.edit' => 'Admin Home Sections Edit',
        'admin.home-sections.update' => 'Admin Home Sections Update',
        'login' => 'Login',
        'admin.dashboard' => 'Admin Dashboard'
    ];
    
    foreach ($routes as $route => $description) {
        try {
            $url = route($route);
            echo "   ✅ {$description}: {$url}\n";
        } catch (Exception $e) {
            echo "   ❌ {$description}: Route not found\n";
        }
    }
} catch (Exception $e) {
    echo "   ❌ Error testing routes: " . $e->getMessage() . "\n";
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

echo "\n✅ Section update test completed!\n";
echo "🔧 Test results summary:\n";
echo "   - Section data tested\n";
echo "   - Specific section tested\n";
echo "   - Storage structure tested\n";
echo "   - Admin access tested\n";
echo "   - Routes tested\n";
echo "   - File permissions tested\n";
echo "\n🌐 Next steps:\n";
echo "   - Check any ❌ errors above\n";
echo "   - Run fix scripts if needed\n";
echo "   - Test admin panel access\n";
echo "   - Verify image uploads work\n";
echo "\n🔑 Admin Login:\n";
echo "   - URL: https://uji.odetune.shop/login\n";
echo "   - Email: admin@namrole.sch.id\n";
echo "   - Password: admin123\n";
echo "\n🌐 Test URLs:\n";
echo "   - Edit Section: https://uji.odetune.shop/admin/home-sections/1/edit\n";
echo "   - Admin Home Sections: https://uji.odetune.shop/admin/home-sections\n";
