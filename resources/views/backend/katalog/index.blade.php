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

    <div class="catalog mt-4">
        <h2>Catalog</h2>
        <a href="{{ route('katalog.create') }}" class="btn btn-warning mb-3 fw-bold">+ Add Produk</a>
        <div class="d-flex justify-content-end mb-3">
            <form method="GET" action="{{ route('katalog.index') }}">
                <label>Search:
                    <input type="text" name="search" class="form-control form-control-sm" 
                        value="{{ request('search') }}" placeholder="Cari Produk...">
                </label>
                <button type="submit" class="btn btn-primary btn-sm btn-warning">Cari</button>
            </form>
        </div>
        <table class="table table-bordered">
            <thead class="table-warning">
                <tr class="text-center">
                    <th>ID</th>
                    <th>Gambar</th>
                    <th>Produk</th>
                    <th>Deskripsi</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($catalog as $katalog)
                <tr>
                    <td>{{ $katalog->id }}</td>
                    <td>
                        <img src="{{ asset('storage/' . $katalog->image_path) }}" alt="Gambar Produk" width="100">
                    </td>
                    <td>{{ $katalog->produk }}</td>
                    <td>{{ $katalog->deskripsi }}</td>
                    <td>
                        <a href="{{ route('katalog.edit', $katalog->id) }}" class="btn btn-sm btn-primary fa-solid fa-pen-to-square"></a>
                        <form action="{{ route('katalog.destroy', $katalog->id) }}" method="POST" class="d-inline delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-sm btn-danger delete-button fa-solid fa-trash" data-user-id="{{ $katalog->id }}"></button>
                        </form>
                        
                        <script>
                            document.addEventListener('DOMContentLoaded', function () {
                                document.querySelectorAll('.delete-button').forEach(button => {
                                    button.addEventListener('click', function () {
                                        let katalogId = this.getAttribute('data-katalog-id');
                                        let form = this.closest('.delete-form'); // Ambil form terdekat dari tombol
                        
                                        Swal.fire({
                                            title: "Apakah Anda yakin?",
                                            text: "Data Produk akan dihapus secara permanen!",
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
                </tr>
                @endforeach
            </tbody>
        </table>
        <p>Showing {{ $catalog->count() }} entries</p>
    </div>
@endsection
