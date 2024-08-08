<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function index()
    {
        $cart = Session::get('cart', []);
        return Inertia::render('Cart/Index', [
            'cart' => $cart,
        ]);
    }

    public function getCart()
    {
        $cart = Cart::latest()->get();
        return response()->json($cart);
    }

    public function add(Request $request)
    {
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity');

        $cart = Session::get('cart', []);
        $cart[$productId] = $quantity;
        Session::put('cart', $cart);

        return redirect()->route('cart.index')->with('success', 'Product added to cart');
    }

    public function remove(Request $request)
    {
        $productId = $request->input('product_id');

        $cart = Session::get('cart', []);
        unset($cart[$productId]);
        Session::put('cart', $cart);

        return redirect()->route('cart.index')->with('success', 'Product removed from cart');
    }

    public function update(Request $request)
    {
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity');

        $cart = Session::get('cart', []);
        $cart[$productId] = $quantity;
        Session::put('cart', $cart);

        return redirect()->route('cart.index')->with('success', 'Cart updated');
    }
}
