@extends('layouts.app')

@section('title', 'Terlalu Banyak Permintaan - ' . config('app.name'))

@section('content')
<div class="container py-5">
    <div class="row justify-content-center text-center">
        <div class="col-lg-6">
            <div class="error-content">
                <!-- Error Illustration -->
                <div class="mb-4">
                    <i class="bi bi-hourglass-split display-1 text-warning"></i>
                </div>

                <!-- Error Message -->
                <h1 class="display-4 mb-3">429</h1>
                <h2 class="h4 mb-4">Terlalu Banyak Permintaan</h2>
                <p class="text-muted mb-4">
                    Maaf, Anda telah melakukan terlalu banyak permintaan. Silakan tunggu beberapa saat dan coba lagi.
                </p>

                <!-- Action Buttons -->
                <div class="d-flex justify-content-center gap-3">
                    <a href="{{ url()->previous() }}" class="btn btn-outline-primary">
                        <i class="bi bi-arrow-left me-2"></i>Kembali
                    </a>
                    <button type="button" class="btn btn-primary" onclick="window.location.reload()">
                        <i class="bi bi-arrow-clockwise me-2"></i>Coba Lagi
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
