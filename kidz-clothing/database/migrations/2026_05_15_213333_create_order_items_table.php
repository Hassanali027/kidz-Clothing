<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_items', function (Blueprint $row) {
            $row->id();
            $row->foreignId('order_id')->constrained()->onDelete('cascade');
            $row->foreignId('product_id')->nullable()->constrained()->onDelete('set null');
            $row->string('product_name');
            $row->integer('quantity');
            $row->decimal('price', 12, 2);
            $row->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_items');
    }
}
