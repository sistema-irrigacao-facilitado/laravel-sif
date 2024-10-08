@extends('user.layout.default')

@section('style')
    <link rel="stylesheet" href="{{ asset('style/index.css') }}">
    <link rel="stylesheet" href="{{ asset('style/indexUser.css') }}">
@endsection

@section('title', 'Página inicial')

@section('content')
<div class="helcome">
    <h1>Bem vindo&#10098;a&#10099; <?php echo htmlentities($user->getNome(), ENT_QUOTES) ?></h1>
    <p></p>

</div>
<br>
<?php if (isset($_GET['e'])) {
    if (!empty($_GET['e'])) {
        $e = $_GET['e'];
        if ($e != false) { ?>
            <?php if ($e == 200) { ?>
                <div class="ssc">
                    <p><?php echo ErrorRepository::errorUsuarioI($e); ?></p>
                </div>
            <?php } else { ?>
                <div class="erro">
                    <p><?php echo ErrorRepository::errorUsuarioI($e); ?></p>
                </div>
<?php }
        }
    }
} ?>
<br>
<div class="sectionDispositivos">
    <h2>Dispositivos</h2>
    <?php if (DispositivoRepository::countUser($user->getId()) > 0) { ?>
        <?php foreach (DispositivoRepository::listAllUserId($user->getId()) as $dispositivo) { ?>
            <div class="dispositivo">
                <div class="dispL1">
                    <div class="disInfo">
                        <div class="indenDis">
                            <p class="getModelo"><?php echo htmlentities($dispositivo->getModelo()); ?></p>
                            <p class="getNum"></p> N°: <?php echo htmlentities($dispositivo->getNumeracao()); ?></p>
                        </div>
                        <div class="other">
                            <p><?php if($dispositivo->getIp() == null){ echo "Ligue o dispositivo e configure-o, assim terá acesso a todas as funcionalidade";}?></p>
                        </div>
                    </div>
                    <div class="ancoragem">
                        <a href="../dispositivo/relatorioDisp.php?id=<?php echo $user->getId() ?>&dispositivo_id=<?php echo $dispositivo->getId() ?>&tipo=1"
                            class="aButtonRelatorio">
                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <path
                                        d="M16.5189 16.5013C16.6939 16.3648 16.8526 16.2061 17.1701 15.8886L21.1275 11.9312C21.2231 11.8356 21.1793 11.6708 21.0515 11.6264C20.5844 11.4644 19.9767 11.1601 19.4083 10.5917C18.8399 10.0233 18.5356 9.41561 18.3736 8.94849C18.3292 8.82066 18.1644 8.77687 18.0688 8.87254L14.1114 12.8299C13.7939 13.1474 13.6352 13.3061 13.4987 13.4811C13.3377 13.6876 13.1996 13.9109 13.087 14.1473C12.9915 14.3476 12.9205 14.5606 12.7786 14.9865L12.5951 15.5368L12.3034 16.4118L12.0299 17.2323C11.9601 17.4419 12.0146 17.6729 12.1708 17.8292C12.3271 17.9854 12.5581 18.0399 12.7677 17.9701L13.5882 17.6966L14.4632 17.4049L15.0135 17.2214L15.0136 17.2214C15.4394 17.0795 15.6524 17.0085 15.8527 16.913C16.0891 16.8004 16.3124 16.6623 16.5189 16.5013Z"
                                        fill="#1C274C"></path>
                                    <path
                                        d="M22.3665 10.6922C23.2112 9.84754 23.2112 8.47812 22.3665 7.63348C21.5219 6.78884 20.1525 6.78884 19.3078 7.63348L19.1806 7.76071C19.0578 7.88348 19.0022 8.05496 19.0329 8.22586C19.0522 8.33336 19.0879 8.49053 19.153 8.67807C19.2831 9.05314 19.5288 9.54549 19.9917 10.0083C20.4545 10.4712 20.9469 10.7169 21.3219 10.847C21.5095 10.9121 21.6666 10.9478 21.7741 10.9671C21.945 10.9978 22.1165 10.9422 22.2393 10.8194L22.3665 10.6922Z"
                                        fill="#1C274C"></path>
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M4.17157 3.17157C3 4.34315 3 6.22876 3 10V14C3 17.7712 3 19.6569 4.17157 20.8284C5.34315 22 7.22876 22 11 22H13C16.7712 22 18.6569 22 19.8284 20.8284C20.9812 19.6756 20.9997 17.8316 21 14.1801L18.1817 16.9984C17.9119 17.2683 17.691 17.4894 17.4415 17.6841C17.1491 17.9121 16.8328 18.1076 16.4981 18.2671C16.2124 18.4032 15.9159 18.502 15.5538 18.6225L13.2421 19.3931C12.4935 19.6426 11.6682 19.4478 11.1102 18.8898C10.5523 18.3318 10.3574 17.5065 10.607 16.7579L10.8805 15.9375L11.3556 14.5121L11.3775 14.4463C11.4981 14.0842 11.5968 13.7876 11.7329 13.5019C11.8924 13.1672 12.0879 12.8509 12.316 12.5586C12.5106 12.309 12.7317 12.0881 13.0017 11.8183L17.0081 7.81188L18.12 6.70004L18.2472 6.57282C18.9626 5.85741 19.9003 5.49981 20.838 5.5C20.6867 4.46945 20.3941 3.73727 19.8284 3.17157C18.6569 2 16.7712 2 13 2H11C7.22876 2 5.34315 2 4.17157 3.17157ZM7.25 9C7.25 8.58579 7.58579 8.25 8 8.25H14.5C14.9142 8.25 15.25 8.58579 15.25 9C15.25 9.41421 14.9142 9.75 14.5 9.75H8C7.58579 9.75 7.25 9.41421 7.25 9ZM7.25 13C7.25 12.5858 7.58579 12.25 8 12.25H10.5C10.9142 12.25 11.25 12.5858 11.25 13C11.25 13.4142 10.9142 13.75 10.5 13.75H8C7.58579 13.75 7.25 13.4142 7.25 13ZM7.25 17C7.25 16.5858 7.58579 16.25 8 16.25H9.5C9.91421 16.25 10.25 16.5858 10.25 17C10.25 17.4142 9.91421 17.75 9.5 17.75H8C7.58579 17.75 7.25 17.4142 7.25 17Z"
                                        fill="#1C274C"></path>
                                </g>
                            </svg>
                        </a>

                        <a
                            class="aButtonExcluir" class="popup-button" onclick="popupOn(event, <?php echo $user->getId() ?>, 0, <?php echo $dispositivo->getId() ?>)">
                            <svg viewBox="0 0 1024 1024" class="icon" version="1.1" xmlns="http://www.w3.org/2000/svg"
                                fill="#000000">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <path
                                        d="M667.8 362.1H304V830c0 28.2 23 51 51.3 51h312.4c28.4 0 51.4-22.8 51.4-51V362.2h-51.3z"
                                        fill="#df4343"></path>
                                    <path
                                        d="M750.3 295.2c0-8.9-7.6-16.1-17-16.1H289.9c-9.4 0-17 7.2-17 16.1v50.9c0 8.9 7.6 16.1 17 16.1h443.4c9.4 0 17-7.2 17-16.1v-50.9z"
                                        fill="#df4343"></path>
                                    <path
                                        d="M733.3 258.3H626.6V196c0-11.5-9.3-20.8-20.8-20.8H419.1c-11.5 0-20.8 9.3-20.8 20.8v62.3H289.9c-20.8 0-37.7 16.5-37.7 36.8V346c0 18.1 13.5 33.1 31.1 36.2V830c0 39.6 32.3 71.8 72.1 71.8h312.4c39.8 0 72.1-32.2 72.1-71.8V382.2c17.7-3.1 31.1-18.1 31.1-36.2v-50.9c0.1-20.2-16.9-36.8-37.7-36.8z m-293.5-41.5h145.3v41.5H439.8v-41.5z m-146.2 83.1H729.5v41.5H293.6v-41.5z m404.8 530.2c0 16.7-13.7 30.3-30.6 30.3H355.4c-16.9 0-30.6-13.6-30.6-30.3V382.9h373.6v447.2z"
                                        fill="#201e1d"></path>
                                    <path
                                        d="M511.6 798.9c11.5 0 20.8-9.3 20.8-20.8V466.8c0-11.5-9.3-20.8-20.8-20.8s-20.8 9.3-20.8 20.8v311.4c0 11.4 9.3 20.7 20.8 20.7zM407.8 798.9c11.5 0 20.8-9.3 20.8-20.8V466.8c0-11.5-9.3-20.8-20.8-20.8s-20.8 9.3-20.8 20.8v311.4c0.1 11.4 9.4 20.7 20.8 20.7zM615.4 799.6c11.5 0 20.8-9.3 20.8-20.8V467.4c0-11.5-9.3-20.8-20.8-20.8s-20.8 9.3-20.8 20.8v311.4c0 11.5 9.3 20.8 20.8 20.8z"
                                        fill="#201e1d"></path>
                                </g>
                            </svg>
                        </a>

                        <div class="popup">
                            <div class="popup-content">
                                <h3>Você tem certeza que deseja excluir este dispositivo?</h3>
                                <div class="buttonsPopup">
                                    <a class="cancel" href="">Cancelar</a>
                                    <a class="conf" href="../dispositivo/excDispPost.php?">Confirmar</a>
                                </div>
                            </div>
                        </div>
                        <a href="../dispositivo/conf.php?id=<?php echo $dispositivo->getId(); ?>" class="config">
                            <svg fill="#000000" height="50px" width="50px" version="1.1" id="Capa_1"
                                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                viewBox="0 0 612.004 612.004" xml:space="preserve">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <g>
                                        <path
                                            d="M593.676,241.87h-48.719c-5.643-21.066-13.982-41.029-24.649-59.482l34.459-34.459c7.158-7.154,7.158-18.755,0-25.912 l-64.783-64.783c-7.154-7.156-18.757-7.156-25.909,0l-34.461,34.461c-18.453-10.667-38.414-19.005-59.482-24.647V18.325 c0-10.121-8.201-18.324-18.324-18.324h-91.616c-10.123,0-18.324,8.203-18.324,18.324V67.05c-21.068,5.64-41.027,13.98-59.48,24.647 l-34.459-34.459c-7.158-7.158-18.755-7.158-25.912,0l-64.785,64.781c-7.158,7.156-7.158,18.755,0,25.913l34.461,34.461 C81.03,200.845,72.69,220.804,67.051,241.87H18.326C8.205,241.87,0,250.073,0,260.193v91.618c0,10.121,8.205,18.324,18.326,18.324 h48.725c5.64,21.066,13.98,41.027,24.645,59.478l-34.461,34.461c-7.158,7.154-7.158,18.757,0,25.911l64.781,64.783 c7.16,7.158,18.759,7.158,25.916,0l34.459-34.459c18.451,10.665,38.412,19.005,59.48,24.645v48.727 c0,10.119,8.201,18.324,18.324,18.324h91.616c10.123,0,18.324-8.205,18.324-18.324v-48.727c21.068-5.64,41.029-13.98,59.482-24.647 l34.461,34.459c7.154,7.158,18.755,7.158,25.913,0l64.781-64.781c7.158-7.158,7.158-18.759,0-25.913l-34.459-34.459 c10.667-18.453,19.007-38.414,24.649-59.479h48.721c10.123,0,18.324-8.203,18.324-18.324v-91.618 C612,250.073,603.799,241.87,593.676,241.87z M306.002,397.619c-50.601,0-91.616-41.021-91.616-91.616 c0-50.597,41.017-91.616,91.616-91.616s91.616,41.019,91.616,91.616C397.616,356.598,356.601,397.619,306.002,397.619z">
                                        </path>
                                    </g>
                                </g>
                            </svg>
                        </a>
                    </div>


                </div>
                <?php if ($dispositivo->getIp() != null) { ?>
                    <div class="dispL2">
                        <h3>Ações Rápidas</h3>
                        <div class="acoes">
                            <div class="acSepar">
                                <div class="actionFlex">
                                    <div class="toggle">
                                        <input type="checkbox" class="checkbox"
                                            id="a<?php echo $dispositivo->getId(); ?>" onclick="toggleMode(<?php echo $dispositivo->getId() ?>, 1, <?php echo $dispositivo->getIpBase() ?>)">
                                        <label class="switch" for="a<?php echo $dispositivo->getId(); ?>"
                                            onchange="togglePump()">
                                            <span class="slider"></span>
                                        </label>
                                    </div>
                                    <p>Modo Automático</p>
                                </div>
                                <div class="actionFlex">
                                    <div class="toggle">
                                        <input type="checkbox" class="checkbox"
                                            id="m<?php echo $dispositivo->getId(); ?>" onclick="toggleMode(<?php echo $dispositivo->getId() ?>, 2, <?php echo $dispositivo->getIpBase() ?>)">
                                        <label class="switch" for="m<?php echo $dispositivo->getId(); ?>">
                                            <span class="slider"></span>
                                        </label>
                                    </div>
                                    <p>Manual</p>
                                </div>
                            </div>
                            <div class="acSepar">
                                <div class="temperatura">
                                    <?php
                                    $temperatura = DadosDispRepository::ultimaLeituraTemperatura($dispositivo->getId());
                                    if ($temperatura) {
                                    ?>
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
                                        <p class="dados"><?php echo htmlentities($temperatura->getTemperatura());
                                                            echo "C°"; ?></p>
                                    <?php
                                    } else {
                                    ?>
                                        <p>Temperatura Indisponivel</p>
                                    <?php } ?>
                                </div>
                                <div class="umidade">
                                    <?php
                                    $umidade = DadosDispRepository::ultimaLeituraUmidade($dispositivo->getId());
                                    if ($umidade) {
                                    ?>
                                        <svg viewBox="0 0 1024 1024" class="icon" version="1.1" xmlns="http://www.w3.org/2000/svg"
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
                                        <p class="dados"><?php echo htmlentities($umidade->getUmidade());
                                                            echo "%"; ?></p>
                                    <?php
                                    } else {
                                    ?>
                                        <p>Umidade Indisponivel</p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <div class="dispL3">
                    <a
                        href="../dispositivo/relatorioDisp.php?id=<?php echo $user->getId() ?>&dispositivo_id=<?php echo $dispositivo->getId() ?>&tipo=1">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <path
                                    d="M16.5189 16.5013C16.6939 16.3648 16.8526 16.2061 17.1701 15.8886L21.1275 11.9312C21.2231 11.8356 21.1793 11.6708 21.0515 11.6264C20.5844 11.4644 19.9767 11.1601 19.4083 10.5917C18.8399 10.0233 18.5356 9.41561 18.3736 8.94849C18.3292 8.82066 18.1644 8.77687 18.0688 8.87254L14.1114 12.8299C13.7939 13.1474 13.6352 13.3061 13.4987 13.4811C13.3377 13.6876 13.1996 13.9109 13.087 14.1473C12.9915 14.3476 12.9205 14.5606 12.7786 14.9865L12.5951 15.5368L12.3034 16.4118L12.0299 17.2323C11.9601 17.4419 12.0146 17.6729 12.1708 17.8292C12.3271 17.9854 12.5581 18.0399 12.7677 17.9701L13.5882 17.6966L14.4632 17.4049L15.0135 17.2214L15.0136 17.2214C15.4394 17.0795 15.6524 17.0085 15.8527 16.913C16.0891 16.8004 16.3124 16.6623 16.5189 16.5013Z"
                                    fill="#1C274C"></path>
                                <path
                                    d="M22.3665 10.6922C23.2112 9.84754 23.2112 8.47812 22.3665 7.63348C21.5219 6.78884 20.1525 6.78884 19.3078 7.63348L19.1806 7.76071C19.0578 7.88348 19.0022 8.05496 19.0329 8.22586C19.0522 8.33336 19.0879 8.49053 19.153 8.67807C19.2831 9.05314 19.5288 9.54549 19.9917 10.0083C20.4545 10.4712 20.9469 10.7169 21.3219 10.847C21.5095 10.9121 21.6666 10.9478 21.7741 10.9671C21.945 10.9978 22.1165 10.9422 22.2393 10.8194L22.3665 10.6922Z"
                                    fill="#1C274C"></path>
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M4.17157 3.17157C3 4.34315 3 6.22876 3 10V14C3 17.7712 3 19.6569 4.17157 20.8284C5.34315 22 7.22876 22 11 22H13C16.7712 22 18.6569 22 19.8284 20.8284C20.9812 19.6756 20.9997 17.8316 21 14.1801L18.1817 16.9984C17.9119 17.2683 17.691 17.4894 17.4415 17.6841C17.1491 17.9121 16.8328 18.1076 16.4981 18.2671C16.2124 18.4032 15.9159 18.502 15.5538 18.6225L13.2421 19.3931C12.4935 19.6426 11.6682 19.4478 11.1102 18.8898C10.5523 18.3318 10.3574 17.5065 10.607 16.7579L10.8805 15.9375L11.3556 14.5121L11.3775 14.4463C11.4981 14.0842 11.5968 13.7876 11.7329 13.5019C11.8924 13.1672 12.0879 12.8509 12.316 12.5586C12.5106 12.309 12.7317 12.0881 13.0017 11.8183L17.0081 7.81188L18.12 6.70004L18.2472 6.57282C18.9626 5.85741 19.9003 5.49981 20.838 5.5C20.6867 4.46945 20.3941 3.73727 19.8284 3.17157C18.6569 2 16.7712 2 13 2H11C7.22876 2 5.34315 2 4.17157 3.17157ZM7.25 9C7.25 8.58579 7.58579 8.25 8 8.25H14.5C14.9142 8.25 15.25 8.58579 15.25 9C15.25 9.41421 14.9142 9.75 14.5 9.75H8C7.58579 9.75 7.25 9.41421 7.25 9ZM7.25 13C7.25 12.5858 7.58579 12.25 8 12.25H10.5C10.9142 12.25 11.25 12.5858 11.25 13C11.25 13.4142 10.9142 13.75 10.5 13.75H8C7.58579 13.75 7.25 13.4142 7.25 13ZM7.25 17C7.25 16.5858 7.58579 16.25 8 16.25H9.5C9.91421 16.25 10.25 16.5858 10.25 17C10.25 17.4142 9.91421 17.75 9.5 17.75H8C7.58579 17.75 7.25 17.4142 7.25 17Z"
                                    fill="#1C274C"></path>
                            </g>
                        </svg>
                        <p>Relatório</p>
                    </a>
                    <a class="excButtonL3"
                        onclick="popupOn(event, <?php echo $user->getId() ?>, 0, <?php echo $dispositivo->getId() ?>)">
                        <svg viewBox="0 0 1024 1024" class="icon" version="1.1" xmlns="http://www.w3.org/2000/svg"
                            fill="#000000">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <path
                                    d="M667.8 362.1H304V830c0 28.2 23 51 51.3 51h312.4c28.4 0 51.4-22.8 51.4-51V362.2h-51.3z"
                                    fill="#df4343"></path>
                                <path
                                    d="M750.3 295.2c0-8.9-7.6-16.1-17-16.1H289.9c-9.4 0-17 7.2-17 16.1v50.9c0 8.9 7.6 16.1 17 16.1h443.4c9.4 0 17-7.2 17-16.1v-50.9z"
                                    fill="#df4343"></path>
                                <path
                                    d="M733.3 258.3H626.6V196c0-11.5-9.3-20.8-20.8-20.8H419.1c-11.5 0-20.8 9.3-20.8 20.8v62.3H289.9c-20.8 0-37.7 16.5-37.7 36.8V346c0 18.1 13.5 33.1 31.1 36.2V830c0 39.6 32.3 71.8 72.1 71.8h312.4c39.8 0 72.1-32.2 72.1-71.8V382.2c17.7-3.1 31.1-18.1 31.1-36.2v-50.9c0.1-20.2-16.9-36.8-37.7-36.8z m-293.5-41.5h145.3v41.5H439.8v-41.5z m-146.2 83.1H729.5v41.5H293.6v-41.5z m404.8 530.2c0 16.7-13.7 30.3-30.6 30.3H355.4c-16.9 0-30.6-13.6-30.6-30.3V382.9h373.6v447.2z"
                                    fill="#201e1d"></path>
                                <path
                                    d="M511.6 798.9c11.5 0 20.8-9.3 20.8-20.8V466.8c0-11.5-9.3-20.8-20.8-20.8s-20.8 9.3-20.8 20.8v311.4c0 11.4 9.3 20.7 20.8 20.7zM407.8 798.9c11.5 0 20.8-9.3 20.8-20.8V466.8c0-11.5-9.3-20.8-20.8-20.8s-20.8 9.3-20.8 20.8v311.4c0.1 11.4 9.4 20.7 20.8 20.7zM615.4 799.6c11.5 0 20.8-9.3 20.8-20.8V467.4c0-11.5-9.3-20.8-20.8-20.8s-20.8 9.3-20.8 20.8v311.4c0 11.5 9.3 20.8 20.8 20.8z"
                                    fill="#201e1d"></path>
                            </g>
                        </svg>
                        <p>Excluir</p>
                    </a>
                    <a href="../dispositivo/conf.php?id=<?php echo $dispositivo->getId() ?>" class="config">
                        <svg fill="#000000" height="50px" width="50px" version="1.1" id="Capa_1"
                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                            viewBox="0 0 612.004 612.004" xml:space="preserve">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <g>
                                    <path
                                        d="M593.676,241.87h-48.719c-5.643-21.066-13.982-41.029-24.649-59.482l34.459-34.459c7.158-7.154,7.158-18.755,0-25.912 l-64.783-64.783c-7.154-7.156-18.757-7.156-25.909,0l-34.461,34.461c-18.453-10.667-38.414-19.005-59.482-24.647V18.325 c0-10.121-8.201-18.324-18.324-18.324h-91.616c-10.123,0-18.324,8.203-18.324,18.324V67.05c-21.068,5.64-41.027,13.98-59.48,24.647 l-34.459-34.459c-7.158-7.158-18.755-7.158-25.912,0l-64.785,64.781c-7.158,7.156-7.158,18.755,0,25.913l34.461,34.461 C81.03,200.845,72.69,220.804,67.051,241.87H18.326C8.205,241.87,0,250.073,0,260.193v91.618c0,10.121,8.205,18.324,18.326,18.324 h48.725c5.64,21.066,13.98,41.027,24.645,59.478l-34.461,34.461c-7.158,7.154-7.158,18.757,0,25.911l64.781,64.783 c7.16,7.158,18.759,7.158,25.916,0l34.459-34.459c18.451,10.665,38.412,19.005,59.48,24.645v48.727 c0,10.119,8.201,18.324,18.324,18.324h91.616c10.123,0,18.324-8.205,18.324-18.324v-48.727c21.068-5.64,41.029-13.98,59.482-24.647 l34.461,34.459c7.154,7.158,18.755,7.158,25.913,0l64.781-64.781c7.158-7.158,7.158-18.759,0-25.913l-34.459-34.459 c10.667-18.453,19.007-38.414,24.649-59.479h48.721c10.123,0,18.324-8.203,18.324-18.324v-91.618 C612,250.073,603.799,241.87,593.676,241.87z M306.002,397.619c-50.601,0-91.616-41.021-91.616-91.616 c0-50.597,41.017-91.616,91.616-91.616s91.616,41.019,91.616,91.616C397.616,356.598,356.601,397.619,306.002,397.619z">
                                    </path>
                                </g>
                            </g>
                        </svg>
                    </a>
                </div>
            </div>

        <?php } ?>
    <?php } else { ?>
        <p id="nenhumDis">Nenhum dispositivo Encontrado.</p>
    <?php } ?>
    <a href="../dispositivo/addDisp.php?id=<?php echo $user->getId() ?>" class="addDisposBlock">
        <p>&#43; Adicionar um novo Dispositivo</p>
    </a>
@endsection

@section('script')
    <script>
        function toggleMode(id, why, ip) {
            let checkM = document.querySelector('#m' + id)
            let checkA = document.querySelector('#a' + id)
            switch (why) {
                case 1:
                    checkA.checked = true
                    checkM.checked = false
                    sendCommand(1, ip);
                    break;
                case 2:
                    checkA.checked = false
                    checkM.checked = true
                    sendCommand(0, ip);
                    break
            }
        }

        function sendCommand(command, ip) {
            fetch(`http://${ip}/comando`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        comando: command
                    })
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok ' + response.statusText);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Success:',
                        data);
                })
                .catch((error) => {
                    console.error('Error:', error);

                });
        }

        function checkScreenWidth() {
            const screenWidth = window.innerWidth;
            const addDisposBlock = document.querySelector('.addDisposBlock')
            if (screenWidth < 768) {
                addDisposBlock.innerHTML = '<p>&#43;</p>'
            } else if (screenWidth >= 768 && screenWidth < 1024) {
                addDisposBlock.innerHTML = '<p>&#43; Adicionar</p>'
            } else {
                addDisposBlock.innerHTML = '<p>&#43; Adicionar um novo Dispositivo</p>'
            }
        }
        window.addEventListener("load", checkScreenWidth);
        window.addEventListener("resize", checkScreenWidth);
    </script>
@endsection