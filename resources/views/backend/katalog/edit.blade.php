@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Edit Catalog</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card p-4">
        <form action="{{ route('katalog.update', $katalog->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="produk" class="form-label">Nama Produk</label>
                <input type="text" name="produk" id="produk" class="form-control" value="{{ $katalog->produk }}" required minlength="8">
            </div>

            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <textarea name="deskripsi" id="deskripsi" class="form-control" required maxlength="255">{{ $katalog->deskripsi }}</textarea>
            </div>

            <div class="mb-3">
                <label for="image_path" class="form-label">Gambar Produk</label>

                {{-- Tampilkan gambar lama jika ada --}}
                @if ($katalog->image_path)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $katalog->image_path) }}" 
                             alt="Gambar Produk" 
                             class="img-thumbnail" 
                             width="200">
                    </div>
                @endif

                <input type="file" name="image_path" id="image_path" class="form-control" accept="image/*">
            </div>

            <button type="submit" class="btn btn-warning fw-bold">Save Update</button>
            <a href="{{ route('katalog.index') }}" class="btn btn-danger">Cancel</a>
        </form>
    </div>
</div>
@endsection
