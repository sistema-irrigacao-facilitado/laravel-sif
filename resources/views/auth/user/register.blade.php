@extends('auth.layout.acess')

@section('style')
    <link rel="stylesheet" href="{{ asset('style/cadastroUser.css') }}">
@endsection

@section('title', 'Cadastro - SIF')

@section('content')
    <div class="steps">
        <div class="row"></div>
        <div class="passoAtual">
            <div class="circulo cA">1</div>
            <p>Cadastro</p>
        </div>
        <div class="circulo cP">2</div>
    </div>

    <div class="container">
        <a href="{{ route('user.login') }}" class="voltar"><svg xmlns="http://www.w3.org/2000/svg" width="22.769"
                height="14.821">
                <path d="M10.212 12.007 7.645 9.414h15.124v-4H7.62l2.585-2.586L7.377 0 0 7.378l7.37 7.443 2.842-2.814z" />
            </svg></a>
        <div>
            <x-alerts />

            <h1>Cadastro</h1>
            <p>Torne sua vida mais prática e tranquila com S.I.F</p>
        </div>
        <form action="{{ route('user.register.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-12">
                    <div class="campo">
                        <input class="input" placeholder="Nome Completo" type="text" name="name" id="name"
                            required maxlength="250">
                        <span class="input-border"></span>
                    </div>
                </div>
                <div class="col-6">
                    <div class="campo">
                        <input class="input" placeholder="Telefone" required minlength="15" type="text" name="telephone"
                            id="telephone">
                        <span class="input-border"></span>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="campo">
                    <input class="input" placeholder="Email" maxlength="200" type="text" name="email">
                    <span class="input-border"></span>
                </div>
            </div>
            <div class="col-6">
                <div class="campo">
                    <input class="input" placeholder="Senha" required minlength="8" maxlength="24" type="password"
                        name="password">
                    <span class="input-border"></span>
                </div>
            </div>
            <div class="col-6">
                <div class="campo">
                    <input class="input" placeholder="Repita a Senha" required minlength="8" maxlength="24"
                        type="password" name="password_confirmation">
                    <span class="input-border"></span>
                </div>
            </div>

            <button type="submit" class="cadButton">Cadastre-se</button>
        </form>
    </div>
@endsection

@section('script')
    <script>
        function alterarTipoInput() {
            const checkbox = document.getElementById('eyeCheckbox');
            const input = document.querySelector('.passInp');

            if (checkbox.checked) {
                input.type = "password";
            } else {
                input.type = "text";
            }
        }
    </script>
@endsection
