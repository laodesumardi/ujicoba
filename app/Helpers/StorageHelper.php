<?php

namespace App\Helpers;

class StorageHelper
{
    /**
     * Get storage URL untuk hosting (tanpa symbolic link)
     * 
     * @param string $path Path file relatif dari storage/app/public
     * @return string URL lengkap ke file
     */
    public static function getStorageUrl($path = '')
    {
        // Hapus slash di awal jika ada
        $path = ltrim($path, '/');
        
        // Cek apakah file ada di public/storage (untuk hosting)
        $publicPath = public_path('storage/' . $path);
        if (file_exists($publicPath)) {
            return asset('storage/' . $path);
        }
        
        // Fallback ke storage link biasa (untuk development)
        return asset('storage/' . $path);
    }
    
    /**
     * Get storage path untuk hosting
     * 
     * @param string $path Path file relatif dari storage/app/public
     * @return string Path lengkap ke file
     */
    public static function getStoragePath($path = '')
    {
        // Hapus slash di awal jika ada
        $path = ltrim($path, '/');
        
        // Cek apakah file ada di public/storage (untuk hosting)
        $publicPath = public_path('storage/' . $path);
        if (file_exists($publicPath)) {
            return $publicPath;
        }
        
        // Fallback ke storage link biasa (untuk development)
        return storage_path('app/public/' . $path);
    }
    
    /**
     * Check apakah file storage ada
     * 
     * @param string $path Path file relatif dari storage/app/public
     * @return bool
     */
    public static function storageExists($path = '')
    {
        $path = ltrim($path, '/');
        
        // Cek di public/storage (untuk hosting)
        $publicPath = public_path('storage/' . $path);
        if (file_exists($publicPath)) {
            return true;
        }
        
        // Cek di storage/app/public (untuk development)
        $storagePath = storage_path('app/public/' . $path);
        return file_exists($storagePath);
    }
    
    /**
     * Get default image jika file tidak ada
     * 
     * @param string $path Path file relatif dari storage/app/public
     * @param string $default Default image path
     * @return string URL ke file atau default image
     */
    public static function getImageUrl($path = '', $default = 'images/default-image.png')
    {
        if (empty($path) || !self::storageExists($path)) {
            return asset($default);
        }
        
        return self::getStorageUrl($path);
    }
    
    /**
     * Copy file dari storage/app/public ke public/storage (untuk hosting)
     * 
     * @param string $path Path file relatif dari storage/app/public
     * @return bool Success status
     */
    public static function copyToPublic($path = '')
    {
        $path = ltrim($path, '/');
        
        $sourcePath = storage_path('app/public/' . $path);
        $targetPath = public_path('storage/' . $path);
        $targetDir = dirname($targetPath);
        
        // Buat folder target jika belum ada
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }
        
        // Copy file
        if (file_exists($sourcePath) && is_file($sourcePath)) {
            return copy($sourcePath, $targetPath);
        }
        
        return false;
    }
    
    /**
     * Sync semua file dari storage/app/public ke public/storage
     * 
     * @return array Result array dengan status
     */
    public static function syncToPublic()
    {
        $results = [
            'success' => 0,
            'failed' => 0,
            'errors' => []
        ];
        
        $sourceDir = storage_path('app/public');
        $targetDir = public_path('storage');
        
        if (!is_dir($sourceDir)) {
            $results['errors'][] = 'Source directory tidak ditemukan: ' . $sourceDir;
            return $results;
        }
        
        // Buat target directory jika belum ada
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }
        
        // Recursive copy
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($sourceDir, \RecursiveDirectoryIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::SELF_FIRST
        );
        
        foreach ($iterator as $item) {
            $sourcePath = $item->getPathname();
            $relativePath = str_replace($sourceDir . DIRECTORY_SEPARATOR, '', $sourcePath);
            $targetPath = $targetDir . DIRECTORY_SEPARATOR . $relativePath;
            
            if ($item->isDir()) {
                if (!is_dir($targetPath)) {
                    if (mkdir($targetPath, 0755, true)) {
                        $results['success']++;
                    } else {
                        $results['failed']++;
                        $results['errors'][] = 'Gagal membuat folder: ' . $targetPath;
                    }
                }
            } else {
                $targetFileDir = dirname($targetPath);
                if (!is_dir($targetFileDir)) {
                    mkdir($targetFileDir, 0755, true);
                }
                
                if (copy($sourcePath, $targetPath)) {
                    $results['success']++;
                } else {
                    $results['failed']++;
                    $results['errors'][] = 'Gagal copy file: ' . $sourcePath . ' -> ' . $targetPath;
                }
            }
        }
        
        return $results;
    }
}
