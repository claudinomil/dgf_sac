// Elementos
const frm_operacao = document.getElementById('frm_operacao');
const divPesquisarMilitar = document.getElementById('divPesquisarMilitar');
const user = document.getElementById('user');
const user_tipo_id = document.getElementById('user_tipo_id');
const militar_id = document.getElementById('militar_id');
const militarNome = document.getElementById('militarNome');
const militarRg = document.getElementById('militarRg');
const militarIdentidadeFuncional = document.getElementById('militarIdentidadeFuncional');
const militarSituacaoName = document.getElementById('militarSituacaoName');
const militarGraduacaoName = document.getElementById('militarGraduacaoName');
const militarQuadroEspecialidadeName = document.getElementById('militarQuadroEspecialidadeName');

function validar_frm_users() {
    var validacao_ok = true;
    var mensagem = "";

    // Campo: name (requerido)
    if (validacao({ op: 1, value: document.getElementById("name").value }) === false) {
        validacao_ok = false;
        mensagem += "Nome requerido." + "<br>";
    }

    // Campo: email (não requerido)
    if (validacao({ op: 1, value: document.getElementById("email").value }) === true) {
        // Campo: email (valido)
        if (validacao({ op: 5, value: document.getElementById("email").value }) === false) {
            validacao_ok = false;
            mensagem += "E-mail inválido." + "<br>";
        }
    }

    // Campo: grupo_id (requerido)
    if (validacao({ op: 1, value: document.getElementById("grupo_id").value }) === false) {
        validacao_ok = false;
        mensagem += "Grupo requerido." + "<br>";
    }

    // Campo: user_situacao_id (requerido)
    if (validacao({ op: 1, value: document.getElementById("user_situacao_id").value }) === false) {
        validacao_ok = false;
        mensagem += "Situação requerido." + "<br>";
    }

    // Campo: user_tipo_id (requerido)
    if (validacao({ op: 1, value: document.getElementById("user_tipo_id").value }) === false) {
        validacao_ok = false;
        mensagem += "Usuário Tipo requerido." + "<br>";
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

// divReferenciaMilitar
function divReferenciaMilitar() {
    const divReferenciaMilitar = document.getElementById("divReferenciaMilitar");

    divReferenciaMilitar.style.display = "none";

    // Militar
    if (user_tipo_id.value == 1) {
        divReferenciaMilitar.style.display = "";
    }

    // Civil
    if (user_tipo_id.value == 2) {
        divReferenciaMilitar.style.display = "none";

        militar_id.value = '';
        militarNome.value = '';
        militarRg.value = '';
        militarIdentidadeFuncional.value = '';
        militarSituacaoName.value = '';
        militarGraduacaoName.value = '';
        militarQuadroEspecialidadeName.value = '';
    }
}

// Preencher alguns campos no Formulário
async function preencherCampos(data) {
    militar_id.value = data.militar_id;
    militarNome.value = data.militarNome;
    militarRg.value = data.militarRg;
    militarIdentidadeFuncional.value = data.militarIdentidadeFuncional;
    militarSituacaoName.value = data.militarSituacaoName;
    militarGraduacaoName.value = data.militarGraduacaoName;
    militarQuadroEspecialidadeName.value = data.militarQuadroEspecialidadeName;
}

// Funções Settings Submodulo - Início'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
// Funções Settings Submodulo - Início'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
async function settingsSubmoduloCrudCreate() {
    divReferenciaMilitar();

    divPesquisarMilitar.style.display = 'block';

    // ReadOnly
    user.readOnly = true;

    militarNome.readOnly = true;
    militarRg.readOnly = true;
    militarIdentidadeFuncional.readOnly = true;
    militarSituacaoName.readOnly = true;
    militarGraduacaoName.readOnly = true;
    militarQuadroEspecialidadeName.readOnly = true;

    // user_tipo_id
    user_tipo_id.disabled = false;

    // Pesquisar Militar
    const militarAuto = autocompleteMilitar();
    militarAuto.init();
}

async function settingsSubmoduloCrudView(data) {
    divReferenciaMilitar();

    divPesquisarMilitar.style.display = 'none';

    await preencherCampos(data);
}

async function settingsSubmoduloCrudEdit(data) {
    divReferenciaMilitar();

    divPesquisarMilitar.style.display = 'block';

    await preencherCampos(data);

    // ReadOnly
    user.readOnly = true;
    militarRg.readOnly = true;
    militarNome.readOnly = true;
    militarGraduacaoName.readOnly = true;

    // user_tipo_id
    user_tipo_id.disabled = true;

    // Pesquisar Militar
    const militarAuto = autocompleteMilitar();
    militarAuto.init();
}

async function settingsSubmoduloCrudDelete() { }

async function settingsSubmoduloCrudConfirmCreate() { }

async function settingsSubmoduloCrudConfirmEdit() {
    // user_tipo_id
    user_tipo_id.disabled = false;
}
// Funções Settings Submodulo - Fim''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
// Funções Settings Submodulo - Fim''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

document.addEventListener("DOMContentLoaded", function (event) {
    // URL
    var url = window.location.protocol + "//" + window.location.host + "/";
    if (window.location.hostname.indexOf("cbmerj.rj.gov") != -1) {
        url += "dgf_sistema/";
    }

    // user_tipo_id'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    document.getElementById("user_tipo_id").addEventListener("change", function () {
        // divReferenciaMilitar
        divReferenciaMilitar();
    });
    //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
});
