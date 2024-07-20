<?php

use App\Http\Controllers\ProductController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/products', function () {
        return Inertia::render('Products');
    })->name('products');

    Route::get('/shoppingcart', function () {
        return Inertia::render('ShoppingCart');
    })->name('shoppingcart');

    Route::get('/createproduct', [ProductController::class, 'create'])->name('createproduct');
    Route::post('/createproduct/store', [ProductController::class, 'store'])->name('createproduct.store');
});


// Route::middleware([AdminMiddleware::class])->group(function () {
//     Route::post('/api/products', [ProductController::class, 'store']);
// });