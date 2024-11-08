@extends('layouts.app')

@section('title', 'Metode Tidak Diizinkan - ' . config('app.name'))

@section('meta')
<meta name="description" content="Metode HTTP yang Anda gunakan tidak diizinkan di {{ config('app.name') }}">
<meta name="robots" content="noindex, follow">
@endsection

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <div class="mb-4">
                <i class="fas fa-ban fa-4x text-danger"></i>
            </div>
            <h1 class="display-4 mb-4">405</h1>
            <h2 class="h4 mb-4">Metode Tidak Diizinkan</h2>
            <p class="text-muted mb-5">
                Maaf, metode HTTP yang Anda gunakan tidak diizinkan untuk halaman ini.<br>
                Silakan kembali ke halaman sebelumnya.
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
                            Jika Anda adalah developer, pastikan metode HTTP yang digunakan sesuai dengan endpoint yang dituju.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
