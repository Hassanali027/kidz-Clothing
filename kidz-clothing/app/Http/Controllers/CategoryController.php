<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;

class CategoryController extends Controller
{
    /**
     * Show all categories listing page.
     */
    public function index(Request $request)
    {
        $categories = Category::where('status', 'active')
            ->orderBy('order', 'asc')
            ->orderBy('name', 'asc')
            ->get();

        $products = null;
        $activeSize = $request->query('size');

        // If a size filter is requested, we show products instead of just categories
        if ($activeSize) {
            $products = Product::where('status', 'active')
                ->orderBy('created_at', 'desc')
                ->get();
            
            // Note: In a real app, you would filter by size here in the query
            // $products = $products->where('size', $activeSize);
        }

        return view('Category-Page', [
            'pageTitle'       => 'Shop by Category | Kidz Wear',
            'metaDescription' => 'Browse all kids clothing categories at Kidz Wear – Boys, Girls, Baby, Party Wear and more.',
            'categories'      => $categories,
            'products'        => $products,
            'categorySlug'    => null,
            'activeSize'      => $activeSize,
        ]);
    }

    /**
     * Show products filtered by a specific category slug.
     */
    public function show($slug)
    {
        // Find category by slug
        $category = Category::where('slug', $slug)
            ->where('status', 'active')
            ->firstOrFail();

        // Get all active categories for navigation
        $categories = Category::where('status', 'active')
            ->orderBy('order', 'asc')
            ->orderBy('name', 'asc')
            ->get();

        // Get products for this category
        $products = Product::where('category', $category->name)
            ->where('status', 'active')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('Category-Page', [
            'pageTitle'       => $category->name . ' | Kidz Wear',
            'metaDescription' => 'Shop ' . $category->name . ' clothing for kids at Kidz Wear.',
            'categorySlug'    => $slug,
            'category'        => $category,
            'categoryName'    => $category->name,
            'categories'      => $categories,
            'products'        => $products,
        ]);
    }
}
