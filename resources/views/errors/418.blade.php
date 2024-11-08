@extends('layouts.app')

@section('title', 'I\'m a teapot - ' . config('app.name'))

@section('meta')
<meta name="description" content="Error 418 - I'm a teapot. Halaman ini tidak dapat memproses permintaan Anda.">
<meta name="robots" content="noindex, follow">
@endsection

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <div class="mb-4">
                <i class="fas fa-coffee fa-4x text-warning"></i>
            </div>
            <h1 class="display-4 mb-4">418</h1>
            <h2 class="h4 mb-4">I'm a teapot</h2>
            <p class="text-muted mb-5">
                Maaf, server ini adalah teko dan menolak mencoba membuat kopi.<br>
                <small>(Ini adalah lelucon April Mop yang menjadi standar HTTP)</small>
            </p>
            <div class="d-flex justify-content-center gap-3">
                <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
                <a href="{{ route('home') }}" class="btn btn-primary">
                    <i class="fas fa-home me-2"></i>Ke Beranda
                </a>
            </div>

            <!-- Fun Section -->
            <div class="mt-5">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="fas fa-info-circle text-primary me-2"></i>
                            Tahukah Anda?
                        </h5>
                        <p class="card-text text-muted">
                            Error 418 adalah referensi ke "Hyper Text Coffee Pot Control Protocol" (HTCPCP),
                            yang merupakan ekstensi lelucon dari HTTP yang dibuat untuk April Mop tahun 1998.
                        </p>
                        <div class="mt-3">
                            <i class="fas fa-mug-hot fa-2x text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
