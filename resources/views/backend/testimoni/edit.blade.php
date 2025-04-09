@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Edit Testimoni</h2>

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
        <form action="{{ route('testimoni.update', $testimoni->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="produk" class="form-label">Nama Produk</label>
                <input type="text" name="produk" id="produk" class="form-control" value="{{ $testimoni->produk }}" required minlength="8">
            </div>

            <div class="mb-3">
                <label for="nama_pelanggan" class="form-label">Nama Pelanggan</label>
                <input type="text" name="nama_pelanggan" id="nama_pelanggan" class="form-control" value="{{ $testimoni->nama_pelanggan }}" required minlength="8">
            </div>

            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <textarea name="deskripsi" id="deskripsi" class="form-control" required maxlength="255">{{ $testimoni->deskripsi }}</textarea>
            </div>

            <div class="mb-3">
                <label for="image_path" class="form-label">Gambar Produk</label>

                {{-- Tampilkan gambar lama jika ada --}}
                @if ($testimoni->image_path)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $testimoni->image_path) }}" 
                             alt="Gambar Produk" 
                             class="img-thumbnail" 
                             width="200">
                    </div>
                @endif

                <input type="file" name="image_path" id="image_path" class="form-control" accept="image/*">
            </div>

            <div class="mb-3">
                <label for="rating" class="form-label">Rating</label>
                <input type="text" name="rating" id="rating" class="form-control" value="{{ $testimoni->rating }}" required>
            </div>

            <button type="submit" class="btn btn-warning fw-bold">Save Update</button>
            <a href="{{ route('testimoni.index') }}" class="btn btn-danger">Cancel</a>
        </form>
    </div>
</div>
@endsection
