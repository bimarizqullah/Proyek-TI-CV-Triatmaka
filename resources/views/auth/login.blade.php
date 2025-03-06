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
        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="mb-3">
                <a href="{{ route('password.forgot') }}">Lupa Password?</a>
            </div>
            <button type="submit" class="btn-submit">Masuk</button>
        </form>
    </div>
</div>
@endsection
