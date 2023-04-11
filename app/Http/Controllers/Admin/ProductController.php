<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Variation;
use App\Helpers\VariationHelper;

class ProductController extends Controller
{ 
    public function edit(Product $product)
    {
        return view('admin.products.edit', [
            'categories' => Category::all(),
            'product' => $product
        ]);
    }
    
    public function editVariations(Request $request, Product $product)
    {
        $variations = $product->variations()->with("options", "options.attribute")->get()->transform(function($variation)
        {
            $variation->options = $variation->options->transform(fn($option) => (object)["name" => $option->name, "attribute" => $option->attribute->name]);
        
            return $variation;
        });

        return view("admin.products.variations", [
            "variations" => $variations, 
            "product_id" => $product->id
        ]);
    }

    public function updateVariations(Product $product, Request $request)
    {
        $variations = $product->variations()->get();

        $request->validate([
            'variations' => "required|array|min:" . count($variations) . "|max:" . count($variations),
            'variations.*.price' => "required|integer",
            "variations.*.stock" => 'nullable|integer'
        ]);

        foreach ($request->variations as $variation) Variation::where("id", $variation["id"])->update($variation);

        if(!$product->is_published) $product->is_published = true;

        $product->save();

        return redirect("/admin/products")->with(["success" => "Variations updated successfully"]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            "name" => "required|max:100",
            "short_description" => "nullable|max:255",
            "description" => "nullable|max:5000",
            "category_id" => "required|exists:categories,id",
            "image_url" => "required",
            "is_featured" => "required|boolean",
            "has_variations" => "required|boolean"     
        ]);

        if($request->has_variations)
        {
            $validated["is_published"] = false;

            $product = Product::create($validated);

            return redirect("/admin/products/{$product->id}/attributes");
        }

        $extra = $request->validate([
            "price" => "required|integer|min:0",
            "stock" => "nullable|integer|min:0"
        ]);

        $extra["is_published"] = true;

        $product = Product::create(array_merge($validated, $extra));

        return back()->with("success", "Product created successfully");
    }

    public function attributes(Product $product)
    {
        $product->attributes = $product->attributes()->get();

        return view("admin.products.attributes", [
            "attributes" => $product->attributes,
            "product_id" => $product->id 
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|max:100',
            'short_description' => 'nullable|max:255',
            'description' => 'nullable|max:5000',
            'category_id' => 'required|exists:categories,id',
            'image_url' => 'required',
            'is_featured' => 'required|boolean',
            'has_variations' => 'required|boolean'
        ]);

        if($product->has_variations && !$request->has_variations)
        {
            $request->validate([
                'price' => 'required|integer|min:0',
                'stock' => 'nullable|integer|min:0' 
            ]);

            $product->attributes()->delete();

            $product->variations()->delete();
       
            $product->price = $request->price;

            $product->stock = $request->stock;

            $product->is_published = true;
        }

        else if(!$product->has_variations && $request->has_variations)
        {
            $product->price = null;

            $product->stock = null;

            $product->is_published = false;
        }

        else if(!$product->has_variations && !$request->has_variations)
        {
            $request->validate([
                'price' => 'required|integer|min:0',
                'stock' => 'nullable|integer|min:0'
            ]);

            $product->price = $request->price;

            $product->stock = $request->stock;
        }

        $product->name = $request->name;

        $product->short_description = $request->short_description;

        $product->description = $request->description;
        
        $product->category_id = $request->category_id;

        $product->is_featured = $request->is_featured;

        $product->has_variations = $request->has_variations;

        $product->image_url = $request->image_url;

        $product->save();

        return redirect("/admin/products")->with("success", "Product updated successfully");
    }

    public function storeAttributes(Request $request, Product $product)
    {
        if(!$product->has_variations) return response()->json(['error' => 'Not applicable'], 422);

        $request->validate([
            'attributes' => 'array|min:1',
            'attributes.*.name' => 'required|max:30',
            'attributes.*.options' => 'required|array|min:1',
            'attributes.*.options.*' => 'required|max:20'
        ]);

        $product->attributes()->delete();

        $product->variations()->delete();

        foreach ($request['attributes'] as $attribute) 
        {
            $newAttribute = $product->attributes()->create(['name' => $attribute['name']]);

            foreach ($attribute['options'] as $option) $newAttribute->options()->create(['name' => $option]);
        }

        $product->is_published = false;

        $product->save();

        return $this->storeVariations($product);
    }

    public function delete(Product $product)
    {
        $product->delete();
        return back()->with("success", "Product deleted successfully");
    }

    public function index(Request $request)
    {
        $products = Product::with('variations')->get()->transform(function($product) use($request)
        {
            if($product->has_variations)
            {
                $priceRange = $this->getPriceRange($product->variations);

                if($priceRange["minPrice"] == $priceRange["maxPrice"]) $product->price = $priceRange["minPrice"];

                else 
                {
                    $product->min_price = $priceRange["minPrice"];
                    $product->max_price = $priceRange["maxPrice"];
                }
            }
            
            return $product;
        });

        return view("admin.products.index", ["products" => $products]);
    }

    public function create()
    {
        return view("admin.products.create", ["categories" => Category::all()]);
    }

    public function product($productId)
    {
        $product = Product::where('id', $productId)->with('attributes', 'attributes.options', 'variations', 'variations.options')->first();

        if(!$product) return response()->json(['error' => 'Product not found'], 404);

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

            $product->variations = $product->variations->transform(fn($variation) => [
                'id' => $variation['id'],
                'stock' => $variation['stock'],
                'price' => $variation['price'],
                'image_url' => $variation['image_url'],
                'options' => $variation->options->map(fn($option) => $option->id),
            ]);
        }

        return view('admin.products.attributes', ['attributes' => $product->attributes, 'id' => $product->id]);
    }

    private function storeVariations($product)
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
