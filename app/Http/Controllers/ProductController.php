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
    public function index(Request $request)
    {
        $isNewArrivals = $request->boolean('new_arrivals');

        $productsQuery = Product::where('status', 'active')
            ->when($isNewArrivals, function ($query) {
                $query->whereJsonContains('display_sections', 'new_arrivals');
            })
            ->when($request->query('category'), function ($query, $category) {
                $query->where('category', $category);
            })
            ->when($request->query('size'), function ($query, $size) {
                $query->where(function ($q) use ($size) {
                    $q->where('age_group', $size)
                        ->orWhere('age_group', 'like', $size . ',%')
                        ->orWhere('age_group', 'like', '%, ' . $size . ',%')
                        ->orWhere('age_group', 'like', '%, ' . $size);
                });
            })
            ->when($request->query('product_type'), function ($query, $type) {
                $query->where('product_type', $type);
            })
            ->orderBy('created_at', 'desc');

        $products = $productsQuery->get();

        $categories = \App\Models\Category::where('status', 'active')
            ->orderBy('order', 'asc')
            ->orderBy('name', 'asc')
            ->get();

        $pageTitle = $isNewArrivals ? 'New Arrivals | Kidz Wear' : 'All Products | Kidz Wear';
        $categoryName = $isNewArrivals ? 'New Arrivals' : ($request->query('category') ?: 'Products');

        return view('Category-Page', [
            'pageTitle'       => $pageTitle,
            'metaDescription' => 'Browse our latest kids clothing collection at Kidz Wear.',
            'categories'      => $categories,
            'products'        => $products,
            'categorySlug'    => null,
            'categoryName'    => $categoryName,
            'productTypes'    => $this->getProductTypes(),
            'ageGroups'       => $this->getAgeGroups(),
            'activeSize'      => $request->query('size'),
            'activeProductType' => $request->query('product_type'),
            'isNewArrivals'   => $isNewArrivals,
        ]);
    }

    private function getProductTypes()
    {
        $defaultTypes = collect([
            'Casual Shirts', 'T-Shirts', 'Trousers', 'Shorts', 'Frocks', 'Dresses', 'Shalwar Kameez', 'Jogger Sets', 'Jackets', 'Sweaters',
        ]);

        $assignedTypes = Product::where('status', 'active')
            ->pluck('product_type')
            ->filter(function ($type) {
                return trim((string) $type) !== '';
            });

        return $defaultTypes->merge($assignedTypes)->unique()->values();
    }

    private function getAgeGroups()
    {
        return Product::where('status', 'active')
            ->get()
            ->flatMap(function ($product) {
                return $product->available_age_groups;
            })
            ->unique(fn ($ageGroup) => strtolower($ageGroup))
            ->sort(SORT_NATURAL | SORT_FLAG_CASE)
            ->values();
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
