@php
    use Illuminate\Support\Facades\Storage;
    use Illuminate\Support\Str;
@endphp

@extends('layouts.app')

@section('title', $product->name . ' - ' . config('app.name'))

@section('meta')
<meta name="description" content="{{ Str::limit($product->description, 160) }}">
<meta name="keywords" content="{{ $product->name }}, {{ $product->category->name }}, {{ config('app.name') }}">
@endsection

@section('content')
<div class="container py-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('products') }}">Produk</a></li>
            <li class="breadcrumb-item"><a href="{{ route('categories.show', $product->category) }}">{{ $product->category->name }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
        </ol>
    </nav>

    <div class="row">
        <!-- Product Image -->
        <div class="col-md-6 mb-4">
            <div class="card border-0 shadow-sm">
                @if($product->image)
                    <img src="{{ Storage::url($product->image) }}"
                         alt="{{ $product->name }}"
                         class="card-img-top product-image"
                         style="height: 400px; object-fit: cover;">
                @else
                    <div class="ratio ratio-1x1 bg-light">
                        <div class="d-flex align-items-center justify-content-center">
                            <i class="bi bi-image text-secondary" style="font-size: 4rem;"></i>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Product Info -->
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h1 class="h2 mb-2">{{ $product->name }}</h1>
                    <a href="{{ route('categories.show', $product->category) }}" class="text-decoration-none">
                        <span class="badge bg-primary mb-3">{{ $product->category->name }}</span>
                    </a>

                    <div class="mb-4">
                        <h2 class="h4 text-primary mb-3">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </h2>
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-box text-muted"></i>
                            @if($product->stock > 5)
                                <span class="text-success">Stok: {{ $product->stock }}</span>
                            @elseif($product->stock > 0)
                                <span class="text-warning">Stok Terbatas: {{ $product->stock }}</span>
                            @else
                                <span class="text-danger">Stok Habis</span>
                            @endif
                        </div>
                    </div>

                    <div class="mb-4">
                        <h3 class="h5 mb-3">Deskripsi</h3>
                        <p class="text-muted">{{ $product->description }}</p>
                    </div>

                    @if($product->stock > 0)
                        <form action="{{ route('cart.add', $product) }}" method="POST" class="d-grid gap-2">
                            @csrf
                            <div class="input-group mb-3">
                                <label class="input-group-text" for="quantity">Jumlah</label>
                                <input type="number"
                                       class="form-control"
                                       id="quantity"
                                       name="quantity"
                                       value="1"
                                       min="1"
                                       max="{{ $product->stock }}"
                                       required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-cart-plus me-2"></i>Tambah ke Keranjang
                            </button>
                        </form>
                    @else
                        <button class="btn btn-secondary btn-lg w-100" disabled>
                            <i class="bi bi-x-circle me-2"></i>Stok Habis
                        </button>
                    @endif
                </div>
            </div>

            <!-- Share Buttons -->
            <div class="card border-0 shadow-sm mt-4">
                <div class="card-body">
                    <h4 class="h6 mb-3">Bagikan Produk</h4>
                    <div class="d-flex gap-2">
                        <a href="https://wa.me/?text={{ urlencode($product->name . ' - ' . route('products.show', $product->slug)) }}"
                           class="btn btn-success"
                           target="_blank">
                            <i class="bi bi-whatsapp"></i>
                        </a>
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('products.show', $product->slug)) }}"
                           class="btn btn-primary"
                           target="_blank">
                            <i class="bi bi-facebook"></i>
                        </a>
                        <a href="https://twitter.com/intent/tweet?text={{ urlencode($product->name) }}&url={{ urlencode(route('products.show', $product->slug)) }}"
                           class="btn btn-info"
                           target="_blank">
                            <i class="bi bi-twitter"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Products -->
    @if($relatedProducts->isNotEmpty())
        <div class="mt-5">
            <h3 class="mb-4">Produk Terkait</h3>
            <div class="row g-4">
                @foreach($relatedProducts as $relatedProduct)
                    <div class="col-6 col-md-3">
                        <div class="card h-100 border-0 shadow-sm product-card">
                            <div class="position-relative">
                                @if($relatedProduct->image)
                                    <img src="{{ Storage::url($relatedProduct->image) }}"
                                         alt="{{ $relatedProduct->name }}"
                                         class="card-img-top"
                                         style="height: 200px; object-fit: cover;">
                                @else
                                    <div class="ratio ratio-1x1 bg-light">
                                        <div class="d-flex align-items-center justify-content-center">
                                            <i class="bi bi-image text-secondary" style="font-size: 3rem;"></i>
                                        </div>
                                    </div>
                                @endif

                                @if($relatedProduct->stock <= 5 && $relatedProduct->stock > 0)
                                    <div class="position-absolute top-0 start-0 p-2">
                                        <span class="badge bg-warning">Stok Terbatas</span>
                                    </div>
                                @elseif($relatedProduct->stock == 0)
                                    <div class="position-absolute top-0 start-0 p-2">
                                        <span class="badge bg-danger">Habis</span>
                                    </div>
                                @endif
                            </div>

                            <div class="card-body">
                                <h5 class="card-title">
                                    <a href="{{ route('products.show', $relatedProduct->slug) }}"
                                       class="text-decoration-none text-dark">
                                        {{ $relatedProduct->name }}
                                    </a>
                                </h5>
                                <p class="card-text text-muted small">{{ $relatedProduct->category->name }}</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-primary">
                                        Rp {{ number_format($relatedProduct->price, 0, ',', '.') }}
                                    </span>
                                    @if($relatedProduct->stock > 0)
                                        <form action="{{ route('cart.add', $relatedProduct) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-outline-primary btn-sm">
                                                <i class="bi bi-cart-plus"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection

@push('styles')
<style>
.product-card {
    transition: transform .2s;
}
.product-card:hover {
    transform: translateY(-5px);
}

.product-image {
    transition: transform .3s ease;
}
.product-image:hover {
    transform: scale(1.05);
}

@media (max-width: 767.98px) {
    .product-card .card-title {
        font-size: 1rem;
    }
}
</style>
@endpush
