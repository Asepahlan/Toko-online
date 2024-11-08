@extends('layouts.app')

@section('title', 'Bad Gateway - ' . config('app.name'))

@section('meta')
<meta name="description" content="Server sedang mengalami masalah. Silakan coba beberapa saat lagi.">
<meta name="robots" content="noindex, follow">
@endsection

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <div class="mb-4">
                <i class="fas fa-server fa-4x text-danger"></i>
            </div>
            <h1 class="display-4 mb-4">502</h1>
            <h2 class="h4 mb-4">Bad Gateway</h2>
            <p class="text-muted mb-5">
                Maaf, server sedang mengalami masalah.<br>
                Tim teknis kami sedang bekerja untuk menyelesaikan masalah ini.
            </p>
            <div class="d-flex justify-content-center gap-3">
                <button onclick="window.location.reload()" class="btn btn-outline-secondary">
                    <i class="fas fa-sync-alt me-2"></i>Muat Ulang
                </button>
                <a href="{{ route('home') }}" class="btn btn-primary">
                    <i class="fas fa-home me-2"></i>Ke Beranda
                </a>
            </div>

            <!-- Status Server -->
            <div class="mt-5">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="fas fa-info-circle text-primary me-2"></i>
                            Status Server
                        </h5>
                        <p class="card-text text-muted mb-4">
                            Server sedang dalam perbaikan. Silakan coba lagi dalam beberapa menit.
                            Anda juga bisa mengecek status layanan kami di:
                        </p>
                        <a href="#" class="btn btn-outline-primary">
                            <i class="fas fa-chart-line me-2"></i>Status Page
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
