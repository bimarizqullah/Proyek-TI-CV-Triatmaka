@extends('layouts.app')

@section('content')
<div class="container px-0 my-5 border rounded overflow-hidden">
    <div class="row g-0">
        <!-- Left Side - Gambar Produk -->
        <div class="col-lg-6 col-md-6 col-12 p-0">
            <img src="{{ asset('storage/' . $katalog->image_path) }}"
                alt="{{ $katalog->produk }}"
                class="w-100 h-120"
                style="object-fit: cover; display: block;">
        </div>

        <!-- Right Side - Detail Produk -->
        <div class="col-md-5 bg-white shadow-sm p-4">
            <h5 class="text-success fw-bold">NEW ARRIVAL</h5>
            <h2 class="fw-bold">{{ $katalog->produk }}</h2>

            <div class="mb-2">
                <span class="text-warning">&#9733; &#9733; &#9733; &#9733; &#9734;</span>
            </div>

            <h3 class="text-danger fw-bold mb-4">Rp {{ number_format(899000, 0, ',', '.') }}</h3>

            <p class="mb-1 fw-semibold">Pilih Rasa</p>
            <div class="d-flex gap-2 mb-3">
                @foreach(['Original' , 'Pedas'] as $color)
                <button class="btn btn-outline-secondary btn-sm">{{ $color }}</button>
                @endforeach
            </div>

            <p class="mb-1 fw-semibold">Pilih Ukuran</p>
            <div class="d-flex gap-2 mb-3">
                @foreach(['500g', '750g' , '1kg'] as $size)
                <button class="btn btn-outline-dark btn-sm">{{ $size }}</button>
                @endforeach
            </div>

            <div class="mb-1">
                <p class="mt-4">{{ $katalog->deskripsi }}</p>
                <p class="mt-4">- original </p>
                <p>- pedas </p>
            </div>

            <div class="d-flex gap-2 mt-4">
                <button class="btn btn-primary px-4">Buy Now</button>
            </div>

            <div class="mt-4">
                <a href="{{ url()->previous() }}" class="btn btn-link text-decoration-none">&larr; Kembali</a>
            </div>
        </div>
    </div>
</div>
<style>
.row.g-0 {
    height: 100%;
    min-height: 600px; /* atau sesuai tinggi ideal */
}
</style>
@endsection