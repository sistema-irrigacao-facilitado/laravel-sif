@extends('admin.layout.default')

@section('style')
    <link rel="stylesheet" href="{{ asset('style/list.css') }}">
@endsection

@section('title', 'Colaboradores')

@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header hcard">
                            <div></div>

                            <div class="thead-buttons">
                                <div class="text-end" style="margin-right: 10px;">
                                    <a href="{{ route('filter_clear.page', 'collaborator') }}" class="btn btn-primary">Limpar
                                        filtro</a>
                                </div>
                                <div class="text-end" style="margin-right: 10px;">
                                    <button type="submit" onclick='$("#filtro").submit()' class="btn btn-primary"
                                        form="filtro">Filtrar</button>
                                </div>
                                <div class="text-end">
                                    <a class="btn btn-green" href="">Criar colaborador</a>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table card-table  table-vcenter text-nowrap datatable">
                                <thead>
                                    <tr>
                                        <form action="{{ route('filter.page', 'collaborator') }}" method="POST" id="filtro">
                                            @csrf
                                            <td>
                                                <div class="mb-3">
                                                    <div class="input-group">
                                                        <label class="input-group-text" for="id">Id: </label>
                                                        <input type="number" min="1" name="id" id="id"
                                                            class="form-control">
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="mb-3">
                                                    <div class="input-group">
                                                        <label class="input-group-text" for="name">Nome: </label>
                                                        <input type="text" name="name" id="name"
                                                            class="form-control">
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="mb-3">
                                                    <div class="input-group">
                                                        <label class="input-group-text" for="telephone">Telefone: </label>
                                                        <input type="text" name="telephone" id="telephone"
                                                            class="form-control">
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="mb-3">
                                                    <div class="input-group">
                                                        <label class="input-group-text" for="email">E-Mail: </label>
                                                        <input type="text" name="email" id="email"
                                                            class="form-control">
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="mb-3 row">
                                                    <label class="col-3 col-form-label">De:</label>
                                                    <div class="col">
                                                        <input class="form-control" id="created_at_from"
                                                            name="created_at_from" placeholder="Select a date"
                                                            type="date">
                                                    </div>
                                                </div>
                                                <div class="mb-3 row">
                                                    <label class="col-3 col-form-label">Até:</label>
                                                    <div class="col">
                                                        <input class="form-control" id="created_at_to" name="created_at_to"
                                                            placeholder="Select a date" type="date">
                                                    </div>
                                                </div>
                                            </td>

                                            <td>
                                                <div class="mb-3">
                                                    <div class="input-group">
                                                        <label class="input-group-text" for="status">Status: </label>
                                                        <select class="form-select" name="status" id="status">
                                                            <option value="">Qualquer</option>
                                                            <option value="2">Ativo</option>
                                                            <option value="9">Desativado</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </td>
                                            <td></td>
                                        </form>
                                    </tr>
                                    <tr>
                                        <th>ID.</th>
                                        <th>Nome</th>
                                        <th>Telefone</th>
                                        <th>E-Mail</th>>
                                        <th>Criado</th>
                                        <th>Status</th>
                                        <th>Ação</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($collection as $item)
                                        <tr id="{{ $item->id }}">
                                            <td>
                                                {{ $item->id }}
                                            </td>
                                            <td>
                                                {{ $item->name }}
                                            </td>
                                            <td>
                                                {{ $item->telephone }}
                                            </td>
                                            <td>
                                                {{ $item->email }}
                                            </td>
                                            
                                            <td>
                                                {{ dateFormat($item->created_at) }}
                                            </td>
                                            <td>
                                                {!! statusSpan($item->status) !!}

                                            </td>
                                            <td>
                                                
                                                    <div class="dropdown">
                                                        <a href="#" class="btn dropdown-toggle"
                                                            data-bs-toggle="dropdown">Ação</a>
                                                        <div class="dropdown-menu">

                                                            <a class="dropdown-item" href="{{ route('admin.edit', $item->id) }}">
                                                                Editar
                                                            </a>

                                                          
                                                                <a href="{{ route('admin.users.delete', $item->id) }}"
                                                                    class="dropdown-item bg-danger text-light">
                                                                    Excluir
                                                                </a>
                                                         
                                                            @if ($item->status == 2)
                                                                <a href="{{ route('admin.updateStatus', [$item->id, 9]) }}"
                                                                    class="dropdown-item bg-danger text-light">
                                                                    Desativar
                                                                </a>
                                                            @else
                                                                <a href="{{ route('admin.updateStatus', [$item->id, 2]) }}"
                                                                    class="dropdown-item bg-danger text-light">
                                                                    Ativar
                                                                </a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="card-footer d-flex justify-content-center align-items-center">
                            {{ $collection->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script src="../../js/tabelas.js"></script>
@endsection
