<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "🔍 Diagnosis Error 419 Mobile for Hosting...\n\n";

// 1. Check session configuration for hosting
echo "📊 Checking session configuration for hosting...\n";
$sessionDriver = config('session.driver');
$sessionLifetime = config('session.lifetime');
$sessionExpireOnClose = config('session.expire_on_close');
$sessionSecure = config('session.secure');
$sessionHttpOnly = config('session.http_only');
$sessionSameSite = config('session.same_site');
$sessionCookie = config('session.cookie');
$sessionPath = config('session.path');
$sessionDomain = config('session.domain');

echo "   Session Driver: {$sessionDriver}\n";
echo "   Session Lifetime: {$sessionLifetime} minutes\n";
echo "   Expire On Close: " . ($sessionExpireOnClose ? 'Yes' : 'No') . "\n";
echo "   Secure Cookie: " . ($sessionSecure ? 'Yes' : 'No') . "\n";
echo "   HTTP Only: " . ($sessionHttpOnly ? 'Yes' : 'No') . "\n";
echo "   Same Site: {$sessionSameSite}\n";
echo "   Cookie Name: {$sessionCookie}\n";
echo "   Cookie Path: {$sessionPath}\n";
echo "   Cookie Domain: " . ($sessionDomain ?: 'null') . "\n";

// 2. Check CSRF configuration for hosting
echo "\n🔒 Checking CSRF configuration for hosting...\n";
$csrfMiddleware = app('Illuminate\Session\Middleware\StartSession');
echo "   CSRF Middleware: " . (class_exists('Illuminate\Session\Middleware\StartSession') ? 'Available' : 'Not Available') . "\n";

// 3. Check environment variables for hosting
echo "\n🌍 Checking environment variables for hosting...\n";
$appEnv = env('APP_ENV');
$appDebug = env('APP_DEBUG');
$appUrl = env('APP_URL');
$sessionDriver = env('SESSION_DRIVER');
$sessionLifetime = env('SESSION_LIFETIME');
$sessionSecure = env('SESSION_SECURE_COOKIE');
$sessionDomain = env('SESSION_DOMAIN');

echo "   APP_ENV: {$appEnv}\n";
echo "   APP_DEBUG: " . ($appDebug ? 'Yes' : 'No') . "\n";
echo "   APP_URL: {$appUrl}\n";
echo "   SESSION_DRIVER: {$sessionDriver}\n";
echo "   SESSION_LIFETIME: {$sessionLifetime}\n";
echo "   SESSION_SECURE_COOKIE: " . ($sessionSecure ? 'Yes' : 'No') . "\n";
echo "   SESSION_DOMAIN: " . ($sessionDomain ?: 'null') . "\n";

// 4. Check routes that might cause 419 for hosting
echo "\n🛣️  Checking routes that might cause 419 for hosting...\n";
$routes = [
    'ppdb.store' => 'PPDB Registration for hosting',
    'contact.store' => 'Contact Form for hosting',
    'login' => 'Login for hosting',
    'register' => 'Register for hosting',
    'ppdb.refresh-token' => 'CSRF Refresh for hosting',
    'ppdb.auto-refresh' => 'Auto Refresh for hosting'
];

foreach ($routes as $route => $description) {
    try {
        $url = route($route);
        echo "   ✅ {$description}: {$url}\n";
    } catch (Exception $e) {
        echo "   ❌ {$description}: Route not found\n";
    }
}

// 5. Check middleware groups for hosting
echo "\n🛡️  Checking middleware groups for hosting...\n";
$middlewareGroups = config('app.middleware_groups');
if (isset($middlewareGroups['web'])) {
    echo "   Web middleware: " . implode(', ', $middlewareGroups['web']) . "\n";
} else {
    echo "   ❌ Web middleware not found for hosting\n";
}

// 6. Check session storage for hosting
echo "\n💾 Checking session storage for hosting...\n";
$sessionPath = storage_path('framework/sessions');
if (is_dir($sessionPath)) {
    echo "   ✅ Session directory exists for hosting: {$sessionPath}\n";
    $files = scandir($sessionPath);
    $sessionFiles = array_filter($files, function($file) {
        return $file !== '.' && $file !== '..' && strpos($file, 'sess_') === 0;
    });
    echo "   Session files: " . count($sessionFiles) . "\n";
} else {
    echo "   ❌ Session directory not found for hosting\n";
}

// 7. Check database sessions for hosting
echo "\n🗄️  Checking database sessions for hosting...\n";
try {
    $sessions = DB::table('sessions')->count();
    echo "   ✅ Sessions table accessible for hosting\n";
    echo "   Active sessions: {$sessions}\n";
} catch (Exception $e) {
    echo "   ❌ Sessions table error for hosting: " . $e->getMessage() . "\n";
}

// 8. Check mobile-specific issues for hosting
echo "\n📱 Checking mobile-specific issues for hosting...\n";
echo "   User Agent Detection: " . (class_exists('Jenssegers\Agent\Agent') ? 'Available' : 'Not Available') . "\n";

// 9. Check CSRF token generation for hosting
echo "\n🔑 Testing CSRF token generation for hosting...\n";
try {
    $token = csrf_token();
    echo "   ✅ CSRF token generated for hosting: " . substr($token, 0, 10) . "...\n";
} catch (Exception $e) {
    echo "   ❌ CSRF token generation failed for hosting: " . $e->getMessage() . "\n";
}

// 10. Check form CSRF implementation for hosting
echo "\n📝 Checking form CSRF implementation for hosting...\n";
$ppdbView = resource_path('views/ppdb/register.blade.php');
if (file_exists($ppdbView)) {
    $content = file_get_contents($ppdbView);
    
    if (strpos($content, '@csrf') !== false) {
        echo "   ✅ PPDB form has @csrf directive for hosting\n";
    } else {
        echo "   ❌ PPDB form missing @csrf directive for hosting\n";
    }
    
    if (strpos($content, 'csrf_token()') !== false) {
        echo "   ✅ PPDB form has csrf_token() function for hosting\n";
    } else {
        echo "   ❌ PPDB form missing csrf_token() function for hosting\n";
    }
    
    if (strpos($content, 'refreshCSRFToken') !== false) {
        echo "   ✅ PPDB form has CSRF refresh function for hosting\n";
    } else {
        echo "   ❌ PPDB form missing CSRF refresh function for hosting\n";
    }
    
    if (strpos($content, 'hosting') !== false) {
        echo "   ✅ PPDB form has hosting-specific features\n";
    } else {
        echo "   ❌ PPDB form missing hosting-specific features\n";
    }
} else {
    echo "   ❌ PPDB form not found for hosting\n";
}

// 11. Check mobile CSS for hosting
echo "\n🎨 Checking mobile CSS for hosting...\n";
$mobileCSSPath = public_path('css/mobile-419-fix.css');
if (file_exists($mobileCSSPath)) {
    echo "   ✅ Mobile CSS file exists for hosting\n";
    
    $cssContent = file_get_contents($mobileCSSPath);
    if (strpos($cssContent, 'Mobile 419 Error Fix CSS for Hosting') !== false) {
        echo "   ✅ Mobile CSS has hosting-specific styles\n";
    } else {
        echo "   ❌ Mobile CSS missing hosting-specific styles\n";
    }
} else {
    echo "   ❌ Mobile CSS file not found for hosting\n";
}

// 12. Check .htaccess rules for hosting
echo "\n🔧 Checking .htaccess rules for hosting...\n";
$htaccessPath = public_path('.htaccess');
if (file_exists($htaccessPath)) {
    $htaccessContent = file_get_contents($htaccessPath);
    
    if (strpos($htaccessContent, 'Mobile 419 Error Fix Rules') !== false) {
        echo "   ✅ .htaccess has mobile 419 fix rules for hosting\n";
    } else {
        echo "   ❌ .htaccess missing mobile 419 fix rules for hosting\n";
    }
    
    if (strpos($htaccessContent, 'Access-Control-Allow-Origin') !== false) {
        echo "   ✅ .htaccess has CORS headers for mobile hosting\n";
    } else {
        echo "   ❌ .htaccess missing CORS headers for mobile hosting\n";
    }
} else {
    echo "   ❌ .htaccess file not found for hosting\n";
}

// 13. Check hosting environment
echo "\n🌐 Checking hosting environment...\n";
$isHttps = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on';
$serverName = $_SERVER['SERVER_NAME'] ?? 'unknown';
$serverPort = $_SERVER['SERVER_PORT'] ?? 'unknown';
$requestScheme = $_SERVER['REQUEST_SCHEME'] ?? 'unknown';

echo "   HTTPS: " . ($isHttps ? 'Yes' : 'No') . "\n";
echo "   Server Name: {$serverName}\n";
echo "   Server Port: {$serverPort}\n";
echo "   Request Scheme: {$requestScheme}\n";

if ($isHttps) {
    echo "   ✅ HTTPS enabled for hosting\n";
} else {
    echo "   ⚠️  HTTPS not enabled (may cause issues with secure cookies)\n";
}

// 14. Check mobile user agent detection for hosting
echo "\n📱 Testing mobile user agent detection for hosting...\n";
$mobileUserAgents = [
    'Mozilla/5.0 (iPhone; CPU iPhone OS 14_0 like Mac OS X) AppleWebKit/605.1.15',
    'Mozilla/5.0 (Linux; Android 10; SM-G973F) AppleWebKit/537.36',
    'Mozilla/5.0 (iPad; CPU OS 14_0 like Mac OS X) AppleWebKit/605.1.15',
    'Mozilla/5.0 (Windows Phone 10.0; Android 4.2.1; Microsoft; Lumia 950) AppleWebKit/537.36'
];

foreach ($mobileUserAgents as $userAgent) {
    $isMobile = false;
    $mobileKeywords = [
        'Mobile', 'Android', 'iPhone', 'iPad', 'iPod', 
        'BlackBerry', 'Windows Phone', 'Opera Mini', 'IEMobile'
    ];
    
    foreach ($mobileKeywords as $keyword) {
        if (stripos($userAgent, $keyword) !== false) {
            $isMobile = true;
            break;
        }
    }
    
    if ($isMobile) {
        echo "   ✅ Mobile user agent detected for hosting: " . substr($userAgent, 0, 50) . "...\n";
    } else {
        echo "   ❌ Mobile user agent not detected for hosting: " . substr($userAgent, 0, 50) . "...\n";
    }
}

echo "\n✅ Mobile 419 diagnosis for hosting completed!\n";
echo "🔧 Common fixes for mobile 419 errors on hosting:\n";
echo "   1. Set SESSION_SECURE_COOKIE=false for HTTP hosting\n";
echo "   2. Set SESSION_SAME_SITE=lax for mobile compatibility\n";
echo "   3. Increase SESSION_LIFETIME for longer sessions\n";
echo "   4. Ensure proper CSRF token refresh mechanism\n";
echo "   5. Check mobile browser cookie settings\n";
echo "   6. Add mobile-specific .htaccess rules\n";
echo "   7. Set production environment\n";
echo "   8. Disable debug mode for hosting\n";
echo "\n📱 Mobile hosting testing tips:\n";
echo "   - Test on actual mobile devices\n";
echo "   - Check browser developer tools mobile mode\n";
echo "   - Verify CSRF token refresh works\n";
echo "   - Check session persistence across page reloads\n";
echo "   - Test on different mobile browsers\n";
echo "   - Monitor server logs for mobile requests\n";
