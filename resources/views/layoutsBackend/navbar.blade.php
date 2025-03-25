<nav class="navbar navbar-expand-lg bg-warning shadow rounded-3">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="{{ route('backend.users.index') }}">
            <img src="{{ asset('images/logo.png') }}" width="50px" class="me-2">    
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-start" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a href="{{ route('backend.users.index') }}" 
                       class="nav-link text-dark {{ request()->is('admin/users*') ? 'active text-white rounded' : '' }}">
                        <i class="bi bi-person"></i> Users
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('katalog.index') }}" 
                       class="nav-link text-dark {{ request()->is('admin/katalog*') ? 'active text-white rounded' : '' }}">
                        <i class="bi bi-person"></i> Katalog
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('backend/testimoni*') ? 'active' : '' }}" href="#">
                        <i class="bi bi-chat"></i> Testimoni
                    </a>
                </li>
            </ul>
        </div>

        @auth
        <div class="d-flex align-items-center">
            <div class="text-end me-3">
                <strong class="d-block">{{ Auth::user()->name }}</strong>
                <small class="text-muted">{{ Auth::user()->email }}</small>
            </div>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-inline">
                @csrf
                <button type="button" class="btn btn-danger btn-sm" id="logout-button">Logout</button>
            </form>
        </div>

        <script>
            document.getElementById('logout-button').addEventListener('click', function(event) {
                event.preventDefault();
                Swal.fire({
                    title: "Apakah Anda yakin?",
                    text: "Anda akan keluar dari akun ini.",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#ffc107",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Ya, logout"
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('logout-form').submit();
                    }
                });
            });
        </script>
        @endauth
    </div>
</nav>
