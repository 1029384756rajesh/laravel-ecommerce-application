<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;

 Route::group(['prefix' => 'laravel-filemanager'], function () {
     \UniSharp\LaravelFilemanager\Lfm::routes();
 });
 Route::get("/file", function () {
     return view("demo");
 });

 Route::get("/cate", function () {
     $ch = new \App\Helpers\CategoryHelper();

     $categories = \App\Models\Category::all()->toArray();

     $parentCategory = $ch->getParents($categories);

     $ch->categories = $categories;

     $ch->setChildren($parentCategory);

     echo "<pre>";

    //  echo($ch->getUlFromCategories($parentCategory));

    $ch->getLabel($parentCategory, 1);
    print_r($ch->final);

     echo "</pre>";
 });

Route::prefix('auth')->group(function(){
        
    Route::view('/login', 'auth.login');

    Route::post('/login', [AuthController::class, 'login']);

    Route::view('/register', 'auth.register')->name('auth.register');

    Route::post('/register', [AuthController::class, 'register'])->name('auth.register');

    Route::middleware('auth')->group(function(){
        
        Route::view('/edit-account', 'auth.edit-account');

        Route::patch('/edit-account', [AuthController::class, 'editAccount']);

        Route::view('/change-password', 'auth.change-password');

        Route::patch('/change-password', [AuthController::class, 'changePassword']);

        Route::get('/logout', [AuthController::class, 'logout']);
    });
});

Route::get('/', [HomeController::class, 'index']);

Route::get('/products', [HomeController::class, 'products']);

Route::get('/products/{productId}', [HomeController::class, "product"]);

Route::get('/about', [HomeController::class, 'about']);
Route::get('/search', [HomeController::class, 'search']);

Route::view('/contact', 'contact');

Route::prefix("/cart")->group(function(){

    Route::get('/', [CartController::class, 'index']);    

    Route::post('/{product}', [CartController::class, 'store']);    

    Route::delete('/', [CartController::class, 'delete']);   

    Route::patch('/{product}', [CartController::class, 'update']);    
});

Route::middleware("auth")->group(function(){

    Route::post('/orders', [OrderController::class, 'store']);
    
    Route::get('/orders', [OrderController::class, 'index']);

    Route::get('/orders/{order}', [OrderController::class, 'show']);
});

Route::get('/checkout', [CartController::class, "checkout"]);
