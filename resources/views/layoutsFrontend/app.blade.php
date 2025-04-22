<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CV Triatmaka | Manis Rejo</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body { font-family: 'Segoe UI', sans-serif; }
        .hero { background: url('/images/hero-bg.jpg') no-repeat center; background-size: cover; color: white; padding: 100px 0; }
        .product-img { height: 250px; object-fit: contain; }
    </style>
</head>
<body>

    @include('layoutsFrontend.navbar')

    <main class="container-fluid p-0">
        @yield('content')
    </main>

    @include('layoutsFrontend.footer')

</body>
</html>
