@extends('layouts.master')

@section('title')
{{ __('Transações') }}
@endsection

@section('topbar_title')
{{ __('Transações') }}
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
                                        ['value' => 'transacoes.date', 'descricao' => __('Data')],
                                        ['value' => 'transacoes.time', 'descricao' => __('Hora')],
                                        ['value' => 'users.name', 'descricao' => __('Usuário')],
                                        ['value' => 'operacoes.name', 'descricao' => __('Operação')],
                                        ['value' => 'submodulos.name', 'descricao' => __('Submódulo')],
                                        ['value' => 'transacoes.dados', 'descricao' => __('Dados')]
                                        ];
                                    @endphp

                                    <x-filter-crud :selectCampoPesquisar=$selectCampoPesquisar />
                                </div>


                            </div>
                        </div>
                    </div>

                    <!-- Tabela (Componente Blade) -->
                    <x-table-crud-ajax :colsNames="[__('Data/Hora'), __('Usuário'), __('Submódulo/Operação'), __('Dados')]" />
                    <input type="hidden" id="crudFieldsColumnsTable" name="crudFieldsColumnsTable" value="date,userName,submoduloName,dados">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
@endsection

@section('script-bottom')
@endsection
