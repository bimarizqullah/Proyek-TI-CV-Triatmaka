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
        <button class="btn btn-warning mb-3 fw-bold" data-bs-toggle="modal" data-bs-target="#addCatalogModal">+ Add Produk</button>
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
                    <th>Variant</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($catalogs as $katalog)
                <tr>
                    <td>{{ $katalog->id }}</td>
                    <td>
                        <img src="{{ asset('storage/' . $katalog->image_path) }}" alt="Gambar Produk" width="100">
                    </td>
                    <td>{{ $katalog->produk }}</td>
                    <td>{{ $katalog->deskripsi }}</td>
                    <td>{{ $katalog->variant }}</td>
                    <td>
                        <!-- Button untuk memicu modal edit -->
                        <a href="javascript:void(0);" class="btn btn-sm btn-primary fa-solid fa-pen-to-square edit-button"
                            data-bs-toggle="modal" data-bs-target="#editCatalogModal"
                            data-id="{{ $katalog->id }}"
                            data-produk="{{ $katalog->produk }}"
                            data-ukuran="{{ $katalog->ukuran }}"
                            data-deskripsi="{{ $katalog->deskripsi }}"
                            data-variant="{{ $katalog->variant }}"
                            data-harga="{{ $katalog->harga }}"
                            data-image="{{ asset('storage/' . $katalog->image_path) }}">
                        </a>
                        <form action="{{ route('katalog.destroy', $katalog->id) }}" method="POST" class="d-inline delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-sm btn-danger delete-button fa-solid fa-trash" data-katalog-id="{{ $katalog->id }}"></button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <p>Showing {{ $catalogs->count() }} entries</p>
    </div>


    <!-- Modal Add Catalog -->
    <div class="modal fade" id="addCatalogModal" tabindex="-1" aria-labelledby="addCatalogModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form method="POST" action="{{ route('katalog.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addCatalogModalLabel">Tambah Catalog</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <div class="mb-3">
                            <label for="produk" class="form-label">Produk</label>
                            <input type="text" name="produk" id="produk" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="variant" class="form-label">Variant</label>
                            <select name="variant" id="variant" class="form-control" required>
                                <option value="Original">Original</option>
                                <option value="Pedas">Pedas</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea style="resize: none;" name="deskripsi" id="deskripsi" class="form-control" placeholder="Max. 200 karakter" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="image_path" class="form-label">Gambar Produk</label>
                            <input type="file" name="image_path" id="image_path" class="form-control" accept="image/*" required>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-warning fw-bold">Simpan Produk</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit Catalog -->
    <div class="modal fade" id="editCatalogModal" tabindex="-1" aria-labelledby="editCatalogModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="editCatalogForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title" id="editCatalogModalLabel">Edit Catalog</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <input type="hidden" name="id" id="edit-catalog-id">

                        <div class="mb-3">
                            <label for="edit-produk" class="form-label">Produk</label>
                            <input type="text" name="produk" id="edit-produk" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="edit-deskripsi" class="form-label">Deskripsi</label>
                            <textarea name="deskripsi" id="edit-deskripsi" class="form-control" placeholder="Max. 200 karakter" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="edit-variant" class="form-label">Variant</label>
                            <select name="variant" id="edit-variant" class="form-control" required> 
                                <option value="" disabled>-- Pilih Variant --</option>
                                <option value="Original">Original</option>
                                <option value="Pedas">Pedas</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="edit-image_path" class="form-label">Gambar Produk</label>
                            <div class="mb-2">
                                <img id="edit-preview-image" src="" class="img-thumbnail" width="200">
                            </div>
                            <input type="file" name="image_path" id="edit-image_path" class="form-control" accept="image/*">
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

    <script>
         @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Sukses',
                text: '{{ session('success') }}',
                confirmButtonColor: '#ffc107'
            });
        @endif

        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: '{{ session('error') }}',
                confirmButtonColor: '#d33'
            });
        @endif  
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.edit-button').forEach(button => {
                button.addEventListener('click', function () {
                    // Ambil data dari button yang diklik
                    const id = this.dataset.id;
                    const produk = this.dataset.produk;
                    const deskripsi = this.dataset.deskripsi;
                    const image = this.dataset.image;
                    const variant = this.dataset.variant;


                    // Set data ke modal
                    document.getElementById('edit-catalog-id').value = id;
                    document.getElementById('edit-produk').value =  produk;
                    document.getElementById('edit-deskripsi').value = deskripsi;
                    document.getElementById('edit-variant').value = variant;
                    document.getElementById('edit-preview-image').src = image;
                    document.getElementById('editCatalogForm').action = '{{ route('katalog.update', '') }}/' + id;  // Sesuaikan dengan route update katalog
                });
            });
        });

        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.delete-button').forEach(button => {
                button.addEventListener('click', function () {
                    let katalogId = this.getAttribute('data-katalog-id');  // Perbaiki nama atributnya
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
                            form.submit(); // Kirim form jika di-confirm
                        }
                    });
                });
            });
        });
    </script>
@endsection
