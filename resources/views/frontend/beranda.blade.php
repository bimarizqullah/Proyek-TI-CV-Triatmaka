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

        window.addEventListener("scroll", function () {
            const gradient = document.getElementById("scrollGradient");
            const scrollPos = window.scrollY;
            if (scrollPos > 50) {
                gradient.style.opacity = 1;
            } else {
                gradient.style.opacity = 0;
            }
        });
    </script>

@endsection