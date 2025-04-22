<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CV Triatmaka | Manis Rejo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="{{ asset('css/style.css?v=2') }}">
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <!-- AOS JS -->
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
        }

        .hero {
            background: url('/images/bg.jpg') no-repeat center;
            background-size: cover;
            color: white;
            padding: 100px 0;
        }

        .product-img {
            height: 250px;
            object-fit: contain;
        }
    </style>
</head>
<body>
    <main class="container-fluid p-0">
        @include('layoutsFrontend.navbar')
        @yield('content')
    </main>
    @include('layoutsFrontend.footer')
</body>
</html>
<script>
    let prevScrollPos = window.pageYOffset;
    const navbar = document.getElementById("navbar");
    window.onscroll = function () {
        const currentScrollPos = window.pageYOffset;

        if (prevScrollPos > currentScrollPos) {
            // Scroll ke atas → tampilkan navbar
            navbar.style.top = "0";
        } else {
            // Scroll ke bawah → sembunyikan navbar
            navbar.style.top = "-100px"; // Bisa sesuaikan dengan tinggi navbar
        }
        prevScrollPos = currentScrollPos;
    };
</script>