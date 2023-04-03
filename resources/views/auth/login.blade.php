@extends('layouts.auth')

@section('title', 'Login')

@section('content')
<div class="w-full max-w-md p-6 space-y-4 md:space-y-6 sm:p-8 bg-white rounded-lg md:bg-transparent">
    <div class="text-center">
        <img src="{{ asset('images/logo-square.png') }}" alt="Logo" class="w-24 h-24 mx-auto">
        <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
            Selamat Datang!
        </h1>
        <p>Silahkan masuk untuk melanjutkan</p>
    </div>
    <form class="space-y-4 md:space-y-6" action="" method="POST">
        @csrf
        <div>
            <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Alamat email</label>
            <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="mail@nurrahma.co.id" required>
        </div>
        <div>
            <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kata sandi</label>
            <input type="password" name="password" id="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
        </div>
        <div class="flex items-center justify-between">
            <div class="flex items-start">
                <div class="flex items-center h-5">
                  <input type="checkbox" name="remember" id="remember" aria-describedby="remember" class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-primary-600 dark:ring-offset-gray-800">
                </div>
                <div class="ml-3 text-sm">
                  <label for="remember" class="text-gray-500 dark:text-gray-300">Ingat saya</label>
                </div>
            </div>
            <a href="#" class="text-sm font-medium text-primary-600 hover:underline dark:text-primary-500">Lupa kata sandi?</a>
        </div>
        <button type="submit" class="w-full text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Masuk</button>
    </form>
</div>
@endsection
