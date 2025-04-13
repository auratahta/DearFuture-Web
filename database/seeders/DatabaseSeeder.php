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
    // database/seeders/UsersTableSeeder.php
public function run()
{
    \App\Models\User::create([
        'name' => 'Admin',
        'email' => 'admin@dearfuture.com',
        'password' => Hash::make('password123'),
        'role' => 'admin',
    ]);
    
    // Tambahkan user mentor dan pelajar juga
}
}
