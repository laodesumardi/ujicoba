<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\HeadmasterGreeting;

class HeadmasterGreetingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        HeadmasterGreeting::create([
            'headmaster_name' => 'Dr. Siti Nurhaliza, M.Pd.',
            'greeting_message' => 'Assalamualaikum Warahmatullahi Wabarakatuh.

Selamat datang di website resmi SMP Negeri 01 Namrole. Sebagai Kepala Sekolah, saya mengucapkan terima kasih kepada semua pihak yang telah mendukung dan mempercayai SMP Negeri 01 Namrole sebagai tempat pendidikan putra-putri tercinta.

SMP Negeri 01 Namrole berkomitmen untuk memberikan pendidikan yang berkualitas, membentuk karakter siswa yang berakhlak mulia, dan mempersiapkan generasi yang siap menghadapi tantangan masa depan. Dengan dukungan guru-guru yang profesional, fasilitas yang memadai, dan kurikulum yang terintegrasi, kami berusaha menciptakan lingkungan belajar yang kondusif dan menyenangkan.

Kami percaya bahwa setiap siswa memiliki potensi unik yang dapat dikembangkan melalui pendidikan yang tepat. Oleh karena itu, kami terus berinovasi dalam metode pembelajaran dan mengembangkan program-program yang mendukung pengembangan diri siswa.

Mari bersama-sama membangun generasi yang cerdas, berkarakter, dan berdaya saing global.

Wassalamualaikum Warahmatullahi Wabarakatuh.',
            'photo' => null,
            'is_active' => true
        ]);
    }
}
