<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Setting;
use App\Helpers\LangHelper;

class CartController extends Controller
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

                $productName = " : ";

                foreach ($variation->options as $option) $productName .= "{$option->attribute->name} - {$option->name}, ";

                $productName = substr($productName, 0, -2);

                array_push($finalProducts, (object)[
                    "product_id" => $product->id,
                    "variation_id" => $variation->id,
                    "name" => $product->name . $productName,
                    "image_url" => $variation->image_url ?? $product->image_url,
                    "price" => $variation->price,
                    "quantity" => $cartItem["quantity"],
                    "in_stock" => $variation->stock === null || $variation->stock >= $cartItem["quantity"]
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
                    "in_stock" => $product->stock === null || $product->stock >= $cartItem["quantity"]
                ]);
            }
        }

        return $finalProducts;
    }

    private function getPriceing($products)
    {
        $setting = Setting::first();

        $productPrice = 0;

        foreach ($products as $product) $productPrice += ($product->price * $product->quantity);

        $gst_amount = $productPrice * ($setting->gst / 100);

        $total_amount = $productPrice + $gst_amount + $setting->shipping_cost;

        return [
            "product_price" => $productPrice,
            "gst_amount" => $gst_amount,
            "gst" => $setting->gst,
            "shipping_cost" => $setting->shipping_cost,
            "total_amount" => $total_amount
        ];
    }

    public function store(Request $request, Product $product)
    {
        if(!$product->is_published) return response()->json(["error" => "Invalid product id"], 422);

        $request->validate(["quantity" => "required|integer|min:1"]);

        if($product->has_variations)
        {
            $variation = $product->variations()->where("id", $request->variation_id)->first();

            if(!$variation) return response()->json(["error" => "Invalid variation id"], 422);

            if($variation->stock !== null && $variation->stock < $request->quantity) return response()->json(["error" => "Out of stock"], 422);

            $cartItems = $request->session()->get("cartItems", []);

            $alreadyExists = false;

            for ($i=0; $i < count($cartItems); $i++) 
            { 
                if($cartItems[$i]["product_id"] == $product->id && $cartItems[$i]["variation_id"] == $variation->id)
                {
                    $cartItems[$i]["quantity"] = $request->quantity;
                    
                    $alreadyExists = true;

                    break;
                }    
            }

            if(!$alreadyExists)
            {
                array_push($cartItems, [
                    "product_id" => $product->id,
                    "variation_id" => $variation->id,
                    "quantity" => $request->quantity
                ]);
            }

            $request->session()->put("cartItems", $cartItems);

            return response()->json(["success" => "Product added to cart successfully"]);
        }

        if($product->stock !== null && $product->stock < $request->quantity) return response()->json(["error" => "Out of stock"], 422);
        
        $cartItems = $request->session()->get("cartItems", []);

        $alreadyExists = false;

        for ($i=0; $i < count($cartItems); $i++) 
        { 
            if($cartItems[$i]["product_id"] == $product->id)
            {
                $cartItems[$i]["quantity"] = $request->quantity;
                
                $alreadyExists = true;

                break;
            }    
        }

        if(!$alreadyExists)
        {
            array_push($cartItems, [
                "product_id" => $product->id,
                "quantity" => $request->quantity
            ]);
        }

        $request->session()->put("cartItems", $cartItems);

        return response()->json(["success" => "Product added to cart successfully"]);
    }

    public function index(Request $request)
    {
        $cartItems = $this->getCartItems($request);

        return view("cart", array_merge(["cartItems" => $cartItems], $this->getPriceing($cartItems)));
    }

    public function checkout(Request $request)
    {
        $cartItems = $this->getCartItems($request);

        $pricing = $this->getPriceing($cartItems);

        $request->session()->put("total_cart_items", count($cartItems));

        $request->session()->put("total_amount", $pricing["total_amount"]);

        return view("checkout", array_merge(["cartItems" => $cartItems], $pricing));
    }

    public function delete(Request $request)
    {
        $request->validate([
            "product_id" => "required|integer",
            "variation_id" => "nullable|integer"
        ]);

        $cartItems = $request->session()->get("cartItems", []);

        $finalCartItems = [];

        for ($i=0; $i < count($cartItems); $i++) 
        { 
            if($request->variation_id && !($cartItems[$i]["product_id"] == $request->product_id && $cartItems[$i]["variation_id"] == $request->variation_id))
            {
                array_push($finalCartItems, $cartItems[$i]);
            }

            else if(!($cartItems[$i]["product_id"] == $request->product_id))
            {
                array_push($finalCartItems, $cartItems[$i]);
            }
        }

        $request->session()->put("cartItems", $finalCartItems);

        return response()->json(["success" => "Item removed from cart successfully"]);
    }

    public function update(Request $request, Product $product)
    {
        if(!$product->is_published) return response()->json(["error" => "Invalid product id"], 422);

        $request->validate(["quantity" => "required|integer|min:1"]);

        if($product->has_variations)
        {
            $variation = $product->variations()->where("id", $request->variation_id)->first();

            if(!$variation) return response()->json(["error" => "Invalid variation id"], 422);

            if($variation->stock != null && $variation->stock < $request->quantity) return response()->json(["error" => "Out of stock"], 422);
        }

        else if($product->stock != null && $product->stock < $request->quantity)
        {
            return response()->json(["error" => "Out of stock"], 422);
        }

        $cartItems = $request->session()->get("cartItems", []);

        for ($i=0; $i < count($cartItems); $i++) 
        { 
            if($request->variation_id && $cartItems[$i]["product_id"] == $product->id && $cartItems[$i]["variation_id"] == $request->variation_id)
            {
                $cartItems[$i]["quantity"] = $request->quantity;
            }

            else if($cartItems[$i]["product_id"] == $product->id)
            {
                $cartItems[$i]["quantity"] = $request->quantity;
            }    
        }

        $request->session()->put("cartItems", $cartItems);

        return response()->json(["success" => "Item updated successfully"]);
    }
}
