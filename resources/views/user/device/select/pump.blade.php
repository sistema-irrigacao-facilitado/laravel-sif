@extends('user.layout.default')

@section('style')
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('style/index.css') }}">
    <link rel="stylesheet" href="{{ asset('style/select.css') }}">
@endsection

@section('title', 'Página inicial')

@section('content')

    <div class="title">

        <div class="vavav">
            <h1>Selecione a Bomba utilizada em sua plantação</h1>
            <a href="{{ route('user.device.config', $device->id) }}" class="voltar">Voltar</a>
        </div>
        <div class="search">
            <div class="search-box">
                <div class="search-field">
                    <input placeholder="Pesquisar" class="input" id="search" type="text">
                    <div class="search-box-icon">
                        <button class="btn-icon-content">
                            <i class="search-icon">
                                <svg xmlns="://www.w3.org/2000/svg" version="1.1" viewBox="0 0 512 512">
                                    <path
                                        d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"
                                        fill="#fff"></path>
                                </svg>
                            </i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="popup" tabindex="-1">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Deseja selecionar esta bomba d'agua?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Ao selecionar esta bomba d'agua, os dados relacionados a ela serão enviado ao seu dispositivo, que atualizara seu modo de operar de acordo com estas informações
                </div>
                <div class="modal-footer">
                    <form action="{{ route('user.device.pump.selected', $device->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="int" hidden name="id" id="id">
                        <button type="button" class="btn me-auto" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Selecionar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

        <div class="paginacao">{{ $pumps->links() }}</div>

    <main>
        @foreach ($pumps as $pump)
            <div class="sctCard" onclick="popup({{ $pump->id }})" data-bs-toggle="modal" data-bs-target="#popup">
                <div class="img"><img src="{{ $pump->image_url }}" alt="Minha Imagem" class="imagem-obj"></div>
                <h1>{{ $pump->common_name }}</h1>
                <p>{{ $pump->scientific_name }}</p>
                <a class="selecionarButton">Selecionar</a>
            </div>
        @endforeach

    </main>

        <div class="paginacao">{{ $pumps->links() }}</div>
@endsection

