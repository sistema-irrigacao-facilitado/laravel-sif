@extends('admin.layout.default')

@section('style')
    <link rel="stylesheet" href="{{ asset('style/list.css') }}">
@endsection

@section('title', 'Novo Usuário')

@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 card">
                    <form action="{{ route('admin.users.store') }}" method="post" enctype="multipart/form-data" class="card">
                        @csrf
                        <div class="card-header">
                            <div class="col">
                                <h4 class="card-title">Cadastrar Usuário</h4>
                            </div>
                            <div class="btn-list">
                                <a href="{{ route('admin.users') }}" class="btn btn-outline-primary me-auto"
                                    aria-label="Voltar">Voltar</a>
                                <button type="submit" name="save" value="save" class="btn btn-outline-success me-auto"
                                    aria-label="Salvar">Salvar</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="row">
                                    <div class="col-6 mb-3">

                                        <label class="form-label" for="name">Nome</label>
                                        <input type="text" class="form-control" name="name" id="name" required
                                            aria-required="true"  placeholder="Nome">

                                    </div>

                                    <div class="col-6 mb-3">

                                        <label class="form-label" for="telephone">Telefone</label>
                                        <input type="text" class="form-control phone" name="telephone" id="telephone"
                                            placeholder="Telefone" required aria-required="true">

                                    </div>
                                    <div class="col-6 mb-3">

                                        <label class="form-label" for="email">Email</label>
                                        <input type="email" class="form-control" name="email" id="email"
                                            placeholder="Email" required aria-required="true">

                                    </div>
                                    <div class="col-3 mb-3">

                                        <label class="form-label" for="password">Senha</label>
                                        <input type="password" class="form-control" name="password" id="password"
                                            placeholder="Senha" required aria-required="true">

                                    </div>
                                    <div class="col-3 mb-3">

                                        <label class="form-label" for="password_confirmation">Confirmar senha</label>
                                        <input type="password" class="form-control" name="password_confirmation"
                                            id="password_confirmation" placeholder="Confirmar senha" required aria-required="true">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
