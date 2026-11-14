@extends('user.layout.default')

@section('style')
    <link rel="stylesheet" href="{{ asset('style/index.css') }}">
    <link rel="stylesheet" href="{{ asset('style/relatorioDisp.css') }}">
@endsection

@section('title', 'Página inicial')

@section('content')

    <main class="relatorio">
        <a href="{{ route('dashboard') }}" class="voltar">Voltar</a>
        <h1>Relatório do dispositivo</h1>
        <p class="relatorio-sub">{{ $device->model }} · N° {{ $device->numbering }}</p>

        @php
            $chaves = $perMode == 2
                ? ['hum' => 'average_humidity', 'temp' => 'average_temperature', 'lit' => 'average_liters']
                : ['hum' => 'humidity', 'temp' => 'temperature', 'lit' => 'liters_pump'];
            $ultimo = fn($k) => collect($values[$k] ?? [])->last();
            $fmt = fn($v, $un) => $v === null ? '—' : number_format((float) $v, 1, ',', '') . $un;
        @endphp

        <div class="kpis">
            <div class="kpi kpi-umidade"><span class="kpi-rotulo">Umidade</span><span class="kpi-valor">{{ $fmt($ultimo($chaves['hum']), '%') }}</span><span class="kpi-nota">último registro</span></div>
            <div class="kpi kpi-temp"><span class="kpi-rotulo">Temperatura</span><span class="kpi-valor">{{ $fmt($ultimo($chaves['temp']), ' °C') }}</span><span class="kpi-nota">último registro</span></div>
            <div class="kpi kpi-litros"><span class="kpi-rotulo">Água usada</span><span class="kpi-valor">{{ $fmt($ultimo($chaves['lit']), ' L') }}</span><span class="kpi-nota">último registro</span></div>
        </div>

        <div class="resultado">
            <form method="GET" action="" class="formFiltro">
                <div class="filt">
                    <label for="time">Período:</label>
                    <select id="time" name="time">
                        <option value="">Última hora</option>
                        @foreach (['1' => '1 hora', '2' => '2 horas', '3' => '3 horas', '4' => '4 horas', '6' => '6 horas', '12' => '12 horas', '24' => '24 horas', '7' => '7 dias', '31' => '1 mês', '93' => '3 meses'] as $v => $rotulo)
                            <option value="{{ $v }}" @selected(request('time') == $v)>{{ $rotulo }}</option>
                        @endforeach
                    </select>
                </div>
                <input type="text" name="from" id="from" style="display: none;">
                <input type="text" name="perMode" id="perMode" style="display: none;" value="{{ $perMode ?? '' }}">
                <button type="submit" class="filtro">Filtrar</button>
            </form>

            @if ($collection->isEmpty())
                <div class="sem-dados-grafico">
                    <strong>Nenhum dado neste período.</strong>
                    <span>Escolha um período maior ou verifique se o dispositivo está ligado e conectado à internet.</span>
                </div>
            @endif
            <div id="chart" @if ($collection->isEmpty()) style="display:none" @endif></div>

            <div class="time" style="margin-top: 5px">Exibindo dados: </div>
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

@endsection

@section('script')
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="{{ asset('js/report.js') }}"></script>
@endsection
