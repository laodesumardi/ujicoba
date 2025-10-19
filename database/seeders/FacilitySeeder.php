<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Facility;

class FacilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $facilities = [
            [
                'name' => 'Laboratorium Komputer',
                'description' => 'Laboratorium komputer dengan 30 unit komputer terbaru untuk pembelajaran teknologi informasi.',
                'category' => 'technology',
                'icon' => 'fas fa-laptop',
                'sort_order' => 1,
                'is_active' => true,
                'is_featured' => true
            ],
            [
                'name' => 'Laboratorium IPA',
                'description' => 'Laboratorium IPA yang dilengkapi dengan peralatan praktikum lengkap untuk pembelajaran sains.',
                'category' => 'laboratory',
                'icon' => 'fas fa-flask',
                'sort_order' => 2,
                'is_active' => true,
                'is_featured' => true
            ],
            [
                'name' => 'Perpustakaan Digital',
                'description' => 'Perpustakaan modern dengan koleksi buku digital dan akses internet untuk penelitian siswa.',
                'category' => 'library',
                'icon' => 'fas fa-book',
                'sort_order' => 3,
                'is_active' => true,
                'is_featured' => true
            ],
            [
                'name' => 'Lapangan Olahraga',
                'description' => 'Lapangan olahraga multifungsi untuk basket, voli, dan sepak bola dengan standar nasional.',
                'category' => 'sports',
                'icon' => 'fas fa-futbol',
                'sort_order' => 4,
                'is_active' => true,
                'is_featured' => false
            ],
            [
                'name' => 'Ruang Kelas Ber-AC',
                'description' => 'Semua ruang kelas dilengkapi dengan AC dan proyektor untuk kenyamanan belajar.',
                'category' => 'academic',
                'icon' => 'fas fa-chalkboard-teacher',
                'sort_order' => 5,
                'is_active' => true,
                'is_featured' => false
            ],
            [
                'name' => 'Kantin Sehat',
                'description' => 'Kantin yang menyediakan makanan sehat dan bergizi untuk siswa dan guru.',
                'category' => 'welfare',
                'icon' => 'fas fa-utensils',
                'sort_order' => 6,
                'is_active' => true,
                'is_featured' => false
            ],
            [
                'name' => 'Ruang UKS',
                'description' => 'Unit Kesehatan Sekolah yang dilengkapi dengan peralatan medis dasar.',
                'category' => 'welfare',
                'icon' => 'fas fa-user-md',
                'sort_order' => 7,
                'is_active' => true,
                'is_featured' => false
            ],
            [
                'name' => 'WiFi Gratis',
                'description' => 'Akses internet WiFi gratis di seluruh area sekolah untuk mendukung pembelajaran digital.',
                'category' => 'technology',
                'icon' => 'fas fa-wifi',
                'sort_order' => 8,
                'is_active' => true,
                'is_featured' => false
            ]
        ];

        foreach ($facilities as $facility) {
            Facility::create($facility);
        }
    }
}
