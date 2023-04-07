<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AddressController;

Route::prefix('auth')->group(function(){

    Route::middleware('auth:api')->group(function(){
            
        Route::patch('/', [AuthController::class, 'editAccount']);
    
        Route::delete('/logout', [AuthController::class, 'logout']);

        Route::patch('/password/change', [AuthController::class, 'changePassword']);
    });

    Route::post('/password/forgot', [AuthController::class, 'forgotPassword']);

    Route::patch('/password/reset/{token}', [AuthController::class, 'resetPassword']);
    
    Route::get('/', [AuthController::class, 'index']);

    Route::post('/login', [AuthController::class, 'login']);

    Route::post('/register', [AuthController::class, 'register']);

    Route::patch('/verify/{token}', [AuthController::class, 'verifyAccount']);

    Route::post('/verify/resend', [AuthController::class, 'resendVerificationLink']);
});

Route::get('/categories', [CategoryController::class, 'index']);

Route::get('/sliders', [SliderController::class, 'index']);

Route::get('/products', [ProductController::class, 'index']);

Route::get('/products/{product}', [ProductController::class, 'product']);

Route::get('/settings', [SettingController::class, 'index']);

Route::prefix('wishlists')->group(function(){
   
    Route::get('/', [WishlistController::class, 'index']);

    Route::post('/{product}', [WishlistController::class, 'store']);

    Route::delete('/{product}', [WishlistController::class, 'delete']);
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

    Route::patch('/{cartId}', [CartController::class, 'update']);

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

    Route::get('/{address}', [AddressController::class, 'show']);

    Route::post('/', [AddressController::class, 'store']);

    Route::patch('/{address}', [AddressController::class, 'update']);

    Route::delete('/{address}', [AddressController::class, 'delete']);
});