<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="base-url" content="{{ url('/') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title') - Toko Nur Rahma</title>
    <link rel="shortcut icon" href="{{ asset('images/logo-square.png') }}"
        type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@200;300;400;500;600;700;800;900&display=swap">
    <link rel="stylesheet" href="{{ asset('vendors/fontawesome5/css/all.min.css') }}">
    @vite('resources/css/app.css')
    @stack('style')
</head>

<body class="bg-gray-100 relative font-normal text-sm antialiased overflow-x-hidden">

    <div class="main-container min-h-screen navbar-floating">
        <div>
            @include('layouts.dashboard._sidebar')
        </div>
        <div class="main-content min-h-screen lg:ml-64 ">
            @include('layouts.dashboard._navbar')
            <main class="max-w-screen">
                @yield('content')
            </main>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script> <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @vite('resources/js/app.js')

    <script src="{{ asset('js/general/base.js') }}" ></script>
    <script src="{{ asset('js/sweetalert.js') }}"></script>
    <script src="{{ asset('js/pages/dashboard.js') }}" ></script>
    @stack('script')
    @if (session('success'))
        <script>
            showSuccessDialog("{{ session('success') }}");
        </script>
    @endif
    @if (session('error'))
        <script>
            showSuccessDialog("{{ session('error') }}");
        </script>
    @endif
</body>

</html>
