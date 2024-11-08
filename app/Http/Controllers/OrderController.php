<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        // Pastikan user hanya bisa melihat pesanannya sendiri
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $order->load(['orderItems.product', 'user']);

        return view('orders.show', compact('order'));
    }

    public function confirm(Order $order)
    {
        // Pastikan user hanya bisa mengkonfirmasi pesanannya sendiri
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $order->update([
            'status' => 'completed'
        ]);

        return back()->with('success', 'Pesanan berhasil dikonfirmasi');
    }

    public function track(Order $order)
    {
        // Pastikan user hanya bisa melacak pesanannya sendiri
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        return view('orders.track', compact('order'));
    }
}
