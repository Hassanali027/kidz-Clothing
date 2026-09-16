<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        
        return view('cart', [
            'pageTitle' => 'Your Cart | Kidz Wear',
            'metaDescription' => 'Review items in your shopping cart.',
            'cart' => $cart
        ]);
    }

    public function add(Request $request)
    {
        $product = Product::find($request->input('product_id'));
        if (!$product) {
            return back()->with('error', 'This product is no longer available.');
        }

        $size = trim((string) $request->input('size'));
        $quantity = max(1, (int) $request->input('quantity', 1));
        if ($product->is_out_of_stock || $product->isSizeOutOfStock($size)) {
            return back()->with('error', 'This product or selected size is out of stock.');
        }

        $sizeStock = $product->size_stock ?? [];
        if (array_key_exists($size, $sizeStock) && $quantity > (int) $sizeStock[$size]) {
            return back()->with('error', 'Only ' . $sizeStock[$size] . ' item(s) are available for size ' . $size . '.');
        }

        if ($quantity > (int) $product->stock_quantity) {
            return back()->with('error', 'Only ' . $product->stock_quantity . ' item(s) are available.');
        }

        $cart = session()->get('cart', []);
        $id = 'product_' . $product->id . '_' . ($size !== '' ? $size : 'standard');
        
        if(isset($cart[$id])) {
            $newQuantity = $cart[$id]['quantity'] + $quantity;
            if (array_key_exists($size, $sizeStock) && $newQuantity > (int) $sizeStock[$size]) {
                return back()->with('error', 'Only ' . $sizeStock[$size] . ' item(s) are available for size ' . $size . '.');
            }
            if ($newQuantity > (int) $product->stock_quantity) {
                return back()->with('error', 'Only ' . $product->stock_quantity . ' item(s) are available.');
            }
            $cart[$id]['quantity'] = $newQuantity;
        } else {
            $cart[$id] = [
                "name" => $product->name,
                "quantity" => $quantity,
                "price" => $product->sale_price ?? $product->price,
                "image" => asset($product->images[0] ?? 'images/img-home/baby-wear.jpg'),
                "color" => $request->color ?? null,
                "size" => $size ?: null,
            ];
        }

        session()->put('cart', $cart);

        if ($request->buy_now == '1') {
            return redirect()->route('checkout');
        }

        return redirect()->route('cart')->with('success', 'Product added to cart!');
    }

    public function remove($id)
    {
        $cart = session()->get('cart', []);

        if(isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Product removed from cart!');
    }
}
