@extends('admin.layout.default')

@section('style')
    <link rel="stylesheet" href="{{ asset('style/list.css') }}">
@endsection

@section('title', 'Editar Bomba')

@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 card">
                    <form action="{{ route('admin.pumps.update', $pump->id) }}" method="post" enctype="multipart/form-data"
                        class="card">
                        @csrf
                        @method('PUT')
                        <div class="card-header">
                            <div class="col">
                                <h4 class="card-title">Editar Bomba</h4>
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
                                            <input type="text" class="form-control" name="model" id="model" value="{{ $pump->model }}"
                                                placeholder="Nome" required aria-required="true">
                                        </div>
                                    </div>

                                    <div class="col-4">
                                        <div class="mb-3">
                                            <label class="form-label" for="flow">Vazão</label>
                                            <input type="number" step="0.1" class="form-control" name="flow" id="flow" value="{{ $pump->flow }}"
                                                required aria-required="true">
                                        </div>
                                    </div>

                                    <div class="col-4">
                                        <div class="mb-3">
                                            <label class="form-label" for="image">Imagem</label>
                                            <input type="file" class="form-control" name="image" id="image"
                                               >
                                               <div class="actualImg"><img src="{{ asset('storage/' . $pump->image) }}" alt=""> <span>Imagem Atual</span></div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="obs">Observação</label>
                                           <textarea name="obs" id="obs" class="form-control" value="{{ $pump->obs }}" rows="3"> {!! $pump->obs !!}</textarea>
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
