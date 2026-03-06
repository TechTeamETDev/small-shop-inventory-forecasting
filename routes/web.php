<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;

// Home page
Route::get('/', function () {
    return view('welcome');
});

// Product CRUD routes
Route::resource('products', ProductController::class);

// Sales routes
Route::get('/sales', [SaleController::class, 'index'])->name('sales.index');       // List all sales
Route::get('/sales/create', [SaleController::class, 'create'])->name('sales.create'); // Show sale form
Route::post('/sales/store', [SaleController::class, 'store'])->name('sales.store');   // Store sale
Route::get('/admin-sales', [SaleController::class, 'adminSales'])->name('sales.admin');