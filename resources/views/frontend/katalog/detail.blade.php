@extends('layouts.app')

@section('content')
<div class="container px-0 my-5 border rounded overflow-hidden">
    <div class="row g-0">
        <!-- Gambar Produk -->
        <div class="col-lg-6 col-md-6 col-12 p-0">
            <img src="{{ asset('storage/' . $katalog->image_path) }}"
                alt="{{ $katalog->produk }}"
                class="w-100 h-120"
                style="object-fit: cover; display: block;">
        </div>

        <!-- Detail Produk -->
        <div class="col-md-5 bg-white shadow-sm p-4">
            <h5 class="text-success fw-bold">NEW ARRIVAL</h5>
            <h2 class="fw-bold">{{ $katalog->produk }} ({{$katalog->variant}})</h2>

            <div class="mb-2">
                <span class="text-warning">&#9733; &#9733; &#9733; &#9733; &#9734;</span>
            </div>

            
            <h4 class="fw-bold mb-3"><span id="displayHarga">Rp {{ number_format($katalog->harga->first()->harga ?? 0, 0, ',', '.') }}</span></h4>

            <!-- Tombol Pilih Ukuran -->
            <h5 class="mb-3">Ukuran (gram):</h5>
            <div id="ukuranButtons" class="mb-4">
                @foreach($katalog->harga->unique('ukuran') as $harga)
                    <button 
                        class="btn btn-outline-primary me-2 mb-2 ukuran-btn" 
                        data-ukuran="{{ $harga->ukuran }}">
                        {{ $harga->ukuran }} gr
                    </button>
                @endforeach
            </div>

            <!-- Harga Dinamis -->

            <!-- Deskripsi -->
            <div class="mb-1 mt-4">
                <p>{{ $katalog->deskripsi }}</p>
            </div>

            <!-- Tombol Buy Now -->
            <div class="d-flex mt-4">
                <a id="buyNowBtn" href="https://wa.me/62895395756124" target="_blank" class="btn btn-success">
                    <i class="fa-brands fa-whatsapp mx-3"></i>Buy Now
                </a>
            </div>

            <!-- Tombol Kembali -->
            <div class="mt-4">
                <a href="{{ url()->previous() }}" class="btn btn-link text-decoration-none">&larr; Kembali</a>
            </div>
        </div>
    </div>
</div>

<script>
    const hargaData = @json($katalog->harga);
    const displayHarga = document.getElementById('displayHarga');
    const ukuranButtons = document.querySelectorAll('.ukuran-btn');
    const buyNowBtn = document.getElementById('buyNowBtn');

    let selectedUkuran = null;

    function updateHarga(ukuran) {
        const hargaItem = hargaData.find(item => item.ukuran == ukuran);
        if (hargaItem) {
            const formattedHarga = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(hargaItem.harga);

            displayHarga.textContent = formattedHarga;

            // Update link Buy Now dengan pesan WA sesuai pilihan ukuran dan produk
            const produk = @json($katalog->produk);
            const pesanWA = encodeURIComponent(`Halo, saya ingin pesan produk *${produk}* ukuran *${ukuran} gr* dengan harga *${formattedHarga}*`);
            buyNowBtn.href = `https://wa.me/62895395756124?text=${pesanWA}`;
        }
    }

    ukuranButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            // Hilangkan kelas active dari semua tombol
            ukuranButtons.forEach(b => b.classList.remove('active'));
            // Tambah kelas active ke tombol yang diklik
            btn.classList.add('active');
            selectedUkuran = btn.getAttribute('data-ukuran');
            updateHarga(selectedUkuran);
        });
    });

    // Set tombol pertama sebagai default aktif dan tampilkan harga awal
    if (ukuranButtons.length > 0) {
        ukuranButtons[0].classList.add('active');
        selectedUkuran = ukuranButtons[0].getAttribute('data-ukuran');
        updateHarga(selectedUkuran);
    }
</script>
@endsection
