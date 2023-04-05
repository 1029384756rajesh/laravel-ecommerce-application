<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Setting;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $address = $request->user()->addresses()->where('id', $request->addressId)->first();

        if(!$address)
        {
            return abort(403);
        }

        $cart = $request->user()->cart()->get();

        $order = $request->user()->orders()->create([
            'status' => 'Placed'
        ]);

        $order->shippingAddress()->create([
            'name' => $address->name,
            'mobile' => $address->mobile,
            'address' => $address->address_line_1 . ', ' . $address->address_line_2 . ', ' . $address->city . ', ' . $address->pincode

        ]);

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
        $orders = $request->user()->orders()->with('paymentInfo')->get()->map(function($order)
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
