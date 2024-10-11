<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FavouriteController;
use App\Http\Controllers\OrderController;

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::get('/lang/{locale}', [LocaleController::class, 'setLocale'])->name('lang.switch');

Route::controller(HomeController::class)->group(function(){
    Route::get('/', 'home')->name('home');
    Route::get('/search', 'search')->name('search');
});

Route::middleware('user_auth')->group(function(){
    Route::resource('cart', CartController::class)->only(['index','update', 'destroy']);
    Route::post('cart/{productId}',[CartController::class,'store'])->name('cart.store');
    
    Route::controller(FavouriteController::class)->group(function(){
        Route::get('favourites','index')->name('favourites.index');
        Route::post('favourites/{productId}','store')->name('favourites.store');
    });

    Route::controller(OrderController::class)->group(function(){
        Route::post('order', 'store')->name('order.store');
    });

    


});

Route::resource('categories', CategoryController::class);
Route::resource('products', ProductController::class);

Route::middleware('is_admin')->prefix('admin')->as('admin.')->group(function () {
    Route::resource('categories', AdminCategoryController::class);
    Route::resource('products', AdminProductController::class);
});

