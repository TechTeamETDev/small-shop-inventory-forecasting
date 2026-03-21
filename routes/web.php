<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;

// Public route
Route::get('/', function () {
    return view('welcome');
});
// Authenticated routes (including dashboard & profile)
Route::middleware(['auth', 'force.password.reset'])->group(function () {

    // Dashboard — dynamic content based on @can() in Blade
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


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

//placeholders to test the dashboard links:
Route::get('/products', function() { return "Products List"; })->name('products.index');
Route::get('/products/create', function() { return "Create Product Form"; })->name('products.create');

Route::get('/sales', function() { return "Sales List"; })->name('sales.index');
Route::get('/sales/create', function() { return "Record Sale Form"; })->name('sales.create');

Route::middleware(['permission:view analytics'])->group(function () {
    Route::get('/analytics', function() {
        return "Analytics Page";
    })->name('analytics.index');
});

Route::middleware(['auth','permission:manage users'])->group(function () {

    Route::resource('users', UserController::class);

    Route::post('/users/{user}/reset-password',
        [UserController::class,'resetPassword'])
        ->name('users.reset');

});


Route::post('/keep-alive', function () {
    session(['last_activity_time' => now()->timestamp]);
    return response()->json(['status' => 'ok']);
})->middleware('auth');
});


require __DIR__.'/auth.php';
