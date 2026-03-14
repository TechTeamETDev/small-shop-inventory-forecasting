<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Http\Controllers\Controller;

class RoleController extends Controller
{
    /**
     * Show the form for creating a new role.
     */
    public function create()
    {
        $permissions = Permission::all();
        return view('roles.create', compact('permissions'));
    }

    /**
     * Store the new role.
     * Updated to handle quick-creation from Dashboard.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'permissions' => 'nullable|array' // Changed 'required' to 'nullable'
        ]);

        // Create the role
        $role = Role::create(['name' => $request->name]);

        // Only sync if permissions were actually sent (fixes dashboard form error)
        if ($request->has('permissions')) {
            $role->syncPermissions($request->permissions);
        }

        return redirect()->route('dashboard')->with('success', 'Role "' . $role->name . '" created successfully!');
    }

    /**
     * Show the form for editing an existing role.
     */
    public function edit($id)
    {
        $role = Role::findOrFail($id);
        $permissions = Permission::all();
        $rolePermissions = $role->permissions->pluck('name')->toArray();

        return view('roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    /**
     * Update the role and sync the new permission list.
     */
    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $id,
            'permissions' => 'nullable|array'
        ]);

        // Update name if it changed
        $role->name = $request->name;
        $role->save();

        // Sync permissions
        $permissions = $request->input('permissions', []);
        $role->syncPermissions($permissions);

        // Clear the Spatie permission cache
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        return redirect()->route('dashboard')->with('success', 'Permissions updated and cache cleared!');
    }
    /**
 * Remove the specified role from storage.
 */
public function destroy($id)
{
    $role = Role::findOrFail($id);
    
    // Prevent deleting the Admin role for safety
    if ($role->name === 'Admin') {
        return redirect()->back()->with('error', 'The Admin role cannot be deleted!');
    }

    $role->delete();

    return redirect()->route('dashboard')->with('success', 'Role deleted successfully!');
}
}