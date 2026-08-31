<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateTestimonialsTable extends Migration
{
    public function up()
    {
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('review_text');
            $table->unsignedTinyInteger('rating')->default(5);
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        DB::table('testimonials')->insert([
            ['name' => 'Ayesha M.', 'review_text' => 'Finding comfortable and stylish clothes for my kids used to be difficult until I discovered this store. The variety is amazing!', 'rating' => 5, 'is_active' => true, 'sort_order' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Ali R.', 'review_text' => "Excellent quality! The clothes didn't fade or shrink after washing. My kids love wearing them all day long.", 'rating' => 5, 'is_active' => true, 'sort_order' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Fatima S.', 'review_text' => 'Very fast delivery and perfect sizes. The customer service was also very helpful when I had a question about sizing.', 'rating' => 5, 'is_active' => true, 'sort_order' => 3, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('testimonials');
    }
}
