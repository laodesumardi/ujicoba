# 📁 Panduan Upload Storage ke Hostinger

## 🚀 Langkah-langkah Deploy Storage

### 1. **Persiapan File**
```bash
# Jalankan script setup
php setup_storage.php
php deploy_storage.php
php check_storage.php
```

### 2. **File yang Perlu Diupload**

#### A. **Folder Storage** (Upload ke root hosting)
```
storage/
└── app/
    └── public/
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

#### B. **Folder Public Storage** (Upload ke public/storage/)
```
public/
└── storage/
    ├── .htaccess
    ├── .gitignore
    ├── test.txt
    ├── deployment-info.txt
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

### 3. **Konfigurasi Hosting**

#### A. **Set Permissions**
```bash
# Via cPanel File Manager atau SSH
chmod -R 755 storage/
chmod -R 755 public/storage/
```

#### B. **Cek .htaccess**
Pastikan file `public/storage/.htaccess` ada dengan konfigurasi:
```apache
Options +FollowSymLinks
RewriteEngine On

<Files "*">
    Order Allow,Deny
    Allow from all
</Files>

<IfModule mod_mime.c>
    AddType image/jpeg .jpg .jpeg
    AddType image/png .png
    AddType image/gif .gif
    AddType image/webp .webp
    AddType application/pdf .pdf
</IfModule>
```

### 4. **Test di Hosting**

#### A. **Test URL**
```
https://yourdomain.com/storage/test.txt
https://yourdomain.com/storage/deploy-test.txt
```

#### B. **Test Upload**
1. Login ke admin panel
2. Upload gambar di galeri
3. Cek apakah gambar muncul di website

### 5. **Troubleshooting**

#### A. **Gambar Tidak Muncul**
1. Cek URL: `https://yourdomain.com/storage/galleries/image.jpg`
2. Cek permissions: `chmod -R 755 storage/`
3. Cek .htaccess di public/storage/

#### B. **Error 403 Forbidden**
1. Cek .htaccess configuration
2. Cek file permissions
3. Cek hosting support untuk symlink

#### C. **Error 404 Not Found**
1. Pastikan folder storage ada
2. Pastikan symlink benar
3. Cek URL configuration di .env

### 6. **Backup & Restore**

#### A. **Backup Storage**
```bash
# Download backup file
storage_backup_YYYY-MM-DD_HH-MM-SS.zip
```

#### B. **Restore Storage**
```bash
# Extract backup
unzip storage_backup_YYYY-MM-DD_HH-MM-SS.zip
# Upload ke hosting
```

### 7. **Monitoring**

#### A. **Check Storage Usage**
Akses: `https://yourdomain.com/check_storage.php`

#### B. **Check File Access**
Akses: `https://yourdomain.com/storage/test.txt`

### 8. **Security**

#### A. **Protect PHP Files**
```apache
# .htaccess di storage/
<Files "*.php">
    Order Deny,Allow
    Deny from all
</Files>
```

#### B. **Prevent Direct Access**
```php
// Di controller, gunakan Storage::url()
$imageUrl = Storage::url('news/image.jpg');
```

---

## ✅ Checklist Deploy

- [ ] Upload folder `storage/` ke root hosting
- [ ] Upload folder `public/storage/` ke public/storage/
- [ ] Set permissions 755 untuk semua folder
- [ ] Cek .htaccess configuration
- [ ] Test akses file via URL
- [ ] Test upload gambar via admin
- [ ] Cek apakah gambar muncul di website
- [ ] Backup storage sebelum deploy
- [ ] Monitor storage usage
- [ ] Setup security headers

---

## 🔧 Script yang Tersedia

1. **setup_storage.php** - Setup storage directory
2. **deploy_storage.php** - Deploy storage ke hosting
3. **check_storage.php** - Cek konfigurasi storage
4. **HOSTING_SETUP.md** - Dokumentasi lengkap

---

## 📞 Support

Jika ada masalah dengan storage di hosting:
1. Cek file permissions
2. Cek .htaccess configuration
3. Cek hosting support untuk symlink
4. Gunakan metode copy folder jika symlink tidak didukung

