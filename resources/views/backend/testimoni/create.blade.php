@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>Add New Product</h2>

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
        <form action="{{ route('testimoni.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="produk" class="form-label">Nama Produk</label>
                <input type="text" name="produk" id="produk" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="nama_pelanggan" class="form-label">Nama Pelanggan</label>
                <input type="text" name="nama_pelanggan" id="nama_pelanggan" class="form-control" required>
            </div>
        
            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <textarea name="deskripsi" id="deskripsi" class="form-control" rows="3" required></textarea>
            </div>
        
            <div class="mb-3">
                <label for="image_path" class="form-label">Gambar Produk</label>
                <input type="file" name="image_path" id="image_path" class="form-control" accept="image/*" required>
            </div>

            <div class="mb-3">
                <label for="rating" class="form-label">Rating</label>
                <input type="text" name="rating" id="rating" class="form-control" required>
            </div>
        
            <button type="submit" class="btn btn-warning fw-bold">Simpan</button>
            <a href="{{ route('testimoni.index') }}" class="btn btn-danger fw-bold">Cancel</a>
        </form>
    </div>
</div>
@endsection
