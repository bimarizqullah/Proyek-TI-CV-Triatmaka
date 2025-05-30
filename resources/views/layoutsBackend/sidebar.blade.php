<nav class="side-bar col-md-3 col-lg-2 d-md-block bg-warning text-dark sidebar py-4 min-vh-100 ">
    <div class="text-center">
        <img src="{{ Auth::user()->image_path ? asset('storage/' . Auth::user()->image_path) : asset('storage/profile/default.png') }}"
        class="rounded-circle mb-3" width="150" height="150" alt="Profile Picture">
        <h4 class="fw-bold">{{ Auth::user()->name }}</h4>
        <p class="pr-2">{{ Auth::user()->email }}</p>
    </div>
    <hr>
    <h6 class="text-uppercase text-dark px-3">Settings</h6>
    <ul class="nav flex-column px-3">
        <li class="nav-item">
            <a href="{{ route('profile.index') }}" 
               class="nav-link text-dark {{ request()->is('admin/profile*') ? 'active text-white rounded' : '' }}">
                <i class="bi bi-person fa-solid fa-user"></i> Profile
            </a>
        </li>
        @if(Auth::user()->level === 'superadmin') 
        <li class="nav-item">
            <a href="{{ route('users.index') }}" 
               class="nav-link text-dark {{ request()->is('admin/users*') ? 'active text-white rounded' : '' }}">
                <i class="bi bi-person fa-solid fa-user"></i> Users
            </a>
        </li> <!-- Hanya muncul jika user adalah Super Admin -->
        @endif
        
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
            <a href="{{ route('testimoni.index') }}" 
               class="nav-link text-dark {{ request()->is('admin/testimoni*') ? 'active text-white rounded' : '' }}">
                <i class="bi bi-person fa-solid fa-briefcase"></i> Testimoni
            </a>
        </li>
        <li class="nav-item">
            <a href="{{route ('harga.index')}}" 
               class="nav-link text-dark {{ request()->is('admin/harga*') ? 'active text-white rounded' : '' }}">
                <i class="bi bi-person fa-solid fa-briefcase"></i> Harga
            </a>
        </li>
    </ul>
</nav>
