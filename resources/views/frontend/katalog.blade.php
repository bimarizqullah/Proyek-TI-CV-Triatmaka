<section id="produk" class="position-relative py-5"
    style="background-color: #f4d001; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;">
    <img src="{{ asset('images/sapi-kiri.png') }}" class="position-absolute start-0 bottom-0" data-aos="fade-up"
        data-aos-delay="0" data-aos-duration="1000" style="max-height: 130%;">
    <img src="{{ asset('images/sapi-kanan.png') }}" class="position-absolute end-0 bottom-0" data-aos="fade-up"
        data-aos-delay="0" data-aos-duration="1000" style="max-height: 130%;">
    <div class="container">
        <div class="row g-4 justify-content-center">
            <div class="text-center mb-5">
                <h2 class="fw-bold text-dark" data-aos="fade-up" data-aos-delay="100" style="font-size: 2rem;">
                    KATALOG / PRODUK</h2>
            </div>
            @foreach ($katalog as $index => $item)
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="{{ 100 + $index * 100 }}">
                    <div class="bg-white rounded-4 shadow-lg p-3 text-center h-100">
                        <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->produk }}"
                            class="img-fluid mb-3" style="max-height: 250px;">
                        <h5 class="fw-bold text-dark">{{ strtoupper($item->produk) }}</h5>
                        <p class="text-muted" style="font-size: 0.9rem;">{{ $item->deskripsi }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>