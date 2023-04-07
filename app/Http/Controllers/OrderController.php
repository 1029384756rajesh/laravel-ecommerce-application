<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Setting;
use App\Models\Product;
use App\Models\OrderedAttribute;

class OrderController extends Controller
{
    private function getCartItems($request)
    {
        return $request->user()->cart()->with(['product', 'variation', 'variation.options', 'variation.options.attribute'])->get()->map(fn($cartItem) => [
            'product_id' => $cartItem->product_id,
            'quantity' => $cartItem->quantity,
            'name' => $cartItem->product->name,
            'inStock' => $cartItem->variation ? $cartItem->variation->stock >= $cartItem->quantity : $cartItem->product->stock >= $cartItem->quantity,
            'price' => $cartItem->variation ? $cartItem->variation->price : $cartItem->product->price,
            'attributes' => $cartItem->variation?->options->map(fn($option) => [
                'name' => $option->attribute->name,
                'option' => $option->name
            ])
        ]);
    }

    public function store(Request $request)
    {
        $cartItems = $this->getCartItems($request);

        if(count($cartItems) == 0) return response()->json(['error' => 'Cart not found'], 404);

        foreach ($cartItems as $cartItem) if($cartItem['inStock'] == false) return response()->json(['error' => 'Prooblem in cart'], 422);

        $order = $request->user()->orders()->create(['status' => 'Placed']);

        $setting = Setting::first();

        $productPrice = 0;

        foreach ($cartItems as $cartItem) $productPrice += $cartItem['price'];

        $gstAmount = $productPrice * ($setting->gst / 100);

        $totalAmount = $productPrice + $gstAmount + $setting->shipping_cost;

        $order->paymentDetails()->create([
            'shipping_cost' => $setting->shipping_cost,
            'gst' => $setting->gst,
            'gst_amount' => $gstAmount,
            'product_price' => $productPrice,
            'total_amount' => $totalAmount,
            'status' => 'Pending'
        ]);

        foreach ($cartItems as $cartItem) {
            $product = $order->products()->create([
                'product_id' => $cartItem['product_id'],
                'name' => $cartItem['name'],
                'quantity' => $cartItem['quantity'],
                'price' => $cartItem['price']
            ]);

            if($cartItem['attributes']) foreach ($cartItem['attributes'] as $attribute) OrderAttribute::create([
                'product_id' => $product->id,
                'name' => $attribute['name'],
                'option' => $attribute['option'],
            ]);
        }

        $request->user()->cart()->delete();

        return response()->json($order);
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
        $order = $request->user()->orders()->where('id', $orderId)->with('paymentDetails', 'shippingAddress', 'products', 'products.attributes')->first();

        return response()->json($order);
    }   
}
