
@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1>Selamat Datang di Dashboard</h1>
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-danger">Logout</button>
    </form>
</div>
@endsection
