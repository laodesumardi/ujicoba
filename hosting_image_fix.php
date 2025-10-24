<?php
/**
 * Script khusus untuk fix gambar di hosting
 * Script ini akan copy semua file dari storage/app/public ke public/storage
 * dan memastikan gambar bisa diakses langsung dari public/storage
 */

echo "=== HOSTING IMAGE FIX SCRIPT ===\n";
echo "Script untuk memperbaiki masalah gambar di hosting\n\n";

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

// Function untuk copy folder recursive dengan detail
function copyDirectoryWithDetails($src, $dst) {
    $dir = opendir($src);
    if (!is_dir($dst)) {
        mkdir($dst, 0755, true);
    }
    
    $copied = 0;
    $failed = 0;
    
    while (($file = readdir($dir)) !== false) {
        if ($file != '.' && $file != '..') {
            $srcFile = $src . '/' . $file;
            $dstFile = $dst . '/' . $file;
            
            if (is_dir($srcFile)) {
                $result = copyDirectoryWithDetails($srcFile, $dstFile);
                $copied += $result['copied'];
                $failed += $result['failed'];
            } else {
                if (copy($srcFile, $dstFile)) {
                    echo "✅ Copied: $file\n";
                    $copied++;
                } else {
                    echo "❌ Failed to copy: $file\n";
                    $failed++;
                }
            }
        }
    }
    closedir($dir);
    
    return ['copied' => $copied, 'failed' => $failed];
}

// Copy semua file dari storage/app/public ke public/storage
echo "📁 Menyalin file dari storage/app/public ke public/storage...\n";
$result = copyDirectoryWithDetails($storagePath, $publicStoragePath);

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

echo "\n📊 HASIL COPY:\n";
echo "✅ Berhasil di-copy: {$result['copied']} file\n";
echo "❌ Gagal di-copy: {$result['failed']} file\n";

// Test akses beberapa file
echo "\n🧪 Testing akses file...\n";
$testFiles = [
    'home-sections',
    'news', 
    'facilities',
    'galleries'
];

foreach ($testFiles as $folder) {
    $testPath = $publicStoragePath . '/' . $folder;
    if (is_dir($testPath)) {
        $files = scandir($testPath);
        $fileCount = count($files) - 2; // Exclude . and ..
        echo "📁 Folder $folder: $fileCount file\n";
        
        // Test akses file pertama
        foreach ($files as $file) {
            if ($file != '.' && $file != '..' && !is_dir($testPath . '/' . $file)) {
                $testFile = $testPath . '/' . $file;
                if (file_exists($testFile) && is_readable($testFile)) {
                    echo "  ✅ $file - OK\n";
                } else {
                    echo "  ❌ $file - Tidak bisa dibaca\n";
                }
                break; // Test hanya file pertama
            }
        }
    } else {
        echo "📁 Folder $folder: Tidak ada\n";
    }
}

echo "\n✅ SELESAI! Gambar hosting telah diperbaiki\n";
echo "📝 Catatan penting:\n";
echo "- File sekarang dapat diakses via: https://smpnegeri01namrole.sch.id/storage/folder/file.jpg\n";
echo "- Pastikan folder public/storage ada dan berisi file yang sama dengan storage/app/public\n";
echo "- Jika ada file baru yang diupload, jalankan script ini lagi\n";
echo "- Model sudah diupdate untuk menggunakan StorageHelper\n";

echo "\n🔗 URL Test:\n";
echo "- Home Sections: https://smpnegeri01namrole.sch.id/storage/home-sections/\n";
echo "- News: https://smpnegeri01namrole.sch.id/storage/news/\n";
echo "- Facilities: https://smpnegeri01namrole.sch.id/storage/facilities/\n";
echo "- Galleries: https://smpnegeri01namrole.sch.id/storage/galleries/\n";
?>
