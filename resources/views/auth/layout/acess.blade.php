<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('images/sificon-bg.ico') }}" type="image/x-icon">
    @yield('style')
    <title>@yield('title')</title>
    {{-- CSS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta17/dist/css/tabler.min.css">
    <link href="{{ asset('/library/fontawesome/css/fontawesome.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('/library/fontawesome/css/solid.min.css') }}" rel="stylesheet" />
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
            $('#telephone').mask('(00) 00000-0000');
        });
    </script>
    @yield('script')
</body>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="{{ asset('js/jquery.mask.min.js') }}"></script>

</html>