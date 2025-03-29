<nav class="side-bar col-md-3 col-lg-2 d-md-block bg-warning text-dark sidebar py-4 min-vh-100 rounded-3">
    <div class="text-center">
        <img src="{{ asset('images/logo.png') }}" class="rounded-circle mb-3" width="100">
        <h4 class="fw-bold">{{ Auth::user()->name }}</h4>
        <p>{{ Auth::user()->email }}</p>
    </div>
    <hr>
    <h6 class="text-uppercase text-dark px-3">Settings</h6>
    <ul class="nav flex-column px-3">
        <li class="nav-item">
            <a href="{{ route('backend.users.index') }}" 
               class="nav-link text-dark {{ request()->is('admin/users*') ? 'active text-white rounded' : '' }}">
                <i class="bi bi-person fa-solid fa-user"></i> Users
            </a>
        </li>
    </ul>
    <h6 class="text-uppercase text-dark px-3 mt-3">Pages</h6>
    <ul class="nav flex-column px-3">
        <li class="nav-item">
            <a href="{{ route('katalog.index') }}" 
               class="nav-link text-dark {{ request()->is('admin/katalog*') ? 'active text-white rounded' : '' }}">
                <i class="bi bi-person fa-solid fa-briefcase"></i> Katalog
            </a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link text-dark"> <i class="bi bi-person fa-solid fa-face-smile"></i> Testimoni</a>
        </li>
    </ul>
</nav>
