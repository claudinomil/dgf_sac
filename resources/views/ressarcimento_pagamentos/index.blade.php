@extends('layouts.master')

@section('title')
{{ __('Ressarcimento Pagamentos') }}
@endsection

@section('topbar_title')
{{ __('Ressarcimento Pagamentos') }}
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
                                    @if(temPermissao('ressarcimento_pagamentos_create'))
                                    <x-button-crud op="99" model="3" bgColor="success" textColor="write" class="btn-sm waves-effect btn-label waves-light font-size-12" image="fa fa-file-import label-icon" label="Importar Pagamentos" id="btnModalImportarPagamentos" />
                                    @endif
                                </div>

                                <!-- Filtro no Banco -->
                                <div class="col-12 col-md-6 float-end">
                                    @php
                                        $selectCampoPesquisar = [
                                        ['value' => 'ressarcimento_pagamentos.nome', 'descricao' => 'Nome'],
                                        ['value' => 'ressarcimento_pagamentos.rg', 'descricao' => 'RG'],
                                        ['value' => 'ressarcimento_pagamentos.referencia', 'descricao' => 'Referência'],
                                        ['value' => 'ressarcimento_pagamentos.identidade_funcional', 'descricao' => 'Identidade Funcional'],
                                        ['value' => 'ressarcimento_pagamentos.nome_cargo', 'descricao' => 'Nome Cargo'],
                                        ['value' => 'ressarcimento_pagamentos.posto_graduacao', 'descricao' => 'Posto/Graduação'],
                                        ['value' => 'ressarcimento_pagamentos.ua', 'descricao' => 'UA'],
                                        ['value' => 'ressarcimento_pagamentos.cpf', 'descricao' => 'CPF'],
                                        ['value' => 'ressarcimento_pagamentos.bruto', 'descricao' => 'Bruto'],
                                        ['value' => 'ressarcimento_pagamentos.desconto', 'descricao' => 'Desconto'],
                                        ['value' => 'ressarcimento_pagamentos.liquido', 'descricao' => 'Líquido'],
                                        ['value' => 'ressarcimento_pagamentos.soldo', 'descricao' => 'Soldo'],
                                        ['value' => 'ressarcimento_pagamentos.hospital10', 'descricao' => 'Hospital 10'],
                                        ['value' => 'ressarcimento_pagamentos.rioprevidencia22', 'descricao' => 'Rioprevidência 22'],
                                        ['value' => 'ressarcimento_pagamentos.etapa_ferias', 'descricao' => 'Etapa Férias'],
                                        ['value' => 'ressarcimento_pagamentos.etapa_destacado', 'descricao' => 'Etapa Destacado'],
                                        ['value' => 'ressarcimento_pagamentos.ajuda_fardamento', 'descricao' => 'Ajuda Fardamento'],
                                        ['value' => 'ressarcimento_pagamentos.habilitacao_profissional', 'descricao' => 'Habilitação Profissional'],
                                        ['value' => 'ressarcimento_pagamentos.gret', 'descricao' => 'GRET'],
                                        ['value' => 'ressarcimento_pagamentos.ferias', 'descricao' => 'Férias'],
                                        ['value' => 'ressarcimento_pagamentos.raio_x', 'descricao' => 'Raio X'],
                                        ['value' => 'ressarcimento_pagamentos.trienio', 'descricao' => 'Triênio'],
                                        ['value' => 'ressarcimento_pagamentos.fundo_saude', 'descricao' => 'Fundo Saúde'],
                                        ['value' => 'ressarcimento_pagamentos.abono_permanencia', 'descricao' => 'Abono Permanência'],
                                        ['value' => 'ressarcimento_pagamentos.auxilio_transporte', 'descricao' => 'Auxílio Transporte'],
                                        ['value' => 'ressarcimento_pagamentos.gram', 'descricao' => 'GRAM'],
                                        ['value' => 'ressarcimento_pagamentos.auxilio_fardamento', 'descricao' => 'Auxílio Fardamento'],
                                        ['value' => 'ressarcimento_pagamentos.cidade', 'descricao' => 'Cidade']
                                        ];
                                    @endphp

                                    <x-filter-crud :selectCampoPesquisar=$selectCampoPesquisar />
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tabela (Componente Blade) -->
                    <x-table-crud-ajax :colsNames="['Referência', 'Militar', 'Lotação', 'Valores', 'Ações']" />
                    <input type="hidden" id="crudFieldsColumnsTable" name="crudFieldsColumnsTable" value="referencia,militar,lotacao,valores,action">
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Form -->
@include('ressarcimento_pagamentos.form')
@endsection

@section('script')
    <!-- scripts_ressarcimento_pagamentos.js -->
    <script src="{{ asset('assets/js/scripts_ressarcimento_pagamentos.js')}}"></script>
@endsection

@section('script-bottom')
@endsection
