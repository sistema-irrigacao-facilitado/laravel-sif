@extends('auth.layout.acess')

@section('style')
    <link rel="stylesheet" href="{{ asset('style/cadastroUser.css') }}">
@endsection

@section('title', 'Cadastro - SIF')

@section('content')

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
                <div class="col-12 mb-3">
                    <label class="form-label">Nome Completo</label>
                    <input class="form-control" placeholder="Nome Completo" type="text" name="name" id="name"
                        required maxlength="250">


                </div>
                <div class="col-6 mb-3">
                    <label class="form-label">Telefone</label>
                    <input class="form-control" placeholder="Telefone" required minlength="15" type="text"
                        name="telephone" id="telephone">


                </div>
                <div class="col-6 mb-3">
                    <label class="form-label">Email</label>
                    <input class="form-control" placeholder="Email" maxlength="200" type="text" name="email">


                </div>
                <div class="col-6 mb-5">
                    <label class="form-label">Senha</label>
                    <input class="form-control" placeholder="Senha" required minlength="8" maxlength="24" type="password"
                        name="password">


                </div>
                <div class="col-6 mb-5">
                    <label class="form-label">Repita a Senha</label>
                    <input class="form-control" placeholder="Repita a Senha" required minlength="8" maxlength="24"
                        type="password" name="password_confirmation">


                </div>
                <button type="submit" class="btn btn-success col-4 offset-4">Cadastre-se</button>

            </div>

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
