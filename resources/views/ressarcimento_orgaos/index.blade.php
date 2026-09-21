@extends('layouts.master')

@section('title')
{{ __('Ressarcimento Orgãos') }}
@endsection

@section('topbar_title')
{{ __('Ressarcimento Orgãos') }}
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
                                        ['value' => 'ressarcimento_orgaos.name', 'descricao' => 'Nome'],
                                        ['value' => 'ressarcimento_orgaos.cnpj', 'descricao' => 'CNPJ'],
                                        ['value' => 'ressarcimento_orgaos.ug', 'descricao' => 'UG'],
                                        ['value' => 'ressarcimento_orgaos.responsavel', 'descricao' => 'Responsável'],
                                        ['value' => 'esferas.name', 'descricao' => 'Esfera'],
                                        ['value' => 'poderes.name', 'descricao' => 'Poder'],
                                        ['value' => 'tratamentos.name', 'descricao' => 'Tratamento'],
                                        ['value' => 'vocativos.name', 'descricao' => 'Vocativo'],
                                        ['value' => 'ressarcimento_funcoes.name', 'descricao' => 'Função'],
                                        ['value' => 'ressarcimento_orgaos.lotacao', 'descricao' => 'Lotação']
                                        ];
                                    @endphp

                                    <x-filter-crud :selectCampoPesquisar=$selectCampoPesquisar />
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tabela (Componente Blade) -->
                    <x-table-crud-ajax :colsNames="['Nome', 'Responsável', 'Ações']" />
                    <input type="hidden" id="crudFieldsColumnsTable" name="crudFieldsColumnsTable" value="name,responsavel,action">
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Form -->
@include('ressarcimento_orgaos.form')
@endsection

@section('script')
    <!-- scripts_ressarcimento_orgaos.js -->
    <script src="{{ asset('assets/js/scripts_ressarcimento_orgaos.js')}}"></script>
@endsection

@section('script-bottom')
@endsection
