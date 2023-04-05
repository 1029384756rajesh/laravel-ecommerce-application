<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $cart = $request->user()->cart()->get();

        $errors = [];

        $warnings = [];

        $results = [];

        foreach ($cart as $cartItem) 
        {
            $product = Product::where('id', $cartItem->product_id)->first();

            if(!$product)
            {
                array_push($errors, "Sorry, “" . $product->name . "” has been removed.");
                $cartItem->delete();
            }
            else if($product->stock < $cartItem->quantity)
            {
                array_push($errors, "Sorry, we do not have enough “" . $product->name . "” in stock to fulfill your order.");
            }
            else if($cartItem->price != $product->price)
            {
                array_push($warnings, "The price of “" . $product->name . "” has been changed.");
                $cartItem->price = $product->price;
                $cartItem->save();
            }
            else if($cartItem->name != $product->name)
            {
                array_push($warnings, "“" . $cartItem->name . "” has been renamed to " . "“" . $product->name . "”");
                $cartItem->name = $product->name;
                $cartItem->save();
            }
            else if($cartItem->image_url != $product->image_url)
            {
                $cartItem->image_url = $product->image_url;
                $cartItem->save();
            }

            if($product)
            {
                $cartItem->stock = $product->stock;
                array_push($results, $cartItem);
            }
        }

        return response()->json([
            'cart' => $results,
            'warnings' => $warnings,
            'errors' => $errors
        ]);
    }

    public function pricing(Request $request)
    {
        $cart = $request->user()->cart()->get();

        $hasError = false;

        foreach ($cart as $cartItem) 
        {
            $product = Product::where('id', $cartItem->id)->first();

            if(!($product && ($product->stock >= $cartItem->quantity) && ($cartItem->price == $product->price)))
            {
                $hasError = true;
                break;
            }
        }

        if($hasError)
        {
            return response()->json(['error' => 'Cart modified'], 400);
        }

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
            'productId' => 'required|exists:products,id',
            'quantity' => 'required|integer',
        ]);

        $product = Product::where('id', $request->productId)->first();

        if($product->stock < $request->quantity)
        {
            return response()->json(['error' => 'Not sufficient to fullfill'], 400);
        }

        $cartItem = $request->user()->cart()->where('product_id', $product->id)->first();

        if($cartItem)
        {
            $cartItem->quantity = $request->quantity;
            $cartItem->save();
        }
        else 
        {
            $cartItem = $request->user()->cart()->create([
                'product_id' => $product->id,
                'quantity' => $request->quantity,
                'name' => $product->name,
                'price' => $product->price,
                'image_url' => $product->image_url,
            ]);
        }

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
            'cart.*.productId' => 'required|exists:cart,product_id',
            'cart.*.quantity' => 'required|integer',
        ]);

        foreach ($request->cart as $cartItem) 
        {
            $item = $request->user()->cart()->where('product_id', $cartItem["productId"])->first();

            if($item)
            {
                $item->quantity = $cartItem["quantity"];

                $item->save();
            }
        }

        return response()->json(['success' => 'Update all items successfully']);
    }
}
