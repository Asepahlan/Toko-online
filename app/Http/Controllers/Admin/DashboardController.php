<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();
        $totalOrders = Order::count();
        $totalUsers = User::count();
        $totalRevenue = Order::where('status', 'completed')->sum('total');

        // Data untuk grafik
        $chartData = $this->getChartData();

        return view('admin.dashboard.index', compact(
            'totalProducts',
            'totalOrders',
            'totalUsers',
            'totalRevenue',
            'chartData'
        ));
    }

    private function getChartData()
    {
        $days = 7;
        $labels = [];
        $data = [];

        for ($i = $days - 1; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $labels[] = $date->format('d M');

            $data[] = Order::whereDate('created_at', $date)
                ->where('status', 'completed')
                ->sum('total');
        }

        return [
            'labels' => $labels,
            'data' => $data
        ];
    }
}
