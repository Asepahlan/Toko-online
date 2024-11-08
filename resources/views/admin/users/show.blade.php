@extends('layouts.admin')

@section('title', 'Detail Pengguna - Admin')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-light">
                    <div class="row align-items-center">
                        <div class="col">
                            <h6 class="mb-0">Detail Pengguna</h6>
                        </div>
                        <div class="col-auto">
                            <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 text-center">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&size=200&background=random"
                                 class="rounded-circle mb-3"
                                 alt="{{ $user->name }}">
                            <h5>{{ $user->name }}</h5>
                            <p class="text-muted">{{ $user->email }}</p>
                        </div>
                        <div class="col-md-8">
                            <h6 class="mb-3">Informasi Pengguna</h6>
                            <div class="table-responsive">
                                <table class="table">
                                    <tr>
                                        <th width="200">ID</th>
                                        <td>#{{ $user->id }}</td>
                                    </tr>
                                    <tr>
                                        <th>Tanggal Daftar</th>
                                        <td>{{ $user->created_at->format('d M Y H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Status Email</th>
                                        <td>
                                            @if($user->email_verified_at)
                                                <span class="badge bg-success">Terverifikasi</span>
                                            @else
                                                <span class="badge bg-warning">Belum Verifikasi</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>No. Telepon</th>
                                        <td>{{ $user->phone_number ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Alamat</th>
                                        <td>{{ $user->address ?? '-' }}</td>
                                    </tr>
                                </table>
                            </div>

                            <h6 class="mb-3 mt-4">Riwayat Pesanan</h6>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>ID Pesanan</th>
                                            <th>Tanggal</th>
                                            <th>Total</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($user->orders as $order)
                                            <tr>
                                                <td>#{{ $order->id }}</td>
                                                <td>{{ $order->created_at->format('d M Y') }}</td>
                                                <td>Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                                                <td>
                                                    <span class="badge bg-{{ $order->status_color }}">
                                                        {{ $order->status_label }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center">
                                                    Belum ada pesanan
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
