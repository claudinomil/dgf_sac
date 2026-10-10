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
const solicitacao_data = document.getElementById('solicitacao_data');
const solicitacao_hora = document.getElementById('solicitacao_hora');
const resposta = document.getElementById('resposta');
const resposta_status = document.getElementById('resposta_status');
const resposta_data = document.getElementById('resposta_data');
const resposta_hora = document.getElementById('resposta_hora');

const div_cp_solicitacao_data = document.getElementById('div_cp_solicitacao_data');
const div_cp_solicitacao_hora = document.getElementById('div_cp_solicitacao_hora');
const div_cp_user_id = document.getElementById('div_cp_user_id');

const div_resposta = document.getElementById('div_resposta');
const div_cp_resposta_data = document.getElementById('div_cp_resposta_data');
const div_cp_resposta_hora = document.getElementById('div_cp_resposta_hora');
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
    resposta_status.value = 'Em Análise';

    // d-none
    div_cp_solicitacao_data.classList.add('d-none');
    div_cp_solicitacao_hora.classList.add('d-none');
    div_cp_user_id.classList.add('d-none');
    div_resposta.classList.add('d-none');
}

async function settingsSubmoduloCrudView(data) {
    // d-none
    div_cp_solicitacao_data.classList.remove('d-none');
    div_cp_solicitacao_hora.classList.remove('d-none');
    div_cp_user_id.classList.remove('d-none');
    div_resposta.classList.remove('d-none');
    div_cp_resposta_data.classList.remove('d-none');
    div_cp_resposta_hora.classList.remove('d-none');
    
    // Visualizar Solicitação Imagem''''''''''''''''''''''''''''''''''''''''''''''''''
    if (data.solicitacao_imagem !== null) {
        const container_file = document.getElementById('solicitacao_imagem_salva_container_file');
        const container_visualizacao = document.getElementById('solicitacao_imagem_salva_container_visualizacao');
        const imagem = document.getElementById('solicitacao_imagem_salva');

        // Limpar visualização anterior
        imagem.removeAttribute('src');
        container_file.classList.add('d-none');
        container_visualizacao.classList.add('d-none');

        imagem.src = data.solicitacao_imagem;

        container_visualizacao.classList.remove('d-none');
    }
    //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
}

async function settingsSubmoduloCrudEdit() {
    // disabled
    submodulo_id.disabled = true;
    solicitacao_tipo.disabled = true;
    solicitacao_prioridade.disabled = true;
    solicitacao.disabled = true;
    solicitacao_data.disabled = true;
    solicitacao_hora.disabled = true;
    user_id.disabled = true;

    // d-none
    div_cp_solicitacao_data.classList.remove('d-none');
    div_cp_solicitacao_hora.classList.remove('d-none');
    div_cp_user_id.classList.remove('d-none');
    div_resposta.classList.remove('d-none');
    div_cp_resposta_data.classList.add('d-none');
    div_cp_resposta_hora.classList.add('d-none');

}

async function settingsSubmoduloCrudDelete() { }
async function settingsSubmoduloCrudConfirmCreate() { }
async function settingsSubmoduloCrudConfirmEdit() { }
// Funções Settings Submodulo - Fim''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
// Funções Settings Submodulo - Fim''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

document.addEventListener("DOMContentLoaded", function (event) {});
