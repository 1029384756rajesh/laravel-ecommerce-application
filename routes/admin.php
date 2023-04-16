<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\VariantController;
use App\Http\Controllers\Admin\OptionController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\HomeController;


Route::get('/', [HomeController::class, 'index']);
    
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
    
    Route::get('/', [CategoryController::class, 'index'])->name("categories");

    Route::get('/create', [CategoryController::class, 'create']);

    Route::post('/', [CategoryController::class, 'store']);

    Route::get('/{category}', [CategoryController::class, 'edit']);

    Route::patch('/{category}', [CategoryController::class, 'update']);

    Route::delete('/{category}', [CategoryController::class, 'delete']);
});

Route::prefix('orders')->group(function(){
    
    Route::get('/', [OrderController::class, 'index'])->name('admin.orders.index');

    Route::get('/{order}', [OrderController::class, 'show'])->name('admin.orders.show');

    Route::patch('/{order}', [OrderController::class, 'update'])->name('admin.orders.update');

    Route::delete('/{order}', [OrderController::class, 'destroy'])->name('admin.orders.destroy');
});

Route::prefix('products')->group(function(){
    
    Route::get('/', [ProductController::class, 'index']);
    
    Route::get('/create', [ProductController::class, 'create']);

    Route::get('/{product}/attributes', [ProductController::class, 'attributes']);

    Route::post('/{product}/attributes', [ProductController::class, 'storeAttributes']);

    Route::get('/{product}/variations', [ProductController::class, 'editVariations']);

    Route::patch('/{product}/variations', [ProductController::class, 'updateVariations']);
    
    Route::get('/{product}', [ProductController::class, 'edit']);

    Route::patch('/{product}', [ProductController::class, 'update'])->name('admin.products.update');

    // Route::patch('/{product}', [ProductController::class, 'update'])->name('admin.products.update');
    
    Route::post('/store', [ProductController::class, 'store'])->name('admin.products.store');

    Route::delete('/{product}', [ProductController::class, 'delete']);
});

Route::get('/users', [UserController::class, 'index']);

Route::prefix('auth')->group(function(){
        
    Route::view('/login', 'auth.login')->name('auth.login');

    Route::post('/login', [AuthController::class, 'login'])->name('auth.login');

    Route::view('/register', 'auth.register')->name('auth.register');

    Route::post('/register', [AuthController::class, 'register'])->name('auth.register');

    Route::middleware('auth')->group(function(){
        
        Route::view('/edit-account', 'auth.edit-account')->name('auth.edit-account');

        Route::patch('/edit-account', [AuthController::class, 'editAccount'])->name('auth.edit-account');

        Route::view('/change-password', 'auth.change-password')->name('auth.change-password');

        Route::patch('/change-password', [AuthController::class, 'changePassword'])->name('auth.change-password');

        Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');
    });
});

Route::get('/', [HomeController::class, 'index'])->name('index');

// Route::get('/products', [HomeController::class, 'products'])->name('products.index');

// Route::get('/products/{product}', [HomeController::class, 'product'])->name('products.show');

Route::get('/about', [HomeController::class, 'about'])->name('about');

Route::view('/contact', 'contact')->name('contact');

Route::prefix("/cart")->group(function(){

    Route::get('/', [CartController::class, 'index'])->name('cart.index');    

    Route::post('/', [CartController::class, 'store'])->name('cart.store');    

    Route::delete('/', [CartController::class, 'destroy'])->name('cart.destroy');   

    Route::delete('/all', [CartController::class, 'destroyAll'])->name('cart.destroy.all');   

    Route::patch('/update', [CartController::class, 'updateAll'])->name('cart.update.all');    
});

Route::prefix("/addresses")->group(function(){

    Route::get('/', [AddressController::class, 'index'])->name('addresses.index');    

    Route::view('/create', 'create-address')->name('addresses.create');   

    Route::post('/', [AddressController::class, 'store'])->name('addresses.store');    

    Route::get('/{address}/edit', [AddressController::class, 'edit'])->name('addresses.edit');   

    Route::patch('/{address}', [AddressController::class, 'update'])->name('addresses.update');   

    Route::delete('/{address}', [AddressController::class, 'destroy'])->name('addresses.destroy');    
});


Route::prefix("/wishlists")->group(function(){

    Route::get('/', [WishlistController::class, 'index'])->name('wishlists.index');    

    Route::post('/', [WishlistController::class, 'store'])->name('wishlists.store');    

    Route::delete('/{productId}', [WishlistController::class, 'destroy'])->name('wishlists.destroy');    
});

Route::prefix("/reviews")->group(function(){

    Route::get('/', [ReviewController::class, 'index'])->name('reviews.index');    

    Route::post('/', [ReviewController::class, 'store'])->name('reviews.store');    

    Route::patch('/{review}', [ReviewController::class, 'update'])->name('reviews.update');    

    Route::delete('/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');    
});


// Route::view('/', 'index');
// Route::view('/products', 'products');
Route::view('/product', 'details');
// Route::view('/cart', 'cart');
// Route::view('/orders', 'orders2');
// Route::view('/order', 'order');
// Route::view('/addresses', 'addresses');
Route::view('/wishlist', 'wishlist');
Route::view('/checkout', 'checkout');

// Route::view('/admin/sliders', 'admin.sliders.index');
// Route::view('/admin/categories', 'admin.categories.index');
// Route::view('/admin/settings', 'admin.settings.index');