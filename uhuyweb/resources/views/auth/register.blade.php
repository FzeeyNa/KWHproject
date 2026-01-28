@extends('layouts.header')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow-sm border-0">
                <div class="card-body bg-white rounded p-4">
                    <div class="text-center mb-4">
                        <h4 class="fw-bold">Daftar Akun</h4>
                        <p class="text-muted small">Lengkapi data di bawah untuk bergabung</p>
                    </div>

                    <form action="{{ route('register.post') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Nama Lengkap</label>
                            <input type="text" name="fullName" class="form-control" placeholder="Contoh: Budi Santoso" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold">Username</label>
                            <input type="text" name="username" class="form-control" placeholder="Username unik" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="email@contoh.com" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Minimal 6 karakter" required>
                        </div>

                        <div class="d-grid mt-4">
                            <button class="btn btn-success fw-bold" type="submit">DAFTAR SEKARANG</button>
                        </div>
                    </form>
                    <hr>
                    <p class="text-center small mb-0">Sudah punya Akun? <a href="{{ route('login') }}" class="fw-bold text-decoration-none">Login Disini!</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@include('layouts.footer')