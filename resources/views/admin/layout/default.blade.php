<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('images/sificon-bg.ico') }}" type="image/x-icon">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


    {{-- CSS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta17/dist/css/tabler.min.css">
    <link href="{{ asset('/library/fontawesome/css/fontawesome.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('/library/fontawesome/css/solid.min.css') }}" rel="stylesheet" />
    {{-- JS --}}
    <script src="{{ asset('library/jquery/js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('library/jquery/js/jquery.mask.js') }}"></script>
    <script src="{{ asset('js/mask.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta17/dist/js/tabler.min.js"></script>

    <link rel="stylesheet" href="{{ asset('style/index.css') }}">
    <link rel="stylesheet" href="{{ asset('style/parts.css') }}">
    <link rel="stylesheet" href="{{ asset('style/partsQuery.css') }}" media="screen and (max-device-width: 800px)">
    @yield('style')

    <title>@yield('title') - SIF</title>

</head>

<body>

    <div class="page">
         <header class="header">
        <div class="logo-nav-container">
            <div class="logo">
                <img src="{{ asset('images/isologo-wh.png') }}" alt="">
                <i class="fa fa-bars fa-2x" onclick="menuShow()"></i>
            </div>
            <ul class="nav">
                <div>
                    <li><a href="{{ route('admin.dashboard') }}">Início</a></li>
                    <li><a href="{{ route('admin.users') }}">Usuarios</a></li>
                    <li><a href="{{ route('admin.devices') }}">Dispositivos</a></li>
                    <li><a href="{{ route('admin.list') }}">Colaboradores</a></li>
                    <li><a href="{{ route('admin.pumps') }}">Bomba</a></li>
                    <li><a href="{{ route('admin.plants') }}">Planta</a></li>
                    <li><a href="{{ route('admin.logs') }}">Logs</a></li>
                </div>
                <a href="{{ route('admin.logout') }}" class="logout query">Sair</a>
            </ul>
        </div>
        <a href="{{ route('admin.logout') }}" class="logout normal">Sair</a>
    </header>
        <div class="page-wrapper">

            <x-alerts />

            @yield('content')
        </div>
    </div>
   
    <script src="{{ asset('js/header.js') }}"></script>

    <script>
        function popup(id) {
            $('#id').attr('value', id)
        }
    </script>
    @yield('script')
</body>

</html>
