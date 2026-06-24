<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Show the Products listing page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $products = Product::where('status', 'active')
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('product', compact('products'));
    }

    /**
     * Show a single product detail page.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\View\View
     */
    public function show(Product $product)
    {
        // Check if product is active
        if ($product->status !== 'active') {
            abort(404);
        }
            
        // Get related products - use manual selection if set, otherwise same category
        if (!empty($product->related_products) && is_array($product->related_products)) {
            $relatedProducts = Product::whereIn('id', $product->related_products)
                ->where('status', 'active')
                ->limit(4)
                ->get();
        } else {
            $relatedProducts = Product::where('category', $product->category)
                ->where('id', '!=', $product->id)
                ->where('status', 'active')
                ->limit(4)
                ->get();
        }
            
        return view('product', [
            'product' => $product,
            'relatedProducts' => $relatedProducts
        ]);
    }
}
