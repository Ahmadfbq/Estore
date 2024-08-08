<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/products', [ProductController::class, 'getProducts']);

Route::get('/cart', [CartController::class, 'getCart']);


Route::get('/orders', [OrderController::class, 'getOrders']);
Route::patch('/orders/{id}', [OrderController::class, 'updateStatus']);

Route::get('/users', [UserController::class, 'getUsers']);

Route::get('/orders', [DashboardController::class, 'getOrders']);
Route::get('/statistics', [DashboardController::class, 'getStatistics']);
Route::get('/top-products', [DashboardController::class, 'getTopProducts']);
