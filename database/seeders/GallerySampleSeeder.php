<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Gallery;
use App\Models\GalleryItem;

class GallerySampleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create sample galleries
        $galleries = [
            [
                'title' => 'Kegiatan Upacara Bendera',
                'description' => 'Dokumentasi kegiatan upacara bendera setiap hari Senin yang diikuti oleh seluruh siswa dan guru.',
                'type' => 'photo',
                'category' => 'kegiatan',
                'status' => 'published',
                'is_featured' => true,
                'is_public' => true,
                'sort_order' => 1,
                'cover_image' => 'uploads/gallery/upacara-bendera.jpg'
            ],
            [
                'title' => 'Lomba 17 Agustus',
                'description' => 'Berbagai lomba yang diadakan dalam rangka memperingati HUT Kemerdekaan RI ke-78.',
                'type' => 'photo',
                'category' => 'event',
                'status' => 'published',
                'is_featured' => true,
                'is_public' => true,
                'sort_order' => 2,
                'cover_image' => 'uploads/gallery/lomba-17-agustus.jpg'
            ],
            [
                'title' => 'Kegiatan Ekstrakurikuler',
                'description' => 'Aktivitas ekstrakurikuler yang diikuti siswa untuk mengembangkan bakat dan minat.',
                'type' => 'photo',
                'category' => 'kegiatan',
                'status' => 'published',
                'is_featured' => true,
                'is_public' => true,
                'sort_order' => 3,
                'cover_image' => 'uploads/gallery/ekstrakurikuler.jpg'
            ],
            [
                'title' => 'Prestasi Siswa',
                'description' => 'Berbagai prestasi yang diraih siswa dalam berbagai kompetisi dan lomba.',
                'type' => 'photo',
                'category' => 'prestasi',
                'status' => 'published',
                'is_featured' => true,
                'is_public' => true,
                'sort_order' => 4,
                'cover_image' => 'uploads/gallery/prestasi-siswa.jpg'
            ],
            [
                'title' => 'Fasilitas Sekolah',
                'description' => 'Berbagai fasilitas yang tersedia di SMP Negeri 01 Namrole untuk mendukung proses pembelajaran.',
                'type' => 'photo',
                'category' => 'fasilitas',
                'status' => 'published',
                'is_featured' => false,
                'is_public' => true,
                'sort_order' => 5,
                'cover_image' => 'uploads/gallery/fasilitas-sekolah.jpg'
            ],
            [
                'title' => 'Kegiatan Pramuka',
                'description' => 'Aktivitas kepramukaan yang membentuk karakter dan kedisiplinan siswa.',
                'type' => 'photo',
                'category' => 'kegiatan',
                'status' => 'published',
                'is_featured' => false,
                'is_public' => true,
                'sort_order' => 6,
                'cover_image' => 'uploads/gallery/pramuka.jpg'
            ],
            [
                'title' => 'Kegiatan Olahraga',
                'description' => 'Berbagai kegiatan olahraga yang diadakan untuk menjaga kesehatan dan kebugaran siswa.',
                'type' => 'photo',
                'category' => 'kegiatan',
                'status' => 'published',
                'is_featured' => false,
                'is_public' => true,
                'sort_order' => 7,
                'cover_image' => 'uploads/gallery/olahraga.jpg'
            ]
        ];

        foreach ($galleries as $galleryData) {
            $gallery = Gallery::create($galleryData);
            
            // Create sample gallery items for each gallery
            $this->createGalleryItems($gallery);
        }
    }

    private function createGalleryItems($gallery)
    {
        $items = [
            [
                'title' => 'Foto 1',
                'description' => 'Dokumentasi kegiatan ' . $gallery->title,
                'file_path' => 'uploads/gallery/' . strtolower(str_replace(' ', '-', $gallery->title)) . '-1.jpg',
                'file_type' => 'image',
                'mime_type' => 'image/jpeg',
                'file_size' => 1024000,
                'width' => 1920,
                'height' => 1080,
                'sort_order' => 1,
                'is_featured' => true
            ],
            [
                'title' => 'Foto 2',
                'description' => 'Dokumentasi kegiatan ' . $gallery->title,
                'file_path' => 'uploads/gallery/' . strtolower(str_replace(' ', '-', $gallery->title)) . '-2.jpg',
                'file_type' => 'image',
                'mime_type' => 'image/jpeg',
                'file_size' => 1200000,
                'width' => 1920,
                'height' => 1080,
                'sort_order' => 2,
                'is_featured' => false
            ],
            [
                'title' => 'Foto 3',
                'description' => 'Dokumentasi kegiatan ' . $gallery->title,
                'file_path' => 'uploads/gallery/' . strtolower(str_replace(' ', '-', $gallery->title)) . '-3.jpg',
                'file_type' => 'image',
                'mime_type' => 'image/jpeg',
                'file_size' => 980000,
                'width' => 1920,
                'height' => 1080,
                'sort_order' => 3,
                'is_featured' => false
            ]
        ];

        foreach ($items as $itemData) {
            $itemData['gallery_id'] = $gallery->id;
            GalleryItem::create($itemData);
        }
    }
}