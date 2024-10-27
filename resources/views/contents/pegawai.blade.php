@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white text-center">
                    <h4 class="mb-0">Create Akun Karyawan</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('karyawan.store') }}" method="POST">
                        @csrf

                        @if(session('success'))
                            <div id="successMessage" class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <div class="form-group mb-3">
                            <label for="name" class="form-label">Nama Karyawan</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" value="{{ old('name') }}" required>
                            @error('name')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email" value="{{ old('email') }}" required>
                            @error('email')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password" required>
                            @error('password')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" required>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Create Akun</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
    window.onload = function() {
        const successMessage = document.getElementById('successMessage');
        if (successMessage) {
            // Menyembunyikan pesan sukses setelah 5 detik
            setTimeout(function() {
                successMessage.style.display = 'none';
            }, 5000);
        }
    };
</script>
@endsection

@endsection
