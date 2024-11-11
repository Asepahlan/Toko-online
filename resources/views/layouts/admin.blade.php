<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') - {{ config('app.name') }}</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('storage/images/asep.png') }}" type="image/png">
    <link rel="shortcut icon" href="{{ asset('storage/images/asep.png') }}" type="image/png">
    <link rel="apple-touch-icon" href="{{ asset('storage/images/asep.png') }}">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <!-- Custom CSS -->
    <style>
        :root {
            --sidebar-width: 250px;
            --header-height: 60px;
            --primary-color: #2c3e50;
            --secondary-color: #34495e;
            --accent-color: #3498db;
        }

        body {
            min-height: 100vh;
            background-color: #f8f9fa;
            overflow-x: hidden;
        }

        /* Sidebar */
        #sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            background: var(--primary-color);
            transition: all 0.3s;
            z-index: 1000;
        }

        #sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 12px 20px;
            border-radius: 8px;
            margin: 4px 16px;
            transition: all 0.3s;
        }

        #sidebar .nav-link:hover {
            color: white;
            background: var(--secondary-color);
            transform: translateX(5px);
        }

        #sidebar .nav-link.active {
            color: white;
            background: var(--accent-color);
        }

        #sidebar .nav-link i {
            width: 24px;
            margin-right: 8px;
        }

        /* Main Content */
        #content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            transition: all 0.3s;
            padding: 20px;
        }

        /* Header */
        .content-header {
            margin-bottom: 24px;
        }

        /* Cards */
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
            transition: all 0.3s;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        /* Tables */
        .table > :not(caption) > * > * {
            padding: 1rem;
        }

        .table th {
            font-weight: 600;
            background-color: #f8f9fa;
            white-space: nowrap;
        }

        /* Forms */
        .form-control:focus,
        .form-select:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 0.25rem rgba(52, 152, 219, 0.25);
        }

        /* Buttons */
        .btn {
            padding: 8px 16px;
            border-radius: 8px;
        }

        .btn-primary {
            background-color: var(--accent-color);
            border-color: var(--accent-color);
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            #sidebar {
                margin-left: calc(-1 * var(--sidebar-width));
            }

            #sidebar.active {
                margin-left: 0;
            }

            #content {
                margin-left: 0;
                padding: 15px;
            }

            .table-responsive {
                margin: 0 -15px;
            }

            .card {
                margin-bottom: 15px;
            }

            .content-header {
                margin-bottom: 15px;
            }

            .btn {
                padding: 6px 12px;
            }
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: var(--secondary-color);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--primary-color);
        }

        /* Utilities */
        .text-truncate-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .bg-light-hover:hover {
            background-color: #f8f9fa;
        }

        /* Dropdown */
        .dropdown-menu {
            border: none;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .dropdown-item {
            padding: 8px 16px;
            transition: all 0.2s;
        }

        .dropdown-item:hover {
            background-color: #f8f9fa;
            transform: translateX(5px);
        }

        /* Overlay for mobile sidebar */
        .sidebar-overlay {
            display: none;
            position: fixed;
            width: 100vw;
            height: 100vh;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
            opacity: 0;
            transition: all 0.3s;
        }

        .sidebar-overlay.active {
            display: block;
            opacity: 1;
        }

        /* Table Styles */
        .table-responsive {
            border-radius: 0.5rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .table {
            margin-bottom: 0;
        }

        .table > :not(caption) > * > * {
            padding: 1rem;
            background-color: var(--bs-table-bg);
            border-bottom-width: 1px;
            box-shadow: inset 0 0 0 9999px var(--bs-table-accent-bg);
        }

        .table > thead {
            background-color: #f8f9fa;
        }

        .table > thead > tr > th {
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 0.75rem;
            color: #6c757d;
        }

        .table-hover tbody tr:hover {
            background-color: rgba(0, 0, 0, 0.02);
        }

        /* Status Badge */
        .badge {
            padding: 0.5em 1em;
            font-weight: 500;
            letter-spacing: 0.5px;
        }

        /* Search & Filter */
        .input-group-text {
            border: none;
            background-color: transparent;
        }

        .form-control,
        .form-select {
            border-radius: 0.5rem;
            padding: 0.75rem 1rem;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--bs-primary);
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.1);
        }

        /* Action Buttons */
        .btn-group {
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            border-radius: 0.5rem;
            overflow: hidden;
        }

        .btn-group .btn {
            border: none;
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
            transition: all 0.2s;
        }

        .btn-group .btn:hover {
            transform: translateY(-1px);
        }

        /* Responsive Adjustments */
        @media (max-width: 767.98px) {
            .table > :not(caption) > * > * {
                padding: 0.75rem;
            }

            .btn-group .btn {
                padding: 0.375rem 0.75rem;
            }

            .form-control,
            .form-select {
                padding: 0.5rem 0.75rem;
            }
        }

        /* Smooth transitions */
        .modal,
        .modal-backdrop,
        .fade,
        .collapse,
        .collapsing {
            transition: all 0.2s ease-in-out !important;
        }

        /* Prevent flickering on hover/active states */
        .btn,
        .nav-link,
        .dropdown-item,
        .form-control,
        .form-select {
            transition: all 0.2s ease-in-out !important;
            backface-visibility: hidden;
            transform: translateZ(0);
            -webkit-font-smoothing: subpixel-antialiased;
        }

        /* Prevent layout shifts */
        .modal-open {
            padding-right: 0 !important;
        }

        .modal {
            padding-right: 0 !important;
        }

        /* Smooth animations */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideIn {
            from { transform: translateY(-10px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        .animate-fade {
            animation: fadeIn 0.2s ease-in-out;
        }

        .animate-slide {
            animation: slideIn 0.2s ease-in-out;
        }

        /* Hardware acceleration */
        * {
            -webkit-transform: translate3d(0, 0, 0);
            transform: translate3d(0, 0, 0);
        }

        /* Prevent text flickering */
        body {
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* Stabilize layout */
        .container,
        .container-fluid {
            transform: translate3d(0, 0, 0);
            backface-visibility: hidden;
            perspective: 1000px;
        }

        /* Modal Fixes */
        .modal {
            background: rgba(0, 0, 0, 0.5);
        }

        .modal-backdrop {
            display: none !important;
        }

        .modal.show {
            display: block !important;
            padding-right: 0 !important;
        }

        body.modal-open {
            overflow: auto !important;
            padding-right: 0 !important;
        }

        /* Prevent modal from blocking clicks */
        .modal-dialog {
            pointer-events: auto;
        }

        .modal-content {
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }

        /* Smooth transitions */
        .modal.fade .modal-dialog {
            transition: transform 0.2s ease-out !important;
            transform: scale(0.95);
        }

        .modal.show .modal-dialog {
            transform: none;
        }

        /* Fix z-index issues */
        .modal {
            z-index: 1050 !important;
        }

        #sidebar {
            z-index: 1040 !important;
        }

        .sidebar-overlay {
            z-index: 1030 !important;
        }
    </style>

    @stack('styles')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
</head>
<body>
    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay"></div>

    <!-- Sidebar -->
    <nav id="sidebar">
        <div class="p-4">
            <!-- Logo -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <a href="{{ route('admin.dashboard') }}" class="text-white text-decoration-none">
                    <div class="d-flex align-items-center">
                        <div class="bg-white rounded-circle p-2 me-2" style="width: 40px; height: 40px;">
                            <span class="fw-bold text-primary d-flex align-items-center justify-content-center" style="font-size: 1.2rem;">
                                {{ strtoupper(substr(config('app.name'), 0, 2)) }}
                            </span>
                        </div>
                        <div>
                            <h4 class="mb-0">{{ config('app.name') }}</h4>
                            <small class="text-muted">Admin Panel</small>
                        </div>
                    </div>
                </a>
                <button class="btn btn-link text-white d-md-none" id="sidebarClose">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>

            <!-- Menu -->
            <div class="nav flex-column">
                <a href="{{ route('admin.dashboard') }}"
                   class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i>Dashboard
                </a>
                <a href="{{ route('admin.products.index') }}"
                   class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                    <i class="bi bi-box-seam"></i>Produk
                </a>
                <a href="{{ route('admin.categories.index') }}"
                   class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                    <i class="bi bi-tags"></i>Kategori
                </a>
                <a href="{{ route('admin.orders.index') }}"
                   class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                    <i class="bi bi-cart"></i>Pesanan
                </a>
                <a href="{{ route('admin.users.index') }}"
                   class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <i class="bi bi-people"></i>Pengguna
                </a>
            </div>

            <!-- User Profile -->
            <div class="mt-auto pt-4 border-top border-secondary">
                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
                        <div class="rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 32px; height: 32px; background-color: {{ '#' . substr(md5(auth()->user()->name), 0, 6) }};">
                            <span class="text-white fw-bold">
                                {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                            </span>
                        </div>
                        <div>
                            <strong>{{ auth()->user()->name }}</strong>
                            <small class="d-block text-muted">Administrator</small>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark">
                        <li>
                            <a class="dropdown-item" href="{{ route('home') }}">
                                <i class="bi bi-house me-2"></i>Halaman Utama
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="bi bi-box-arrow-right me-2"></i>Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <div id="content">
        <!-- Mobile Header -->
        <header class="d-md-none mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <button class="btn btn-link text-dark p-0" id="sidebarToggle">
                    <i class="bi bi-list fs-4"></i>
                </button>
                <h5 class="mb-0">{{ config('app.name') }}</h5>
                <div class="dropdown">
                    <button class="btn btn-link text-dark p-0" data-bs-toggle="dropdown">
                        <i class="bi bi-three-dots-vertical fs-4"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="{{ route('home') }}">
                                <i class="bi bi-house me-2"></i>Halaman Utama
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="bi bi-box-arrow-right me-2"></i>Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </header>

        <!-- Alerts -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Main Content -->
        @yield('content')

        <!-- Footer -->
        <footer class="mt-auto py-4">
            <div class="container-fluid">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
                    <div class="text-muted">
                        <small>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</small>
                    </div>
                    <div class="d-flex gap-3 mt-3 mt-md-0">
                        <a href="{{ route('home') }}" class="text-muted text-decoration-none">
                            <small>Halaman Utama</small>
                        </a>
                        <a href="https://wa.me/6285215142110" class="text-muted text-decoration-none" target="_blank">
                            <small>Bantuan</small>
                        </a>
                        <a href="mailto:support@example.com" class="text-muted text-decoration-none">
                            <small>Kontak</small>
                        </a>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Sidebar Toggle
        document.getElementById('sidebarToggle')?.addEventListener('click', function() {
            document.getElementById('sidebar').classList.add('active');
            document.querySelector('.sidebar-overlay').classList.add('active');
        });

        document.getElementById('sidebarClose')?.addEventListener('click', function() {
            document.getElementById('sidebar').classList.remove('active');
            document.querySelector('.sidebar-overlay').classList.remove('active');
        });

        document.querySelector('.sidebar-overlay')?.addEventListener('click', function() {
            document.getElementById('sidebar').classList.remove('active');
            this.classList.remove('active');
        });

        // Responsive Table
        const tables = document.querySelectorAll('.table');
        tables.forEach(table => {
            if (table.offsetWidth > table.parentElement.offsetWidth) {
                table.parentElement.classList.add('table-responsive');
            }
        });

        // Fix modal issues
        document.addEventListener('DOMContentLoaded', function() {
            const modals = document.querySelectorAll('.modal');

            modals.forEach(modal => {
                modal.addEventListener('show.bs.modal', function() {
                    document.body.style.overflow = 'hidden';
                });

                modal.addEventListener('hidden.bs.modal', function() {
                    document.body.style.overflow = '';
                    document.body.classList.remove('modal-open');
                    const backdrop = document.querySelector('.modal-backdrop');
                    if (backdrop) backdrop.remove();
                });

                // Prevent clicks inside modal from closing it
                modal.querySelector('.modal-content')?.addEventListener('click', function(e) {
                    e.stopPropagation();
                });
            });
        });

        // Close modal function
        function closeModal(modalId) {
            const modal = bootstrap.Modal.getInstance(document.getElementById(modalId));
            if (modal) {
                modal.hide();
                document.body.classList.remove('modal-open');
                const backdrop = document.querySelector('.modal-backdrop');
                if (backdrop) backdrop.remove();
            }
        }

        // Fungsi untuk menampilkan notifikasi
        function showNotification(type, message) {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });

            Toast.fire({
                icon: type,
                title: message
            });
        }

        // Fungsi untuk konfirmasi hapus
        function confirmDelete(title, text, callback) {
            Swal.fire({
                title: title,
                text: text,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    callback();
                }
            });
        }

        // Tampilkan notifikasi jika ada session flash
        @if(session('success'))
            showNotification('success', '{{ session('success') }}');
        @endif

        @if(session('error'))
            showNotification('error', '{{ session('error') }}');
        @endif

        @if(session('warning'))
            showNotification('warning', '{{ session('warning') }}');
        @endif
    </script>
    @stack('scripts')
</body>
</html>
