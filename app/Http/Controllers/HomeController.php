<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Slider;

class HomeController extends Controller
{
    public function products(Request $request)
    {
        $ch = new \App\Helpers\CategoryHelper();

        $categories = \App\Models\Category::all()->toArray();
   
        $parentCategory = $ch->getParents($categories);
   
        $ch->categories = $categories;
   
        $ch->setChildren($parentCategory);
      
        $category_list = $ch->getUlFromCategories($parentCategory);
   
        $products = Product::all();

        if($request->cid)
        {
            $products = Product::where('category_id', $request->cid)->get();
        }
        $categories = Category::all();
        return view("products", ["products" => $products, "category_list" => $category_list]);
    }

    public function search(Request $request)
    {
        $query = Product::where("is_published", true);

        if($request->search)
        {
            $query->where("name", "like", "%{$request->search}%");
            $query->orWhere("short_description", "like", "%{$request->search}%");
            $query->orWhere("description", "like", "%{$request->search}%");
        }

        $products = $query->get();
        return view("search", ["products" => $products]);
    }
    public function product($productId)
    {
        $product = Product::where("id", $productId)->where("is_published", true)->with("attributes", "attributes.options", "variations", "variations.options")->first();

        if(!$product) abort(404);

        $product->variations = $product->variations->transform(function($variation)
        {
            $variation->options = $variation->options->transform(fn($option) => $option->id);
            return $variation;
        });

        if($product->has_variations)
        {
            $priceRange = $this->getPriceRange($product->variations);
            
            if($priceRange['minPrice'] == $priceRange['maxPrice'])
            {
                $product->price = $priceRange['minPrice'];
            }
            else 
            {
                $product->min_price = $priceRange['minPrice'];
                $product->max_price = $priceRange['maxPrice'];
            }
        }

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
