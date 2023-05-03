<?php 

namespace App\Helpers;

class CartHelper 
{
    public function get($user)
    {
        $cart = $user->cart()->where("has_variations", false)->where("is_completed", true)->with("options", "options.attribute", "parent")->get()->transform(function ($product)
        {
            $data = [
                "product_id" => $product->id,
                "quantity" => $product->pivot->quantity,
                "price" => $product->price
            ];

            if($product->parent_id)
            {
                $data["name"] = "{$product->parent->name} : ";

                foreach ($product->options as $option) $data["name"] .= "{$option->attribute->name} - $option->name, "; 

                $data["name"] = substr($data["name"], 0, -2);

                $data["image"] = empty($product->images) ? explode("|", $product->parent->images)[0] :
                    explode("|", $product->images)[0];
            }
            else 
            {
                $data["name"] = $product->name;
                $data["image"] = explode("|", $product->images)[0];
            }

            return $data;
        });

        $productPrice = 0;

        foreach ($cart as $cartItem) $productPrice += $cartItem["price"];

        $setting = Setting::first();

        $gstAmount = round($productPrice * ($setting->gst / 100));

        return [
            "items" => $cart,
            "pricing" => [
                "productPrice" => $productPrice,
                "totalAmount" => ($productPrice + $gstAmount + $setting->shipping_cost),
                "gstAmount" => $gstAmount,
                "gst" => $setting->gst,
                "shippingCost" => $setting->shippingCost
            ]
        ];
    }
}