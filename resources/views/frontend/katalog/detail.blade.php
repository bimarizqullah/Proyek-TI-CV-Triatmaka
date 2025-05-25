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

            <!-- Harga Dinamis -->
            <h3 class="text-danger fw-bold mb-4" id="hargaProduk">Rp {{ number_format(899000, 0, ',', '.') }}</h3>

            <!-- Pilih Rasa -->
            <p class="mb-1 fw-semibold">Pilih Rasa</p>
            <div class="d-flex gap-2 mb-3">
                @foreach(['Original', 'Pedas'] as $rasa)
                <button class="btn btn-outline-secondary btn-sm rasa-btn" data-value="{{ $rasa }}">{{ $rasa }}</button>
                @endforeach
            </div>

            <!-- Pilih Ukuran -->
            <p class="mb-1 fw-semibold">Pilih Ukuran</p>
            <div class="d-flex gap-2 mb-3">
                @foreach(['500g', '750g', '1kg'] as $ukuran)
                <button class="btn btn-outline-dark btn-sm ukuran-btn" data-value="{{ $ukuran }}">{{ $ukuran }}</button>
                @endforeach
            </div>

            <!-- Deskripsi -->
            <div class="mb-1">
                <p class="mt-4">{{ $katalog->deskripsi }}</p>
                <p class="mt-4">- Sapi</p>
                <p>- Ayam</p>
                <p>- Lele</p>
                <p>- Original & Pedas</p>
            </div>

            <!-- Tombol Buy Now -->
            <div class="d-flex mt-4">
                <a href="https://wa.me/62895395756124" target="_blank" class="btn btn-success">
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

<!-- CSS -->
<style>
    .row.g-0 {
        height: 100%;
        min-height: 600px;
    }

    .btn.active {
        background-color: #0d6efd;
        color: white;
        border-color: #0d6efd;
    }
</style>

<!-- Data Harga dan Script -->
@php
$hargaVarian = [
'Sapi' => [
'Original' => [
'500g' => 899000,
'750g' => 1049000,
'1kg' => 1199000,
],
'Pedas' => [
'500g' => 909000,
'750g' => 1059000,
'1kg' => 1209000,
],
],
'Ayam' => [
'Original' => [
'500g' => 799000,
'750g' => 949000,
'1kg' => 1099000,
],
'Pedas' => [
'500g' => 809000,
'750g' => 959000,
'1kg' => 1109000,
],
],
'Lele' => [
'Original' => [
'500g' => 699000,
'750g' => 849000,
'1kg' => 999000,
],
'Pedas' => [
'500g' => 709000,
'750g' => 859000,
'1kg' => 1009000,
],
],
];
@endphp

<script>
    const hargaVarian = @json($hargaVarian);

    let selectedProduk = null;
    let selectedRasa = null;
    let selectedUkuran = null;

    const hargaEl = document.getElementById('hargaProduk');

    // Format Rupiah
    const formatRupiah = (angka) => {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(angka);
    };

    // Tambah fungsi update tombol aktif
    function setActiveButton(buttons, clickedButton) {
        buttons.forEach(btn => btn.classList.remove('active'));
        clickedButton.classList.add('active');
    }

    // Event klik produk
    const produkButtons = document.querySelectorAll('.produk-btn');
    produkButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            selectedProduk = this.dataset.value;
            setActiveButton(produkButtons, this);
            updateHarga();
        });
    });

    // Event klik rasa
    const rasaButtons = document.querySelectorAll('.rasa-btn');
    rasaButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            selectedRasa = this.dataset.value;
            setActiveButton(rasaButtons, this);

            // Pilih otomatis ukuran default (misalnya 500g)
            selectedUkuran = '500g';
            ukuranButtons.forEach(ukuranBtn => {
                if (ukuranBtn.dataset.value === '500g') {
                    ukuranBtn.classList.add('active');
                } else {
                    ukuranBtn.classList.remove('active');
                }
            });

            updateHarga();
        });
    });


    // Event klik ukuran
    const ukuranButtons = document.querySelectorAll('.ukuran-btn');
    ukuranButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            selectedUkuran = this.dataset.value;
            setActiveButton(ukuranButtons, this);
            updateHarga();
        });
    });

    function updateHarga() {
        if (selectedProduk && selectedRasa && selectedUkuran) {
            const harga = hargaVarian[selectedProduk][selectedRasa][selectedUkuran];
            hargaEl.textContent = formatRupiah(harga);
        }
    }
</script>

@endsection