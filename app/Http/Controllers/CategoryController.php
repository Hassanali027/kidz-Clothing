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
        $search = $request->query('search');
        $productType = $request->query('product_type');

        // If a size filter or search query is requested, we show products instead of just categories
        if ($activeSize || $search || $productType) {
            $productsQuery = Product::where('status', 'active');

            if ($productType) {
                $productsQuery->where('product_type', $productType);
            }

            $products = $productsQuery->orderBy('created_at', 'desc')->get();

            if ($productType && $products->isEmpty()) {
                $products = null;
            }
            
            // Note: In a real app, you would filter by size here in the query
            // $products = $products->where('size', $activeSize);
        }

        return view('Category-Page', [
            'pageTitle'       => \App\Models\SiteSetting::get('category_seo_title', 'Shop by Category | Kidz Wear'),
            'metaDescription' => \App\Models\SiteSetting::get('category_seo_description', 'Browse all kids clothing categories at Kidz Wear – Boys, Girls, Baby, Party Wear and more.'),
            'categories'      => $categories,
            'products'        => $products,
            'productTypes'    => $this->getProductTypes(),
            'ageGroups'       => $this->getAgeGroups(),
            'categorySlug'    => null,
            'activeSize'      => $activeSize,
            'activeProductType' => $productType,
        ]);
    }

    /**
     * Show products filtered by a specific category slug.
     */
    public function show(Request $request, $slug)
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

        // Get filters from request
        $sizeFilter = $request->query('size');
        $productType = $request->query('product_type');
        $minPrice = $request->query('min_price', 0);
        $maxPrice = $request->query('max_price', 10000);

        // Build products query
        $productsQuery = Product::where('category', $category->name)
            ->where('status', 'active');

        // Apply size filter if provided
        if ($sizeFilter) {
            $productsQuery->where('age_group', $sizeFilter);
        }

        if ($productType) {
            $productsQuery->where('product_type', $productType);
        }

        // Apply price filter
        $productsQuery->where(function($query) use ($minPrice, $maxPrice) {
            $query->whereBetween('price', [$minPrice, $maxPrice])
                  ->orWhereBetween('sale_price', [$minPrice, $maxPrice]);
        });

        $products = $productsQuery->orderBy('created_at', 'desc')->get();
        $productTypes = $this->getProductTypes();
        $ageGroups = $this->getAgeGroups($category->name);

        // Database diagnostics log
        try {
            $diagnostics = [
                'timestamp' => date('Y-m-d H:i:s'),
                'requested_slug' => $slug,
                'size_filter' => $sizeFilter,
                'price_range' => ['min' => $minPrice, 'max' => $maxPrice],
                'resolved_category' => [
                    'id' => $category->id,
                    'name' => $category->name,
                    'slug' => $category->slug,
                    'status' => $category->status,
                ],
                'unique_product_categories' => Product::select('category')->distinct()->pluck('category')->toArray(),
                'all_products_count' => Product::count(),
                'active_products_count' => Product::where('status', 'active')->count(),
                'matched_products_count' => count($products),
                'matched_products' => $products->map(function($p) {
                    return [
                        'id' => $p->id,
                        'name' => $p->name,
                        'price' => $p->price,
                        'sale_price' => $p->sale_price,
                        'status' => $p->status,
                        'stock' => $p->stock_quantity,
                        'category' => $p->category,
                        'age_group' => $p->age_group,
                        'product_type' => $p->product_type,
                    ];
                })->toArray(),
            ];
            file_put_contents(public_path('diagnostics.json'), json_encode($diagnostics, JSON_PRETTY_PRINT));
        } catch (\Exception $e) {
            // ignore
        }

        return view('Category-Page', [
            'pageTitle'       => $category->name . ' | Kidz Wear',
            'metaDescription' => 'Shop ' . $category->name . ' clothing for kids at Kidz Wear.',
            'categorySlug'    => $slug,
            'category'        => $category,
            'categoryName'    => $category->name,
            'categories'      => $categories,
            'products'        => $products,
            'productTypes'    => $productTypes,
            'ageGroups'       => $ageGroups,
            'activeSize'      => $sizeFilter,
            'activeProductType' => $productType,
            'minPrice'        => $minPrice,
            'maxPrice'        => $maxPrice,
        ]);
    }

    private function getProductTypes()
    {
        $defaultTypes = collect([
            'Casual Shirts',
            'T-Shirts',
            'Trousers',
            'Shorts',
            'Frocks',
            'Dresses',
            'Shalwar Kameez',
            'Jogger Sets',
            'Jackets',
            'Sweaters',
        ]);

        $assignedTypes = Product::where('status', 'active')
            ->pluck('product_type')
            ->filter(function ($type) {
                return trim((string) $type) !== '';
            });

        return $defaultTypes
            ->merge($assignedTypes)
            ->unique()
            ->values();
    }

    private function getAgeGroups(?string $categoryName = null)
    {
        $query = Product::where('status', 'active');

        if ($categoryName !== null) {
            $query->where('category', $categoryName);
        }

        return $query->pluck('age_group')
            ->map(fn ($ageGroup) => trim((string) $ageGroup))
            ->filter()
            ->unique(fn ($ageGroup) => strtolower($ageGroup))
            ->sort(SORT_NATURAL | SORT_FLAG_CASE)
            ->values();
    }
}
