<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;
use App\Models\Course;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create sample courses
        $courses = ['Mathematics', 'Science', 'English', 'History', 'Computer Science'];
        foreach ($courses as $course) {
            Course::create(['name' => $course]);
        }

       
        Student::factory(10)->create()->each(function ($student) {
            $student->courses()->attach(
                Course::inRandomOrder()->take(rand(1, 3))->pluck('id')
            );
        });
    }
}
