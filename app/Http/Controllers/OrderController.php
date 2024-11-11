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

    public function track($id)
    {
        $order = Order::findOrFail($id);
        $whatsappNumber = env('WHATSAPP_NUMBER', '6281234567890');

        // Buat pesan WhatsApp
        $message = "Halo Admin AhlanBoys, saya ingin konfirmasi pesanan:\n"
            . "No. Pesanan: " . $order->invoice_number . "\n"
            . "Total: Rp " . number_format($order->total_amount, 0, ',', '.') . "\n"
            . "Nama: " . $order->user->name;

        return view('orders.track', [
            'order' => $order,
            'whatsappNumber' => $whatsappNumber,
            'message' => $message
        ]);
    }
}
