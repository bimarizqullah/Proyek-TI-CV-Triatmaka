@extends('layouts.app')

@section('content')
<div class="container-fluid m-3">
    <div class="row">
        <!-- Sidebar -->
        <nav class="side-bar col-md-3 col-lg-2 d-md-block bg-warning text-dark sidebar py-4 min-vh-100 rounded-3">
            <div class="text-center">
                <img src="{{ asset('images/logo.png') }}" class="rounded-circle mb-3" width="100">
                <h4 class="fw-bold">{{ Auth::user()->name}}</h4>
                <p>{{Auth::user()->email}}</p>
            </div>
            <hr>
            <h6 class="text-uppercase text-dark px-3">Settings</h6>
            <ul class="nav flex-column px-3">
                <li class="nav-item">
                    <a href="{{ route('backend.users.index') }}" 
                       class="nav-link text-dark {{ request()->is('admin/users*') ? 'active text-white rounded' : '' }}">
                        <i class="bi bi-person"></i> Users
                    </a>
                </li>
            </ul>
            <h6 class="text-uppercase text-dark px-3 mt-3">Pages</h6>
            <ul class="nav flex-column px-3">
                <li class="nav-item">
                    <a href="{{ route('backend.katalog.index') }}" 
                       class="nav-link text-dark {{ request()->is('admin/katalog*') ? 'active text-white rounded' : '' }}">
                        <i class="bi bi-person"></i> Katalog
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link text-dark"> <i class="bi bi-chat"></i> Testimoni</a>
                </li>
            </ul>
        </nav>

        <!-- Main Content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <!-- Navbar -->
            <nav class="navbar navbar-expand-lg bg-warning shadow rounded-3">
                <div class="container">
                    <!-- Logo -->
                    <a class="navbar-brand d-flex align-items-center" href="{{ route('backend.users.index') }}">
                        <img src="{{ asset('images/logo.png') }}" width="50px" class="me-2">    
                    </a>
            
                    <!-- Toggle button for mobile -->
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
            
                    <!-- Navbar Content -->
                    <div class="collapse navbar-collapse justify-content-start" id="navbarNav">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a href="{{ route('backend.users.index') }}" 
                                   class="nav-link text-dark {{ request()->is('admin/users*') ? 'active text-white rounded' : '' }}">
                                    <i class="bi bi-person"></i> Users
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('backend.katalog.index') }}" 
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
            
                    <!-- User Info & Logout -->
                    @auth
                    <div class="d-flex align-items-center">
                        <div class="text-end me-3">
                            <strong class="d-block">{{ Auth::user()->name }}</strong>
                            <small class="text-muted">{{ Auth::user()->email }}</small>
                        </div>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm">Logout</button>
                        </form>
                    </div>
                    @endauth
                </div>
            </nav>            


            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
                    
            <!-- Content -->
            <div class="catalog mt-4">
                <h2>Catalog</h2>
                 <a href="{{ route('backend.katalog.create') }}" class="btn btn-warning mb-3 fw-bold">+ Add Produk</a>
                    <div class="d-flex justify-content-end mb-3">
                        <form method="GET" action="{{ route('backend.katalog.index') }}">
                            <label>Search:
                                <input type="text" name="search" class="form-control form-control-sm" 
                                    value="{{ request('search') }}" placeholder="Cari Produk...">
                            </label>
                            <button type="submit" class="btn btn-primary btn-sm btn-warning">Cari</button>
                        </form>
                    </div>
                    <table class="table table-bordered">
                        <thead class="table-warning">
                            <tr class="text-center">
                                <th>ID</th>
                                <th>Gambar</th>
                                <th>Produk</th>
                                <th>Deskripsi</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($catalog as $katalog)
                            <tr>
                                <td>{{ $katalog->id }}</td>
                                <td>
                                    <img src="{{ asset('storage/' . $katalog->image_path) }}" alt="Gambar Produk" width="100">
                                </td>
                                <td>{{ $katalog->produk }}</td>
                                <td>{{ $katalog->deskripsi }}</td>
                                <td>
                                    <a href="{{ route('backend.katalog.edit', $katalog->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                    <form action="{{ route('katalog.destroy', $katalog->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <p>Showing {{ $katalog->count() }} entries</p>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection