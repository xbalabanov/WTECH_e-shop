<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $orders = $user->orders()->with('items.book')->orderByDesc('placed_at')->get();

        // Calculate stats
        $totalOrders = $orders->count();
        $totalSpent = (float) $orders->sum('total');
        $inTransit = $orders->where('status', 'pending')->count() + $orders->where('status', 'processing')->count() + $orders->where('status', 'shipped')->count();
        $delivered = $orders->where('status', 'delivered')->count();

        return view('profile', [
            'orders' => $orders,
            'totalOrders' => $totalOrders,
            'totalSpent' => $totalSpent,
            'inTransit' => $inTransit,
            'delivered' => $delivered,
        ]);
    }

    public function show($orderId)
    {
        $order = auth()->user()->orders()->findOrFail($orderId);
        $order->load('items.book', 'billingAddress', 'shippingAddress', 'payment');

        return view('order-details', [
            'order' => $order,
        ]);
    }
}
