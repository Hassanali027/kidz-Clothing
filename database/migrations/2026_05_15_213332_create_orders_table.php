<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $row) {
            $row->id();
            $row->string('order_number')->unique();
            $row->string('first_name');
            $row->string('last_name');
            $row->string('address');
            $row->string('city');
            $row->string('phone');
            $row->decimal('total_amount', 12, 2);
            $row->string('payment_method')->default('cod');
            $row->string('status')->default('pending');
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
        Schema::dropIfExists('orders');
    }
}
