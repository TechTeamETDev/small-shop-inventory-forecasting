<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

// Public route
Route::get('/', function () {
    return view('welcome');
});

// Authenticated routes
Route::middleware(['auth', 'force.password.reset'])->group(function () {

    // First login password reset
    Route::get('/password/reset/custom', function () {
        return view('auth.passwords.reset_custom');
    })->name('password.reset.custom');

   // Handle password update after first login
Route::post('/password/reset/custom', function (Request $request) {
    $request->validate([
        'password' => 'required|string|min:8|confirmed',
    ]);

    $user = Auth::user();
    $user->password = Hash::make($request->password);
    $user->must_reset_password = false;
    $user->save();

    // Redirect to the dynamic dashboard (single route)
    return redirect()->route('dashboard')->with('success', 'Password updated!');
})->name('password.reset.custom.post');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Permission-based routes
    Route::middleware(['permission:create sales'])->get('/sales', function () {
        return "Sales Page";
    });

    Route::middleware(['permission:view products'])->get('/products', function () {
        return "Products Page";
    });

    Route::middleware(['permission:view analytics'])->get('/analytics', function () {
        return "Analytics Page";
    });

    Route::middleware(['permission:view profit reports'])->get('/profit', function () {
        return "Profit Reports Page";
    });

    // User management (Admin only)
    Route::middleware(['permission:manage users'])->group(function () {
        Route::resource('users', UserController::class);
        Route::post('/users/{user}/reset-password', [UserController::class,'resetPassword'])->name('users.reset');
    });

    // Keep-alive AJAX
    Route::post('/keep-alive', function () {
        session(['last_activity_time' => now()->timestamp]);
        return response()->json(['status' => 'ok']);
    });
});

require __DIR__.'/auth.php';