<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
 Route::group(['prefix' => 'laravel-filemanager'], function () {
     \UniSharp\LaravelFilemanager\Lfm::routes();
 });

 Route::view('/demo', 'demo');
Route::post("/demo", function(Request $request)
{
    $request->validate([
        'age' => 'required',
        'names' => 'required|array|min:2',
        'names.*' => 'required|min:2'
    ]);
});

// Route::view("/admin/products/create", "admin.products.create");

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

Route::prefix('account')->group(function(){
        
    Route::middleware("guest")->group(function(){

        Route::view('/login', 'auth.login');

        Route::post('/login', [AuthController::class, 'login']);

        Route::view('/', 'auth.register')->name('auth.register');

        Route::post('/', [AuthController::class, 'register'])->name('auth.register');
    });

    Route::middleware('auth')->group(function(){
        
        Route::view('/edit', 'auth.edit-account');

        Route::patch('/update', [AuthController::class, 'update']);

        Route::view('/password/change', 'auth.change-password');

        Route::patch('/password/change', [AuthController::class, 'changePassword']);

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

    Route::post('/{productId}', [CartController::class, 'store']);    

    Route::delete('/{productId}', [CartController::class, 'delete']);   

    Route::patch('/{cartId}', [CartController::class, 'update']);    
});

Route::middleware("auth")->group(function(){

    Route::post('/orders', [OrderController::class, 'store']);
    
    Route::get('/orders', [OrderController::class, 'index']);

    Route::get('/orders/{order}', [OrderController::class, 'show']);
});

Route::post('/orders', [OrderController::class, 'store']);
    
Route::get('/orders', [OrderController::class, 'index']);

Route::get('/orders/{order}', [OrderController::class, 'show']);

Route::get('/checkout', [CartController::class, "checkout"]);
