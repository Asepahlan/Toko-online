@extends('layouts.app')

@section('title', 'Konten Tidak Tersedia - ' . config('app.name'))

@section('meta')
<meta name="description" content="Konten yang Anda cari telah dihapus secara permanen.">
<meta name="robots" content="noindex, follow">
@endsection

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <div class="mb-4">
                <i class="fas fa-trash-alt fa-4x text-danger"></i>
            </div>
            <h1 class="display-4 mb-4">410</h1>
            <h2 class="h4 mb-4">Konten Tidak Tersedia</h2>
            <p class="text-muted mb-5">
                Maaf, konten yang Anda cari telah dihapus secara permanen.<br>
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

            <!-- Saran -->
            <div class="mt-5">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="fas fa-lightbulb text-primary me-2"></i>
                            Saran
                        </h5>
                        <p class="card-text text-muted mb-4">
                            Konten ini mungkin telah:
                        </p>
                        <ul class="list-unstyled text-start text-muted">
                            <li><i class="fas fa-check me-2"></i>Dipindahkan ke lokasi baru</li>
                            <li><i class="fas fa-check me-2"></i>Diganti dengan konten yang lebih baru</li>
                            <li><i class="fas fa-check me-2"></i>Dihapus karena sudah tidak relevan</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
