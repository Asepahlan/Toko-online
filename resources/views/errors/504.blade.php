@extends('layouts.app')

@section('title', 'Gateway Timeout - ' . config('app.name'))

@section('meta')
<meta name="description" content="Server tidak merespons dalam waktu yang ditentukan. Silakan coba beberapa saat lagi.">
<meta name="robots" content="noindex, follow">
@endsection

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <div class="mb-4">
                <i class="fas fa-clock fa-4x text-warning"></i>
            </div>
            <h1 class="display-4 mb-4">504</h1>
            <h2 class="h4 mb-4">Gateway Timeout</h2>
            <p class="text-muted mb-5">
                Maaf, server tidak merespons dalam waktu yang ditentukan.<br>
                Silakan coba lagi dalam beberapa saat.
            </p>
            <div class="d-flex justify-content-center gap-3">
                <button onclick="window.location.reload()" class="btn btn-outline-secondary">
                    <i class="fas fa-sync-alt me-2"></i>Muat Ulang
                </button>
                <a href="{{ route('home') }}" class="btn btn-primary">
                    <i class="fas fa-home me-2"></i>Ke Beranda
                </a>
            </div>

            <!-- Bantuan -->
            <div class="mt-5">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="fas fa-question-circle text-primary me-2"></i>
                            Butuh Bantuan?
                        </h5>
                        <p class="card-text text-muted mb-4">
                            Jika masalah berlanjut, silakan hubungi tim support kami:
                        </p>
                        <div class="d-flex justify-content-center gap-3">
                            <a href="mailto:support@example.com" class="btn btn-outline-primary">
                                <i class="fas fa-envelope me-2"></i>Email Support
                            </a>
                            <a href="tel:628776275" class="btn btn-outline-success">
                                <i class="fas fa-phone me-2"></i>Hubungi Kami
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
