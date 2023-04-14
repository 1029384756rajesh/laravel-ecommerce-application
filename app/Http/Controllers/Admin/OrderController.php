<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderStatus;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with("paymentDetails", "user")->orderBy("orders.created_at", "desc")->get();

        return view("admin.orders.index", ["orders" => $orders]);
    }

    public function update(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required'
        ]);

        $order->status = $request->status;

        $order->save();

        return back()->with('success', 'Order Updated Successfully');
    }

    public function show($orderId)
    {
        $order = Order::where('id', $orderId)->with('products', "products.attributes", 'shippingAddress', 'paymentDetails', 'user')->first();


$order->products = $order->products->transform(function($product)
{
    if(count($product->attributes) > 0)
    {
        $name = " : ";

        foreach ($product->attributes as $attribute) $name .= "{$attribute->name} - {$attribute->option}, ";

        $name = substr($name, 0, -2);
    }

    $product->name .= $name;

    return $product;
});
// dd($order->toArray());
        // $statuses = OrderStatus::all();

        return view('admin.orders.show', [
            'order' => $order,
        ]);
    }
}
