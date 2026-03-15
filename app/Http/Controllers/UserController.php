<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Notifications\NewAccountNotification;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','permission:manage users']);
    }

    // Show all users
    public function index()
    {
        $users = User::paginate(10);
        $roles = Role::all();

        return view('users.index', compact('users','roles'));
    }

    // Create new user (admin registration)
    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role'  => 'required|exists:roles,name',
        ]);

        $password = Str::random(12);

        $user = User::create([
            'name'  => $request->name,
            'email' => $request->email,
            'password' => Hash::make($password),
            'must_reset_password' => true,
        ]);

        $user->assignRole($request->role);

        // Send email with temporary password
        $user->notify(new NewAccountNotification($user,$password));

        return redirect()->route('users.index')
            ->with('success',"User {$user->name} created successfully");
    }

    // View user profile
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    // Edit user
    public function edit(User $user)
    {
        $roles = Role::all();

        return view('users.edit', compact('user','roles'));
    }

    // Update user
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email',
            'role'  => 'required|exists:roles,name',
        ]);

        $user->update([
            'name'  => $request->name,
            'email' => $request->email,
        ]);

        $user->syncRoles([$request->role]);

        return redirect()->route('users.index')
            ->with('success',"User {$user->name} updated");
    }

    // Delete user
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index')
            ->with('success','User deleted');
    }

    // Reset password
    public function resetPassword(User $user)
    {
        $newPassword = Str::random(10);

        $user->update([
            'password' => Hash::make($newPassword),
            'must_reset_password' => true,
        ]);

        $user->notify(new NewAccountNotification($user,$newPassword));

        return redirect()->back()
            ->with('success',"Password reset for {$user->name}");
    }
}