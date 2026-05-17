<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColorSizeToProductsAndOrderItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Add to products table
        Schema::table('products', function (Blueprint $table) {
            $table->string('color')->nullable()->after('age_group');
            $table->string('size')->nullable()->after('color');
        });

        // Add to order_items table
        Schema::table('order_items', function (Blueprint $table) {
            $table->string('color')->nullable()->after('product_name');
            $table->string('size')->nullable()->after('color');
            $table->string('product_image')->nullable()->after('size');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['color', 'size']);
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->dropColumn(['color', 'size', 'product_image']);
        });
    }
}
