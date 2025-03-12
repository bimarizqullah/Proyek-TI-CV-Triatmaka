@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-center align-items-center min-vh-100 position-relative" 
    style="background: url('{{ asset('images/bg.jpg') }}') no-repeat center center; background-size: cover;">
    
    <!-- Overlay Blur untuk Efek Transparan -->
    <div class="position-absolute top-0 start-0 w-100 h-100" 
        style="backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px); z-index: 1;">
    </div>

    <!-- Login Container -->
    <div class="login-container position-relative z-2">
        <div class="row shadow rounded-4 overflow-hidden bg-white" style="max-width: 900px; margin: auto;">
            
            <!-- Bagian Kiri (Logo & Branding) -->
            <div class="login-left col-md-6 col-12 d-flex flex-column justify-content-center align-items-center p-4 text-center"
                style="background: linear-gradient(to right, #ffcc00, #00aa00);">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="img-fluid" style="max-width: 50%;">
            </div>

            <!-- Bagian Kanan (Form Login) -->
            <div class="login-right col-md-6 col-12 p-5">
                <h2 class="text-center m-3 fw-bold">LOGIN</h2>

                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>

                    <div class="mb-5">
                        <label class="form-label">Password</label>
                        <div class="input-group">
                            <input type="password" id="password" name="password" class="form-control" required>
                            <button type="button" class="btn btn-outline-secondary" id="togglePassword">
                                <i class="bi bi-eye-slash">👁</i>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-warning mb-3 w-100 shadow">Masuk</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Script untuk Toggle Password -->
<script>
document.getElementById('togglePassword').addEventListener('click', function () {
    let passwordField = document.getElementById('password');
    let icon = this.querySelector('i');

    if (passwordField.type === 'password') {
        passwordField.type = 'text';
        icon.classList.replace('bi-eye-slash', 'bi-eye');
    } else {
        passwordField.type = 'password';
        icon.classList.replace('bi-eye', 'bi-eye-slash');
    }
});
</script>

@endsection
