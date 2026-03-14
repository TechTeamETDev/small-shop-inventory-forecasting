<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;
use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use Spatie\Permission\Models\Role;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    
    // 1. Dashboard
    Route::get('/dashboard', function () {
        $productCount = Product::count();
        $categoryCount = Category::count();
        $roles = Role::all();
        $users = User::all(); 
        
        return view('dashboard', compact('productCount', 'categoryCount', 'roles', 'users'));
    })->name('dashboard');

    // 2. Role Management
    Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');
    Route::get('/roles/{id}/edit', [RoleController::class, 'edit'])->name('roles.edit');
    Route::put('/roles/{id}', [RoleController::class, 'update'])->name('roles.update');
    Route::delete('/roles/{id}', [RoleController::class, 'destroy'])->name('roles.destroy');

    // 3. User & Role Assignment Management
    // This route handles the "Update" button in your dashboard user table
    Route::put('/users/{user}/role', [ProfileController::class, 'updateRole'])->name('users.update-role');
    
    // This route handles deleting accounts
    Route::delete('/users/{id}', [ProfileController::class, 'destroyUser'])->name('users.destroy');

    // 4. Inventory Management
    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);

    // 5. Profile Management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';