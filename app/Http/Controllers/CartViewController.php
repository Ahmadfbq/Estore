<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;

class CartViewController extends Controller
{
    public function getCart()
    {
        $cart = Cart::latest()->get();
        return response()->json($cart);
    }
}
