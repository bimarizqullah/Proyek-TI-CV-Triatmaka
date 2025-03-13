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
                    <a href="#" class="nav-link text-dark"> <i class="bi bi-person"></i> Users</a>
                </li>
            </ul>
            <h6 class="text-uppercase text-dark px-3 mt-3">Pages</h6>
            <ul class="nav flex-column px-3">
                <li class="nav-item">
                    <a href="#" class="nav-link text-dark"> <i class="bi bi-folder"></i> Post Categories</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link text-dark"> <i class="bi bi-file-earmark"></i> Posts</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link text-dark"> <i class="bi bi-box"></i> Catalog</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link text-dark"> <i class="bi bi-chat"></i> Testimoni</a>
                </li>
            </ul>
        </nav>

        <!-- Main Content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <!-- Navbar -->
            <nav class="navbar navbar-expand-lg navbar-dark bg-warning shadow rounded-3">
                <div class="container">
                    <img src="{{asset('images/logo.png')}}" width="70px">
            
                    <div class="d-flex">
                        @auth
                            <span class="navbar-text me-3 fw-bold text-dark">
                                {{ Auth::user()->name }}
                            </span>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-dark">Logout</button>
                            </form>
                        @endauth
                    </div>
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
            <div class="mt-4">
                <h2>Users</h2>
                 <a href="{{ route('backend.users.create') }}" class="btn btn-warning mb-3 fw-bold">+ Add User</a>
                <div class="card p-3">
                    <div class="d-flex justify-content-end mb-3">
                        <label>Search: <input type="text" class="form-control form-control-sm"></label>
                    </div>
                    <table class="table table-bordered">
                        <thead class="table-warning">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Password</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->password }}</td>
                                <td>{{ $user->status }}</td>
                                <td>
                                    <a href="{{ route('backend.users.edit', $user->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <p>Showing {{ $users->count() }} entries</p>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection