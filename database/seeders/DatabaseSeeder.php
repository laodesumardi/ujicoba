<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        User::factory()->create([
            'name' => 'Admin SMP Namrole',
            'email' => 'admin@smpnamrole.com',
            'password' => bcrypt('admin123'),
        ]);

        // Seed home sections
        $this->call([
            HomeSectionSeeder::class,
            SchoolProfileSeeder::class,
            NewsSeeder::class,
        ]);
    }
}
