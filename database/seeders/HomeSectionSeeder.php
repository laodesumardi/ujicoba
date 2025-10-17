<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\HomeSection;

class HomeSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sections = [
            [
                'section_key' => 'hero',
                'title' => 'Selamat Datang di SMP Negeri 01 Namrole',
                'subtitle' => 'Sekolah Unggul Berkarakter, Berprestasi, dan Berdaya Saing Global',
                'description' => 'Bergabunglah dengan kami dalam perjalanan pendidikan yang menginspirasi dan membentuk karakter siswa yang unggul.',
                'image' => null, // Will be uploaded via admin
                'image_alt' => 'SMP Negeri 01 Namrole - Hero Image',
                'image_position' => 'right',
                'button_text' => 'Lihat Profil Sekolah',
                'button_link' => '/profil',
                'background_color' => 'bg-gradient-to-r from-primary-500 to-primary-600',
                'text_color' => 'text-white',
                'is_active' => true,
                'sort_order' => 1
            ],
            [
                'section_key' => 'quick_info',
                'title' => 'Keunggulan Sekolah Kami',
                'subtitle' => 'Mengapa memilih SMP Negeri 01 Namrole?',
                'description' => 'Kami berkomitmen memberikan pendidikan terbaik dengan fasilitas modern dan tenaga pendidik berkualitas.',
                'image' => null,
                'image_alt' => 'Keunggulan Sekolah',
                'image_position' => 'center',
                'button_text' => null,
                'button_link' => null,
                'background_color' => 'bg-gray-50',
                'text_color' => 'text-gray-900',
                'is_active' => true,
                'sort_order' => 2
            ],
            [
                'section_key' => 'about',
                'title' => 'Tentang SMP Negeri 01 Namrole',
                'subtitle' => 'Membangun Generasi Unggul Sejak 1985',
                'description' => 'SMP Negeri 01 Namrole telah berdiri sejak tahun 1985 dengan komitmen untuk memberikan pendidikan berkualitas dan membentuk karakter siswa yang unggul. Dengan dukungan penuh dari masyarakat dan pemerintah daerah, kami terus berkembang menjadi salah satu institusi pendidikan terkemuka di daerah ini.',
                'image' => null,
                'image_alt' => 'Tentang Sekolah',
                'image_position' => 'left',
                'button_text' => 'Pelajari Lebih Lanjut',
                'button_link' => '/profil',
                'background_color' => 'bg-white',
                'text_color' => 'text-gray-900',
                'is_active' => true,
                'sort_order' => 3
            ],
            [
                'section_key' => 'guru_berkualitas',
                'title' => 'Guru Berkualitas',
                'subtitle' => 'Tenaga pendidik berpengalaman dan berkompeten',
                'description' => 'Tim pendidik kami terdiri dari guru-guru berpengalaman dan berkompeten yang siap membimbing siswa menuju prestasi terbaik.',
                'image' => null,
                'image_alt' => 'Guru Berkualitas',
                'image_position' => 'center',
                'button_text' => null,
                'button_link' => null,
                'background_color' => 'bg-white',
                'text_color' => 'text-gray-900',
                'is_active' => true,
                'sort_order' => 4
            ],
            [
                'section_key' => 'akreditasi_a',
                'title' => 'Akreditasi A',
                'subtitle' => 'Sekolah terakreditasi A dengan skor 95',
                'description' => 'SMP Negeri 01 Namrole telah meraih akreditasi A dengan skor 95, membuktikan kualitas pendidikan yang tinggi dan standar yang terbaik.',
                'image' => null,
                'image_alt' => 'Akreditasi A',
                'image_position' => 'center',
                'button_text' => null,
                'button_link' => null,
                'background_color' => 'bg-white',
                'text_color' => 'text-gray-900',
                'is_active' => true,
                'sort_order' => 5
            ],
            [
                'section_key' => 'fasilitas_lengkap',
                'title' => 'Fasilitas Lengkap',
                'subtitle' => 'Fasilitas pembelajaran yang modern dan memadai',
                'description' => 'Kami menyediakan fasilitas pembelajaran yang modern dan memadai untuk mendukung proses belajar mengajar yang optimal.',
                'image' => null,
                'image_alt' => 'Fasilitas Lengkap',
                'image_position' => 'center',
                'button_text' => null,
                'button_link' => null,
                'background_color' => 'bg-white',
                'text_color' => 'text-gray-900',
                'is_active' => true,
                'sort_order' => 6
            ]
        ];

        foreach ($sections as $section) {
            HomeSection::updateOrCreate(
                ['section_key' => $section['section_key']],
                $section
            );
        }
    }
}