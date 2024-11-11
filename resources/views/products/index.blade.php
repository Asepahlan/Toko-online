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
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Filter</h5>
                </div>
                <div class="card-body">
                    <form id="filterForm" action="{{ route('products') }}" method="GET">
                        <!-- Pencarian -->
                        <div class="mb-3">
                            <label class="form-label">Cari Produk</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="search"
                                       value="{{ request('search') }}"
                                       placeholder="Nama produk...">
                                <button class="btn btn-primary" type="submit">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Kategori dengan dropdown -->
                        <div class="mb-3">
                            <label class="form-label">Kategori</label>
                            <div class="dropdown w-100">
                                <button class="btn btn-outline-secondary w-100 text-start d-flex justify-content-between align-items-center"
                                        type="button"
                                        data-bs-toggle="dropdown">
                                    <span>
                                        <i class="bi bi-tag-fill me-2"></i>
                                        Kategori:
                                        <span class="fw-medium">
                                            {{ request('category') ? ($categories->firstWhere('id', request('category'))->name ?? 'Semua') : 'Semua' }}
                                        </span>
                                    </span>
                                    <i class="bi bi-chevron-down"></i>
                                </button>
                                <ul class="dropdown-menu w-100">
                                    <li>
                                        <a href="{{ route('products', request()->except('category')) }}"
                                           class="dropdown-item {{ !request('category') ? 'active' : '' }}">
                                            <i class="bi bi-collection me-2"></i>
                                            Semua Kategori
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    @foreach($categories as $category)
                                        <li>
                                            <a href="{{ route('products', array_merge(request()->except('category'), ['category' => $category->id])) }}"
                                               class="dropdown-item {{ request('category') == $category->id ? 'active' : '' }}">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <span>
                                                        <i class="bi bi-{{ $category->icon ?? 'tag' }} me-2"></i>
                                                        {{ $category->name }}
                                                    </span>
                                                    <span class="badge bg-light text-dark">{{ $category->products_count }}</span>
                                                </div>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                        <!-- Rentang Harga -->
                        <div class="mb-3">
                            <label class="form-label">Rentang Harga</label>
                            <div class="row g-2">
                                <div class="col-6">
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number" class="form-control" name="min_price"
                                               value="{{ request('min_price') }}" placeholder="Min">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number" class="form-control" name="max_price"
                                               value="{{ request('max_price') }}" placeholder="Max">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Urutkan dengan dropdown -->
                        <div class="mb-3">
                            <label class="form-label">Urutkan</label>
                            <div class="dropdown w-100">
                                <button class="btn btn-outline-secondary w-100 text-start d-flex justify-content-between align-items-center"
                                        type="button"
                                        data-bs-toggle="dropdown">
                                    <span>
                                        <i class="bi bi-sort-down me-2"></i>
                                        Urutkan:
                                        <span class="fw-medium">
                                            @switch(request('sort', 'latest'))
                                                @case('oldest')
                                                    Terlama
                                                    @break
                                                @case('price_low')
                                                    Termurah
                                                    @break
                                                @case('price_high')
                                                    Termahal
                                                    @break
                                                @default
                                                    Terbaru
                                            @endswitch
                                        </span>
                                    </span>
                                    <i class="bi bi-chevron-down"></i>
                                </button>
                                <ul class="dropdown-menu w-100">
                                    <li>
                                        <a href="{{ route('products', array_merge(request()->except('sort'), ['sort' => 'latest'])) }}"
                                           class="dropdown-item {{ request('sort', 'latest') == 'latest' ? 'active' : '' }}">
                                            <i class="bi bi-arrow-down-circle me-2"></i>Terbaru
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('products', array_merge(request()->except('sort'), ['sort' => 'price_low'])) }}"
                                           class="dropdown-item {{ request('sort') == 'price_low' ? 'active' : '' }}">
                                            <i class="bi bi-sort-numeric-down me-2"></i>Termurah
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('products', array_merge(request()->except('sort'), ['sort' => 'price_high'])) }}"
                                           class="dropdown-item {{ request('sort') == 'price_high' ? 'active' : '' }}">
                                            <i class="bi bi-sort-numeric-up me-2"></i>Termahal
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <!-- Tombol Filter -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary flex-grow-1">
                                <i class="bi bi-funnel-fill me-1"></i> Terapkan Filter
                            </button>
                            <a href="{{ route('products') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-x-circle me-1"></i> Reset
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

/* Perbaikan tampilan filter */
.btn-check + .btn {
    padding: 0.25rem 0.75rem;
    font-size: 0.875rem;
    border-radius: 50px;
}

.btn-check:checked + .btn {
    font-weight: 500;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .d-flex.gap-2 {
        flex-wrap: wrap;
    }

    .btn-check + .btn {
        width: auto;
        min-width: 80px;
        margin-bottom: 0.25rem;
    }
}

/* Hover effects */
.btn-check + .btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.btn-check:checked + .btn {
    transform: translateY(1px);
    box-shadow: none;
}

/* Input number arrows */
input[type="number"]::-webkit-inner-spin-button,
input[type="number"]::-webkit-outer-spin-button {
    opacity: 1;
}

/* Styling untuk dropdown */
.dropdown-menu {
    border: 0;
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    padding: 0.5rem;
    border-radius: 0.5rem;
}

.dropdown-item {
    padding: 0.625rem 1rem;
    border-radius: 0.375rem;
    color: #4B5563;
    transition: all 0.2s;
}

.dropdown-item:hover {
    background-color: #F3F4F6;
    color: #1F2937;
    transform: translateX(4px);
}

.dropdown-item.active {
    background-color: #EBF5FF;
    color: #2563EB;
    font-weight: 500;
}

.dropdown-divider {
    margin: 0.5rem 0;
    opacity: 0.1;
}

/* Animasi untuk chevron */
.dropdown.show .bi-chevron-down {
    transform: rotate(180deg);
}

.bi-chevron-down {
    transition: transform 0.2s ease-in-out;
}

/* Button styles */
.btn-outline-secondary {
    border-color: #E5E7EB;
    color: #374151;
}

.btn-outline-secondary:hover {
    background-color: #F9FAFB;
    border-color: #D1D5DB;
}

/* Badge styles */
.badge {
    font-weight: 500;
    font-size: 0.75rem;
    padding: 0.25rem 0.75rem;
}

/* Input group styles */
.input-group .form-control {
    border-right: 0;
}

.input-group .btn {
    border-left: 0;
    background-color: #FFFFFF;
}

.input-group .btn:hover {
    background-color: #F9FAFB;
}

/* Hover transitions */
.dropdown-item, .btn {
    transition: all 0.2s ease-in-out;
}

/* Mobile optimizations */
@media (max-width: 768px) {
    .dropdown-item {
        padding: 0.5rem 0.75rem;
    }

    .badge {
        padding: 0.2rem 0.5rem;
    }
}

/* Styling untuk pills */
.btn-check + .btn {
    border-radius: 50px;
    font-size: 0.875rem;
    padding: 0.25rem 0.75rem;
}

.btn-check:checked + .btn-outline-primary {
    background-color: #0d6efd;
    color: white;
}

.btn-check:checked + .btn-outline-secondary {
    background-color: #6c757d;
    color: white;
}

/* Input styling */
.input-group-text {
    background-color: #f8f9fa;
    font-size: 0.875rem;
}

.form-control::placeholder {
    font-size: 0.875rem;
}

/* Scrollable categories if too many */
.d-flex.flex-wrap {
    max-height: 120px;
    overflow-y: auto;
    padding: 0.25rem;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .btn-check + .btn {
        font-size: 0.8125rem;
        padding: 0.2rem 0.5rem;
    }
}

/* Smooth scrollbar */
.d-flex.flex-wrap::-webkit-scrollbar {
    width: 4px;
}

.d-flex.flex-wrap::-webkit-scrollbar-track {
    background: #f1f1f1;
}

.d-flex.flex-wrap::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 4px;
}

.d-flex.flex-wrap::-webkit-scrollbar-thumb:hover {
    background: #555;
}

/* Styling untuk label */
.btn-sm {
    padding: 0.25rem 0.75rem;
    font-size: 0.875rem;
    border-radius: 50px;
    transition: all 0.2s;
}

.btn-sm:hover {
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.btn-sm.active {
    transform: translateY(1px);
    box-shadow: none;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .d-flex.gap-2 {
        flex-wrap: wrap;
    }

    .btn-sm {
        font-size: 0.8125rem;
        padding: 0.2rem 0.5rem;
    }
}

/* Warna dan tampilan tombol */
.btn-outline-primary:hover,
.btn-outline-secondary:hover {
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.btn-primary,
.btn-secondary {
    transform: translateY(1px);
    box-shadow: none;
}
</style>
@endpush

@push('scripts')
<script>
// Auto submit on radio change
document.querySelectorAll('input[type="radio"]').forEach(radio => {
    radio.addEventListener('change', function() {
        this.form.submit();
    });
});

// Format currency input
document.querySelectorAll('input[type="number"]').forEach(input => {
    input.addEventListener('input', function() {
        if (this.value < 0) this.value = 0;
    });
});
</script>
@endpush
