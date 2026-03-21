<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public
Route::get('/', function () {
    return view('welcome');
});

// Protected routes
Route::middleware(['auth', 'force.password.reset'])->group(function () {

    // -------------------------------
    // Dashboard
    // -------------------------------
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // -------------------------------
    // Profile
    // -------------------------------
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // -------------------------------
    // First Login Password Reset
    // -------------------------------
    Route::get('/password/reset/custom', function () {
        return view('auth.passwords.reset_custom');
    })->name('password.reset.custom');

    Route::post('/password/reset/custom', function (\Illuminate\Http\Request $request) {
        $request->validate([
            'password' => 'required|string|min:8|confirmed'
        ]);

        $user = Auth::user();
        $user->password = Hash::make($request->password);
        $user->must_reset_password = false;
        $user->save();

        return redirect('/dashboard')->with('success', 'Password updated!');
    })->name('password.reset.custom.post');

    // -------------------------------
    // PRODUCTS
    // -------------------------------
    Route::middleware('permission:view products')->group(function () {
        Route::get('/products', [ProductController::class,'index'])->name('products.index');
    });

    Route::middleware('permission:create products')->group(function () {
        Route::post('/products', [ProductController::class,'store'])->name('products.store');
    });

    Route::middleware('permission:edit products')->group(function () {
        Route::get('/products/{product}/edit', [ProductController::class,'edit'])->name('products.edit');
        Route::put('/products/{product}', [ProductController::class,'update'])->name('products.update');
    });

    Route::middleware('permission:delete products')->group(function () {
        Route::delete('/products/{product}', [ProductController::class,'destroy'])->name('products.destroy');
    });

    // -------------------------------
    // CATEGORIES (NOW WORKS ✅)
    // -------------------------------
    Route::middleware('permission:manage categories')->group(function () {
        Route::get('/categories', [CategoryController::class,'index'])->name('categories.index');
        Route::post('/categories', [CategoryController::class,'store'])->name('categories.store');
        Route::get('/categories/{category}/edit', [CategoryController::class,'edit'])->name('categories.edit');
        Route::put('/categories/{category}', [CategoryController::class,'update'])->name('categories.update');
        Route::delete('/categories/{category}', [CategoryController::class,'destroy'])->name('categories.destroy');
    });

    // -------------------------------
    // SALES
    // -------------------------------
    Route::middleware('permission:create sales')->group(function () {
        Route::get('/sales', function () {
            return view('placeholders.page', ['title' => 'Sales']);
        })->name('sales.index');
    });

    // -------------------------------
    // PURCHASES
    // -------------------------------
    Route::middleware('permission:create purchases')->group(function () {
        Route::get('/purchases', function () {
            return view('placeholders.page', ['title' => 'Purchases']);
        })->name('purchases.index');
    });

    // -------------------------------
    // ANALYTICS
    // -------------------------------
    Route::middleware('permission:view analytics')->group(function () {
        Route::get('/analytics', function () {
            return view('placeholders.page', ['title' => 'Analytics']);
        })->name('analytics.index');
    });

    // -------------------------------
    // PROFIT REPORTS
    // -------------------------------
    Route::middleware('permission:view profit reports')->group(function () {
        Route::get('/profit', function () {
            return view('placeholders.page', ['title' => 'Profit Reports']);
        })->name('profit.index');
    });

    // -------------------------------
    // USERS
    // -------------------------------
    Route::middleware('permission:manage users')->group(function () {
        Route::resource('users', UserController::class);
        Route::post('/users/{user}/reset-password', [UserController::class,'resetPassword'])->name('users.reset');
        Route::post('/users/{user}/role', [UserController::class,'updateRole'])->name('users.updateRole');
    });

    // -------------------------------
    // SESSION KEEP ALIVE
    // -------------------------------
    Route::post('/keep-alive', function () {
        session(['last_activity_time' => now()->timestamp]);
        return response()->json(['status' => 'ok']);
    });
   
});

require __DIR__.'/auth.php';