<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [

            'view products',
            'create products',
            'edit products',
            'delete products',

            'create purchases',
            'view purchases',

            'create sales',
            'view sales',

            'view analytics',
            'view profit reports',

            'manage categories',
            'manage users'
            
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web', // ⚡ important!
            ]);
        }

        $admin = Role::firstOrCreate(['name' => 'Admin', 'guard_name' => 'web']);
        $employee = Role::firstOrCreate(['name' => 'Employee', 'guard_name' => 'web']);

        $admin->syncPermissions(Permission::all());

        $employee->syncPermissions(Permission::whereIn('name', [
            'view products',
            'create sales',
            'view sales'
        ])->get());
    }
}