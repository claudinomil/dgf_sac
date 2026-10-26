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
                                <div class="col-12 col-md-6 float-end">&nbsp;</div>
                            </div>
                        </div>
                    </div>

                    <!-- Tabela (Componente Blade) -->
                    <x-table-crud-ajax :colsNames="['Unidade', 'Ano', 'Indicadores', 'Gráficos', 'Ações']" />
                    <input type="hidden" id="crudFieldsColumnsTable" name="crudFieldsColumnsTable" value="unidade,ano,indicadores,graficos,action">
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Form -->
@include('dashboards_tvs_controles.form')
@endsection

@section('script')
    <!-- scripts_dashboards_tvs_controles.js -->
    <script src="{{ asset('assets/js/scripts_dashboards_tvs_controles.js')}}"></script>
@endsection

@section('script-bottom')
@endsection