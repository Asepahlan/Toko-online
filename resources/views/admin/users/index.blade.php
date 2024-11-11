@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-header bg-white py-3">
            <h5 class="card-title mb-0">Filter</h5>
        </div>
        <div class="card-body">
            <form id="filterForm" class="row g-3">
                <!-- Filter Role -->
                <div class="col-12 col-md-4">
                    <label class="form-label">Role</label>
                    <div class="d-flex gap-2">
                        <input type="radio" class="btn-check" name="role" id="all-role" value="" checked>
                        <label class="btn btn-outline-secondary btn-sm" for="all-role">
                            Semua
                        </label>

                        <input type="radio" class="btn-check" name="role" id="admin-role" value="admin">
                        <label class="btn btn-outline-primary btn-sm" for="admin-role">
                            Admin
                        </label>

                        <input type="radio" class="btn-check" name="role" id="user-role" value="user">
                        <label class="btn btn-outline-secondary btn-sm" for="user-role">
                            User
                        </label>
                    </div>
                </div>

                <!-- Filter Status -->
                <div class="col-12 col-md-4">
                    <label class="form-label">Status</label>
                    <div class="d-flex gap-2">
                        <input type="radio" class="btn-check" name="status" id="all-status" value="" checked>
                        <label class="btn btn-outline-secondary btn-sm" for="all-status">
                            Semua
                        </label>

                        <input type="radio" class="btn-check" name="status" id="active-status" value="active">
                        <label class="btn btn-outline-success btn-sm" for="active-status">
                            Aktif
                        </label>

                        <input type="radio" class="btn-check" name="status" id="inactive-status" value="inactive">
                        <label class="btn btn-outline-danger btn-sm" for="inactive-status">
                            Tidak Aktif
                        </label>
                    </div>
                </div>

                <!-- Pencarian -->
                <div class="col-12 col-md-4">
                    <label class="form-label">Cari</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="searchInput"
                               placeholder="Cari nama atau email..." name="search">
                        <button class="btn btn-primary" type="submit">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabel Pengguna -->
    <div class="card shadow-sm mt-3">
        <div class="card-header bg-white py-3">
            <h5 class="card-title mb-0">Daftar Pengguna</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="border-0 px-3">NAMA</th>
                            <th class="border-0">EMAIL</th>
                            <th class="border-0">ROLE</th>
                            <th class="border-0">STATUS</th>
                            <th class="border-0">BERGABUNG</th>
                            <th class="border-0 text-end px-3">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td class="px-3">
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center me-2"
                                         style="width: 35px; height: 35px; background-color: {{ '#' . substr(md5($user->name), 0, 6) }};">
                                        <span class="text-white fw-bold">
                                            {{ strtoupper(substr($user->name, 0, 2)) }}
                                        </span>
                                    </div>
                                    <div>{{ $user->name }}</div>
                                </div>
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <span class="badge bg-{{ $user->role === 'admin' ? 'primary' : 'secondary' }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-{{ $user->is_active ? 'success' : 'danger' }} status-badge"
                                      data-user-id="{{ $user->id }}">
                                    {{ $user->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                </span>
                            </td>
                            <td>{{ $user->created_at->format('d/m/Y') }}</td>
                            <td class="text-end px-3">
                                <div class="btn-group">
                                    <button class="btn btn-sm btn-outline-primary" onclick="editUser({{ $user->id }})">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    @if(auth()->id() !== $user->id)
                                    <button class="btn btn-sm btn-outline-danger"
                                            onclick="confirmDelete({{ $user->id }}, '{{ $user->name }}')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit User -->
<div class="modal fade" id="editUserModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="editUserForm" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title">Edit Pengguna</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Role</label>
                        <select class="form-select" name="role" required>
                            <option value="user">User</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_active" id="isActive">
                        <label class="form-check-label" for="isActive">Akun Aktif</label>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary px-4">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function editUser(userId) {
    fetch(`/admin/users/${userId}/edit`)
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.json();
        })
        .then(user => {
            const form = document.getElementById('editUserForm');
            form.action = `/admin/users/${userId}`;
            form.querySelector('[name="name"]').value = user.name;
            form.querySelector('[name="email"]').value = user.email;
            form.querySelector('[name="role"]').value = user.role;
            form.querySelector('[name="is_active"]').checked = user.is_active;

            new bootstrap.Modal(document.getElementById('editUserModal')).show();
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat mengambil data pengguna');
        });
}

// Perbaiki event listener untuk form submit
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('editUserForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);
        const userId = this.action.split('/').pop();

        fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update status badge
                const statusBadge = document.querySelector(`.status-badge[data-user-id="${userId}"]`);
                if (statusBadge) {
                    const isActive = formData.get('is_active') === 'on';
                    statusBadge.className = `badge bg-${isActive ? 'success' : 'danger'} status-badge`;
                    statusBadge.textContent = isActive ? 'Aktif' : 'Tidak Aktif';
                }

                // Tutup modal
                const modal = bootstrap.Modal.getInstance(document.getElementById('editUserModal'));
                if (modal) modal.hide();

                // Tampilkan pesan sukses
                alert('Pengguna berhasil diperbarui');
                location.reload();
            } else {
                alert(data.message || 'Terjadi kesalahan saat memperbarui pengguna');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat memperbarui pengguna');
        });
    });
});

// Update fungsi confirmDelete dengan animasi yang lebih jelas
function confirmDelete(userId, userName) {
    Swal.fire({
        title: 'Hapus Pengguna?',
        text: `Apakah Anda yakin ingin menghapus pengguna ${userName}?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal',
        reverseButtons: true,
        showClass: {
            popup: 'animate__animated animate__zoomIn animate__faster'
        },
        hideClass: {
            popup: 'animate__animated animate__zoomOut animate__faster'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            // Tampilkan loading dengan animasi
            Swal.fire({
                title: 'Menghapus Pengguna',
                html: 'Mohon tunggu sebentar...',
                allowOutsideClick: false,
                showConfirmButton: false,
                willOpen: () => {
                    Swal.showLoading();
                },
                showClass: {
                    popup: 'animate__animated animate__fadeIn animate__faster'
                }
            });

            // Buat form untuk delete
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/admin/users/${userId}`;
            form.innerHTML = `
                @csrf
                @method('DELETE')
            `;
            document.body.appendChild(form);
            form.submit();
        }
    });
}

// Tambahkan di head untuk animasi
document.head.insertAdjacentHTML('beforeend', `
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
`);

// Update notifikasi sukses/error dengan animasi yang lebih jelas
@if(session('success'))
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: '{{ session('success') }}',
        showConfirmButton: false,
        timer: 1500,
        showClass: {
            popup: 'animate__animated animate__fadeInDown animate__faster'
        },
        hideClass: {
            popup: 'animate__animated animate__fadeOutUp animate__faster'
        }
    });
@endif

@if(session('error'))
    Swal.fire({
        icon: 'error',
        title: 'Gagal!',
        text: '{{ session('error') }}',
        showClass: {
            popup: 'animate__animated animate__shakeX animate__faster'
        }
    });
@endif

// Tambahkan filter realtime
document.getElementById('filterForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    const params = new URLSearchParams(formData);
    window.location.href = `${window.location.pathname}?${params.toString()}`;
});

// Update filter realtime
document.querySelectorAll('input[type="radio"]').forEach(radio => {
    radio.addEventListener('change', function() {
        document.getElementById('filterForm').dispatchEvent(new Event('submit'));
    });
});
</script>
@endpush

@push('styles')
<style>
/* Perbaikan tampilan mobile */
@media (max-width: 768px) {
    .table th, .table td {
        white-space: nowrap;
    }

    .btn-group {
        display: flex;
        gap: 0.25rem;
    }

    .modal-dialog {
        margin: 0.5rem;
    }

    .card {
        margin-bottom: 1rem;
    }

    .form-label {
        margin-bottom: 0.25rem;
    }
}

/* Animasi smooth untuk interaksi */
.badge, .btn {
    transition: all 0.2s ease-in-out;
}

.btn:active {
    transform: scale(0.95);
}

/* Perbaikan tampilan tabel */
.table {
    font-size: 0.9rem;
}

.table th {
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.75rem;
    letter-spacing: 0.5px;
}

/* Perbaikan tampilan filter */
.form-select, .form-control {
    font-size: 0.9rem;
    padding: 0.5rem 0.75rem;
}

/* Perbaikan tampilan filter button */
.btn-check + .btn {
    padding: 0.25rem 0.75rem;
    font-size: 0.875rem;
    border-radius: 50px;
}

.btn-check:checked + .btn {
    font-weight: 500;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .d-flex.gap-2 {
        flex-wrap: wrap;
    }

    .btn-check + .btn {
        width: auto;
        min-width: 80px;
        margin-bottom: 0.25rem;
    }
}

/* Hover effects */
.btn-check + .btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.btn-check:checked + .btn {
    transform: translateY(1px);
    box-shadow: none;
}
</style>
@endpush
