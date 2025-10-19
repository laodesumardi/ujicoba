<?php

echo "🔐 Testing Admin Access for Hosting\n";
echo "===================================\n\n";

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

// 3. Test database connection
echo "\n🗄️  Testing database connection...\n";
try {
    $connection = DB::connection()->getPdo();
    echo "   ✅ Database connection successful\n";
} catch (Exception $e) {
    echo "   ❌ Database connection failed: " . $e->getMessage() . "\n";
    exit(1);
}

// 4. Test admin users
echo "\n👤 Testing admin users...\n";
try {
    $adminUsers = DB::table('users')->where('role', 'admin')->get();
    echo "   📊 Found " . count($adminUsers) . " admin users\n";
    
    if (count($adminUsers) > 0) {
        foreach ($adminUsers as $admin) {
            echo "   👤 Admin: {$admin->name}\n";
            echo "      📧 Email: {$admin->email}\n";
            echo "      📅 Created: {$admin->created_at}\n";
            echo "      🔑 Password: [HIDDEN]\n";
        }
    } else {
        echo "   ❌ No admin users found\n";
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
    echo "   ❌ Error testing admin users: " . $e->getMessage() . "\n";
}

// 5. Test home sections
echo "\n🏠 Testing home sections...\n";
try {
    $sections = DB::table('home_sections')->get();
    echo "   📊 Found " . count($sections) . " home sections\n";
    
    $sectionsWithImages = 0;
    $sectionsWithoutImages = 0;
    
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
    
} catch (Exception $e) {
    echo "   ❌ Error testing home sections: " . $e->getMessage() . "\n";
}

// 6. Test storage structure
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

// 7. Test Laravel configuration
echo "\n⚙️  Testing Laravel configuration...\n";

$configTests = [
    'app.env' => 'Environment',
    'app.debug' => 'Debug mode',
    'app.url' => 'App URL',
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

// 8. Test routes
echo "\n🛣️  Testing routes...\n";

try {
    $routes = [
        'admin.home-sections.index' => 'Admin Home Sections',
        'admin.home-sections.create' => 'Admin Home Sections Create',
        'admin.home-sections.edit' => 'Admin Home Sections Edit',
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

// 9. Test file permissions
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

echo "\n✅ Admin access test completed!\n";
echo "🔧 Test results summary:\n";
echo "   - Database connection tested\n";
echo "   - Admin users tested\n";
echo "   - Home sections tested\n";
echo "   - Storage structure tested\n";
echo "   - Laravel configuration tested\n";
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
