<section id="produk" class="position-relative py-5" style="background-color: #f4d001;">
    <img src="{{ asset('images/sapi-kiri.png') }}" class="position-absolute start-0 bottom-0" data-aos="fade-up"
        data-aos-delay="0" data-aos-duration="1000" style="max-height: 100%;">
    <div class="container position-relative z-2" data-aos="fade-up" data-aos-duration="200">
        <h1 class="text-right fw-bold mb-5 text-dark" data-aos="zoom-in" data-aos-delay="200"
            style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Oxygen', 'Ubuntu', 'Cantarell', 'Fira Sans', 'Droid Sans', sans-serif; font-size: 2.5rem;">
            TESTIMONI
        </h1>
        <div class="row g-4 justify-content-center">
            @foreach ($testimoni as $index => $item)

            <div class="col-md-4" data-aos="fade-up" data-aos-delay="{{ 100 + $index * 100 }}">
                <div class="bg-white rounded-4 shadow-lg text-center h-100 card-hover">
                    <div class="image-container mb-3 position-relative">
                        <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->produk }}"
                            class="img-fluid rounded-4">
                        <div class="overlay-text">
                            <h5 class="fw-bold text-light judul-produk">{{ strtoupper($item->nama_pelanggan) }}</h5>
                            <h6 class="text-light" style="font-size: 0.9rem;">Produk: {{ $item->catalog->produk }}</h6>
                            <p class="text-light">{{($item->deskripsi) }}</p>
                            <p class="text-light" style="font-size: 0.9rem;">
                                @php
                                $fullStars = floor($item->rating); // Berapa bintang penuh
                                $halfStar = ($item->rating - $fullStars) >= 0.5 ? true : false; // Ada setengah bintang?
                                $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0); // Sisanya kosong
                                @endphp

                                {{-- Bintang penuh --}}
                                @for ($i = 0; $i < $fullStars; $i++)
                                    <i class="fas fa-star text-warning"></i>
                                    @endfor

                                    {{-- Setengah bintang --}}
                                    @if ($halfStar)
                                    <i class="fas fa-star-half-alt text-warning"></i>
                                    @endif

                                    {{-- Bintang kosong --}}
                                    @for ($i = 0; $i < $emptyStars; $i++)
                                        <i class="far fa-star text-warning"></i>
                                        @endfor
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            @endforeach
        </div>
    </div>
</section>