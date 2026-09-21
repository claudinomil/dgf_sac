@extends('layouts.master')

@section('title')
{{ __('Grupos') }}
@endsection

@section('topbar_title')
{{ __('Grupos') }}
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
                                    @if(temPermissao('grupos_create'))
                                    <x-button-crud op="1" onclick="crudCreate();" />
                                    @endif
                                </div>

                                <!-- Filtro no Banco -->
                                <div class="col-12 col-md-6 float-end">
                                    @php
                                        $selectCampoPesquisar = [
                                        ['value' => 'grupos.name', 'descricao' => 'Nome']
                                        ];
                                    @endphp

                                    <x-filter-crud :selectCampoPesquisar=$selectCampoPesquisar />
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tabela (Componente Blade) -->
                    <x-table-crud-ajax :colsNames="['Nome', 'Ações']" />
                    <input type="hidden" id="crudFieldsColumnsTable" name="crudFieldsColumnsTable" value="name,action">
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Form -->
@include('grupos.form')
@endsection

@section('script')
    <!-- scripts_grupos.js -->
    <script src="{{ asset('assets/js/scripts_grupos.js')}}"></script>
@endsection

@section('script-bottom')
@endsection
