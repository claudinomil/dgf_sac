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
                                    @if(temPermissao('militares_auxilios_fardamentos_create'))
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
                                        ['value' => 'auxilio_fardamento_tipos.name', 'descricao' => 'Auxílio Fardamento Tipo'],
                                        ];
                                    @endphp

                                    <x-filter-crud :selectCampoPesquisar=$selectCampoPesquisar />
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tabela (Componente Blade) -->
                    <x-table-crud-ajax :colsNames="['Militar', 'Auxílio Fardamento', 'Ações']" />
                    <input type="hidden" id="crudFieldsColumnsTable" name="crudFieldsColumnsTable" value="militar,auxilio_fardamento,action">
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Form -->
@include('militares_auxilios_fardamentos.form')
@endsection

@section('script')
    <!-- scripts_militares_auxilios_fardamentos.js -->
    <script src="{{ asset('assets/js/scripts_militares_auxilios_fardamentos.js')}}"></script>
@endsection

@section('script-bottom')
@endsection
