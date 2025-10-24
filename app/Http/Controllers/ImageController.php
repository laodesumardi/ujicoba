<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use App\Helpers\StorageHelper;

class ImageController extends Controller
{
    /**
     * Serve image directly from storage
     */
    public function serve(Request $request, $folder, $filename)
    {
        try {
            // Clean parameters
            $folder = preg_replace('/[^a-zA-Z0-9_-]/', '', $folder);
            $filename = preg_replace('/[^a-zA-Z0-9._-]/', '', $filename);
            
            if (empty($folder) || empty($filename)) {
                return $this->serveDefaultImage();
            }
            
            $imagePath = $folder . '/' . $filename;
            
            // Prefer storage/app/public first (no symlink/copy)
            $storagePath = storage_path('app/public/' . $imagePath);
            if (file_exists($storagePath) && is_readable($storagePath)) {
                return $this->serveImageFile($storagePath);
            }
            
            // Fallback to public/storage if present
            $publicPath = public_path('storage/' . $imagePath);
            if (file_exists($publicPath) && is_readable($publicPath)) {
                return $this->serveImageFile($publicPath);
            }
            
            // If not found, serve default image
            return $this->serveDefaultImage();
            
        } catch (\Exception $e) {
            \Log::error("Image serve error: " . $e->getMessage());
            return $this->serveDefaultImage();
        }
    }
    
    /**
     * Serve image from specific model
     */
    public function serveModelImage(Request $request, $model, $id, $field = 'image')
    {
        try {
            $modelClass = $this->getModelClass($model);
            $defaultOverride = ($model === 'library' && $field === 'organization_chart') ? 'images/default-struktur.png' : null;
            if (!$modelClass) {
                return $this->serveDefaultImage($defaultOverride);
            }
            
            $record = $modelClass::find($id);
            if (!$record) {
                return $this->serveDefaultImage($defaultOverride);
            }
            
            $imagePath = $record->getAttribute($field);
            if (empty($imagePath)) {
                return $this->serveDefaultImage($defaultOverride);
            }
            
            // Clean path
            $cleanPath = $this->cleanImagePath($imagePath, $model, $field);
            if (!$cleanPath) {
                return $this->serveDefaultImage($defaultOverride);
            }
            
            // Prefer storage/app/public first (no symlink/copy)
            $storagePath = storage_path('app/public/' . $cleanPath);
            if (file_exists($storagePath) && is_readable($storagePath)) {
                return $this->serveImageFile($storagePath);
            }
            
            // Fallback to public/storage if present
            $publicPath = public_path('storage/' . $cleanPath);
            if (file_exists($publicPath) && is_readable($publicPath)) {
                return $this->serveImageFile($publicPath);
            }
            
            return $this->serveDefaultImage($defaultOverride);
            
        } catch (\Exception $e) {
            \Log::error("Model image serve error: " . $e->getMessage());
            return $this->serveDefaultImage($defaultOverride ?? null);
        }
    }
    
    /**
     * Serve default image
     */
    private function serveDefaultImage(?string $overridePath = null)
    {
        if ($overridePath) {
            $candidate = is_file($overridePath) ? $overridePath : public_path($overridePath);
            if (file_exists($candidate) && is_readable($candidate)) {
                return $this->serveImageFile($candidate);
            }
        }
        
        $defaultPath = public_path('images/default-image.png');
        
        if (file_exists($defaultPath)) {
            return $this->serveImageFile($defaultPath);
        }
        
        // Create a simple default image if not exists
        $this->createDefaultImage();
        return $this->serveImageFile($defaultPath);
    }
    
    /**
     * Serve image file with proper headers
     */
    private function serveImageFile($filePath)
    {
        if (!file_exists($filePath) || !is_readable($filePath)) {
            return $this->serveDefaultImage();
        }
        
        $mimeType = mime_content_type($filePath);
        $fileSize = filesize($filePath);
        
        return response()->file($filePath, [
            'Content-Type' => $mimeType,
            'Content-Length' => $fileSize,
            'Cache-Control' => 'public, max-age=31536000', // 1 year cache
            'Expires' => gmdate('D, d M Y H:i:s', time() + 31536000) . ' GMT',
        ]);
    }
    
    /**
     * Get model class from string
     */
    private function getModelClass($model)
    {
        $models = [
            'home-section' => \App\Models\HomeSection::class,
            'news' => \App\Models\News::class,
            'facility' => \App\Models\Facility::class,
            'gallery' => \App\Models\Gallery::class,
            'gallery-item' => \App\Models\GalleryItem::class,
            'headmaster-greeting' => \App\Models\HeadmasterGreeting::class,
            'school-profile' => \App\Models\SchoolProfile::class,
            'user' => \App\Models\User::class,
            'library' => \App\Models\Library::class,
            // Added support for VisionMission
            'vision-mission' => \App\Models\VisionMission::class,
        ];
        
        return $models[$model] ?? null;
    }
    
    /**
     * Clean image path for specific model and field
     */
    private function cleanImagePath($imagePath, $model, $field)
    {
        if (empty($imagePath)) {
            return null;
        }
        
        // Skip if it's already a full URL
        if (filter_var($imagePath, FILTER_VALIDATE_URL) ||
            str_starts_with($imagePath, 'http://') ||
            str_starts_with($imagePath, 'https://')) {
            return null;
        }
        
        $path = $imagePath;
        
        // Remove public/ prefix if exists
        if (str_starts_with($path, 'public/')) {
            $path = substr($path, 7);
        }
        
        // Remove storage/ prefix if exists
        if (str_starts_with($path, 'storage/')) {
            $path = substr($path, 8);
        }
        
        // Determine folder based on model and field
        $folder = $this->getFolderForModel($model, $field);
        
        // Ensure proper folder structure
        if (!str_starts_with($path, $folder . '/')) {
            $path = $folder . '/' . $path;
        }
        
        return $path;
    }
    
    /**
     * Get folder name for model and field
     */
    private function getFolderForModel($model, $field)
    {
        $modelFolders = [
            'home-section' => 'home-sections',
            'news' => 'news',
            'facility' => 'facilities',
            'gallery' => 'galleries',
            'gallery-item' => 'gallery-items',
            'headmaster-greeting' => 'headmaster-greetings',
            'school-profile' => 'school-profiles',
            'user' => 'students/photos',
            'library' => 'libraries',
            // Added folder mapping for VisionMission
            'vision-mission' => 'vision-missions',
        ];
        
        return $modelFolders[$model] ?? 'general';
    }
    
    /**
     * Create default image if not exists
     */
    private function createDefaultImage()
    {
        $defaultPath = public_path('images/default-image.png');
        $imagesDir = dirname($defaultPath);
        
        if (!is_dir($imagesDir)) {
            mkdir($imagesDir, 0755, true);
        }
        
        if (!file_exists($defaultPath)) {
            // Create a simple 1x1 transparent PNG
            $pngData = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNkYPhfDwAChwGA60e6kgAAAABJRU5ErkJggg==');
            file_put_contents($defaultPath, $pngData);
        }
    }
}