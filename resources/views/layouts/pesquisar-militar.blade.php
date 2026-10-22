<!-- Inclusão de campos hiddens e da Pesquisa de Militar para Incluir Registro -->

<input type="hidden" id="militarSituacaoId" name="militarSituacaoId" value="0" />
<input type="hidden" id="militarSituacaoId_token" name="militarSituacaoId_token" value="xxxyyyzzz" />

@if(session('crudPrefixPermissaoSubmodulo') !== 'militares')

<input type="hidden" id="militar_id" name="militar_id" value="0" />
<input type="hidden" id="militar_id_token" name="militar_id_token" value="xxxyyyzzz" />

<div class="row pt-4" id="divPesquisarMilitar" style="display: none;">
    <div class="font-size-16 pb-4"><i class="fas fa-person-military-pointing text-start"></i>- <b>Pesquisar Militar</b></div>
    <div class="form-group col-12 col-md-12 pb-3">
        <label class="form-label">Nome / RG / Id. Funcional</label>
        <input type="text" class="form-control" id="pesquisar_militar" name="pesquisar_militar">
        <div id="autocomplete_militar" class="list-group position-absolute col-12 col-md-8" style="z-index:999;"></div>
    </div>
</div>

<div class="row pt-4">
    <div class="font-size-16 pb-4"><i class="fas fa-person-military-pointing text-start"></i>- <b>Informações Militar</b></div>
    <div class="form-group col-12 col-md-8 pb-3">
        <label class="form-label">Nome</label>
        <input type="text" class="form-control text-uppercase" id="militarNome" name="militarNome">
    </div>
    <div class="form-group col-12 col-md-2 pb-3">
        <label class="form-label">RG</label>
        <input type="text" class="form-control text-uppercase" id="militarRg" name="militarRg">
    </div>
    <div class="form-group col-12 col-md-2 pb-3">
        <label class="form-label">Id. Funcional</label>
        <input type="text" class="form-control text-uppercase" id="militarIdentidadeFuncional" name="militarIdentidadeFuncional">
    </div>
    <div class="form-group col-12 col-md-4 pb-3">
        <label class="form-label">Situação</label>
        <input type="text" class="form-control text-uppercase" id="militarSituacaoName" name="militarSituacaoName">
    </div>
    <div class="form-group col-12 col-md-4 pb-3">
        <label class="form-label">Posto/Graduação</label>
        <input type="text" class="form-control text-uppercase" id="militarGraduacaoName" name="militarGraduacaoName">
    </div>
    <div class="form-group col-12 col-md-4 pb-3">
        <label class="form-label">Quadro</label>
        <input type="text" class="form-control text-uppercase" id="militarQuadroEspecialidadeName" name="militarQuadroEspecialidadeName">
    </div>
</div>

@endif
