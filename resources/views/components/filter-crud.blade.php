<div class="row" id="crudFilterRepeater">
    <div class="float-end" id="filterRepeaterList">
        <div class="row filterRepeaterItem" data-id="0">
            <div class="input-group py-1">
                <!-- Botões -->
                <button type="button" class="btn btn-sm btn-danger float-end" id="filter_crud_botao_excluir" name="filter_crud_botao_excluir" title="Excluir Filtro" value="0"><i class="fa fa-trash-alt font-size-12"></i></button>

                <!-- Tipo Condição-->
                <select class="form-select font-size-11 me-1" id="filter_crud_tipo_condicao" name="filter_crud_tipo_condicao" title="Tipo de Condição" style="max-width: fit-content !important;">
                    <option value="1">E</option>
                    <option value="2">OU</option>
                </select>

                <!--Campos para Pesquisar-->
                <select class="form-select font-size-11 me-1" id="filter_crud_campo_pesquisar" name="filter_crud_campo_pesquisar" title="Campo Pesquisar" style="max-width: fit-content !important;">
                    @foreach($selectCampoPesquisar as $dado)
                        <option value="{{$dado['value']}}">{{$dado['descricao']}}</option>
                    @endforeach
                </select>

                <!-- Operação para Realizar-->
                <select class="form-select font-size-11 me-1" id="filter_crud_operacao_realizar" name="filter_crud_operacao_realizar" title="Operação" style="max-width: fit-content !important;">
                    <option value="1">Contém</option>
                    <option value="2">Igual</option>
                    <option value="3">Maior que</option>
                    <option value="4">Maior ou igual a</option>
                    <option value="5">Menor que</option>
                    <option value="6">Menor ou igual a</option>
                    <option value="7">No início</option>
                    <option value="8">No fim</option>
                </select>

                <!-- Dado para Pesquisar-->
                <input type="text" id="filter_crud_dado_pesquisar" name="filter_crud_dado_pesquisar" class="form-control font-size-11" title="Dado Pesquisar" placeholder="Dado" style="min-width: 20% !important;" />

                <!-- Botões -->
                <button type="button" class="btn btn-sm btn-success float-end" name="filter_crud_botao_executar" title="Executar Filtro(s)" onclick="crudFilterExecutar();"><i class="fa fa-filter font-size-12"></i></button>
                <button type="button" class="btn btn-sm btn-primary float-end" name="filter_crud_botao_novo" title="Novo Filtro" style="border-radius: 0rem 0.25rem 0.25rem 0rem;" onclick="crudFilterInsertLine();"><i class="fa fa-plus font-size-12"></i></button>
            </div>
        </div>
    </div>
</div>
