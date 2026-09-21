@extends('layouts.master')

@section('title')
{{ __('Referências') }}
@endsection

@section('topbar_title')
{{ __('Referências') }}
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
                                    @if(temPermissao('ressarcimento_referencias_create'))
                                    <x-button-crud op="1" onclick="crudCreate();" />
                                    @endif
                                </div>

                                <!-- Filtro no Banco -->
                                <div class="col-12 col-md-6 float-end">
                                    @php
                                        $selectCampoPesquisar = [
                                        ['value' => 'ressarcimento_referencias.referencia', 'descricao' => 'Referência'],
                                        ['value' => 'ressarcimento_referencias.ano', 'descricao' => 'Ano'],
                                        ['value' => 'ressarcimento_referencias.mes', 'descricao' => 'Mês']
                                        ];
                                    @endphp

                                    <x-filter-crud :selectCampoPesquisar=$selectCampoPesquisar />
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tabela (Componente Blade) -->
                    <x-table-crud-ajax :colsNames="['Referência', 'Ano', 'Mês', 'Parte', 'Ações']" />
                    <input type="hidden" id="crudFieldsColumnsTable" name="crudFieldsColumnsTable" value="referencia,ano,mes,parte,action">
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Form -->
@include('ressarcimento_referencias.form')
@endsection

@section('script')
    <!-- scripts_ressarcimento_referencias.js -->
    <script src="{{ asset('assets/js/scripts_ressarcimento_referencias.js')}}"></script>
@endsection

@section('script-bottom')
@endsection
