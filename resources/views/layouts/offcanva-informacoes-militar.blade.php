<div class="offcanvas offcanvas-start w-100" tabindex="-1" id="offcanvaInformacoesMilitar" aria-labelledby="offcanvaInformacoesMilitarLabel">
    <div class="offcanvas-header position-relative d-flex align-items-center">
        <img src="{{ asset('assets/images/logo_cbmerj_dgf_branco.png') }}" height="50" />
        <h3 class="offcanvas-title position-absolute start-50 translate-middle-x text-white" id="offcanvaInformacoesMilitarLabel">Informações do Militar</h3>
        <a href="#" class="btn-close ms-auto" data-bs-dismiss="offcanvas"><i class="fa fa-close font-size-20 text-white"></i></a>
    </div>
    <div class="offcanvas-body bg-light">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-body text-center">
                            <img src="{{ asset('/assets/images/militares/fotografia-0.png') }}" class="rounded-circle mb-3" width="110" id="militarImgFotografia">
                            <div class="font-size-13" id="militarName"></div>
                        </div>
                    </div>
                    <div class="card mb-3">
                        <div class="card-body font-size-11">
                            <div class="table-responsive">
                                <table class="table table-nowrap mb-0">
                                    <tbody>
                                        <tr>
                                            <th scope="row">RG :</th>
                                            <td id="militarInformacaoRg"></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Nome :</th>
                                            <td id="militarInformacaoNome"></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Nome Guerra :</th>
                                            <td id="militarInformacaoNomeGuerra"></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Identidade Funcional :</th>
                                            <td id="militarInformacaoIdentidadeFuncional"></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Data Ingresso :</th>
                                            <td id="militarInformacaoDataIngresso"></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Situação :</th>
                                            <td id="militarInformacaoSituacao"></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Posto/Graduação :</th>
                                            <td id="militarInformacaoPostoGraduacao"></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Quadro :</th>
                                            <td id="militarInformacaoQuadro"></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Comportamento :</th>
                                            <td id="militarInformacaoComportamento"></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Unidade :</th>
                                            <td id="militarInformacaoUnidade"></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Prestando Serviço :</th>
                                            <td id="militarInformacaoPrestandoServico"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card mb-3">
                        <div class="card-body font-size-12">
                            <h6>{{ __('Alterar fotografia') }}</h6>
                            <form id="frm_informacoes_militar_update_fotografia" enctype="multipart/form-data">
                                @csrf

                                <input type="hidden" id="informacoes_militar_id" name="informacoes_militar_id">

                                <div class="mb-3">
                                    <label>{{ __('Fotografia') }}</label>
                                    <input type="file" name="informacoes_militar_fotografia" id="informacoes_militar_fotografia" class="form-control form-control-sm" accept="image/*">
                                </div>

                                <button type="button" class="btn btn-primary btn-sm" onclick="crudOffCanvaInformacoesMilitarUpdateFotografia()" id="btnOffCanvaInformacoesMilitarUpdateFotografia">{{ __('Alterar fotografia') }}</button>
                            </form>
                        </div>
                    </div>
                    <div class="card mb-3">
                        <div class="card-body font-size-12">
                            <h6>{{ __('Ajudas de Custos') }}</h6>
                            <div class="table-responsive">
                                <table class="table table-striped mb-0 small">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Tipo</th>
                                            <th>Boletim</th>
                                            <th>Pagamento</th>
                                            <th>Processo SEI</th>
                                        </tr>
                                    </thead>
                                    <tbody id="offcanvaInformacoesMilitarAjudasCustosTbody">&nbsp;</tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-3">
                        <div class="card-body font-size-12">
                            <h6>{{ __('Auxílios Fardamentos') }}</h6>
                            <div class="table-responsive">
                                <table class="table table-striped mb-0 small">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Tipo</th>
                                            <th>Boletim</th>
                                            <th>Pagamento</th>
                                            <th>Processo SEI</th>
                                        </tr>
                                    </thead>
                                    <tbody id="offcanvaInformacoesMilitarAuxiliosFardamentosTbody">&nbsp;</tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-3">
                        <div class="card-body font-size-12">
                            <h6>{{ __('Cursos') }}</h6>
                            <div class="table-responsive">
                                <table class="table table-striped mb-0 small">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Curso</th>
                                            <th>Boletim</th>
                                            <th>Conceito</th>
                                        </tr>
                                    </thead>
                                    <tbody id="offcanvaInformacoesMilitarCursosTbody">&nbsp;</tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-3">
                        <div class="card-body font-size-12">
                            <h6>{{ __('Dependentes') }}</h6>
                            <div class="table-responsive">
                                <table class="table table-striped mb-0 small">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Parentesco</th>
                                            <th>Nome</th>
                                        </tr>
                                    </thead>
                                    <tbody id="offcanvaInformacoesMilitarDependentesTbody">&nbsp;</tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-3">
                        <div class="card-body font-size-12">
                            <h6>{{ __('Fundos de Saúde') }}</h6>
                            <div class="table-responsive">
                                <table class="table table-striped mb-0 small">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Cancelar Desconto</th>
                                            <th>Acesso Sistema Saúde</th>
                                            <th>Tipo Acesso</th>
                                        </tr>
                                    </thead>
                                    <tbody id="offcanvaInformacoesMilitarFundosSaudeTbody">&nbsp;</tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-3">
                        <div class="card-body font-size-12">
                            <h6>{{ __('Férias (últimos 5 anos)') }}</h6>
                            <div class="table-responsive">
                                <table class="table table-striped mb-0 small">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Ano</th>
                                            <th>Referência</th>
                                            <th>Mês</th>
                                        </tr>
                                    </thead>
                                    <tbody id="offcanvaInformacoesMilitarFeriasTbody">&nbsp;</tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-3">
                        <div class="card-body font-size-12">
                            <h6>{{ __('Pensões') }}</h6>
                            <div class="table-responsive">
                                <table class="table table-striped mb-0 small">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Tipo</th>
                                            <th>Beneficiário</th>
                                            <th>Desconto</th>
                                            <th>Representante Legal</th>
                                        </tr>
                                    </thead>
                                    <tbody id="offcanvaInformacoesMilitarPensoesTbody">&nbsp;</tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-3">
                        <div class="card-body font-size-12">
                            <h6>{{ __('Tempos Averbados') }}</h6>
                            <div class="table-responsive">
                                <table class="table table-striped mb-0 small">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Local</th>
                                            <th>Data Ingresso</th>
                                            <th>Data Término</th>
                                            <th>Tempo Apurado</th>
                                        </tr>
                                    </thead>
                                    <tbody id="offcanvaInformacoesMilitarTemposAverbadosTbody">&nbsp;</tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
