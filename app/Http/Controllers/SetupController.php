<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use App\Models\HomeSection;

class SetupController extends Controller
{
    public function generate()
    {
        try {
            // Create storage directories
            $directories = [
                'storage/app/public',
                'storage/app/public/home-sections',
                'public/uploads',
                'public/uploads/home-sections',
                'public/storage',
                'public/storage/home-sections'
            ];

            foreach ($directories as $dir) {
                if (!is_dir($dir)) {
                    mkdir($dir, 0755, true);
                }
            }

            // Create storage link
            Artisan::call('storage:link');
            
            // Create placeholder image
            $placeholderPath = 'storage/app/public/home-sections/placeholder.jpg';
            if (!file_exists($placeholderPath)) {
                if (function_exists('imagecreate')) {
                    $img = imagecreate(400, 300);
                    $bg = imagecolorallocate($img, 240, 240, 240);
                    $text_color = imagecolorallocate($img, 100, 100, 100);
                    imagestring($img, 5, 150, 140, 'SMP Namrole', $text_color);
                    imagejpeg($img, $placeholderPath, 80);
                    imagedestroy($img);
                }
            }
            
            // Create sample images for each section
            $sections = HomeSection::all();
            foreach ($sections as $section) {
                $imageName = $section->section_key . '.jpg';
                $imagePath = 'storage/app/public/home-sections/' . $imageName;
                
                if (!file_exists($imagePath)) {
                    if (function_exists('imagecreate')) {
                        $img = imagecreate(400, 300);
                        $bg = imagecolorallocate($img, 240, 240, 240);
                        $text_color = imagecolorallocate($img, 100, 100, 100);
                        imagestring($img, 5, 150, 140, ucfirst($section->section_key), $text_color);
                        imagejpeg($img, $imagePath, 80);
                        imagedestroy($img);
                    }
                }
                
                // Update database with correct path
                $section->image = 'storage/home-sections/' . $imageName;
                $section->save();
            }

            // Create .htaccess for storage
            $htaccessContent = "Options -Indexes\n<Files ~ \"\\.(jpg|jpeg|png|gif|svg|webp)$\">\n    Order allow,deny\n    Allow from all\n</Files>\n";
            file_put_contents('public/storage/.htaccess', $htaccessContent);

            return response('<h1>Storage Link Created Successfully!</h1><p>✅ Storage link created</p><p>✅ Sample images created</p><p>✅ Database updated</p><p>✅ .htaccess created</p><p><a href="/test-images">Test Images</a></p><p><a href="/">Go to Homepage</a></p><p><a href="/admin/home-sections">Go to Admin Panel</a></p>');
        } catch (\Exception $e) {
            return response('<h1>Error Creating Storage Link</h1><p>Error: ' . $e->getMessage() . '</p><p>Please try again or contact administrator.</p>');
        }
    }

    public function setup()
    {
        try {
            $baseStorage = storage_path('app/public');
            $basePublic = public_path('storage');
            $baseUploads = public_path('uploads');

            // Direktori yang umum digunakan di seluruh aplikasi
            $subdirs = [
                'home-sections',
                'school-profiles',
                'facilities',
                'galleries',
                'headmaster-greetings',
                'teachers',
                'students',
                'students/photos',
                'documents',
                'assignments',
                'submissions',
                'lessons',
                'libraries',
                'ppdb',
                'news',
            ];

            // Pastikan base directories ada
            foreach ([$baseStorage, $basePublic, $baseUploads] as $dir) {
                if (!is_dir($dir)) {
                    mkdir($dir, 0755, true);
                }
            }

            // Buat subdirektori di storage dan public/storage
            foreach ($subdirs as $sub) {
                $storageDir = $baseStorage . DIRECTORY_SEPARATOR . $sub;
                $publicDir = $basePublic . DIRECTORY_SEPARATOR . $sub;

                if (!is_dir($storageDir)) {
                    mkdir($storageDir, 0755, true);
                }
                if (!is_dir($publicDir)) {
                    mkdir($publicDir, 0755, true);
                }
            }

            // Legacy uploads yang perlu dijaga (untuk kompatibilitas lama)
            $legacyUploadDirs = ['home-sections', 'school-profiles'];
            foreach ($legacyUploadDirs as $sub) {
                $legacyDir = $baseUploads . DIRECTORY_SEPARATOR . $sub;
                if (!is_dir($legacyDir)) {
                    mkdir($legacyDir, 0755, true);
                }
            }

            // Buat symlink storage
            Artisan::call('storage:link');

            // Jika symlink gagal atau diblokir, lakukan mirror copy dari storage ke public/storage
            if (!is_link($basePublic)) {
                $this->copyDirectory($baseStorage, $basePublic);
            }

            // Copy dari public/uploads ke storage untuk direktori legacy jika ada file lama
            foreach ($legacyUploadDirs as $sub) {
                $src = $baseUploads . DIRECTORY_SEPARATOR . $sub;
                $dst = $baseStorage . DIRECTORY_SEPARATOR . $sub;
                if (is_dir($src)) {
                    $this->copyDirectory($src, $dst);
                }
            }

            // Pastikan .htaccess ada di public/storage
            $htaccessPath = $basePublic . DIRECTORY_SEPARATOR . '.htaccess';
            if (!file_exists($htaccessPath)) {
                $htaccessContent = "Options -Indexes\n<Files ~ \"\\.(jpg|jpeg|png|gif|svg|webp|pdf)$\">\n    Order allow,deny\n    Allow from all\n</Files>\n";
                file_put_contents($htaccessPath, $htaccessContent);
            }

            // Bersihkan cache
            Artisan::call('cache:clear');
            Artisan::call('config:clear');
            Artisan::call('route:clear');
            Artisan::call('view:clear');
            Artisan::call('config:cache');

            return response('<h1>Setup Completed Successfully!</h1><p>✅ Directories ensured</p><p>✅ Storage link created or fallback mirrored</p><p>✅ Legacy uploads copied</p><p>✅ .htaccess ensured</p><p>✅ Caches cleared</p><p><a href="/admin/home-sections">Admin Home Sections</a></p>');
        } catch (\Exception $e) {
            return response('<h1>Error During Setup</h1><p>Error: ' . $e->getMessage() . '</p><p>Please try again or contact administrator.</p>');
        }
    }

    public function testImages()
    {
        $html = '<h1>Image Access Test</h1>';
        
        // Check if storage link exists
        if (is_link(public_path('storage'))) {
            $html .= '<p>✅ Storage link exists</p>';
        } else {
            $html .= '<p>❌ Storage link does not exist</p>';
        }
        
        // Check if placeholder image exists
        $placeholderPath = public_path('storage/home-sections/placeholder.jpg');
        if (file_exists($placeholderPath)) {
            $html .= '<p>✅ Placeholder image exists</p>';
            $html .= '<p><img src="/storage/home-sections/placeholder.jpg" alt="Placeholder" style="max-width: 200px;"></p>';
        } else {
            $html .= '<p>❌ Placeholder image not found</p>';
        }
        
        // List all images in storage
        $storagePath = public_path('storage/home-sections');
        if (is_dir($storagePath)) {
            $images = scandir($storagePath);
            $html .= '<h3>Available Images:</h3>';
            $html .= '<ul>';
            foreach ($images as $image) {
                if ($image != '.' && $image != '..') {
                    $html .= '<li><a href="/storage/home-sections/' . $image . '" target="_blank">' . $image . '</a></li>';
                }
            }
            $html .= '</ul>';
        }
        
        $html .= '<p><a href="/">Go to Homepage</a></p>';
        $html .= '<p><a href="/setup">Run Complete Setup</a></p>';
        
        return response($html);
    }
    
    private function copyDirectory(string $src, string $dst): void
    {
        if (!is_dir($src)) {
            return;
        }
        if (!is_dir($dst)) {
            mkdir($dst, 0755, true);
        }

        $items = scandir($src);
        foreach ($items as $item) {
            if ($item === '.' || $item === '..') {
                continue;
            }
            $source = $src . DIRECTORY_SEPARATOR . $item;
            $dest = $dst . DIRECTORY_SEPARATOR . $item;

            if (is_dir($source)) {
                $this->copyDirectory($source, $dest);
            } else {
                @copy($source, $dest);
            }
        }
    }
}
