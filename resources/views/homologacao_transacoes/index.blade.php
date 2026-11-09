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
                    <div class="row">
                        <div class="col-12 col-md-7">
                            <!-- Tabela (Componente Blade) -->
                            <x-table-crud-ajax :colsNames="['Submódulo', 'Usuário', 'Operação', 'Data', 'Hora']" />
                            <input type="hidden" id="crudFieldsColumnsTable" name="crudFieldsColumnsTable" value="submoduloName,userName,operacao,data,hora">
                        </div>
                        <div class="col-12 col-md-5">
                            <div class="pt-4 font-size-12">
                                <table class="table table-bordered dt-responsive table-striped w-100" id="datatable-dados-users-ajax">
                                    <thead>
                                        <tr>
                                            <th class="bg-dark-subtle text-dark text-center" nowrap>USUÁRIO</th>
                                            <th class="bg-dark-subtle text-dark text-center" nowrap>C</th>
                                            <th class="bg-dark-subtle text-dark text-center" nowrap>I</th>
                                            <th class="bg-dark-subtle text-dark text-center" nowrap>A</th>
                                            <th class="bg-dark-subtle text-dark text-center" nowrap>E</th>
                                            <th class="bg-dark-subtle text-dark text-center" nowrap>T</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
    <!-- scripts_homologacao_transacoes.js -->
    <script src="{{ asset('assets/js/scripts_homologacao_transacoes.js')}}"></script>
@endsection

@section('script-bottom')
@endsection
