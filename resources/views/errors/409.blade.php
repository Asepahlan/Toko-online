@extends('layouts.app')

@section('title', 'Konflik - ' . config('app.name'))

@section('meta')
<meta name="description" content="Terjadi konflik saat memproses permintaan Anda.">
<meta name="robots" content="noindex, follow">
@endsection

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <div class="mb-4">
                <i class="fas fa-random fa-4x text-warning"></i>
            </div>
            <h1 class="display-4 mb-4">409</h1>
            <h2 class="h4 mb-4">Konflik</h2>
            <p class="text-muted mb-5">
                Maaf, terjadi konflik saat memproses permintaan Anda.<br>
                Silakan coba lagi atau hubungi administrator.
            </p>
            <div class="d-flex justify-content-center gap-3">
                <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
                <a href="{{ route('home') }}" class="btn btn-primary">
                    <i class="fas fa-home me-2"></i>Ke Beranda
                </a>
            </div>

            <!-- Informasi Teknis -->
            <div class="mt-5">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="fas fa-info-circle text-primary me-2"></i>
                            Informasi Teknis
                        </h5>
                        <p class="card-text text-muted">
                            Permintaan Anda bertentangan dengan status sumber daya saat ini.
                            Hal ini mungkin terjadi karena perubahan bersamaan pada sumber daya yang sama.
                        </p>
                        <div class="mt-4">
                            <a href="#" class="btn btn-outline-primary" onclick="window.location.reload()">
                                <i class="fas fa-sync-alt me-2"></i>Muat Ulang Halaman
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
