<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index($userId)
    {
        $user = User::find($userId);

        if (!$user) {
            return response()->json(['message' => 'User not found.'], 404);
        }

        $orders = $user->orders()->latest()->get();
        return response()->json($orders, 200);
    }

    public function getOrders()
    {
        $orders = Order::latest()->get();
        return response()->json($orders);
    }

    public function show($id)
    {
        $order = Order::with('products')->find($id);

        if (!$order) {
            return redirect()->route('orders')->with('error', 'Order not found');
        }

        return Inertia::render('Orders/Show', [
            'order' => $order,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'total_price' => 'required|numeric',
            'status' => 'string',
        ]);

        $order = Order::create($request->all());

        // Attach products if provided
        if ($request->has('products')) {
            $order->products()->attach($request->input('products'));
        }

        return redirect()->route('orders')->with('success', 'Order created successfully');
    }

    public function update(Request $request, $id)
    {
        $order = Order::find($id);

        if (!$order) {
            return redirect()->route('orders')->with('error', 'Order not found');
        }

        $request->validate([
            'total_price' => 'numeric',
            'status' => 'string',
        ]);

        $order->update($request->all());

        return redirect()->route('orders')->with('success', 'Order updated successfully');
    }

    public function updateStatus(Request $request, $id)
    {
       $request->validate([
        'status' => 'required|string|in:Pending,Confirmed,Shipped,Delivered',
    ]);

    $order = Order::find($id);

    if (!$order) {
        return response()->json(['message' => 'Order not found.'], 404);
    }

    $order->status = $request->input('status');

    $order->save();

    return response()->json(['message' => 'Order status updated successfully.', 'order' => $order], 200);
    }

    public function destroy($id)
    {
        $order = Order::find($id);

        if (!$order) {
            return redirect()->route('orders')->with('error', 'Order not found');
        }

        $order->delete();

        return redirect()->route('orders')->with('success', 'Order deleted successfully');
    }
    
}

