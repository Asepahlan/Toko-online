@extends('layouts.app')

@section('title', 'Sedang Dalam Perbaikan - ' . config('app.name'))

@section('content')
<div class="container py-5">
    <div class="row justify-content-center text-center">
        <div class="col-lg-6">
            <div class="error-content">
                <!-- Error Illustration -->
                <div class="mb-4">
                    <i class="bi bi-tools display-1 text-primary"></i>
                </div>

                <!-- Error Message -->
                <h1 class="display-4 mb-3">503</h1>
                <h2 class="h4 mb-4">Sedang Dalam Perbaikan</h2>
                <p class="text-muted mb-4">
                    Maaf, saat ini website sedang dalam perbaikan. Silakan kembali beberapa saat lagi.
                    <br>
                    <small>Tim kami sedang bekerja untuk memberikan pengalaman yang lebih baik untuk Anda.</small>
                </p>

                <!-- Action Buttons -->
                <div class="d-flex justify-content-center gap-3">
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
