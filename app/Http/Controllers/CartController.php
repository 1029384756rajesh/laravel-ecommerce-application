<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Setting;

class CartController extends Controller
{
    public function cart(Request $request)
    {
        // load the cart
        $cart = $request->user()->cart()->where("has_variations", false)->where("is_completed", true)->with("options", "options.attribute", "parent")->get();
        
        // format the cart response
        $finalCart = [];

        foreach ($cart as $cartItem) 
        {
            if($cartItem->stock && $cartItem->pivot->quantity > $cartItem->stock) continue;

            $data = [
                "product_id" => $cartItem->id,
                "quantity" => $cartItem->pivot->quantity,
                "price" => $cartItem->price
            ];

            if($cartItem->parent_id)
            {
                $data["name"] = "{$cartItem->parent->name} : ";

                foreach ($cartItem->options as $option) $data["name"] .= "{$option->attribute->name} - $option->name, "; 

                $data["name"] = substr($data["name"], 0, -2);

                $data["image"] = empty($cartItem->images) ? explode("|", $cartItem->parent->images)[0] :
                    explode("|", $cartItem->images)[0];
            }
            else 
            {
                $data["name"] = $cartItem->name;
                $data["image"] = explode("|", $cartItem->images)[0];
            }

            array_push($finalCart, $data);
        }

        // calculate pricing
        $productPrice = 0;

        foreach ($cart as $cartItem) $productPrice += $cartItem["price"];

        $setting = Setting::first();

        $gstAmount = round($productPrice * ($setting->gst / 100));

        // return response
        return response()->json([
            "cart" => $finalCart,
            "pricing" => [
                "productPrice" => $productPrice,
                "gst" => $setting->gst,
                "gstAmount" => $gstAmount,
                "shippingCost" => $setting->shipping_cost,
                "totalAmount" => $gstAmount + $productPrice + $setting->shippingCost
            ]
        ]);
    }

    public function create(Request $request)
    {
        $data = $request->validate([
            "product_id" => "required|integer",
            "quantity" => "required|integer"
        ]);

        $product = Product::where("id", $request->product_id)->where("has_variations", false)->where("is_completed", true)->first();

        if(!$product) return abort(404);

        if($product->stock && $product->stock < $request->quantity) return response()->json(["error" => "Insufficent stock"]);

        $cartItem = $request->user()->cart()->where("id", $product->id)->first();

        if($cartItem)
        {
            $cartItem->pivot->quantity = $request->quantity;
            $cartItem->save();
        }
        else 
        {
            $request->user()->cart()->attach($product->id, ["quantity" => $request->quantity]);
        }

        return response()->json(["success" => "Product added to the cart successfully"]);
    }

    public function delete(Request $request, $productId)
    {
        $request->user()->cart()->detach($productId);

        return response()->json(["success" => "Product removed from cart successfully"]);
    }
}
