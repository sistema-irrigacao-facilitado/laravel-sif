@extends('user.layout.default')

@section('style')
    <link rel="stylesheet" href="{{ asset('style/index.css') }}">
    <link rel="stylesheet" href="{{ asset('style/indexUser.css') }}">
@endsection

@section('title', 'Página inicial')

@section('content')
<a href="#" target="_blank">
    <div class="whats"><img src="../../images/wapp.png" alt=""></div>
</a>
<?php include_once('../../include/parts/header.php') ?>
<main>
    <form method="GET" action="" class="formDado">
        <label for="">Qual informação do seu dispositivo você gostaria de acompanhar?</label> <br>
        <select name="tipo" id="tipo">
            <option value="1" <?php if($_GET['tipo'] === '1'){ echo "selected";}?>>Umidade</option>
            <option value="2" <?php if($_GET['tipo'] === '2'){ echo "selected";}?>>Temperatura</option>
            <option value="3" <?php if($_GET['tipo'] === '3'){ echo "selected";}?>>Litros</option>
        </select>
        <input type="hidden" name="id" value="<?php echo htmlentities($user->getId()); ?>">
        <input type="hidden" name="dispositivo_id" value="<?php echo $dispositivo->getId(); ?>">
        <button type="submit" class="button">Escolher</button>
    </form>
    <div class="resultado">
        <form method="GET" action="" class="formFiltro">
            <div class="filt">
                <label for="hora">Hora:</label>
                <select id="hora" name="hora">
                    <option value="" selected></option>
                    <option value="1">1 Hora</option>
                    <option value="2">2 Hora</option>
                    <option value="3">3 Hora</option>
                    <option value="4">4 Hora</option>
                    <option value="6">6 Hora</option>
                    <option value="12">12 Hora</option>
                    <option value="24">24 Hora</option>
                </select>
            </div>
            <div class="filt">
                <label for="periodo">Periodo:</label>
                <select name="periodo" id="periodo">
                    <option value="" selected></option>
                    <option value="7">7 Dias</option>
                    <option value="1">1 Mês</option>
                    <option value="3">3 Mêses</option>
                </select>
            </div>
            <input type="hidden" name="tipo" value="<?php echo htmlentities($_GET['tipo']) ?>">
            <input type="hidden" name="id" value="<?php echo htmlentities($user->getId()); ?>">
            <input type="hidden" name="dispositivo_id" value="<?php echo $dispositivo->getId(); ?>">
            <button type="submit" class="filtro">Filtrar</button>
        </form>
         <div id="chart_div"></div>
         <div class="time">Exibindo Dados: </div>
    </div>
</main>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    

    window.addEventListener('resize', drawChart);
    google.charts.load('current', {
        'packages': ['corechart']
    });


    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {

        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Horario');
        data.addColumn('number', '<?php if($_GET['tipo'] == 1){ echo 'Umidade';} if($_GET['tipo'] == 2){echo 'Temperatura';} if($_GET['tipo'] == 3){ echo 'Litros';} ?>');

        data.addRows([
            <?php 
            if(!empty($_GET['hora'])){
                if($_GET['tipo'] == 1){
                    foreach (DadosDispRepository::listAllId($dispositivo->getId(), DadosDispRepository::oneHour(''.$_GET['hora'])) as $dados) {
                        echo "['".$dados->getDataInclusao()."', ".$dados->getUmidade()."],";
                    }
                }
                if($_GET['tipo'] == 2){
                    foreach (DadosDispRepository::listAllId($dispositivo->getId(), DadosDispRepository::oneHour(''.$_GET['hora'])) as $dados) {
                        echo "['".$dados->getDataInclusao()."', ".$dados->getTemperatura()."],";
                    }
                }
                if($_GET['tipo'] == 3){
                    foreach (DadosDispRepository::listAllId($dispositivo->getId(), DadosDispRepository::oneHour(''.$_GET['hora'])) as $dados) {
                        echo "['".$dados->getDataInclusao()."', ".number_format($dados->getLitrosBomba(), 3)."],";
                    }
                }
                
            }else if(!empty($_GET['periodo'])){
                    
                if($_GET['tipo'] == 1){
                    foreach (MediaDadosRepository::listAllPeriodo($dispositivo->getId(), MediaDadosRepository::periodoData($_GET['periodo'])) as $dados) {
                        echo "['". $dados->getDataInclusao() ."', ". $dados->getMediaUmidade() ."],";
                    }
                }
                if($_GET['tipo'] == 2){
                    foreach (MediaDadosRepository::listAllPeriodo($dispositivo->getId(), MediaDadosRepository::periodoData(''.$_GET['periodo'])) as $dados) {
                        echo "['".$dados->getDataInclusao()."', ".$dados->getMediaTemperatura()."],";
                    }
                }
                if($_GET['tipo'] == 3){
                    foreach (MediaDadosRepository::listAllPeriodo($dispositivo->getId(), MediaDadosRepository::periodoData(''.$_GET['periodo'])) as $dados) {
                        echo "['".$dados->getDataInclusao()."', ".number_format($dados->getMediaLitros(), 3)."],";
                    }
                }
                    
            } else{
                if($_GET['tipo'] == 1){
                    foreach (DadosDispRepository::listAllId($dispositivo->getId(), DadosDispRepository::oneHour('1')) as $dados) {
                        echo "['".$dados->getDataInclusao()."', ".$dados->getUmidade()."],";
                    }
                }
                if($_GET['tipo'] == 2){
                    foreach (DadosDispRepository::listAllId($dispositivo->getId(), DadosDispRepository::oneHour('1')) as $dados) {
                        echo "['".$dados->getDataInclusao()."', ".$dados->getTemperatura()."],";
                    }
                }
                if($_GET['tipo'] == 3){
                    foreach (DadosDispRepository::listAllId($dispositivo->getId(), DadosDispRepository::oneHour('1')) as $dados) {
                        echo "['".$dados->getDataInclusao()."', ".number_format($dados->getLitrosBomba(), 3)."],";
                    }
                }
            }
            ?>
        ]);

        var options = {
            'title': 'Relatorio de <?php if($_GET['tipo'] == 1){ echo 'Umidade';} if($_GET['tipo'] == 2){echo 'Temperatura';} if($_GET['tipo'] == 3){ echo 'Litros';} ?> (%)',
            'width': '100%',
            'height': '100%',
            colors: ['<?php if($_GET['tipo'] == 1){ echo '#0055ff';} if($_GET['tipo'] == 2){echo '#ff5900';} if($_GET['tipo'] == 3){ echo '#9500ff';} ?>']
        };

        var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
        chart.draw(data, options);
    }
    const time = document.querySelector('.time')

    <?php if(!empty($_GET['hora'])){ ?>
            time.innerHTML += '<?php echo $_GET['hora']?> Hora(s)'
    <?php } else if(!empty($_GET['periodo'])) {?> 
        switch(<?php echo $_GET['periodo']?>){
            case 7:                   
                time.innerHTML += `7 Dias`
                break
            case 1:
                time.innerHTML += `1 Mês`
                break
            case 3:
                time.innerHTML += `3 Mês`
                break
        }
    <?php } else{?>
        time.innerHTML += '1 Hora'
        <?php } ?>
</script>
@endsection
