<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'name', 'review_text', 'rating', 'is_active', 'sort_order'];

    protected $casts = ['is_active' => 'boolean'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
