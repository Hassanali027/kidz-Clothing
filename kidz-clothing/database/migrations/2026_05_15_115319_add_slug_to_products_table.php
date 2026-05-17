<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSlugToProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Check if slug column doesn't exist
        if (!Schema::hasColumn('products', 'slug')) {
            Schema::table('products', function (Blueprint $table) {
                $table->string('slug')->nullable()->after('name');
            });
        }
        
        // Generate slugs for existing products
        $products = \App\Models\Product::whereNull('slug')->orWhere('slug', '')->get();
        foreach ($products as $product) {
            $slug = \Illuminate\Support\Str::slug($product->name);
            $count = 1;
            $originalSlug = $slug;
            
            // Ensure unique slug
            while (\App\Models\Product::where('slug', $slug)->where('id', '!=', $product->id)->exists()) {
                $slug = $originalSlug . '-' . $count;
                $count++;
            }
            
            $product->slug = $slug;
            $product->save();
        }
        
        // Make slug unique if not already
        $indexes = \DB::select("SHOW INDEX FROM products WHERE Key_name = 'products_slug_unique'");
        if (empty($indexes)) {
            Schema::table('products', function (Blueprint $table) {
                $table->unique('slug');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
}
