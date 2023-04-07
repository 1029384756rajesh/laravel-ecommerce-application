<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;

class CartController extends Controller
{
    public function store(Request $request)
    {
        $product = Product::where('id', $request->product_id)->first();

        if(!$product) return response()->json(['error' => 'Product not found'], 422);

        if($product->has_variations) return $this->storeVariantProduct($request, $product);

        if($product->stock < $request->quantity) return response()->json(['error' => 'In sufficient stock'], 422);

        $cartItem = $request->user()->cart()->where('product_id', $request->product_id)->first();

        if($cartItem)
        {
            $cartItem->quantity = $request->quantity;
            $cartItem->save();
            return response()->json($cartItem);
        }

        $cartItem = $request->user()->cart()->create([
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'variant_id' => $request->variant_id
        ]);

        return response()->json($cartItem);
    }

    public function index(Request $request)
    {
        $cart = $request->user()->cart()->with(['product', 'variation', 'variation.options'])->get()->map(function($cartItem)
        {
            $cartItem->inStock = $cartItem->variation ? $cartItem->variation->stock >= $cartItem->quantity : $cartItem->product->stock >= $cartItem->quantity; 
        
            if($cartItem->variation)
            {
                $cartItem->product->name .= " - ";

                foreach ($cartItem->variation?->options as $option) $cartItem->product->name .= $option->name . ", ";
            }

            return [
                'id' => $cartItem->id,
                'variation_id' => $cartItem->variation_id,
                'product_id' => $cartItem->product_id,
                'quantity' => $cartItem->quantity,
                'name' => $cartItem->product->name,
                'price' => $cartItem->variation ? $cartItem->variation->price : $cartItem->product->price,
                'image_url' => $cartItem->product->image_url,
                'inStock' => $cartItem->inStock
            ];
        });

        return response()->json($cart);
    }

    public function delete(Request $request, Cart $cart)
    {
        if($request->user()->id == $cart->user_id)
        {
            $cart->delete();
        }

        return response()->json($cart);
    }

    public function update(Request $request, $cartId)
    {
        $request->validate([
            'quantity' => 'required|integer',
        ]);

        $cartItem = $request->user()
            ->cart()
            ->where('cart.id', $cartId)
            ->join('products', 'products.id', 'cart.product_id')
            ->leftJoin('variations', 'variations.id', 'cart.variation_id')
            ->select('cart.quantity')
            ->selectRaw('if(variations.stock, variations.stock, products.stock) as stock')
            ->first();

        if(!$cartItem)
        {
            return response()->json(['error' => 'Cart item not found'], 404);
        }

        if($cartItem->stock < $request->quantity)
        {
            return response()->json(['error' => 'In sufficient stock'], 422);
        }

        Cart::where('id', $cartId)->update(['quantity' => $request->quantity]);

        return response()->json(['success' => 'Cart item updated']);
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
