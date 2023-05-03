<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Slider;
use App\Models\Category;
use App\Models\Product;
use App\Models\Order;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.index', [
            'total_products' => Product::count(),
            'total_sliders' => Slider::count(),
            'total_categories' => Category::count(),
            'total_orders' => Order::count(),
            'total_users' => User::count(),
            'total_placed_orders' => Order::where('status', "Placed")->count(),
            'total_accepted_orders' => Order::where('status', "Accepted")->count(),
            'total_rejected_orders' => Order::where('status', "Rejected")->count(),
            'total_shipped_orders' => Order::where('status', "Shipped")->count(),
            'total_delivered_orders' => Order::where('status', "Delivered")->count(),
        ]);
    }
}
