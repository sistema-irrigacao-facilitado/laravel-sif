@extends('admin.layout.default')

@section('title', 'Editar Usuário')

@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 card">
                    <form action="{{ route('admin.users.update', $user->id) }}" method="post" enctype="multipart/form-data"
                        class="card">
                        @csrf
                        @method('PUT')
                        <div class="card-header">
                            <div class="col">
                                <h4 class="card-title">Editar Usuário</h4>
                            </div>
                            <div class="btn-list">
                                <a href="{{ route('admin.users') }}" class="btn btn-outline-primary me-auto"
                                    aria-label="Voltar">Voltar</a>
                                    <a class="btn" href="{{ route('admin.updatePassword', $user->id) }}">Alterar
                                        senha</a>
                                <button type="submit" name="save" value="save" class="btn btn-outline-success me-auto"
                                    aria-label="Salvar">Salvar</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">

                                <div class="col-6 mb-3">
                                    <label class="form-label" for="name">Nome</label>
                                    <input type="text" class="form-control" name="name" id="name"
                                        value="{{ $user->name }}" required aria-required="true">
                                </div>

                                <div class="col-6 mb-3">
                                    <label class="form-label" for="telephone">Telefone</label>
                                    <input type="text" class="form-control phone" name="telephone" id="telephone"
                                        value="{{ $user->telephone }}" placeholder="Nome" required aria-required="true">
                                </div>


                                <div class="col-6 mb-3">
                                    <label class="form-label" for="email">Email</label>
                                    <input type="email" class="form-control" name="email" id="email"
                                        value="{{ $user->email }}" placeholder="Nome" required aria-required="true">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
