<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="{{ asset('images/logo-square.png') }}" type="image/x-icon">
    <title>@yield('title') - Toko Nur Rahma</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        .bg-auth{
            background-image: url('/images/auth.jpg');
        }
    </style>
    @vite('resources/css/app.css')
    @stack('style')
</head>
<body class="bg-white">
    <div class="min-h-screen flex items-center justify-center">
        <!-- Left Column -->
        <div class="bg-center bg-no-repeat bg-auth bg-gray-700 bg-blend-multiply hidden w-full md:flex md:items-center md:min-h-screen">
            <div class="px-4 mx-auto max-w-screen-xl text-center">
                <h1 class="mb-4 text-2xl font-extrabold tracking-tight leading-none text-white md:text-5xl lg:text-6xl">CV. Nur Rahma</h1>
                <p class="mb-8 text-lg font-normal text-gray-300">General Suppliers & Digital Printing</p>
            </div>
        </div>
        <!-- Right Column -->
        <div class="bg-transparent min-h-screen flex items-center justify-center px-6 w-full md:bg-white">
            @yield('content')
        </div>
    </div>
    @vite('resources/js/app.js')
</body>
</html>