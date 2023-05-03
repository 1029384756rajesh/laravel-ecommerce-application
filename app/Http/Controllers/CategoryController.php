<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Helpers\CategoryHelper;

class CategoryController extends Controller
{
    public function categories()
    {
        $categoryHelper = new CategoryHelper(Category::all()->toArray());

        $categories = array_map(fn($category) => [
            "id" => $category["id"],
            "name" => $category["name"],
            "label" => $category["label"]
        ], $categoryHelper->labeled);
        
        return response()->json($categories);
    }

    public function products()
    {
        $categories = Category::whereNull("parent_id")->inRandomOrder()->get()->transform(function($category)
        {
            $products = Product::whereNull("parent_id")->where("is_completed", true)->where("category_id", $category->id)->inRandomOrder()->limit(20)->get()->transform(fn($product) => [
                "id" => $product->id,
                "name" => $product->name,
                "price" => $product->price,
                "min_price" => $product->min_price,
                "max_price" => $product->max_price,
                "image" => explode("|", $product->images)[0]
            ]);

            return [
                "id" => $category->id,
                "name" => $category->name,
                "products" => $products
            ];
        });

        $responseData = [];

        foreach ($categories as $category) if(count($category["products"])) array_push($responseData, $category);

        return response()->json($responseData);
    }
}
