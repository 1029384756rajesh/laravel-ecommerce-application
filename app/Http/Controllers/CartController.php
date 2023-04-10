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

        if($request->variation_id)
        {
            $variation = $product->variations()->where('id', $request->variation_id)->first();

            return $variation->stock == null ? true : $variation->stock >= $request->quantity; 
        }

        return $product->stock == null ? true : $product->stock >= $request->quantity;

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
        $finalProducts = [];

        $productIds = [];

        foreach ($request->cartItems as $cartItem) array_push($productIds, $request->product_id);

        $products = Product::whereIn($productIds)->where('published', true)->with(['product', 'variation', 'variation.options', 'options.attribute'])->get();

        foreach ($products as $product) 
        {
            $selectedCartItem = [];

            foreach ($request->cartItems as $cartItem) 
            {
                if($cartItem['product_id' == $product->id])
                {
                    $selectedCartItem = $cartItem;
                    break;
                }
            }

            if($selectedCartItem['variation_id'] && $product->has_variations)
            {
                $selectedVariation = [];

                $selectedOptions = [];

                foreach ($product->variations as $variation) 
                {
                    if($variation->id == $selectedCartItem['variation_id']) 
                    {
                        array_push($selectedVariation, $variation);

                        foreach ($variation->options as $option) 
                        {
                            array_push($selectedOptions, [
                                'name' => $option->attribute->name,
                                'option' => $option->name
                            ]);
                        }
                    }
                }

                array_push($finalProducts, [
                    'name' => $product->name,
                    'price' => $variation->price,
                    'image_url' => $product->image_url,
                    'attributes' => $selectedOptions,
                    'inStock' => $selectedVariation->stock != null ? $selectedVariation->stock >= $selectedCartItem['quantity'] : true
                ]);
            }

            else if(!$selectedCartItem['variation_id'] && !$product->has_variations)
            {
                array_push([
                    'name' => $product->name,
                    'price' => $variation->price,
                    'image_url' => $product->image_url,
                    'attributes' => [],
                    'inStock' => $product->stock != null ? $product->stock >= $selectedCartItem['quantity'] : true
                ]);
            }    
        }

        return response()->json($finalProducts);
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
