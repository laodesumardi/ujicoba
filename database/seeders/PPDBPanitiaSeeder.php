<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class PPDBPanitiaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create directory for panitia photos if it doesn't exist
        if (!Storage::disk('public')->exists('ppdb_panitia/photos')) {
            Storage::disk('public')->makeDirectory('ppdb_panitia/photos');
        }

        // Create default panitia users
        $panitiaUsers = [
            [
                'name' => 'Dr. Siti Aminah, M.Pd',
                'email' => 'panitia1@smpnegeri01namrole.sch.id',
                'password' => Hash::make('panitia123'),
                'phone' => '081234567890',
                'address' => 'Jl. Pendidikan No. 1, Namrole, Buru Selatan',
                'bio' => 'Kepala Sekolah SMP Negeri 01 Namrole dengan pengalaman 15 tahun di bidang pendidikan. Memiliki visi untuk meningkatkan kualitas pendidikan di daerah Buru Selatan.',
                'role' => 'ppdb_panitia',
                'photo' => 'ppdb_panitia/photos/default-panitia-1.png',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Budi Santoso, S.Pd',
                'email' => 'panitia2@smpnegeri01namrole.sch.id',
                'password' => Hash::make('panitia123'),
                'phone' => '081234567891',
                'address' => 'Jl. Merdeka No. 15, Namrole, Buru Selatan',
                'bio' => 'Wakil Kepala Sekolah Bidang Kesiswaan. Berpengalaman dalam mengelola kegiatan siswa dan penerimaan peserta didik baru.',
                'role' => 'ppdb_panitia',
                'photo' => 'ppdb_panitia/photos/default-panitia-2.png',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Sari Indah, S.Pd',
                'email' => 'panitia3@smpnegeri01namrole.sch.id',
                'password' => Hash::make('panitia123'),
                'phone' => '081234567892',
                'address' => 'Jl. Kartini No. 8, Namrole, Buru Selatan',
                'bio' => 'Guru Bimbingan Konseling yang bertanggung jawab dalam proses seleksi dan orientasi siswa baru.',
                'role' => 'ppdb_panitia',
                'photo' => 'ppdb_panitia/photos/default-panitia-3.png',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Ahmad Rizki, S.Pd',
                'email' => 'panitia4@smpnegeri01namrole.sch.id',
                'password' => Hash::make('panitia123'),
                'phone' => '081234567893',
                'address' => 'Jl. Sudirman No. 22, Namrole, Buru Selatan',
                'bio' => 'Guru Matematika yang aktif dalam kegiatan administrasi sekolah dan penerimaan siswa baru.',
                'role' => 'ppdb_panitia',
                'photo' => 'ppdb_panitia/photos/default-panitia-4.png',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Maya Sari, S.Pd',
                'email' => 'panitia5@smpnegeri01namrole.sch.id',
                'password' => Hash::make('panitia123'),
                'phone' => '081234567894',
                'address' => 'Jl. Gatot Subroto No. 5, Namrole, Buru Selatan',
                'bio' => 'Guru Bahasa Indonesia yang bertugas sebagai sekretaris panitia PPDB dan mengelola dokumentasi pendaftaran.',
                'role' => 'ppdb_panitia',
                'photo' => 'ppdb_panitia/photos/default-panitia-5.png',
                'email_verified_at' => now(),
            ]
        ];

        foreach ($panitiaUsers as $userData) {
            // Check if user already exists
            $existingUser = User::where('email', $userData['email'])->first();
            
            if (!$existingUser) {
                // Create user
                $user = User::create($userData);
                
                // Create default photo if it doesn't exist
                $photoPath = $userData['photo'];
                if (!Storage::disk('public')->exists($photoPath)) {
                    $this->createDefaultPhoto($photoPath);
                }
                
                $this->command->info("Created panitia user: {$user->name} ({$user->email})");
            } else {
                $this->command->info("User already exists: {$userData['email']}");
            }
        }

        $this->command->info('PPDB Panitia users seeded successfully!');
        $this->command->info('Default password for all panitia users: panitia123');
    }

    /**
     * Create a default photo for panitia users
     */
    private function createDefaultPhoto($photoPath)
    {
        // Create a simple default image using GD
        $width = 200;
        $height = 200;
        
        // Create image
        $image = imagecreate($width, $height);
        
        // Define colors
        $bgColor = imagecolorallocate($image, 59, 130, 246); // Blue background
        $textColor = imagecolorallocate($image, 255, 255, 255); // White text
        
        // Fill background
        imagefill($image, 0, 0, $bgColor);
        
        // Add text
        $text = 'PPDB';
        $fontSize = 5;
        $textWidth = imagefontwidth($fontSize) * strlen($text);
        $textHeight = imagefontheight($fontSize);
        $x = ($width - $textWidth) / 2;
        $y = ($height - $textHeight) / 2;
        
        imagestring($image, $fontSize, $x, $y, $text, $textColor);
        
        // Save image
        $tempPath = sys_get_temp_dir() . '/temp_panitia_photo.png';
        imagepng($image, $tempPath);
        
        // Store in public storage
        $contents = file_get_contents($tempPath);
        Storage::disk('public')->put($photoPath, $contents);
        
        // Clean up
        unlink($tempPath);
        imagedestroy($image);
    }
}