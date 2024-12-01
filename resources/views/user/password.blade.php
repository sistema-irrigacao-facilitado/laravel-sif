@extends('user.layout.default')

@section('style')
    <link rel="stylesheet" href="{{ asset('style/index.css') }}">
    <link rel="stylesheet" href="{{ asset('style/form.css') }}">
@endsection

@section('title', 'Página inicial')

@section('content')
<div class="container">

    <h1>Editar Senha Usuario</h1>
    <a href="{{ route('user.conf') }}" class="voltar">Voltar</a>
    <div class="row mt-4">
        <div class="col-md-12">
            <form action="{{ route('user.password.update') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <div class="dobleForm">
                        <div class="campoForm">
                            <label for="password" class="form-label">Nova Senha <strong>*</strong></label>
                            <input type="password" class="form-control" name="password" id="password" required minlength="8" maxlength="24">
                        </div>
                        <div class="campoForm">
                            <label for="password_confirmation" class="form-label">Confirme a Senha <strong>*</strong></label>
                            <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" required minlength="8" maxlength="24">
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <button type="submit" class="enviar">Enviar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection