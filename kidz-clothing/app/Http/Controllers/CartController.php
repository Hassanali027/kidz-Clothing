<?php

namespace App\Http\Controllers;

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
        $cart = session()->get('cart', []);

        $id = $request->id ?? 'prod_'.time();
        
        if(isset($cart[$id])) {
            $cart[$id]['quantity'] += $request->quantity ?? 1;
        } else {
            $cart[$id] = [
                "name" => $request->name,
                "quantity" => $request->quantity ?? 1,
                "price" => $request->price,
                "image" => $request->image,
                "color" => $request->color ?? null,
                "size" => $request->size ?? null,
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
