<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Facility;

class FacilityImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $facilityImages = [
            'Laboratorium Komputer' => 'https://images.unsplash.com/photo-1580582932707-520aed937b7b?w=400&h=300&fit=crop',
            'Laboratorium IPA' => 'https://images.unsplash.com/photo-1532094349884-543bc11b234d?w=400&h=300&fit=crop',
            'Perpustakaan Digital' => 'https://images.unsplash.com/photo-1481627834876-b7833e8f5570?w=400&h=300&fit=crop',
            'Lapangan Olahraga' => 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=400&h=300&fit=crop',
            'Ruang Kelas Ber-AC' => 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=400&h=300&fit=crop',
            'Kantin Sehat' => 'https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?w=400&h=300&fit=crop',
            'Ruang UKS' => 'https://images.unsplash.com/photo-1559757148-5c350d0d3c56?w=400&h=300&fit=crop',
            'WiFi Gratis' => 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=400&h=300&fit=crop',
        ];

        foreach ($facilityImages as $name => $imageUrl) {
            $facility = Facility::where('name', $name)->first();
            if ($facility) {
                $facility->update(['image' => $imageUrl]);
                echo "Updated facility {$facility->name} with image\n";
            }
        }

        echo "All facilities updated with sample images!\n";
    }
}
