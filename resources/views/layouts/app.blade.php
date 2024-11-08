@php
    use Illuminate\Support\Facades\Request;
    use Illuminate\Support\Facades\Route;
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name'))</title>

    @yield('meta')

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('storage/images/asep.png') }}" type="image/png">
    <link rel="shortcut icon" href="{{ asset('storage/images/asep.png') }}" type="image/png">
    <link rel="apple-touch-icon" href="{{ asset('storage/images/asep.png') }}">

    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <!-- Custom CSS -->
    <style>
        /* Navbar */
        .navbar {
            backdrop-filter: blur(10px);
            background-color: rgba(255, 255, 255, 0.9) !important;
        }

        .navbar .nav-link {
            color: #333;
            font-weight: 500;
            padding: .5rem 1rem;
            border-radius: .25rem;
            transition: all .2s;
        }

        .navbar .nav-link:hover {
            background: rgba(13, 110, 253, .1);
            color: #0d6efd;
        }

        .navbar .nav-link.active {
            background: #0d6efd;
            color: white;
        }

        /* Card Hover Effect */
        .card-hover {
            transition: transform .2s, box-shadow .2s;
        }
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        ::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        /* Mobile Responsive */
        @media (max-width: 767.98px) {
            .navbar-brand img {
                height: 30px;
            }
            .navbar-brand span {
                font-size: .9rem;
            }
        }

        .hover-text-white:hover {
            color: white !important;
            transition: color 0.2s ease-in-out;
        }

        /* Pastikan footer selalu di bawah */
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        main {
            flex: 1 0 auto;
        }

        footer {
            flex-shrink: 0;
        }

        /* Animasi hover untuk link */
        .text-white-50 {
            transition: all 0.2s ease-in-out;
        }

        .text-white-50:hover {
            transform: translateX(5px);
        }

        /* SEO Schema */
        .schema-organization {
            display: none;
        }

        /* Custom Pagination Style */
        .pagination {
            --bs-pagination-padding-x: 0.5rem;
            --bs-pagination-padding-y: 0.25rem;
            --bs-pagination-font-size: 0.875rem;
            --bs-pagination-color: var(--bs-primary);
            --bs-pagination-bg: var(--bs-white);
            --bs-pagination-hover-color: var(--bs-white);
            --bs-pagination-hover-bg: var(--bs-primary);
            --bs-pagination-focus-color: var(--bs-primary);
            --bs-pagination-focus-bg: var(--bs-white);
            --bs-pagination-active-color: var(--bs-white);
            --bs-pagination-active-bg: var(--bs-primary);
            --bs-pagination-disabled-color: var(--bs-gray-400);
            --bs-pagination-disabled-bg: var(--bs-white);
            gap: 0.25rem;
        }

        .page-link {
            width: 28px;
            height: 28px;
            padding: 0 !important;
            border-radius: 4px !important;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 500;
            transition: all 0.2s ease-in-out;
            font-size: 0.8125rem;
        }

        .page-link:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .page-item.active .page-link {
            font-weight: 600;
        }

        .page-item.disabled .page-link {
            opacity: 0.5;
        }

        .page-link:focus {
            box-shadow: none;
        }

        .bi {
            font-size: 0.75rem;
        }

        @media (max-width: 575.98px) {
            .pagination {
                --bs-pagination-font-size: 0.75rem;
            }

            .page-link {
                width: 24px;
                height: 24px;
            }

            .bi {
                font-size: 0.7rem;
            }
        }
    </style>

    @stack('styles')
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
                <div class="bg-primary rounded-circle p-2 me-2" style="width: 40px; height: 40px;">
                    <span class="fw-bold text-white d-flex align-items-center justify-content-center" style="font-size: 1.2rem;">
                        {{ strtoupper(substr(config('app.name'), 0, 2)) }}
                    </span>
                </div>
                <span class="fw-bold">{{ config('app.name') }}</span>
            </a>

            <!-- Mobile Toggle -->
            <div class="d-flex align-items-center gap-3">
                @auth
                    <a href="{{ route('cart.index') }}" class="nav-link position-relative d-lg-none">
                        <i class="bi bi-cart3"></i>
                        @if($cartCount > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                {{ $cartCount }}
                            </span>
                        @endif
                    </a>
                @endauth
                <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>

            <!-- Menu -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item mx-2">
                        <a class="nav-link {{ request()->routeIs('products*') ? 'active' : '' }}"
                           href="{{ route('products') }}">
                            <i class="bi bi-box me-2"></i>Produk
                        </a>
                    </li>
                    <li class="nav-item mx-2">
                        <a class="nav-link {{ request()->routeIs('categories*') ? 'active' : '' }}"
                           href="{{ route('categories.index') }}">
                            <i class="bi bi-tags me-2"></i>Kategori
                        </a>
                    </li>
                </ul>

                <!-- Right Menu -->
                <ul class="navbar-nav">
                    @auth
                        <!-- Cart -->
                        <li class="nav-item d-none d-lg-block">
                            <a href="{{ route('cart.index') }}" class="nav-link position-relative">
                                <i class="bi bi-cart3"></i>
                                @if($cartCount > 0)
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                        {{ $cartCount }}
                                    </span>
                                @endif
                            </a>
                        </li>

                        <!-- User Menu -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle me-2"></i>
                                <span>{{ auth()->user()->name }}</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                @if(auth()->user()->role === 'admin')
                                    <li>
                                        <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                            <i class="bi bi-speedometer2 me-2"></i>Dashboard Admin
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                @endif
                                <li>
                                    <a class="dropdown-item" href="{{ route('orders.index') }}">
                                        <i class="bi bi-bag me-2"></i>Pesanan Saya
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                        <i class="bi bi-person me-2"></i>Profil
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="bi bi-box-arrow-right me-2"></i>Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a href="{{ route('login') }}" class="nav-link">Login</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('register') }}" class="btn btn-primary">Register</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <main class="min-vh-100">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-white mt-auto">
        <div class="container py-5">
            <div class="row g-4">
                <!-- Brand & Description -->
                <div class="col-lg-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-white rounded-circle p-2 me-2" style="width: 40px; height: 40px;">
                            <span class="fw-bold text-primary d-flex align-items-center justify-content-center" style="font-size: 1.2rem;">
                                {{ strtoupper(substr(config('app.name'), 0, 2)) }}
                            </span>
                        </div>
                        <h5 class="mb-0">{{ config('app.name') }}</h5>
                    </div>
                    <p class="text-white-50 mb-4">
                        {{ config('app.name') }} adalah toko online terpercaya yang menyediakan berbagai produk berkualitas dengan harga terbaik. Kami berkomitmen memberikan pelayanan terbaik untuk kepuasan pelanggan.
                    </p>
                    <div class="d-flex gap-3">
                        <a href="https://facebook.com/{{ config('app.name') }}"
                           class="text-white-50 hover-text-white"
                           target="_blank"
                           rel="noopener noreferrer"
                           aria-label="Facebook">
                            <i class="bi bi-facebook fs-5"></i>
                        </a>
                        <a href="https://instagram.com/{{ config('app.name') }}"
                           class="text-white-50 hover-text-white"
                           target="_blank"
                           rel="noopener noreferrer"
                           aria-label="Instagram">
                            <i class="bi bi-instagram fs-5"></i>
                        </a>
                        <a href="https://twitter.com/{{ config('app.name') }}"
                           class="text-white-50 hover-text-white"
                           target="_blank"
                           rel="noopener noreferrer"
                           aria-label="Twitter">
                            <i class="bi bi-twitter fs-5"></i>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="col-lg-2 col-md-4">
                    <h6 class="text-uppercase mb-3">Menu Utama</h6>
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2">
                            <a href="{{ route('home') }}"
                               class="text-white-50 text-decoration-none hover-text-white">
                                Beranda
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="{{ route('products') }}"
                               class="text-white-50 text-decoration-none hover-text-white">
                                Produk
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="{{ route('categories.index') }}"
                               class="text-white-50 text-decoration-none hover-text-white">
                                Kategori
                            </a>
                        </li>
                        @auth
                            <li class="mb-2">
                                <a href="{{ route('orders.index') }}"
                                   class="text-white-50 text-decoration-none hover-text-white">
                                    Pesanan Saya
                                </a>
                            </li>
                        @endauth
                    </ul>
                </div>

                <!-- Categories -->
                <div class="col-lg-2 col-md-4">
                    <h6 class="text-uppercase mb-3">Kategori Populer</h6>
                    <ul class="list-unstyled mb-0">
                        @foreach(\App\Models\Category::withCount('products')->orderBy('products_count', 'desc')->take(5)->get() as $category)
                            <li class="mb-2">
                                <a href="{{ route('categories.show', $category->slug) }}"
                                   class="text-white-50 text-decoration-none hover-text-white">
                                    {{ $category->name }}
                                    <span class="small">({{ $category->products_count }})</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Contact Info -->
                <div class="col-lg-4 col-md-4">
                    <h6 class="text-uppercase mb-3">Hubungi Kami</h6>
                    <ul class="list-unstyled mb-0">
                        <li class="mb-3">
                            <a href="https://wa.me/6285215142110"
                               class="text-white-50 text-decoration-none hover-text-white d-flex align-items-center"
                               target="_blank"
                               rel="noopener noreferrer">
                                <i class="bi bi-whatsapp me-2 fs-5"></i>
                                <div>
                                    <div>WhatsApp</div>
                                    <small>+62 852-1514-2110</small>
                                </div>
                            </a>
                        </li>
                        <li class="mb-3">
                            <a href="mailto:info@example.com"
                               class="text-white-50 text-decoration-none hover-text-white d-flex align-items-center">
                                <i class="bi bi-envelope me-2 fs-5"></i>
                                <div>
                                    <div>Email</div>
                                    <small>info@example.com</small>
                                </div>
                            </a>
                        </li>
                        <li>
                            <div class="text-white-50 d-flex align-items-center">
                                <i class="bi bi-geo-alt me-2 fs-5"></i>
                                <div>
                                    <div>Alamat</div>
                                    <small>Jl. Contoh No. 123, Kota, Indonesia</small>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Bottom Footer -->
        <div class="py-4 border-top border-secondary">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6 text-center text-md-start">
                        <p class="text-white-50 mb-0 small">
                            &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
                        </p>
                    </div>
                    <div class="col-md-6 text-center text-md-end mt-3 mt-md-0">
                        <div class="d-flex justify-content-center justify-content-md-end gap-3">
                            <a href="#"
                               class="text-white-50 text-decoration-none small hover-text-white">
                                Kebijakan Privasi
                            </a>
                            <a href="#"
                               class="text-white-50 text-decoration-none small hover-text-white">
                                Syarat & Ketentuan
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')

    <!-- Schema.org untuk SEO -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Organization",
        "name": "{{ config('app.name') }}",
        "description": "Toko online terpercaya yang menyediakan berbagai produk berkualitas dengan harga terbaik",
        "url": "{{ url('/') }}",
        "logo": "{{ asset('images/logo.png') }}",
        "contactPoint": {
            "@type": "ContactPoint",
            "telephone": "+62-852-1514-2110",
            "contactType": "customer service",
            "email": "info@example.com",
            "areaServed": "ID",
            "availableLanguage": ["id", "en"]
        },
        "address": {
            "@type": "PostalAddress",
            "streetAddress": "Jl. Contoh No. 123",
            "addressLocality": "Kota",
            "addressRegion": "Jawa Barat",
            "postalCode": "12345",
            "addressCountry": "ID"
        },
        "sameAs": [
            "https://facebook.com/{{ config('app.name') }}",
            "https://twitter.com/{{ config('app.name') }}",
            "https://instagram.com/{{ config('app.name') }}"
        ]
    }
    </script>
</body>
</html>
