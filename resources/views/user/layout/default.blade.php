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
    <script src="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta17/dist/js/tabler.min.js"></script>

    <link rel="stylesheet" href="{{ asset('style/parts.css') }}">
    <link rel="stylesheet" href="{{ asset('style/partsQuery.css') }}" media="screen and (max-device-width: 800px)">
    @yield('style')
    
    <title>@yield('title') - SIF</title>

</head>

<body>
    <header class="header">
        <div class="logo-nav-container">
            <div class="logo">

                <i class="fa fa-bars fa-2x" onclick="menuShow()"></i>
                <img src="{{ asset('images/isologo-wh.png') }}" alt="">
            </div>
            <ul class="nav">
                <div>
                    <li><a href="{{ route('dashboard') }}">Início</a></li>
                    <li><a href="../confUser/conf.php">Configurações</a></li>
                    <!-- <li><a href="#">Ajuda</a></li>
                <li><a href="#">Contato</a></li>
                <li><a href="#">Loja</a></li> -->
                </div>
                <a href="{{ route('logout') }}" class="logout query">Sair</a>
            </ul>
        </div>
        <a href="{{ route('logout') }}" class="logout normal">Sair</a>
    </header>
    <script src="{{ asset('js/header.js') }}"></script>
    

    <a href="#" target="_blank">
        <div class="whats"><img src="{{ asset('images/wapp.png') }}" alt=""></div>
    </a>

    @yield('content')
    <script>
        function popup(id) {
            $('#id').attr('value', id)
        }
    </script>
    @yield('script')
</body>

</html>
