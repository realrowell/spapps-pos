<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'username' => 'admin',
                'email' => 'demo.1@mail.com',
                'full_name' => 'Admin User',
                'password' => Hash::make('05052000'), // ✅ hashed
                'email_verified_at' => now(), // optional but recommended
            ]
        );
    }
}
