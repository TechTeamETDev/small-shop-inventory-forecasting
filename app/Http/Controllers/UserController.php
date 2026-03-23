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

    // List users
    public function index()
    {
        $users = User::paginate(10);
        $roles = Role::all();
        return view('users.index', compact('users','roles'));
    }

    // Store new user (admin creates employee)
   public function store(Request $request)
{
    // Validate input
    $request->validate([
        'name'  => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'role'  => 'required|exists:roles,name',
    ]);

    // Generate a temporary password
    $tempPassword = Str::random(10);

    // Create the user with temporary password
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($tempPassword),
        'must_reset_password' => true, // force first login reset
    ]);

    // Assign the selected role
    $user->assignRole($request->role);

    // Send the temporary password via email immediately
    try {
        $user->notify(new NewAccountNotification($user, $tempPassword));
    } catch (\Exception $e) {
        return response()->json([
            'message' => "User created, but failed to send email: {$e->getMessage()}"
        ], 500);
    }

    // Return success response (for AJAX)
    return response()->json([
        'message' => "User {$user->name} created successfully. Temporary password sent via email."
    ]);
}

    // Update user info
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'role'  => 'required|exists:roles,name',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        $user->syncRoles([$request->role]);

        return response()->json(['message' => "User {$user->name} updated successfully."]);
    }

    // Delete user
    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(['message' => 'User deleted successfully.']);
    }

    // Reset user password (admin action)
    public function resetPassword(User $user)
    {
        $tempPassword = Str::random(10);

        $user->update([
            'password' => Hash::make($tempPassword),
            'must_reset_password' => true,
        ]);

        $user->notify(new NewAccountNotification($user, $tempPassword));

        return response()->json(['message' => "Password reset. Temporary password sent via email."]);
    }
}