@extends('layouts.auth')

@section('title', 'Lupa Kata Sandi')

@section('content')
<div class="w-full max-w-md p-6 space-y-4 md:space-y-6 sm:p-8 bg-white rounded-lg md:bg-transparent">
    <div class="text-center">
        <img src="{{ asset('images/logo-square.png') }}" alt="Logo" class="w-24 h-24 mx-auto">
        <h1 class="auth-title">
            Lupa Password
        </h1>
        <p class="auth-subtitle">Silahkan masukkan alamat email anda.</p>
    </div>
    <form class="space-y-4 md:space-y-6" action="" method="POST">
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
       <button type="submit" class="w-full btn btn-primary">Kirim Tautan Atur Ulang</button>
    </form>
</div>
@endsection

@push('script')
@endpush
