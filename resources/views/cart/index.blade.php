@php
    use Illuminate\Support\Facades\Storage;
@endphp

@extends('layouts.app')

@section('title', 'Keranjang Belanja - ' . config('app.name'))

@section('content')
<div class="container py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-2">Keranjang Belanja</h1>
            <p class="text-muted mb-0">{{ $cartItems->count() }} item dalam keranjang</p>
        </div>
        <a href="{{ route('products') }}" class="btn btn-outline-primary">
            <i class="bi bi-arrow-left me-2"></i>Lanjut Belanja
        </a>
    </div>

    @if($cartItems->isEmpty())
        <!-- Empty Cart -->
        <div class="text-center py-5">
            <div class="mb-4">
                <i class="bi bi-cart-x display-1 text-muted"></i>
            </div>
            <h3>Keranjang Belanja Kosong</h3>
            <p class="text-muted mb-4">Belum ada produk di keranjang belanja Anda</p>
            <a href="{{ route('products') }}" class="btn btn-primary">
                <i class="bi bi-cart-plus me-2"></i>Mulai Belanja
            </a>
        </div>
    @else
        <div class="row g-4">
            <div class="col-lg-8">
                <!-- Cart Items -->
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-borderless align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="ps-4 py-3">Produk</th>
                                        <th class="py-3" style="width: 120px">Harga</th>
                                        <th class="py-3" style="width: 150px">Jumlah</th>
                                        <th class="py-3" style="width: 120px">Subtotal</th>
                                        <th class="py-3" style="width: 50px"></th>
                                    </tr>
                                </thead>
                                <tbody class="border-top">
                                    @foreach($cartItems as $item)
                                        <tr>
                                            <!-- Product Info -->
                                            <td class="ps-4">
                                                <div class="d-flex align-items-center">
                                                    @if($item->product->image)
                                                        <img src="{{ Storage::url($item->product->image) }}"
                                                             alt="{{ $item->product->name }}"
                                                             class="rounded"
                                                             width="64"
                                                             height="64"
                                                             style="object-fit: cover;">
                                                    @else
                                                        <div class="bg-light rounded d-flex align-items-center justify-content-center"
                                                             style="width: 64px; height: 64px;">
                                                            <i class="bi bi-image text-secondary fs-4"></i>
                                                        </div>
                                                    @endif
                                                    <div class="ms-3">
                                                        <h6 class="mb-1">{{ $item->product->name }}</h6>
                                                        <span class="badge bg-info">{{ $item->product->category->name }}</span>
                                                    </div>
                                                </div>
                                            </td>

                                            <!-- Price -->
                                            <td>Rp {{ number_format($item->product->price, 0, ',', '.') }}</td>

                                            <!-- Quantity -->
                                            <td>
                                                <div class="input-group input-group-sm quantity-control">
                                                    <button type="button" class="btn btn-outline-secondary" onclick="updateQuantity({{ $item->product_id }}, -1)">
                                                        <i class="bi bi-dash"></i>
                                                    </button>
                                                    <input type="number"
                                                           class="form-control text-center"
                                                           value="{{ $item->quantity }}"
                                                           min="1"
                                                           onchange="updateQuantity({{ $item->product_id }}, this.value)">
                                                    <button type="button" class="btn btn-outline-secondary" onclick="updateQuantity({{ $item->product_id }}, 1)">
                                                        <i class="bi bi-plus"></i>
                                                    </button>
                                                </div>
                                            </td>

                                            <!-- Subtotal -->
                                            <td class="fw-bold text-primary">
                                                Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}
                                            </td>

                                            <!-- Remove Button -->
                                            <td>
                                                <form action="{{ route('cart.remove', $item->product_id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-link text-danger p-0" title="Hapus">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Total Belanja</h5>
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <span class="h4 mb-0">Total</span>
                            <span class="h4 mb-0 text-primary">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                        <form action="{{ route('cart.checkout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-cart-check me-2"></i>Buat Pesanan
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection

@push('styles')
<style>
.quantity-control {
    width: 120px;
}

.quantity-control input {
    text-align: center;
}

.quantity-control input::-webkit-outer-spin-button,
.quantity-control input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

.quantity-control input[type=number] {
    -moz-appearance: textfield;
}

.table th {
    font-size: 0.875rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.card {
    transition: all 0.3s ease;
}

.card:hover {
    transform: translateY(-5px);
}

@media (max-width: 767.98px) {
    .table th,
    .table td {
        font-size: 0.875rem;
    }

    .quantity-control {
        width: 100px;
    }
}
</style>
@endpush

@push('scripts')
<script>
function updateQuantity(productId, change) {
    let input = event.target.parentNode.querySelector('input');
    let currentValue = parseInt(input.value);
    let newValue;

    if (typeof change === 'number') {
        newValue = currentValue + change;
    } else {
        newValue = parseInt(change);
    }

    if (newValue < 1) newValue = 1;

    fetch(`/cart/${productId}`, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            quantity: newValue
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Gagal memperbarui jumlah');
            input.value = currentValue;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan');
        input.value = currentValue;
    });
}

// Konfirmasi hapus item
document.querySelectorAll('form[action*="cart/remove"]').forEach(form => {
    form.addEventListener('submit', function(e) {
        if (!confirm('Apakah Anda yakin ingin menghapus produk ini dari keranjang?')) {
            e.preventDefault();
        }
    });
});
</script>
@endpush
