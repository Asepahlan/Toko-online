@php
    use Illuminate\Support\Str;
@endphp

@extends('layouts.admin')

@section('title', 'Manajemen Kategori - ' . config('app.name'))

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Kategori</h1>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
            <i class="bi bi-plus-lg me-1"></i> Tambah Kategori
        </button>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="bg-light">
                        <tr>
                            <th width="50">#</th>
                            <th>Nama</th>
                            <th>Slug</th>
                            <th>Deskripsi</th>
                            <th>Jumlah Produk</th>
                            <th width="100">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $category)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $category->name }}</td>
                                <td>{{ $category->slug }}</td>
                                <td>{{ Str::limit($category->description, 50) }}</td>
                                <td>{{ $category->products_count }}</td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button"
                                                class="btn btn-sm btn-outline-primary"
                                                onclick="editCategory({{ $category->id }}, '{{ $category->name }}', '{{ $category->description }}', '{{ $category->icon }}')">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <form action="{{ route('admin.categories.destroy', $category) }}"
                                              method="POST"
                                              class="d-inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="bi bi-inbox display-6 d-block mb-3"></i>
                                        <p class="mb-0">Belum ada kategori</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-4">
                <div class="text-muted small">
                    Menampilkan {{ $categories->firstItem() ?? 0 }} sampai {{ $categories->lastItem() ?? 0 }}
                    dari {{ $categories->total() }} kategori
                </div>
                {{ $categories->links('vendor.pagination.bootstrap-5') }}
            </div>
        </div>
    </div>
</div>

<!-- Modal Form Edit -->
<div class="modal" id="categoryModal" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Edit Kategori</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="categoryForm" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Kategori</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="description" class="form-control" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Icon</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi" id="editSelectedIcon"></i>
                            </span>
                            <input type="text" class="form-control" name="icon" id="editIconInput" readonly>
                            <button class="btn btn-outline-secondary" type="button" data-bs-toggle="modal" data-bs-target="#editIconPickerModal">
                                Pilih Icon
                            </button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" onclick="closeModal()">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Icon Picker untuk Edit -->
<div class="modal fade" id="editIconPickerModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pilih Icon</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <input type="text" class="form-control" id="editIconSearch" placeholder="Cari icon...">
                </div>
                <div class="row g-3" id="editIconGrid">
                    <!-- Icons akan di-generate oleh JavaScript -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Kategori -->
<div class="modal fade" id="addCategoryModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.categories.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Kategori</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Kategori</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea class="form-control" name="description" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Icon</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi" id="selectedIcon"></i>
                            </span>
                            <input type="text" class="form-control" name="icon" id="iconInput" readonly>
                            <button class="btn btn-outline-secondary" type="button" data-bs-toggle="modal" data-bs-target="#iconPickerModal">
                                Pilih Icon
                            </button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Tambahkan modal untuk pemilih icon -->
<div class="modal fade" id="iconPickerModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pilih Icon</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <input type="text" class="form-control" id="iconSearch" placeholder="Cari icon...">
                </div>
                <div class="row g-3" id="iconGrid">
                    <!-- Icons akan di-generate oleh JavaScript -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let categoryModal;

document.addEventListener('DOMContentLoaded', function() {
    categoryModal = new bootstrap.Modal(document.getElementById('categoryModal'), {
        backdrop: 'static',
        keyboard: false
    });
});

function closeModal() {
    categoryModal.hide();
    document.body.classList.remove('modal-open');
    const backdrop = document.querySelector('.modal-backdrop');
    if (backdrop) backdrop.remove();
}

function editCategory(id, name, description, icon) {
    const form = document.getElementById('categoryForm');
    form.action = `/admin/categories/${id}`;

    form.querySelector('[name="name"]').value = name;
    form.querySelector('[name="description"]').value = description;
    form.querySelector('[name="icon"]').value = icon || '';
    document.getElementById('editSelectedIcon').className = `bi bi-${icon || ''}`;

    const modal = new bootstrap.Modal(document.getElementById('categoryModal'));
    modal.show();
}

// Handle form submit
document.getElementById('categoryForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const submitBtn = this.querySelector('button[type="submit"]');
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Loading...';

    fetch(this.action, {
        method: 'POST',
        body: new FormData(this),
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            closeModal();
            location.reload();
        } else {
            alert('Gagal menyimpan kategori');
            submitBtn.disabled = false;
            submitBtn.innerHTML = 'Simpan';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan');
        submitBtn.disabled = false;
        submitBtn.innerHTML = 'Simpan';
    });
});

// Handle delete confirmation
document.querySelectorAll('.delete-form').forEach(form => {
    form.addEventListener('submit', function(e) {
        if (!confirm('Yakin ingin menghapus kategori ini?')) {
            e.preventDefault();
        }
    });
});

// Daftar icon Bootstrap yang sering digunakan
const icons = [
    'tag', 'tags', 'bookmark', 'cart', 'bag', 'box', 'gift', 'truck',
    'shop', 'basket', 'basket2', 'basket3', 'bag-check', 'bag-plus',
    'currency-dollar', 'credit-card', 'cash', 'wallet', 'wallet2',
    'receipt', 'receipt-cutoff', 'archive', 'box-seam', 'box2',
    'box2-heart', 'boxes', 'handbag', 'suit-heart', 'suit-club',
    'suit-diamond', 'suit-spade', 'watch', 'smartwatch', 'headphones',
    'phone', 'laptop', 'display', 'tablet', 'tv', 'speaker', 'camera',
    'camera2', 'mic', 'printer', 'keyboard', 'mouse', 'cpu', 'gpu-card',
    'lamp', 'lightbulb', 'battery', 'bluetooth', 'wifi', 'broadcast',
    'book', 'journal', 'newspaper', 'magazine', 'postcard', 'envelope',
    'chat', 'chat-dots', 'chat-left', 'chat-right', 'heart', 'star',
    'cup', 'cup-hot', 'cup-straw', 'egg', 'egg-fried', 'music-note',
    'film', 'camera-reels', 'controller', 'puzzle', 'palette', 'brush',
    'paint-bucket', 'pen', 'pencil', 'marker', 'type', 'fonts', 'list',
    'card-list', 'table', 'diagram', 'bar-chart', 'graph-up', 'pie-chart',
    'clock', 'alarm', 'calendar', 'calendar2', 'calendar3', 'calendar4'
];

// Fungsi untuk me-render grid icon
function renderIcons(searchTerm = '') {
    const iconGrid = document.getElementById('iconGrid');
    iconGrid.innerHTML = '';

    icons.filter(icon => icon.includes(searchTerm.toLowerCase()))
        .forEach(icon => {
            const div = document.createElement('div');
            div.className = 'col-4 col-md-3 col-lg-2';
            div.innerHTML = `
                <div class="d-flex flex-column align-items-center p-2 border rounded icon-item"
                     role="button" onclick="selectIcon('${icon}')">
                    <i class="bi bi-${icon} fs-3 mb-2"></i>
                    <small class="text-muted text-center">${icon}</small>
                </div>
            `;
            iconGrid.appendChild(div);
        });
}

// Fungsi untuk memilih icon
function selectIcon(icon) {
    document.getElementById('iconInput').value = icon;
    document.getElementById('selectedIcon').className = `bi bi-${icon}`;
    bootstrap.Modal.getInstance(document.getElementById('iconPickerModal')).hide();
}

// Event listener untuk pencarian icon
document.getElementById('iconSearch')?.addEventListener('input', (e) => {
    renderIcons(e.target.value);
});

// Render icons saat modal dibuka
document.getElementById('iconPickerModal')?.addEventListener('show.bs.modal', () => {
    renderIcons();
});

// Fungsi untuk memilih icon saat edit
function selectEditIcon(icon) {
    document.getElementById('editIconInput').value = icon;
    document.getElementById('editSelectedIcon').className = `bi bi-${icon}`;
    bootstrap.Modal.getInstance(document.getElementById('editIconPickerModal')).hide();
}

// Event listener untuk pencarian icon di modal edit
document.getElementById('editIconSearch')?.addEventListener('input', (e) => {
    renderEditIcons(e.target.value);
});

// Render icons saat modal edit dibuka
document.getElementById('editIconPickerModal')?.addEventListener('show.bs.modal', () => {
    renderEditIcons();
});

// Fungsi untuk me-render grid icon di modal edit
function renderEditIcons(searchTerm = '') {
    const iconGrid = document.getElementById('editIconGrid');
    iconGrid.innerHTML = '';

    icons.filter(icon => icon.includes(searchTerm.toLowerCase()))
        .forEach(icon => {
            const div = document.createElement('div');
            div.className = 'col-4 col-md-3 col-lg-2';
            div.innerHTML = `
                <div class="d-flex flex-column align-items-center p-2 border rounded icon-item"
                     role="button" onclick="selectEditIcon('${icon}')">
                    <i class="bi bi-${icon} fs-3 mb-2"></i>
                    <small class="text-muted text-center">${icon}</small>
                </div>
            `;
            iconGrid.appendChild(div);
        });
}
</script>
@endpush

@push('styles')
<style>
.icon-item {
    cursor: pointer;
    transition: all 0.2s;
}

.icon-item:hover {
    background-color: #f8f9fa;
    transform: translateY(-2px);
}

.icon-item small {
    font-size: 0.75rem;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    max-width: 100%;
}

#iconGrid {
    max-height: 400px;
    overflow-y: auto;
}

/* Styling untuk scrollbar */
#iconGrid::-webkit-scrollbar {
    width: 6px;
}

#iconGrid::-webkit-scrollbar-track {
    background: #f1f1f1;
}

#iconGrid::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 3px;
}

#iconGrid::-webkit-scrollbar-thumb:hover {
    background: #555;
}
</style>
@endpush
