@extends('layouts.app')

@section('title', 'Verifikasi Email - ' . config('app.name'))

@section('meta')
<meta name="description" content="Verifikasi alamat email Anda untuk mengaktifkan akun {{ config('app.name') }}.">
<meta name="robots" content="noindex, nofollow">
@endsection

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-5">
                    <div class="text-center mb-5">
                        <div class="mb-4">
                            <i class="fas fa-envelope fa-3x text-primary"></i>
                        </div>
                        <h1 class="h3 mb-3">Verifikasi Email</h1>
                        <p class="text-muted">
                            Sebelum melanjutkan, silakan periksa email Anda untuk link verifikasi.
                            Jika Anda tidak menerima email verifikasi, klik tombol di bawah untuk mengirim ulang.
                        </p>
                    </div>

                    @if (session('resent'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            Link verifikasi baru telah dikirim ke alamat email Anda.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('verification.resend') }}" class="text-center">
                        @csrf
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-paper-plane me-2"></i>Kirim Ulang Email Verifikasi
                        </button>
                    </form>

                    <div class="text-center mt-4">
                        <p class="text-muted">
                            Kembali ke
                            <a href="{{ route('home') }}" class="text-decoration-none">
                                Beranda
                            </a>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Informasi Tambahan -->
            <div class="card border-0 shadow-sm mt-4">
                <div class="card-body p-4">
                    <h5 class="card-title">
                        <i class="fas fa-info-circle text-primary me-2"></i>
                        Mengapa Verifikasi Email Penting?
                    </h5>
                    <p class="card-text text-muted mb-0">
                        Verifikasi email membantu kami memastikan bahwa alamat email Anda valid dan membantu meningkatkan keamanan akun Anda.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "BreadcrumbList",
    "itemListElement": [{
        "@type": "ListItem",
        "position": 1,
        "name": "Beranda",
        "item": "{{ route('home') }}"
    },{
        "@type": "ListItem",
        "position": 2,
        "name": "Verifikasi Email"
    }]
}
</script>
@endpush
@endsection
