<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class WishlistController extends Controller
{
    public function index(Request $request)
    {
        $wishlist = $request->user()->wishlists()->get();

        return response()->json($wishlist);
    }

    public function store(Request $request, Product $product)
    {
        if(!$request->user()->wishlists()->where('products.id', $product->id)->exists()) 
        {
            $request->user()->wishlists()->attach($product->id);
        }

        return response()->json(['success' => 'Added to wishlist successfully']);
    }

    public function delete(Request $request, Product $product)
    {
        $request->user()->wishlists()->detach($product->id);

        return response()->json(['success' => 'Removed from wishlist successfully']);
    }
}
