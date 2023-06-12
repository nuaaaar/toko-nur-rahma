<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <style>
        body{
            font-family: Arial, Helvetica, sans-serif;
        }

        table{
            border-collapse: collapse;
            width: 100%;
        }

        table th{
            border: 1px solid #000;
            padding: 8px;
            font-weight: bold;
            text-align: center;
        }

        table td{
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
        }
    </style>
</head>
<body>
    @yield('content')

    @yield('script')
</body>
</html>
