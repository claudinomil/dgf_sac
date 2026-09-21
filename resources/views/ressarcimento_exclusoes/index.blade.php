@extends('layouts.master')

@section('title')
{{ __('Exclusões') }}
@endsection

@section('topbar_title')
{{ __('Exclusões') }}
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
                                    @if(temPermissao('ressarcimento_exclusoes_create'))
                                    <button onclick="prepararExclusao();" type="button" class="btn btn-sm btn-primary text-white mb-2 font-size-12 waves-effect btn-label waves-light " data-bs-toggle="tooltip" data-bs-placement="top" data-bs-target="" data-bs-original-title="Excluir último Ressarcimento">
                                        <i class="bx bx-trash label-icon"></i>
                                        Excluir último Ressarcimento
                                    </button>
                                    @endif
                                </div>

                                <!-- Filtro no Banco -->
                                <div class="col-12 col-md-6 float-end">
                                    @php
                                        $selectCampoPesquisar = [
                                        ['value' => 'ressarcimento_exclusoes.referencia', 'descricao' => 'Referência'],
                                        ['value' => 'ressarcimento_exclusoes.ano', 'descricao' => 'Ano'],
                                        ['value' => 'ressarcimento_exclusoes.mes', 'descricao' => 'Mês']
                                        ];
                                    @endphp

                                    <x-filter-crud :selectCampoPesquisar=$selectCampoPesquisar />
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tabela (Componente Blade) -->
                    <x-table-crud-ajax :colsNames="['Referência', 'Ano', 'Mês', 'Parte', 'Militares']" />
                    <input type="hidden" id="crudFieldsColumnsTable" name="crudFieldsColumnsTable" value="referencia,ano,mes,parte,militares">
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Form -->
@include('ressarcimento_exclusoes.form')
@endsection

@section('script')
    <!-- scripts_ressarcimento_exclusoes.js -->
    <script src="{{ asset('assets/js/scripts_ressarcimento_exclusoes.js')}}"></script>
@endsection

@section('script-bottom')
@endsection
