<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin',
                'password' => bcrypt('password123'),
                'role' => 'admin',
            ]
        );

        // Create test user
        User::firstOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'User Test',
                'password' => bcrypt('password123'),
                'role' => 'user',
            ]
        );
    }
}
