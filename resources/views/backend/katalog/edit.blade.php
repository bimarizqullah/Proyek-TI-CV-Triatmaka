@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Edit User</h2>

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
                <input type="text" name="produk" id="produk" class="form-control" value="{{ $katalog->produk }}" required>
            </div>
        
            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <textarea name="deskripsi" id="deskripsi" class="form-control" required>{{ $katalog->deskripsi }}</textarea>
            </div>
        
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
        
    </div>
</div>
@endsection
