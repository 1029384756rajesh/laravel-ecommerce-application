<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlist = $request->user()->wishlists()->get();

        return response()->json($wishlist);
    }

    public function store(Request $request, Product $product)
    {
        if($request->user()->wishlists()->where('products.id', $product->id)->exists()) 
        {
            return response()->json(['error' => 'Product already exists in the wishlist'], 409);
        }

        $request->user()->wishlists()->attach($product->id);

        return response()->json(['success' => 'Added to wishlist successfully']);
    }

    public function delete(Product $product)
    {
        $request->user()->wishlists()->detach($product->id);

        return response()->json(['success' => 'Removed from wishlist successfully']);
    }
}
