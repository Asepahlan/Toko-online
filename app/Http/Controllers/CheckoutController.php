<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index()
    {
        $cartItems = CartItem::with('product')
            ->where('user_id', Auth::id())
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Keranjang belanja Anda kosong');
        }

        $total = $cartItems->sum(function($item) {
            return $item->product->price * $item->quantity;
        });

        return view('checkout.index', compact('cartItems', 'total'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'shipping_address' => 'required|string',
            'contact_number' => 'required|string',
            'notes' => 'nullable|string'
        ]);

        $cartItems = CartItem::with('product')
            ->where('user_id', Auth::id())
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Keranjang belanja Anda kosong');
        }

        // Hitung total
        $total = $cartItems->sum(function($item) {
            return $item->product->price * $item->quantity;
        });

        try {
            DB::beginTransaction();

            // Buat order baru
            $order = Order::create([
                'user_id' => Auth::id(),
                'total_amount' => $total,
                'shipping_address' => $request->shipping_address,
                'contact_number' => $request->contact_number,
                'notes' => $request->notes,
                'status' => 'pending'
            ]);

            // Simpan item order
            foreach ($cartItems as $item) {
                $order->orderItems()->create([
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price
                ]);

                // Kurangi stok produk
                $item->product->decrement('stock', $item->quantity);
            }

            // Kosongkan keranjang
            CartItem::where('user_id', Auth::id())->delete();

            DB::commit();

            // Generate pesan WhatsApp
            $message = $this->generateWhatsAppMessage($order);
            $whatsappUrl = $this->generateWhatsAppUrl($message);

            return redirect()->route('orders.success', $order)
                ->with('whatsapp_url', $whatsappUrl);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat memproses pesanan');
        }
    }

    private function generateWhatsAppMessage(Order $order)
    {
        $message = "🛍️ *PESANAN BARU*\n\n";
        $message .= "No. Pesanan: #{$order->id}\n";
        $message .= "Nama: " . Auth::user()->name . "\n\n";

        $message .= "*Detail Pesanan:*\n";
        foreach ($order->orderItems as $item) {
            $message .= "- {$item->product->name} ({$item->quantity}x) @ Rp " .
                       number_format($item->price) . "\n";
        }

        $message .= "\nTotal: Rp " . number_format($order->total_amount) . "\n";
        $message .= "Alamat: {$order->shipping_address}\n";
        $message .= "No. HP: {$order->contact_number}\n";

        if ($order->notes) {
            $message .= "\nCatatan: {$order->notes}\n";
        }

        return $message;
    }

    private function generateWhatsAppUrl($message)
    {
        $phone = "6285215142110"; // Ganti dengan nomor WhatsApp toko
        return "https://wa.me/{$phone}?text=" . urlencode($message);
    }
}
