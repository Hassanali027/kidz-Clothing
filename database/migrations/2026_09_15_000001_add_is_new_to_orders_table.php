<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsNewToOrdersTable extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            // Existing orders remain unchanged; only newly placed orders are marked new.
            $table->boolean('is_new')->default(false)->after('workflow_category')->index();
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropIndex(['is_new']);
            $table->dropColumn('is_new');
        });
    }
}
