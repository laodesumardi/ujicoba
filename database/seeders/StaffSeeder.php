<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class StaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create sample teachers
        $teachers = [
            [
                'name' => 'Dr. Siti Aminah, S.Pd., M.Pd.',
                'email' => 'siti.aminah@smpn01namrole.sch.id',
                'phone' => '081234567890',
                'gender' => 'Perempuan',
                'religion' => 'Islam',
                'date_of_birth' => '1980-05-15',
                'subject' => 'Matematika',
                'position' => 'Guru Matematika',
                'employment_status' => 'Guru Honorer',
                'join_date' => '2010-08-01',
                'education' => 'S2 Pendidikan Matematika',
                'certification' => 'Sertifikat Pendidik',
                'experience_years' => 14,
                'bio' => 'Guru matematika dengan pengalaman 14 tahun. Spesialisasi dalam pembelajaran matematika yang menyenangkan dan mudah dipahami.',
                'address' => 'Jl. Pendidikan No. 123, Namrole',
                'is_active' => true,
                'role' => 'teacher',
                'password' => Hash::make('password123')
            ],
            [
                'name' => 'Budi Santoso, S.Pd.',
                'email' => 'budi.santoso@smpn01namrole.sch.id',
                'phone' => '081234567891',
                'gender' => 'Laki-laki',
                'religion' => 'Islam',
                'date_of_birth' => '1985-03-20',
                'subject' => 'Bahasa Indonesia',
                'position' => 'Guru Bahasa Indonesia',
                'employment_status' => 'Guru Honorer',
                'join_date' => '2012-01-15',
                'education' => 'S1 Pendidikan Bahasa Indonesia',
                'certification' => 'Sertifikat Pendidik',
                'experience_years' => 12,
                'bio' => 'Guru bahasa Indonesia yang berdedikasi dalam mengembangkan kemampuan literasi siswa.',
                'address' => 'Jl. Merdeka No. 45, Namrole',
                'is_active' => true,
                'role' => 'teacher',
                'password' => Hash::make('password123')
            ],
            [
                'name' => 'Maria Magdalena, S.Pd.',
                'email' => 'maria.magdalena@smpn01namrole.sch.id',
                'phone' => '081234567892',
                'gender' => 'Perempuan',
                'religion' => 'Katolik',
                'date_of_birth' => '1982-12-10',
                'subject' => 'Bahasa Inggris',
                'position' => 'Guru Bahasa Inggris',
                'employment_status' => 'Guru Honorer',
                'join_date' => '2011-07-01',
                'education' => 'S1 Pendidikan Bahasa Inggris',
                'certification' => 'Sertifikat Pendidik',
                'experience_years' => 13,
                'bio' => 'Guru bahasa Inggris dengan sertifikasi internasional. Berpengalaman dalam mengajar bahasa Inggris untuk berbagai level.',
                'address' => 'Jl. Harmoni No. 78, Namrole',
                'is_active' => true,
                'role' => 'teacher',
                'password' => Hash::make('password123')
            ],
            [
                'name' => 'Ahmad Fauzi, S.Pd.',
                'email' => 'ahmad.fauzi@smpn01namrole.sch.id',
                'phone' => '081234567893',
                'gender' => 'Laki-laki',
                'religion' => 'Islam',
                'date_of_birth' => '1988-08-25',
                'subject' => 'IPA',
                'position' => 'Guru IPA',
                'employment_status' => 'Guru Honorer',
                'join_date' => '2013-08-01',
                'education' => 'S1 Pendidikan IPA',
                'certification' => 'Sertifikat Pendidik',
                'experience_years' => 11,
                'bio' => 'Guru IPA yang kreatif dalam mengembangkan eksperimen dan praktikum untuk siswa.',
                'address' => 'Jl. Sains No. 56, Namrole',
                'is_active' => true,
                'role' => 'teacher',
                'password' => Hash::make('password123')
            ],
            [
                'name' => 'Sri Wahyuni, S.Pd.',
                'email' => 'sri.wahyuni@smpn01namrole.sch.id',
                'phone' => '081234567894',
                'gender' => 'Perempuan',
                'religion' => 'Islam',
                'date_of_birth' => '1983-11-30',
                'subject' => 'IPS',
                'position' => 'Guru IPS',
                'employment_status' => 'Guru Honorer',
                'join_date' => '2010-08-01',
                'education' => 'S1 Pendidikan IPS',
                'certification' => 'Sertifikat Pendidik',
                'experience_years' => 14,
                'bio' => 'Guru IPS yang mengintegrasikan teknologi dalam pembelajaran untuk meningkatkan minat siswa.',
                'address' => 'Jl. Sosial No. 90, Namrole',
                'is_active' => true,
                'role' => 'teacher',
                'password' => Hash::make('password123')
            ]
        ];

        foreach ($teachers as $teacher) {
            User::create($teacher);
        }

        // Create sample admin staff
        $admins = [
            [
                'name' => 'Dr. John Doe, M.Pd.',
                'email' => 'john.doe@smpn01namrole.sch.id',
                'phone' => '081234567895',
                'gender' => 'Laki-laki',
                'religion' => 'Kristen',
                'date_of_birth' => '1975-06-15',
                'position' => 'Kepala Sekolah',
                'employment_status' => 'Guru Honorer',
                'join_date' => '2005-08-01',
                'education' => 'S2 Manajemen Pendidikan',
                'certification' => 'Sertifikat Kepala Sekolah',
                'experience_years' => 19,
                'bio' => 'Kepala sekolah yang visioner dengan pengalaman 19 tahun dalam dunia pendidikan. Berkomitmen untuk meningkatkan kualitas pendidikan di SMP Negeri 01 Namrole.',
                'address' => 'Jl. Kepemimpinan No. 1, Namrole',
                'is_active' => true,
                'role' => 'admin',
                'password' => Hash::make('password123')
            ],
            [
                'name' => 'Siti Nurhaliza, S.Pd.',
                'email' => 'siti.nurhaliza@smpn01namrole.sch.id',
                'phone' => '081234567896',
                'gender' => 'Perempuan',
                'religion' => 'Islam',
                'date_of_birth' => '1980-09-20',
                'position' => 'Wakil Kepala Sekolah',
                'employment_status' => 'Guru Honorer',
                'join_date' => '2008-01-15',
                'education' => 'S1 Administrasi Pendidikan',
                'certification' => 'Sertifikat Wakil Kepala Sekolah',
                'experience_years' => 16,
                'bio' => 'Wakil kepala sekolah yang handal dalam mengelola administrasi sekolah dan mendukung program-program pendidikan.',
                'address' => 'Jl. Administrasi No. 12, Namrole',
                'is_active' => true,
                'role' => 'admin',
                'password' => Hash::make('password123')
            ],
            [
                'name' => 'Bambang Sutrisno, S.E.',
                'email' => 'bambang.sutrisno@smpn01namrole.sch.id',
                'phone' => '081234567897',
                'gender' => 'Laki-laki',
                'religion' => 'Islam',
                'date_of_birth' => '1982-04-10',
                'position' => 'Bendahara Sekolah',
                'employment_status' => 'Guru Honorer',
                'join_date' => '2010-08-01',
                'education' => 'S1 Ekonomi',
                'certification' => 'Sertifikat Bendahara',
                'experience_years' => 14,
                'bio' => 'Bendahara sekolah yang profesional dalam mengelola keuangan sekolah dengan transparansi dan akuntabilitas.',
                'address' => 'Jl. Keuangan No. 34, Namrole',
                'is_active' => true,
                'role' => 'admin',
                'password' => Hash::make('password123')
            ]
        ];

        foreach ($admins as $admin) {
            User::create($admin);
        }
    }
}
