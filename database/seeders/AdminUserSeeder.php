<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin Plakat Indonesia',
            'email' => 'admin@plakatindonesia.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        // Create sample regular user
        User::create([
            'name' => 'User Test',
            'email' => 'user@test.com',
            'password' => Hash::make('user123'),
            'role' => 'user',
        ]);
    }
}