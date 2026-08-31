<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductReview;
use Illuminate\Http\Request;

class ProductReviewController extends Controller
{
    public function store(Request $request, Product $product)
    {
        $request->validate(['rating' => 'required|integer|min:1|max:5', 'review_text' => 'required|string|max:1000']);
        ProductReview::create(['product_id' => $product->id, 'user_id' => auth()->id(), 'rating' => $request->rating, 'review_text' => $request->review_text, 'status' => 'pending']);
        return back()->with('success', 'Thank you. Your review is awaiting admin approval.');
    }
}
