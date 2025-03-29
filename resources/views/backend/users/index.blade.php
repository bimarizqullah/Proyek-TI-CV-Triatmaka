@extends('layoutsBackend.app')

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Content -->
    <div class="user mt-4">
        <h2>Users</h2>

        <!-- Tombol tambah user hanya muncul untuk Super Admin -->
        @if(auth()->user()->level === 'superadmin')
            <a href="{{ route('backend.users.create') }}" class="btn btn-warning mb-3 fw-bold">+ Add User</a>
        @endif

        <div class="d-flex justify-content-end mb-3">
            <form method="GET" action="{{ route('backend.users.index') }}">
                <label>Search:
                    <input type="text" name="search" class="form-control form-control-sm"
                        value="{{ request('search') }}" placeholder="Cari user...">
                </label>
                <button type="submit" class="btn btn-primary btn-sm btn-warning">Cari</button>
            </form>
        </div>

        <table class="table table-bordered">
            <thead class="table-warning">
                <tr class="text-center">
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Alamat</th>
                    <th>Level</th>
                    <th>Status</th>
                    @if(Auth::user()->level === 'superadmin') 
                        <th>Action</th> <!-- Hanya muncul jika user adalah Super Admin -->
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->alamat }}</td>
                    <td>{{ $user->level }}</td>
                    <td>{{ $user->status }}</td>

                    @if(auth()->user()->level === 'superadmin')
                        <td>
                            <a href="{{ route('backend.users.edit', $user->id) }}" class="btn btn-sm btn-primary fa-solid fa-pen-to-square"></a>
                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-sm btn-danger delete-button fa-solid fa-trash" data-user-id="{{ $user->id }}"></button>
                            </form>

                            <script>
                                document.addEventListener('DOMContentLoaded', function () {
                                    document.querySelectorAll('.delete-button').forEach(button => {
                                        button.addEventListener('click', function () {
                                            let userId = this.getAttribute('data-user-id');
                                            let form = this.closest('.delete-form'); // Ambil form terdekat dari tombol

                                            Swal.fire({
                                                title: "Apakah Anda yakin?",
                                                text: "Data pengguna akan dihapus secara permanen!",
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
                                });
                            </script>
                        </td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
        <p>Showing {{ $users->count() }} entries</p>
    </div>
</div>
@endsection
