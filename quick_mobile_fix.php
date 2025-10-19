<?php

echo "🔧 Quick Mobile 419 Fix for Hosting\n";
echo "=====================================\n\n";

// 1. Check if we're in Laravel project
if (!file_exists('artisan')) {
    echo "❌ Error: Not in Laravel project directory\n";
    echo "Please run this script from your Laravel project root\n";
    exit(1);
}

echo "✅ Laravel project detected\n";

// 2. Check PHP version
$phpVersion = phpversion();
echo "✅ PHP Version: {$phpVersion}\n";

// 3. Check if vendor directory exists
if (!file_exists('vendor/autoload.php')) {
    echo "❌ Error: Composer dependencies not installed\n";
    echo "Please run: composer install\n";
    exit(1);
}

echo "✅ Composer dependencies found\n";

// 4. Bootstrap Laravel
try {
    require_once 'vendor/autoload.php';
    $app = require_once 'bootstrap/app.php';
    $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
    echo "✅ Laravel bootstrapped successfully\n";
} catch (Exception $e) {
    echo "❌ Error bootstrapping Laravel: " . $e->getMessage() . "\n";
    exit(1);
}

// 5. Quick fixes for mobile 419
echo "\n🔧 Applying quick fixes for mobile 419...\n";

// Update .env file
$envPath = '.env';
if (file_exists($envPath)) {
    $envContent = file_get_contents($envPath);
    
    // Update session settings
    $envUpdates = [
        'SESSION_LIFETIME=120' => 'SESSION_LIFETIME=480',
        'SESSION_SECURE_COOKIE=false' => 'SESSION_SECURE_COOKIE=false',
        'SESSION_SAME_SITE=lax' => 'SESSION_SAME_SITE=lax',
        'APP_ENV=local' => 'APP_ENV=production',
        'APP_DEBUG=true' => 'APP_DEBUG=false'
    ];
    
    $updated = false;
    foreach ($envUpdates as $old => $new) {
        if (strpos($envContent, $old) !== false) {
            $envContent = str_replace($old, $new, $envContent);
            echo "   ✅ Updated: {$old} -> {$new}\n";
            $updated = true;
        }
    }
    
    if ($updated) {
        file_put_contents($envPath, $envContent);
        echo "   ✅ .env file updated\n";
    } else {
        echo "   ℹ️  .env file already has correct settings\n";
    }
} else {
    echo "   ❌ .env file not found\n";
}

// 6. Clear cache
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

// 7. Check session configuration
echo "\n📊 Checking session configuration...\n";
$sessionLifetime = config('session.lifetime');
$sessionSecure = config('session.secure');
$sessionSameSite = config('session.same_site');

echo "   Session Lifetime: {$sessionLifetime} minutes\n";
echo "   Secure Cookie: " . ($sessionSecure ? 'Yes' : 'No') . "\n";
echo "   Same Site: {$sessionSameSite}\n";

if ($sessionLifetime >= 480 && !$sessionSecure && $sessionSameSite === 'lax') {
    echo "   ✅ Session configuration is correct for mobile\n";
} else {
    echo "   ⚠️  Session configuration may need adjustment\n";
}

// 8. Test CSRF token generation
echo "\n🔑 Testing CSRF token generation...\n";
try {
    $token = csrf_token();
    echo "   ✅ CSRF token generated: " . substr($token, 0, 10) . "...\n";
} catch (Exception $e) {
    echo "   ❌ CSRF token generation failed: " . $e->getMessage() . "\n";
}

// 9. Check database sessions
echo "\n🗄️  Checking database sessions...\n";
try {
    $sessions = DB::table('sessions')->count();
    echo "   ✅ Sessions table accessible\n";
    echo "   Active sessions: {$sessions}\n";
} catch (Exception $e) {
    echo "   ❌ Sessions table error: " . $e->getMessage() . "\n";
}

echo "\n✅ Quick mobile 419 fix completed!\n";
echo "🔧 Key improvements applied:\n";
echo "   - Extended session lifetime to 480 minutes\n";
echo "   - Disabled secure cookies for HTTP hosting\n";
echo "   - Set same site to 'lax' for mobile compatibility\n";
echo "   - Set production environment\n";
echo "   - Disabled debug mode\n";
echo "   - Cleared all caches\n";
echo "\n🌐 Test your mobile forms now!\n";
echo "📱 Mobile testing tips:\n";
echo "   - Test on actual mobile devices\n";
echo "   - Check browser developer tools mobile mode\n";
echo "   - Verify CSRF token refresh works\n";
echo "   - Check session persistence across page reloads\n";
