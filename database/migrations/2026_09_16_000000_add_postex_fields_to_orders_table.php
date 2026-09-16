<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPostexFieldsToOrdersTable extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('postex_tracking_number')->nullable()->unique()->after('status');
            $table->string('postex_status')->nullable()->after('postex_tracking_number');
            $table->timestamp('postex_created_at')->nullable()->after('postex_status');
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropUnique(['postex_tracking_number']);
            $table->dropColumn(['postex_tracking_number', 'postex_status', 'postex_created_at']);
        });
    }
}
