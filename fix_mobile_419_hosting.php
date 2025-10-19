<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "🔧 Fixing Mobile 419 Error for Hosting...\n\n";

// 1. Update session configuration for mobile compatibility
echo "📱 Updating session configuration for mobile...\n";

// Read current config
$sessionConfigPath = config_path('session.php');
$sessionConfig = file_get_contents($sessionConfigPath);

// Update session configuration for hosting
$updates = [
    "'lifetime'" => "'lifetime' => (int) env('SESSION_LIFETIME', 480), // Extended for mobile",
    "'expire_on_close'" => "'expire_on_close' => env('SESSION_EXPIRE_ON_CLOSE', false), // Keep session alive",
    "'same_site'" => "'same_site' => 'lax', // Mobile compatible",
    "'secure'" => "'secure' => env('SESSION_SECURE_COOKIE', false), // HTTP compatible for hosting",
    "'http_only'" => "'http_only' => true, // Security",
    "'domain'" => "'domain' => env('SESSION_DOMAIN', null), // No domain restriction for hosting"
];

foreach ($updates as $key => $value) {
    if (strpos($sessionConfig, $key) !== false) {
        $sessionConfig = preg_replace("/{$key}\s*=>\s*[^,]+/", $value, $sessionConfig);
        echo "   ✅ Updated: {$key}\n";
    }
}

// Write updated config
file_put_contents($sessionConfigPath, $sessionConfig);
echo "   ✅ Session configuration updated for hosting\n";

// 2. Create mobile-specific middleware for hosting
echo "\n🛡️  Creating mobile-specific middleware for hosting...\n";
$middlewarePath = app_path('Http/Middleware/MobileCSRFMiddleware.php');

$middlewareContent = '<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class MobileCSRFMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if request is from mobile
        $userAgent = $request->header(\'User-Agent\');
        $isMobile = $this->isMobile($userAgent);
        
        if ($isMobile) {
            // Extend session lifetime for mobile
            $sessionLifetime = config(\'session.lifetime\', 480);
            config([\'session.lifetime\' => $sessionLifetime * 2]); // Double for mobile
            
            // Log mobile requests for debugging
            Log::info(\'Mobile request detected\', [
                \'user_agent\' => $userAgent,
                \'ip\' => $request->ip(),
                \'url\' => $request->url(),
                \'method\' => $request->method(),
                \'hosting\' => true
            ]);
        }
        
        return $next($request);
    }
    
    /**
     * Check if user agent is mobile
     */
    private function isMobile($userAgent)
    {
        $mobileKeywords = [
            \'Mobile\', \'Android\', \'iPhone\', \'iPad\', \'iPod\', 
            \'BlackBerry\', \'Windows Phone\', \'Opera Mini\', \'IEMobile\'
        ];
        
        foreach ($mobileKeywords as $keyword) {
            if (stripos($userAgent, $keyword) !== false) {
                return true;
            }
        }
        
        return false;
    }
}';

file_put_contents($middlewarePath, $middlewareContent);
echo "   ✅ Mobile CSRF middleware created for hosting\n";

// 3. Update .env file for hosting mobile compatibility
echo "\n🌍 Updating environment configuration for hosting...\n";
$envPath = base_path('.env');
if (file_exists($envPath)) {
    $envContent = file_get_contents($envPath);
    
    // Update session settings for mobile hosting
    $envUpdates = [
        'SESSION_LIFETIME=120' => 'SESSION_LIFETIME=480',
        'SESSION_SECURE_COOKIE=false' => 'SESSION_SECURE_COOKIE=false',
        'SESSION_SAME_SITE=lax' => 'SESSION_SAME_SITE=lax',
        'SESSION_DOMAIN=' => 'SESSION_DOMAIN=',
        'APP_ENV=local' => 'APP_ENV=production',
        'APP_DEBUG=true' => 'APP_DEBUG=false'
    ];
    
    foreach ($envUpdates as $old => $new) {
        if (strpos($envContent, $old) !== false) {
            $envContent = str_replace($old, $new, $envContent);
            echo "   ✅ Updated: {$old} -> {$new}\n";
        } else {
            // Add new setting if not exists
            $envContent .= "\n{$new}\n";
            echo "   ✅ Added: {$new}\n";
        }
    }
    
    file_put_contents($envPath, $envContent);
    echo "   ✅ Environment configuration updated for hosting\n";
} else {
    echo "   ❌ .env file not found\n";
}

// 4. Create mobile-specific CSRF refresh route for hosting
echo "\n🔄 Creating mobile CSRF refresh route for hosting...\n";
$webRoutesPath = base_path('routes/web.php');
$webRoutes = file_get_contents($webRoutesPath);

// Add mobile CSRF refresh route if not exists
if (strpos($webRoutes, 'ppdb/refresh-token') === false) {
    $mobileRoute = '
// Mobile CSRF refresh route for hosting
Route::get(\'/ppdb/refresh-token\', function() {
    return response()->json([
        \'success\' => true,
        \'token\' => csrf_token(),
        \'timestamp\' => time(),
        \'hosting\' => true
    ]);
})->name(\'ppdb.refresh-token\');

Route::get(\'/ppdb/auto-refresh\', function() {
    return response()->json([
        \'success\' => true,
        \'token\' => csrf_token(),
        \'auto_refresh\' => true,
        \'timestamp\' => time(),
        \'hosting\' => true
    ]);
})->name(\'ppdb.auto-refresh\');';

    $webRoutes .= $mobileRoute;
    file_put_contents($webRoutesPath, $webRoutes);
    echo "   ✅ Mobile CSRF refresh route added for hosting\n";
} else {
    echo "   ✅ Mobile CSRF refresh route already exists\n";
}

// 5. Update PPDB form for better mobile hosting compatibility
echo "\n📝 Updating PPDB form for mobile hosting...\n";
$ppdbViewPath = resource_path('views/ppdb/register.blade.php');
if (file_exists($ppdbViewPath)) {
    $ppdbContent = file_get_contents($ppdbViewPath);
    
    // Add mobile-specific meta tags for hosting
    $mobileMeta = '
    <!-- Mobile CSRF Meta Tags for Hosting -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="format-detection" content="telephone=no">';
    
    if (strpos($ppdbContent, 'Mobile CSRF Meta Tags for Hosting') === false) {
        $ppdbContent = str_replace('<head>', '<head>' . $mobileMeta, $ppdbContent);
        echo "   ✅ Mobile meta tags added for hosting\n";
    }
    
    // Update CSRF refresh function for mobile hosting
    $mobileCSRFJS = '
// Enhanced mobile CSRF refresh for hosting
function refreshCSRFToken() {
    // Show loading indicator
    const button = event.target;
    const originalText = button.innerHTML;
    button.innerHTML = \'🔄 Refreshing...\';
    button.disabled = true;
    
    fetch(\'/ppdb/refresh-token\', {
        method: \'GET\',
        headers: {
            \'X-Requested-With\': \'XMLHttpRequest\',
            \'Accept\': \'application/json\',
            \'X-CSRF-TOKEN\': document.querySelector(\'meta[name="csrf-token"]\')?.getAttribute(\'content\') || \'\'
        },
        cache: \'no-cache\'
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        if (data.success && data.token) {
            // Update CSRF token in all form inputs
            document.querySelectorAll(\'input[name="_token"]\').forEach(input => {
                input.value = data.token;
            });
            document.getElementById(\'csrf-token\').value = data.token;
            
            // Update meta tag
            const metaTag = document.querySelector(\'meta[name="csrf-token"]\');
            if (metaTag) {
                metaTag.setAttribute(\'content\', data.token);
            }
            
            showNotification(\'Token CSRF diperbarui untuk mobile hosting\', \'success\');
        } else {
            throw new Error(\'Invalid response format\');
        }
    })
    .catch(error => {
        console.error(\'Error refreshing CSRF token:\', error);
        showNotification(\'Gagal memperbarui token: \' + error.message, \'error\');
    })
    .finally(() => {
        // Restore button
        button.innerHTML = originalText;
        button.disabled = false;
    });
}';
    
    if (strpos($ppdbContent, 'Enhanced mobile CSRF refresh for hosting') === false) {
        $ppdbContent = str_replace('function refreshCSRFToken() {', $mobileCSRFJS, $ppdbContent);
        echo "   ✅ Mobile CSRF refresh function updated for hosting\n";
    }
    
    file_put_contents($ppdbViewPath, $ppdbContent);
    echo "   ✅ PPDB form updated for mobile hosting\n";
} else {
    echo "   ❌ PPDB form not found\n";
}

// 6. Create mobile-specific CSS for hosting
echo "\n🎨 Creating mobile-specific CSS for hosting...\n";
$mobileCSSPath = public_path('css/mobile-419-fix.css');
$mobileCSS = '
/* Mobile 419 Error Fix CSS for Hosting */
@media (max-width: 768px) {
    /* Mobile form improvements for hosting */
    .mobile-form {
        padding: 1rem;
        margin: 0.5rem;
    }
    
    /* Mobile button improvements for hosting */
    .mobile-button {
        min-height: 44px; /* iOS minimum touch target */
        font-size: 16px; /* Prevent zoom on iOS */
        padding: 12px 24px;
        border-radius: 8px;
        transition: all 0.3s ease;
    }
    
    /* Mobile input improvements for hosting */
    .mobile-input {
        font-size: 16px; /* Prevent zoom on iOS */
        padding: 12px;
        border-radius: 8px;
        border: 2px solid #e5e7eb;
        transition: border-color 0.3s ease;
    }
    
    .mobile-input:focus {
        border-color: #3b82f6;
        outline: none;
    }
    
    /* Mobile CSRF refresh button for hosting */
    .mobile-csrf-refresh {
        background: #3b82f6;
        color: white;
        border: none;
        border-radius: 8px;
        padding: 12px 24px;
        font-size: 16px;
        min-height: 44px;
        width: 100%;
        margin: 8px 0;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }
    
    .mobile-csrf-refresh:hover {
        background: #2563eb;
    }
    
    .mobile-csrf-refresh:disabled {
        background: #9ca3af;
        cursor: not-allowed;
    }
    
    /* Mobile notification for hosting */
    .mobile-notification {
        position: fixed;
        top: 20px;
        left: 20px;
        right: 20px;
        z-index: 9999;
        padding: 12px;
        border-radius: 8px;
        font-size: 14px;
        text-align: center;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    
    .mobile-notification.success {
        background: #10b981;
        color: white;
    }
    
    .mobile-notification.error {
        background: #ef4444;
        color: white;
    }
    
    /* Mobile form container for hosting */
    .mobile-form-container {
        max-width: 100%;
        padding: 1rem;
        margin: 0 auto;
    }
    
    /* Mobile table responsive for hosting */
    .mobile-table {
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }
}';

file_put_contents($mobileCSSPath, $mobileCSS);
echo "   ✅ Mobile CSS created for hosting\n";

// 7. Create hosting-specific .htaccess rules
echo "\n🔧 Creating hosting-specific .htaccess rules...\n";
$htaccessPath = public_path('.htaccess');
$htaccessContent = file_get_contents($htaccessPath);

$mobileHtaccessRules = '
# Mobile 419 Error Fix Rules
<IfModule mod_headers.c>
    # Enable CORS for mobile
    Header always set Access-Control-Allow-Origin "*"
    Header always set Access-Control-Allow-Methods "GET, POST, PUT, DELETE, OPTIONS"
    Header always set Access-Control-Allow-Headers "X-Requested-With, Content-Type, Authorization, X-CSRF-TOKEN"
    
    # Mobile-specific headers
    Header always set X-Content-Type-Options nosniff
    Header always set X-Frame-Options SAMEORIGIN
    Header always set X-XSS-Protection "1; mode=block"
</IfModule>

# Mobile session handling
<IfModule mod_rewrite.c>
    # Handle mobile user agents
    RewriteCond %{HTTP_USER_AGENT} "Mobile|Android|iPhone|iPad|iPod|BlackBerry|Windows Phone|Opera Mini|IEMobile" [NC]
    RewriteRule .* - [E=MOBILE:1]
</IfModule>';

if (strpos($htaccessContent, 'Mobile 419 Error Fix Rules') === false) {
    $htaccessContent .= $mobileHtaccessRules;
    file_put_contents($htaccessPath, $htaccessContent);
    echo "   ✅ Mobile .htaccess rules added for hosting\n";
} else {
    echo "   ✅ Mobile .htaccess rules already exist\n";
}

// 8. Clear cache for hosting
echo "\n🧹 Clearing cache for hosting...\n";
try {
    \Artisan::call('config:clear');
    echo "   ✅ Config cache cleared\n";
    
    \Artisan::call('route:clear');
    echo "   ✅ Route cache cleared\n";
    
    \Artisan::call('view:clear');
    echo "   ✅ View cache cleared\n";
    
    \Artisan::call('cache:clear');
    echo "   ✅ Application cache cleared\n";
} catch (Exception $e) {
    echo "   ❌ Cache clear failed: " . $e->getMessage() . "\n";
}

echo "\n✅ Mobile 419 error fix for hosting completed!\n";
echo "🔧 Key improvements for hosting:\n";
echo "   - Extended session lifetime to 480 minutes\n";
echo "   - Disabled secure cookies for HTTP hosting\n";
echo "   - Set same site to 'lax' for mobile compatibility\n";
echo "   - Added mobile-specific middleware\n";
echo "   - Enhanced CSRF refresh mechanism for hosting\n";
echo "   - Added mobile-specific CSS for hosting\n";
echo "   - Added mobile .htaccess rules\n";
echo "   - Cleared all caches\n";
echo "\n🌐 Test URLs for hosting:\n";
echo "   - PPDB: https://yourdomain.com/ppdb/register\n";
echo "   - Contact: https://yourdomain.com/kontak\n";
echo "   - CSRF Refresh: https://yourdomain.com/ppdb/refresh-token\n";
echo "\n📱 Mobile testing tips for hosting:\n";
echo "   - Test on actual mobile devices\n";
echo "   - Check browser developer tools mobile mode\n";
echo "   - Verify CSRF token refresh works\n";
echo "   - Check session persistence across page reloads\n";
echo "   - Test on different mobile browsers\n";
