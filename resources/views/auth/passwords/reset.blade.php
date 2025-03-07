@extends('layouts.app')

@section('content')
<div class="background-blur"></div>
<div class="reset-container">
    <!-- Bagian Kiri (Logo & Branding) -->
    <div class="reset-left">
        <img src="{{ asset('images/logo.png') }}" alt="Logo">
    </div>

    <!-- Bagian Kanan (Form forgot) -->
    <div class="reset-right">
        <h1>Lupa Password</h1>
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
        <form action="{{ url('admin/password/reset') }}" method="POST">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Password Baru</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>
            <button type="submit" class="btn-submit">Reset Password</button>
        </form>
    </div>
</div>
@endsection

