@extends('admin.layout.default')

@section('style')
    <link rel="stylesheet" href="{{ asset('style/list.css') }}">
@endsection

@section('title', 'Nova Bomba')

@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 card">
                    <form action="{{ route('admin.pumps.store') }}" method="post" enctype="multipart/form-data"
                        class="card">
                        @csrf
                        <div class="card-header">
                            <div class="col">
                                <h4 class="card-title">Cadastrar Bomba</h4>
                            </div>
                            <div class="btn-list">
                                <a href="{{ route('admin.pumps') }}" class="btn btn-outline-primary me-auto"
                                    aria-label="Voltar">Voltar</a>
                                <button type="submit" name="save" value="save" class="btn btn-outline-success me-auto"
                                    aria-label="Salvar">Salvar</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="row">
                                    
                                    <div class="col-4">
                                        <div class="mb-3">
                                            <label class="form-label" for="model">Modelo</label>
                                            <input type="text" class="form-control" name="model" id="model"
                                                placeholder="Modelo" required aria-required="true">
                                        </div>
                                    </div>

                                    <div class="col-4">
                                        <div class="mb-3">
                                            <label class="form-label" for="flow">Vazão</label>
                                            <input type="number" step="0.1" class="form-control" name="flow" id="flow" placeholder="Vazão"
                                                required aria-required="true">
                                        </div>
                                    </div>

                                    <div class="col-4">
                                        <div class="mb-3">
                                            <label class="form-label" for="image">Imagem</label>
                                            <input type="file" class="form-control" name="image" id="image"
                                                required aria-required="true">
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="obs">Observação</label>
                                           <textarea name="obs" id="obs" class="form-control" rows="3"></textarea>
                                        </div>
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
