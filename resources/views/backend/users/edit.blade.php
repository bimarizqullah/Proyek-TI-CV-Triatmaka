@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Edit User</h2>

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
        <form action="{{ route('users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="name" class="form-label">Name:</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $user->name ?? old('name') }}" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ $user->email ?? old('email') }}" required>
            </div>

            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat:</label>
                <input type="text" class="form-control" id="alamat" name="alamat" value="{{ $user->alamat ?? old('alamat') }}" required>
            </div>

            <div class="mb-3">
                <label for="level" class="form-label">Level:</label>
                <select class="form-control" id="level" name="level" required>
                    <option value="superadmin" {{ (isset($user) && $user->level == 'superadmin') ? 'selected' : '' }}>Super Admin</option>
                    <option value="admin" {{ (isset($user) && $user->level == 'admin') ? 'selected' : '' }}>Admin</option>
                </select>
            </div>


            <div class="mb-3">
                <label for="status" class="form-label">Status:</label>
                <select class="form-control" id="status" name="status" required>
                    <option value="aktif" {{ (isset($user) && $user->status == 'aktif') ? 'selected' : '' }}>Aktif</option>
                    <option value="non-aktif" {{ (isset($user) && $user->status == 'non-aktif') ? 'selected' : '' }}>Non-Aktif</option>
                </select>
            </div>

            <button type="submit" class="btn btn-warning fw-bold">Save User</button>
            <a href="{{ route('backend.users.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection
