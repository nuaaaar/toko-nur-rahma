@extends('layouts.auth')

@section('title', 'Atur Ulang Kata Sandi')

@section('content')
<div class="w-full max-w-md p-6 space-y-4 md:space-y-6 sm:p-8 bg-white rounded-lg md:bg-transparent">
    <div class="text-center">
        <img src="{{ asset('images/logo-square.png') }}" alt="Logo" class="w-24 h-24 mx-auto">
        <h1 class="auth-title">
            Atur Ulang Kata Sandi
        </h1>
        <p class="auth-subtitle">Silahkan masukkan password baru.</p>
    </div>
    <form class="form" action="{{ route('password.update') }}" method="POST">
        @csrf
        <input type="hidden" name="email" value="{{ request()->email }}">
        <input type="hidden" name="token" value="{{ request()->token }}">
        <div>
            <label for="email" class="label-block">Alamat Email</label>
            <input type="email" id="email" class="@error('email') is-invalid @enderror form-control" value="{{ request()->email }}" disabled>
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div>
            <label for="password" class="label-block">Kata Sandi Baru</label>
            <div class="input-group">
                <input type="password" name="password" id="password" class="@error('password') is-invalid @enderror form-control" required>
                <span class="input-group-append cursor-pointer toggle-password" data-toggle="#password">
                    <i class="fa-light fa-eye hidden"></i>
                    <i class="fa-light fa-eye-slash"></i>
                </span>
            </div>
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div>
            <label for="password-confirm" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Konfirmasi Kata Sandi</label>
            <div class="input-group">
                <input type="password" name="password_confirmation" id="password-confirm" class="@error('password_confirmation') is-invalid @enderror form-control" required>
                <span class="input-group-append cursor-pointer toggle-password" data-toggle="#password-confirm">
                    <i class="fa-light fa-eye hidden"></i>
                    <i class="fa-light fa-eye-slash"></i>
                </span>
            </div>
            @error('password_confirmation')
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
    <script>
        $(document).ready(function()
        {
            $('.toggle-password').click(function()
            {
                $(this).find('i').toggleClass('hidden');
                var input = $($(this).data('toggle'));
                if (input.attr('type') == 'password')
                {
                    input.attr('type', 'text');
                }
                else
                {
                    input.attr('type', 'password');
                }
            });
        });
    </script>
@endpush
