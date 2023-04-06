<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Setting;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $cart = $request->user()->cart()->first();

        if(!$cart)
        {
            return response()->json([
                'warnings' => [],
                'errors' => [],
                'cartItems' => [],
                'pricing' => new \stdClass()
            ]);
        }

        $setting = Setting::first();

        $cartItems = json_decode($cart->items, true);

        if(count($cartItems) == 0)
        {
            return response()->json(['error' => 'Cart not found'], 404);
        }

        $pricing = json_decode($cart->pricing, true);

        $errors = [];

        $warnings = [];

        foreach ($cartItems as $cartItem) 
        {
            $product = Product::where('id', $cartItem['productId'])->first();

            if(!$product)
            {
                array_push($errors, "Sorry, “" . $product->name . "” has been removed.");
            }
            else if($product->stock < $cartItem['quantity'])
            {
                array_push($errors, "Sorry, we do not have enough “" . $product->name . "” in stock to fulfill your order.");
            }
            else if($cartItem['price'] != $product->price)
            {
                array_push($warnings, "The price of “" . $product->name . "” has been changed.");
                $cartItem['price'] = $product->price;
            }
            else if($cartItem['name'] != $product->name)
            {
                array_push($warnings, "“" . $cartItem['name'] . "” has been renamed to " . "“" . $product->name . "”");
                $cartItem['name'] = $product->name;
            }
            else if($cartItem['imageUrl'] != $product->image_url)
            {
                $cartItem['imageUrl'] = $product->image_url;
            }

            if($product)
            {
                $cartItem['stock'] = $product->stock;
            }
        }

        if($pricing['shippingCost'] != $setting->shipping_cost)
        {
            $pricing['shippingCost'] = $setting->shipping_cost;
            array_push($warnings, 'Shipping cost has been changed');
        }
        if($pricing['gst'] != $setting->gst)
        {
            $pricing['gst'] = $setting->gst;
            array_push($warnings, 'Gst has been changed');
        }

        $productPrice = 0;

        foreach ($cartItems as $cartItem) 
        {
            $productPrice += $cartItem['price'] * $cartItem['quantity'];
        }

        $gstAmount = round($productPrice * ($pricing['gst'] / 100));

        $totalAmount = $gstAmount + $productPrice + $pricing['shippingCost'];

        $resultPricing = [
            'totalAmount' => $totalAmount,
            'productPrice' => $productPrice,
            'gstAmount' => $gstAmount,
            'gst' => $pricing['gst'],
            'shippingCost' => $pricing['shippingCost']
        ];

        $cart->items = json_encode($cartItems);
        $cart->pricing = json_encode($pricing);
        $cart->save();
        Log::debug($cartItems);
        return response()->json([
            'warnings' => $warnings,
            'errors' => $errors,
            'cartItems' => $cartItems,
            'pricing' => $resultPricing
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'productId' => 'required|exists:products,id',
            'quantity' => 'required|integer',
        ]);

        $product = Product::where('id', $request->productId)->first();

        if(!$product)
        {
            return response()->json(['error' => 'Product not found'], 404);
        }
        else if($product->stock < $request->quantity)
        {
            return response()->json(['error' => 'Not sufficient to fullfill'], 422);
        }

        $cart = $request->user()->cart()->first();
        
        if(!$cart)
        {
            $setting = Setting::first();

            $request->user()->cart()->create([
                'items' => json_encode([
                    [
                        'productId' => $product->id,
                        'quantity' => $request->quantity,
                        'name' => $product->name,
                        'price' => $product->price,
                        'imageUrl' => $product->image_url,
                    ]
                ]),
                'pricing' => json_encode([
                    'shippingCost' => $setting->shipping_cost,
                    'gst' => $setting->gst
                ])
            ]);

            return response()->json(['success' => 'Product added to cart'], 201);
        }

        $cartItems = json_decode($cart->items, true);
        $isPresent = false;

        foreach ($cartItems as $cartItem) 
        {
            if($cartItem['productId'] == $product->id)
            {
                $cartItem['quantity'] = $request->quantity;

                $isPresent = true;

                break;
            }
        }

        if(!$isPresent)
        {
            array_push($cartItems, [
                'productId' => $product->id,
                'quantity' => $request->quantity,
                'name' => $product->name,
                'price' => $product->price,
                'imageUrl' => $product->image_url,
            ]);
        }

        $cart->items = json_encode($cartItems);

        $cart->save();

        return response()->json(['success' => 'Product added to cart']);
    }

    public function delete(Request $request, $productId)
    {
        $cart = $request->user()->cart()->first();

        if(!$cart)
        {
            return response()->json(['error' => 'Cart not found'], 404);
        }

        $cartItems = json_decode($cart->items, true);

        if(count($cartItems) == 0)
        {
            return response()->json(['error' => 'Cart not found'], 404);
        }

        $newCartItems = [];

        foreach ($cartItems as $cartItem) 
        {
            if($cartItem['productId'] != $productId)
            {
                array_push($newCartItems, $cartItem);
            }
        }
        
        $cart->items = json_encode($newCartItems);
        $cart->save();

        return response()->json(['success' => 'Item deleted from cart']);
    }

    public function deleteAll(Request $request)
    {
        $request->user()->cart()->delete();

        return response()->json(['success' => 'Removed all from cart successfully']);
    }

    public function updateAll(Request $request)
    {
        $request->validate([
            'cartItems.*.productId' => 'required',
            'cartItems.*.quantity' => 'required|integer',
        ]);

        $cart = $request->user()->cart()->first();

        if(!$cart)
        {
            return response()->json(['error' => 'Cart not found'], 404);
        }

        $cartItems = json_decode($cart->items, true);


        if(count($cartItems) == 0)
        {
            return response()->json(['error' => 'Cart not found'], 404);
        }

        foreach ($request->cartItems as $cartItem) 
        {
            for ($i=0; $i < count($cartItems); $i++) 
            { 
                if($cartItems[$i]['productId'] == $cartItem['productId'])
                {
                    $cartItems[$i]['quantity'] = $cartItem['quantity'];
                }
            }
        }

        $cart->items = json_encode($cartItems);
        $cart->save();

        return response()->json(['success' => 'Update all items successfully']);
    }
}
