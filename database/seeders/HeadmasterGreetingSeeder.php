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
            'headmaster_name' => 'MUHAMMAD SAID BUTON, SH.,Gr',
            'greeting_message' => 'Assalamualaikum Warahmatullahi Wabarakatuh.

Selamat datang di website SMP Negeri 01 Namrole. Puji dan syukur kehadirat Allah SWT, Tuhan Yang Maha Esa. Alhamdulillah terima kasih atas kepercayaan dan amanat yang diembankan kepada saya untuk menahkodai Pendidikan di SMP Negeri 01 Namrole.

Sebagai Kepala Sekolah, saya berkomitmen untuk memajukan pendidikan di SMP Negeri 01 Namrole dengan memberikan pelayanan terbaik kepada seluruh siswa, guru, dan masyarakat. Kami berusaha menciptakan lingkungan belajar yang kondusif, nyaman, dan mendukung pengembangan potensi setiap siswa.

SMP Negeri 01 Namrole memiliki visi untuk menjadi sekolah unggul yang menghasilkan lulusan berkarakter, berprestasi, dan berdaya saing global. Dengan dukungan tenaga pendidik yang profesional, fasilitas yang memadai, dan kurikulum yang terintegrasi, kami berusaha mewujudkan visi tersebut.

Kami percaya bahwa pendidikan adalah investasi terbaik untuk masa depan. Oleh karena itu, kami terus berinovasi dalam metode pembelajaran dan mengembangkan program-program yang mendukung pengembangan diri siswa secara holistik.

Mari bersama-sama membangun generasi yang cerdas, berkarakter, dan berdaya saing global.

Wassalamualaikum Warahmatullahi Wabarakatuh.',
            'photo' => null,
            'is_active' => true
        ]);
    }
}
