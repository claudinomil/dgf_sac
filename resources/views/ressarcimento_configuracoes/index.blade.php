@extends('layouts.master')

@section('title')
{{ __('Ressarcimento Configurações') }}
@endsection

@section('topbar_title')
{{ __('Ressarcimento Configurações') }}
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
                                        ['value' => 'ressarcimento_configuracoes.referencia', 'descricao' => 'Referência']
                                        ];
                                    @endphp

                                    <x-filter-crud :selectCampoPesquisar=$selectCampoPesquisar />
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tabela (Componente Blade) -->
                    <x-table-crud-ajax :colsNames="['Referência', 'Diretor Geral de Finanças', 'Chefe da DGF/2 - Contabilidade', 'Ações']" />
                    <input type="hidden" id="crudFieldsColumnsTable" name="crudFieldsColumnsTable" value="referencia,diretor_geral_financas,chefe_dgf2,action">
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Form -->
@include('ressarcimento_configuracoes.form')
@endsection

@section('script')
    <!-- scripts_ressarcimento_configuracoes.js -->
    <script src="{{ asset('assets/js/scripts_ressarcimento_configuracoes.js')}}"></script>
@endsection

@section('script-bottom')
@endsection
