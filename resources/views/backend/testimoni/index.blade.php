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

    <div class="testimoni mt-4">
        <h2>Testimoni</h2>
        <a href="javascript:void(0);" class="btn btn-warning mb-3 fw-bold" data-bs-toggle="modal" data-bs-target="#addTestimoniModal">+ Add Testimoni</a>
        <div class="d-flex justify-content-end mb-3">
            <form method="GET" action="{{ route('testimoni.index') }}">
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
                    <th>Nama Pelanggan</th>
                    <th>Produk</th>
                    <th>Deskripsi</th>
                    <th>Rating</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($testimoni as $testimonis)
                <tr>
                    <td>{{ $testimonis->id }}</td>
                    <td>
                        <img src="{{ asset('storage/' . $testimonis->image_path) }}" alt="Gambar Produk" width="100">
                    </td>
                    <td>{{ $testimonis->nama_pelanggan }}</td>
                    <td>{{ $testimonis->produk }}</td>
                    <td>{{ $testimonis->deskripsi }}</td>
                    <td>{{ $testimonis->rating }}</td>
                    <td>
                        <a href="javascript:void(0);" 
                           class="btn btn-sm btn-primary fa-solid fa-pen-to-square edit-button"
                           data-id="{{ $testimonis->id }}"
                           data-produk="{{ $testimonis->produk }}"
                           data-nama_pelanggan="{{ $testimonis->nama_pelanggan }}"
                           data-deskripsi="{{ $testimonis->deskripsi }}"
                           data-image="{{ asset('storage/' . $testimonis->image_path) }}"
                           data-rating="{{ $testimonis->rating }}"
                           data-update-url="{{ route('testimoni.update', $testimonis->id) }}">
                        </a>
                        <form action="{{ route('testimoni.destroy', $testimonis->id) }}" method="POST" class="d-inline delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-sm btn-danger delete-button fa-solid fa-trash" data-user-id="{{ $testimonis->id }}"></button>
                        </form>

                        <script>
                            document.addEventListener('DOMContentLoaded', function () {
                                document.querySelectorAll('.delete-button').forEach(button => {
                                    button.addEventListener('click', function () {
                                        let testimoniId = this.getAttribute('data-user-id');
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
        <p>Showing {{ $testimoni->count() }} entries</p>
    </div>

    <!-- Modal Edit Testimoni -->
    <div class="modal fade" id="editTestimoniModal" tabindex="-1" aria-labelledby="editTestimoniModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="editForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title" id="editTestimoniModalLabel">Edit Testimoni</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <input type="hidden" name="id" id="edit-id">

                        <div class="mb-3">
                            <label for="edit-produk" class="form-label">Nama Produk</label>
                            <input type="text" name="produk" id="edit-produk" class="form-control" required minlength="8">
                        </div>

                        <div class="mb-3">
                            <label for="edit-nama_pelanggan" class="form-label">Nama Pelanggan</label>
                            <input type="text" name="nama_pelanggan" id="edit-nama_pelanggan" class="form-control" required minlength="8">
                        </div>

                        <div class="mb-3">
                            <label for="edit-deskripsi" class="form-label">Deskripsi</label>
                            <textarea name="deskripsi" id="edit-deskripsi" class="form-control" required maxlength="255"></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="edit-image_path" class="form-label">Gambar Produk</label>
                            <div class="mb-2">
                                <img id="edit-preview-image" src="" class="img-thumbnail" width="200">
                            </div>
                            <input type="file" name="image_path" id="edit-image_path" class="form-control" accept="image/*">
                        </div>

                        <div class="mb-3">
                            <label for="edit-rating" class="form-label">Rating</label>
                            <input type="text" name="rating" id="edit-rating" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-warning fw-bold">Save Update</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Add Testimoni -->
    <div class="modal fade" id="addTestimoniModal" tabindex="-1" aria-labelledby="addTestimoniModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form method="POST" action="{{ route('testimoni.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addTestimoniModalLabel">Add Testimoni</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <div class="mb-3">
                            <label for="add-produk" class="form-label">Nama Produk</label>
                            <input type="text" name="produk" id="add-produk" class="form-control" required minlength="8">
                        </div>

                        <div class="mb-3">
                            <label for="add-nama_pelanggan" class="form-label">Nama Pelanggan</label>
                            <input type="text" name="nama_pelanggan" id="add-nama_pelanggan" class="form-control" required minlength="8">
                        </div>

                        <div class="mb-3">
                            <label for="add-deskripsi" class="form-label">Deskripsi</label>
                            <textarea name="deskripsi" id="add-deskripsi" class="form-control" required maxlength="255"></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="add-image_path" class="form-label">Gambar Produk</label>
                            <input type="file" name="image_path" id="add-image_path" class="form-control" accept="image/*">
                        </div>

                        <div class="mb-3">
                            <label for="add-rating" class="form-label">Rating</label>
                            <input type="text" name="rating" id="add-rating" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-warning fw-bold">Save</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- JavaScript untuk Modal Edit -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.edit-button').forEach(button => {
                button.addEventListener('click', function () {
                    const id = this.dataset.id;
                    const produk = this.dataset.produk;
                    const nama = this.dataset.nama_pelanggan;
                    const deskripsi = this.dataset.deskripsi;
                    const image = this.dataset.image;
                    const rating = this.dataset.rating;
                    const updateUrl = this.dataset.updateUrl;

                    document.getElementById('edit-id').value = id;
                    document.getElementById('edit-produk').value = produk;
                    document.getElementById('edit-nama_pelanggan').value = nama;
                    document.getElementById('edit-deskripsi').value = deskripsi;
                    document.getElementById('edit-preview-image').src = image;
                    document.getElementById('edit-rating').value = rating;

                    // Set action form
                    document.getElementById('editForm').action = updateUrl;

                    const modal = new bootstrap.Modal(document.getElementById('editTestimoniModal'));
                    modal.show();
                });
            });
        });
    </script>
@endsection
