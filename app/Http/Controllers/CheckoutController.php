<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\CouponUsage;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
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

        return view('checkout', [
            'pageTitle' => 'Checkout | Kidz Wear',
            'metaDescription' => 'Complete your purchase.',
            'cart' => $cart,
            'total' => $total
        ]);
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
            $request->session()->put('url.intended', route('checkout'));
            return redirect()->route('login')->with('error', 'Please log in before using a coupon code.');
        }

        try {
            $order = DB::transaction(function () use ($request, $cart, $total, $couponCode) {
                $coupon = null;
                $discountPercent = ($request->payment_method ?? 'cod') === 'online' ? 5 : 0;

                if ($couponCode !== '') {
                    $coupon = Coupon::where('code', $couponCode)->lockForUpdate()->first();

                    if (!$coupon || !$coupon->is_active) {
                        throw new \RuntimeException('This coupon code is invalid or inactive.');
                    }

                    if ($coupon->single_use_per_user && CouponUsage::where('coupon_id', $coupon->id)->where('user_id', auth()->id())->exists()) {
                        throw new \RuntimeException('This 10% coupon has already been used with your email address.');
                    }

                    // A coupon replaces the online-payment discount; the discounts never stack.
                    $discountPercent = $coupon->discount_percent;
                }

                $discount = round($total * ($discountPercent / 100), 2);
                $finalTotal = $total - $discount;

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
                    'status' => 'pending'
                ]);

                foreach ($cart as $productId => $item) {
                    \App\Models\OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => is_numeric($productId) ? $productId : null,
                        'product_name' => $item['name'],
                        'quantity' => $item['quantity'],
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

        return view('order-success', [
            'pageTitle' => 'Order Success | Kidz Wear',
            'metaDescription' => 'Your order has been placed successfully.',
            'orderId' => $order->order_number
        ]);
    }
}
