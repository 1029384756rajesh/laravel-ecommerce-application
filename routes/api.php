<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\WishlistController;

Route::prefix('auth')->group(function(){

    Route::middleware('auth:api')->group(function(){
            
        Route::patch('/edit-account', [AccountController::class, 'edit-account']);
    
        Route::delete('/logout', [AccountController::class, 'logout']);
    });
    
    Route::get('/', [AccountController::class, 'index']);

    Route::post('/login', [AccountController::class, 'login']);

    Route::post('/register', [AccountController::class, 'register']);
});

Route::get('/categories', [CategoryController::class, 'index']);

Route::get('/sliders', [SliderController::class, 'index']);

Route::get('/products', [ProductController::class, 'index']);

Route::get('/products/{product}', [ProductController::class, 'product']);

Route::get('/settings', [SettingController::class, 'index']);

Route::prefix('wishlists')->group(function(){
   
    Route::get('/', [UserController::class, 'wishlists']);

    Route::post('/', [UserController::class, 'storeWishlist']);

    Route::delete('/{product}', [UserController::class, 'deleteWishlist']);
});

Route::prefix('reviews')->group(function(){
   
    Route::get('/', [ReviewController::class, 'index']);

    Route::post('/', [ReviewController::class, 'store']);

    Route::delete('/{review}', [ReviewController::class, 'delete']);
});

Route::prefix('cart')->group(function(){
   
    Route::get('/', [CartController::class, 'index']);

    Route::get('/pricing', [CartController::class, 'pricing']);

    Route::post('/', [CartController::class, 'store']);

    Route::patch('/', [CartController::class, 'updateAll']);

    Route::delete('/{cart}', [CartController::class, 'delete']);

    Route::delete('/', [CartController::class, 'deleteAll']);
});

Route::prefix('orders')->group(function(){
   
    Route::get('/', [OrderController::class, 'index']);

    Route::get('/{order}', [OrderController::class, 'order']);

    Route::post('/', [OrderController::class, 'store']);
});

Route::prefix('addresses')->group(function(){
   
    Route::get('/', [AddressController::class, 'index']);

    Route::post('/', [AddressController::class, 'store']);

    Route::patch('/{address}', [AddressController::class, 'update']);

    Route::delete('/{address}', [AddressController::class, 'delete']);
});