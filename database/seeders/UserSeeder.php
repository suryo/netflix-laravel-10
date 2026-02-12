<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Admin Account
        User::updateOrCreate(
            ['email' => 'admin@netflixku.com'],
            [
                'name' => 'Admin Netflixku',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'ktp_number' => null,
                'is_approved_adult' => true,
            ]
        );

        // 2. Member (Pending/Unapproved)
        User::updateOrCreate(
            ['email' => 'member@netflixku.com'],
            [
                'name' => 'Budi Santoso',
                'password' => Hash::make('password'),
                'role' => 'member',
                'ktp_number' => '3201234567890001',
                'is_approved_adult' => false,
            ]
        );

        // 3. Member (Approved)
        User::updateOrCreate(
            ['email' => 'approved@netflixku.com'],
            [
                'name' => 'Siti Aminah',
                'password' => Hash::make('password'),
                'role' => 'member',
                'ktp_number' => '1234567890123456',
                'is_approved_adult' => true,
            ]
        );
    }
}
