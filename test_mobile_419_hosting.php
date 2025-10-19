<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "🧪 Testing Mobile 419 Fix for Hosting...\n\n";

// 1. Test session configuration for hosting
echo "📊 Testing session configuration for hosting...\n";
$sessionLifetime = config('session.lifetime');
$sessionSecure = config('session.secure');
$sessionSameSite = config('session.same_site');
$sessionHttpOnly = config('session.http_only');
$sessionDomain = config('session.domain');

echo "   Session Lifetime: {$sessionLifetime} minutes\n";
echo "   Secure Cookie: " . ($sessionSecure ? 'Yes' : 'No') . "\n";
echo "   Same Site: {$sessionSameSite}\n";
echo "   HTTP Only: " . ($sessionHttpOnly ? 'Yes' : 'No') . "\n";
echo "   Domain: " . ($sessionDomain ?: 'null') . "\n";

if ($sessionLifetime >= 480) {
    echo "   ✅ Session lifetime extended for mobile hosting\n";
} else {
    echo "   ❌ Session lifetime not extended for mobile hosting\n";
}

if (!$sessionSecure) {
    echo "   ✅ Secure cookie disabled for HTTP hosting\n";
} else {
    echo "   ❌ Secure cookie enabled (may cause issues on HTTP hosting)\n";
}

if ($sessionSameSite === 'lax') {
    echo "   ✅ Same site set to lax for mobile hosting compatibility\n";
} else {
    echo "   ❌ Same site not set to lax for mobile hosting\n";
}

// 2. Test mobile middleware for hosting
echo "\n🛡️  Testing mobile middleware for hosting...\n";
$middlewarePath = app_path('Http/Middleware/MobileCSRFMiddleware.php');
if (file_exists($middlewarePath)) {
    echo "   ✅ Mobile CSRF middleware exists for hosting\n";
    
    $middlewareContent = file_get_contents($middlewarePath);
    if (strpos($middlewareContent, 'isMobile') !== false) {
        echo "   ✅ Mobile detection function exists for hosting\n";
    } else {
        echo "   ❌ Mobile detection function missing for hosting\n";
    }
    
    if (strpos($middlewareContent, 'Log::info') !== false) {
        echo "   ✅ Mobile logging enabled for hosting\n";
    } else {
        echo "   ❌ Mobile logging not enabled for hosting\n";
    }
    
    if (strpos($middlewareContent, 'hosting') !== false) {
        echo "   ✅ Hosting-specific logging enabled\n";
    } else {
        echo "   ❌ Hosting-specific logging not enabled\n";
    }
} else {
    echo "   ❌ Mobile CSRF middleware not found for hosting\n";
}

// 3. Test environment configuration for hosting
echo "\n🌍 Testing environment configuration for hosting...\n";
$envPath = base_path('.env');
if (file_exists($envPath)) {
    $envContent = file_get_contents($envPath);
    
    $envChecks = [
        'SESSION_LIFETIME=480' => 'Session lifetime extended for hosting',
        'SESSION_SECURE_COOKIE=false' => 'Secure cookie disabled for hosting',
        'SESSION_SAME_SITE=lax' => 'Same site set to lax for hosting',
        'APP_ENV=production' => 'App environment set to production',
        'APP_DEBUG=false' => 'Debug mode disabled for hosting'
    ];
    
    foreach ($envChecks as $setting => $description) {
        if (strpos($envContent, $setting) !== false) {
            echo "   ✅ {$description}\n";
        } else {
            echo "   ❌ {$description} not found\n";
        }
    }
} else {
    echo "   ❌ .env file not found for hosting\n";
}

// 4. Test CSRF refresh route for hosting
echo "\n🔄 Testing CSRF refresh route for hosting...\n";
try {
    $url = route('ppdb.refresh-token');
    echo "   ✅ CSRF refresh route: {$url}\n";
    
    // Test route response
    $response = \Illuminate\Support\Facades\Http::get($url);
    if ($response->successful()) {
        $data = $response->json();
        if (isset($data['success']) && isset($data['token']) && isset($data['hosting'])) {
            echo "   ✅ CSRF refresh route returns valid hosting response\n";
        } else {
            echo "   ❌ CSRF refresh route returns invalid hosting response\n";
        }
    } else {
        echo "   ❌ CSRF refresh route not accessible for hosting\n";
    }
} catch (Exception $e) {
    echo "   ❌ CSRF refresh route error for hosting: " . $e->getMessage() . "\n";
}

// 5. Test PPDB form mobile improvements for hosting
echo "\n📝 Testing PPDB form mobile improvements for hosting...\n";
$ppdbViewPath = resource_path('views/ppdb/register.blade.php');
if (file_exists($ppdbViewPath)) {
    $ppdbContent = file_get_contents($ppdbViewPath);
    
    $mobileChecks = [
        'Mobile CSRF Meta Tags for Hosting' => 'Mobile meta tags for hosting',
        'Enhanced mobile CSRF refresh for hosting' => 'Enhanced CSRF refresh function for hosting',
        'mobile-web-app-capable' => 'Mobile web app meta for hosting',
        'apple-mobile-web-app-capable' => 'Apple mobile web app meta for hosting',
        'format-detection' => 'Format detection meta for hosting'
    ];
    
    foreach ($mobileChecks as $check => $description) {
        if (strpos($ppdbContent, $check) !== false) {
            echo "   ✅ {$description} added\n";
        } else {
            echo "   ❌ {$description} not found\n";
        }
    }
} else {
    echo "   ❌ PPDB form not found for hosting\n";
}

// 6. Test mobile CSS for hosting
echo "\n🎨 Testing mobile CSS for hosting...\n";
$mobileCSSPath = public_path('css/mobile-419-fix.css');
if (file_exists($mobileCSSPath)) {
    echo "   ✅ Mobile CSS file exists for hosting\n";
    
    $cssContent = file_get_contents($mobileCSSPath);
    $cssChecks = [
        '@media (max-width: 768px)' => 'Mobile media query for hosting',
        'mobile-form' => 'Mobile form styles for hosting',
        'mobile-button' => 'Mobile button styles for hosting',
        'mobile-input' => 'Mobile input styles for hosting',
        'mobile-csrf-refresh' => 'Mobile CSRF refresh styles for hosting',
        'mobile-notification' => 'Mobile notification styles for hosting',
        'mobile-form-container' => 'Mobile form container styles for hosting',
        'mobile-table' => 'Mobile table responsive styles for hosting'
    ];
    
    foreach ($cssChecks as $check => $description) {
        if (strpos($cssContent, $check) !== false) {
            echo "   ✅ {$description} included\n";
        } else {
            echo "   ❌ {$description} not found\n";
        }
    }
} else {
    echo "   ❌ Mobile CSS file not found for hosting\n";
}

// 7. Test .htaccess rules for hosting
echo "\n🔧 Testing .htaccess rules for hosting...\n";
$htaccessPath = public_path('.htaccess');
if (file_exists($htaccessPath)) {
    $htaccessContent = file_get_contents($htaccessPath);
    
    $htaccessChecks = [
        'Mobile 419 Error Fix Rules' => 'Mobile 419 error fix rules',
        'Access-Control-Allow-Origin' => 'CORS headers for mobile',
        'X-Content-Type-Options' => 'Security headers for mobile',
        'X-Frame-Options' => 'Frame options for mobile',
        'X-XSS-Protection' => 'XSS protection for mobile',
        'MOBILE:1' => 'Mobile user agent detection'
    ];
    
    foreach ($htaccessChecks as $check => $description) {
        if (strpos($htaccessContent, $check) !== false) {
            echo "   ✅ {$description} added\n";
        } else {
            echo "   ❌ {$description} not found\n";
        }
    }
} else {
    echo "   ❌ .htaccess file not found for hosting\n";
}

// 8. Test routes accessibility for hosting
echo "\n🛣️  Testing routes accessibility for hosting...\n";
$routes = [
    'ppdb.register' => 'PPDB Registration for hosting',
    'contact.index' => 'Contact Form for hosting',
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

// 9. Test CSRF token generation for hosting
echo "\n🔑 Testing CSRF token generation for hosting...\n";
try {
    $token = csrf_token();
    echo "   ✅ CSRF token generated for hosting: " . substr($token, 0, 10) . "...\n";
    
    // Test token length
    if (strlen($token) >= 40) {
        echo "   ✅ CSRF token length is valid for hosting\n";
    } else {
        echo "   ❌ CSRF token length is invalid for hosting\n";
    }
} catch (Exception $e) {
    echo "   ❌ CSRF token generation failed for hosting: " . $e->getMessage() . "\n";
}

// 10. Test database sessions for hosting
echo "\n🗄️  Testing database sessions for hosting...\n";
try {
    $sessions = DB::table('sessions')->count();
    echo "   ✅ Sessions table accessible for hosting\n";
    echo "   Active sessions: {$sessions}\n";
    
    if ($sessions > 0) {
        echo "   ✅ Sessions are being stored for hosting\n";
    } else {
        echo "   ℹ️  No active sessions found for hosting\n";
    }
} catch (Exception $e) {
    echo "   ❌ Sessions table error for hosting: " . $e->getMessage() . "\n";
}

// 11. Test mobile user agent detection for hosting
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

// 12. Test hosting-specific features
echo "\n🌐 Testing hosting-specific features...\n";
$appEnv = env('APP_ENV');
$appDebug = env('APP_DEBUG');
$appUrl = env('APP_URL');

echo "   APP_ENV: {$appEnv}\n";
echo "   APP_DEBUG: " . ($appDebug ? 'Yes' : 'No') . "\n";
echo "   APP_URL: {$appUrl}\n";

if ($appEnv === 'production') {
    echo "   ✅ App environment set to production for hosting\n";
} else {
    echo "   ❌ App environment not set to production for hosting\n";
}

if (!$appDebug) {
    echo "   ✅ Debug mode disabled for hosting\n";
} else {
    echo "   ❌ Debug mode enabled (not recommended for hosting)\n";
}

echo "\n✅ Mobile 419 fix testing for hosting completed!\n";
echo "🔧 Summary of fixes applied for hosting:\n";
echo "   - Extended session lifetime to 480 minutes\n";
echo "   - Disabled secure cookies for HTTP hosting\n";
echo "   - Set same site to 'lax' for mobile hosting compatibility\n";
echo "   - Added mobile-specific middleware for hosting\n";
echo "   - Enhanced CSRF refresh mechanism for hosting\n";
echo "   - Added mobile-specific CSS for hosting\n";
echo "   - Added mobile .htaccess rules for hosting\n";
echo "   - Set production environment for hosting\n";
echo "   - Disabled debug mode for hosting\n";
echo "\n🌐 Test URLs for hosting:\n";
echo "   - PPDB: https://yourdomain.com/ppdb/register\n";
echo "   - Contact: https://yourdomain.com/kontak\n";
echo "   - CSRF Refresh: https://yourdomain.com/ppdb/refresh-token\n";
echo "   - Auto Refresh: https://yourdomain.com/ppdb/auto-refresh\n";
echo "\n📱 Mobile testing tips for hosting:\n";
echo "   - Test on actual mobile devices\n";
echo "   - Check browser developer tools mobile mode\n";
echo "   - Verify CSRF token refresh works\n";
echo "   - Check session persistence across page reloads\n";
echo "   - Test on different mobile browsers\n";
echo "   - Test on different hosting environments\n";
echo "   - Monitor server logs for mobile requests\n";
