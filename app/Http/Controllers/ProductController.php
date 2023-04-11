<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Product;
use App\Models\Variation;
use App\Models\Category;
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
    
    public function variations(Request $request, Product $product)
    {
        $variations = $product->variations()->with('options', 'options.attribute')->get()->transform(function($variation)
        {
            $variation->options = $variation->options->transform(fn($option) => ['name' => $option->name, 'attribute' => $option->attribute->name]);
        
            return $variation;
        });

        // return response()->json($variation);

        return view('admin.products.variations', ['variations' => $variations, 'id' => $product->id]);
    }

    public function editVariations(Product $product, Request $request)
    {
        $variations = $product->variations()->get();

        $request->validate([
            'variations' => "required|array|min:" . count($variations) . "|max:" . count($variations),
            'variations.*.price' => "required|integer",
            "variations.*.stock" => 'nullable|integer'
        ]);

        foreach ($request->variations as $variation) Variation::where('id', $variation['id'])->update($variation);

        if(!$product->is_published) $product->is_published = true;

        $product->save();

        // return response()->json(['success' => 'Variant updated successfully']);

        return back()->with(['message' => 'Variations updated successfully']);
    }

    public function store(Request $request)
    {
        if($request->has_variations)
        {
            $validated = $request->validate([
                'name' => 'required|max:100',
                'short_description' => 'nullable|max:255',
                'description' => 'nullable|max:5000',
                'category_id' => 'required|exists:categories,id',
                'image_url' => 'required',
                'is_featured' => 'required|boolean',
                'has_variations' => 'required|boolean'         
            ]);

            $validated['is_published'] = false;

            $product = Product::create($validated);

            return response()->json($product);
        }
        else 
        {
            $validated = $request->validate([
                'name' => 'required|max:100',
                'short_description' => 'nullable|max:255',
                'description' => 'nullable|max:5000',
                'category_id' => 'required|exists:categories,id',
                'price' => 'required|integer|min:0',
                'stock' => 'nullable|integer|min:0',
                'image_url' => 'required',
                'is_featured' => 'required|boolean',
                'has_variations' => 'required|boolean'     
            ]);

            $validated['is_published'] = true;

            $product = Product::create($validated);

            return response()->json($product);
        }
    }

    public function update(Request $request, Product $product)
    {
        // dd($request);
        if($product->has_variations && !$request->has_variations)
        {
            $request->validate([
                'name' => 'required|max:100',
                'short_description' => 'nullable|max:255',
                'description' => 'nullable|max:5000',
                'category_id' => 'required|exists:categories,id',
                'price' => 'required|integer|min:0',
                'stock' => 'nullable|integer|min:0',
                'image_url' => 'required',
                'is_featured' => 'required|boolean'    
            ]);

            $product->attributes()->delete();

            $product->variations()->delete();

            $product->name = $request->name;

            $product->short_description = $request->short_description;

            $product->description = $request->description;

            $product->price = $request->price;

            $product->stock = $request->stock;

            $product->image_url = $request->image_url;

            $product->is_featured = $request->is_featured;

            $product->has_variations = false;

            $product->is_published = true;

            $product->save();
        }
        else if(!$product->has_variations && $request->has_variations)
        {
            $request->validate([
                'name' => 'required|max:100',
                'short_description' => 'nullable|max:255',
                'description' => 'nullable|max:5000',
                'category_id' => 'required|exists:categories,id',
                'is_featured' => 'required|boolean'
            ]);

            $product->price = null;

            $product->stock = null;

            $product->image_url = null;

            $product->is_published = false;

            $product->name = $request->name;

            $product->short_description = $request->short_description;

            $product->description = $request->description;

            $product->category_id = $request->category_id;

            $product->is_featured = $request->is_featured;

            $product->has_variations = true;

            $product->save();
        }
        else if($product->has_variations && $request->has_variations)
        {
            $request->validate([
                'name' => 'required|max:100',
                'short_description' => 'nullable|max:255',
                'description' => 'nullable|max:5000',
                'category_id' => 'required|exists:categories,id',
                'is_featured' => 'required|boolean'    
            ]);

            $product->name = $request->name;

            $product->short_description = $request->short_description;

            $product->description = $request->description;

            $product->category_id = $request->category_id;

            $product->is_featured = $request->is_featured;

            $product->save();
        }
        else if(!$product->has_variations && !$request->has_variations)
        {
            $request->validate([
                'name' => 'required|max:100',
                'short_description' => 'nullable|max:255',
                'description' => 'nullable|max:5000',
                'category_id' => 'required|exists:categories,id',
                'price' => 'required|integer|min:0',
                'stock' => 'nullable|integer|min:0',
                'image_url' => 'required',
                'is_featured' => 'required|boolean'    
            ]);

            $product->name = $request->name;

            $product->short_description = $request->short_description;

            $product->description = $request->description;

            $product->price = $request->price;

            $product->stock = $request->stock;

            $product->image_url = $request->image_url;

            $product->is_featured = $request->is_featured;

            $product->save();
        }

        return response()->json($product);
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
        return response()->json($product);
    }

    public function index(Request $request)
    {
        $products = Product::where('is_published', true)->with('variations')->get()->transform(function($product) use($request)
        {
            $productData = [
                'id' => $product->id,
                'name' => $product->name,
                'has_variations' => $product->has_variations == 1
            ];

            if($product->has_variations)
            {
                $priceRange = $this->getPriceRange($product->variations);

                if($priceRange['minPrice'] == $priceRange['maxPrice']) 
                {
                    $productData['price'] = $priceRange['minPrice'];
                }
                else 
                {
                    $productData['minPrice'] = $priceRange['minPrice'];
                    $productData['maxPrice'] = $priceRange['maxPrice'];
                }
            }
            else
            {
                $productData['price'] = $product->price;
            }

            return $productData;
        });

        return response()->json($products);
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
            'minPrice' => $minPrice,
            'maxPrice' => $maxPrice
        ];
    }
}
