<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Setting;
use App\Models\Product;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $cart = $request->user()->cart()->first();

        $cartItems = json_decode($cart->items, true);

        $pricing = json_decode($cart->pricing, true);

        $setting = Setting::first();

        foreach ($cartItems as $cartItem) 
        {
            $product = Product::where('id', $cartItem['productId'])->first();

            if(!($product && ($product->price == $cartItem['price']) && ($product->stock >= $cartItem['quantity'])))
            {
                return response()->json(['error' => 'Some cart item has been changed'], 422);
            }
        }

        if(!($setting->gst == $pricing['gst'] && $setting->shipping_cost == $pricing['shippingCost']))
        {
            return response()->json(['error' => 'Pricing of cart has been changed'], 422);
        }

        $address = $request->user()->addresses()->where('id', $request->addressId)->first();

        if(!$address)
        {
            return response()->json(['error' => 'Address not found'], 404);
        }

        $order = $request->user()->orders()->create([
            'status' => 'Pending'
        ]);

        $order->shippingAddress()->create([
            'name' => $address->name,
            'mobile' => $address->mobile,
            'address' => $address->address_line_1 . ', ' . $address->address_line_2 . ', ' . $address->city . ', ' . $address->pincode
        ]);

        $productPrice = 0;

        foreach ($cartItems as $cartItem) 
        {
            $order->products()->create([
                'name' => $cartItem['name'],
                'image_url' => $cartItem['imageUrl'],
                'price' => $cartItem['price'],
                'quantity' => $cartItem['quantity'],
            ]);

            $product = Product::where('id', $cartItem['productId'])->first();

            if($product && $product->stock > 0)
            {
                $newStock = $product->stock - $cartItem['quantity'];

                $product->stock =  $newStock > 0 ? $newStock : 0; 

                $product->save();
            }

            $productPrice += $cartItem['price'] * $cartItem['quantity'];
        }

        $gstAmount = round($productPrice * ($pricing['gst'] / 100));

        $totalAmount = $gstAmount + $productPrice + $pricing['shippingCost'];

        $order->paymentInfo()->create([
            'product_price' => $productPrice,
            'total_amount' => $totalAmount,
            'shipping_cost' => $setting->shipping_cost,
            'method' => 'COD',
            'status' => 'Confirmed',
            'payment_id' => 2,
            'gst' => $setting->gst,
            'gst_amount' => $gstAmount,
        ]);

        $request->user()->cart()->delete();

        return response()->json($order, 201);
    }   

    public function index(Request $request)
    {
        $orders = $request->user()->orders()->orderBy('orders.id', 'desc')->with('paymentInfo')->get()->map(function($order)
        {
            return [
                'id' => $order->id,
                'status' => $order->status,
                'created_at' => $order->created_at,
                'updated_at' => $order->updated_at,
                'total_amount' => $order->paymentInfo->total_amount,
            ];
        });


        return response()->json($orders);
    }   
    
    public function order(Request $request, $orderId)
    {
        $order = $request->user()->orders()->where('id', $orderId)->with('paymentInfo', 'shippingAddress', 'products')->first();

        return response()->json($order);
    }   
}
