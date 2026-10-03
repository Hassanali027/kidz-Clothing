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
        'merged' => 'Merged Order',
    ];

    protected $fillable = [
        'user_id',
        'order_number',
        'first_name',
        'last_name',
        'address',
        'delivery_note',
        'city',
        'phone',
        'coupon_code',
        'discount_amount',
        'total_amount',
        'payment_method',
        'status',
        'postex_tracking_number',
        'postex_status',
        'postex_created_at',
        'workflow_category',
        'is_new',
        'merged_into_order_id',
    ];

    public static function workflowCategories(): array
    {
        return self::WORKFLOW_CATEGORIES;
    }

    /**
     * A stable key for spotting repeat orders from the same contact and delivery address.
     */
    public static function duplicateContactKey($phone, $address, $city = null)
    {
        $normalPhone = preg_replace('/\D+/', '', (string) $phone);
        $normalAddress = strtolower(trim(preg_replace('/\s+/', ' ', (string) $address)));
        $normalCity = strtolower(trim(preg_replace('/\s+/', ' ', (string) $city)));

        if ($normalPhone === '' || $normalAddress === '') {
            return null;
        }

        return $normalPhone . '|' . $normalAddress . '|' . $normalCity;
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /** The combined order this source order was moved into. */
    public function mergedIntoOrder()
    {
        return $this->belongsTo(self::class, 'merged_into_order_id');
    }

    /** Original orders that were combined into this order. */
    public function mergedOrders()
    {
        return $this->hasMany(self::class, 'merged_into_order_id');
    }

    /**
     * Restore stock for items in this order when cancelled or deleted.
     */
    public function restoreStock(): void
    {
        $this->loadMissing('items.product');

        foreach ($this->items as $item) {
            $product = $item->product ?? Product::find($item->product_id);
            if (!$product) {
                continue;
            }

            $quantity = max(1, (int) $item->quantity);
            $size = trim((string) ($item->size ?? ''));
            $sizeStock = $product->size_stock ?? [];

            if ($size !== '' && is_array($sizeStock) && array_key_exists($size, $sizeStock)) {
                $sizeStock[$size] = (int) $sizeStock[$size] + $quantity;
                $product->size_stock = $sizeStock;
            }

            $product->stock_quantity = (int) $product->stock_quantity + $quantity;

            if ($product->status === 'out-of-stock' && $product->stock_quantity > 0) {
                $product->status = 'active';
            }

            $product->save();
        }
    }

    /**
     * Re-deduct stock for items in this order if un-cancelled.
     */
    public function deductStock(): void
    {
        $this->loadMissing('items.product');

        foreach ($this->items as $item) {
            $product = $item->product ?? Product::find($item->product_id);
            if (!$product) {
                continue;
            }

            $quantity = max(1, (int) $item->quantity);
            $size = trim((string) ($item->size ?? ''));
            $sizeStock = $product->size_stock ?? [];

            if ($size !== '' && is_array($sizeStock) && array_key_exists($size, $sizeStock)) {
                $sizeStock[$size] = max(0, (int) $sizeStock[$size] - $quantity);
                $product->size_stock = $sizeStock;
            }

            $product->stock_quantity = max(0, (int) $product->stock_quantity - $quantity);
            $product->save();
        }
    }
}
