<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\DashboardController;

Route::middleware(['auth', 'can:admin'])->group(function(){
    
    Route::get('/', [DashboardController::class, 'index']);
        
    Route::prefix('sliders')->group(function(){

        Route::get('/', [SliderController::class, 'index']); 

        Route::view('/create', 'admin.sliders.create');

        Route::post('/', [SliderController::class, 'store']);

        Route::delete('/{slider}', [SliderController::class, 'delete']);
    });

    Route::prefix('settings')->group(function(){
        
        Route::get('/', [SettingController::class, 'index']);

        Route::get('/edit', [SettingController::class, 'edit']);

        Route::patch('/', [SettingController::class, 'update']);
    });

    Route::prefix('categories')->group(function(){
        
        Route::get('/', [CategoryController::class, 'categories']);

        Route::get('/create', [CategoryController::class, 'create']);

        Route::post('/', [CategoryController::class, 'store']);

        Route::get('/{category}/edit', [CategoryController::class, 'edit']);

        Route::patch('/{category}', [CategoryController::class, 'update']);

        Route::delete('/{category}', [CategoryController::class, 'delete']);
    });

    Route::prefix('orders')->group(function(){
        
        Route::get('/', [OrderController::class, 'index']);

        Route::get('/{order}', [OrderController::class, 'show']);

        Route::patch('/{order}', [OrderController::class, 'update']);
    });

    Route::prefix('products')->group(function(){
        
        Route::get('/', [ProductController::class, 'products']);

        Route::get('/create', [ProductController::class, 'create']);

        Route::post('/store', [ProductController::class, 'store']);

        Route::get('/{product}/edit', [ProductController::class, 'edit']);

        Route::patch('/{product}', [ProductController::class, 'update']);

        Route::delete('/{product}', [ProductController::class, 'delete']);
        
        Route::get('/{product}/attributes', [ProductController::class, 'attributes']);

        Route::post('/{product}/attributes', [ProductController::class, 'storeAttributes']);

        Route::get('/{product}/variations', [ProductController::class, 'variations']);

        Route::patch('/{product}/variations', [ProductController::class, 'updateVariations']);
    });

    Route::get('/users', [UserController::class, 'index']);

    Route::get('/setting', [SettingController::class, 'settings']);

    Route::patch('/setting', [SettingController::class, 'edit']);
});



