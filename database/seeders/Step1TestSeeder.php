<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Subject;
use App\Models\MentoringSession;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class Step1TestSeederSafe extends Seeder
{
    public function run()
    {
        $this->command->info('Creating test users...');

        // 1. Create Admin
        $admin = User::updateOrCreate([
            'email' => 'admin@dearfuture.com'
        ], [
            'name' => 'Admin DearFuture',
            'role' => 'admin',
            'password' => Hash::make('password'),
            'is_active' => true,
            'phone' => '081234567890'
        ]);

        // 2. Create Mentors
        $mentor1 = User::updateOrCreate([
            'email' => 'mentor1@dearfuture.com'
        ], [
            'name' => 'Dr. Sarah - Math Expert',
            'role' => 'mentor',
            'password' => Hash::make('password'),
            'is_active' => true,
            'phone' => '081234567891',
            'bio' => 'Expert in Mathematics with 10+ years experience'
        ]);

        $mentor2 = User::updateOrCreate([
            'email' => 'mentor2@dearfuture.com'
        ], [
            'name' => 'Prof. Ahmad - Physics Specialist',
            'role' => 'mentor',
            'password' => Hash::make('password'),
            'is_active' => true,
            'phone' => '081234567892',
            'bio' => 'Physics Professor and Research Scientist'
        ]);

        // 3. Create Student
        $student = User::updateOrCreate([
            'email' => 'student@dearfuture.com'
        ], [
            'name' => 'Aura Tahta',
            'role' => 'pelajar',
            'password' => Hash::make('password'),
            'is_active' => true,
            'phone' => '081234567893'
        ]);

        $this->command->info('Creating test subjects...');

        // 4. Create NEW Test Subjects (beda dari yang lama)
        $math = Subject::updateOrCreate([
            'name' => 'Matematika Test'
        ], [
            'category' => 'Exact Sciences',
            'description' => 'Pelajari matematika dari dasar hingga advanced',
            'display_order' => 10,
            'is_active' => true,
            'icon' => 'math.png'
        ]);

        $physics = Subject::updateOrCreate([
            'name' => 'Fisika Test'
        ], [
            'category' => 'Exact Sciences', 
            'description' => 'Fisika untuk SMA dan persiapan ujian',
            'display_order' => 11,
            'is_active' => true,
            'icon' => 'physics.png'
        ]);

        $this->command->info('Assigning mentors to subjects...');

        // 5. Assign Mentors to Subjects (pivot table)
        DB::table('mentor_subjects')->updateOrInsert([
            'mentor_id' => $mentor1->id,
            'subject_id' => $math->id
        ], [
            'price_per_hour' => 50000,
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('mentor_subjects')->updateOrInsert([
            'mentor_id' => $mentor2->id,
            'subject_id' => $physics->id
        ], [
            'price_per_hour' => 60000,
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $this->command->info('Creating available sessions...');

        // 6. Create Available Sessions
        $sessions = [
            [
                'mentor_id' => $mentor1->id,
                'subject_id' => $math->id,
                'date' => now()->addDays(1)->toDateString(),
                'start_time' => '09:00:00',
                'end_time' => '10:00:00',
                'price' => 50000
            ],
            [
                'mentor_id' => $mentor1->id,
                'subject_id' => $math->id,
                'date' => now()->addDays(1)->toDateString(),
                'start_time' => '10:00:00',
                'end_time' => '11:00:00',
                'price' => 50000
            ],
            [
                'mentor_id' => $mentor2->id,
                'subject_id' => $physics->id,
                'date' => now()->addDays(2)->toDateString(),
                'start_time' => '14:00:00',
                'end_time' => '15:00:00',
                'price' => 60000
            ]
        ];

        foreach ($sessions as $sessionData) {
            MentoringSession::updateOrCreate([
                'mentor_id' => $sessionData['mentor_id'],
                'subject_id' => $sessionData['subject_id'],
                'date' => $sessionData['date'],
                'start_time' => $sessionData['start_time'],
            ], [
                'student_id' => null, // PENTING: null = available slot
                'end_time' => $sessionData['end_time'],
                'price' => $sessionData['price'],
                'status' => 'available', // PENTING: status available
                'notes' => 'Available slot created by seeder'
            ]);
        }

        $this->command->info('✅ Step 1 test data created successfully!');
        $this->command->info('🔑 Login credentials:');
        $this->command->info('   Admin: admin@dearfuture.com / password');
        $this->command->info('   Student: student@dearfuture.com / password');
        $this->command->info('   Mentor1: mentor1@dearfuture.com / password');
        $this->command->info('   Mentor2: mentor2@dearfuture.com / password');
    }
}