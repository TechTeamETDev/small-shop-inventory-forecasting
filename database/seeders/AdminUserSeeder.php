<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        // Create default admin if not exists
        User::firstOrCreate(
            ['email' => 'admin@example.com'], // default email
            [
                'name' => 'Admin',
                'password' => Hash::make('password123'), // default password
                'role' => 'admin',
            ]
        );
    }
}