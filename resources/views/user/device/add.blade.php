@extends('user.layout.default')

@section('style')
    <link rel="stylesheet" href="{{ asset('style/index.css') }}">
    <link rel="stylesheet" href="{{ asset('style/addDisp.css') }}">
@endsection

@section('title', 'Adicionar dispositivo')

@section('content')
<div class="pagina-add">
    <div class="helcome">
        <div class="helloBlock">
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
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('#numbering').mask('00000000');
        });
    </script>
@endsection
