<?php

use App\Http\Controllers\ApiControllers\AuthController;
use App\Http\Controllers\ApiControllers\CategoryController;
use App\Http\Controllers\ApiControllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::controller(AuthController::class)->group(function () {
    Route::post('/register', 'register');
    Route::post('/login', 'login');
    Route::post('/logout', 'logout')->middleware('api.auth');
});

// require authenticated user
Route::middleware('api.auth')->group(function () {
    Route::controller(ProductController::class)->group(function () {
        Route::get('/products', 'index');
        Route::get('/products/{id}', 'show');
    });
    Route::controller(CategoryController::class)->group(function () {
        Route::get('/categories', 'index');
        Route::get('/categories/{id}', 'show');
    });
});

// require authenticated user and to be admin
Route::middleware(['api.auth', 'api.admin'])->group(function () {
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
