@extends('layouts.app')

@section('content')
    <div style="background-color:rgb(248, 204, 43); min-height: 100vh;"
        class="d-flex align-items-center justify-content-center py-5">
        
        <img src="{{ asset('images/sapi-kanan.png') }}" class="position-absolute end-0 bottom-0" data-aos="fade-up"
            data-aos-delay="0" data-aos-duration="1000" style="max-height: 110%;">
        <img src="{{ asset('images/sapi-kiri.png') }}" class="position-absolute start-0 bottom-0" data-aos="fade-up"
            data-aos-delay="0" data-aos-duration="1000" style="max-height: 100%;">
        <div class="detail container border rounded-4 shadow-lg bg-white overflow-hidden" style="max-width: 1200px;">
            <div class="row g-0">
                <!-- Gambar Produk -->
                <div class="col-lg-6 col-md-6 col-12 p-4 bg-light d-flex align-items-center justify-content-center">
                    <img src="{{ asset('storage/' . $katalog->image_path) }}" alt="{{ $katalog->produk }}"
                        class="img-fluid rounded-3 shadow-sm" style="max-height: 500px; object-fit: cover;">
                </div>

                <!-- Detail Produk -->
                <div class="col-md-6 p-5">
                    <h6 class="text-success fw-semibold mb-2">NEW ARRIVAL</h6>
                    <h2 class="fw-bold mb-3 text-dark">{{ $katalog->produk }} <small
                            class="text-muted">({{ $katalog->variant }})</small></h2>

                    <div class="mb-3">
                        <span class="text-warning fs-5">&#9733; &#9733; &#9733; &#9733; &#9734;</span>
                    </div>

                    <h4 class="fw-bold text-danger mb-4"><span id="displayHarga">Rp
                            {{ number_format($katalog->harga->first()->harga ?? 0, 0, ',', '.') }}</span></h4>

                    <!-- Pilihan Ukuran -->
                    <h5 class="mb-3">Ukuran (gram):</h5>
                    <div id="ukuranButtons" class="mb-4">
                        @foreach ($katalog->harga->unique('ukuran') as $harga)
                            <button class="btn btn-outline-primary me-2 mb-2 ukuran-btn rounded-pill px-4 py-2 fw-medium"
                                data-ukuran="{{ $harga->ukuran }}">
                                {{ $harga->ukuran }} gr
                            </button>
                        @endforeach
                    </div>

                    <!-- Deskripsi -->
                    <div class="mb-4">
                        <p class="text-secondary" style="line-height: 1.7;">{{ $katalog->deskripsi }}</p>
                    </div>

                    <!-- Tombol Buy Now -->
                    <a id="buyNowBtn" href="https://wa.me/62895395756124" target="_blank"
                        class="btn btn-success btn-lg rounded-pill px-4">
                        <i class="fa-brands fa-whatsapp me-2"></i>Buy Now
                    </a>

                    <!-- Kembali -->
                    <div class="mt-4">
                        <a href="{{ url()->previous() }}" class="btn btn-link text-decoration-none text-muted">
                            &larr; Kembali
                        </a>
                    </div>
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

                const produk = @json($katalog->produk);
                const pesanWA = encodeURIComponent(
                    `Halo, saya ingin pesan produk *${produk}* ukuran *${ukuran} gr* dengan harga *${formattedHarga}*`);
                buyNowBtn.href = `https://wa.me/62895395756124?text=${pesanWA}`;
            }
        }

        ukuranButtons.forEach(btn => {
            btn.addEventListener('click', () => {
                ukuranButtons.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                selectedUkuran = btn.getAttribute('data-ukuran');
                updateHarga(selectedUkuran);
            });
        });

        if (ukuranButtons.length > 0) {
            ukuranButtons[0].classList.add('active');
            selectedUkuran = ukuranButtons[0].getAttribute('data-ukuran');
            updateHarga(selectedUkuran);
        }
    </script>
@endsection
