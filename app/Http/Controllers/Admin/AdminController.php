<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Data untuk statistik
        $totalOrders = Order::count();
        $totalProducts = Product::count();
        $totalUsers = User::where('role', '!=', 'admin')->count();
        $totalRevenue = Order::where('status', 'completed')->sum('total_amount');

        // Pesanan terbaru
        $recentOrders = Order::with('user')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalOrders',
            'totalProducts',
            'totalUsers',
            'totalRevenue',
            'recentOrders'
        ));
    }

    public function exportSalesReport(Request $request)
    {
        // Logika untuk export laporan penjualan
        // ...
    }
}
