@extends('user.layout.default')

@section('style')
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('style/index.css') }}">
    <link rel="stylesheet" href="{{ asset('style/conf.css') }}">
@endsection

@section('title', 'Configurações do Dispositivo')

@section('content')
    <a href="#" target="_blank">
        <div class="whats"><img src="{{ asset('images/wapp.png') }}" alt=""></div>
    </a>
    {{-- $device, $dataDevice, $plant, $pump --}}
    <main>
        <div class="container">

            <div class="vavav">
                <h1 id="h1">Configurações do Dispositivo</h1>
                <a href="{{ route('dashboard') }}" class="voltar">Voltar</a>
            </div>

            <div class="infoDisp">
                <h1>{{ $device->model }}</h1>
                <p>N° {{ $device->numbering }}</p>
            </div>

            <h4>Bomba d'agua e planta selecionados -- clique para trocar</h4>
            <div class="seAMCards">
            
                @if ($plant)
                    <a class="seAMCItem plantaCard" href="{{ route('user.device.plant', $device->id) }}">
                        <div class="img"><img src="data:image/png;base64,{{ $plant->image }}" alt="Minha Imagem"   class="imagem-obj"></div>
                        <div class="info">
                            <div class="nome">
                                <h1>{{ $plant->common_name }}</h1>
                                <h2>{{ $plant->scientific_name }}</h2>
                            </div>
                            <div class="caracteristicas">
                                <p>Tipo do solo: {{ $plant->soil_type }}</p>
                                <p>Nescessidade hidrica: {{ $plant->soil_type }}</p>
                                <p>Temperatura maxima suportada: {{ $plant->temperature_tolerance }}°C</p>
                                <p>Umidade minima suportada: {{ $plant->humidity_tolerance }}%</p>
                            </div>
                        </div>
                    </a>
                @else

                    <a class="seAMCItem plantaCard" href="{{ route('user.device.plant', $device->id) }}">
                        <h1>Nenhuma planta selecionada</h1>
                    </a>

                @endif
                @if ($pump)
                   
                    <a class="seAMCItem bombaCard" href="{{ route('user.device.pump', $device->id) }}">
                        <div class="img"><img src="data:image/png;base64,{{ $pump->image }}" alt="Minha Imagem"   class="imagem-obj"></div>
                        <div class="info">
                            <div class="nome">
                                <h1>{{ $pump->model }}</h1>
                            </div>
                            <div class="caracteristicas">
                                <p>Vazão: {{ $pump->flow }}</p>
                                <input id="vazao" style="display: none;" type="text" readonly value="{{ $pump->flow }}">
                            </div>
                        </div>
                    </a>
                @else
                    <a class="seAMCItem bombaCard" href="{{ route('user.device.pump', $device->id) }}">
                        <h1>Ultilizando a bomba padrão</h1>
                    </a>
                @endif
            </div>

            <div class="modo">
                <h3>Modo atual: @if($device->mode == 2)
                                    Ligar a bomba d'agua em determinado horario
                                @else
                                    Ligar a partir dos dados coletados pelos sensores
                                @endif</h3>
                <button type="button" class="btn btn-primary center" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    Alterar modo
                </button>


            </div>
    </main>

    <div class="modal" id="exampleModal" tabindex="-1">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Alterar modo de funcionamento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-selectgroup-boxes row mb-3">
                        <div class="col-md-6">
                            <label class="form-selectgroup-item">
                                <input type="radio" name="modoRadio" value="1" class="form-selectgroup-input" @if($device->mode ==1) {{ 'checked' }} @endif />
                                <span class="form-selectgroup-label d-flex align-items-center p-3">
                                    <span class="me-3">
                                        <span class="form-selectgroup-check"></span>
                                    </span>
                                    <span class="form-selectgroup-label-content">
                                        <span class="form-selectgroup-title strong mb-1">Automático</span>
                                        <span class="d-block text-secondary">O dispositivo realiza a irrigação da plantação de acordo com os dados coletados</span>
                                    </span>
                                </span>
                            </label>
                        </div>
                        <div class="col-md-6">
                            <label class="form-selectgroup-item">
                                <input type="radio" name="modoRadio" value="2" id="lbdh" class="form-selectgroup-input" @if($device->mode == 2) {{ 'checked' }} @endif />
                                <span class="form-selectgroup-label d-flex align-items-center p-3">
                                    <span class="me-3">
                                        <span class="form-selectgroup-check"></span>
                                    </span>
                                    <span class="form-selectgroup-label-content">
                                        <span class="form-selectgroup-title strong mb-1">Por horário</span>
                                        <span class="d-block text-secondary">Onde você define os dias e horas em que o dispositivo fara a irrigação</span>
                                    </span>
                                </span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row modal-body" id="hrLigar" @if($device->mode ==1) style='display: flex;' @endif>
                    <div class="col-12 mb-3 mx-auto p-relative">

                        <div class="days-btn-container m-auto">
                            <input class="day-btn" id="Domingo" value="0" type="checkbox" />
                            <label class="day-label" for="Domingo">Dom</label>

                            <input class="day-btn" id="Segunda" value="1" type="checkbox" />
                            <label class="day-label" for="Segunda">Seg</label>

                            <input class="day-btn" id="Terça" value="2" type="checkbox" />
                            <label class="day-label" for="Terça">Ter</label>

                            <input class="day-btn" id="Quarta" value="3" type="checkbox" />
                            <label class="day-label" for="Quarta">Qua</label>

                            <input class="day-btn" id="Quinta" value="4" type="checkbox" />
                            <label class="day-label" for="Quinta">Qui</label>

                            <input class="day-btn" id="Sexta" value="5" type="checkbox" />
                            <label class="day-label" for="Sexta">Se</label>

                            <input class="day-btn" id="Sábado" value="6" type="checkbox" />
                            <label class="day-label" for="Sábado">Sáb</label>
                        </div>

                    </div>
                    <div class="col-12 m-auto time">
                    </div>
                    <div class="periodoContainer" @if($device->mode == 2) style='display: flex;' @endif>
                        <label for="pertime" class="form-label">Tempo ligado</label>
                        <input type="text" id="pertime" value="{{ periodFormat($device->period) ?? '00:00' }}" placeholder="Min:Seg">
                    </div>
                    <div class="l"><p></p></div>
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
                        Cancelar
                    </a>
                    <a href="#" class="btn btn-success ms-auto" data-bs-dismiss="modal">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-plus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M12 5l0 14"></path>
                            <path d="M5 12l14 0"></path>
                        </svg>
                        Salvar
                    </a>
                </div>
            </div>
        </div>
    </div>
    <form action="{{ route('user.device.modeUpdate', $device->id) }}" method="POST" id="formModo" style="display: none;">
        @csrf

        <input type="text" name="mode" id="modo">
        <input class="hrLigarInput" name="time_on" value='{{ $device->time_on }}'>
        <input type="text" name="id" value="{{ $device->id }}">
        <input type="text" name="period" id="periodo" value="{{ $device->period }}">
        <button type="submit"></button>
    </form>
    <script src="{{ asset('js/confDevice.js') }}"></script>
@endsection
