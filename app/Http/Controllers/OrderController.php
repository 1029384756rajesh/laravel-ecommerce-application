<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Setting;
use App\Models\Product;
use App\Models\User;
use App\Models\OrderedAttribute;
use App\Helpers\LangHelper;

class OrderController extends Controller
{
    private function getCartItems($request)
    {
        $cartItems = $request->session()->get("cartItems", []);

        $productIds = array_map(fn($cartItem) => $cartItem["product_id"], $cartItems);

        $products = Product::whereIn("id", $productIds)->with("variations", "variations.options", "variations.options.attribute")->get();

        $finalProducts = [];

        foreach ($cartItems as $cartItem) 
        {
            $product = LangHelper::arrayFind($products, fn($product) => $product->id == $cartItem["product_id"]);

            if(!$product) continue;

            if($product->has_variations && isset($cartItem["variation_id"]))
            {
                $variation = LangHelper::arrayFind($product->variations, fn($variation) => $variation->id == $cartItem["variation_id"]);

                if(!$variation) continue;

                array_push($finalProducts, (object)[
                    "product_id" => $product->id,
                    "variation_id" => $variation->id,
                    "name" => $product->name,
                    "image_url" => $variation->image_url ?? $product->image_url,
                    "price" => $variation->price,
                    "quantity" => $cartItem["quantity"],
                    "variation_id" => $cartItem["variation_id"],
                    "in_stock" => $variation->stock === null || $variation->stock >= $cartItem["quantity"],
                    "attributes" => $variation->options->map(fn($option) => (object)[
                        "name" => $option->attribute->name,
                        "option" => $option->name,
                    ])
                ]);
            }

            else if(!$product->has_variations && !isset($cartItem["variation_id"]))
            {
                array_push($finalProducts, (object)[
                    "product_id" => $product->id,
                    "name" => $product->name,
                    "image_url" => $product->image_url,
                    "price" => $product->price,
                    "quantity" => $cartItem["quantity"],
                    "in_stock" => $product->stock === null || $product->stock >= $cartItem["quantity"],
                    "attributes" => []
                ]);
            }
        }

        return $finalProducts;
    }

    private function getPricingDetails($cartItems)
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

    private function updateProductStock($cartItem)
    {
        $product = Product::where("id", $cartItem->product_id)->where("is_published", true)->first();

        if(!$product) return;
            
        if(isset($cartItem->variation_id) && $product->has_variations)
        {
            $variation = $product->variations()->where("id", $cartItem->variation_id)->first();

            if($variation && $variation->stock !== null)
            {
                $newStock = $variation->stock - $cartItem->quantity;

                if($newStock < 0 ) $newStock = 0;

                $variation->stock = $newStock;

                $variation->save();
            }
        }

        else if(!isset($cartItem->variation_id) && !$product->has_variations && $product->stock !== null) 
        {
            $newStock = $product->stock - $cartItem->quantity;

            if($newStock < 0 ) $newStock = 0;

            $product->stock = $newStock;

            $product->save();
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            "name" => "required|max:50",
            "mobile" => "required|integer|min:1000000000|max:9999999999",
            "address_line_1" => "required|max:100",
            "address_line_2" => "required|max:100",
            "city" => "required|max:20",
            "pincode" => "required|min:6|max:6",
        ]);

        $cartItems = $this->getCartItems($request);

        $pricing = $this->getPricingDetails($cartItems);

        if(count($cartItems) == 0 && $request->session()->get("total_cart_items") == 0)
        {
            return abort(404);
        } 

        foreach ($cartItems as $cartItem) 
        {
            if(!$cartItem->in_stock) 
            {
                return back()->with("error", "There is some problem in your cart. Please check your cart before proceding.");
            }
        }

        if(!($request->session()->get("total_cart_items") == count($cartItems) && $request->session()->get("total_amount") == $pricing["total_amount"]))
        {
            return back()->with("error", "Some products of your cart has been changed recently. Please check your cart before proceding.");
        }
  
        $order = $request->user()->orders()->create(["status" => "Placed"]);

        $order->shippingAddress()->create([
            "name" => $request->name,
            "mobile" => $request->mobile,
            "address" => "{$request->address_line_1}, {$request->address_line_2}, {$request->city}, {$request->pincode}"
        ]);

        $order->paymentDetails()->create([
            "shipping_cost" => $pricing["shipping_cost"],
            "gst" => $pricing["gst"],
            "gst_amount" => $pricing["gst_amount"],
            "product_price" => $pricing["product_price"],
            "total_amount" => $pricing["total_amount"]
        ]);

        foreach ($cartItems as $cartItem) 
        {
            $this->updateProductStock($cartItem);

            $product = $order->products()->create([
                "product_id" => $cartItem->product_id,
                "name" => $cartItem->name,
                "quantity" => $cartItem->quantity,
                "image_url" => $cartItem->image_url,
                "price" => $cartItem->price
            ]);

            foreach ($cartItem->attributes as $attribute) $product->attributes()->create([
                "name" => $attribute->name,
                "option" => $attribute->option,
            ]);
        }

        $request->session()->put("cartItems", []);

        return redirect("/orders")->with("success", "Your order placed successfully.");
    }   

    public function index(Request $request)
    {
        $orders = $request->user()->orders()->orderBy("orders.id", "desc")->with("paymentDetails")->get()->map(function($order)
        {
            return (object) [
                "id" => $order->id,
                "status" => $order->status,
                "created_at" => $order->created_at,
                "updated_at" => $order->updated_at,
                "total_amount" => $order->paymentDetails->total_amount,
            ];
        });

        return view("orders", ["orders" => $orders]);
    }   
    
    public function show(Request $request, $orderId)
    {
        $order = User::where("is_admin", true)->first()->orders()->where("id", $orderId)->with("paymentDetails", "shippingAddress", "products", "products.attributes")->first();

        $order->products = $order->products->transform(function($product)
        {
            if(count($product->attributes) > 0)
            {
                $name = " : "; 

                foreach ($product->attributes as $attribute) $name .= "{$attribute->name} - {$attribute->option}, ";

                $name = substr($name, 0, -2);

                $product->name .= $name;
            }

            return $product;
        });

        return view("order", ["order" => $order]);
    }   
}
