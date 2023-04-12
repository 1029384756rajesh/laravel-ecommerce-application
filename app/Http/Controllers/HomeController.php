<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Slider;

class HomeController extends Controller
{
    public function product(Product $product)
    {
        $product->attributes = $product->attributes()->with("options")->get();
        $product->variations = $product->variations()->with("options")->get()->transform(function($variation)
        {
            $variation->options = $variation->options->transform(fn($option) => $option->id);
            return $variation;
        });
        // dd($product->attributes->toArray());
        return view("product", ["product" => $product]);
    }
    public function index(Request $request)
    {
        $products = Product::where("is_published", true)->with("variations")->get()->transform(function($product)
        {
            if($product->has_variations)
            {
                $priceData = $this->getPriceRange($product->variations);

                if($priceData["minPrice"] == $priceData["maxPrice"]) $product->price = $priceData["minPrice"];

                else 
                {
                    $product->min_price = $priceData["minPrice"];
                    $product->max_price = $priceData["maxPrice"];
                }
            }

            return $product;
        });

        return view("index", [
            "sliders" => Slider::all(),
            "categories" => Category::all(),
            "products" => $products
        ]);
    }

    
    private function getPriceRange($variations)
    {
        $minPrice = 1000000;

        $maxPrice = 0;

        foreach ($variations as $variation) 
        {
            if($variation->price < $minPrice) $minPrice = $variation->price;
            
            if($variation->price > $maxPrice) $maxPrice = $variation->price;
        }

        return [
            'minPrice' => $minPrice === 1000000 ? 0 : $minPrice,
            'maxPrice' => $maxPrice
        ];
    }
}
