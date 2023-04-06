<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Product;

class ProductController extends Controller
{
    public function getMinPrice($variations)
    {
        $minPrice = $variations[0]['price'];

        foreach ($variations as $variation) 
        {
            if($variation['price'] < $minPrice)
            {
                $minPrice = $variation['price'];
            }
        }

        return $minPrice;
    }
    public function index(Request $request)
    {
        Log::debug($request->search);
        $request->validate([
            'categories' => 'array',
            'categories.*' => 'integer'
        ]);

        $query = Product::orderBy('id', 'desc');

        if($request->featured)
        {
            $query->where('is_featured', true);
        }

        if($request->search)
        {
            $query->where(function($query) use ($request) {
                $query->where('name', 'like', '%' . $request->search . '%');
                $query->orWhere('short_description', 'like', '%' . $request->search . '%');
                $query->orWhere('long_description', 'like', '%' . $request->search . '%');  
            });
        }



        if($request->categories)
        {
            $query->whereIn('category_id', $request->categories);
        }

        $query->where('is_active', true);

        $query->limit($request->limit ? $request->limit : 10);

        $query->skip($request->offset ? $request->offset : 0);

        if($request->category_id)
        {
            $query->whereIn('category_id', $request->category_id);
        }

        $products = $query->get();

        return response()->json($products);
    }

    public function product(Product $product)
    {
        $product->images = explode("|", $product->gallery);

        return response()->json($product);
    }
}
