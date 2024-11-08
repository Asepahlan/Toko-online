@extends('layouts.app')

@section('title', 'Request Timeout - ' . config('app.name'))

@section('meta')
<meta name="description" content="Permintaan membutuhkan waktu terlalu lama untuk diproses. Silakan coba lagi.">
<meta name="robots" content="noindex, follow">
@endsection

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <div class="mb-4">
                <i class="fas fa-hourglass-end fa-4x text-warning"></i>
            </div>
            <h1 class="display-4 mb-4">408</h1>
            <h2 class="h4 mb-4">Request Timeout</h2>
            <p class="text-muted mb-5">
                Maaf, permintaan Anda membutuhkan waktu terlalu lama untuk diproses.<br>
                Silakan coba lagi dengan koneksi yang lebih stabil.
            </p>
            <div class="d-flex justify-content-center gap-3">
                <button onclick="window.location.reload()" class="btn btn-outline-secondary">
                    <i class="fas fa-sync-alt me-2"></i>Coba Lagi
                </button>
                <a href="{{ route('home') }}" class="btn btn-primary">
                    <i class="fas fa-home me-2"></i>Ke Beranda
                </a>
            </div>

            <!-- Tips -->
            <div class="mt-5">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="fas fa-lightbulb text-primary me-2"></i>
                            Tips
                        </h5>
                        <div class="text-start">
                            <p class="card-text text-muted mb-2">Beberapa hal yang bisa Anda coba:</p>
                            <ul class="text-muted mb-0">
                                <li>Periksa koneksi internet Anda</li>
                                <li>Gunakan koneksi yang lebih stabil</li>
                                <li>Coba akses beberapa saat lagi</li>
                                <li>Bersihkan cache browser</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
