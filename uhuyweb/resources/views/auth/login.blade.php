@extends('layouts.header')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body bg-light rounded">
                    <div class="text-center mb-4">
                        <h5 class="fw-bold">Login Aplikasi</h5>
                    </div>

                    @if(session('error'))
                        <div class="alert alert-danger small py-2">{{ session('error') }}</div>
                    @endif

                    <form action="{{ route('login.post') }}" method="POST">
                        @csrf {{-- Wajib di Laravel untuk keamanan --}}
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Username</label>
                            <input type="text" name="username" class="form-control form-control-sm" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Password</label>
                            <input type="password" name="password" class="form-control form-control-sm" required>
                        </div>

                        <div class="d-grid mt-4">
                            <button class="btn btn-primary btn-sm fw-bold" type="submit">MASUK</button>
                        </div>
                    </form>
                    <hr>
                    <p class="text-center small">Belum punya Akun? <a href="/register" class="text-decoration-none">Register Disini!</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@include('layouts.footer')