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
                                    @if(temPermissao('militares_fundos_saude_create'))
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
                                        ];
                                    @endphp

                                    <x-filter-crud :selectCampoPesquisar=$selectCampoPesquisar />
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tabela (Componente Blade) -->
                    <x-table-crud-ajax :colsNames="['Militar', 'Fundo Saúde', 'Ações']" />
                    <input type="hidden" id="crudFieldsColumnsTable" name="crudFieldsColumnsTable" value="militar,fundo_saude,action">
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Form -->
@include('militares_fundos_saude.form')
@endsection

@section('script')
    <!-- scripts_militares_fundos_saude.js -->
    <script src="{{ asset('assets/js/scripts_militares_fundos_saude.js')}}"></script>
@endsection

@section('script-bottom')
@endsection
