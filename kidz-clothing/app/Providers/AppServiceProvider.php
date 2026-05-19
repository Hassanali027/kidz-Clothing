<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('partials.header', function ($view) {
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

            try {
                $assignedTypes = Product::where('status', 'active')
                    ->pluck('product_type')
                    ->filter(function ($type) {
                        return trim((string) $type) !== '';
                    });

                $accessoriesCategory = Category::where('status', 'active')
                    ->where(function ($query) {
                        $query->where('slug', 'accessories')
                            ->orWhere('slug', 'accessories-wear')
                            ->orWhere('name', 'accessories')
                            ->orWhere('name', 'Accessories');
                    })
                    ->first();
            } catch (\Exception $e) {
                $assignedTypes = collect();
                $accessoriesCategory = null;
            }

            $view->with([
                'mobileProductTypes' => $defaultTypes->merge($assignedTypes)->unique()->values(),
                'accessoriesCategory' => $accessoriesCategory,
            ]);
        });
    }
}
