<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Setting;
use App\Models\Product;
use App\Models\User;
use App\Models\OrderedAttribute;

class OrderController extends Controller
{
    public function getPricingDetails($cartItems)
    {
        $setting = Setting::first();

        $productPrice = 0;

        foreach ($cartItems as $cartItem) $productPrice += ($cartItem->price * $cartItem->quantity);

        $gstAmount = $productPrice * ($setting->gst / 100);

        $totalAmount = $productPrice + $gstAmount + $setting->shipping_cost;

        return [
            "gst_amount" => $gstAmount,
            "gst" => $setting->gst,
            "total_amount" => $totalAmount,
            "product_price" => $productPrice,
            "shipping_cost" => $setting->shipping_cost
        ];
    }

    public function getCartItems($request)
    {
        // dd($request->session()->get("cartItems"));
        $cartItems = $request->session()->get("cartItems", []);

        $productIds = array_map(fn($cartItem) => $cartItem["product_id"], $cartItems);

        $products = Product::whereIn("id", $productIds)->where("is_published", true)->with("variations", "variations.options", "variations.options.attribute")->get();

        $finalProducts = [];

        foreach ($cartItems as $cartItem) 
        {
            $product = null;

            foreach ($products as $p) if($cartItem["product_id"] == $p->id) $product = $p;

            if(!$product) continue;

            if(isset($cartItem["variation_id"]))
            {
                $variation = null;

                foreach ($product->variations as $v) if($v->id == $cartItem["variation_id"]) $variation = $v;

                if(!$variation) continue;

                if($variation->stock && $variation->stock < $cartItem["quantity"]) continue;

                array_push($finalProducts, (object)[
                    "product_id" => $product->id,
                    "name" => $product->name,
                    "price" => $variation->price,
                    "image_url" => $variation->image_url ?? $product->image_url,
                    "quantity" => $cartItem["quantity"],
                    "attributes" => $variation->options->map(function($option)
                    {
                        return (object)[
                            "name" => $option->attribute->name,
                            "option" => $option->name
                        ];
                    })
                ]);
            }

            else 
            {
                if($product->stock && $product->stock < $cartItem["quantity"])  continue;

                array_push($finalProducts, (object)[
                    "product_id" => $product->id,
                    "name" => $product->name,
                    "price" => $product->price,
                    "image_url" => $product->image_url,
                    "quantity" => $cartItem["quantity"],
                    "attributes" => []
                ]);
            }
        }

        return $finalProducts;
    }

    public function store(Request $request)
    {
        // $request->validate([
        //     "name" => "required|max:50",
        //     "mobile" => "required|integer|min:10|max:10",
        //     "address_line_1" => "required|max:100",
        //     "address_line_2" => "required|max:100",
        //     "city" => "required|max:20",
        //     "pincode" => "required|min:6|max:6",
        // ]);
        $cartItems = $this->getCartItems($request);

        if(count($cartItems) == 0) return response()->json(['error' => 'Cart not found'], 404);

        $pricing = $this->getPricingDetails($cartItems);
  
        $order = User::where("is_admin", true)->first()->orders()->create(['status' => 'Placed']);

        $order->shippingAddress()->create([
            'name' => "$request->name",
            'mobile' => "$request->mobile",
            'address' => "{$request->address_line_1}, {$request->address_line_2}, {$request->city}, {$request->pincode}"
        ]);

        $order->paymentDetails()->create([
            'shipping_cost' => $pricing["shipping_cost"],
            'gst' => $pricing["gst"],
            'gst_amount' => $pricing["gst_amount"],
            'product_price' => $pricing["product_price"],
            'total_amount' => $pricing["total_amount"]
        ]);

        foreach ($cartItems as $cartItem) {
            $product = $order->products()->create([
                'product_id' => $cartItem->product_id,
                'name' => $cartItem->name,
                'quantity' => $cartItem->quantity,
                'price' => $cartItem->price
            ]);

            foreach ($cartItem->attributes as $attribute) $product->attributes()->create([
                'name' => $attribute->name,
                'option' => $attribute->option,
            ]);
        }

        $request->session()->put("cartItems", []);

        return response()->json($order);
    }   

    public function index(Request $request)
    {
        $orders = User::where("is_admin", true)->first()->orders()->orderBy('orders.id', 'desc')->with('paymentDetails')->get()->map(function($order)
        {
            return (object)[
                'id' => $order->id,
                'status' => $order->status,
                'created_at' => $order->created_at,
                'updated_at' => $order->updated_at,
                'total_amount' => $order->paymentDetails->total_amount,
            ];
        });

        return view("orders", ["orders" => $orders]);
    }   
    
    public function show(Request $request, $orderId)
    {
        $order = User::where("is_admin", true)->first()->orders()->where('id', $orderId)->with('paymentDetails', 'shippingAddress', 'products', 'products.attributes')->first();

        $order->products = $order->products->transform(function($product)
        {
            $name = " : "; 

            foreach ($product->attributes as $attribute) {
                $name .= "{$attribute->name} - {$attribute->option}, ";
            }

            $product->name .= $name;

            return $product;

        });
// dd($order->toArray());
        return view("order", ["order" => $order]);
    }   
}
