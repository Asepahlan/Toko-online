<footer class="bg-light mt-5">
    <div class="container py-5">
        <div class="row g-4">
            <!-- Tentang -->
            <div class="col-lg-4">
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-primary rounded-circle p-2 me-2" style="width: 40px; height: 40px;">
                        <span class="fw-bold text-white d-flex align-items-center justify-content-center" style="font-size: 1.2rem;">
                            {{ strtoupper(substr(config('app.name'), 0, 2)) }}
                        </span>
                    </div>
                    <h5 class="mb-0">{{ config('app.name') }}</h5>
                </div>
                <p class="text-muted mb-4">
                    Toko online terpercaya dengan berbagai produk berkualitas untuk memenuhi kebutuhan Anda.
                </p>
                <div class="d-flex gap-3">
                    <a href="#" class="text-muted" title="Facebook">
                        <i class="bi bi-facebook fs-5"></i>
                    </a>
                    <a href="#" class="text-muted" title="Instagram">
                        <i class="bi bi-instagram fs-5"></i>
                    </a>
                    <a href="#" class="text-muted" title="Twitter">
                        <i class="bi bi-twitter fs-5"></i>
                    </a>
                </div>
            </div>

            <!-- Menu -->
            <div class="col-lg-2 col-md-4">
                <h6 class="mb-3">Menu</h6>
                <ul class="list-unstyled mb-0">
                    <li class="mb-2">
                        <a href="{{ route('products') }}" class="text-muted text-decoration-none">Produk</a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('categories.index') }}" class="text-muted text-decoration-none">Kategori</a>
                    </li>
                    @auth
                        <li class="mb-2">
                            <a href="{{ route('cart.index') }}" class="text-muted text-decoration-none">Keranjang</a>
                        </li>
                        <li class="mb-2">
                            <a href="{{ route('orders.index') }}" class="text-muted text-decoration-none">Pesanan</a>
                        </li>
                    @endauth
                </ul>
            </div>

            <!-- Kategori -->
            <div class="col-lg-2 col-md-4">
                <h6 class="mb-3">Kategori</h6>
                <ul class="list-unstyled mb-0">
                    @foreach(\App\Models\Category::take(5)->get() as $category)
                        <li class="mb-2">
                            <a href="{{ route('categories.show', $category->slug) }}"
                               class="text-muted text-decoration-none">
                                {{ $category->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Kontak -->
            <div class="col-lg-4 col-md-4">
                <h6 class="mb-3">Hubungi Kami</h6>
                <ul class="list-unstyled mb-0">
                    <li class="mb-2">
                        <a href="https://wa.me/6285215142110"
                           class="text-muted text-decoration-none d-flex align-items-center">
                            <i class="bi bi-whatsapp me-2"></i>
                            +62 852-1514-2110
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="mailto:info@example.com"
                           class="text-muted text-decoration-none d-flex align-items-center">
                            <i class="bi bi-envelope me-2"></i>
                            info@example.com
                        </a>
                    </li>
                    <li class="mb-2">
                        <span class="text-muted d-flex align-items-center">
                            <i class="bi bi-geo-alt me-2"></i>
                            Jl. Contoh No. 123, Kota, Indonesia
                        </span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Copyright -->
    <div class="border-top py-4">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start">
                    <small class="text-muted">
                        &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
                    </small>
                </div>
                <div class="col-md-6 text-center text-md-end mt-3 mt-md-0">
                    <div class="d-flex justify-content-center justify-content-md-end gap-3">
                        <a href="{{ route('privacy') }}" class="text-muted text-decoration-none">
                            <small>Kebijakan Privasi</small>
                        </a>
                        <a href="{{ route('terms') }}" class="text-muted text-decoration-none">
                            <small>Syarat & Ketentuan</small>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
