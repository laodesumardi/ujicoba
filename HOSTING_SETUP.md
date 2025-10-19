# Setup Storage untuk Hosting (Hostinger)

## 📁 Konfigurasi Storage Laravel

### 1. Symlink Storage
```bash
# Di local development
php artisan storage:link

# Di hosting (jika symlink tidak didukung)
# Upload folder storage/app/public ke public/storage
```

### 2. File yang Perlu Diupload ke Hosting

#### A. Folder Storage
```
storage/
├── app/
│   └── public/
│       ├── news/
│       ├── galleries/
│       ├── documents/
│       ├── facilities/
│       ├── teachers/
│       ├── students/
│       ├── school-profiles/
│       ├── home-sections/
│       ├── headmaster-greetings/
│       ├── assignments/
│       ├── submissions/
│       ├── lessons/
│       ├── libraries/
│       └── ppdb/
```

#### B. Public Storage (jika symlink tidak didukung)
```
public/
└── storage/
    ├── news/
    ├── galleries/
    ├── documents/
    ├── facilities/
    ├── teachers/
    ├── students/
    ├── school-profiles/
    ├── home-sections/
    ├── headmaster-greetings/
    ├── assignments/
    ├── submissions/
    ├── lessons/
    ├── libraries/
    └── ppdb/
```

### 3. Konfigurasi .htaccess

#### A. public/storage/.htaccess
```apache
Options +FollowSymLinks
RewriteEngine On

# Allow access to files
<Files "*">
    Order Allow,Deny
    Allow from all
</Files>

# Set proper MIME types
<IfModule mod_mime.c>
    AddType image/jpeg .jpg .jpeg
    AddType image/png .png
    AddType image/gif .gif
    AddType image/webp .webp
    AddType application/pdf .pdf
    AddType application/msword .doc
    AddType application/vnd.openxmlformats-officedocument.wordprocessingml.document .docx
    AddType application/vnd.ms-excel .xls
    AddType application/vnd.openxmlformats-officedocument.spreadsheetml.sheet .xlsx
</IfModule>

# Cache control for images
<IfModule mod_expires.c>
    ExpiresActive On
    ExpiresByType image/jpeg "access plus 1 month"
    ExpiresByType image/png "access plus 1 month"
    ExpiresByType image/gif "access plus 1 month"
    ExpiresByType image/webp "access plus 1 month"
</IfModule>

# Security headers
<IfModule mod_headers.c>
    Header set X-Content-Type-Options nosniff
    Header set X-Frame-Options DENY
</IfModule>
```

### 4. Konfigurasi Laravel untuk Hosting

#### A. config/filesystems.php
```php
'disks' => [
    'public' => [
        'driver' => 'local',
        'root' => storage_path('app/public'),
        'url' => env('APP_URL').'/storage',
        'visibility' => 'public',
    ],
],
```

#### B. .env untuk Hosting
```env
APP_URL=https://yourdomain.com
FILESYSTEM_DISK=public
```

### 5. Script Setup untuk Hosting

#### A. setup_storage.php
```php
<?php
// Jalankan script ini di hosting untuk setup storage
// Akses: https://yourdomain.com/setup_storage.php

echo "=== SETUP STORAGE FOR HOSTING ===\n\n";

// Check storage directory
$storagePath = __DIR__ . '/storage/app/public';
$publicStoragePath = __DIR__ . '/public/storage';

if (!is_dir($storagePath)) {
    mkdir($storagePath, 0755, true);
    echo "✓ Storage directory created\n";
}

// Create directories
$directories = [
    'news', 'galleries', 'documents', 'facilities', 
    'teachers', 'students', 'school-profiles', 
    'home-sections', 'headmaster-greetings', 
    'assignments', 'submissions', 'lessons', 
    'libraries', 'ppdb'
];

foreach ($directories as $dir) {
    $dirPath = $storagePath . '/' . $dir;
    if (!is_dir($dirPath)) {
        mkdir($dirPath, 0755, true);
        echo "✓ Created directory: $dir\n";
    }
}

echo "✓ Storage setup complete!\n";
?>
```

### 6. Langkah-langkah Deploy ke Hostinger

#### A. Upload File
1. Upload semua file Laravel ke hosting
2. Upload folder `storage/` ke root hosting
3. Upload folder `public/storage/` ke `public/storage/`

#### B. Set Permissions
```bash
# Set permissions untuk storage
chmod -R 755 storage/
chmod -R 755 public/storage/
```

#### C. Test Storage
1. Akses: `https://yourdomain.com/storage/test.txt`
2. Upload gambar melalui admin panel
3. Cek apakah gambar muncul di website

### 7. Troubleshooting

#### A. Gambar Tidak Muncul
1. Cek apakah symlink berfungsi: `ls -la public/storage`
2. Cek permissions: `chmod -R 755 storage/`
3. Cek .htaccess di public/storage/

#### B. Error 403 Forbidden
1. Cek .htaccess configuration
2. Cek file permissions
3. Cek hosting support untuk symlink

#### C. Error 404 Not Found
1. Pastikan folder storage ada
2. Pastikan symlink benar
3. Cek URL configuration di .env

### 8. Backup Storage

#### A. Backup Script
```bash
#!/bin/bash
# backup_storage.sh
tar -czf storage_backup_$(date +%Y%m%d).tar.gz storage/
echo "Storage backup created: storage_backup_$(date +%Y%m%d).tar.gz"
```

#### B. Restore Script
```bash
#!/bin/bash
# restore_storage.sh
tar -xzf storage_backup_YYYYMMDD.tar.gz
chmod -R 755 storage/
```

### 9. Monitoring Storage

#### A. Check Storage Usage
```php
// storage_usage.php
$storagePath = __DIR__ . '/storage/app/public';
$size = 0;
foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($storagePath)) as $file) {
    $size += $file->getSize();
}
echo "Storage usage: " . number_format($size / 1024 / 1024, 2) . " MB";
```

### 10. Security

#### A. Protect Storage Files
```apache
# .htaccess di storage/
<Files "*.php">
    Order Deny,Allow
    Deny from all
</Files>
```

#### B. Prevent Direct Access
```php
// Di controller, gunakan Storage::url() untuk generate URL
$imageUrl = Storage::url('news/image.jpg');
```

---

## ✅ Checklist Deploy

- [ ] Upload semua file Laravel
- [ ] Upload folder storage/
- [ ] Upload folder public/storage/
- [ ] Set permissions 755
- [ ] Cek .htaccess configuration
- [ ] Test upload gambar
- [ ] Test akses gambar via URL
- [ ] Backup storage sebelum deploy
- [ ] Monitor storage usage
- [ ] Setup security headers

---

**Catatan**: Jika hosting tidak mendukung symlink, gunakan metode copy folder storage/app/public ke public/storage secara manual.

