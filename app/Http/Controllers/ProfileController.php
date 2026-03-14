<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User; // Added to find specific users
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's OWN account (Default Laravel Breeze).
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * NEW: Delete a specific user from the Dashboard.
     * This frees up the email address immediately.
     */
    public function destroyUser(int $id): RedirectResponse
    {
        $user = User::findOrFail($id);

        // Safety check: Prevent deleting yourself
        if (Auth::id() === $user->id) {
            return Redirect::back()->with('error', 'You cannot delete your own account from here. Use the Profile page instead.');
        }

        $user->delete();

        return Redirect::route('dashboard')->with('success', 'User "' . $user->name . '" and their email have been completely removed.');
    }
    public function updateRole(Request $request, User $user)
{
    // 1. Remove their old roles so they don't have multiple roles
    $user->syncRoles([]);

    // 2. If a role was selected in the dropdown, assign it
    if ($request->role) {
        $user->assignRole($request->role);
    }

    return redirect()->back()->with('success', 'User role updated successfully!');
}
}