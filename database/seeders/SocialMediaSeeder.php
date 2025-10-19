<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SocialMedia;

class SocialMediaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $socialMediaData = [
            [
                'name' => 'Facebook',
                'icon' => 'facebook',
                'url' => 'https://facebook.com/smpnegeri01namrole',
                'color' => '#1877F2',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Instagram',
                'icon' => 'instagram',
                'url' => 'https://instagram.com/smpnegeri01namrole',
                'color' => '#E4405F',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'YouTube',
                'icon' => 'youtube',
                'url' => 'https://youtube.com/@smpnegeri01namrole',
                'color' => '#FF0000',
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'WhatsApp',
                'icon' => 'whatsapp',
                'url' => 'https://wa.me/6281234567890',
                'color' => '#25D366',
                'is_active' => true,
                'sort_order' => 4,
            ],
        ];

        foreach ($socialMediaData as $data) {
            SocialMedia::create($data);
        }
    }
}
