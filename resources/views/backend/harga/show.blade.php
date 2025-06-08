@extends('layoutsBackend.app')

@section('content')
<div class="price">
    <h2>Harga untuk Produk: {{ $catalog->produk }} ({{$catalog->variant}})</h2>
    <a href="{{ route('harga.index') }}" class="btn btn-secondary mb-3">← Kembali ke daftar katalog</a>
    <button class=" fw-bold btn btn-warning mb-3" data-bs-toggle="modal" data-bs-target="#addHargaModal">+ Tambah Harga</button>

    <table class="table table-bordered">
        <thead class="table-warning">
            <tr>
                <th class="col-md-1">ID</th>
                <th>Ukuran</th>
                <th>Harga</th>
                <th class="col-md-1">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($hargas as $harga)
            <tr>
                <td>{{ $harga->id }}</td>
                <td>{{ $harga->ukuran}}</td>
                <td>{{ number_format($harga->harga, 0, ',', '.') }}</td>
                <td>
                    <button class="btn btn-sm btn-primary fa-solid fa-pen-to-square edit-button"
                        data-id="{{ $harga->id }}"
                        data-ukuran="{{$harga->ukuran}}"
                        data-harga="{{ $harga->harga }}"
                        data-bs-toggle="modal" data-bs-target="#editHargaModal">
                    </button>

                    <form action="{{ route('harga.destroy', $harga->id) }}" method="POST" class="delete-form" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger delete-button fa-solid fa-trash"></button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Modal Tambah Harga -->
</div>
<div class="modal fade" id="addHargaModal" tabindex="-1" aria-labelledby="addHargaModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('harga.store') }}">
                @csrf
                <input type="hidden" name="catalog_id" value="{{ $catalog->id }}">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addHargaModalLabel">Tambah Harga</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <label for="ukuran" class="form-label">Ukuran</label>
                        <select name="ukuran" id="ukuran" class="form-control" required>
                            <option value="" disabled>-- Pilih Ukuran --</option>
                            <option value="80">80g</option>
                            <option value="100">100g</option>                            
                            <option value="250">250g</option>
                            <option value="500">500g</option>
                            <option value="1000">1Kg</option>
                        </select>
                    </div>
                    <div class="modal-body">
                        <label for="harga">Harga</label>
                        <input type="number" name="harga" id="harga" class="form-control" required>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-warning" type="submit">Simpan</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit Harga -->
    <div class="modal fade" id="editHargaModal" tabindex="-1" aria-labelledby="editHargaModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="editHargaForm" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="catalog_id" value="{{ $catalog->id }}">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editHargaModalLabel">Edit Harga</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <label for="edit-ukuran" class="form-label">Ukuran</label>
                        <select name="ukuran" id="edit-ukuran" class="form-control" required>
                            <option value="" disabled>-- Pilih Ukuran --</option>
                            <option value="80">80g</option>
                            <option value="100">100g</option>                            
                            <option value="250">250g</option>
                            <option value="500">500g</option>
                            <option value="1000">1Kg</option>
                        </select>
                    </div>
                    <div class="modal-body">
                        <label for="edit-harga">Harga</label>
                        <input type="number" name="harga" id="edit-harga" class="form-control" required>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-warning" type="submit">Update</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                    </div>
                </div>
            </form>
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
            // Setup tombol edit
            document.querySelectorAll('.edit-button').forEach(button => {
                button.addEventListener('click', function () {
                    const id = this.getAttribute('data-id');
                    const ukuran = this.getAttribute('data-ukuran');
                    const harga = this.getAttribute('data-harga');
                    const form = document.getElementById('editHargaForm');

                    form.action = "{{ url('admin/harga') }}/" + id;
                    form.querySelector('#edit-harga').value = harga;
                    form.querySelector('#edit-ukuran').value = ukuran;
                });
            });

            // Setup tombol hapus
            document.querySelectorAll('.delete-button').forEach(button => {
                button.addEventListener('click', function (e) {
                    e.preventDefault(); // Cegah submit langsung
                    let form = this.closest('.delete-form'); // Ambil form terdekat

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
