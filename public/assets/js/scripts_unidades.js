// Globais'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

// URL
let url = window.location.protocol + "//" + window.location.host + "/";
if (window.location.hostname.indexOf("cbmerj.rj.gov") != -1) { url += "dgf_sistema/"; }

// Const
//'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

// Validação
async function validar_frm_unidades() {
    var validacao_ok = true;
    var mensagem = "";

    // Campo: name (requerido)
    if (validacao({ op: 1, value: document.getElementById("name").value }) === false) {
        validacao_ok = false;
        mensagem += "Nome requerido." + "<br>";
    }

    // Campo: sigla (requerido)
    if (validacao({ op: 1, value: document.getElementById("sigla").value }) === false) {
        validacao_ok = false;
        mensagem += "Sigla requerido." + "<br>";
    }

    // Campo: codigo_unidade (requerido)
    if (validacao({ op: 1, value: document.getElementById("codigo_unidade").value }) === false) {
        validacao_ok = false;
        mensagem += "Código Unidade requerido." + "<br>";
    }


    // Campo: situacao (requerido)
    if (validacao({ op: 1, value: document.getElementById("situacao").value }) === false) {
        validacao_ok = false;
        mensagem += "Situação requerido." + "<br>";
    }

    // Campo: tipo (requerido)
    if (validacao({ op: 1, value: document.getElementById("tipo").value }) === false) {
        validacao_ok = false;
        mensagem += "Tipo requerido." + "<br>";
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
async function preencherCampos(data) { }

// Desabilitar campos no Formulário
async function desabilitarCampos() { }

// Habilitar campos no Formulário
async function habilitarCampos() { }

// Funções Settings Submodulo - Início'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
// Funções Settings Submodulo - Início'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
async function settingsSubmoduloCrudCreate() {
    await desabilitarCampos();
    await habilitarCampos();
}

async function settingsSubmoduloCrudView(data) {
    await preencherCampos(data);
    await desabilitarCampos();
    await habilitarCampos();
}

async function settingsSubmoduloCrudEdit(data) {
    await preencherCampos(data);
    await desabilitarCampos();
    await habilitarCampos();
}

async function settingsSubmoduloCrudDelete() { }

async function settingsSubmoduloCrudConfirmCreate() { }

async function settingsSubmoduloCrudConfirmEdit() { }
// Funções Settings Submodulo - Fim''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
// Funções Settings Submodulo - Fim''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

document.addEventListener("DOMContentLoaded", function (event) { });
