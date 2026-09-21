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
                                    @if(temPermissao('militares_cursos_create'))
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
                                        ['value' => 'cursos.name', 'descricao' => 'Curso'],
                                        ];
                                    @endphp

                                    <x-filter-crud :selectCampoPesquisar=$selectCampoPesquisar />
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tabela (Componente Blade) -->
                    <x-table-crud-ajax :colsNames="['Militar', 'Curso', 'Ações']" />
                    <input type="hidden" id="crudFieldsColumnsTable" name="crudFieldsColumnsTable" value="militar,curso,action">
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Form -->
@include('militares_cursos.form')
@endsection

@section('script')
    <!-- scripts_militares_cursos.js -->
    <script src="{{ asset('assets/js/scripts_militares_cursos.js')}}"></script>
@endsection

@section('script-bottom')
@endsection
