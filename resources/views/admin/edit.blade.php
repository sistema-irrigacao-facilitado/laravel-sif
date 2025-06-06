@extends('admin.layout.default')


@section('title', 'Editar Colaborador')

@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 card">
                    <form action="{{ route('admin.update', $collaborator0->id) }}" method="post" enctype="multipart/form-data"
                        class="card">
                        @csrf
                        @method('PUT')
                        <div class="card-header">
                            <div class="col">
                                <h4 class="card-title">Editar Colaborador</h4>
                            </div>
                            <div class="btn-list">
                                <a href="{{ route('admin.list') }}" class="btn btn-outline-primary me-auto"
                                    aria-label="Voltar">Voltar</a>
                                     <a class="btn" href="{{ route('admin.updatePassword', $collaborator->id) }}">Alterar senha</a>
                                <button type="submit" name="save" value="save" class="btn btn-outline-success me-auto"
                                    aria-label="Salvar">Salvar</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="row">
                                    <div class="col-6 mb-3">

                                        <label class="form-label" for="name">Nome</label>
                                        <input type="text" class="form-control" name="name" id="name"
                                            value="{{ $collaborator->name }}" required aria-required="true">

                                    </div>

                                    <div class="col-6 mb-3">

                                        <label class="form-label" for="telephone">Telefone</label>
                                        <input type="text" class="form-control" name="telephone" id="telephone"
                                            value="{{ $collaborator->telephone }}" placeholder="Nome" required
                                            aria-required="true">

                                    </div>

                                   

                                       

                                   

                                    <div class="col-6 mb-3">

                                        <label class="form-label" for="email">Email</label>
                                        <input type="email" class="form-control" name="email" id="email"
                                            value="{{ $collaborator->email }}" placeholder="Nome" required
                                            aria-required="true">

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
