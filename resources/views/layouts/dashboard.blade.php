<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>@yield('title') - Toko Nur Rahma</title>
  <link rel="shortcut icon" href="{{ asset('images/logo-square.png') }}" type="image/x-icon">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  @vite('resources/css/app.css')
  @stack('style')
</head>

<body class="bg-gray-100">

  @include('layouts.dashboard._sidebar')
  <div class="flex">
    <div class="hidden w-64 md:block">
    </div>
    <div class="flex-grow px-3 pt-3">
      @include('layouts.dashboard._navbar')
      <section id="content">
        @yield('content')
      </section>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="{{ asset('js/sweetalert.js') }}"></script>
  @vite('resources/js/app.js')
  @stack('script')
</body>

</html>
