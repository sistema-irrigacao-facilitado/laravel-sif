<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('images/sificon-bg.ico') }}" type="image/x-icon">
    @yield('style')
    <title>@yield('title')</title>
    @vite(['resources/js/app.js'])
</head>

<body>

    <main>
        @yield('content')
    </main>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="{{ asset('js/jquery.mask.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#cpf').mask('000.000.000-00', {
                reverse: true
            });
            $('#telephone').mask('(00) 00000-0000');
        });
    </script>
    @yield('script')
</body>

</html>