<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Contact;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Contact::create([
            'address' => "Jl. Pendidikan No. 123\nNamrole, Maluku Tengah",
            'phone' => '(0911) 123456',
            'email' => 'smp01namrole@email.com',
            'website' => 'smpnegeri01namrole.sch.id',
            'is_active' => true,
        ]);
    }
}
