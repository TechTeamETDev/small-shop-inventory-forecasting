<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AlertController;
use App\Http\Controllers\PurchaseController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('products', ProductController::class);
Route::resource('categories', CategoryController::class);

/*
|--------------------------------------------------------------------------
| ALERT ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/alerts', [AlertController::class, 'index'])->name('alerts.index');
Route::get('/alerts/create', [AlertController::class, 'create'])->name('alerts.create');
Route::post('/alerts', [AlertController::class, 'store'])->name('alerts.store');

/*
|--------------------------------------------------------------------------
| PURCHASE ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/purchases', [PurchaseController::class, 'index'])->name('purchases.index');
Route::get('/purchases/create', [PurchaseController::class, 'create'])->name('purchases.create');
Route::post('/purchases', [PurchaseController::class, 'store'])->name('purchases.store');