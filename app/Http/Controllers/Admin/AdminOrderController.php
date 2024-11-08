<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdminOrderController extends Controller
{
    public function index()
    {
        // Hitung jumlah pesanan berdasarkan status
        $pendingOrders = Order::where('status', 'pending')->count();
        $processingOrders = Order::where('status', 'processing')->count();
        $completedOrders = Order::where('status', 'completed')->count();
        $cancelledOrders = Order::where('status', 'cancelled')->count();

        // Ambil semua pesanan dengan relasi user dan orderItems
        $orders = Order::with(['user', 'orderItems.product'])
            ->latest()
            ->paginate(10);

        return view('admin.orders.index', compact(
            'orders',
            'pendingOrders',
            'processingOrders',
            'completedOrders',
            'cancelledOrders'
        ));
    }

    public function show(Order $order)
    {
        $order->load(['user', 'orderItems.product']);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,completed,cancelled'
        ]);

        try {
            DB::beginTransaction();

            $oldStatus = $order->status;
            $newStatus = $request->status;

            // Update status pesanan
            $order->update([
                'status' => $newStatus
            ]);

            // Jika status berubah menjadi dibatalkan, kembalikan stok produk
            if ($newStatus === 'cancelled' && $oldStatus !== 'cancelled') {
                foreach ($order->orderItems as $item) {
                    $item->product->increment('stock', $item->quantity);
                }
            }

            // Jika status berubah dari dibatalkan, kurangi stok produk
            if ($oldStatus === 'cancelled' && $newStatus !== 'cancelled') {
                foreach ($order->orderItems as $item) {
                    $item->product->decrement('stock', $item->quantity);
                }
            }

            DB::commit();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Status pesanan berhasil diperbarui'
                ]);
            }

            return back()->with('success', 'Status pesanan berhasil diperbarui');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating order status: ' . $e->getMessage());
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal memperbarui status pesanan'
                ]);
            }

            return back()->with('error', 'Gagal memperbarui status pesanan');
        }
    }

    public function destroy(Order $order)
    {
        try {
            DB::beginTransaction();

            // Jika pesanan belum dibatalkan, kembalikan stok produk
            if ($order->status !== 'cancelled') {
                foreach ($order->orderItems as $item) {
                    $item->product->increment('stock', $item->quantity);
                }
            }

            // Hapus order items terlebih dahulu
            $order->orderItems()->delete();

            // Kemudian hapus order
            $order->delete();

            DB::commit();

            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Pesanan berhasil dihapus'
                ]);
            }

            return back()->with('success', 'Pesanan berhasil dihapus');

        } catch (\Exception $e) {
            DB::rollBack();

            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menghapus pesanan'
                ]);
            }

            return back()->with('error', 'Gagal menghapus pesanan');
        }
    }

    public function exportOrders()
    {
        // Logika untuk export data pesanan (bisa ditambahkan nanti)
    }
}
