<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'category',
        'product_type',
        'age_group',
        'price',
        'sale_price',
        'description',
        'images',
        'stock_quantity',
        'status',
        'display_sections',
        'related_products',
        'color',
        'size'
    ];

    protected $casts = [
        'images' => 'array',
        'display_sections' => 'array',
        'related_products' => 'array',
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2'
    ];

    /**
     * Boot method to auto-generate slug
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = static::generateUniqueSlug($product->name);
            }
        });

        static::updating(function ($product) {
            if ($product->isDirty('name') && empty($product->slug)) {
                $product->slug = static::generateUniqueSlug($product->name, $product->id);
            }
        });
    }

    /**
     * Generate unique slug
     */
    public static function generateUniqueSlug($name, $ignoreId = null)
    {
        $slug = Str::slug($name);
        $count = 1;
        $originalSlug = $slug;

        while (static::where('slug', $slug)->when($ignoreId, function ($query) use ($ignoreId) {
            return $query->where('id', '!=', $ignoreId);
        })->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }

        return $slug;
    }

    /**
     * Get route key name for route model binding
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }
}

