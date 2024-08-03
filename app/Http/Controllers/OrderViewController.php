<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderViewController extends Controller
{
    public function getOrders()
    {
        $orders = Order::latest()->get();
        return response()->json($orders);
    }
}
