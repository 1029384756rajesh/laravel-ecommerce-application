<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::orderBy("orders.id", "desc")->with("paymentDetails", "products", "user")->get()->transform(fn($order) => (object) [
            "id" => $order->id,
            "email" => $order->user->email,
            "status" => $order->status,
            "created" => date('d-m-Y', strtotime($order->created_at)),
            "total_products" => count($order->products),
            "total_amount" => $order->paymentDetails->total_amount
        ]);

        return view("admin.orders.index", ["orders" => $orders]);
    }  

    public function show(Request $request, $orderId)
    {
        $order = Order::where("id", $orderId)->with("paymentDetails", "shippingAddress", "products", "products.attributes")->first();

        if(!$order) abort(404);

        $order->products = $order->products->transform(function($product)
        {
            if(count($product->attributes))
            {
                $product->name = "$product->name : ";

                foreach ($product->attributes as $attribute) $product->name .= "$attribute->name - $attribute->option, ";

                $product->name = substr($product->name, 0, -2);
            }

            return (object)[
                "id" => $product->id,
                "name" => $product->name,
                "quantity" => $product->quantity,
                "image" => $product->image,
                "price" => $product->price
            ];
        });

        return view("admin.orders.show", ["order" => $order]);
    }   

    public function update(Request $request, Order $order)
    {
        $request->validate(["status" => "required"]);

        $order->status = $request->status;

        $order->save();

        return back()->with("success", "Order updated successfully");
    }
}
