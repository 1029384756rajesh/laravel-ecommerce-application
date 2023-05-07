<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Setting;
use App\Models\Slider;
use App\Helpers\CategoryHelper;

class HomeController extends Controller
{
    public function about()
    {
        return view("about", ["about" => Setting::first()->about]);
    }
    public function products(Request $request)
    {
        $categoryHelper = new CategoryHelper(Category::all()->toArray());
   
        $query = Product::where("is_completed", true)->whereNull("parent_id");
        
        if($request->category_id) $query->where("category_id", $request->category_id);
        
        $products = $query->get()->transform(fn($product) => (object)[
            "id" => $product->id,
            "name" => $product->name,
            "min_price" => $product->min_price,
            "max_price" => $product->max_price,
            "price" => $product->price,
            "image" => explode("|", $product->images)[0]
        ]);

        return view("products", [
            "products" => $products, 
            "categories" => $categoryHelper->labeled
        ]);
    }

    public function search(Request $request)
    {
        $query = Product::where("is_completed", true);

        if($request->search)
        {
            $query->where(function($query) use($request)
            {
                $query->where("name", "like", "%{$request->search}%");
                    $query->orWhere("short_description", "like", "%{$request->search}%");
                    $query->orWhere("description", "like", "%{$request->search}%");
            });
        }

        $products = $query->get()->map(fn($product) => (object)[
            "id" => $product->id,
            "name" => $product->name,
            "price" => $product->price,
            "min_price" => $product->min_price,
            "max_price" => $product->max_price,
            "image" => explode("|", $product->images)[0],
        ]);

        return view("search", ["products" => $products]);
    }
    public function product($productId)
    {
        $product = Product::where("id", $productId)->where("is_completed", true)->first();

        if(!$product) abort(404);

        if($product->parent_id)
        {
            $parent = $product->parent()->with("attributes", "attributes.options", "variations", "variations.options")->first();

            $data = (object)[
                "id" => $product->id,
                "name" => $parent->name,
                "short_description" => $parent->short_description,
                "description" => $parent->description,
                "images" => $product->images ? explode("|", $product->images) : explode("|", $parent->images),
                "inStock" => $product->stock == null || $product->stock > 0,
                "price" => $product->price,
                "min_price" => null,
                "max_price" => null,
                "has_variations" => false,
                "attributes" => $parent->attributes,
                "options" => $product->options()->get()->map(fn($option) => $option->id)->toArray(),
                "variations" => $parent->variations->transform(fn($variation) => (object)[
                    "id" => $variation->id,
                    "options" => $variation->options->map(fn($option) => $option->id)
                ])
            ];
        }
        else if($product->has_variations)
        {
            $data = (object)[
                "id" => $product->id,
                "name" => $product->name,
                "short_description" => $product->short_description,
                "description" => $product->description,
                "images" => explode("|", $product->images),
                "inStock" => true,
                "price" => $product->price,
                "has_variations" => true,
                "min_price" => $product->min_price,
                "max_price" => $product->max_price,
                "attributes" => $product->attributes,
                "options" => [],
                "variations" => $product->variations->transform(fn($variation) => (object)[
                    "id" => $variation->id,
                    "options" => $variation->options->map(fn($option) => $option->id)
                ])
            ];
        }
        else 
        {
            $data = (object)[
                "id" => $product->id,
                "name" => $product->name,
                "short_description" => $product->short_description,
                "description" => $product->description,
                "images" => explode("|", $product->images),
                "inStock" => $product->stock == null || $product->stock > 0,
                "price" => $product->price,
                "min_price" => null,
                "has_variations" => false,
                "max_price" => null,
                "attributes" => [],
                "options" => [],
                "variations" => []
            ];
        }

        return view("product", ["product" => $data]);
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
        $categories = Category::inRandomOrder()->with("products")->get();
        
        $finalCategories = [];

        foreach ($categories as $category) 
        {
            $data = (object)[
                "name" => $category->name,
                "products" => []
            ];

            foreach ($category->products as $product) 
            {
                if($product->is_completed && !$product->parent_id) 
                {
                    array_push($data->products, (object)[
                        "id" => $product->id,
                        "name" => $product->name,
                        "min_price" => $product->min_price,
                        "max_price" => $product->max_price,
                        "price" => $product->price,
                        "image" => explode("|", $product->images)[0]
                    ]);
                }
            }

            if(count($data->products) > 0) 
            {
                array_slice($data->products, 0, 10);
                array_push($finalCategories, $data);
            }
        }

        return view("index", [
            "sliders" => Slider::all(),
            "categories" => $finalCategories
        ]);
    }
}
