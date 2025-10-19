<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Accreditation;

class AccreditationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Accreditation::create([
            'status' => 'Terakreditasi A',
            'certificate_number' => 'BAN-SM-2023-001',
            'year' => 2023,
            'score' => 95,
            'valid_until' => '2023-2028',
            'description' => 'Sekolah telah mendapatkan akreditasi A dengan skor 95 dari Badan Akreditasi Nasional Sekolah/Madrasah',
            'is_active' => true
        ]);
    }
}
