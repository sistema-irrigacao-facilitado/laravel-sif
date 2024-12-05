@extends('auth.layout.acess')

@section('style')
    <link rel="stylesheet" href="{{ asset('style/loginAdm.css') }}">
@endsection

@section('title', 'Login - SIF')

@section('content')
    <div class="blockForm">
        <form action="{{ route('admin.login') }}" method="post">
            @csrf
            <h1>S.I.F</h1>
            <p>Entrar no Painel Administrativo</p>
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
            <div class="group">
                <input required type="email" class="input" name="email" autocomplete="off">
                <span class="highlight"></span>
                <span class="bar"></span>
                <label>E-mail</label>
            </div>
            <div class="group">
                <input required type="password" class="input" name="password" autocomplete="off">
                <span class="highlight"></span>
                <span class="bar"></span>
                <label>Senha</label>
            </div>
            <button type="submit" class="btn"> <strong>ENTRAR</strong></button>
        </form>
        <div class="divis">
            <img src="{{ asset('images/isologo-wh.png') }}" alt="">
        </div>
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
