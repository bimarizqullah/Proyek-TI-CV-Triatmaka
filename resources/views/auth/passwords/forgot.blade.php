@extends('layouts.app')

@section('content')
<div class="background-blur"></div>
<div class="forgot-container">
    <!-- Bagian Kiri (Logo & Branding) -->
    <div class="forgot-left">
        <img src="{{ asset('images/logo.png') }}" alt="Logo">
    </div>

    <!-- Bagian Kanan (Form forgot) -->
    <div class="forgot-right">
        <h1>Lupa Password</h1>
        @if (session('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
        @endif
        <form action="{{ url('admin/password/forgot') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <button type="submit" class="btn-submit">Kirim Link Reset</button>
            <button type="submit" onclick="window.location.href='{{ route('login') }}'" class="btn-cancel">Batalkan</button>
        </form>
    </div>
</div>
@endsection

