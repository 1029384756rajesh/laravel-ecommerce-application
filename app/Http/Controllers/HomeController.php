<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Slider;
use App\Models\Product;
use App\Models\Category;
use App\Models\Setting;

class HomeController extends Controller
{
    public function index()
    {
        return view('index', [
            'sliders' => Slider::all(),
            'categories' => Category::all(),
            'products' => Product::where('is_featured', true)->get(),
        ]); 
    }

    public function products(Request $request)
    {
        $query = Product::orderBy('created_at', 'asc');

        if($request->category_ids)
        {
            $query->whereIn('category_id', $request->category_ids);
        }

        if($request->search_query)
        {
            $query->where('name', 'like', '%' . $request->search_query . '%')
                ->orWhere('short_description', 'like', '%' . $request->search_query . '%');
        }

        $products = $query->get();

        $categories = Category::all();

        session()->flashInput($request->input());

        return view('products', [
            'products' => $products,
            'categories' => $categories
        ]);
    }

    public function about()
    {
        return view('about', ['about' => Setting::first()->about]);
    }

    public function product($productId)
    {
        $product = Product::where('id', $productId)->with('reviews', 'images')->first();
        
        return view('product', ['product' => $product]);
    }
}
