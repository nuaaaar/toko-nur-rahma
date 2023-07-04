<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $product->name }}</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@200;300;400;500;600;700;800;900&display=swap">
    @vite('resources/css/app.css')
    <style>
        .img-wrapper{
            display: inline-block;
            padding: 0px !important;
            position: relative !important;
        }
    </style>
</head>
<body>
    <div class="grid grid-cols-1 place-items-center w-screen h-screen">
        <div class="flex flex-col justify-center items-center gap-5" id="main-wrapper">
            <div class="img-wrapper">
                <table style="text-align: center">
                    <tr>
                        <td style="font-size: 10px; color: #ea580c; font-weight: 600; padding-bottom: 10px;">{{ $product->name . ' (' . $product->unit . ')' }}</td>
                    </tr>
                    <tr>
                        <td>{!! DNS1D::getBarcodeSVG($product->product_code, 'C39', 2, 100, 'black', true) !!}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ asset('vendors/html2canvas/html2canvas.min.js') }}"></script>
    <script>
        $(document).ready(function()
        {
            html2canvas($(".img-wrapper")[0]).then(canvas => {
                var link = canvas.toDataURL("image/jpeg").replace("image/jpeg", "image/octet-stream");
                $(document).find('#main-wrapper').append(canvas)
                $("body").find('#main-wrapper').append(`
                    <div>
                        <div class="download-wrapper text-center inline-block"><a href="javascript:;" download="{{ preg_replace('/[^A-Za-z0-9 ]/', '', $product->name) }}.jpg" class="btn btn-primary btn-download"><h1 class="mb-0 inline-block">Unduh Gambar</h1></a></div>
                    </div>
                `);
                $(".btn-download").prop("href", link);
                // console.log({canvas})
                $(".img-wrapper").hide();
            });
        });
    </script>
</body>
</html>
