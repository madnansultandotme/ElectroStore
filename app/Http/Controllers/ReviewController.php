<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Store a new review.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000'
        ]);
        
        $product = Product::findOrFail($request->product_id);
        
        // Check if user already reviewed this product
        $existingReview = Review::where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->first();
            
        if ($existingReview) {
            return back()->with('error', 'You have already reviewed this product.');
        }
        
        // Check if user has purchased this product
        $hasPurchased = Order::where('user_id', Auth::id())
            ->whereHas('orderItems', function ($query) use ($request) {
                $query->where('product_id', $request->product_id);
            })
            ->exists();
        
        Review::create([
            'user_id' => Auth::id(),
            'product_id' => $request->product_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'verified_purchase' => $hasPurchased
        ]);
        
        return back()->with('success', 'Thank you for your review!');
    }
    
    /**
     * Update an existing review.
     */
    public function update(Request $request, Review $review)
    {
        // Ensure the review belongs to the authenticated user
        if ($review->user_id !== Auth::id()) {
            abort(403);
        }
        
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000'
        ]);
        
        $review->update([
            'rating' => $request->rating,
            'comment' => $request->comment
        ]);
        
        return back()->with('success', 'Your review has been updated.');
    }
    
    /**
     * Delete a review.
     */
    public function destroy(Review $review)
    {
        // Ensure the review belongs to the authenticated user
        if ($review->user_id !== Auth::id()) {
            abort(403);
        }
        
        $review->delete();
        
        return back()->with('success', 'Your review has been deleted.');
    }
}
