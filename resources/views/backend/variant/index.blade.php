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
        <h2>Variant</h2>
        <button class="btn btn-warning mb-3 fw-bold" data-bs-toggle="modal" data-bs-target="#addVariantModal">+ Add
            Variant</button>
        <div class="d-flex justify-content-end mb-3">
            <form method="GET" action="{{ route('variant.index') }}">
                <label>Search:
                    <input type="text" name="search" class="form-control form-control-sm" value="{{ request('search') }}"
                        placeholder="Cari Produk...">
                </label>
                <button type="submit" class="btn btn-primary btn-sm btn-warning">Cari</button>
            </form>
        </div>
        <table class="table table-bordered">
            <thead class="table-warning">
                <tr class="text-center">
                    <th>ID</th>
                    <th>Varian</th>
                    <th>Ukuran</th>
                    <th>Harga</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($variants as $variant)
                    <tr>
                        <td>{{ $variant->id }}</td>
                        <td>{{ $variant->variant }}</td>
                        <td>{{ $variant->ukuran }}</td>
                        <td>{{ $variant->harga }}</td>
                        <td>
                            <!-- Button untuk memicu modal edit -->
                            <a href="javascript:void(0);" class="btn btn-sm btn-primary fa-solid fa-pen-to-square edit-button"
                                data-bs-toggle="modal" data-bs-target="#editVariantModal" data-id="{{ $variant->id }}"
                                data-variant="{{ $variant->variant }}" data-ukuran="{{ $variant->ukuran }}"
                                data-harga="{{ $variant->harga }}">
                            </a>
                            <form action="{{ route('variant.destroy', $variant->id) }}" method="POST"
                                class="d-inline delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-sm btn-danger delete-button fa-solid fa-trash"
                                    data-variant-id="{{ $variant->id }}"></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <p>Showing {{ $variants->count() }} entries</p>
    </div>


    <!-- Modal Add Catalog -->
    <div class="modal fade" id="addVariantModal" tabindex="-1" aria-labelledby="addVariantModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form method="POST" action="{{ route('variant.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addVariantModalLabel">Tambah Variant</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <div class="mb-3">
                            <label for="variant" class="form-label">Variant</label>
                            <input type="text" name="variant" id="variant" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="ukuran" class="form-label">Ukuran</label>
                            <select name="ukuran" id="ukuran" class="form-control" required>
                                <option value="500">500g</option>
                                <option value="750">750g</option>
                                <option value="1">1Kg</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="harga" class="form-label">Harga</label>
                            <input type="number" name="harga" id="harga" class="form-control" required>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-warning fw-bold">Simpan Variant</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit Catalog -->
    <div class="modal fade" id="editVariantModal" tabindex="-1" aria-labelledby="editVariantModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="editCatalogForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title" id="editVariantModalLabel">Edit Catalog</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <input type="hidden" name="id" id="edit-variant-id">

                        <div class="mb-3">
                            <label for="edit-variant" class="form-label">Variant</label>
                            <input type="text" name="variant" id="edit-variant" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="edit-ukuran" class="form-label">Deskripsi</label>
                            <textarea name="deskripsi" id="edit-ukuran" class="form-control"
                                placeholder="Max. 200 karakter" required></textarea>
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
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.edit-button').forEach(button => {
                button.addEventListener('click', function () {
                    // Ambil data dari button yang diklik
                    const id = this.dataset.id;
                    const variant = this.dataset.variant;
                    const ukuran = this.dataset.ukuran;
                    const harga = this.dataset.harga;

                    // Set data ke modal
                    document.getElementById('edit-variant-id').value = id;
                    document.getElementById('edit-variant').value = produk;
                    document.getElementById('edit-ukuran').value = deskripsi;
                    document.getElementById('edit-preview-image').src = image;

                    // Set action form
                    document.getElementById('editCatalogForm').action = '{{ route('variant.update', '') }}/' + id;  // Sesuaikan dengan route update variant
                });
            });
        });

        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.delete-button').forEach(button => {
                button.addEventListener('click', function () {
                    let variantId = this.getAttribute('data-variant-id');  // Perbaiki nama atributnya
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