@extends('layouts.app')

@section('title', 'Terjadi Kesalahan - ' . config('app.name'))

@section('content')
<div class="container py-5">
    <div class="row justify-content-center text-center">
        <div class="col-lg-6">
            <div class="error-content">
                <!-- Error Illustration -->
                <div class="mb-4">
                    <i class="bi bi-emoji-frown display-1 text-danger"></i>
                </div>

                <!-- Error Message -->
                <h1 class="display-4 mb-3">{{ $code ?? '500' }}</h1>
                <h2 class="h4 mb-4">{{ $message ?? 'Terjadi Kesalahan' }}</h2>
                <p class="text-muted mb-4">
                    {{ $description ?? 'Maaf, telah terjadi kesalahan. Silakan coba lagi nanti.' }}
                </p>

                <!-- Action Buttons -->
                <div class="d-flex justify-content-center gap-3">
                    <a href="{{ url()->previous() }}" class="btn btn-outline-primary">
                        <i class="bi bi-arrow-left me-2"></i>Kembali
                    </a>
                    <a href="{{ route('home') }}" class="btn btn-primary">
                        <i class="bi bi-house me-2"></i>Halaman Utama
                    </a>
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
