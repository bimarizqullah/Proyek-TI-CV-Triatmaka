<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin | Manis Rejo</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <link rel="stylesheet" href="{{ asset('css/style.css?v=2') }}">
        
        <style>
            /* Membuat body dan wrapper agar footer tetap di bawah */
            body {
                display: flex;
                flex-direction: column;
                min-height: 100vh;
                margin: 0;
            }

            /* Wrapper untuk sidebar dan konten utama */
            .wrapper {
                flex: 1;
                display: flex;
                padding-bottom: 50px; /* Beri ruang untuk footer */
            }

            /* Sidebar */
            .sidebar {
                width: 250px;
                background: #FFC107;
                min-height: 100vh;
                padding: 20px;
            }

            /* Main content */
            .main-content {
                flex: 1;
                padding: 20px;
            }

            /* Footer tetap di bawah dan fixed */
            .footer {
                background: #f8f9fa;
                color: #333;
                text-align: center;
                padding: 10px 0;
                width: 100%;
                position: fixed;
                bottom: 0;
                left: 0;
                box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.1);
            }
        </style>
    </head>
    
    <body>
        <div class="wrapper">
            <!-- Sidebar -->
            @include('layoutsBackend.sidebar')

            <!-- Main Content -->
            <div class="main-content">
                @include('layoutsBackend.navbar')

                @yield('content')
            </div>
        </div>

        <!-- Footer fixed di bawah -->
        @include('layoutsBackend.footer')
    </body>
</html>
