@extends('layoutsBackend.app')

@section('content')
@if(session('success'))
                        <div class="alert alert-success" aria-label="Close">{{ session('success') }}</div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger" aria-label="Close">{{ session('error') }}</div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
<div class="container-fluid py-4">
    <div class="row">
        <!-- Sidebar Profil -->
        <div class="col-md-3">
            <div class="card shadow-sm mb-4">
                <div class="card-body text-center">
                    <img src="{{ Auth::user()->image_path ? asset('storage/' . Auth::user()->image_path) : asset('storage/profile/default.png') }}"
                         class="rounded-circle mb-3" width="150" height="150" alt="Profile Picture">
                    <h4>{{ Auth::user()->name }}</h4>
                    <p class="text-muted">{{ Auth::user()->email }}</p>

                    <form action="{{ route('profile.update-foto', Auth::user()->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <input type="file" name="image_path" id="profilePictureInput" accept="image/*" style="display: none;" onchange="this.form.submit()">
                        
                        <button type="button" class="btn btn-outline-primary btn-sm" onclick="document.getElementById('profilePictureInput').click()">
                            <i class="fas fa-camera me-1"></i> Ganti Foto
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Informasi Profil -->
        <div class="col-md-9">
            <div class="card shadow-sm">
                <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Informasi Profil</h5>
                    <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#editUserModal">
                        <i class="fas fa-edit me-1"></i> Edit
                    </button>
                </div>

                <div class="card-body">
                    <div class="row mb-3">
                        <label class="col-md-3 col-form-label">Nama Lengkap</label>
                        <div class="col-md-9 mt-2">
                            <span>{{ Auth::user()->name }}</span>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-md-3 col-form-label">Email</label>
                        <div class="col-md-9 mt-2">
                            <span>{{ Auth::user()->email }}</span>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-md-3 col-form-label">Alamat</label>
                        <div class="col-md-9 mt-2">
                            <span>{{ Auth::user()->alamat }}</span>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-md-3 col-form-label">Level</label>
                        <div class="col-md-9 mt-2">
                            <span>{{ Auth::user()->level }}</span>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-md-3 col-form-label">Status</label>
                        <div class="col-md-9 mt-2">
                            <span class="badge {{ Auth::user()->status == 'aktif' ? 'bg-success' : 'bg-secondary' }}">
                                {{ Auth::user()->status }}
                            </span>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-md-3 col-form-label">Password</label>
                        <div class="col-md-9">
                            <a class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#changePasswordModal">Ubah Password</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Informasi Tambahan -->
            <div class="card shadow-sm mt-4">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0">Informasi Tambahan</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-md-3 text-muted">Bergabung Pada</div>
                        <div class="col-md-9">{{ Auth::user()->created_at->format('d F Y') }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-3 text-muted">Terakhir Diperbarui</div>
                        <div class="col-md-9">{{ Auth::user()->updated_at->format('d F Y H:i') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('profile.update', Auth::user()->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="modal-header">
                    <h5 class="modal-title">Edit Profil</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Lengkap:</label>
                        <input type="text" class="form-control" name="name" value="{{ Auth::user()->name }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" class="form-control" name="email" value="{{ Auth::user()->email }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat:</label>
                        <input type="text" class="form-control" name="alamat" value="{{ Auth::user()->alamat }}" required>
                    </div>

                    <!-- Level dan Status diset non-editable -->
                    <div class="mb-3">
                        <label class="form-label">Level:</label>
                        <input type="text" class="form-control" value="{{ Auth::user()->level }}" disabled>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status:</label>
                        <input type="text" class="form-control" value="{{ Auth::user()->status }}" disabled>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-warning">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Ganti Password -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="changePasswordModalLabel">Ganti Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">

                    <div class="mb-3">
                        <label for="current_password">Password Lama</label>
                        <input type="password" name="current_password" class="form-control" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="new_password">Password Baru</label>
                        <input type="password" name="new_password" class="form-control" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="new_password_confirmation">Konfirmasi Password Baru</label>
                        <input type="password" name="new_password_confirmation" class="form-control" required>
                    </div>                    
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-warning fw-bold">Update Password</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
