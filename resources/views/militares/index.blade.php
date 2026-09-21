@extends('layouts.master')

@section('title')
{{ __('Militares') }}
@endsection

@section('topbar_title')
{{ __('Militares') }}
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
                                    @if(temPermissao('militares_create'))
                                    <x-button-crud op="1" onclick="crudCreate();" />
                                    @endif
                                </div>

                                <!-- Filtro no Banco -->
                                <div class="col-12 col-md-6 float-end">
                                    @php
                                        $selectCampoPesquisar = [
                                        ['value' => 'militares.rg', 'descricao' => 'RG'],
                                        ['value' => 'militares.identidade_funcional', 'descricao' => 'ID Funcional'],
                                        ['value' => 'militares.nome', 'descricao' => 'Nome'],
                                        ['value' => 'situacoes.name', 'descricao' => 'Situação'],
                                        ['value' => 'graduacoes.name', 'descricao' => 'Posto/Graduação'],
                                        ['value' => 'quadros.name', 'descricao' => 'Quadro'],
                                        ['value' => 'unidades.name', 'descricao' => 'Unidade']
                                        ];
                                    @endphp

                                    <x-filter-crud :selectCampoPesquisar=$selectCampoPesquisar />
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tabela (Componente Blade) -->
                    <x-table-crud-ajax :colsNames="['#', 'Militar', 'Unidade/Prestando Serviço', 'Ações']" />
                    <input type="hidden" id="crudFieldsColumnsTable" name="crudFieldsColumnsTable" value="fotografia,militar,unidade,action">
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Form -->
@include('militares.form')
@endsection

@section('script')
    <!-- scripts_militares.js -->
    <script src="{{ asset('assets/js/scripts_militares.js')}}"></script>
@endsection

@section('script-bottom')
@endsection
