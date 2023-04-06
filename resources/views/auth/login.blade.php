@extends('layouts.auth')

@section('title', 'Login')

@section('content')
<div class="w-full max-w-md p-6 space-y-4 md:space-y-6 sm:p-8 bg-white rounded-lg md:bg-transparent">
    <div class="text-center">
        <img src="{{ asset('images/logo-square.png') }}" alt="Logo" class="w-24 h-24 mx-auto">
        <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
            Selamat Datang!
        </h1>
        <p class=" text-gray-900 dark:text-white">Silahkan masuk untuk melanjutkan.</p>
    </div>
    <form class="space-y-4 md:space-y-6" action="" method="POST">
        @csrf
        <div>
            <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Alamat email</label>
            <input type="email" name="email" id="email" class="@error('email') is-invalid @enderror form-control" placeholder="mail@nurrahma.co.id" required>
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div>
            <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kata sandi</label>
            <div class="input-group">
                <input type="password" name="password" id="password" class="@error('password') is-invalid @enderror form-control" required>
                <span class="input-group-append toggle-password" data-toggle="#password">
                    <i class="hidden" data-feather="eye"></i>
                    <i data-feather="eye-off"></i>
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
            <a href="{{ route('password.request') }}" class="text-sm font-medium text-primary-600 hover:underline dark:text-primary-500" id="btn-forgot-password">Lupa kata sandi?</a>
        </div>
        <button type="submit" class="w-full btn btn-primary">Masuk</button>
    </form>
</div>
@endsection

@push('script')
    <script>
        $(document).ready(function()
        {
            $('.toggle-password').click(function()
            {
                $(this).find('.feather').toggleClass('hidden');
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
