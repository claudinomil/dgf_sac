// Globais'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

// URL
let url = window.location.protocol + "//" + window.location.host + "/";
if (window.location.hostname.indexOf("cbmerj.rj.gov") != -1) { url += "dgf_sistema/"; }

// Const
const militarNome = document.getElementById('militarNome');
const militar_id = document.getElementById('militar_id');
const militar_id_token = document.getElementById('militar_id_token');
const militarRg = document.getElementById('militarRg');
const militarIdentidadeFuncional = document.getElementById('militarIdentidadeFuncional');
const militarSituacaoId = document.getElementById('militarSituacaoId');
const militarSituacaoName = document.getElementById('militarSituacaoName');
const militarGraduacaoName = document.getElementById('militarGraduacaoName');
const militarQuadroEspecialidadeName = document.getElementById('militarQuadroEspecialidadeName');
//'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

// Validação
async function validar_frm_militares_dependentes() {
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

    // Campo: parentesco_id (requerido)
    if (validacao({ op: 1, value: document.getElementById("parentesco_id").value }) === false) {
        validacao_ok = false;
        mensagem += "Parentesco requerido." + "<br>";
    }

    // Campo: name (requerido)
    if (validacao({ op: 1, value: document.getElementById("name").value }) === false) {
        validacao_ok = false;
        mensagem += "Nome requerido." + "<br>";
    }

    // Campo: cpf (requerido)
    if (validacao({ op: 1, value: document.getElementById("cpf").value }) === false) {
        validacao_ok = false;
        mensagem += "CPF requerido." + "<br>";
    }

    // Campo: data_nascimento (validar)
    if (validacao({ op: 1, value: document.getElementById("data_nascimento").value }) === true) {
        if (validacao({ op: 8, value: document.getElementById('data_nascimento').value }) === false) {
            validacao_ok = false;
            mensagem += 'Data Nascimento inválida.' + '<br>';
        }
    }

    // Campo: data_casamento (validar)
    if (validacao({ op: 1, value: document.getElementById("data_casamento").value }) === true) {
        if (validacao({ op: 8, value: document.getElementById('data_casamento').value }) === false) {
            validacao_ok = false;
            mensagem += 'Data Casamento inválida.' + '<br>';
        }
    }

    // Campo: sexo_biologico_id (requerido)
    if (validacao({ op: 1, value: document.getElementById("sexo_biologico_id").value }) === false) {
        validacao_ok = false;
        mensagem += "Sexo Biológico requerido." + "<br>";
    }

    // Campo: vinculo_permanente (requerido)
    if (validacao({ op: 1, value: document.getElementById("vinculo_permanente").value }) === false) {
        validacao_ok = false;
        mensagem += "Vínculo Permanente requerido." + "<br>";
    }

    // Campo: boletim (inválido)
    if (validacao({ op: 1, value: document.getElementById("boletim").value }) === true) {
        if (validacao({ op: 20, value: document.getElementById('boletim').value }) === false) {
            validacao_ok = false;
            mensagem += 'Boletim inválido.' + '<br>';
        }
    }

    // Campo: data_requerimento (validar)
    if (validacao({ op: 1, value: document.getElementById("data_requerimento").value }) === true) {
        if (validacao({ op: 8, value: document.getElementById('data_requerimento').value }) === false) {
            validacao_ok = false;
            mensagem += 'Data Requerimento inválida.' + '<br>';
        }
    }

    // Campo: data_processo (validar)
    if (validacao({ op: 1, value: document.getElementById("data_processo").value }) === true) {
        if (validacao({ op: 8, value: document.getElementById('data_processo').value }) === false) {
            validacao_ok = false;
            mensagem += 'Data Processo inválida.' + '<br>';
        }
    }

    // Campo: decisao_judicial (requerido)
    if (validacao({ op: 1, value: document.getElementById("decisao_judicial").value }) === false) {
        validacao_ok = false;
        mensagem += "Decisão Judicial requerido." + "<br>";
    }

    // Campo: decisao_judicial_a_contar_de (validar)
    if (validacao({ op: 1, value: document.getElementById("decisao_judicial_a_contar_de").value }) === true) {
        if (validacao({ op: 8, value: document.getElementById('decisao_judicial_a_contar_de').value }) === false) {
            validacao_ok = false;
            mensagem += 'Decisão Judicial A Contar De inválida.' + '<br>';
        }
    }

    // Campo: imposto_renda (requerido)
    if (validacao({ op: 1, value: document.getElementById("imposto_renda").value }) === false) {
        validacao_ok = false;
        mensagem += "Imposto Renda requerido." + "<br>";
    }

    // Campo: fundo_saude (requerido)
    if (validacao({ op: 1, value: document.getElementById("fundo_saude").value }) === false) {
        validacao_ok = false;
        mensagem += "Fundo Saúde requerido." + "<br>";
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

// Funções Settings Submodulo - Início'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
// Funções Settings Submodulo - Início'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
async function settingsSubmoduloCrudCreate() {
    await desabilitarCampos();
    await habilitarCampos();

    // Pesquisar Militar
    const militarAuto = crudAutocompleteMilitar('militares_dependentes', 'create');
    militarAuto.init();
    document.getElementById('divPesquisarMilitar').style.display = '';
}

async function settingsSubmoduloCrudView(data) {
    await preencherCampos(data);
    await desabilitarCampos();
    await habilitarCampos();

    // Verificando permissões para botões
    await configurarBotoesPermissaoSituacao({ modulo: 'militares_dependentes', situacaoId: data.militarSituacaoId });

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

    // Verificando permissões para botões
    await configurarBotoesPermissaoSituacao({ modulo: 'militares_dependentes', situacaoId: data.militarSituacaoId });

    // Gerar Token para Controle militar_id
    if (!await tokenServiceGerar('militar_id', data.militar_id)) return;

    // Gerar Token para Controle militarSituacaoId
    if (!await tokenServiceGerar('militarSituacaoId', data.militarSituacaoId)) return;

    // Pesquisar Militar
    document.getElementById('divPesquisarMilitar').style.display = 'none';
}

async function settingsSubmoduloCrudDelete() { }

async function settingsSubmoduloCrudConfirmCreate() { }

async function settingsSubmoduloCrudConfirmEdit() { }
// Funções Settings Submodulo - Fim''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
// Funções Settings Submodulo - Fim''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

document.addEventListener("DOMContentLoaded", function (event) { });





function preenchimento_teste() {
    document.getElementById('parentesco_id').value = 3;
    document.getElementById('name').value = 'NOME TESTE';
    document.getElementById('cpf').value = '80974494046';
    document.getElementById('data_nascimento').value = '02/06/1971';
    document.getElementById('sexo_biologico_id').value = 1;
    document.getElementById('vinculo_permanente').value = 0;
    document.getElementById('boletim').value = '111-11/11/1111';
    document.getElementById('decisao_judicial').value = 0;
    document.getElementById('imposto_renda').value = 0;
    document.getElementById('fundo_saude').value = 0;
}
