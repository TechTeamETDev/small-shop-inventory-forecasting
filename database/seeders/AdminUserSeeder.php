<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        // Seeder admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin',
                'password' => bcrypt('password'),
                'must_reset_password' => false, // normal login
            ]
        );
        $admin->assignRole('Admin');

        // Seeder employee
        $employee = User::firstOrCreate(
            ['email' => 'employee@example.com'],
            [
                'name' => 'Employee User',
                'password' => bcrypt('password'),
                'must_reset_password' => true, // first login reset
            ]
        );
        $employee->assignRole('Employee');
    }
}