<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../../images/sificon-bg.ico" type="image/x-icon">
    <link rel="icon" type="images/x-icon" href="images/5983cc5b-aa86-44e5-a2be-00b885f5d843.jpg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    @yield('style')
    
    <link rel="stylesheet" href="../../style/parts.css">
    <link rel="stylesheet" href="../../style/popup.css">
    <link rel="stylesheet" href="../../style/partsQuery.css" media="screen and (max-device-width: 800px)">
    <title>@yield('title') - SIF</title>
    <script src="../../js/popups.js"></script>
</head>
<body>
    <header class="header">
        <div class="logo-nav-container">
            <div class="logo">
                
                <i class="fa fa-bars fa-2x" onclick="menuShow()"></i>
                <img src="../../images/isologo-wh.png" alt="">
            </div>
            <ul class="nav">
            <div>
                <li><a href="../index/index.php">Início</a></li>
                <li><a href="../confUser/conf.php">Configurações</a></li>
                <!-- <li><a href="#">Ajuda</a></li>
                <li><a href="#">Contato</a></li>
                <li><a href="#">Loja</a></li> -->
            </div>
            <a href="../../login/logout.php" class="logout media">Sair</a>
            </ul>
        </div>
        <a href="../../login/logout.php" class="logout normal">Sair</a>
    </header>
    <script src="../../js/header.js"></script>

    <a href="#" target="_blank">
        <div class="whats"><img src="../../images/wapp.png" alt=""></div>
    </a>

    @yield('content')

    <script src="../../js/popups.js"></script>

    @yield('script')
</body>
</html>