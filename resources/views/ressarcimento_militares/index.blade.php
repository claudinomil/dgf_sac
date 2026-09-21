@extends('layouts.master')

@section('title')
{{ __('Ressarcimento Militares') }}
@endsection

@section('topbar_title')
{{ __('Ressarcimento Militares') }}
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
                                    @if(temPermissao('ressarcimento_militares_create'))
                                    <x-button-crud op="99" model="3" bgColor="success" textColor="write" class="btn-sm waves-effect btn-label waves-light font-size-12" image="fa fa-file-import label-icon" label="Importar Militares" id="btnModalImportarMilitar" />
                                    @endif
                                </div>

                                <!-- Filtro no Banco -->
                                <div class="col-12 col-md-6 float-end">
                                    @php
                                        $selectCampoPesquisar = [
                                        ['value' => 'ressarcimento_militares.nome', 'descricao' => 'Nome'],
                                        ['value' => 'ressarcimento_militares.rg', 'descricao' => 'RG'],
                                        ['value' => 'ressarcimento_militares.referencia', 'descricao' => 'Referência'],
                                        ['value' => 'ressarcimento_militares.identidade_funcional', 'descricao' => 'Identidade Funcional'],
                                        ['value' => 'ressarcimento_militares.posto_graduacao', 'descricao' => 'Posto/Graduação'],
                                        ['value' => 'ressarcimento_militares.quadro_qbmp', 'descricao' => 'Quadro/QBMP'],
                                        ['value' => 'ressarcimento_militares.lotacao', 'descricao' => 'Lotação']
                                        ];
                                    @endphp

                                    <x-filter-crud :selectCampoPesquisar=$selectCampoPesquisar />
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tabela (Componente Blade) -->
                    <x-table-crud-ajax :colsNames="['Referência', 'Militar', 'Lotação', 'Ações']" />
                    <input type="hidden" id="crudFieldsColumnsTable" name="crudFieldsColumnsTable" value="referencia,militar,lotacao,action">
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Form -->
@include('ressarcimento_militares.form')
@endsection

@section('script')
    <!-- scripts_ressarcimento_militares.js -->
    <script src="{{ asset('assets/js/scripts_ressarcimento_militares.js')}}"></script>
@endsection

@section('script-bottom')
@endsection
