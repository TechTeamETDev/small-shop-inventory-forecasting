<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
public function run(): void
{
    // 1. Create Roles
    $adminRole = Role::create(['name' => 'Admin']);
    $viewerRole = Role::create(['name' => 'Viewer']);

    // 2. Create ALL permissions (matching your Blade @can statements exactly)
    $permissions = [
        'category.create',
        'category.edit',
        'category.delete',
        'product.create',
        'product.edit',
        'product.delete',
        'record.sales',
    ];

    foreach ($permissions as $permission) {
        Permission::create(['name' => $permission]);
    }

    // 3. Give Admin everything
    $adminRole->givePermissionTo(Permission::all());

    // 4. Create your specific User
    $user = User::factory()->create([
        'name' => 'Admin',
        'email' => 'admin@shop.com', // Use your chosen email here
        'password' => bcrypt('password'), // Use your chosen password here
    ]);
    
    $user->assignRole($adminRole);
}
}