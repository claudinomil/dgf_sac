// Globais'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

// URL
let url = window.location.protocol + "//" + window.location.host + "/";
if (window.location.hostname.indexOf("cbmerj.rj.gov") != -1) { url += "dgf_sistema/"; }

// Const
const frm_operacao = document.getElementById('frm_operacao');
const registro_id = document.getElementById('registro_id');
const militarNome = document.getElementById('militarNome');
const militar_id = document.getElementById('militar_id');
const militar_id_token = document.getElementById('militar_id_token');
const militarRg = document.getElementById('militarRg');
const militarIdentidadeFuncional = document.getElementById('militarIdentidadeFuncional');
const militarSituacaoId = document.getElementById('militarSituacaoId');
const militarSituacaoName = document.getElementById('militarSituacaoName');
const militarGraduacaoName = document.getElementById('militarGraduacaoName');
const militarQuadroEspecialidadeName = document.getElementById('militarQuadroEspecialidadeName');
const divMilitarDependentes = document.getElementById('divMilitarDependentes');
//'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

// Validação
async function validar_frm_militares_fundos_saude() {
    var validacao_ok = true;
    var mensagem = "";

    // Campo: militar_id (requerido)
    if (validacao({ op: 1, value: document.getElementById("militar_id").value }) === false) {
        validacao_ok = false;
        mensagem += "Militar requerido." + "<br>";
    }

    // Campo: militar_id_token (validação)
    var response = await tokenServiceValidar(document.getElementById('militar_id_token').value);

    if (!response) {
        validacao_ok = false;
        mensagem += "Erro ao Validar o Token MilitarId." + "<br>";
    }

    // Campo: militar_id_token x militar_id (validação)
    var response = await tokenServiceId(document.getElementById('militar_id_token').value);

    if (response != document.getElementById('militar_id').value) {
        validacao_ok = false;
        mensagem += "Erro ao Validar o MilitarIdToken x MilitarId." + "<br>";
    }

    // Campo: militarSituacaoId_token (validação)
    var response = await tokenServiceValidar(document.getElementById('militarSituacaoId_token').value);

    if (!response) {
        validacao_ok = false;
        mensagem += "Erro ao Validar o Token MilitarSituacaoId." + "<br>";
    }

    // Campo: militarSituacaoId_token x militarSituacaoId (validação)
    var response = await tokenServiceId(document.getElementById('militarSituacaoId_token').value);

    if (response != document.getElementById('militarSituacaoId').value) {
        validacao_ok = false;
        mensagem += "Erro ao Validar o MilitarSituacaoIdToken x MilitarSituacaoId." + "<br>";
    }

    // Campo: cancelar_desconto (requerido)
    if (validacao({ op: 1, value: document.getElementById("cancelar_desconto").value }) === false) {
        validacao_ok = false;
        mensagem += "Cancelar Desconto requerido." + "<br>";
    }

    // Campo: acesso_sistema_saude (requerido)
    if (validacao({ op: 1, value: document.getElementById("acesso_sistema_saude").value }) === false) {
        validacao_ok = false;
        mensagem += "Acesso Sistema Saúde requerido." + "<br>";
    }

    // Campo: tipo_acesso (requerido)
    if (validacao({ op: 1, value: document.getElementById("tipo_acesso").value }) === false) {
        validacao_ok = false;
        mensagem += "Tipo Acesso requerido." + "<br>";
    }

    // Campo: data_documento (validar)
    if (validacao({ op: 1, value: document.getElementById("data_documento").value }) === true) {
        if (validacao({ op: 8, value: document.getElementById('data_documento').value }) === false) {
            validacao_ok = false;
            mensagem += 'Data Documento inválida.' + '<br>';
        }
    }

    // Mensagem
    if (validacao_ok === false) {
        var texto = '<div class="pt-3">';
        texto +=
            '<div class="col-12 text-start font-size-12">' +
            mensagem +
            "</div>";
        texto += "</div>";

        alertSwal("warning", "Validação", texto, "true", 5000);
    }

    // Retorno
    return validacao_ok;
}

// Preencher alguns campos no Formulário
async function preencherCampos(data) {
    militarNome.value = data.militarNome;
    militar_id.value = data.militar_id;
    militarRg.value = data.militarRg;
    militarIdentidadeFuncional.value = data.militarIdentidadeFuncional;
    militarSituacaoId.value = data.militarSituacaoId;
    militarSituacaoName.value = data.militarSituacaoName;
    militarGraduacaoName.value = data.militarGraduacaoName;
    militarQuadroEspecialidadeName.value = data.militarQuadroEspecialidadeName;
}

// Desabilitar campos no Formulário
async function desabilitarCampos() {
    militarNome.disabled = true;
    militarRg.disabled = true;
    militarIdentidadeFuncional.disabled = true;
    militarSituacaoName.disabled = true;
    militarGraduacaoName.disabled = true;
    militarQuadroEspecialidadeName.disabled = true;
}

// Habilitar campos no Formulário
async function habilitarCampos() {
    militar_id.disabled = false;
    militarSituacaoId.disabled = false;
}

// Grade de Dependentes do Militar
async function gradeMilitarDependentes() {
    // Hidden
    divMilitarDependentes.classList.add('d-none');

    // View
    if (frm_operacao.value == 'view') {
        // Show
        divMilitarDependentes.classList.remove('d-none');

        // Rota
        const response = await fetch(`militares/militar/dependentes/${militar_id.value}`, {
            headers: {
                'Accept': 'application/json',
                'request-origin': 'fetch'
            }
        });

        // Dados
        const data = await response.json();

        if (!response.ok) {
            throw new Error(data.message ?? 'Erro ao consultar os dependentes.');
        }

        // Montar Grade de Dependente
        montarTabela({
            elemento: 'divTabelaDependentes',
            classe: 'table table-sm small',
            colunas: [
                { titulo: '#', tipo: 'numero', alinhamento: 'center', nowrap: true },
                { titulo: 'Situação', campo: 'situacao', alinhamento: 'center', nowrap: true, tipo: 'badge', mapa: { 'Ativo': 'bg-success', 'Excluído': 'bg-danger' } },
                { titulo: 'Parentesco', campo: 'parentescoName', alinhamento: 'start', nowrap: false },
                { titulo: 'Dependente', campo: 'name', alinhamento: 'start', nowrap: true },
                { titulo: 'Acesso Sistema Saúde', campo: 'acesso_sistema_saude_dependente', alinhamento: 'center', tipo: 'booleano', nowrap: true },
                { titulo: 'Tipo Acesso', campo: 'tipoAcessoName', alinhamento: 'center', nowrap: true, tipo: 'badge', mapa: { 'Negado': 'bg-danger', 'Integral': 'bg-success', 'Ampulatorial': 'bg-warning' } }
            ],
            dados: data ?? []
        });
    }
}

// Funções Settings Submodulo - Início'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
// Funções Settings Submodulo - Início'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
async function settingsSubmoduloCrudCreate() {
    await desabilitarCampos();
    await habilitarCampos();
    await gradeMilitarDependentes();

    // Pesquisar Militar
    const militarAuto = crudAutocompleteMilitar('militares_fundos_saude', 'create');
    militarAuto.init();
    document.getElementById('divPesquisarMilitar').style.display = '';
}

async function settingsSubmoduloCrudView(data) {
    await preencherCampos(data);
    await desabilitarCampos();
    await habilitarCampos();
    await gradeMilitarDependentes();

    // Verificando permissões para botões
    await configurarBotoesPermissaoSituacao({ modulo: 'militares_fundos_saude', situacaoId: data.militarSituacaoId });

    // Gerar Token para Controle militar_id
    if (!await tokenServiceGerar('militar_id', data.militar_id)) return;

    // Gerar Token para Controle militarSituacaoId
    if (!await tokenServiceGerar('militarSituacaoId', data.militarSituacaoId)) return;

    // Pesquisar Militar
    document.getElementById('divPesquisarMilitar').style.display = 'none';
}

async function settingsSubmoduloCrudEdit(data) {
    await preencherCampos(data);
    await desabilitarCampos();
    await habilitarCampos();
    await gradeMilitarDependentes();

    // Verificando permissões para botões
    await configurarBotoesPermissaoSituacao({ modulo: 'militares_fundos_saude', situacaoId: data.militarSituacaoId });

    // Gerar Token para Controle militar_id
    if (!await tokenServiceGerar('militar_id', data.militar_id)) return;

    // Gerar Token para Controle militarSituacaoId
    if (!await tokenServiceGerar('militarSituacaoId', data.militarSituacaoId)) return;

    // Pesquisar Militar
    document.getElementById('divPesquisarMilitar').style.display = 'none';
}

async function settingsSubmoduloCrudConfirmCreate() { }

async function settingsSubmoduloCrudConfirmEdit() { }
// Funções Settings Submodulo - Fim''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
// Funções Settings Submodulo - Fim''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

document.addEventListener("DOMContentLoaded", function (event) { });
