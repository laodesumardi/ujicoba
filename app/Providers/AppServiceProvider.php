<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Artisan;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Ensure public/storage symlink exists in production-like environments
        try {
            $publicStorage = public_path('storage');
            $target = storage_path('app/public');

            if (!is_link($publicStorage)) {
                // Attempt to create symlink via Artisan (handles cross-platform)
                Artisan::call('storage:link');

                // If symlink still not created and folder exists, try fallback: create directory
                if (!is_link($publicStorage) && is_dir($target) && !is_dir($publicStorage)) {
                    // As a last resort, create the directory so assets can be served if host blocks symlink
                    @mkdir($publicStorage, 0755, true);
                }
            }
        } catch (\Throwable $e) {
            // Silently ignore to avoid breaking boot; admins can run manual fix route
            // logger()->warning('Storage link setup failed: '.$e->getMessage());
        }
    }
}
