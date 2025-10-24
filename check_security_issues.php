<?php
/**
 * Script untuk memeriksa masalah keamanan website
 */

require_once __DIR__ . '/vendor/autoload.php';

// Bootstrap Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== CHECK SECURITY ISSUES ===\n";

try {
    // Check SSL configuration
    echo "1. Checking SSL configuration...\n";
    $sslCheck = @fsockopen('ssl://smpnegeri01namrole.sch.id', 443, $errno, $errstr, 5);
    if ($sslCheck) {
        echo "   SSL connection: OK\n";
        fclose($sslCheck);
    } else {
        echo "   SSL connection: FAILED ($errstr)\n";
    }
    
    // Check if HTTPS is enforced
    echo "2. Checking HTTPS enforcement...\n";
    $appUrl = config('app.url');
    echo "   App URL: $appUrl\n";
    
    if (strpos($appUrl, 'https://') === 0) {
        echo "   HTTPS enforcement: OK\n";
    } else {
        echo "   HTTPS enforcement: NEEDS FIX\n";
    }
    
    // Check security headers
    echo "3. Checking security headers...\n";
    $headers = [
        'X-Frame-Options',
        'X-Content-Type-Options',
        'X-XSS-Protection',
        'Strict-Transport-Security',
        'Content-Security-Policy',
        'Referrer-Policy'
    ];
    
    foreach ($headers as $header) {
        echo "   $header: Check manually in browser dev tools\n";
    }
    
    // Check for mixed content
    echo "4. Checking for mixed content issues...\n";
    echo "   - Ensure all images use HTTPS\n";
    echo "   - Ensure all CSS/JS use HTTPS\n";
    echo "   - Check for HTTP links in content\n";
    
    // Check Laravel security settings
    echo "5. Checking Laravel security settings...\n";
    $appDebug = config('app.debug');
    $appEnv = config('app.env');
    echo "   Debug mode: " . ($appDebug ? 'ON (RISK!)' : 'OFF') . "\n";
    echo "   Environment: $appEnv\n";
    
    if ($appDebug) {
        echo "   WARNING: Debug mode is ON in production!\n";
    }
    
    // Check for sensitive files
    echo "6. Checking for sensitive files...\n";
    $sensitiveFiles = [
        '.env',
        'composer.json',
        'package.json',
        'artisan',
        'storage/logs/laravel.log'
    ];
    
    foreach ($sensitiveFiles as $file) {
        if (file_exists($file)) {
            echo "   $file: EXISTS (check if accessible via web)\n";
        }
    }
    
    // Check database security
    echo "7. Checking database security...\n";
    $dbConnection = config('database.default');
    $dbHost = config("database.connections.$dbConnection.host");
    echo "   Database: $dbConnection\n";
    echo "   Host: $dbHost\n";
    
    // Recommendations
    echo "\n=== SECURITY RECOMMENDATIONS ===\n";
    echo "1. Enable HTTPS enforcement in .htaccess or server config\n";
    echo "2. Add security headers to server configuration\n";
    echo "3. Turn off debug mode in production\n";
    echo "4. Ensure all content uses HTTPS\n";
    echo "5. Check for malware in uploaded files\n";
    echo "6. Update Laravel and dependencies\n";
    echo "7. Use strong passwords for database\n";
    echo "8. Regular security scans\n";
    
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

echo "\n=== END SECURITY CHECK ===\n";
?>
