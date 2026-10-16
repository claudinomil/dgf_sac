@extends('layouts.master')

@section('title')
{{ session('crudNameSubmodulo') }}
@endsection

@section('topbar_title')
{{ session('crudNameSubmodulo') }}
@endsection

@section('content')

<div id="crudTable">
    <div class="row">
        <div class="col-12">
            <div class="card border-0 mb-4">
                <div class="card-body">
                    <!-- Botoes -->
                    <div class="row">
                        <div class="col-12">
                            <div class="row">
                                <!-- Botões -->
                                <div class="col-12 col-md-6 pb-2">&nbsp;</div>

                                <!-- Filtro no Banco -->
                                <div class="col-12 col-md-6 float-end">
                                    @php
                                        $selectCampoPesquisar = [
                                        ['value' => 'submodulos.name', 'descricao' => 'Submódulo'],
                                        ['value' => 'homologacao_transacoes.operacao', 'descricao' => 'Operação'],
                                        ['value' => 'users.name', 'descricao' => 'Usuário'],
                                        ['value' => 'homologacao_transacoes.data', 'descricao' => 'Data'],
                                        ];
                                    @endphp

                                    <x-filter-crud :selectCampoPesquisar=$selectCampoPesquisar />
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tabela (Componente Blade) -->
                    <x-table-crud-ajax :colsNames="['Submódulo', 'Usuário', 'Operação', 'Data', 'Hora']" />
                    <input type="hidden" id="crudFieldsColumnsTable" name="crudFieldsColumnsTable" value="submoduloName,userName,operacao,data,hora">
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
    <!-- scripts_homologacao_transacoes.js -->
    <script src="{{ asset('assets/js/scripts_homologacao_transacoes.js')}}"></script>
@endsection

@section('script-bottom')
@endsection
