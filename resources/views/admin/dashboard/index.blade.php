@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-md-3 mb-4">
        <div class="card shadow-sm">
            <div class="card-body text-center">
                <h5 class="card-title">Total Produk</h5>
                <h2 class="card-text">{{ $totalProducts }}</h2>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-4">
        <div class="card shadow-sm">
            <div class="card-body text-center">
                <h5 class="card-title">Total Pesanan</h5>
                <h2 class="card-text">{{ $totalOrders }}</h2>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-4">
        <div class="card shadow-sm">
            <div class="card-body text-center">
                <h5 class="card-title">Total Pengguna</h5>
                <h2 class="card-text">{{ $totalUsers }}</h2>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-4">
        <div class="card shadow-sm">
            <div class="card-body text-center">
                <h5 class="card-title">Pendapatan</h5>
                <h2 class="card-text">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h2>
            </div>
        </div>
    </div>

    <!-- Grafik Penjualan -->
    <div class="col-12 mt-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Grafik Penjualan</h5>
                <p class="text-muted">7 hari terakhir</p>
                <canvas id="salesChart" height="100"></canvas>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('salesChart').getContext('2d');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($chartData['labels']) !!},
            datasets: [{
                label: 'Penjualan (Rp)',
                data: {!! json_encode($chartData['data']) !!},
                borderColor: 'rgb(54, 162, 235)',
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                tension: 0.1,
                fill: true
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                        }
                    }
                }
            }
        }
    });
});
</script>
@endsection
