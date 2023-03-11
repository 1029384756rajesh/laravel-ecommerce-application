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
        $orders = Order::with('products:order_id', 'status:name,id', 'paymentInfo:order_id,total_amount', 'user:id,email')->paginate(10);
// dd($orders->toArray());
        return view('admin.orders.index', ['orders' => $orders]);
    }

    public function update(Request $request, Order $order)
    {
        $request->validate([
            'status_id' => 'required|exists:order_statuses,id'
        ]);

        $order->status_id = $request->status_id;

        $order->save();

        return back()->with('success', 'Order Updated Successfully');
    }

    public function show($orderId)
    {
        $order = Order::where('id', $orderId)->with('products', 'shippingAddress', 'paymentInfo', 'user')->first();

        $statuses = OrderStatus::all();

        return view('admin.orders.show', [
            'order' => $order,
            'statuses' => $statuses
        ]);
    }
}
