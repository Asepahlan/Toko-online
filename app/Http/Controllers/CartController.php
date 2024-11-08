<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    public function index()
    {
        // Ambil cart items untuk user yang login
        $cartItems = CartItem::with('product.category')
            ->where('user_id', Auth::id())
            ->get();

        // Hitung total
        $total = $cartItems->sum(function($item) {
            return $item->product->price * $item->quantity;
        });

        return view('cart.index', compact('cartItems', 'total'));
    }

    public function add(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'sometimes|numeric|min:1'
        ]);

        $quantity = $request->quantity ?? 1;

        // Cek stok produk
        if ($product->stock < $quantity) {
            return back()->with('error', 'Stok produk tidak mencukupi');
        }

        // Cek apakah produk sudah ada di cart
        $cartItem = CartItem::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->first();

        if ($cartItem) {
            // Update quantity jika produk sudah ada
            $cartItem->increment('quantity', $quantity);
        } else {
            // Tambah produk baru ke cart
            CartItem::create([
                'user_id' => Auth::id(),
                'product_id' => $product->id,
                'quantity' => $quantity
            ]);
        }

        return back()->with('success', 'Produk berhasil ditambahkan ke keranjang');
    }

    public function update(Request $request, $productId)
    {
        $request->validate([
            'quantity' => 'required|numeric|min:1'
        ]);

        $cartItem = CartItem::where('user_id', Auth::id())
            ->where('product_id', $productId)
            ->firstOrFail();

        // Cek stok produk
        if ($cartItem->product->stock < $request->quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Stok produk tidak mencukupi'
            ]);
        }

        $cartItem->update([
            'quantity' => $request->quantity
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Jumlah produk berhasil diperbarui'
        ]);
    }

    public function remove($productId)
    {
        CartItem::where('user_id', Auth::id())
            ->where('product_id', $productId)
            ->delete();

        return back()->with('success', 'Produk berhasil dihapus dari keranjang');
    }

    public function checkout(Request $request)
    {
        try {
            DB::beginTransaction();

            // Ambil cart items
            $cartItems = CartItem::with('product')
                ->where('user_id', Auth::id())
                ->get();

            if ($cartItems->isEmpty()) {
                return back()->with('error', 'Keranjang belanja kosong');
            }

            // Validasi stok
            foreach ($cartItems as $item) {
                if ($item->product->stock < $item->quantity) {
                    return back()->with('error', "Stok {$item->product->name} tidak mencukupi");
                }
            }

            // Hitung total
            $total = $cartItems->sum(function($item) {
                return $item->product->price * $item->quantity;
            });

            // Generate invoice number
            $invoiceNumber = 'INV-' . date('Ymd') . '-' . str_pad(Order::count() + 1, 4, '0', STR_PAD_LEFT);

            try {
                // Buat order dengan field yang sesuai dengan model
                $order = Order::create([
                    'invoice_number' => $invoiceNumber,
                    'user_id' => Auth::id(),
                    'total_amount' => $total,
                    'shipping_address' => 'Alamat akan diupdate',
                    'contact_number' => Auth::user()->phone ?? 'Nomor HP akan diupdate', // Sesuaikan dengan field di database
                    'notes' => '-',
                    'status' => 'pending'
                ]);

                // Buat order items
                foreach ($cartItems as $item) {
                    $order->orderItems()->create([
                        'product_id' => $item->product_id,
                        'quantity' => $item->quantity,
                        'price' => $item->product->price
                    ]);

                    // Kurangi stok produk
                    $item->product->decrement('stock', $item->quantity);
                }

                // Kosongkan cart
                CartItem::where('user_id', Auth::id())->delete();

                DB::commit();

                return redirect()->route('orders.show', $order)
                    ->with('success', 'Pesanan berhasil dibuat');

            } catch (\Exception $e) {
                Log::error('Error creating order: ' . $e->getMessage());
                DB::rollBack();
                return back()->with('error', 'Terjadi kesalahan saat membuat pesanan. Silakan coba lagi.');
            }

        } catch (\Exception $e) {
            Log::error('Error in checkout process: ' . $e->getMessage());
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan sistem. Silakan coba lagi nanti.');
        }
    }
}
