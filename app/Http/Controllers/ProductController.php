<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Product;

class ProductController extends Controller
{
    public function storeProduct()
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'short_description' => 'max:255',
            'description' => 'max:5000',
            'category' => 'required|exists:categories.id',
            'is_featured' => 'required|boolean',
            'has_variations' => 'required|boolean'
        ]);

        $validated['published'] = !$request->has_variations;

        $product = Product::create($validated);

        return response()->json($product);
    }
    public function storeAttributes(Product $product)
    {
        $request->validate([
            'attributes' => 'array|min:1',
            'attributes.*.name' => 'required|max:30',
            'attributes.*.options' => 'required|array|min:2',
            'attributes.*.options.*' => 'required|max:20'
        ]);

        $product->attributes()->delete();

        $product->variations()->delete();

        foreach ($request->attributes as $attribute) 
        {
            $attributes = $product->attributes()->create(['name' => $attribute->name]);

            foreach ($attributes->options as $option) 
            {
                $attributes->options()->create(['name' => $option]);
            }
        }



        $validated['published'] = !$request->has_variations;

        $product = Product::create($validated);

        return response()->json($product);
    }

    public function index(Request $request)
    {
        $request->validate(['categoryIds' => 'array', 'categoryIds.*' => 'integer']);

        $query = Product::orderBy('id', 'desc')->where('published', true);

        if($request->is_featured) $query->where('is_featured', true);

        if($request->search) $query->where(function($query) use ($request){
            $query->where('name', 'like', '%' . $request->search . '%');

            $query->orWhere('short_description', 'like', '%' . $request->search . '%');

            $query->orWhere('description', 'like', '%' . $request->search . '%');  
        });

        if($request->categoryIds) $query->whereIn('category_id', $request->categoryIds);

        if($request->category_id) $query->whereIn('category_id', $request->category_id);

        $products = $query->select('id', 'image_url', 'has_variations', 'price', 'min_price', 'max_price')->get();

        return response()->json($products);
    }

    public function product(Product $product)
    {
        $product->variations = $product->variations()->with('options')->get()->map(fn($variation) => [
            'id' => $variation->id,
            'price' => $variation->price,
            'stock' => $variation->stock,
            'optionIds' => $variation->options->map(fn($option) => $option->id)
        ]);

        $product->attributes = $product->attributes()->with('options')->get()->map(fn($attribute) => [
            'name' => $attribute->name,
            'options' => $attribute->options->map(fn($option) => [
                'id' => $option->id,
                'name' => $option->name
            ])
        ]);

        return response()->json($product);
    }
}
