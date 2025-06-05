@extends('admin.layout.default')

@section('style')
    <link rel="stylesheet" href="{{ asset('style/list.css') }}">
@endsection

@section('title', 'Editar Planta')

@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 card">
                    <form action="{{ route('admin.plants.update', $plant->id) }}" method="post" enctype="multipart/form-data"
                        class="card">
                        @csrf
                        <div class="card-header">
                            <div class="col">
                                <h4 class="card-title">Editar Planta</h4>
                            </div>
                            <div class="btn-list">
                                <a href="{{ route('admin.plants') }}" class="btn btn-outline-primary me-auto"
                                    aria-label="Voltar">Voltar</a>
                                <button type="submit" name="save" value="save" class="btn btn-outline-success me-auto"
                                    aria-label="Salvar">Salvar</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                 <div class="row">
                                <div class="row">

                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="common_name">Nome Comum</label>
                                            <input type="text" class="form-control" name="common_name" id="common_name" value="{{ $plant->common_name }}"
                                                placeholder="Nome" required aria-required="true">
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="scientific_name">Nome Ciêntifico</label>
                                            <input type="number" step="0.1" class="form-control" name="scientific_name" value="{{ $plant->scientific_name }}"
                                                id="scientific_name" required aria-required="true">
                                        </div>
                                    </div>

                                    <select name="water_need" id="water_need" class="form-select" required>
                                        <option value="low">Pequena</option>
                                        <option value="medium">Média</option>
                                        <option value="high">Alta</option>
                                    </select>

                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="soil_type">Tipo de Solo Ideal</label>
                                            <select name="soil_type" id="soil_type" class="form-select" required>
                                                <option value="sandy">Arenoso</option>
                                                <option value="clayey">Argiloso</option>
                                                <option value="humus">Humoso</option>
                                                <option value="calcareous">Calcario</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="humidity_tolerance">Tolerancia Umidade (%)</label>
                                            <input type="text" class="form-control" name="humidity_tolerance" id="humidity_tolerance" value="{{ $plant->humidity_tolerance }}"
                                                placeholder="Nome" required aria-required="true" max="100"
                                                step="0.01" min="0">
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="temperature_tolerance">Tolerancia Temperatura
                                                (C°)</label>
                                            <input type="number" step="0.1" class="form-control"
                                                name="temperature_tolerance" id="temperature_tolerance" max="100" value="{{ $plant->temperature_tolerance }}"
                                                step="0.01" required aria-required="true">
                                        </div>
                                    </div>

                                    <div class="col-4">
                                        <div class="mb-3">
                                            <label class="form-label" for="image">Imagem</label>
                                            <input type="file" class="form-control" name="image" id="image"
                                                required aria-required="true">
                                                <div class="actualImg"><img src="{{ asset('storage/' . $plant->image) }}" alt=""> <span>Imagem Atual</span></div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="obs">Observação</label>
                                            <textarea name="obs" id="obs" class="form-control" value="{{ $plant->obs }}" rows="3">{!! $plant->obs !!}</textarea>
                                        </div>
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

    <script>
        let plant = @json($plant);
        $('#soil_type').val(plant->soil_type).change()
        $('#water_need').val(plant->water_need).change()
    </script>

@endsection
