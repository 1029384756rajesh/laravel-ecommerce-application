<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Helpers\VariationHelper;
use App\Helpers\CategoryHelper;

class ProductController extends Controller
{ 
    public function index()
    {
        $products = Product::whereNull("parent_id")->orderBy("id", "desc")->with("variations", "category")->get()->transform(fn($product) => [
            "id" => $product->id,
            "name" => $product->name,
            "price" => $product->price,
            "min_price" => $product->min_price,
            "max_price" => $product->max_price,
            "has_variations" => $product->has_variations == 1,
            "is_completed" => $product->is_completed == 1,
            "category" => $product->category->name,
            "image" => explode("|", $product->images)[0]
        ]);

        return response()->json($products);
    }

    public function product(Product $product)
    {
        return response()->json([
            "id" => $product->id,
            "name" => $product->name,
            "short_description" => $product->short_description,
            "description" => $product->description,
            "category_id" => $product->category_id,
            "has_variations" => $product->has_variations,
            "price" => $product->price,
            "stock" => $product->stock,
            "images" => explode("|", $product->images)
        ]);
    }

    public function create(Request $request)
    {
        $baseRules = [
            "name" => "required|max:40",
            "short_description" => "nullable|max:255",
            "description" => "nullable|max:5000",
            "category_id" => "required|exists:categories,id",
            "has_variations" => "nullable|boolean",
            "images" => "required|array|min:1|max:20"
        ];

        if($request->has_variations)
        {
            $data = $request->validate($baseRules);

            $data["is_completed"] = false;

            $data["images"] = implode("|", $request->images);

            $product = Product::create($data);

            return response()->json($product);
        }
        else 
        {
            $data = $request->validate(array_merge($baseRules, [
                "price" => "required|integer|min:0",
                "stock" => "nullable|integer|min:0"
            ]));

            $data["is_completed"] = true;

            $data["images"] = implode("|", $request->images);

            $product = Product::create($data);

            return response()->json($product);
        }
    }

    public function edit(Request $request, Product $product)
    {
        $baseRules = [
            "name" => "required|max:40",
            "short_description" => "nullable|max:255",
            "description" => "nullable|max:5000",
            "category_id" => "required|exists:categories,id",
            "has_variations" => "required|boolean",
            "images" => "required|array|min:1|max:10"
        ];

        if($request->has_variations && $product->has_variations)
        {
            $data = $request->validate($baseRules);

            $data["images"] = implode("|", $data["images"]);

            $product->update($data);
        }
        else if($request->has_variations && !$product->has_variations)
        {
            $data = $request->validate($baseRules);

            $data["is_completed"] = false;

            $data["price"] = null;

            $data["stock"] = null;

            $data["images"] = implode("|", $data["images"]);

            $product->update($data);
        }
        else if(!$request->has_variations && $product->has_variations)
        {
            $data = $request->validate(array_merge($baseRules, [
                "price" => "required|integer|min:0",
                "stock" => "nullable|integer|min:0"
            ]));

            $data["is_completed"] = true;

            $data["min_price"] = null;

            $data["max_price"] = null;

            $data["images"] = implode("|", $data["images"]);

            $product->update($data);

            $product->attributes()->delete();

            $product->variations()->delete();
        }
        else if(!$request->has_variations && !$product->has_variations)
        {
            $data = $request->validate(array_merge($baseRules, [
                "price" => "required|integer|min:0",
                "stock" => "nullable|integer|min:0",
            ]));

            $data["images"] = implode("|", $data["images"]);

            $product->update($data);
        }

        return response()->json(["success" => "Product edited successfully"]);
    }

    public function delete(Product $product)
    {
        $product->delete();

        return response()->json($product);
    }

    public function attributes(Product $product)
    {
        $attributes = $product->attributes()->with("options")->get()->transform(fn($attribute) => [
            "name" => $attribute->name,
            "options" => $attribute->options->map(fn($option) => $option->name)
        ]);

        return response()->json($attributes);
    }

    public function createAttributes(Request $request, Product $product)
    {
        $request->validate([
            "attributes" => "required|array|min:1",
            "attributes.*.name" => "required|max:40",
            "attributes.*.options" => "required|array|min:1"
        ]);

        $product->variations()->delete();

        $product->is_completed = false;

        $product->save();

        $product->attributes()->delete();
     
        foreach ($request->input("attributes") as $attribute) 
        {
            $newAttribute = $product->attributes()->create(["name" => $attribute["name"]]);

            foreach ($attribute["options"] as $option) $newAttribute->options()->create(["name" => $option]);
        }

        $this->createVariations($product);

        return response()->json(["success" => "Attribute updated successfully"]);
    }

    public function createVariations($product)
    {
        $variationHelper = new VariationHelper;

        $variations = $variationHelper->getVariationIds($product->attributes()->with('options')->get()->toArray());

        foreach ($variations as $variation) 
        {
            $newVariation = $product->variations()->create(['stock' => 0]);

            foreach ($variation as $option) $newVariation->options()->attach($option);
        }

        return response()->json($product);
    }
    
    public function variations(Product $product)
    {
        $variations = $product->variations()->with("options", "options.attribute")->get()->transform(function($variation)
        {
            return [
                "id" => $variation->id,
                "price" => $variation->price,
                "stock" => $variation->stock,
                "images" => $variation->images ? explode("|", $variation->images) : [],
                "attributes" => $variation->options->map(fn($option) => [
                    "name" => $option->attribute->name,
                    "option" => $option->name
                ])
            ];
        });

        return response()->json($variations);
    }

    public function editVariations(Product $product, Request $request)
    {
        $variations = $request->validate([
            "variations" => "required|array",
            "variations.*.id" => "required|integer",
            "variations.*.stock" => "nullable|integer",
            "variations.*.price" => "required|integer",
            "variations.*.images" => "nullable|array|max:20"
        ]);

        foreach ($variations["variations"] as $variation) 
        {
            $variation["images"] = isset($variation["images"]) ? implode("|", $variation["images"]) : [];
            $product->variations()->where("id", $variation["id"])->update($variation);
        }

        if(!$product->is_completed)
        {
            $product->is_completed = true;
            $product->save();
        }

        $minPrice = $product->variations()->min("price");

        $maxPrice = $product->variations()->max("price");

        if($minPrice == $maxPrice) 
        {
            $product->price = $minPrice;
            $product->min_price = null;
            $product->max_price = null;
        }
        else 
        {
            $product->min_price = $minPrice;
            $product->max_price = $maxPrice;
            $product->price = null;
        }

        $product->save();

        return response()->json(["success" => "Product updated successfully"]);
    }
}
