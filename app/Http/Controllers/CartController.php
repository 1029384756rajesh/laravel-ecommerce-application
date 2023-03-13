<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use Illuminate\Support\Facades\DB;
use App\Models\Setting;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $cart = $request->user()->cart()->select(['products.id', 'name', 'price', 'image_url'])->get();

        $setting = Setting::first();

        $product_price = 0;

        foreach ($cart as $cartItem) 
        {
            $product_price = $product_price + ($cartItem->price * $cartItem->pivot->quantity);
        }

        $gst_amount = round($product_price * ($setting->gst / 100));

        $total_amount = $gst_amount + $product_price + $setting->delivery_fee;

        return view('cart', [
            'cart' => $cart,
            'total_amount' => $total_amount,
            'product_price' => $product_price,
            'gst_amount' => $gst_amount,
            'settings' => $setting 
        ]);
    }

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

    public function destroy(Request $request)
    {
        $request->validate([
            'product_id' => 'required'
        ]);

        $request->user()->cart()->detach($request->product_id);

        return response()->json(['success' => 'Removed from cart successfully']);
    }

    public function destroyAll(Request $request)
    {
        $request->user()->cart()->detach();

        return response()->json(['success' => 'Removed all from cart successfully']);
    }

    public function updateAll(Request $request)
    {
        foreach ($request->cartItems as $cartItem) 
        {
            DB::table('cart')->where('user_id', $request->user()->id)->where('product_id', $cartItem['product_id'])->update(['quantity' => $cartItem['quantity']]);
        }

        return response()->json(['success' => 'Update all items successfully']);
    }
}
