@extends('user.layout.default')

@section('style')
    <link rel="stylesheet" href="{{ asset('style/index.css') }}">
    <link rel="stylesheet" href="{{ asset('style/form.css') }}">
@endsection

@section('title', 'Página inicial')

@section('content')
<main>
    <div class="container">

        <h1 id="h1">Configurações de Usuário</h1>
        <a href="{{ route('dashboard') }}" class="voltar">Voltar</a>
        <div class="row mt-4">
            <div class="col-md-7">
                <h2 id="infoPerson">Informações Pessoais</h2>
                <form action="{{ route('user.conf.update', $user->id) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <div class="campoForm">
                            <label for="name" class="form-label">Nome <strong>*</strong></label>
                            <input type="text" name="name" id="name" class="form-control" maxlength="250" value="{{ $user->name }}">
                        </div>

                        <div class="campoForm">
                            <label for="lastname" class="form-label">Sobrenome <strong>*</strong></label>
                            <input type="text" name="lastname" id="lastname" class="form-control"  maxlength="250" value="{{ $user->lastname }}">
                        </div>

                        <div class="dobleForm">
                            <div class="campoForm">
                                <label for="telephone" class="form-label">Telefone <strong>*</strong></label>
                                <input type="text" name="telephone" id="telephone" class="form-control" placeholder="(99) 99999-9999" value="{{ $user->telephone }}" minlength="15">
                            </div>

                            <div class="campoForm">
                                <label for="cpf" class="form-label">Cpf <strong>*</strong></label>
                                <input type="text" name="cpf" id="cpf" class="form-control" placeholder="000.000.000-00" value="{{ $user->cpf }}" minlength="14">
                            </div>
                        </div>

                        <div class="campoForm">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="name@email.com" maxlength="200" value="{{ $user->email ?? '' }}">
                        </div>

                        <div class="campoForm"><a href="{{ route('user.password') }}" class="altSenha">Alterar Senha</a></div>

                        <!-- <h2 id="pref">Preferencias</h2> -->


                    </div>
                    <div class="mb-3">
                        <button type="submit" class="atualizar">Atualizar</button>
                    </div>
                </form>
            </div>
            <div class="col-md-1">
            </div>
            <div class="col-md-3">
                <ul class="ul-nav">
                    <li class="li-h1" onclick="moveOn('h1')">Configurações de Usuário</li>
                    <li class="li-h2" onclick="moveOn('infoPerson')">Informações pessoais</li>
                    <!-- <li class="li-h2" onclick="moveOn('pref')">Preferencias</li> -->

                </ul>
            </div>
        </div>
    </div>
</main>
<script src="{{ asset('js/jquery.mask.min.js') }}"></script>
<script>
    function moveOn(id) {
        where = document.querySelector(`#${id}`)
        where.scrollIntoView({
            behavior: 'smooth'
        })
    }
    $(document).ready(function() {
                $('.data_nascimento').mask('00/00/0000');
                $('#cpf').mask('000.000.000-00', {
                    reverse: true
                });
                $('#rg').mask('00.000.000-0', {
                    reverse: true
                });
                $('#telephone').mask('(00) 00000-0000');
            });
</script>
@endsection