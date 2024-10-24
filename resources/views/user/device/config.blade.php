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
    <main>
        <div class="container">

            <h1 id="h1">Configurações do Dispositivo</h1>

            <a href="{{ route('dashboard') }}" class="voltar">Voltar</a>

            <div class="infoDisp">
                <h1>{{ $device->model }}</h1>
                <p>N° {{ $device->numbering }}</p>
            </div>



            <h3>Dados da ultima leitura</h3>
            <div class="dadosAtuais">
                @if ($dataDevice)
                    <div class="umidade">
                        @if ($dataDevice->humidity != null)
                            <svg viewBox="0 0 1024 1024"  version="1.1" xmlns="http://www.w3.org/2000/svg"
                                fill="#000000">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <path d="M512 512m-480 0a480 480 0 1 0 960 0 480 480 0 1 0-960 0Z" fill="#E5F1FF">
                                    </path>
                                    <path
                                        d="M512 179.2c-96 102.4-262.4 236.8-262.4 384s115.2 262.4 262.4 262.4 262.4-115.2 262.4-262.4-160-281.6-262.4-384z"
                                        fill="#9FC8FE"></path>
                                    <path
                                        d="M512 684.8c-57.6 0-102.4-44.8-102.4-108.8 0-57.6 64-102.4 102.4-147.2 38.4 44.8 102.4 89.6 102.4 147.2 0 57.6-44.8 108.8-102.4 108.8z"
                                        fill="#72AEFD"></path>
                                </g>
                            </svg>
                            <p class="dados">{{ $dataDevice->humidity }}%</p>
                        @else
                            <p>Umidade Indisponivel</p>
                        @endif
                    </div>
                    <div class="temperatura">
                        @if ($dataDevice->temperature != null)
                            <svg height="50px" width="50px" version="1.1" id="Layer_1"
                                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                viewBox="0 0 512 512" xml:space="preserve" fill="#000000">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <circle style="fill:#CEE8FA;" cx="221.32" cy="381.469" r="59.943"></circle>
                                    <g>
                                        <path style="fill:#2D527C;"
                                            d="M221.326,455.991c-41.09,0-74.52-33.43-74.52-74.52s33.43-74.52,74.52-74.52 s74.52,33.43,74.52,74.52S262.416,455.991,221.326,455.991z M221.326,336.107c-25.014,0-45.364,20.35-45.364,45.364 s20.35,45.364,45.364,45.364s45.364-20.35,45.364-45.364S246.339,336.107,221.326,336.107z">
                                        </path>
                                        <path style="fill:#2D527C;"
                                            d="M221.361,512c-1.061,0-2.121-0.012-3.187-0.038c-70.33-1.662-127.472-60.279-127.377-130.668 c0.063-46.595,24.418-88.796,64.149-112.209V58.856C154.948,26.403,181.349,0,213.804,0h15.046 c32.453,0,58.856,26.403,58.856,58.856c0,8.051-6.526,14.578-14.578,14.578s-14.578-6.526-14.578-14.578 c0-16.377-13.324-29.701-29.701-29.701h-15.046c-16.377,0-29.701,13.324-29.701,29.701V277.74c0,5.521-3.118,10.567-8.054,13.037 c-34.548,17.286-56.042,51.985-56.093,90.556c-0.073,54.666,44.297,100.191,98.911,101.482c27.549,0.63,53.593-9.582,73.285-28.814 c19.7-19.24,30.549-44.998,30.549-72.528c0-16.546-4.073-32.954-11.779-47.455c-3.779-7.11-1.077-15.936,6.032-19.713 c7.111-3.777,15.936-1.077,19.713,6.032c9.936,18.697,15.189,39.838,15.189,61.136c0,35.449-13.97,68.614-39.333,93.388 C287.924,498.88,255.657,511.999,221.361,512z">
                                        </path>
                                        <path style="fill:#2D527C;"
                                            d="M221.326,283.228c-8.051,0-14.578-6.526-14.578-14.578V151.01c0-8.051,6.526-14.578,14.578-14.578 c8.051,0,14.578,6.526,14.578,14.578v117.64C235.903,276.702,229.377,283.228,221.326,283.228z">
                                        </path>
                                        <path style="fill:#2D527C;"
                                            d="M406.627,194.304H287.704v-30.613h64.823c8.051,0,14.578-6.526,14.578-14.578 s-6.526-14.578-14.578-14.578h-77.941c-0.249,0-0.491,0.025-0.736,0.038c-0.241-0.012-0.478-0.036-0.723-0.036 c-8.051,0-14.578,6.526-14.578,14.578v119.537c0,8.051,6.526,14.578,14.578,14.578c0.246,0,0.487-0.025,0.729-0.036 c0.243,0.012,0.484,0.036,0.729,0.036h77.941c8.051,0,14.578-6.526,14.578-14.578s-6.526-14.578-14.578-14.578h-64.823v-30.613 h118.923c8.051,0,14.578-6.526,14.578-14.578S414.678,194.304,406.627,194.304z">
                                        </path>
                                        <path style="fill:#2D527C;"
                                            d="M340.682,23.012c-8.787,0-13.875,4.933-13.875,15.416v40.854c0,10.483,5.088,15.416,14.03,15.416 c12.334,0,13.104-9.404,13.566-15.416c0.464-5.704,5.704-7.247,11.871-7.247c8.325,0,12.18,2.159,12.18,11.408 c0,20.504-16.649,32.22-38.695,32.22c-20.194,0-36.998-9.866-36.998-36.383V38.428c0-26.515,16.804-36.383,36.998-36.383 c22.046,0,38.695,11.099,38.695,30.679c0,9.25-3.854,11.408-12.025,11.408c-6.474,0-11.716-1.697-12.025-7.247 C354.249,32.878,353.787,23.012,340.682,23.012z">
                                        </path>
                                    </g>
                                </g>
                            </svg>
                            <p class="dados">{{ $dataDevice->temperature }} °C</p>
                        @else
                            <p>Temperatura Indisponivel</p>
                        @endif
                    </div>
                @else
                    <h3>Nenhuma leitura foi encontrada</h3>
                    <p>Ligue seu dispositivo, se conecte a uma rede Wi-Fi, e tenha acesso aos dados coletados de seu
                        dispositivo</p>
                @endif
            </div>

            <h4>Bomba d'agua e planta selecionados -- clique para trocar</h4>
            <div class="seAMCards">
                @if ($plant)
                    <a class="seAMCItem plantaCard" href="{{ route('user.device.plant', $device->id) }}">
                        <div class="img"><img src="{{ $plant->image_url }}" alt="Minha Imagem" class="imagem-obj"></div>
                        <div class="info">
                            <div class="nome">
                                <h1>{{ $plant->common_name }}</h1>
                                <h2>{{ $plant->scientific_name }}</h2>
                            </div>
                            <div class="caracteristicas">
                                <p>Tipo do solo: {{ $plant->soil_type }}</p>
                                <p>Nescessidade hidrica: {{ $plant->water_need }}</p>
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
                        <div class="img"><img src="{{ $pump->image_url }}" alt="Minha Imagem" class="imagem-obj"></div>
                        <div class="info">
                            <div class="nome">
                                <h1>{{ $pump->model }}</h1>
                            </div>
                            <div class="caracteristicas">
                                <p>Vazão: {{ $pump->flow }}</p>
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
                <h3>Modo atual: @if ($device->mode == 1)
                        {{ "Ligar a bomba d'agua em determinado horario" }}
                    @else
                        {{ 'Ligar a partir dos dados coletados pelos sensores' }}
                    @endif
                </h3>
                <div class="chMode">
                    <input type="checkbox" name="changeModo" id="changeModo">
                    <label for="changeModo">Alterar modo de funcionamento</label>
                </div>

                <form action="{{ route('user.device.modeUpdate', $device->id) }}" method="post" id="changeForm">
                    @csrf
                    @method('PUT')
                    <div class="radioButtons">
                        <div class="radioInput">
                            <input type="radio" name="mode" value="1" id="umds"
                                @if ($device->mode == 1) {{ 'checked' }} @endif>
                            <label for="umds">Modo inteligente</label>
                        </div>
                        <div class="radioInput">
                            <input type="radio" name="mode" value="2" id="lbdh"
                                @if ($device->mode == 2) {{ 'checked' }} @endif>
                            <label for="lbdh">Definir Horario</label>
                        </div>
                    </div>
                    <div class="hrLigar">
                        <label for="time">Clique abaixo e defina o horario para que a bomba d'agua ligue</label>
                        <input type="time" name="time_on" id="time">
                    </div>
                    <input type="text" name="dispositivo_id" value="{{ $device->id }}" hidden>
                    <button type="submit" class="salvar">Salvar</button>
                </form>
            </div>
    </main>
    <script>
        let changeModo = document.querySelector('#changeModo');

        changeModo.addEventListener('change', function change() {
            const changeForm = document.querySelector('#changeForm');
            if (changeModo.checked) {
                changeForm.style.display = 'flex';
            } else {
                changeForm.style.display = 'none';
            }
        });


        const radioButtons = document.querySelectorAll('input[name="mode"]');
        const divAExibir = document.querySelector('.hrLigar'); // Div que será exibida

        radioButtons.forEach(button => {
            button.addEventListener('change', () => {
                // Verifica se o radio button que acionou o evento é o que deve exibir a div
                if (button.id === 'lbdh') { // Substitua por o ID do radio button correto
                    divAExibir.style.display = button.checked ? 'flex' : 'none';
                } else {
                    divAExibir.style.display = 'none'
                }
            });
        });
    </script>
@endsection
