<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Setting;

class CartController extends Controller
{
    public function getPriceing($products)
    {
        $setting = Setting::first();

        $productPrice = 0;

        foreach ($products as $product) 
        {
            $productPrice += ($product->price * $product->quantity);
        }

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

            if($variation->stock < $request->quantity) return response()->json(["error" => "Invalid stock"], 422);

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
        $cartItems = $request->session()->get("cartItems", []);

        $productIds = [];

        foreach ($cartItems as $cartItem) array_push($productIds, $cartItem["product_id"]);

        $products = Product::whereIn("id", $productIds)->with("variations", "variations.options", "variations.options.attribute")->get();

        // dd($products->toArray());

        $finalProducts = [];

        foreach ($cartItems as $cartItem) 
        {
            $product = null;

            foreach ($products as $p) if($p->id == $cartItem["product_id"]) $product = $p;

            if(!$product) continue;

            if($product->has_variations && isset($cartItem["variation_id"]))
            {
                $variation = null;

                foreach ($product->variations as $v) if($v->id == $cartItem["variation_id"]) $variation = $v;

                if(!$variation) continue;
// dd($variation->toArray());
                $name = " : ";

                foreach ($variation->options as $option) 
                {
                    $name .= $option->attribute->name . " - " . $option->name . ", ";
                }

                $name = substr($name, 0, -2);
// dd($selectedItem);
                array_push($finalProducts, (object)[
                    "product_id" => $product->id,
                    "variation_id" => $variation->id,
                    "name" => $product->name . $name,
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
                    "in_stock" => $product->stock == null || $product->stock >= $cartItem["quantity"]
                ]);
            }
        }
        // dd($finalProducts);
// dd($finalProducts);
        return view("cart", array_merge(["cartItems" => $finalProducts], $this->getPriceing($finalProducts)));
    }

    public function delete(Request $request)
    {sleep(2);
        $request->validate([
            "product_id" => "required|integer",
            "variation_id" => "nullable|integer"
        ]);

        $cartItems = $request->session()->get("cartItems", []);

        $finalCartItems = [];

        for ($i=0; $i < count($cartItems); $i++) 
        { 
            if($request->variation_id)
            {
                if(!($cartItems[$i]["product_id"] == $request->product_id && $cartItems[$i]["variation_id"] == $request->variation_id))
                {
                    array_push($finalCartItems, $cartItems[$i]);
                }  
            }
            else 
            {
                if(!($cartItems[$i]["product_id"] == $request->product_id))
                {
                    array_push($finalCartItems, $cartItems[$i]);
                }  
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

            if($variation->stock && $variation->stock < $request->quantity) return response()->json(["error" => "Invalid stock"], 422);
        }
        else if($product->stock && $product->stock < $request->quantity)
        {
            return response()->json(["error" => "Invalid stock"], 422);
        }


        $cartItems = $request->session()->get("cartItems", []);

        for ($i=0; $i < count($cartItems); $i++) 
        { 
            if($request->variation_id)
            {
                if($cartItems[$i]["product_id"] == $product->id && $cartItems[$i]["variation_id"] == $request->variation_id)
                {
                    $cartItems[$i]["quantity"] = $request->quantity;
                }    
            }
            else 
            {
                if($cartItems[$i]["product_id"] == $product->id)
                {
                    $cartItems[$i]["quantity"] = $request->quantity;
                }    
            }
        }

        $request->session()->put("cartItems", $cartItems);

        return response()->json(["success" => "Item updated successfully"]);
    }

    private function storeVariantProduct($request, $product)
    {
        $variation = $product->variations()->where('id', $request->variation_id)->first();

        if($variation == null) return response()->json(['error' => 'Variant id not found'], 404);
        
        if($variation->stock < $request->quantity) return response()->json(['error' => 'In sufficient stock'], 422);

        $cartItem = $request->user()->cart()->where('product_id', $request->product_id)->where('variation_id', $request->variation_id)->first();

        if($cartItem)
        {
            $cartItem->quantity = $request->quantity;
            $cartItem->save();
            return response()->json($cartItem);
        }

        $cartItem = $request->user()->cart()->create([
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'variation_id' => $request->variation_id
        ]);

        return response()->json($cartItem);
    }
}
