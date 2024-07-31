<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;


class DashboardController extends Controller
{
    public function getOrders()
    {
        $orders = Order::latest()->get();
        return response()->json($orders);
    }

    public function getStatistics()
    {
        $ordersThisWeek = Order::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count();
        $ordersThisMonth = Order::whereMonth('created_at', now()->month)->count();
        $revenueThisMonth = Order::whereMonth('created_at', now()->month)->sum('total');

        return response()->json([
            'ordersThisWeek' => $ordersThisWeek,
            'ordersThisMonth' => $ordersThisMonth,
            'revenueThisMonth' => $revenueThisMonth
        ]);
    }

    public function getTopProducts()
    {
        $topProducts = Product::withCount('orders')
            ->orderBy('orders_count', 'desc')
            ->take(5)
            ->get();

        return response()->json($topProducts);
    }
}
