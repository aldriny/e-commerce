<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiControllers\AuthController;
use App\Http\Controllers\ApiControllers\CartController;
use App\Http\Controllers\ApiControllers\ProductController;
use App\Http\Controllers\ApiControllers\CategoryController;


Route::controller(AuthController::class)->group(function () {
    Route::post('/register', 'register');
    Route::post('/login', 'login');
    Route::post('/logout', 'logout')->middleware('auth:sanctum');
});

Route::controller(ProductController::class)->group(function () {
    Route::get('/products', 'index');
    Route::get('/products/{id}', 'show');
});
Route::controller(CategoryController::class)->group(function () {
    Route::get('/categories', 'index');
    Route::get('/categories/{id}', 'show');
});

//require authenticated user
Route::middleware('auth:sanctum')->group(function () {
    Route::controller(CartController::class)->group(function () {
        Route::get('/cart', 'index');
        Route::post('/cart/create/{productId}', 'store');
        Route::put('/cart/update/{productId}', 'update');
        Route::delete('/cart/delete/{productId}', 'destroy');
    });
});

// require authenticated user and to be admin
Route::middleware(['auth:sanctum', 'api.admin'])->group(function () {
    Route::controller(ProductController::class)->group(function () {
        Route::post('/products/create', 'store');
        Route::put('/products/edit/{id}', 'update');
        Route::delete('/products/{id}', 'destroy');
    });
    Route::controller(CategoryController::class)->group(function () {
        Route::post('/categories/create', 'store');
        Route::put('/categories/edit/{id}', 'update');
        Route::delete('/categories/{id}', 'destroy');
    });
});
