<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductReview;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $reviews = ProductReview::where('product_reviews.is_approved', false)
            ->join('users', 'users.id', 'product_reviews.user_id')
            ->join('products', 'products.id', 'product_reviews.product_id')
            ->select([
                'products.name as product_name',
                'products.image_url as product_image_url',
                'users.email as user_email',
                'users.name as user_name',
                'product_reviews.id',
                'product_reviews.review',
                'product_reviews.created_at'
            ])
            ->orderBy('product_reviews.created_at')
            ->get();

        return view('admin.reviews.index', ['reviews' => $reviews]);
    }

    public function approve(ProductReview $review)
    {
        $review->is_approved = true;

        $review->save();

        return back()->with('success', 'Review approved successfully');
    }

    public function destroy(ProductReview $review)
    {
        $review->delete();

        return back()->with('success', 'Review deleted successfully');
    }
}
