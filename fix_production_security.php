<?php
/**
 * Script untuk memperbaiki keamanan production
 */

require_once __DIR__ . '/vendor/autoload.php';

// Bootstrap Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\Artisan;

echo "=== FIX PRODUCTION SECURITY ===\n";

try {
    // Clear all caches
    echo "1. Clearing caches...\n";
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    Artisan::call('route:clear');
    echo "   Caches cleared successfully!\n";
    
    // Optimize for production
    echo "2. Optimizing for production...\n";
    Artisan::call('config:cache');
    Artisan::call('route:cache');
    Artisan::call('view:cache');
    echo "   Application optimized!\n";
    
    // Check environment
    echo "3. Checking environment...\n";
    $appEnv = config('app.env');
    $appDebug = config('app.debug');
    $appUrl = config('app.url');
    
    echo "   Environment: $appEnv\n";
    echo "   Debug mode: " . ($appDebug ? 'ON' : 'OFF') . "\n";
    echo "   App URL: $appUrl\n";
    
    if ($appDebug) {
        echo "   WARNING: Debug mode is ON! This is a security risk in production.\n";
        echo "   Please set APP_DEBUG=false in your .env file.\n";
    }
    
    if (strpos($appUrl, 'http://') === 0) {
        echo "   WARNING: App URL is HTTP! Please set APP_URL=https://smpnegeri01namrole.sch.id in your .env file.\n";
    }
    
    // Check file permissions
    echo "4. Checking file permissions...\n";
    $directories = [
        'storage',
        'storage/app',
        'storage/framework',
        'storage/framework/cache',
        'storage/framework/sessions',
        'storage/framework/views',
        'storage/logs',
        'bootstrap/cache'
    ];
    
    foreach ($directories as $dir) {
        if (is_dir($dir)) {
            $perms = substr(sprintf('%o', fileperms($dir)), -4);
            echo "   $dir: $perms\n";
        }
    }
    
    // Security recommendations
    echo "\n=== SECURITY RECOMMENDATIONS ===\n";
    echo "1. Set APP_DEBUG=false in .env file\n";
    echo "2. Set APP_URL=https://smpnegeri01namrole.sch.id in .env file\n";
    echo "3. Ensure SSL certificate is valid\n";
    echo "4. Check .htaccess file is in place\n";
    echo "5. Verify security headers are working\n";
    echo "6. Run malware scan\n";
    echo "7. Update all dependencies\n";
    echo "8. Use strong database passwords\n";
    echo "9. Regular security audits\n";
    echo "10. Monitor error logs\n";
    
    // Test security headers
    echo "\n=== TESTING SECURITY HEADERS ===\n";
    echo "Please test these URLs in your browser:\n";
    echo "- https://smpnegeri01namrole.sch.id/\n";
    echo "- https://smpnegeri01namrole.sch.id/berita\n";
    echo "\nCheck browser developer tools > Network > Response Headers for:\n";
    echo "- X-Frame-Options\n";
    echo "- X-Content-Type-Options\n";
    echo "- X-XSS-Protection\n";
    echo "- Strict-Transport-Security\n";
    echo "- Content-Security-Policy\n";
    echo "- Referrer-Policy\n";
    
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
}

echo "\n=== END FIX PRODUCTION SECURITY ===\n";
?>
