<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SchoolProfile;

class SchoolProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sections = [
            [
                'section_key' => 'sejarah',
                'content' => 'SMP Negeri 01 Namrole didirikan pada tahun 1985 dengan tujuan memberikan pendidikan berkualitas kepada masyarakat Namrole dan sekitarnya. Sekolah ini telah berkembang menjadi salah satu sekolah unggulan di wilayah tersebut.',
                'is_active' => true,
                'sort_order' => 1
            ],
            [
                'section_key' => 'visi-misi',
                'content' => 'Visi: Menjadi sekolah unggul yang berkarakter, berprestasi, dan berdaya saing global. Misi: 1. Menyelenggarakan pendidikan berkualitas, 2. Membentuk karakter siswa yang baik, 3. Mengembangkan potensi siswa secara optimal, 4. Menciptakan lingkungan belajar yang kondusif.',
                'is_active' => true,
                'sort_order' => 2
            ],
            [
                'section_key' => 'struktur',
                'content' => 'Struktur organisasi SMP Negeri 01 Namrole terdiri dari Kepala Sekolah, Wakil Kepala Sekolah, Koordinator Kurikulum, Koordinator Kesiswaan, Koordinator Sarana Prasarana, dan Guru-guru yang kompeten di bidangnya masing-masing.',
                'is_active' => true,
                'sort_order' => 3
            ],
            [
                'section_key' => 'tenaga-pendidik',
                'content' => 'SMP Negeri 01 Namrole memiliki tenaga pendidik yang berkualitas dan berpengalaman. Semua guru telah memenuhi kualifikasi akademik dan memiliki sertifikasi pendidik. Mereka berkomitmen untuk memberikan pendidikan terbaik kepada siswa.',
                'is_active' => true,
                'sort_order' => 4
            ],
            [
                'section_key' => 'akreditasi',
                'content' => 'SMP Negeri 01 Namrole telah terakreditasi A dengan skor 95. Akreditasi ini menunjukkan kualitas pendidikan yang tinggi dan komitmen sekolah dalam memberikan pelayanan terbaik kepada siswa dan masyarakat.',
                'is_active' => true,
                'sort_order' => 5
            ]
        ];

        foreach ($sections as $section) {
            SchoolProfile::updateOrCreate(
                ['section_key' => $section['section_key']],
                $section
            );
        }
    }
}
