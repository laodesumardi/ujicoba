#!/bin/bash

echo "=== SETTING UP SERVER FOR IMAGES ==="

# 1. Navigate to project directory
cd /var/www/html/namrole

# 2. Pull latest changes
echo "1. Pulling latest changes..."
git pull origin main

# 3. Install dependencies
echo "2. Installing dependencies..."
composer install --no-dev --optimize-autoloader
npm install
npm run build

# 4. Create storage link
echo "3. Creating storage link..."
php artisan storage:link

# 5. Set permissions
echo "4. Setting permissions..."
sudo chmod -R 755 storage
sudo chmod -R 755 public/uploads
sudo chmod -R 755 public/storage
sudo chown -R www-data:www-data storage
sudo chown -R www-data:www-data public/uploads
sudo chown -R www-data:www-data public/storage

# 6. Clear caches
echo "5. Clearing caches..."
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# 7. Rebuild config cache
echo "6. Rebuilding config cache..."
php artisan config:cache

# 8. Test image access
echo "7. Testing image access..."
if [ -f "public/storage/home-sections/placeholder.jpg" ]; then
    echo "✓ Placeholder image exists"
else
    echo "✗ Placeholder image not found"
fi

echo "=== SERVER SETUP COMPLETED ==="
echo "Images should now be accessible at: /storage/home-sections/"
