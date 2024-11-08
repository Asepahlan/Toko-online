@extends('layouts.admin')

@section('title', 'Tambah Kategori - ' . config('app.name'))

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Tambah Kategori</h1>
            <p class="text-muted">Tambahkan kategori baru untuk produk</p>
        </div>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-primary">
            <i class="bi bi-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <!-- Form -->
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form action="{{ route('admin.categories.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-8">
                        <!-- Basic Info -->
                        <div class="mb-3">
                            <label class="form-label">Nama Kategori</label>
                            <input type="text"
                                   name="name"
                                   class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name') }}"
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Deskripsi</label>
                            <textarea name="description"
                                      class="form-control @error('description') is-invalid @enderror"
                                      rows="4"
                                      required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Icon</label>
                            <div class="input-group">
                                <span class="input-group-text">bi bi-</span>
                                <input type="text"
                                       name="icon"
                                       class="form-control @error('icon') is-invalid @enderror"
                                       value="{{ old('icon', 'tag') }}"
                                       placeholder="Nama icon dari Bootstrap Icons">
                            </div>
                            <small class="text-muted">
                                Lihat daftar icon di
                                <a href="https://icons.getbootstrap.com/" target="_blank">Bootstrap Icons</a>
                            </small>
                            @error('icon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Preview Icon -->
                        <div class="mb-4">
                            <label class="form-label">Preview Icon</label>
                            <div class="p-3 bg-light rounded text-center">
                                <i id="iconPreview" class="bi bi-tag display-4"></i>
                            </div>
                        </div>

                        <hr>

                        <!-- Submit Button -->
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.categories.index') }}" class="btn btn-light">Batal</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-2"></i>Simpan
                            </button>
                        </div>
                    </div>

                    <!-- Sidebar -->
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="card-title">Icon Populer</h6>
                                <div class="d-flex flex-wrap gap-2">
                                    <button type="button" class="btn btn-outline-primary icon-btn" data-icon="tag">
                                        <i class="bi bi-tag"></i>
                                    </button>
                                    <button type="button" class="btn btn-outline-primary icon-btn" data-icon="box">
                                        <i class="bi bi-box"></i>
                                    </button>
                                    <button type="button" class="btn btn-outline-primary icon-btn" data-icon="cart">
                                        <i class="bi bi-cart"></i>
                                    </button>
                                    <button type="button" class="btn btn-outline-primary icon-btn" data-icon="bag">
                                        <i class="bi bi-bag"></i>
                                    </button>
                                    <button type="button" class="btn btn-outline-primary icon-btn" data-icon="phone">
                                        <i class="bi bi-phone"></i>
                                    </button>
                                    <button type="button" class="btn btn-outline-primary icon-btn" data-icon="laptop">
                                        <i class="bi bi-laptop"></i>
                                    </button>
                                    <button type="button" class="btn btn-outline-primary icon-btn" data-icon="camera">
                                        <i class="bi bi-camera"></i>
                                    </button>
                                    <button type="button" class="btn btn-outline-primary icon-btn" data-icon="headphones">
                                        <i class="bi bi-headphones"></i>
                                    </button>
                                    <button type="button" class="btn btn-outline-primary icon-btn" data-icon="watch">
                                        <i class="bi bi-watch"></i>
                                    </button>
                                    <button type="button" class="btn btn-outline-primary icon-btn" data-icon="book">
                                        <i class="bi bi-book"></i>
                                    </button>
                                    <button type="button" class="btn btn-outline-primary icon-btn" data-icon="gift">
                                        <i class="bi bi-gift"></i>
                                    </button>
                                    <button type="button" class="btn btn-outline-primary icon-btn" data-icon="house">
                                        <i class="bi bi-house"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.icon-btn {
    width: 40px;
    height: 40px;
    padding: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
}

.icon-btn:hover {
    transform: scale(1.1);
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const iconInput = document.querySelector('input[name="icon"]');
    const iconPreview = document.getElementById('iconPreview');
    const iconButtons = document.querySelectorAll('.icon-btn');

    // Update preview when input changes
    iconInput.addEventListener('input', function() {
        iconPreview.className = `bi bi-${this.value} display-4`;
    });

    // Update input and preview when icon button clicked
    iconButtons.forEach(button => {
        button.addEventListener('click', function() {
            const icon = this.dataset.icon;
            iconInput.value = icon;
            iconPreview.className = `bi bi-${icon} display-4`;
        });
    });
});
</script>
@endpush
