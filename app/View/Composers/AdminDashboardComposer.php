<?php

namespace App\View\Composers;

use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class AdminDashboardComposer
{
    public function compose(View $view)
    {
        // Data untuk chart penjualan
        $salesData = DB::table('orders')
            ->selectRaw('MONTH(created_at) as month, SUM(total_amount) as total')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->get();

        $chartData = [
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'],
            'data' => array_fill(0, 12, 0)
        ];

        foreach ($salesData as $sale) {
            $chartData['data'][$sale->month - 1] = $sale->total;
        }

        $view->with('chartData', $chartData);
    }
}
