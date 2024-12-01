@extends('user.layout.default')

@section('style')
    <link rel="stylesheet" href="{{ asset('style/index.css') }}">
    <link rel="stylesheet" href="{{ asset('style/relatorioDisp.css') }}">
@endsection

@section('title', 'Página inicial')

@section('content')

    <main>
        <div class="vavav">
            <h1>Acompanhe os dados que seu dispositivo captura.</h1>
            <a href="{{ route('dashboard') }}" class="voltar">Voltar</a>
        </div> <br>
        <div class="resultado">
            <form method="GET" action="" class="formFiltro">
                
                <div class="filt">
                    <label for="time">Periodo:</label>
                    <select id="time" name="time">
                        <option value="" selected>Selecione</option>
                        <option value="1">1 Hora</option>
                        <option value="2">2 Hora</option>
                        <option value="3">3 Hora</option>
                        <option value="4">4 Hora</option>
                        <option value="6">6 Hora</option>
                        <option value="12">12 Hora</option>
                        <option value="24">24 Hora</option>
                        <option value="7">7 Dias</option>
                        <option value="31">1 Mês</option>
                        <option value="93">3 Mêses</option>
                    </select>
                </div>
                <input type="text" name="from" id="from" style="display: none;">
                <input type="text" name="perMode" id="perMode" style="display: none;" value="{{ $perMode ?? '' }}">
                <button type="submit" class="filtro">Filtrar</button>
            </form>

                <div id="chart"></div>


            
            <div class="time" style="margin-top: 5px">Exibindo Dados: </div>
        </div>
    </main>

    @if ($perMode == 2)
        <input type="hidden" name="average_humidity" id="average_humidity" readonly
            value="{{ implode(', ', $values['average_humidity'] ?? []) }}">
        <input type="hidden" name="average_temperature" id="average_temperature" readonly
            value="{{ implode(', ', $values['average_temperature'] ?? []) }}">
        <input type="hidden" name="average_liters" id="average_liters" readonly
            value="{{ implode(', ', $values['average_liters'] ?? []) }}">
        <input type="hidden" name="created_at" id="created_at" readonly
            value="{{ implode(', ', $values['created_at'] ?? []) }}">
    @else
        <input type="hidden" name="humidity" id="humidity" readonly
            value="{{ implode(', ', $values['humidity'] ?? []) }}">
        <input type="hidden" name="temperature" id="temperature" readonly
            value="{{ implode(', ', $values['temperature'] ?? []) }}">
        <input type="hidden" name="liters" id="liters" readonly
            value="{{ implode(', ', $values['liters_pump'] ?? []) }}">
        <input type="hidden" name="created_at" id="created_at" readonly
            value="{{ implode(', ', $values['created_at'] ?? []) }}">
    @endif


    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <script src="{{ asset('js/report.js') }}"></script>

@endsection
