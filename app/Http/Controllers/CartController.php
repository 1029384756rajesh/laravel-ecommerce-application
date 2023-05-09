<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use App\Models\Setting;

class CartController extends Controller
{
    public function checkout(Request $request)
    {
        $cart = $request->user()->cart()->where("has_variations", false)->where("is_completed", true)->with("parent", "options", "options.attribute")->get();

        $finalCart = [];

        foreach ($cart as $cartItem) 
        {
            if($cartItem->stock && $cartItem->stock < $cartItem->pivot->quantity) continue;

            $data = (object)[
                "id" => $cartItem->id,
                "quantity" => $cartItem->pivot->quantity,
                "price" => $cartItem->price
            ];

            if($cartItem->parent_id)
            {
                $data->name = "{$cartItem->parent->name} : ";

                foreach ($cartItem->options as $option) $data->name .= "{$option->attribute->name} - $option->name, "; 

                $data->name = substr($data->name, 0, -2);

                $data->image = empty($cartItem->images) ? explode("|", $cartItem->parent->images)[0] :
                    explode("|", $cartItem->images)[0];
            }
            else 
            {
                $data->name = $cartItem->name;
                $data->image = explode("|", $cartItem->images)[0];
            }

            array_push($finalCart, $data);
        }

        $productPrice = 0;

        foreach ($finalCart as $cartItem) $productPrice += ($cartItem->price * $cartItem->quantity);

        $setting = Setting::first();

        $gstAmount = (int) round($productPrice * ($setting->gst / 100));

        return view("checkout", [
            "product_price" => $productPrice,
            "gst" => $setting->gst,
            "gst_amount" => $gstAmount,
            "shipping_cost" => $setting->shipping_cost,
            "total_amount" => $gstAmount + $productPrice + $setting->shippingCost
        ]);
    }
    public function index(Request $request)
    {
        $cart = $request->user()->cart()->where("has_variations", false)->where("is_completed", true)->with("parent", "options", "options.attribute")->get();

        $finalCart = [];

        foreach ($cart as $cartItem) 
        {
            if($cartItem->stock && $cartItem->stock < $cartItem->pivot->quantity) continue;

            $data = (object)[
                "id" => $cartItem->id,
                "quantity" => $cartItem->pivot->quantity,
                "price" => $cartItem->price
            ];

            if($cartItem->parent_id)
            {
                $data->name = "{$cartItem->parent->name} : ";

                foreach ($cartItem->options as $option) $data->name .= "{$option->attribute->name} - $option->name, "; 

                $data->name = substr($data->name, 0, -2);

                $data->image = empty($cartItem->images) ? explode("|", $cartItem->parent->images)[0] :
                    explode("|", $cartItem->images)[0];
            }
            else 
            {
                $data->name = $cartItem->name;
                $data->image = explode("|", $cartItem->images)[0];
            }

            array_push($finalCart, $data);
        }

        $productPrice = 0;

        foreach ($finalCart as $cartItem) $productPrice += ($cartItem->price * $cartItem->quantity);

        $setting = Setting::first();

        $gstAmount = (int) round($productPrice * ($setting->gst / 100));

        return view("cart", [
            "products" => $finalCart,
            "product_price" => $productPrice,
            "gst" => $setting->gst,
            "gst_amount" => $gstAmount,
            "shipping_cost" => $setting->shipping_cost,
            "total_amount" => $gstAmount + $productPrice + $setting->shippingCost
        ]);
    }

    public function store(Request $request, $productId)
    {
        $data = $request->validate(["quantity" => "required|integer|min:1"]);

        $product = Product::where("id", $productId)->where("has_variations", false)->where("is_completed", true)->first();

        if(!$product) abort(404);

        if($product->stock && $product->stock < $request->quantity) return response()->json(["error" => "Insufficent stock"], 422);

        $cartItem = $request->user()->cart()->where("id", $product->id)->first();

        if($cartItem)
        {
            $cartItem->pivot->quantity = $request->quantity;
            $cartItem->pivot->save();
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
