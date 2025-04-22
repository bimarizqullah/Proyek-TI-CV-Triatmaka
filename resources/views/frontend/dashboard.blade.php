@extends ('layouts.app')

@section('content')
<div class="d-flex justify-content-center align-items-center min-vh-100 position-relative" style="background: url('{{ asset('images/bg.jpg') }}') no-repeat center center; background-size: cover;">
    <div class="position-absolute top-0 start-0 w-100 h-100" 
        style="backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px); z-index: 1;">
    </div>
    <div class="announce-container position-relative z-2"> 
        <div class="row shadow rounded-4 overflow-hidden bg-white" style="max-width: 900px; margin: auto;">
            <div class="container col-md-6 col-12 align-items-center text-center p-5">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo img-fluid rounded-4 shadow" style="max-width: 50%; margin: 50px; background-color: #ffcc00;">
                <h2 class="announcement text-center mb-1 lead">Website sedang dalam pengembangan...</h2>
            </div>
        </div>
    </div>
</div>
@endsection