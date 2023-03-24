<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $cart = $request->user()->cart()->get();

        return response()->json($cart);
    }

    public function pricing(Request $request)
    {
        $setting = Setting::first();

        $productPrice = 0;

        foreach ($cart as $cartItem) 
        {
            $productPrice += $cartItem->price * $cartItem->quantity;
        }

        $gstAmount = round($productPrice * ($setting->gst / 100));

        $totalAmount = $gstAmount + $productPrice + $setting->delivery_fee;

        return response()->json([
            'totalAmount' => $totalAmount,
            'productPrice' => $productPrice,
            'gstAmount' => $gstAmount,
            'shippingCost' => $setting->shippingCost
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer',
        ]);

        $product = Product::where('id', $request->product_id)->first();

        $cartItem = $request->user()->cart()->where('product_id', $product->id)->first();

        if($cartItem) 
        {
            $cartItem->quantity = $request->quantity;

            $cartItem->save();

            return response()->json($cartItem);
        }

        $cartItem = $request->user()->cart()->create([
            'product_id' => $product->id,
            'name' => $product->name,
            'image_url' => $product->image_url,
            'price' => $product->price,
            'quantity' => $request->quantity,
        ]);

        return response()->json($cartItem);
    }

    public function delete(Request $request, Cart $cart)
    {
        $cart->delete();

        return response()->json($cart);
    }

    public function deleteAll(Request $request)
    {
        $request->user()->cart()->delete();

        return response()->json(['success' => 'Removed all from cart successfully']);
    }

    public function updateAll(Request $request)
    {
        $request->validate([
            'cart.*.product_id' => 'required|exists:cart,product_id',
            'cart.*.quantity' => 'required|integer',
        ]);

        foreach ($request->cart as $cartItem) 
        {
            $item = $request->user()->cart()->where('product_id', $cartItem->product_id)->first();

            if($item)
            {
                $item->quantity = $cartItem->quantity;

                $item->save();
            }
        }

        return response()->json(['success' => 'Update all items successfully']);
    }
}
