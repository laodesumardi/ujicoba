<?php

echo "⚡ Quick Admin Fix for Hosting\n";
echo "==============================\n\n";

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

// 3. Quick fixes
echo "\n🔧 Applying quick fixes...\n";

// Create storage directories
$directories = [
    'storage/app/public/home-sections',
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
    }
}

// Create storage link
$storageLink = 'public/storage';
if (!is_link($storageLink)) {
    if (symlink('../storage/app/public', $storageLink)) {
        echo "   ✅ Storage link created\n";
    } else {
        if (!is_dir($storageLink)) {
            mkdir($storageLink, 0755, true);
            echo "   ✅ Storage directory created manually\n";
        }
    }
}

// 4. Fix home sections images
echo "\n🖼️  Fixing home sections images...\n";

try {
    $sections = DB::table('home_sections')->get();
    echo "   📊 Found " . count($sections) . " home sections\n";
    
    $fixed = 0;
    foreach ($sections as $section) {
        if ($section->image) {
            $storagePath = storage_path('app/public/' . $section->image);
            $publicPath = public_path('storage/' . $section->image);
            
            if (file_exists($storagePath) && !file_exists($publicPath)) {
                $publicDir = dirname($publicPath);
                if (!is_dir($publicDir)) {
                    mkdir($publicDir, 0755, true);
                }
                
                if (copy($storagePath, $publicPath)) {
                    echo "   ✅ Copied image for section: {$section->title}\n";
                    $fixed++;
                }
            }
        }
    }
    
    echo "   📊 Images fixed: {$fixed}\n";
} catch (Exception $e) {
    echo "   ❌ Error fixing images: " . $e->getMessage() . "\n";
}

// 5. Ensure admin user exists
echo "\n👤 Ensuring admin user exists...\n";

try {
    $adminUser = DB::table('users')->where('role', 'admin')->first();
    if (!$adminUser) {
        DB::table('users')->insert([
            'name' => 'Administrator',
            'email' => 'admin@namrole.sch.id',
            'password' => bcrypt('admin123'),
            'role' => 'admin',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        echo "   ✅ Admin user created\n";
    } else {
        echo "   ✅ Admin user exists\n";
    }
} catch (Exception $e) {
    echo "   ❌ Error with admin user: " . $e->getMessage() . "\n";
}

// 6. Clear cache
echo "\n🧹 Clearing cache...\n";

try {
    if (file_exists('bootstrap/cache/config.php')) {
        unlink('bootstrap/cache/config.php');
    }
    if (file_exists('bootstrap/cache/routes.php')) {
        unlink('bootstrap/cache/routes.php');
    }
    
    $viewCachePath = 'storage/framework/views';
    if (is_dir($viewCachePath)) {
        $files = glob($viewCachePath . '/*');
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }
    }
    
    echo "   ✅ Cache cleared\n";
} catch (Exception $e) {
    echo "   ❌ Error clearing cache: " . $e->getMessage() . "\n";
}

echo "\n✅ Quick admin fix completed!\n";
echo "🔧 Key improvements applied:\n";
echo "   - Created storage directories\n";
echo "   - Fixed home sections images\n";
echo "   - Ensured admin user exists\n";
echo "   - Cleared cache\n";
echo "\n🌐 Test your admin panel:\n";
echo "   - Login: https://uji.odetune.shop/login\n";
echo "   - Admin: https://uji.odetune.shop/admin/home-sections\n";
echo "\n🔑 Admin Login:\n";
echo "   - Email: admin@namrole.sch.id\n";
echo "   - Password: admin123\n";
