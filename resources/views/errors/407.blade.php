@extends('layouts.app')

@section('title', 'Proxy Authentication Required - ' . config('app.name'))

@section('meta')
<meta name="description" content="Autentikasi proxy diperlukan untuk mengakses halaman ini.">
<meta name="robots" content="noindex, follow">
@endsection

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <div class="mb-4">
                <i class="fas fa-shield-alt fa-4x text-warning"></i>
            </div>
            <h1 class="display-4 mb-4">407</h1>
            <h2 class="h4 mb-4">Proxy Authentication Required</h2>
            <p class="text-muted mb-5">
                Maaf, Anda harus mengautentikasi diri dengan proxy server terlebih dahulu.<br>
                Silakan hubungi administrator jaringan Anda.
            </p>
            <div class="d-flex justify-content-center gap-3">
                <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
                <a href="{{ route('home') }}" class="btn btn-primary">
                    <i class="fas fa-home me-2"></i>Ke Beranda
                </a>
            </div>

            <!-- Help Section -->
            <div class="mt-5">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="fas fa-question-circle text-primary me-2"></i>
                            Butuh Bantuan?
                        </h5>
                        <p class="card-text text-muted mb-4">
                            Jika Anda mengalami masalah dengan autentikasi proxy, silakan:
                        </p>
                        <ul class="list-unstyled text-start text-muted">
                            <li><i class="fas fa-check me-2"></i>Periksa pengaturan proxy browser Anda</li>
                            <li><i class="fas fa-check me-2"></i>Pastikan kredensial proxy Anda benar</li>
                            <li><i class="fas fa-check me-2"></i>Hubungi administrator jaringan</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
