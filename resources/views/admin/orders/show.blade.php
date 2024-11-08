@php
    use Illuminate\Support\Facades\Storage;
@endphp

@extends('layouts.admin')

@section('title', 'Detail Pesanan - ' . config('app.name'))

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Detail Pesanan</h1>
            <p class="text-muted">{{ $order->invoice_number }}</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-primary">
                <i class="bi bi-arrow-left me-2"></i>Kembali
            </a>
            <button type="button"
                    class="btn btn-success"
                    data-bs-toggle="modal"
                    data-bs-target="#updateStatusModal">
                <i class="bi bi-pencil me-2"></i>Update Status
            </button>
        </div>
    </div>

    <div class="row g-4">
        <!-- Order Status -->
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-4">Status Pesanan</h5>

                    <!-- Progress Steps -->
                    <div class="position-relative mb-5">
                        <!-- Progress Bar -->
                        <div class="progress" style="height: 2px;">
                            <div class="progress-bar bg-primary" role="progressbar" style="width:
                                @switch($order->status)
                                    @case('pending') 0% @break
                                    @case('processing') 33% @break
                                    @case('shipped') 66% @break
                                    @case('completed') 100% @break
                                    @default 0%
                                @endswitch
                            "></div>
                        </div>

                        <!-- Progress Steps -->
                        <div class="d-flex justify-content-between position-relative" style="margin-top: -15px;">
                            <!-- Pending -->
                            <div class="text-center" style="width: 120px; margin-left: -60px;">
                                <div class="rounded-circle bg-{{ $order->status === 'pending' ? $order->status_color : ($order->status === 'cancelled' ? 'danger' : 'secondary') }} d-flex align-items-center justify-content-center mx-auto mb-2"
                                     style="width: 30px; height: 30px;">
                                    <i class="bi bi-clock-fill text-white small"></i>
                                </div>
                                <span class="d-block small fw-medium">Menunggu Pembayaran</span>
                                @if($order->status === 'pending')
                                    <small class="text-muted">{{ $order->created_at->format('d/m/Y H:i') }}</small>
                                @endif
                            </div>

                            <!-- Processing -->
                            <div class="text-center" style="width: 120px; margin-left: -60px;">
                                <div class="rounded-circle bg-{{ $order->status === 'processing' ? $order->status_color : 'secondary' }} d-flex align-items-center justify-content-center mx-auto mb-2"
                                     style="width: 30px; height: 30px;">
                                    <i class="bi bi-gear-fill text-white small"></i>
                                </div>
                                <span class="d-block small fw-medium">Diproses</span>
                                @if($order->status === 'processing')
                                    <small class="text-muted">{{ $order->updated_at->format('d/m/Y H:i') }}</small>
                                @endif
                            </div>

                            <!-- Shipped -->
                            <div class="text-center" style="width: 120px; margin-left: -60px;">
                                <div class="rounded-circle bg-{{ $order->status === 'shipped' ? $order->status_color : 'secondary' }} d-flex align-items-center justify-content-center mx-auto mb-2"
                                     style="width: 30px; height: 30px;">
                                    <i class="bi bi-truck text-white small"></i>
                                </div>
                                <span class="d-block small fw-medium">Dikirim</span>
                                @if($order->status === 'shipped')
                                    <small class="text-muted">{{ $order->updated_at->format('d/m/Y H:i') }}</small>
                                @endif
                            </div>

                            <!-- Completed -->
                            <div class="text-center" style="width: 120px; margin-right: -60px;">
                                <div class="rounded-circle bg-{{ $order->status === 'completed' ? $order->status_color : 'secondary' }} d-flex align-items-center justify-content-center mx-auto mb-2"
                                     style="width: 30px; height: 30px;">
                                    <i class="bi bi-check-lg text-white"></i>
                                </div>
                                <span class="d-block small fw-medium">Selesai</span>
                                @if($order->status === 'completed')
                                    <small class="text-muted">{{ $order->updated_at->format('d/m/Y H:i') }}</small>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Current Status -->
                    <div class="alert alert-{{ $order->status_color }} d-flex align-items-center" role="alert">
                        <i class="bi bi-info-circle-fill me-2"></i>
                        <div>
                            Status pesanan: <strong>{{ $order->status_label }}</strong>
                            @if($order->status === 'pending')
                                <br>
                                <small>Batas waktu pembayaran: {{ $order->created_at->addDays(1)->format('d/m/Y H:i') }}</small>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Customer Info -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-4">Informasi Pelanggan</h5>
                    <div class="mb-3">
                        <label class="text-muted small">Nama</label>
                        <p class="mb-0">{{ $order->user->name }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted small">Email</label>
                        <p class="mb-0">{{ $order->user->email }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted small">No. HP</label>
                        <p class="mb-0">{{ $order->contact_number }}</p>
                    </div>
                    <div>
                        <label class="text-muted small">Alamat Pengiriman</label>
                        <p class="mb-0">{{ $order->shipping_address }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Details -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-4">Detail Pesanan</h5>
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Produk</th>
                                    <th>Harga</th>
                                    <th>Jumlah</th>
                                    <th class="text-end">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->orderItems as $item)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if($item->product->image)
                                                    <img src="{{ Storage::url($item->product->image) }}"
                                                         alt="{{ $item->product->name }}"
                                                         class="rounded me-3"
                                                         style="width: 50px; height: 50px; object-fit: cover;">
                                                @else
                                                    <div class="bg-light rounded me-3 d-flex align-items-center justify-content-center"
                                                         style="width: 50px; height: 50px;">
                                                        <i class="bi bi-image text-secondary"></i>
                                                    </div>
                                                @endif
                                                <div>
                                                    <h6 class="mb-0">{{ $item->product->name }}</h6>
                                                    <small class="text-muted">{{ $item->product->category->name }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>Rp {{ number_format($item->price) }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td class="text-end">
                                            Rp {{ number_format($item->price * $item->quantity) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="table-light">
                                <tr>
                                    <td colspan="3" class="text-end"><strong>Total</strong></td>
                                    <td class="text-end">
                                        <strong class="text-primary">Rp {{ number_format($order->total_amount) }}</strong>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    @if($order->notes)
                        <div class="mt-3">
                            <label class="text-muted small">Catatan</label>
                            <p class="mb-0">{{ $order->notes }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Update Status Modal -->
<div class="modal fade" id="updateStatusModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.orders.update-status', $order) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-header">
                    <h5 class="modal-title">Update Status Pesanan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select" required>
                            <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>
                                Menunggu Pembayaran
                            </option>
                            <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>
                                Diproses
                            </option>
                            <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>
                                Dikirim
                            </option>
                            <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>
                                Selesai
                            </option>
                            <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>
                                Dibatalkan
                            </option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
@media (max-width: 767.98px) {
    .progress-step {
        font-size: 0.75rem;
    }
}
</style>
@endpush
