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
                                <div class="col-12 col-md-6 pb-2">
                                    @if(temPermissao('homologacao_solicitacoes_create'))
                                    <x-button-crud op="1" onclick="crudCreate();" />
                                    @endif
                                </div>

                                <!-- Filtro no Banco -->
                                <div class="col-12 col-md-6 float-end">
                                    @php
                                        $selectCampoPesquisar = [
                                        ['value' => 'homologacao_solicitacoes.solicitacao', 'descricao' => 'Solicitação'],
                                        ['value' => 'homologacao_solicitacoes.tipo', 'descricao' => 'Tipo'],
                                        ['value' => 'homologacao_solicitacoes.prioridade', 'descricao' => 'Prioridade'],
                                        ['value' => 'homologacao_solicitacoes.resposta_status', 'descricao' => 'Status'],
                                        ['value' => 'submodulos.name', 'descricao' => 'Submódulo'],
                                        ['value' => 'users.name', 'descricao' => 'Usuário']
                                        ];
                                    @endphp

                                    <x-filter-crud :selectCampoPesquisar=$selectCampoPesquisar />
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tabela (Componente Blade) -->
                    <x-table-crud-ajax :colsNames="['Solicitação', 'Resposta', 'Ações']" />
                    <input type="hidden" id="crudFieldsColumnsTable" name="crudFieldsColumnsTable" value="solicitacao,resposta,action">
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Form -->
@include('homologacao_solicitacoes.form')
@endsection

@section('script')
    <!-- scripts_homologacao_solicitacoes.js -->
    <script src="{{ asset('assets/js/scripts_homologacao_solicitacoes.js')}}"></script>
@endsection

@section('script-bottom')
@endsection
