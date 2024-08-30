<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\ProductVariation;
use App\Models\ShippingLocation;
use App\Models\ShippingZone;
use Illuminate\Http\Request;
use App\Models\Setting;
class CartController extends Controller
{
    public function checkout(Request $request)
    {
        $pricing = [];

        $total_price = 0;

        $total_weight = 0;

        $cart = $request->user()->cart()->with('product', 'images', 'options')->get()->map(function ($item) use ($total_price, $total_weight) {

            $total_price += $item->price * $item->pivot->quantity;

            $total_weight += $item->weight * $item->pivot->quantity;

            $options = $item->options->map(fn($option) => $option->name);

            $options = $options->count() ? ' — ' . implode(',', $options->toArray()) : null;

            return collect([
                'id' => $item->id,
                'name' => $item->product->name . $options,
                'image' => $item->images->first()->src,
                'price' => $item->price,
                'in_stock' => $item->stock === null || $item->stock > $item->pivot->quantity
            ]);
        });

        $pricing = [
            [
                'label' => 'Product Price',
                'amount' => $total_price
            ]
        ];
        
        if ($request->coupon && !$request->user()->coupons()->where('code', $request->code)->exists()) {

            $coupon = Coupon::where('code', $request->coupon)->first();

            if ($coupon && strtotime($coupon->expires_at) < strtotime(date('Y-m-d H:i:s'))) {

                $discount_amount = ($total_price * $coupon->rate) / 100;
                
                $pricing[] = [
                    'label' => 'Discount',
                    'amount' => -$discount_amount
                ];

                $total_price = $total_price - $discount_amount;
            }
        }

        if ($request->state_id) {

            $location = ShippingLocation::where('location_id', $request->state_id)->first();

            if ($location === null) {

                if ($request->country_id) {

                    $location = ShippingLocation::where('location_id', $request->country_id)->first();
                }
            }
        }

        if ($location) {

            $methods = $location->zone()->methods()
                ->whereNull('condition')
                ->orWhere(
                    fn($query) => $query->where('condition', 'price')
                        ->where('min_value', '<=', $total_price)
                        ->where('max_value', '>=', $total_price)
                )
                ->orWhere(
                    fn($query) => $query->where('condition', 'weight')
                        ->where('min_value', '<=', $total_weight)
                        ->where('max_value', '>=', $total_weight)
                )
                ->get();

            if ($methods) {

                $method = $request->method_id ? $methods->first(fn($method) => $method->id == $request->method_id) : $methods->first();

                $pricing[] = [
                    'label' => 'Shipping Cost',
                    'amount' => $method->amount
                ];
            }
        }

        $grand_total = 0;

        foreach ($pricing as $data) {

            $grand_total += $data['amount'];
        }


        $pricing[] = [
            'label' => 'Grand Total',
            'amount' => $grand_total
        ];

        return [
            'pricing' => $pricing,
            'products' => $cart,
            'methods' => $methods ?? [],
        ];
    }

    public function cart(Request $request)
    {
        $cart = $request->user()->cart()->with('product', 'images', 'options')->get()->map(function ($item) {

            $options = $item->options->map(fn($option) => $option->name);

            $options = $options->count() ? ' — ' . implode(',', $options->toArray()) : null;

            return collect([
                'id' => $item->id,
                'name' => $item->product->name . $options,
                'image' => $item->images->first()->src,
                'price' => $item->price,
                'in_stock' => $item->stock === null || $item->stock > $item->pivot->quantity
            ]);
        })->toArray();


        foreach ($cart as $item) {

        }

        dd($cart);

        $finalCart = [];

        foreach ($cart as $cartItem) {
            if ($cartItem->stock && $cartItem->stock < $cartItem->pivot->quantity)
                continue;

            $data = (object) [
                'id' => $cartItem->id,
                "quantity" => $cartItem->pivot->quantity,
                "price" => $cartItem->price
            ];

            if ($cartItem->parent_id) {
                $data->name = "{$cartItem->parent->name} : ";

                foreach ($cartItem->options as $option)
                    $data->name .= "{$option->attribute->name} - $option->name, ";

                $data->name = substr($data->name, 0, -2);

                $data->image = empty($cartItem->images) ? explode("|", $cartItem->parent->images)[0] :
                    explode("|", $cartItem->images)[0];
            } else {
                $data->name = $cartItem->name;
                $data->image = explode("|", $cartItem->images)[0];
            }

            array_push($finalCart, $data);
        }

        $productPrice = 0;

        foreach ($finalCart as $cartItem)
            $productPrice += ($cartItem->price * $cartItem->quantity);

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
        $request->validate([
            'quantity' => 'required|integer|min:1',
            'id' => 'required|integer|exists:product_variations,id'
        ]);

        $variation = ProductVariation::where('id', $request->id)->first();

        if ($variation->stock !== null || $variation->stock < $request->quantity) {
            return response()->json(['success' => false, 'message' => 'Insufficent Stock'], 422);
        }

        $item = $request->user()->cart()->where('id', $variation->id)->first();

        if ($item) {
            $item->pivot->quantity = $request->quantity;
            $item->pivot->save();
        } else {
            $request->user()->cart()->attach($variation->id, ['quantity' => $request->quantity]);
        }

        return response()->json(['success' => true, 'message' => 'Product added to the cart successfully']);
    }

    public function delete(Request $request)
    {
        $request->validate([
            'id' => 'required|integer'
        ]);

        $request->user()->cart()->detach($request->id);

        return response()->json(['success' => true, 'message' => 'Product removed from cart successfully']);
    }
}
