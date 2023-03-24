<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $address = $request->user()->addresses()->where('id', $request->address_id)->first();

        if(!$address)
        {
            return abort(403);
        }

        $cart = $request->user()->cart()->get();

        $order = $request->user()->orders()->create([
            'status' => 1
        ]);

        $order->shippingAddress()->create($address);

        foreach ($cart as $cartItem) 
        {
            $order->products()->create([
                'name' => $cartItem->name,
                'image_url' => $cartItem->image_url,
                'price' => $cartItem->price,
                'quantity' => $cartItem->quantity,
            ]);
        }

        $setting = Setting::first();

        $productPrice = 0;

        foreach ($cart as $cartItem) 
        {
            $productPrice += $cartItem->price * $cartItem->quantity;
        }

        $gstAmount = round($productPrice * ($setting->gst / 100));

        $totalAmount = $gstAmount + $productPrice + $setting->delivery_fee;

        $order->paymentDetails()->create([
            'product_price' => $productPrice,
            'total_mount' => $totalAmount,
            'shipping_cost' => $setting->shippingCost,
            'gst' => $setting->gst,
            'gst_amount' => $gstAmount,
        ]);

        $order->shippingAddress()->create($address);

        $request->user()->cart()->delete();

        return response()->json($order, 201);
    }   

    public function index(Request $request)
    {
        $orders = $request->user()->orders()->with('paymentDetails:totalAmount')->get();

        return response()->json($orders);
    }   
    
    public function order(Request $request, $orderId)
    {
        $order = $request->user()->orders()->where('id', $orderId)->with('paymentDetails', 'shippingAddress', 'products')->first();

        return response()->json($order);
    }   
}
