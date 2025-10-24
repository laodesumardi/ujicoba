<?php

namespace App\Listeners;

use App\Helpers\StorageHelper;
use Illuminate\Support\Facades\Log;

class AutoSyncStorageListener
{
    /**
     * Handle the event.
     */
    public function handle($event)
    {
        try {
            // Get the model instance
            $model = $event->model ?? $event;
            
            // Check if model has image fields
            $imageFields = $this->getImageFields($model);
            
            if (empty($imageFields)) {
                return;
            }
            
            // Sync each image field
            foreach ($imageFields as $field) {
                $imagePath = $model->getAttribute($field);
                
                if ($imagePath && !empty($imagePath)) {
                    // Clean path untuk StorageHelper
                    $cleanPath = $this->cleanImagePath($imagePath, $field);
                    
                    if ($cleanPath) {
                        // Copy to public storage
                        $success = StorageHelper::copyToPublic($cleanPath);
                        
                        if ($success) {
                            Log::info("Auto sync successful for {$field}: {$cleanPath}");
                        } else {
                            Log::warning("Auto sync failed for {$field}: {$cleanPath}");
                        }
                    }
                }
            }
            
        } catch (\Exception $e) {
            Log::error("Auto sync error: " . $e->getMessage());
        }
    }
    
    /**
     * Get image fields for the model
     */
    private function getImageFields($model)
    {
        $imageFields = [];
        
        // Define image fields for each model type
        $modelType = class_basename($model);
        
        switch ($modelType) {
            case 'HomeSection':
                $imageFields = ['image'];
                break;
            case 'News':
                $imageFields = ['featured_image'];
                break;
            case 'Facility':
                $imageFields = ['image'];
                break;
            case 'Gallery':
                $imageFields = ['image', 'cover_image'];
                break;
            case 'GalleryItem':
                $imageFields = ['image'];
                break;
            case 'HeadmasterGreeting':
                $imageFields = ['image'];
                break;
            case 'SchoolProfile':
                $imageFields = ['hero_image', 'struktur_image'];
                break;
            case 'User':
                $imageFields = ['photo'];
                break;
        }
        
        return $imageFields;
    }
    
    /**
     * Clean image path for StorageHelper
     */
    private function cleanImagePath($imagePath, $field)
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
        
        // Determine folder based on field name and model
        $folder = $this->getFolderForField($field);
        
        // Ensure proper folder structure
        if (!str_starts_with($path, $folder . '/')) {
            $path = $folder . '/' . $path;
        }
        
        return $path;
    }
    
    /**
     * Get folder name for field
     */
    private function getFolderForField($field)
    {
        $fieldFolders = [
            'image' => 'home-sections',
            'featured_image' => 'news',
            'cover_image' => 'galleries',
            'hero_image' => 'school-profiles',
            'struktur_image' => 'school-profiles',
            'photo' => 'students/photos'
        ];
        
        return $fieldFolders[$field] ?? 'general';
    }
}
