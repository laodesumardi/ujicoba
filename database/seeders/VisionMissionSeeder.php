<?php

namespace Database\Seeders;

use App\Models\VisionMission;
use Illuminate\Database\Seeder;

class VisionMissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        VisionMission::create([
            'vision' => 'Menjadi sekolah unggul yang berkarakter, berprestasi, dan berdaya saing global.',
            'missions' => [
                'Menyelenggarakan pendidikan yang berkualitas dengan mengintegrasikan nilai-nilai karakter',
                'Mengembangkan potensi siswa melalui pembelajaran yang kreatif dan inovatif',
                'Membina hubungan yang harmonis antara sekolah, orang tua, dan masyarakat',
                'Menyediakan fasilitas pembelajaran yang memadai dan modern',
                'Membentuk siswa yang memiliki kepedulian sosial dan lingkungan'
            ],
            'is_active' => true,
        ]);
    }
}


