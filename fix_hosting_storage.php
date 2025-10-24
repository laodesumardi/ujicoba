<?php
/**
 * Script untuk mengatasi masalah storage link di hosting
 * Jalankan script ini di hosting untuk copy file dari storage/app/public ke public/storage
 */

echo "=== FIX HOSTING STORAGE SCRIPT ===\n";
echo "Script ini akan mengatasi masalah storage link di hosting\n\n";

// Path ke storage/app/public
$storagePath = __DIR__ . '/storage/app/public';
// Path ke public/storage
$publicStoragePath = __DIR__ . '/public/storage';

echo "Storage path: $storagePath\n";
echo "Public storage path: $publicStoragePath\n\n";

// Cek apakah folder storage/app/public ada
if (!is_dir($storagePath)) {
    echo "❌ Folder storage/app/public tidak ditemukan!\n";
    exit(1);
}

// Buat folder public/storage jika belum ada
if (!is_dir($publicStoragePath)) {
    if (mkdir($publicStoragePath, 0755, true)) {
        echo "✅ Folder public/storage berhasil dibuat\n";
    } else {
        echo "❌ Gagal membuat folder public/storage\n";
        exit(1);
    }
}

// Function untuk copy folder recursive
function copyDirectory($src, $dst) {
    $dir = opendir($src);
    if (!is_dir($dst)) {
        mkdir($dst, 0755, true);
    }
    
    while (($file = readdir($dir)) !== false) {
        if ($file != '.' && $file != '..') {
            $srcFile = $src . '/' . $file;
            $dstFile = $dst . '/' . $file;
            
            if (is_dir($srcFile)) {
                copyDirectory($srcFile, $dstFile);
            } else {
                if (copy($srcFile, $dstFile)) {
                    echo "✅ Copied: $file\n";
                } else {
                    echo "❌ Failed to copy: $file\n";
                }
            }
        }
    }
    closedir($dir);
}

// Copy semua file dari storage/app/public ke public/storage
echo "📁 Menyalin file dari storage/app/public ke public/storage...\n";
copyDirectory($storagePath, $publicStoragePath);

// Set permission
echo "\n🔧 Mengatur permission...\n";
chmod($publicStoragePath, 0755);

// Set permission untuk semua file dan folder di dalamnya
function setPermissions($path) {
    if (is_dir($path)) {
        chmod($path, 0755);
        $files = scandir($path);
        foreach ($files as $file) {
            if ($file != '.' && $file != '..') {
                setPermissions($path . '/' . $file);
            }
        }
    } else {
        chmod($path, 0644);
    }
}

setPermissions($publicStoragePath);

echo "\n✅ SELESAI! Storage link telah diperbaiki untuk hosting\n";
echo "📝 Catatan:\n";
echo "- File sekarang dapat diakses via: /storage/folder/file.jpg\n";
echo "- Pastikan folder public/storage ada dan berisi file yang sama dengan storage/app/public\n";
echo "- Jika ada file baru yang diupload, jalankan script ini lagi\n";
?>
