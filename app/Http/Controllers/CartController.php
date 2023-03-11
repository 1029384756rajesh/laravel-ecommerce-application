<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;

class CartController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer',
        ]);

        if($request->user()->cart()->where('products.id', $request->product_id)->exists()) 
        {
            return response()->json(['error' => 'Product already exists in the cart'], 409);
        }

        $request->user()->cart()->attach($request->product_id, ['quantity' => $request->quantity]);

        return response()->json(['success' => 'Added to cart successfully']);
    }
}
