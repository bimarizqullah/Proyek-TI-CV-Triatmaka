@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>Add New User</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card p-4">
        <form action="{{ route('users.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Name:</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" name="email" id="email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="name" class="form-label">Alamat:</label>
                <input type="text" name="alamat" id="alamat" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="level">Level:</label>
                <select name="level" id="level" class="form-control" required>
                    <option value="superadmin">Super Admin</option>
                    <option value="admin">Admin</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="status">Status:</label>
                <select name="status" id="status" class="form-control">
                    <option value="aktif">Aktif</option>
                    <option value="non-aktif">Non-Aktif</option>
                </select>
            </div>

            <button type="submit" class="btn btn-warning fw-bold">Save User</button>
            <a href="{{ route('backend.users.index') }}" class="btn btn-danger">Cancel</a>
        </form>
    </div>
</div>
@endsection
