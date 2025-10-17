<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Gallery;
use App\Models\GalleryItem;

class GallerySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Gallery 1: Kegiatan Siswa
        $gallery1 = Gallery::updateOrCreate(
            ['slug' => 'kegiatan-siswa-smp-negeri-01-namrole'],
            [
                'title' => 'Kegiatan Siswa SMP Negeri 01 Namrole',
                'slug' => 'kegiatan-siswa-smp-negeri-01-namrole',
                'description' => 'Dokumentasi berbagai kegiatan siswa yang dilaksanakan di SMP Negeri 01 Namrole',
                'type' => 'photo',
                'category' => 'kegiatan',
                'status' => 'published',
                'is_featured' => true,
                'is_public' => true,
                'sort_order' => 1
            ]
        );

        // Gallery 2: Event Besar
        $gallery2 = Gallery::updateOrCreate(
            ['slug' => 'event-besar-sekolah'],
            [
                'title' => 'Event Besar Sekolah',
                'slug' => 'event-besar-sekolah',
                'description' => 'Dokumentasi event-event besar yang diselenggarakan oleh sekolah',
                'type' => 'mixed',
                'category' => 'event',
                'status' => 'published',
                'is_featured' => true,
                'is_public' => true,
                'sort_order' => 2
            ]
        );

        // Gallery 3: Profil Sekolah
        $gallery3 = Gallery::updateOrCreate(
            ['slug' => 'profil-sekolah'],
            [
                'title' => 'Profil Sekolah',
                'slug' => 'profil-sekolah',
                'description' => 'Video profil dan dokumentasi fasilitas sekolah',
                'type' => 'video',
                'category' => 'profil',
                'status' => 'published',
                'is_featured' => false,
                'is_public' => true,
                'sort_order' => 3
            ]
        );

        // Gallery 4: Testimoni
        $gallery4 = Gallery::updateOrCreate(
            ['slug' => 'testimoni-siswa-guru-alumni'],
            [
                'title' => 'Testimoni Siswa, Guru, dan Alumni',
                'slug' => 'testimoni-siswa-guru-alumni',
                'description' => 'Video testimoni dari siswa, guru, dan alumni SMP Negeri 01 Namrole',
                'type' => 'video',
                'category' => 'testimoni',
                'status' => 'published',
                'is_featured' => false,
                'is_public' => true,
                'sort_order' => 4
            ]
        );

        // Gallery 5: Prestasi
        $gallery5 = Gallery::updateOrCreate(
            ['slug' => 'prestasi-sekolah-dan-siswa'],
            [
                'title' => 'Prestasi Sekolah dan Siswa',
                'slug' => 'prestasi-sekolah-dan-siswa',
                'description' => 'Dokumentasi prestasi yang diraih oleh sekolah dan siswa',
                'type' => 'photo',
                'category' => 'prestasi',
                'status' => 'published',
                'is_featured' => true,
                'is_public' => true,
                'sort_order' => 5
            ]
        );

        // Gallery 6: Fasilitas
        $gallery6 = Gallery::updateOrCreate(
            ['slug' => 'fasilitas-sekolah'],
            [
                'title' => 'Fasilitas Sekolah',
                'slug' => 'fasilitas-sekolah',
                'description' => 'Dokumentasi fasilitas-fasilitas yang dimiliki sekolah',
                'type' => 'photo',
                'category' => 'fasilitas',
                'status' => 'published',
                'is_featured' => false,
                'is_public' => true,
                'sort_order' => 6
            ]
        );

        // Create sample gallery items for each gallery
        $this->createGalleryItems($gallery1, 'kegiatan');
        $this->createGalleryItems($gallery2, 'event');
        $this->createGalleryItems($gallery3, 'profil');
        $this->createGalleryItems($gallery4, 'testimoni');
        $this->createGalleryItems($gallery5, 'prestasi');
        $this->createGalleryItems($gallery6, 'fasilitas');
    }

    private function createGalleryItems($gallery, $type)
    {
        $items = [
            'kegiatan' => [
                ['title' => 'Upacara Bendera', 'file_type' => 'image'],
                ['title' => 'Kegiatan Pramuka', 'file_type' => 'image'],
                ['title' => 'Lomba Antar Kelas', 'file_type' => 'image'],
                ['title' => 'Kegiatan OSIS', 'file_type' => 'image'],
            ],
            'event' => [
                ['title' => 'Hari Kemerdekaan', 'file_type' => 'image'],
                ['title' => 'Peringatan Hari Besar', 'file_type' => 'video'],
                ['title' => 'Acara Wisuda', 'file_type' => 'image'],
                ['title' => 'Festival Sekolah', 'file_type' => 'video'],
            ],
            'profil' => [
                ['title' => 'Video Profil Sekolah', 'file_type' => 'video'],
                ['title' => 'Virtual Tour Sekolah', 'file_type' => 'video'],
                ['title' => 'Sejarah Sekolah', 'file_type' => 'video'],
            ],
            'testimoni' => [
                ['title' => 'Testimoni Siswa', 'file_type' => 'video'],
                ['title' => 'Testimoni Guru', 'file_type' => 'video'],
                ['title' => 'Testimoni Alumni', 'file_type' => 'video'],
            ],
            'prestasi' => [
                ['title' => 'Piala Prestasi', 'file_type' => 'image'],
                ['title' => 'Sertifikat Penghargaan', 'file_type' => 'image'],
                ['title' => 'Foto Prestasi Siswa', 'file_type' => 'image'],
            ],
            'fasilitas' => [
                ['title' => 'Laboratorium', 'file_type' => 'image'],
                ['title' => 'Perpustakaan', 'file_type' => 'image'],
                ['title' => 'Lapangan Olahraga', 'file_type' => 'image'],
                ['title' => 'Ruang Kelas', 'file_type' => 'image'],
            ]
        ];

        foreach ($items[$type] as $index => $item) {
            GalleryItem::updateOrCreate(
                [
                    'gallery_id' => $gallery->id,
                    'title' => $item['title']
                ],
                [
                    'description' => 'Deskripsi ' . $item['title'],
                    'file_path' => 'galleries/sample_' . $type . '_' . ($index + 1) . '.jpg',
                    'file_type' => $item['file_type'],
                    'mime_type' => $item['file_type'] === 'image' ? 'image/jpeg' : 'video/mp4',
                    'file_size' => rand(100000, 5000000),
                    'width' => $item['file_type'] === 'image' ? 1920 : 1280,
                    'height' => $item['file_type'] === 'image' ? 1080 : 720,
                    'duration' => $item['file_type'] === 'video' ? rand(60, 300) : null,
                    'sort_order' => $index + 1,
                    'is_featured' => $index === 0
                ]
            );
        }
    }
}
