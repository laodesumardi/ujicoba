<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Facility;

class AddFacilityImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'facility:add-images';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add sample images to facilities';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Get all facilities and add images
        $facilities = Facility::all();
        
        $imageUrls = [
            'https://images.unsplash.com/photo-1580582932707-520aed937b7b?w=400&h=300&fit=crop',
            'https://images.unsplash.com/photo-1532094349884-543bc11b234d?w=400&h=300&fit=crop',
            'https://images.unsplash.com/photo-1481627834876-b7833e8f5570?w=400&h=300&fit=crop',
            'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=400&h=300&fit=crop',
            'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=400&h=300&fit=crop',
            'https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?w=400&h=300&fit=crop',
            'https://images.unsplash.com/photo-1559757148-5c350d0d3c56?w=400&h=300&fit=crop',
            'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=400&h=300&fit=crop',
        ];

        $this->info('Adding images to facilities...');

        foreach ($facilities as $index => $facility) {
            if (isset($imageUrls[$index])) {
                $facility->update(['image' => $imageUrls[$index]]);
                $this->line("✓ Updated {$facility->name} with image");
            }
        }

        // Force update ALL facilities with external images
        $allImageUrls = [
            'https://images.unsplash.com/photo-1580582932707-520aed937b7b?w=400&h=300&fit=crop',
            'https://images.unsplash.com/photo-1532094349884-543bc11b234d?w=400&h=300&fit=crop',
            'https://images.unsplash.com/photo-1481627834876-b7833e8f5570?w=400&h=300&fit=crop',
            'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=400&h=300&fit=crop',
            'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=400&h=300&fit=crop',
            'https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?w=400&h=300&fit=crop',
            'https://images.unsplash.com/photo-1559757148-5c350d0d3c56?w=400&h=300&fit=crop',
            'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=400&h=300&fit=crop',
        ];

        $this->info('Force updating ALL facilities with external images...');
        foreach ($facilities as $index => $facility) {
            if (isset($allImageUrls[$index])) {
                $facility->update(['image' => $allImageUrls[$index]]);
                $this->line("✓ Force updated {$facility->name} with external image");
            } else {
                // Use a default image for any remaining facilities
                $facility->update(['image' => 'https://images.unsplash.com/photo-1580582932707-520aed937b7b?w=400&h=300&fit=crop']);
                $this->line("✓ Updated {$facility->name} with default external image");
            }
        }

        $this->info('All facilities updated with images!');
    }
}
