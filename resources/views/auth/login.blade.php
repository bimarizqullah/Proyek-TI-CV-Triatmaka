@extends('layouts.app')

@section('content')
<div class="background-blur"></div>
<div class="login-container">
   
    <!-- Bagian Kiri (Logo & Branding) -->
    <div class="login-left">
        <img src="{{ asset('images/logo.png') }}" alt="Logo">
    </div>

    <!-- Bagian Kanan (Form Login) -->
    <div class="login-right">
        <h1>LOGIN</h1>
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
            <div class="mb-3">
                <label class="form-label">Password</label>
                <div class="input-group">
                    <input type="password" id="password" name="password" class="form-control" required>
                    <button type="button" class="btn-show-password" id="togglePassword">
                        👁
                    </button>
                </div>
            </div>
            <button type="submit" class="btn-submit">Masuk</button>
        </form>
    </div>
</div>

<script>
document.getElementById('togglePassword').addEventListener('click', function () {
    let passwordField = document.getElementById('password');
    passwordField.type = passwordField.type === 'password' ? 'text' : 'password';
});
</script>
@endsection
