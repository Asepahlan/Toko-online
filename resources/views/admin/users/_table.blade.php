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
            @forelse($users as $user)
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
            @empty
            <tr>
                <td colspan="6" class="text-center py-4">
                    <div class="text-muted">
                        <i class="bi bi-inbox display-6 d-block mb-3"></i>
                        <p class="mb-0">Tidak ada pengguna yang ditemukan</p>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
