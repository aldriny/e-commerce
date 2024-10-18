<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiControllers\AuthController;
use App\Http\Controllers\ApiControllers\CartController;
use App\Http\Controllers\ApiControllers\ProductController;
use App\Http\Controllers\ApiControllers\CategoryController;
use App\Http\Controllers\ApiControllers\FavouriteController;
use App\Http\Controllers\ApiControllers\OrderController;

Route::controller(AuthController::class)->group(function () {
    Route::post('/register', 'register');
    Route::post('/login', 'login');
    Route::post('/logout', 'logout')->middleware('auth:sanctum');
});

Route::apiResource('products', ProductController::class)->only(['index', 'show']);
Route::apiResource('categories', CategoryController::class)->only(['index', 'show']);

//require authenticated user
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('cart', CartController::class)->except(['store','show']);
    Route::post('/cart/{productId}', [CartController::class,'store']);
    Route::apiResource('orders', OrderController::class)->except(['update']);
    Route::get('favourites',[FavouriteController::class,'index']);
    Route::post('favourites/{productId}',[FavouriteController::class,'store']);
});

// require authenticated user and to be admin
Route::middleware(['auth:sanctum', 'api.admin'])->group(function () {
    Route::apiResource('products', ProductController::class)->except(['index', 'show']);
    Route::apiResource('categories', CategoryController::class)->except(['index', 'show']);
});
