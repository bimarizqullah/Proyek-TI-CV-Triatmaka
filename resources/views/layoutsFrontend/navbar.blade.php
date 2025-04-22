<nav id="navbar" class="navbar navbar-expand-lg navbar-light bg-warning fixed-top shadow mx-auto rounded-3 m-3" style="width: 60%; transition: top 0.3s; ">
  <div class="container-fluid">
    <!-- Logo -->
    <a class="navbar-brand d-flex align-items-center" href="#">
      <img src="{{ asset('images/logo.png') }}" width="50px" class="me-3">
    </a>
    <div class="collapse navbar-collapse" id="navMenu">
      <ul class="navbar-nav ms-auto font-apple">
        <li class="nav-item"><a class="nav-link" href="/">Beranda</a></li>
        <li class="nav-item"><a class="nav-link" href="#tentang">Tentang</a></li>
        <li class="nav-item"><a class="nav-link" href="#produk">Produk</a></li>
        <li class="nav-item"><a class="nav-link" href="#kontak">Testimoni</a></li>
        <li class="nav-item"><a class="nav-link" href="#kontak">Hubungi Kami</a></li>
      </ul>
      <form class="d-flex mx-auto rounded-5 shadow-sm" role="search" style="width: 50%">
        <div class="input-group">
          <span class="input-group-text bg-white border-end-0">
            <i class="fa-solid fa-magnifying-glass"></i> <!-- Pakai Bootstrap Icons -->
          </span>
          <input class="form-control border-start-0" type="search" placeholder="Cari produk..." aria-label="Search">
        </div>
      </form>
    </div>
  </div>
</nav>
