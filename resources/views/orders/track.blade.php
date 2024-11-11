@php
    use Illuminate\Support\Facades\Storage;
@endphp

@extends('layouts.app')

@section('title', 'Lacak Pesanan - ' . config('app.name'))

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Back Button -->
            <div class="mb-4">
                <a href="{{ route('orders.index') }}" class="text-decoration-none">
                    <i class="bi bi-arrow-left"></i> Kembali ke Daftar Pesanan
                </a>
            </div>

            <!-- Order Status -->
            <div class="card border-0 shadow-sm mb-4">
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
                                <small>Silakan lakukan pembayaran sebelum {{ $order->created_at->addDays(1)->format('d/m/Y H:i') }}</small>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Details -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Detail Pesanan</h5>
                        <span class="badge bg-primary">{{ $order->invoice_number }}</span>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Customer Info -->
                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <div class="p-3 bg-light rounded">
                                <h6 class="mb-3">Informasi Pengiriman</h6>
                                <p class="mb-1"><strong>{{ $order->user->name }}</strong></p>
                                <p class="mb-1">{{ $order->shipping_address }}</p>
                                <p class="mb-0">{{ $order->contact_number }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 bg-light rounded">
                                <h6 class="mb-3">Informasi Pesanan</h6>
                                <p class="mb-1">Tanggal: {{ $order->created_at->format('d/m/Y H:i') }}</p>
                                <p class="mb-1">Status: <span class="badge bg-{{ $order->status_color }}">{{ $order->status_label }}</span></p>
                                @if($order->notes)
                                    <p class="mb-0">Catatan: {{ $order->notes }}</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Order Items -->
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Produk</th>
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
                                                    <small class="text-muted">{{ $item->quantity }}x @ Rp {{ number_format($item->price) }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-end">
                                            <span class="fw-medium">Rp {{ number_format($item->price * $item->quantity) }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="table-light">
                                <tr>
                                    <td class="text-end"><strong>Total</strong></td>
                                    <td class="text-end">
                                        <strong class="text-primary">Rp {{ number_format($order->total_amount) }}</strong>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('orders.index') }}" class="btn btn-outline-primary">
                    <i class="bi bi-arrow-left me-2"></i>Kembali
                </a>
                @if($order->status === 'pending')
                    <a
                        href="https://wa.me/{{ $whatsappNumber }}?text={{ urlencode($message) }}"
                        class="btn btn-success"
                    >
                        <i class="fab fa-whatsapp"></i> Konfirmasi via WhatsApp
                    </a>
                @endif
            </div>
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
