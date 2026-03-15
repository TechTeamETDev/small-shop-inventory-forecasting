<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UsersController;

// Public route
Route::get('/', function () {
    return view('welcome');
});

// Authenticated routes
Route::middleware(['auth','force.password.reset'])->group(function () {

    // Dashboard — dynamic content based on @can() in Blade
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // Sales routes (permission-based)
    Route::middleware(['permission:create sales'])->group(function () {
        Route::get('/sales', function () {
            return "Sales Page";
        });
    });

    // Products routes (permission-based)
    Route::middleware(['permission:view products'])->group(function () {
        Route::get('/products', function () {
            return "Products Page";
        });
    });

    // Analytics routes (permission-based)
    Route::middleware(['permission:view analytics'])->group(function () {
        Route::get('/analytics', function () {
            return "Analytics Page";
        });
    });

    // Profit reports routes (permission-based)
    Route::middleware(['permission:view profit reports'])->group(function () {
        Route::get('/profit', function () {
            return "Profit Reports Page";
        });
    });

 // User management routes (Admin only)
Route::middleware(['auth', 'permission:manage users'])->group(function () {
    Route::get('/users', [UsersController::class, 'index'])->name('users.index');
    Route::post('/users', [UsersController::class, 'store'])->name('users.store');
    Route::post('/users/{user}/role', [UsersController::class, 'updateRole'])->name('users.updateRole');
});

// First login password reset
Route::get('/password/reset/custom', function () {
    return view('auth.passwords.reset_custom');
})->name('password.reset.custom');

Route::post('/password/reset/custom', function (\Illuminate\Http\Request $request) {
    $request->validate(['password' => 'required|string|min:8|confirmed']);
    $user = Auth::user();
    $user->password = Hash::make($request->password);
    $user->must_reset_password = false;
    $user->save();
    return redirect('/dashboard')->with('success', 'Password updated!');
})->name('password.reset.custom.post');


});