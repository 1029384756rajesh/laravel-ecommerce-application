<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Helpers\VariationHelper;
use App\Helpers\CategoryHelper;

class ProductController extends Controller
{ 
    public function products()
    {
        $products = Product::whereNull("parent_id")->orderBy("id", "desc")->with("variations", "category")->get()->transform(fn($product) => (object)[
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

        return view("admin.products.index", ["products" => $products]);
    }

    public function edit(Product $product)
    {
        $data = (object)[
            "id" => $product->id,
            "name" => $product->name,
            "short_description" => $product->short_description,
            "description" => $product->description,
            "category_id" => $product->category_id,
            "has_variations" => $product->has_variations,
            "price" => $product->price,
            "stock" => $product->stock,
            "images" => explode("|", $product->images)
        ];

        $categoryHelper = new CategoryHelper(Category::all()->toArray());

        return view("admin.products.edit", [
            "product" => $data,
            "categories" => $categoryHelper->labeled
        ]);
    }

    public function create()
    {
        $categoryHelper = new CategoryHelper(Category::all()->toArray());

        return view("admin.products.create", ["categories" => $categoryHelper->labeled]);
    }

    public function store(Request $request)
    {
        $baseRules = [
            "name" => "required|max:40",
            "short_description" => "nullable|max:255",
            "description" => "nullable|max:5000",
            "category_id" => "required|exists:categories,id",
            "has_variations" => "nullable|boolean",
            "images" => "required|array|min:1|max:5",
            "images.*" => "required|file|mimes:jpg,jpeg,png"
        ];

        if($request->has_variations)
        {
            $data = $request->validate($baseRules);

            $data["is_completed"] = false;

            $data["images"] = array_map(function($image) {
                return $image->store('images', 'public');
            }, $data["images"]);

            $data["images"] = implode("|", $data["images"]);

            $product = Product::create($data);

            return redirect("/admin/products/$product->id/attributes");
        }
        else 
        {
            $data = $request->validate(array_merge($baseRules, [
                "price" => "required|integer|min:0",
                "stock" => "nullable|integer|min:0"
            ]));

            $data["is_completed"] = true;

            $data["images"] = array_map(function($image) {
                return $image->store("images", 'public');
            }, $data["images"]);

            $data["images"] = implode("|", $data["images"]);

            $product = Product::create($data);

            return redirect("/admin/products")->with("success", "Product created successfully");
        }
    }

    public function update(Request $request, Product $product)
    {
        $baseRules = [
            "name" => "required|max:40",
            "short_description" => "nullable|max:255",
            "description" => "nullable|max:5000",
            "category_id" => "required|exists:categories,id",
            "has_variations" => "required|boolean",
            "images" => "nullable|array|max:10",
            "images.*" => "nullable|file|mimes:jpg,jpeg,png",
        ];

        if($request->has_variations && $product->has_variations)
        {
            $data = $request->validate($baseRules);

            if(isset($data["images"]) && count($data["images"]) > 0)
            {
                $data["images"] = array_map(function($image) {
                    return $image->store("images", 'public');
                }, $data["images"]);
    
                $data["images"] = implode("|", $data["images"]);
            }

            $product->update($data);
        }
        else if($request->has_variations && !$product->has_variations)
        {
            $data = $request->validate($baseRules);

            $data["is_completed"] = false;

            $data["price"] = null;

            $data["stock"] = null;

            if(isset($data["images"]) && count($data["images"]) > 0)
            {
                $data["images"] = array_map(function($image) {
                    return $image->store("images", 'public');
                }, $data["images"]);
    
                $data["images"] = implode("|", $data["images"]);
            }

            $product->update($data);

            return redirect("/admin/products/$product->id/attributes");
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

            if(isset($data["images"]) && count($data["images"]) > 0)
            {
                $data["images"] = array_map(function($image) {
                    return $image->store("images", 'public');
                }, $data["images"]);
    
                $data["images"] = implode("|", $data["images"]);
            }

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

            if(isset($data["images"]) && count($data["images"]) > 0)
            {
                $data["images"] = array_map(function($image) {
                    return $image->store("images", 'public');
                }, $data["images"]);
    
                $data["images"] = implode("|", $data["images"]);
            }

            $product->update($data);
        }

        return redirect("/admin/products")->with("success", "Product updated successfully");
    }

    public function delete(Product $product)
    {
        $product->delete();

        return back()->with("success", "Product deleted successfully");
    }

    public function attributes(Product $product)
    {
        $attributes = $product->attributes()->with("options")->get()->transform(fn($attribute) => (object)[
            "name" => $attribute->name,
            "options" => $attribute->options->map(fn($option) => $option->name)
        ]);

        return view("admin.products.attributes", [
            "attributes" => $attributes,
            "product" => $product
        ]);
    }

    public function storeAttributes(Request $request, Product $product)
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
        $variationHelper = new VariationHelper();

        $variations = $variationHelper->getVariationIds($product->attributes()->with('options')->get()->toArray());

        foreach ($variations as $variation) 
        {
            $newVariation = $product->variations()->create();

            foreach ($variation as $option) $newVariation->options()->attach($option);
        }

        return response()->json($product);
    }
    
    public function variations(Product $product)
    {
        $variations = $product->variations()->with("options", "options.attribute")->get()->transform(fn($variation) => (object)[
            "id" => $variation->id,
            "price" => $variation->price,
            "stock" => $variation->stock,
            "images" => $variation->images ? explode("|", $variation->images) : [],
            "attributes" => $variation->options->map(fn($option) => (object)[
                "name" => $option->attribute->name,
                "option" => $option->name
            ])
        ]);

        return view("admin.products.variations", [
            "product" => $product,
            "variations" => $variations
        ]);
    }

    public function updateVariations(Product $product, Request $request)
    {
        $productVariations = $product->variations()->get();

        $totalVariations = count($productVariations);

        $data = $request->validate([
            "variations" => "required|array|min:$totalVariations|max:$totalVariations",
            "variations.*.id" => "required|integer",
            "variations.*.stock" => "nullable|integer|min:0",
            "variations.*.price" => "required|integer|min:0",
        ]);

        foreach ($data["variations"] as $requestVariation) 
        {
            $isExists = false;

            foreach ($productVariations as $productVariation) 
            {
               if($requestVariation["id"] == $productVariation["id"]) 
               {
                    $isExists = true;
                    break;
               }
            }

            if(!$isExists) return abort(403);
        }

        foreach ($data["variations"] as $variation) 
        {
            $variation["is_completed"] = true;

            $product->variations()->where("id", $variation["id"])->update($variation);
        }

        if(!$product->is_completed) $product->is_completed = true;

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
