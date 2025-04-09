@extends('layoutsBackend.app')


@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-3">
            <div class="card shadow-sm mb-4">
                <div class="card-body text-center">
                    <img src="{{ Auth::user()->profile_picture ? asset('storage/'.Auth::user()->profile_picture) : asset('images/default-avatar.png') }}" 
                         class="rounded-circle mb-3" width="150" height="150" alt="Profile Picture">
                    <h4>{{ Auth::user()->name }}</h4>
                    <p class="text-muted">{{ Auth::user()->email }}</p>
                    
                    <div class="d-grid gap-2">
                        <button class="btn btn-outline-primary btn-sm" onclick="document.getElementById('profilePictureInput').click()">
                            <i class="fas fa-camera me-1"></i> Ganti Foto
                        </button>
                    </div>
                    <input type="file" id="profilePictureInput" style="display: none;">
                </div>
            </div>
            
        </div>
        
        <div class="col-md-9">
            <div class="card shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Informasi Profile</h5>
                        <button class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-edit me-1"></i> Edit
                        </button>
                    </div>
                </div>
                
                <div class="card-body">
                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="row mb-3">
                            <label class="col-md-3 col-form-label">Nama Lengkap</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="name" value="{{ Auth::user()->name }}" required>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <label class="col-md-3 col-form-label">Email</label>
                            <div class="col-md-9">
                                <input type="email" class="form-control" name="email" value="{{ Auth::user()->email }}" required>
                            </div>
                        </div>
                        
                        
                        <div class="row mb-3">
                            <label class="col-md-3 col-form-label">Alamat</label>
                            <div class="col-md-9">
                                <textarea class="form-control" name="address" rows="3">{{ Auth::user()->alamat }}</textarea>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-md-3 col-form-label">Level</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="level" value="{{ Auth::user()->level }}" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-md-3 col-form-label">Status</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="level" value="{{ Auth::user()->status }}" required>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <label class="col-md-3 col-form-label">Password</label>
                            <div class="col-md-9">
                                <a href="#" class="btn btn-outline-secondary btn-sm">Ubah Password</a>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-9 offset-md-3">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i> Simpan Perubahan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            
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

<script>
    // Preview image sebelum upload
    document.getElementById('profilePictureInput').addEventListener('change', function(e) {
        if (e.target.files.length > 0) {
            const reader = new FileReader();
            reader.onload = function(event) {
                document.querySelector('.rounded-circle').src = event.target.result;
            };
            reader.readAsDataURL(e.target.files[0]);
            
            // Otomatis submit form jika file dipilih
            document.querySelector('form').submit();
        }
    });
</script>
@endsection