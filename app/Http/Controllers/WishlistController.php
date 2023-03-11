<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        if($request->user()->wishlists()->where('products.id', $request->product_id)->exists()) 
        {
            return response()->json(['error' => 'Product already exists in the wishlist'], 409);
        }

        $request->user()->wishlists()->attach($request->product_id);

        return response()->json(['success' => 'Added to wishlist successfully']);
    }
}
