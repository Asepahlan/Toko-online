@php
    use Illuminate\Support\Facades\Storage;
    use Illuminate\Support\Str;
@endphp

@extends('layouts.app')

@section('title', 'Produk - ' . config('app.name'))

@section('meta')
<meta name="description" content="Jelajahi koleksi produk terbaik di {{ config('app.name') }}. Temukan berbagai produk berkualitas dengan harga terbaik.">
<meta name="keywords" content="produk, belanja online, {{ config('app.name') }}">
@endsection

@section('content')
<div class="container py-4">
    <div class="row">
        <!-- Sidebar Filter -->
        <div class="col-lg-3 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-4">Filter</h5>
                    <form action="{{ route('products') }}" method="GET">
                        <!-- Search -->
                        <div class="mb-4">
                            <label class="form-label">Cari Produk</label>
                            <div class="input-group">
                                <input type="text"
                                       name="search"
                                       class="form-control"
                                       placeholder="Nama produk..."
                                       value="{{ request('search') }}">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Kategori -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Kategori</label>
                            @foreach($categories as $category)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox"
                                           name="categories[]"
                                           value="{{ $category->id }}"
                                           id="category{{ $category->id }}"
                                           {{ in_array($category->id, request('categories', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="category{{ $category->id }}">
                                        {{ $category->name }}
                                        <span class="badge bg-light text-dark">{{ $category->products_count }}</span>
                                    </label>
                                </div>
                            @endforeach
                        </div>

                        <!-- Harga -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Rentang Harga</label>
                            <div class="row g-2">
                                <div class="col">
                                    <input type="number"
                                           class="form-control"
                                           name="min_price"
                                           placeholder="Min"
                                           value="{{ request('min_price') }}">
                                </div>
                                <div class="col">
                                    <input type="number"
                                           class="form-control"
                                           name="max_price"
                                           placeholder="Max"
                                           value="{{ request('max_price') }}">
                                </div>
                            </div>
                        </div>

                        <!-- Sort -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Urutkan</label>
                            <select name="sort" class="form-select">
                                <option value="latest" {{ request('sort') === 'latest' ? 'selected' : '' }}>Terbaru</option>
                                <option value="price_low" {{ request('sort') === 'price_low' ? 'selected' : '' }}>Harga Terendah</option>
                                <option value="price_high" {{ request('sort') === 'price_high' ? 'selected' : '' }}>Harga Tertinggi</option>
                                <option value="name_asc" {{ request('sort') === 'name_asc' ? 'selected' : '' }}>Nama A-Z</option>
                                <option value="name_desc" {{ request('sort') === 'name_desc' ? 'selected' : '' }}>Nama Z-A</option>
                            </select>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-funnel me-2"></i>Terapkan Filter
                            </button>
                            <a href="{{ route('products') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-x-circle me-2"></i>Reset Filter
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Product Grid -->
        <div class="col-lg-9">
            @if($products->isEmpty())
                <div class="text-center py-5">
                    <i class="bi bi-box-seam display-1 text-muted mb-3"></i>
                    <h3>Tidak ada produk yang ditemukan</h3>
                    <p class="text-muted">Coba ubah filter pencarian Anda</p>
                </div>
            @else
                <!-- Product Count & Sort (Mobile) -->
                <div class="d-lg-none mb-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted">{{ $products->total() }} Produk</span>
                        <button class="btn btn-outline-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#filterOffcanvas">
                            <i class="bi bi-funnel me-2"></i>Filter
                        </button>
                    </div>
                </div>

                <div class="row g-4">
                    @foreach($products as $product)
                        <div class="col-6 col-md-4">
                            <div class="card h-100 border-0 shadow-sm product-card">
                                <div class="position-relative">
                                    @if($product->image)
                                        <img src="{{ Storage::url($product->image) }}"
                                             alt="{{ $product->name }}"
                                             class="card-img-top"
                                             style="height: 200px; object-fit: cover;">
                                    @else
                                        <div class="ratio ratio-1x1 bg-light">
                                            <div class="d-flex align-items-center justify-content-center">
                                                <i class="bi bi-image text-secondary" style="font-size: 3rem;"></i>
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Product Labels -->
                                    <div class="position-absolute top-0 start-0 p-2">
                                        @if($product->stock <= 5 && $product->stock > 0)
                                            <span class="badge bg-warning">Stok Terbatas</span>
                                        @elseif($product->stock == 0)
                                            <span class="badge bg-danger">Habis</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="card-body">
                                    <a href="{{ route('products.show', $product->slug) }}" class="text-decoration-none">
                                        <h5 class="card-title text-dark">{{ $product->name }}</h5>
                                    </a>
                                    <p class="card-text text-muted small">{{ $product->category->name }}</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="h5 mb-0 text-primary">
                                            Rp {{ number_format($product->price, 0, ',', '.') }}
                                        </span>
                                        @if($product->stock > 0)
                                            <form action="{{ route('cart.add', $product) }}" method="POST">
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

                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div class="text-muted small">
                        Menampilkan {{ $products->firstItem() ?? 0 }} sampai {{ $products->lastItem() ?? 0 }}
                        dari {{ $products->total() }} produk
                    </div>
                    {{ $products->withQueryString()->links('vendor.pagination.bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Filter Offcanvas (Mobile) -->
<div class="offcanvas offcanvas-start" tabindex="-1" id="filterOffcanvas">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title">Filter Produk</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body">
        <!-- Copy the filter form from sidebar here -->
    </div>
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

@media (max-width: 767.98px) {
    .product-card .card-title {
        font-size: 1rem;
    }
    .product-card .h5 {
        font-size: 1rem;
    }
}
</style>
@endpush
