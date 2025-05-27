@extends('layoutsBackend.app')

@section('content')
@if(session('success'))
    <div class="d-none" id="swal-success" data-message="{{ session('success') }}"></div>
@endif

@if(session('error'))
    <div class="d-none" id="swal-error" data-message="{{ session('error') }}"></div>
@endif

@if ($errors->any())
    <div class="d-none" id="swal-validation">
        @foreach ($errors->all() as $error)
            <div class="swal-validation-message">{{ $error }}</div>
        @endforeach
    </div>
@endif

<div class="user mt-4">
    <h2>User Management</h2>
    <a href="javascript:void(0);" class="btn btn-warning mb-3 fw-bold" data-bs-toggle="modal"
       data-bs-target="#addUserModal">+ Add User</a>
    <div class="d-flex justify-content-end mb-3">
        <form method="GET" action="{{ route('users.index') }}">
            <label>Search:
                <input type="text" name="search" class="form-control form-control-sm" value="{{ request('search') }}"
                    placeholder="Cari User...">
            </label>
            <button type="submit" class="btn btn-primary btn-sm btn-warning">Cari</button>
        </form>
    </div>
    <table class="table table-bordered">
        <thead class="table-warning">
            <tr class="text-center">
                <th>ID</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Alamat</th>
                <th>Level</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr class="text-center">
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->alamat }}</td>
                    <td>{{ $user->level }}</td>
                    <td>{{ $user->status }}</td>
                    <td>
                        <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#editUserModal"
                            class="btn btn-sm btn-primary fa-solid fa-pen-to-square edit-user"
                            data-id="{{ $user->id }}"
                            data-name="{{ $user->name }}"
                            data-email="{{ $user->email }}"
                            data-alamat="{{ $user->alamat }}"
                            data-level="{{ $user->level }}"
                            data-status="{{ $user->status }}"
                            data-update-url="{{ route('users.update', $user->id) }}">
                        </a>

                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-sm btn-danger delete-button fa-solid fa-trash"
                                    data-user-id="{{ $user->id }}"></button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <p>Showing {{ $users->count() }} entries</p>
</div>

{{-- Modal Tambah User --}}
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" action="{{ route('users.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Nama</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Alamat</label>
                        <input type="text" name="alamat" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Level</label>
                        <select name="level" class="form-control" required>
                            <option value="superadmin">Super Admin</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Status</label>
                        <select name="status" class="form-control" required>
                            <option value="aktif">Aktif</option>
                            <option value="non-aktif">Non-Aktif</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-warning fw-bold">Simpan</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Edit User --}}
<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="edit-id" name="id">
                    <div class="mb-3">
                        <label>Nama</label>
                        <input type="text" name="name" id="edit-name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" id="edit-email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Alamat</label>
                        <input type="text" name="alamat" id="edit-alamat" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Level</label>
                        <select name="level" id="edit-level" class="form-control" required>
                            <option value="superadmin">Super Admin</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Status</label>
                        <select name="status" id="edit-status" class="form-control" required>
                            <option value="aktif">Aktif</option>
                            <option value="non-aktif">Non-Aktif</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-warning fw-bold">Update</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Populate modal Edit
        document.querySelectorAll('.edit-user').forEach(button => {
            button.addEventListener('click', function () {
                document.getElementById('edit-id').value = this.dataset.id;
                document.getElementById('edit-name').value = this.dataset.name;
                document.getElementById('edit-email').value = this.dataset.email;
                document.getElementById('edit-alamat').value = this.dataset.alamat;
                document.getElementById('edit-level').value = this.dataset.level;
                document.getElementById('edit-status').value = this.dataset.status;
                document.getElementById('editForm').action = this.dataset.updateUrl;
            });
        });

        // Konfirmasi delete
        document.querySelectorAll('.delete-button').forEach(button => {
            button.addEventListener('click', function () {
                let form = this.closest('.delete-form');
                Swal.fire({
                    title: "Apakah Anda yakin?",
                    text: "Data user akan dihapus secara permanen!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#ffc107",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Ya, hapus"
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });

        // SweetAlert: Success
        const successAlert = document.getElementById('swal-success');
        if (successAlert) {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: successAlert.dataset.message,
                confirmButtonColor: '#ffc107'
            });
        }

        // SweetAlert: Error
        const errorAlert = document.getElementById('swal-error');
        if (errorAlert) {
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: errorAlert.dataset.message,
                confirmButtonColor: '#d33'
            });
        }

        // SweetAlert: Validation Errors
        const validationAlert = document.getElementById('swal-validation');
        if (validationAlert) {
            let messages = '';
            validationAlert.querySelectorAll('.swal-validation-message').forEach(el => {
                messages += `<div>${el.textContent}</div>`;
            });
            Swal.fire({
                icon: 'error',
                title: 'Validasi Gagal!',
                html: messages,
                confirmButtonColor: '#d33'
            });
        }
    });
</script>
@endsection
