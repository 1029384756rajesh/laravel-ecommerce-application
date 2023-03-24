<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index(Product $product)
    {
        $reviews = $product->reviews()->with('user')->get();

        return response()->json($reviews);
    }

    public function store(Request $request)
    {
        $request->validate([
            'review' => 'required|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'product_id' => 'required|integer|exists:products.id'
        ]);

        $review = $request->user()->reviews()->where('product_id', $product->id)->first();

        if($review)
        {
            $review->rating = $request->rating;
            $review->review = $request->review;
            $review->save();
        }
        else 
        {
            $review = $product->reviews()->create([
                'user_id' => $request->user()->id,
                'review' => $request->review,
                'rating' => $request->rating
            ]);
        }

        return response()->json($review);
    }

    public function delete(Request $request, Product $product)
    {
        $request->user()->reviews()->where('product_id', $product->id)->delete();

        return response()->json($review);
    }
}
