@extends('admin.layout.default')

@section('title', 'Editar senha do Colaborador')

@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 card">
                    <form action="{{ route('admin.updatePassword', $collaborator0->id) }}" method="post" enctype="multipart/form-data"
                        class="card">
                        @csrf
                        <div class="card-header">
                            <div class="col">
                                <h4 class="card-title">Editar senha do Colaborador</h4>
                            </div>
                            <div class="btn-list">
                                <a href="{{ route('admin.list') }}" class="btn btn-outline-primary me-auto"
                                    aria-label="Voltar">Voltar</a>
                                <button type="submit" name="save" value="save" class="btn btn-outline-success me-auto"
                                    aria-label="Salvar">Salvar</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="row">
                                    <div class="col-3 mb-3">

                                        <label class="form-label" for="password">Senha</label>
                                        <input type="password" class="form-control" name="password" id="password"
                                            placeholder="Nome" required aria-required="true">

                                    </div>
                                    <div class="col-3 mb-3">

                                        <label class="form-label" for="password_confirmation">Confirmar senha</label>
                                        <input type="password" class="form-control" name="password_confirmation"
                                            id="password_confirmation" placeholder="Nome" required aria-required="true">

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
