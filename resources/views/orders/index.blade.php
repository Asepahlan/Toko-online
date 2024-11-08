@php
    use Illuminate\Support\Facades\Auth;
@endphp

@extends('layouts.app')

@section('title', 'Daftar Pesanan - ' . config('app.name'))

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <h2 class="mb-4">Daftar Pesanan</h2>

            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>No. Invoice</th>
                                    @if(Auth::user()->role === 'admin')
                                        <th>Pelanggan</th>
                                    @endif
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($orders as $order)
                                    <tr>
                                        <td>{{ $order->invoice_number }}</td>
                                        @if(Auth::user()->role === 'admin')
                                            <td>{{ $order->user->name }}</td>
                                        @endif
                                        <td>Rp {{ number_format($order->total_amount) }}</td>
                                        <td>
                                            <span class="badge bg-{{ $order->status_color }}">
                                                {{ $order->status_label }}
                                            </span>
                                        </td>
                                        <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('orders.track', $order) }}"
                                                   class="btn btn-sm btn-primary">
                                                    <i class="bi bi-truck me-1"></i>Lacak
                                                </a>
                                                @if(Auth::user()->role === 'admin')
                                                    <button type="button"
                                                            class="btn btn-sm btn-success"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#updateStatusModal{{ $order->id }}">
                                                        <i class="bi bi-pencil me-1"></i>Update
                                                    </button>
                                                @endif
                                            </div>

                                            @if(Auth::user()->role === 'admin')
                                                <!-- Update Status Modal -->
                                                <div class="modal fade" id="updateStatusModal{{ $order->id }}" tabindex="-1">
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
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="{{ Auth::user()->role === 'admin' ? 6 : 5 }}" class="text-center py-4">
                                            <div class="text-muted">
                                                <i class="bi bi-inbox display-1 mb-3"></i>
                                                <p>Belum ada pesanan</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center mt-4">
                        {{ $orders->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
