<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('images/sificon-bg.ico') }}" type="image/x-icon">
    <title>Adicionar Dispositivo</title>
    <link rel="stylesheet" href="{{ asset('style/index.css') }}">
    <link rel="stylesheet" href="{{ asset('style/addDisp.css') }}">
</head>
<body>
    <div class="helcome">
        <div class="helloBlock">
            <h1>Olá {{ getAuthUser()->name }}.</h1>
            <p>Você está prestes a adicionar seu novo dispositivo SIF, caso tenha dificuldades, siga os passos a seguir.</p>
        </div>
        <div class="backBlock">
            <a href="{{ route('dashboard') }}">Voltar</a>
        </div>
    </div>
    
    <div class="container">
        <div class="addManual">
            <div class="manualHelp">
                <h2>Adicionar Manualmente</h2>
                <p>Adicione manualmente seu dispositivo SIF preenchendo no campo abaixo o número de indentificação do seu novo equipamento de irrigação!</p>
            </div>
            <form action="{{ route('user.device.add') }}" method="post">
                @csrf
                @method('PUT')
                <input type="text" name="numbering" id="numbering" placeholder="00000000">
                <p>Lembre-se: o número possui 8 digitos.</p>
                <button type="submit" class="addBtn">Adicionar</button>
            </form>
        </div>
        <div class="ajuda">
            <h3>Como encontrar o número do meu dispositivo? <strong id="strTagAjuda">#ajuda</strong></h3>
            <ul>
                <li>Em seu dispositivo SIF, encontre o QR Code para conexão Wi-Fi.</li><br>
                <li>Ao scanear o Qr Code, poderá encontrar o numero de identificação de seu dispositivo</li><br>
                <li>Agora que você ja possui o SIF-Id (codigo de identificação), siga para o campo de Adiconar Manualmente ao lado.</li>
            </ul>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="../../js/jquery.mask.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#numbering').mask('00000000');
        });
    </script>
</body>
</html>
