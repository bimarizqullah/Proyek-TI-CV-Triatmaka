@extends ('layoutsFrontend.app')

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <div id="beranda" class="position-relative" data-aos="fade-in" data-aos-duration="1000">
        <div class="d-flex justify-content-center align-items-center min-vh-100 position-relative"
            style="background-color: #f4d001; background: url('{{ asset('images/bg.jpg') }}') no-repeat center center; background-size: cover;">
            <div class="position-absolute bottom-0 start-0 w-100"
                style="height: 80px; background: linear-gradient(to bottom, rgba(255, 255, 230, 0) 0%, #f4d001 90%); opacity: 1; transition: opacity 0.5s ease; z-index: 3;">
            </div>
            <div id="scrollGradient" class="position-absolute bottom-0 start-0 w-100"
                style="height: 100%; background: linear-gradient(to bottom, rgba(255, 255, 230, 0) 0%, #f4d001 90%); opacity: 0; transition: opacity 0.5s ease; z-index: 3;">
            </div>
        </div>
        @include('frontend.tentang')
        @include('frontend.katalog')
        @include('frontend.testimoni')
    </div>
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init();

        window.addEventListener("scroll", function() {
            const gradient = document.getElementById("scrollGradient");
            const scrollPos = window.scrollY;
            gradient.style.opacity = scrollPos > 50 ? 1 : 0;
        });

        const searchForm = document.querySelector("form[role='search']");
        const searchInput = searchForm.querySelector("input[type='search']");

        function resetSections() {
            document.querySelectorAll('.search-section').forEach(section => {
                section.style.display = 'block';
            });
        }

        function handleSearch(keyword) {
            let foundIn = null;

            // Produk
            const produkItems = document.querySelectorAll('.produk-item');
            produkItems.forEach(item => {
                const data = item.dataset.produk || '';
                item.style.display = data.includes(keyword) ? 'block' : 'none';
                if (data.includes(keyword)) foundIn = 'produk';
            });

            // Testimoni
            const testiItems = document.querySelectorAll('.testimoni-item');
            testiItems.forEach(item => {
                const data = item.dataset.testimoni || '';
                item.style.display = data.includes(keyword) ? 'block' : 'none';
                if (data.includes(keyword)) foundIn = 'testimoni';
            });

            // Tentang
            const tentangSection = document.getElementById('tentang');
            const tentangText = tentangSection.innerText.toLowerCase();
            if (tentangText.includes(keyword)) {
                foundIn = 'tentang';
            }

            // Sembunyikan semua section dulu
            document.querySelectorAll('.search-section').forEach(section => {
                section.style.display = 'none';
            });

            // Tampilkan yang ditemukan
            if (foundIn) {
                document.getElementById(foundIn).style.display = 'block';
                document.getElementById(foundIn).scrollIntoView({
                    behavior: 'smooth'
                });
            } else {
                alert("Tidak ditemukan.");
            }
        }

        // Submit pencarian (tekan Enter)
        searchForm.addEventListener("submit", function(e) {
            e.preventDefault();
            const keyword = searchInput.value.trim().toLowerCase();
            if (!keyword) {
                resetSections();
            } else {
                handleSearch(keyword);
            }
        });

        // Reset otomatis saat input dikosongkan
        searchInput.addEventListener("input", function() {
            const keyword = this.value.trim().toLowerCase();
            if (!keyword) {
                resetSections();
            }
        });

        // 👉 Tambahkan ini agar saat halaman dimuat, semua section muncul
        document.addEventListener("DOMContentLoaded", function() {
            resetSections();
        });
    </script>
@endsection
