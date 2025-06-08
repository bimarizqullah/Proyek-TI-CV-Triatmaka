@extends('layoutsBackend.app')

@section('content')
    <div class="price row">
        <h2 class="mb-4">Pilih Katalog</h2>
        @foreach ($catalogs as $catalog)
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    @if ($catalog->image_path)
                        <img src="{{ asset('storage/' . $catalog->image_path) }}" class="card-img-top" alt="Gambar Produk"
                            style="height: 200px; object-fit: cover;">
                    @endif
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $catalog->produk }}</h5>
                        <p class="card-text text-truncate" style="max-height: 3rem;">{{ $catalog->variant }}</p>
                        <a href="{{ route('harga.show', $catalog->id) }}" class="btn btn-warning mt-auto">Lihat Harga</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
