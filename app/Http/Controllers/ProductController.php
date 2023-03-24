<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index(Request $request, Product $product)
    {
        $query = Product::orderBy('id', 'desc');

        if($request->featured)
        {
            $query->where('is_featured', true);
        }

        $products = $query->get();

        return response()->json($products);
    }

    public function product(Product $product)
    {
        $product->images = $product->images()->get();

        return response()->json($product);
    }
}
