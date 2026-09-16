<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\CouponUsage;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    private const FREE_DELIVERY_THRESHOLD = 3000;
    private const SHIPPING_CHARGE = 199;

    public function index()
    {
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart')->with('error', 'Your cart is empty!');
        }

        $total = 0;
        foreach($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        $couponCode = session('checkout_coupon_code');
        $coupon = null;
        $couponError = null;

        if ($couponCode && auth()->check()) {
            list($coupon, $couponError) = $this->findUsableCoupon($couponCode);
            if (!$coupon) {
                session()->forget('checkout_coupon_code');
                $couponCode = null;
            }
        }

        $couponDiscount = $coupon ? round($total * ($coupon->discount_percent / 100), 2) : 0;
        $shippingCharge = $total < self::FREE_DELIVERY_THRESHOLD ? self::SHIPPING_CHARGE : 0;
        $freeDeliveryRemaining = max(0, self::FREE_DELIVERY_THRESHOLD - $total);

        return view('checkout', [
            'pageTitle' => 'Checkout | Kidz Wear',
            'metaDescription' => 'Complete your purchase.',
            'cart' => $cart,
            'total' => $total,
            'couponCode' => $couponCode,
            'coupon' => $coupon,
            'couponDiscount' => $couponDiscount,
            'couponError' => $couponError,
            'shippingCharge' => $shippingCharge,
            'freeDeliveryRemaining' => $freeDeliveryRemaining,
        ]);
    }

    public function applyCoupon(Request $request)
    {
        $request->validate(['coupon_code' => 'nullable|string|max:50']);

        $couponCode = strtoupper(trim((string) $request->coupon_code));
        if ($couponCode === '') {
            session()->forget('checkout_coupon_code');
            return redirect()->route('checkout')->with('success', 'Coupon removed.');
        }

        session(['checkout_coupon_code' => $couponCode]);

        if (!auth()->check()) {
            $request->session()->put('url.intended', route('checkout'));
            return redirect()->route('login')->with('error', 'Please log in or create an account to use this coupon.');
        }

        list($coupon, $error) = $this->findUsableCoupon($couponCode);
        if (!$coupon) {
            session()->forget('checkout_coupon_code');
            return redirect()->route('checkout')->with('error', $error);
        }

        return redirect()->route('checkout')->with('success', $coupon->discount_percent . '% coupon applied successfully.');
    }

    public function placeOrder(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'address' => 'required',
            'city' => 'required',
            'phone' => 'required',
            'coupon_code' => 'nullable|string|max:50',
        ]);

        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart')->with('error', 'Your cart is empty!');
        }

        $total = 0;
        foreach($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        $couponCode = strtoupper(trim((string) $request->coupon_code));
        if ($couponCode !== '' && !auth()->check()) {
            session(['checkout_coupon_code' => $couponCode]);
            $request->session()->put('url.intended', route('checkout'));
            return redirect()->route('login')->with('error', 'Please log in before using a coupon code.');
        }

        try {
            $order = DB::transaction(function () use ($request, $cart, $total, $couponCode) {
                $coupon = null;
                $discountPercent = ($request->payment_method ?? 'cod') === 'online' ? 5 : 0;
                $contactKey = Order::duplicateContactKey($request->phone, $request->address, $request->city);
                $isDuplicate = $contactKey !== null && Order::select('phone', 'address', 'city')
                    ->get()
                    ->contains(function ($existingOrder) use ($contactKey) {
                        return Order::duplicateContactKey($existingOrder->phone, $existingOrder->address, $existingOrder->city) === $contactKey;
                    });

                if ($couponCode !== '') {
                    $coupon = Coupon::where('code', $couponCode)->lockForUpdate()->first();

                    if (!$coupon || !$coupon->is_active) {
                        throw new \RuntimeException('This coupon code is invalid or inactive.');
                    }

                    if ($coupon->single_use_per_user && CouponUsage::where('coupon_id', $coupon->id)->where('user_id', auth()->id())->exists()) {
                        throw new \RuntimeException('This 10% coupon has already been used with your email address.');
                    }

                    // Coupon and online-payment discounts are both applied.
                    $discountPercent += $coupon->discount_percent;
                }

                $discount = round($total * ($discountPercent / 100), 2);
                $shippingCharge = $total < self::FREE_DELIVERY_THRESHOLD ? self::SHIPPING_CHARGE : 0;
                $finalTotal = $total - $discount + $shippingCharge;

                $order = Order::create([
                    'user_id' => auth()->id(),
                    'order_number' => 'KW-' . strtoupper(\Illuminate\Support\Str::random(8)),
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'address' => $request->address,
                    'city' => $request->city,
                    'phone' => $request->phone,
                    'coupon_code' => $coupon ? $coupon->code : null,
                    'discount_amount' => $discount,
                    'total_amount' => $finalTotal,
                    'payment_method' => $request->payment_method ?? 'cod',
                    'status' => 'pending',
                    'workflow_category' => $isDuplicate ? 'duplicate' : 'new_order',
                    'is_new' => true,
                ]);

                foreach ($cart as $cartKey => $item) {
                    $productId = $this->productIdFromCartItem($cartKey, $item);
                    $quantity = max(1, (int) ($item['quantity'] ?? 1));
                    $size = trim((string) ($item['size'] ?? ''));

                    if (!$productId) {
                        throw new \RuntimeException('One of the products in your cart is no longer available.');
                    }

                    $product = Product::whereKey($productId)->lockForUpdate()->first();
                    if (!$product || $product->status !== 'active' || $product->is_out_of_stock) {
                        throw new \RuntimeException('One of the products in your cart is out of stock.');
                    }

                    $sizeStock = $product->size_stock ?? [];
                    if (!empty($sizeStock) && ($size === '' || !array_key_exists($size, $sizeStock))) {
                        throw new \RuntimeException('The selected size for ' . $product->name . ' is no longer available.');
                    }

                    if ($size !== '' && array_key_exists($size, $sizeStock) && (int) $sizeStock[$size] < $quantity) {
                        throw new \RuntimeException('Only ' . $sizeStock[$size] . ' item(s) are available for size ' . $size . '.');
                    }

                    if ((int) $product->stock_quantity < $quantity) {
                        throw new \RuntimeException('Only ' . $product->stock_quantity . ' item(s) are available for ' . $product->name . '.');
                    }

                    $hasManagedSizeStock = !empty($sizeStock);
                    if ($size !== '' && array_key_exists($size, $sizeStock)) {
                        $sizeStock[$size] = (int) $sizeStock[$size] - $quantity;
                        $product->size_stock = $sizeStock;
                    }

                    // When the product has age/size-wise stock, its main stock is
                    // the sum of those quantities. This keeps product cards and the
                    // detail page in sync after every completed order.
                    $product->stock_quantity = $hasManagedSizeStock
                        ? collect($sizeStock)->sum(function ($available) { return (int) $available; })
                        : (int) $product->stock_quantity - $quantity;

                    $product->save();

                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'product_name' => $item['name'],
                        'quantity' => $quantity,
                        'price' => $item['price'],
                        'product_image' => $item['image'] ?? null,
                        'color' => $item['color'] ?? null,
                        'size' => $item['size'] ?? null,
                    ]);
                }

                if ($coupon && $coupon->single_use_per_user) {
                    CouponUsage::create([
                        'coupon_id' => $coupon->id,
                        'user_id' => auth()->id(),
                        'order_id' => $order->id,
                    ]);
                }

                return $order;
            });
        } catch (\RuntimeException $exception) {
            return back()->withInput()->with('error', $exception->getMessage());
        }

        // Clear cart
        session()->forget('cart');
        session()->forget('checkout_coupon_code');

        return view('order-success', [
            'pageTitle' => 'Order Success | Kidz Wear',
            'metaDescription' => 'Your order has been placed successfully.',
            'orderId' => $order->order_number
        ]);
    }

    private function findUsableCoupon($couponCode)
    {
        $coupon = Coupon::where('code', strtoupper(trim($couponCode)))
            ->where('is_active', true)
            ->first();

        if (!$coupon) {
            return [null, 'This coupon code is invalid or inactive.'];
        }

        if ($coupon->single_use_per_user && CouponUsage::where('coupon_id', $coupon->id)->where('user_id', auth()->id())->exists()) {
            return [null, 'This 10% coupon has already been used with your email address.'];
        }

        return [$coupon, null];
    }

    /**
     * Cart entries created before product_id was added use a key like
     * "product_42_1-2Y". Keep those existing carts checkout-safe as well.
     */
    private function productIdFromCartItem($cartKey, array $item)
    {
        if (!empty($item['product_id']) && is_numeric($item['product_id'])) {
            return (int) $item['product_id'];
        }

        if (preg_match('/^product_(\d+)(?:_|$)/', (string) $cartKey, $matches)) {
            return (int) $matches[1];
        }

        return null;
    }
}
