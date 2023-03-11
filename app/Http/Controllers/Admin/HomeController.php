<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Slider;
use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use App\Models\ProductReview;

class HomeController extends Controller
{
    public function index()
    {
        return view('admin.index', [
            'total_products' => Product::count(),
            'total_sliders' => Slider::count(),
            'total_categories' => Category::count(),
            'total_orders' => Order::count(),
            'total_users' => User::count(),
            'total_placed_orders' => Order::where('status_id', 1)->count(),
            'total_accepted_orders' => Order::where('status_id', 2)->count(),
            'total_rejected_orders' => Order::where('status_id', 3)->count(),
            'total_shipped_orders' => Order::where('status_id', 4)->count(),
            'total_delivered_orders' => Order::where('status_id', 5)->count(),
            'total_pending_reviews' => ProductReview::where('is_approved', false)->count(),
        ]);
    }
}
