@extends('layouts.auth')

@section('title', 'Login')

@section('content')
<div class="w-full max-w-md p-6 space-y-4 md:space-y-6 sm:p-8 bg-white rounded-lg md:bg-transparent">
    <div class="text-center">
        <img src="{{ asset('images/logo-square.png') }}" alt="Logo" class="w-24 h-24 mx-auto">
        <h1 class="auth-title">
            Selamat Datang!
        </h1>
        <p class="auth-subtitle">Silahkan masuk untuk melanjutkan.</p>
    </div>
    <form class="form" action="" method="POST">
        @csrf
        <div>
            <label for="email" class="label-block">Alamat email</label>
            <input type="email" name="email" id="email" class="@error('email') is-invalid @enderror form-control" placeholder="mail@nurrahma.co.id" required>
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div>
            <label for="password" class="label-block">Kata sandi</label>
            <div class="input-group">
                <input type="password" name="password" id="password" class="@error('password') is-invalid @enderror form-control" required>
                <span class="input-group-append cursor-pointer toggle-password" data-toggle="#password">
                    <i class="hidden fa-light fa-eye"></i>
                    <i class="fa-light fa-eye-slash"></i>
                </span>
            </div>
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="flex items-center justify-between">
            <div class="flex items-start">
                <div class="flex items-center h-5">
                    <input type="checkbox" name="remember" id="remember" aria-describedby="remember" class="custom-checkbox">
                </div>
                <div class="ml-3 text-sm">
                    <label for="remember" class="text-gray-500 dark:text-gray-300">Ingat saya</label>
                </div>
            </div>
            <a href="{{ route('password.request') }}" class="link-primary" id="btn-forgot-password">Lupa kata sandi?</a>
        </div>
        <button type="submit" class="w-full btn btn-primary">Masuk</button>
    </form>
</div>
@endsection

@push('script')
    <script src="{{ asset('js/pages/auth/login.js') }}"></script>
@endpush
