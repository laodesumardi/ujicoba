<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Teacher;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teachers = [
            [
                'nip' => '196512121990031001',
                'name' => 'Dr. Ahmad Susanto, M.Pd',
                'email' => 'ahmad.susanto@smpnamrole.sch.id',
                'phone' => '081234567890',
                'address' => 'Jl. Pendidikan No. 15, Namrole',
                'birth_date' => '1965-12-12',
                'gender' => 'male',
                'subject' => 'Matematika',
                'education' => 'S2 Pendidikan Matematika',
                'education_level' => 'S2 Pendidikan Matematika',
                'position' => 'Kepala Sekolah',
                'join_date' => '1990-03-01',
                'bio' => 'Kepala Sekolah yang berpengalaman dalam bidang pendidikan selama 30 tahun.',
                'type' => 'teacher',
                'is_active' => true
            ],
            [
                'nip' => '197203151995032002',
                'name' => 'Siti Nurhaliza, S.Pd',
                'email' => 'siti.nurhaliza@smpnamrole.sch.id',
                'phone' => '081234567891',
                'address' => 'Jl. Merdeka No. 25, Namrole',
                'birth_date' => '1972-03-15',
                'gender' => 'female',
                'subject' => 'Bahasa Indonesia',
                'education' => 'S1 Pendidikan Bahasa Indonesia',
                'education_level' => 'S1 Pendidikan Bahasa Indonesia',
                'position' => 'Wakil Kepala Sekolah',
                'join_date' => '1995-03-01',
                'bio' => 'Wakil Kepala Sekolah yang ahli dalam bidang bahasa dan sastra Indonesia.',
                'type' => 'teacher',
                'is_active' => true
            ],
            [
                'nip' => '198005201998031003',
                'name' => 'Budi Santoso, S.Pd',
                'email' => 'budi.santoso@smpnamrole.sch.id',
                'phone' => '081234567892',
                'address' => 'Jl. Sudirman No. 10, Namrole',
                'birth_date' => '1980-05-20',
                'gender' => 'male',
                'subject' => 'IPA',
                'education' => 'S1 Pendidikan IPA',
                'education_level' => 'S1 Pendidikan IPA',
                'position' => 'Guru',
                'join_date' => '1998-03-01',
                'bio' => 'Guru IPA yang kreatif dan inovatif dalam pembelajaran.',
                'type' => 'teacher',
                'is_active' => true
            ],
            [
                'nip' => '198512101999032004',
                'name' => 'Rina Wulandari, S.Pd',
                'email' => 'rina.wulandari@smpnamrole.sch.id',
                'phone' => '081234567893',
                'address' => 'Jl. Gatot Subroto No. 5, Namrole',
                'birth_date' => '1985-12-10',
                'gender' => 'female',
                'subject' => 'Bahasa Inggris',
                'education' => 'S1 Pendidikan Bahasa Inggris',
                'education_level' => 'S1 Pendidikan Bahasa Inggris',
                'position' => 'Guru',
                'join_date' => '1999-03-01',
                'bio' => 'Guru Bahasa Inggris yang berpengalaman dalam mengajar siswa SMP.',
                'type' => 'teacher',
                'is_active' => true
            ],
            [
                'nip' => '199003152005031005',
                'name' => 'Eko Prasetyo, S.Pd',
                'email' => 'eko.prasetyo@smpnamrole.sch.id',
                'phone' => '081234567894',
                'address' => 'Jl. Diponegoro No. 20, Namrole',
                'birth_date' => '1990-03-15',
                'gender' => 'male',
                'subject' => 'IPS',
                'education' => 'S1 Pendidikan IPS',
                'education_level' => 'S1 Pendidikan IPS',
                'position' => 'Guru',
                'join_date' => '2005-03-01',
                'bio' => 'Guru IPS yang aktif dalam kegiatan ekstrakurikuler.',
                'type' => 'teacher',
                'is_active' => true
            ]
        ];

        foreach ($teachers as $teacher) {
            // Add password and role to each teacher
            $teacher['password'] = bcrypt('password123');
            $teacher['role'] = 'teacher';
            
            Teacher::updateOrCreate(
                ['nip' => $teacher['nip']],
                $teacher
            );
        }
    }
}
