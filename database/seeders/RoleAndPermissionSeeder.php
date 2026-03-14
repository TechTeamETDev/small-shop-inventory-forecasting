<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RoleAndPermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // 1. Define all permissions (including the ones missing from your screenshot)
        $permissions = [
            'manage inventory',
            'view inventory',
            'record sales',
            'product.create',
            'product.edit',
            'product.delete',
            'category.create',
            'category.edit',
            'category.delete',
        ];

        // Create each permission if it doesn't exist
        foreach ($permissions as $permission) {
            Permission::findOrCreate($permission);
        }

        // 2. Create Roles
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $employeeRole = Role::firstOrCreate(['name' => 'employee']);

        // 3. Assign ALL permissions to Admin
        $adminRole->syncPermissions(Permission::all());
        
        // 4. Assign specific permissions to Employee (Sales Staff)
        // This makes sure they can record sales and view inventory immediately
        $employeeRole->syncPermissions([
            'view inventory',
            'record sales'
        ]);
    }
}