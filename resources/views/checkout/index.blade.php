@extends('layouts.app')

@section('title', 'Checkout - ' . config('app.name'))

@section('meta')
<meta name="description" content="Checkout dan selesaikan pembelian Anda di {{ config('app.name') }}">
<meta name="robots" content="noindex, nofollow">
@endsection

@section('content')
<div class="container py-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
            <li class="breadcrumb-item"><a href="{{ route('cart.index') }}">Keranjang</a></li>
            <li class="breadcrumb-item active" aria-current="page">Checkout</li>
        </ol>
    </nav>

    <div class="row">
        <!-- Form Checkout -->
        <div class="col-lg-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h1 class="h5 mb-0">Informasi Pengiriman</h1>
                </div>
                <div class="card-body">
                    <form action="{{ route('checkout.process') }}" method="POST" id="checkoutForm">
                        @csrf
                        <div class="mb-4">
                            <label for="name" class="form-label">Nama Lengkap</label>
                            <input type="text"
                                   class="form-control @error('name') is-invalid @enderror"
                                   id="name"
                                   name="name"
                                   value="{{ old('name', auth()->user()->name) }}"
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="phone" class="form-label">Nomor Telepon</label>
                            <input type="tel"
                                   class="form-control @error('phone') is-invalid @enderror"
                                   id="phone"
                                   name="phone"
                                   value="{{ old('phone', auth()->user()->phone) }}"
                                   required>
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="shipping_address" class="form-label">Alamat Pengiriman</label>
                            <textarea class="form-control @error('shipping_address') is-invalid @enderror"
                                      id="shipping_address"
                                      name="shipping_address"
                                      rows="3"
                                      required>{{ old('shipping_address', auth()->user()->address) }}</textarea>
                            @error('shipping_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="notes" class="form-label">Catatan (Opsional)</label>
                            <textarea class="form-control"
                                      id="notes"
                                      name="notes"
                                      rows="2">{{ old('notes') }}</textarea>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Metode Pembayaran -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h2 class="h5 mb-0">Metode Pembayaran</h2>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        Pembayaran akan dilakukan melalui WhatsApp setelah order dikonfirmasi
                    </div>
                    <div class="d-flex flex-wrap gap-3">
                        <img src="{{ asset('images/payments/bca.png') }}" alt="BCA" height="30">
                        <img src="{{ asset('images/payments/mandiri.png') }}" alt="Mandiri" height="30">
                        <img src="{{ asset('images/payments/bni.png') }}" alt="BNI" height="30">
                    </div>
                </div>
            </div>
        </div>

        <!-- Ringkasan Order -->
        <div class="col-lg-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h2 class="h5 mb-0">Ringkasan Order</h2>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-borderless">
                            <tbody>
                                @foreach($cartItems as $item)
                                    <tr>
                                        <td class="text-muted">
                                            {{ $item->product->name }}
                                            <br>
                                            <small>{{ $item->quantity }}x @ Rp {{ number_format($item->product->price) }}</small>
                                        </td>
                                        <td class="text-end">
                                            Rp {{ number_format($item->product->price * $item->quantity) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="border-top">
                                <tr>
                                    <th>Total</th>
                                    <th class="text-end">Rp {{ number_format($total) }}</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <button type="submit"
                            form="checkoutForm"
                            class="btn btn-primary w-100">
                        <i class="fab fa-whatsapp me-2"></i>
                        Pesan via WhatsApp
                    </button>
                </div>
            </div>

            <!-- Informasi Keamanan -->
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <i class="fas fa-shield-alt text-success fa-2x me-3"></i>
                        <div>
                            <h6 class="mb-1">Transaksi Aman</h6>
                            <small class="text-muted">Data Anda dilindungi dan dienkripsi</small>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <i class="fas fa-lock text-success fa-2x me-3"></i>
                        <div>
                            <h6 class="mb-1">Pembayaran Terpercaya</h6>
                            <small class="text-muted">Pembayaran melalui bank terpercaya</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "BreadcrumbList",
    "itemListElement": [{
        "@type": "ListItem",
        "position": 1,
        "name": "Beranda",
        "item": "{{ route('home') }}"
    },{
        "@type": "ListItem",
        "position": 2,
        "name": "Keranjang",
        "item": "{{ route('cart.index') }}"
    },{
        "@type": "ListItem",
        "position": 3,
        "name": "Checkout"
    }]
}
</script>
@endpush
@endsection
