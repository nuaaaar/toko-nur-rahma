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
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    @vite('resources/js/app.js')

    <script src="{{ asset('js/general/base.js') }}" ></script>
    <script src="{{ asset('js/general/sidebar.js') }}" ></script>
    <script src="{{ asset('js/sweetalert.js') }}"></script>
    <script src="{{ asset('vendors/inputmask/inputmask.min.js') }}"></script>
    <script src="{{ asset('vendors/inputmask/jquery.inputmask.min.js') }}"></script>
    <script src="{{ asset('js/pages/dashboard.js') }}" ></script>
    @stack('script')
    @if (session('success'))
        <script>
            showSuccessDialog("{{ session('success') }}");
        </script>
    @endif
    @if (session('error'))
        <script>
            showErrorDialog("{{ session('error') }}");
        </script>
    @endif
</body>

</html>
