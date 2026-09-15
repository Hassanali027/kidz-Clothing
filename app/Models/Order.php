<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public const WORKFLOW_CATEGORIES = [
        'follow_up' => 'Follow Up',
        'new_order' => 'New Order',
        'print_taken' => 'Print Taken',
        'incomplete' => 'Incomplete',
        'reverse' => 'Reverse',
        'not_verified' => 'Not Verified',
        'duplicate' => 'Duplicate',
        'discount_5' => '5% Discount',
        'after_edit' => 'After Edit',
        'dispatched' => 'Dispatched',
        'hold' => 'Hold',
        'posted' => 'Posted',
    ];

    protected $fillable = [
        'user_id',
        'order_number',
        'first_name',
        'last_name',
        'address',
        'city',
        'phone',
        'coupon_code',
        'discount_amount',
        'total_amount',
        'payment_method',
        'status',
        'workflow_category',
        'is_new',
    ];

    public static function workflowCategories(): array
    {
        return self::WORKFLOW_CATEGORIES;
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
