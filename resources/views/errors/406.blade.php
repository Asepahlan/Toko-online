@extends('layouts.app')

@section('title', 'Not Acceptable - ' . config('app.name'))

@section('meta')
<meta name="description" content="Format yang diminta tidak dapat diterima oleh server.">
<meta name="robots" content="noindex, follow">
@endsection

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <div class="mb-4">
                <i class="fas fa-file-alt fa-4x text-warning"></i>
            </div>
            <h1 class="display-4 mb-4">406</h1>
            <h2 class="h4 mb-4">Not Acceptable</h2>
            <p class="text-muted mb-5">
                Maaf, format yang Anda minta tidak dapat diterima oleh server.<br>
                Silakan coba dengan format yang berbeda.
            </p>
            <div class="d-flex justify-content-center gap-3">
                <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
                <a href="{{ route('home') }}" class="btn btn-primary">
                    <i class="fas fa-home me-2"></i>Ke Beranda
                </a>
            </div>

            <!-- Technical Info -->
            <div class="mt-5">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="fas fa-info-circle text-primary me-2"></i>
                            Informasi Teknis
                        </h5>
                        <p class="card-text text-muted">
                            Server tidak dapat menghasilkan konten yang sesuai dengan Accept headers yang dikirim
                            dalam permintaan. Pastikan format yang diminta didukung oleh server.
                        </p>
                        <div class="mt-3">
                            <code class="text-muted">
                                Accept: {{ request()->header('Accept') ?? '*/*' }}
                            </code>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
