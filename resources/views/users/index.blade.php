@extends('layouts.master')

@section('title')
{{ __('Usuários') }}
@endsection

@section('topbar_title')
{{ __('Usuários') }}
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
                                    @if(temPermissao('users_create'))
                                    <x-button-crud op="1" onclick="crudCreate();" />
                                    @endif
                                </div>

                                <!-- Filtro no Banco -->
                                <div class="col-12 col-md-6 float-end">
                                    @php
                                        $selectCampoPesquisar = [
                                        ['value' => 'users.name', 'descricao' => 'Nome'],
                                        ['value' => 'users.email', 'descricao' => 'E-mail']
                                        ];
                                    @endphp

                                    <x-filter-crud :selectCampoPesquisar=$selectCampoPesquisar />
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tabela (Componente Blade) -->
                    <x-table-crud-ajax :colsNames="['#', 'Nome', 'E-mail', 'Ações']" />
                    <input type="hidden" id="crudFieldsColumnsTable" name="crudFieldsColumnsTable" value="avatar,name,email,action">
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Form -->
@include('users.form')
@endsection

@section('script')
    <!-- scripts_users.js -->
    <script src="{{ asset('assets/js/scripts_users.js')}}"></script>
@endsection

@section('script-bottom')
@endsection
