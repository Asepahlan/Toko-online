@extends('layouts.app')

@section('title', 'Payload Terlalu Besar - ' . config('app.name'))

@section('meta')
<meta name="description" content="Ukuran data yang dikirim terlalu besar.">
<meta name="robots" content="noindex, follow">
@endsection

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <div class="mb-4">
                <i class="fas fa-file-upload fa-4x text-warning"></i>
            </div>
            <h1 class="display-4 mb-4">413</h1>
            <h2 class="h4 mb-4">Payload Terlalu Besar</h2>
            <p class="text-muted mb-5">
                Maaf, ukuran data yang Anda kirim terlalu besar.<br>
                Silakan kurangi ukuran file atau pisahkan menjadi beberapa bagian.
            </p>
            <div class="d-flex justify-content-center gap-3">
                <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
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
                            <p class="card-text text-muted mb-2">Beberapa hal yang bisa Anda lakukan:</p>
                            <ul class="text-muted mb-0">
                                <li>Kompres file sebelum mengunggah</li>
                                <li>Pisahkan file menjadi beberapa bagian</li>
                                <li>Kurangi resolusi gambar</li>
                                <li>Gunakan format file yang lebih efisien</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
