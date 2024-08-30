<?php 
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ShippingController;

Route::get('/products', [ProductController::class, 'products']);
Route::get('/products/{product}', [ProductController::class, 'product']);
Route::get('/show/{product}', [ProductController::class, 'show']);
Route::post('/products', [ProductController::class, 'store']);
Route::patch('/products/{product}', [ProductController::class, 'update']);
Route::delete('/products/{product}', [ProductController::class, 'delete']);

Route::get('/categories', [CategoryController::class, 'categories']);
Route::get('/categories/{category}', [CategoryController::class, 'category']);
Route::post('/categories', [CategoryController::class, 'store']);
Route::patch('/categories/{category}', [CategoryController::class, 'update']);
Route::delete('/categories/{category}', [CategoryController::class, 'delete']);

Route::get('/brands', [BrandController::class, 'index']);
Route::get('/brands/{brand}', [BrandController::class, 'show']);
Route::post('/brands', [BrandController::class, 'store']);
Route::patch('/brands/{brand}', [BrandController::class, 'update']);
Route::delete('/brands/{brand}', [BrandController::class, 'delete']);

Route::get('/zones', [ShippingController::class, 'zones']);
Route::get('/brands/{brand}', [BrandController::class, 'show']);
Route::post('/brands', [BrandController::class, 'store']);
Route::patch('/brands/{brand}', [BrandController::class, 'update']);
Route::delete('/brands/{brand}', [BrandController::class, 'delete']);

Route::get('/cart', [ProductController::class, 'upload']);

Route::get('/get-products', [ProductController::class, 'get_products']);

// function changed($attributes1, $attributes2)
// {
//     if(count($attributes1) !== count($attributes2))
//     {
//         return true;
//     }

//     $totalAttributes = 0;

//     foreach($attributes1 as $attribute1)
//     {
//         foreach($attributes2 as $attribute2)
//         {
//             if($attribute1['name'] === $attribute2['name'] && count($attribute1['options']) === count($attribute2['options']))
//             {
//                 $totalOptions = 0;

//                 foreach($attributes1['options'] as $option1)
//                 {
//                     foreach($attributes2['options'] as $option2)
//                     {
//                         if($option1['name'] === $option2['name'])
//                         {
//                             $totalOptions++;
//                         }
//                     }
//                 }

//                 if(count($attribute1['options']) === $totalOptions)
//                 {
//                     $totalAttributes++;
//                 }
//             }
//         }
//     }

//     return count($attribute1) === $totalAttributes;
// }

// In a ecommerce application each product can have multiple attributes each attribute can have multiple options. Create a php function which will
// take two attributes and check whether both are same or not. do not consider order of the attribute. do not consider id, position property.


// sample data - 
// $attributes1 = [
//     [
//             'id' => 1,
//         'name' => 'Size',
//         'options' => [
//             [
//                     'position' => 1,
//                 'name' => 'Small'
//             ],
//             [
//                 'name' => 'Medium'
//             ]
//         ]
//     ],
//     [
//         'name' => 'Color',
//         'options' => [
//             [
//                 'name' => 'Red'
//             ],
//             [
//                 'name' => 'Blue'
//             ]
//         ]
//     ],
// ];
// $attributes2 = [
//     [
//         'name' => 'Size',
//         'options' => [
//             [
//                 'name' => 'Small'
//             ],
//             [
//                 'name' => 'Medium'
//             ]
//         ]
//     ],
//     [
//         'name' => 'Color',
//         'options' => [
//             [
//                 'name' => 'Red'
//             ],
//             [
//                 'name' => 'Blue'
//             ]
//         ]
//     ],
// ];

// sample function - 
// function isSame($attribute1, $attribute2) {
//     // code
// }

// sample output
// isSame($attribute1, $attribute2) // true



