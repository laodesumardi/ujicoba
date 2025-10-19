#!/bin/bash

echo "🚀 Running Mobile 419 Fix for Hosting..."
echo "=========================================="

# Check if we're in the right directory
if [ ! -f "artisan" ]; then
    echo "❌ Error: Not in Laravel project directory"
    echo "Please run this script from your Laravel project root"
    exit 1
fi

# Check if PHP is available
if ! command -v php &> /dev/null; then
    echo "❌ Error: PHP not found"
    exit 1
fi

# Check PHP version
PHP_VERSION=$(php -v | head -n 1 | cut -d " " -f 2 | cut -d "." -f 1,2)
echo "✅ PHP Version: $PHP_VERSION"

# Run the mobile fix script
echo "🔧 Running mobile 419 fix script..."
php fix_mobile_419_hosting.php

# Check if script ran successfully
if [ $? -eq 0 ]; then
    echo "✅ Mobile 419 fix completed successfully!"
    echo ""
    echo "📱 Next steps:"
    echo "1. Test your mobile forms"
    echo "2. Check if error 419 is resolved"
    echo "3. Monitor server logs for mobile requests"
else
    echo "❌ Mobile 419 fix failed!"
    echo "Please check the error messages above"
fi

echo ""
echo "🌐 Test URLs:"
echo "- PPDB: https://yourdomain.com/ppdb/register"
echo "- Contact: https://yourdomain.com/kontak"
echo "- CSRF Refresh: https://yourdomain.com/ppdb/refresh-token"
