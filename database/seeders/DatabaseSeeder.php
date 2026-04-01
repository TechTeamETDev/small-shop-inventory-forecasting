<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1️ First seed roles and permissions
        $this->call(RolePermissionSeeder::class);

        // 2️ Then seed users (Admin & Employee)
        $this->call(UsersSeeder::class);
    }
}