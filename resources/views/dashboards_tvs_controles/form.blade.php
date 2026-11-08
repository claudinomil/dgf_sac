<style>
    .indicador-grafico-toggle {
        display: block;
        width: 100%;
        margin: 0;
        cursor: pointer;
    }

    .indicador-grafico-checkbox {
        position: absolute;
        opacity: 0;
        width: 1px;
        height: 1px;
    }

    .indicador-grafico-botao {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 4px;
        width: 100%;
        height: 70px;
        padding: 10px 14px;
        border: 1px solid #dc3545;
        border-radius: 6px;
        background-color: #dc3545;
        color: #fff;
        text-align: center;
        font-size: 11px;
        transition: background-color 0.2s, border-color 0.2s;
    }

    .indicador-grafico-linha {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        font-weight: 600;
    }

    .indicador-grafico-icone {
        font-size: 17px;
    }

    .indicador-grafico-checkbox:checked+.indicador-grafico-botao {
        background-color: #198754;
        border-color: #198754;
    }

    .indicador-grafico-checkbox:focus-visible+.indicador-grafico-botao {
        outline: 3px solid rgba(13, 110, 253, 0.35);
        outline-offset: 2px;
    }
</style>

<!-- Formulario -->
<div class="font-size-12" id="crudForm">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <!-- Formulário - Form -->
                    <form id="{{ session('crudNameFormSubmodulo') }}" name="{{ session('crudNameFormSubmodulo') }}">
                        <fieldset>
                            <input type="hidden" id="frm_operacao" name="frm_operacao" />
                            <input type="hidden" id="registro_id" name="registro_id" />

                            <div class="row pt-4">
                                <div class="font-size-16 pb-4"><i class="fas fa-info text-start"></i>- <b>Informações Gerais</b></div>
                                <div class="form-group col-12 col-md-10 pb-3">
                                    <label class="form-label">Unidade</label>
                                    <select class="form-control" name="unidade_id" id="unidade_id" required="required">
                                        <option value="null">Selecione...</option>

                                        @foreach ($unidades as $unidade)
                                        <option value="{{ $unidade['id'] }}">{{ $unidade['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-12 col-md-2 pb-3">
                                    <label class="form-label">Ano</label>
                                    <select class="form-control" name="ano" id="ano" required="required">
                                        <option value="null">Todos</option>

                                        @for ($ano = date('Y'); $ano >= 2000; $ano--)
                                        <option value="{{ $ano }}">{{ $ano }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>

                            <div class="row pt-4">
                                <div class="font-size-16 pb-4"><i class="fas fa-chart-line text-start"></i>- <b>Indicadores</b></div>

                                @foreach ($indicadores as $indicador)
                                <div class="col-12 col-md-2 pb-3 p-1 indicador-grafico-container">
                                    <label class="indicador-grafico-toggle" for="{{ $indicador['identificador'] }}">
                                        <input class="indicador-grafico-checkbox" type="checkbox" id="{{ $indicador['identificador'] }}" name="{{ $indicador['identificador'] }}" value="1">
                                        <span class="indicador-grafico-botao">
                                            <span class="indicador-grafico-linha"><i class="fas fa-circle-xmark indicador-grafico-icone"></i></span>
                                            <span>{{ primeiraMaiuscula($indicador['titulo']) }}</span>
                                        </span>
                                    </label>

                                    <div class="row px-2">
                                        <div class="col-6">
                                            <label>Colunas</label>
                                            <select class="form-group col-12 text-center mt-1 indicador-grafico-select-colunas" id="{{ $indicador['identificador'] }}_colunas" name="{{ $indicador['identificador'] }}_colunas">
                                                @foreach (range(1, 12, 1) as $colunas)
                                                <option value="{{ $colunas }}" @selected($indicador['colunas'] == $colunas)>{{ $colunas }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-6">
                                            <label>Ordem</label>
                                            <select class="form-group col-12 text-center mt-1 indicador-grafico-select-ordem" id="{{ $indicador['identificador'] }}_ordem" name="{{ $indicador['identificador'] }}_ordem">
                                                @foreach (range(5, 120, 5) as $ordem)
                                                <option value="{{ $ordem }}" @selected($indicador['ordem'] == $ordem)>{{ $ordem }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <div class="row pt-4">
                                <div class="font-size-16 pb-4"><i class="fas fa-chart-pie text-start"></i>- <b>Gráficos</b></div>

                                @foreach ($graficos as $grafico)
                                <div class="col-12 col-md-2 pb-3 p-1 indicador-grafico-container">
                                    <label class="indicador-grafico-toggle" for="{{ $grafico['identificador'] }}">
                                        <input class="indicador-grafico-checkbox" type="checkbox" id="{{ $grafico['identificador'] }}" name="{{ $grafico['identificador'] }}" value="1">
                                        <span class="indicador-grafico-botao">
                                            <span class="indicador-grafico-linha"><i class="fas fa-circle-xmark indicador-grafico-icone"></i></span>
                                            <span>{{ primeiraMaiuscula($grafico['titulo']) }}</span>
                                        </span>
                                    </label>

                                    <div class="row">
                                        <div class="col-6">
                                            <label>Colunas</label>
                                            <select class="form-group col-12 text-center mt-1 indicador-grafico-select-colunas" id="{{ $grafico['identificador'] }}_colunas" name="{{ $grafico['identificador'] }}_colunas">
                                                @foreach (range(1, 12, 1) as $colunas)
                                                <option value="{{ $colunas }}" @selected($grafico['colunas'] == $colunas)>{{ $colunas }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-6">
                                            <label>Ordem</label>
                                            <select class="form-group col-12 text-center mt-1 indicador-grafico-select-ordem" id="{{ $grafico['identificador'] }}_ordem" name="{{ $grafico['identificador'] }}_ordem">
                                                @foreach (range(5, 120, 5) as $ordem)
                                                <option value="{{ $ordem }}" @selected($grafico['ordem'] == $ordem)>{{ $ordem }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
