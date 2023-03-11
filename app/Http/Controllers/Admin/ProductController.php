<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        return view('admin.products.index', [
            'products' => Product::paginate(10)
        ]);
    }

    public function create()
    {
        return view('admin.products.create', [
            'categories' => Category::all()
        ]);
    }

    public function edit(Product $product)
    {
        return view('admin.products.edit', [
            'product' => $product,
            'categories' => Category::all()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:2|max:50',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|integer',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'stock' => 'required|integer',
            'short_description' => 'min:2|max:255',
            'long_description' => 'min:2|max:2000',
            'image' => 'required|image',
            'gallery_images' => 'array|max:10'
        ]);

        $product = Product::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'price' => $request->price,
            'is_featured' => $request->is_featured != null,
            'is_active' => $request->is_active != null,
            'stock' => $request->stock,
            'short_description' => $request->short_description,
            'long_description' => $request->long_description,
            'image_url' => $request->image->store('images/products', 'public')
        ]);

        if($request->gallery_images)
        {
            foreach ($request->gallery_images as $gallery_image) 
            {
                $product->images()->create([
                    'image_url' => $gallery_image->store('images/products', 'public')
                ]);
            }
        }
        
        return back()->with('success', 'Product created successfully');
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|min:2|max:50',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|integer',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'stock' => 'required|integer',
            'short_description' => 'min:2|max:255',
            'long_description' => 'min:2|max:2000',
            'image' => 'image',
            'gallery_images' => 'array|max:10'
        ]);

        $product->name = $request->name;

        $product->category_id = $request->category_id;

        $product->price = $request->price;

        $product->is_featured = $request->is_featured != null;

        $product->is_active = $request->is_active != null;

        $product->stock = $request->stock;

        $product->short_description = $request->short_description;

        $product->long_description = $request->long_description;

        if($request->image)
        {
            $product->image_url = $request->image->store('images/products', 'public');
        }

        if($request->gallery_images)
        {
            $product->images()->delete();
            
            foreach ($request->gallery_images as $gallery_image) 
            {
                $product->images()->create([
                    'image_url' => $gallery_image->store('images/products', 'public')
                ]);
            }
        }

        $product->save();

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return back()->with('success', 'Product deleted successfully');
    }
}
