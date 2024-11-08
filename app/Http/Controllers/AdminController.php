<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function dashboard()
    {
        $stats = [
            'products' => Product::count(),
            'categories' => Category::count(),
            'orders' => Order::count(),
            'users' => User::where('role', 'user')->count(),
            'totalSales' => Order::where('status', 'completed')->sum('total_amount'),
            'newOrders' => Order::where('status', 'pending')->count(),
        ];

        // Data untuk grafik penjualan 7 hari terakhir
        $dates = collect(range(6, 0))->map(function($days) {
            return now()->subDays($days)->format('Y-m-d');
        });

        $chartData = [
            'labels' => $dates->map(fn($date) => Carbon::parse($date)->format('d/m')),
            'data' => $dates->map(function($date) {
                return Order::where('status', 'completed')
                    ->whereDate('created_at', $date)
                    ->sum('total_amount') ?? 0;
            })
        ];

        $latestProducts = Product::latest()->take(5)->get();
        $latestOrders = Order::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'stats',
            'latestProducts',
            'latestOrders',
            'chartData'
        ));
    }

    public function exportSalesReport(Request $request)
    {
        $type = $request->type;
        $query = Order::where('status', 'completed');

        switch ($type) {
            case 'daily':
                $data = $query->whereDate('created_at', today())->get();
                $title = 'Laporan Penjualan Harian - ' . today()->format('d/m/Y');
                break;

            case 'weekly':
                $data = $query->whereBetween('created_at', [
                    now()->startOfWeek(),
                    now()->endOfWeek()
                ])->get();
                $title = 'Laporan Penjualan Mingguan';
                break;

            case 'monthly':
                $data = $query->whereMonth('created_at', now()->month)
                             ->whereYear('created_at', now()->year)
                             ->get();
                $title = 'Laporan Penjualan Bulanan - ' . now()->format('F Y');
                break;

            case 'custom':
                $request->validate([
                    'start_date' => 'required|date',
                    'end_date' => 'required|date|after_or_equal:start_date'
                ]);

                $data = $query->whereBetween('created_at', [
                    $request->start_date,
                    $request->end_date
                ])->get();
                $title = 'Laporan Penjualan Kustom';
                break;

            default:
                return back()->with('error', 'Tipe laporan tidak valid');
        }

        if ($data->isEmpty()) {
            return back()->with('error', 'Tidak ada data untuk periode yang dipilih');
        }

        // Generate CSV content
        $csvContent = "No. Invoice,Tanggal,Pelanggan,Total,Status\n";

        foreach ($data as $order) {
            $csvContent .= sprintf(
                '"%s","%s","%s","Rp %s","%s"' . "\n",
                $order->invoice_number,
                $order->created_at->format('d/m/Y H:i'),
                $order->user->name,
                number_format($order->total_amount),
                $order->status_label
            );
        }

        $filename = "laporan-penjualan-{$type}-" . now()->format('Y-m-d') . ".csv";

        return response($csvContent)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', "attachment; filename=\"$filename\"");
    }
}
