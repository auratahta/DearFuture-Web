<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subjects = [
            [
                'name' => 'BIG DEALS',
                'category' => 'Special',
                'description' => 'Special discounts and deals for students',
                'icon' => 'Big Sale.png',
                'is_active' => true,
                'display_order' => 0,
                'color_code' => '#FF5C5C',
            ],
            [
                'name' => 'SNBT',
                'category' => 'Special',
                'description' => 'Seleksi Nasional Berbasis Tes untuk persiapan ujian masuk PT',
                'icon' => 'Snbt.png',
                'is_active' => true,
                'display_order' => 1,
                'color_code' => '#FFA64D',
            ],
            [
                'name' => 'Math',
                'category' => 'Mathematics',
                'description' => 'Mathematics subjects including algebra, geometry, calculus, and statistics',
                'icon' => 'math.png',
                'is_active' => true,
                'display_order' => 2,
                'color_code' => '#5E81AC',
            ],
            [
                'name' => 'Physics',
                'category' => 'Science',
                'description' => 'Study of matter, energy, and the interaction between them',
                'icon' => 'physics.png',
                'is_active' => true,
                'display_order' => 3,
                'color_code' => '#81A1C1',
            ],
            [
                'name' => 'Chemistry',
                'category' => 'Science',
                'description' => 'Study of the composition, structure, properties, and change of matter',
                'icon' => 'chemistry.png',
                'is_active' => true,
                'display_order' => 4,
                'color_code' => '#88C0D0',
            ],
            [
                'name' => 'Biology',
                'category' => 'Science',
                'description' => 'Study of living organisms and their interactions with each other and their environment',
                'icon' => 'biology.png',
                'is_active' => true,
                'display_order' => 5,
                'color_code' => '#8FBCBB',
            ],
            [
                'name' => 'Bahasa Indonesia',
                'category' => 'Languages',
                'description' => 'Indonesian language and literature',
                'icon' => 'indonesian.png',
                'is_active' => true,
                'display_order' => 6,
                'color_code' => '#A3BE8C',
            ],
            [
                'name' => 'English',
                'category' => 'Languages',
                'description' => 'English language and literature',
                'icon' => 'english.png',
                'is_active' => true,
                'display_order' => 7,
                'color_code' => '#B48EAD',
            ],
            [
                'name' => 'History',
                'category' => 'Social Studies',
                'description' => 'Study of past events, particularly human affairs',
                'icon' => 'history.png',
                'is_active' => true,
                'display_order' => 8,
                'color_code' => '#D08770',
            ],
            [
                'name' => 'Economics',
                'category' => 'Social Studies',
                'description' => 'Study of how societies use scarce resources to produce valuable goods and services',
                'icon' => 'economics.png',
                'is_active' => true,
                'display_order' => 9,
                'color_code' => '#EBCB8B',
            ],
            [
                'name' => 'Geography',
                'category' => 'Social Studies',
                'description' => 'Study of places and the relationships between people and their environments',
                'icon' => 'geography.png',
                'is_active' => true,
                'display_order' => 10,
                'color_code' => '#E08880',
            ],
            [
                'name' => 'Sociology',
                'category' => 'Social Studies',
                'description' => 'Study of society, patterns of social relationships, social interaction, and culture',
                'icon' => 'sosiology.png',
                'is_active' => true,
                'display_order' => 11,
                'color_code' => '#BF616A',
            ],
        ];
        
        foreach ($subjects as $subject) {
            Subject::create($subject);
        }
    }
}