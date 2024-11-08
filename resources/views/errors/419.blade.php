@extends('layouts.app')

@section('title', 'Sesi Berakhir - ' . config('app.name'))

@section('content')
<div class="container py-5">
    <div class="row justify-content-center text-center">
        <div class="col-lg-6">
            <div class="error-content">
                <!-- Error Illustration -->
                <div class="mb-4">
                    <i class="bi bi-clock-history display-1 text-danger"></i>
                </div>

                <!-- Error Message -->
                <h1 class="display-4 mb-3">419</h1>
                <h2 class="h4 mb-4">Sesi Telah Berakhir</h2>
                <p class="text-muted mb-4">
                    Maaf, sesi Anda telah berakhir. Silakan muat ulang halaman dan coba lagi.
                </p>

                <!-- Action Buttons -->
                <div class="d-flex justify-content-center gap-3">
                    <a href="{{ url()->previous() }}" class="btn btn-outline-primary">
                        <i class="bi bi-arrow-left me-2"></i>Kembali
                    </a>
                    <button type="button" class="btn btn-primary" onclick="window.location.reload()">
                        <i class="bi bi-arrow-clockwise me-2"></i>Muat Ulang
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.error-content {
    animation: fadeInUp .5s ease;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>
@endpush
@endsection
