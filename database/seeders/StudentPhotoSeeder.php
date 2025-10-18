<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class StudentPhotoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all students
        $students = User::where('role', 'student')->get();
        
        foreach ($students as $student) {
            // Create a sample photo path (you can replace this with actual photo upload)
            $photoPath = 'students/photos/' . $student->id . '.jpg';
            
            // For demo purposes, we'll just set a placeholder path
            // In real implementation, you would upload actual photos
            $student->photo = $photoPath;
            $student->save();
            
            echo "Set photo for student: {$student->name} - {$photoPath}\n";
        }
    }
}