<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        ]);

        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart')->with('error', 'Your cart is empty!');
        }

        $total = 0;
        foreach($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        // Create the order in database
        $order = \App\Models\Order::create([
            'order_number' => 'KW-' . strtoupper(\Illuminate\Support\Str::random(8)),
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'address' => $request->address,
            'city' => $request->city,
            'phone' => $request->phone,
            'total_amount' => $total,
            'payment_method' => $request->payment_method ?? 'cod',
            'status' => 'pending'
        ]);

        // Save order items
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

        // Clear cart
        session()->forget('cart');

        return view('order-success', [
            'pageTitle' => 'Order Success | Kidz Wear',
            'metaDescription' => 'Your order has been placed successfully.',
            'orderId' => $order->order_number
        ]);
    }
}
