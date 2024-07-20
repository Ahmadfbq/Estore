<?php

use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/products', [ProductController::class, 'index']);

// Route::post('/products/create', [ProductController::class, 'store'])->name('products.store');

// Route::middleware(['auth:sanctum', 'admin'])->group(function () {
//     Route::post('/products', [ProductController::class, 'store']);
// });
