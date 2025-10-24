# 🔧 Solusi Storage Link untuk Hosting

Dokumentasi ini menjelaskan cara mengatasi masalah storage link di hosting yang tidak mendukung symbolic link.

## 🚨 Masalah yang Sering Terjadi

1. **Symbolic Link Tidak Bisa Dibuat di Hosting**
   - Shared hosting sering melarang symbolic link (symlink) karena alasan keamanan
   - Akibatnya, `/storage` tidak mengarah ke `storage/app/public`

2. **Gambar Diupload ke Folder Salah**
   - Gambar tersimpan di `storage/app/public`, tapi diakses via `public/images`
   - URL gambar tidak bisa diakses

3. **File Permission Salah**
   - Folder storage atau file gambarnya tidak terbaca publik

## ✅ Solusi Lengkap

### 1. Script Otomatis (Recommended)

Jalankan script `fix_hosting_storage.php` di hosting:

```bash
php fix_hosting_storage.php
```

Script ini akan:
- ✅ Copy semua file dari `storage/app/public` ke `public/storage`
- ✅ Set permission yang benar
- ✅ Memberikan feedback proses

### 2. Command Artisan

Gunakan command artisan yang sudah dibuat:

```bash
php artisan storage:sync
```

Atau dengan force option:

```bash
php artisan storage:sync --force
```

### 3. Manual Copy (Jika Script Gagal)

Jika script otomatis gagal, lakukan manual:

```bash
# 1. Buat folder public/storage
mkdir public/storage

# 2. Copy semua file
cp -r storage/app/public/* public/storage/

# 3. Set permission
chmod -R 755 public/storage
```

## 🔧 Helper Functions

### StorageHelper Class

Gunakan `App\Helpers\StorageHelper` untuk akses gambar yang aman:

```php
use App\Helpers\StorageHelper;

// Get URL gambar
$imageUrl = StorageHelper::getStorageUrl('galleries/image.jpg');

// Get path file
$filePath = StorageHelper::getStoragePath('galleries/image.jpg');

// Check apakah file ada
$exists = StorageHelper::storageExists('galleries/image.jpg');

// Get image dengan default fallback
$imageUrl = StorageHelper::getImageUrl('galleries/image.jpg', 'images/default.jpg');

// Copy file ke public (untuk hosting)
StorageHelper::copyToPublic('galleries/image.jpg');

// Sync semua file
$results = StorageHelper::syncToPublic();
```

### Di Blade Template

```blade
{{-- Menggunakan StorageHelper --}}
<img src="{{ StorageHelper::getImageUrl($gallery->image, 'images/default-gallery.png') }}" alt="{{ $gallery->title }}">

{{-- Atau menggunakan accessor model --}}
<img src="{{ $gallery->image_url }}" alt="{{ $gallery->title }}">
```

## 📁 Struktur Folder yang Benar

```
public/
├── storage/           # ← Folder ini harus ada di hosting
│   ├── galleries/
│   ├── news/
│   ├── facilities/
│   ├── home-sections/
│   └── ...
└── images/
    ├── default-gallery.png
    ├── default-news.png
    └── ...

storage/
└── app/
    └── public/        # ← File asli disimpan di sini
        ├── galleries/
        ├── news/
        ├── facilities/
        └── ...
```

## 🔄 Workflow untuk Hosting

### Upload File Baru

1. **Upload file** seperti biasa (akan tersimpan di `storage/app/public`)
2. **Jalankan sync** untuk copy ke `public/storage`:
   ```bash
   php artisan storage:sync
   ```
3. **File sekarang bisa diakses** via URL `/storage/...`

### Otomatis Sync

Tambahkan di controller setelah upload:

```php
// Setelah upload file
StorageHelper::copyToPublic($filePath);
```

## 🚀 Deployment ke Hosting

### 1. Upload File

```bash
# Upload semua file ke hosting
git push origin main

# Atau upload manual via FTP/cPanel
```

### 2. Jalankan Script

```bash
# Via SSH (jika tersedia)
php fix_hosting_storage.php

# Atau via cPanel Terminal
php artisan storage:sync
```

### 3. Set Permission

```bash
# Set permission yang benar
chmod -R 755 public/storage
chmod -R 644 public/storage/*
```

## 🐛 Troubleshooting

### Gambar Tidak Muncul

1. **Cek apakah folder `public/storage` ada**
2. **Cek permission folder** (harus 755)
3. **Cek permission file** (harus 644)
4. **Jalankan sync ulang**

### Error Permission Denied

```bash
# Set permission yang benar
chmod -R 755 storage
chmod -R 755 public/storage
chmod -R 644 public/storage/*
```

### File Tidak Ter-copy

1. **Cek apakah source file ada** di `storage/app/public`
2. **Cek disk space** hosting
3. **Jalankan script manual** step by step

## 📝 Catatan Penting

- ✅ **Selalu jalankan sync** setelah upload file baru
- ✅ **Cek permission** folder dan file
- ✅ **Test akses gambar** setelah deployment
- ❌ **Jangan hapus** folder `storage/app/public`
- ❌ **Jangan edit** file di `public/storage` langsung

## 🔗 URL Akses Gambar

Setelah fix, gambar bisa diakses via:

```
https://yourdomain.com/storage/galleries/image.jpg
https://yourdomain.com/storage/news/image.png
https://yourdomain.com/storage/facilities/image.jpeg
```

## 📞 Support

Jika masih ada masalah:

1. **Cek log error** di `storage/logs/`
2. **Test akses file** manual via browser
3. **Hubungi support hosting** untuk permission issue
4. **Gunakan fallback** ke default image jika perlu
