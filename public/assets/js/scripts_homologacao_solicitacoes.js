// Globais'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

// URL
let url = window.location.protocol + "//" + window.location.host + "/";
if (window.location.hostname.indexOf("cbmerj.rj.gov") != -1) { url += "dgf_sistema/"; }

// Const
const submodulo_id = document.getElementById('submodulo_id');
const user_id = document.getElementById('user_id');
const solicitacao = document.getElementById('solicitacao');
const solicitacao_tipo = document.getElementById('solicitacao_tipo');
const solicitacao_prioridade = document.getElementById('solicitacao_prioridade');
const data_solicitacao = document.getElementById('data_solicitacao');
const hora_solicitacao = document.getElementById('hora_solicitacao');
const resposta = document.getElementById('resposta');
const solicitacao_status = document.getElementById('solicitacao_status');
const data_resposta = document.getElementById('data_resposta');
const hora_resposta = document.getElementById('hora_resposta');

const div_cp_data_solicitacao = document.getElementById('div_cp_data_solicitacao');
const div_cp_hora_solicitacao = document.getElementById('div_cp_hora_solicitacao');
const div_cp_user_id = document.getElementById('div_cp_user_id');

const div_resposta = document.getElementById('div_resposta');
const div_cp_data_resposta = document.getElementById('div_cp_data_resposta');
const div_cp_hora_resposta = document.getElementById('div_cp_hora_resposta');
//'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

// Validação
async function validar_frm_homologacao_solicitacoes() {
    var validacao_ok = true;
    var mensagem = "";

    // Campo: solicitacao (requerido)
    if (validacao({ op: 1, value: document.getElementById("solicitacao").value }) === false) {
        validacao_ok = false;
        mensagem += "Solicitação requerido." + "<br>";
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

// Funções Settings Submodulo - Início'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
// Funções Settings Submodulo - Início'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
async function settingsSubmoduloCrudCreate() {
    // Preencher campos no Formulário
    submodulo_id.value = '';
    solicitacao_tipo.value = 'Sugestão';
    solicitacao_prioridade.value = 'Normal';
    solicitacao_status.value = 'Em Análise';

    // d-none
    div_cp_data_solicitacao.classList.add('d-none');
    div_cp_hora_solicitacao.classList.add('d-none');
    div_cp_user_id.classList.add('d-none');
    div_resposta.classList.add('d-none');
}

async function settingsSubmoduloCrudView() {
    // d-none
    div_cp_data_solicitacao.classList.remove('d-none');
    div_cp_hora_solicitacao.classList.remove('d-none');
    div_cp_user_id.classList.remove('d-none');
    div_resposta.classList.remove('d-none');
    div_cp_data_resposta.classList.remove('d-none');
    div_cp_hora_resposta.classList.remove('d-none');
}

async function settingsSubmoduloCrudEdit() {
    // disabled
    submodulo_id.disabled = true;
    solicitacao_tipo.disabled = true;
    solicitacao_prioridade.disabled = true;
    solicitacao.disabled = true;
    data_solicitacao.disabled = true;
    hora_solicitacao.disabled = true;
    user_id.disabled = true;

    // d-none
    div_cp_data_solicitacao.classList.remove('d-none');
    div_cp_hora_solicitacao.classList.remove('d-none');
    div_cp_user_id.classList.remove('d-none');
    div_resposta.classList.remove('d-none');
    div_cp_data_resposta.classList.add('d-none');
    div_cp_hora_resposta.classList.add('d-none');

}

async function settingsSubmoduloCrudDelete() { }
async function settingsSubmoduloCrudConfirmCreate() { }
async function settingsSubmoduloCrudConfirmEdit() { }
// Funções Settings Submodulo - Fim''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
// Funções Settings Submodulo - Fim''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

document.addEventListener("DOMContentLoaded", function (event) {});
