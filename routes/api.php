<?php

use App\Http\Controllers\CartViewController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderViewController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductsViewController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/products', [ProductController::class, 'index']);

Route::get('/products', [ProductsViewController::class, 'getProducts']);

Route::get('/cart', [CartViewController::class, 'getCart']);


Route::get('/orders', [OrderViewController::class, 'getOrders']);

Route::get('/users', [UserController::class, 'getUsers']);

Route::get('/orders', [DashboardController::class, 'getOrders']);
Route::get('/statistics', [DashboardController::class, 'getStatistics']);
Route::get('/top-products', [DashboardController::class, 'getTopProducts']);
