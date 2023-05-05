<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FileController;

Route::get('/', [DashboardController::class, 'index']);
    
Route::prefix('sliders')->group(function(){

    Route::get('/', [SliderController::class, 'sliders']); 

    Route::post('/', [SliderController::class, 'create']);

    Route::delete('/{slider}', [SliderController::class, 'delete']);
});

Route::prefix('settings')->group(function(){
    
    Route::get('/', [SettingController::class, 'settings']);

    Route::patch('/', [SettingController::class, 'edit']);
});

Route::prefix('categories')->group(function(){
    
    Route::get('/', [CategoryController::class, 'categories']);

    Route::get('/{category}', [CategoryController::class, 'category']);

    Route::post('/', [CategoryController::class, 'create']);

    Route::patch('/{category}', [CategoryController::class, 'edit']);

    Route::delete('/{category}', [CategoryController::class, 'delete']);
});

Route::prefix('orders')->group(function(){
    
    Route::get('/', [OrderController::class, 'orders']);

    Route::get('/{order}', [OrderController::class, 'order']);

    Route::patch('/{order}', [OrderController::class, 'edit']);
});

Route::prefix('products')->group(function(){
    
    Route::get('/', [ProductController::class, 'products']);

    Route::get('/{product}', [ProductController::class, 'product']);

    Route::post('/', [ProductController::class, 'create']);

    Route::patch('/{product}', [ProductController::class, 'edit']);

    Route::delete('/{product}', [ProductController::class, 'delete']);
    
    Route::get('/{product}/attributes', [ProductController::class, 'attributes']);

    Route::post('/{product}/attributes', [ProductController::class, 'createAttributes']);

    Route::get('/{product}/variations', [ProductController::class, 'variations']);

    Route::patch('/{product}/variations', [ProductController::class, 'editVariations']);
});

Route::get('/users', [UserController::class, 'index']);

Route::get('/setting', [SettingController::class, 'settings']);

Route::patch('/setting', [SettingController::class, 'edit']);

Route::get('/files', [FileController::class, 'files']);

Route::post('/files', [FileController::class, 'create']);


