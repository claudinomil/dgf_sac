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
const resposta = document.getElementById('resposta');
const resposta_status = document.getElementById('resposta_status');
const resposta_data = document.getElementById('resposta_data');

const div_cp_solicitacao_data = document.getElementById('div_cp_solicitacao_data');
const div_cp_user_id = document.getElementById('div_cp_user_id');

const div_resposta = document.getElementById('div_resposta');
const div_cp_resposta_data = document.getElementById('div_cp_resposta_data');
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

async function mudarTituloColunas() {
    try {
        // Pegar totais de Solicitações e Respostas
        const response = await fetch(`homologacao_solicitacoes/totais/solicitacoes/respostas`);
        const data = await response.json();

        const totais_solicitacoes = data.success.totais_solicitacoes;
        const totais_respostas = data.success.totais_respostas; 
        const totais_respostas_em_analise = data.success.totais_respostas_em_analise;
        const totais_respostas_concluido = data.success.totais_respostas_concluido;
        const totais_respostas_em_desenvolvimento = data.success.totais_respostas_em_desenvolvimento;
        const totais_respostas_aguardando_validacao = data.success.totais_respostas_aguardando_validacao;
        const totais_respostas_nao_realizado = data.success.totais_respostas_nao_realizado;
        
        // Alterando títulos'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        const tabela = $('#datatable-crud-ajax').DataTable();

        // Coluna [0]
        let coluna_0 = `SOLICITAÇÃO <span class="ms-3 badge bg-primary">Total Geral: ${totais_solicitacoes}</span>`;
        
        tabela.column(0).header().innerHTML = coluna_0;

        // Coluna [1]
        let coluna_1 = `RESPOSTA <span class="ms-3 badge bg-primary">Respondidas: ${totais_respostas}</span>`;

        if (totais_respostas_em_analise > 0) {
            coluna_1 += `<span class="ms-3 badge bg-info">Em Análise: ${totais_respostas_em_analise}</span>`;
        }

        if (totais_respostas_concluido > 0) {
            coluna_1 += `<span class="ms-3 badge bg-success">Concluído: ${totais_respostas_concluido}</span>`;
        }

        if (totais_respostas_em_desenvolvimento > 0) {
            coluna_1 += `<span class="ms-3 badge bg-warning">Em Desenvolvimento: ${totais_respostas_em_desenvolvimento}</span>`;
        }

        if (totais_respostas_aguardando_validacao > 0) {
            coluna_1 += `<span class="ms-3 badge bg-dark">Aguardando Validação: ${totais_respostas_aguardando_validacao}</span>`;
        }

        if (totais_respostas_nao_realizado > 0) {
            coluna_1 += `<span class="ms-3 badge bg-danger">Não Realizado: ${totais_respostas_nao_realizado}</span>`;
        }

        tabela.column(1).header().innerHTML = coluna_1;
        //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    } catch (error) {
        console.error(error);
        return false;
    }
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
    div_cp_user_id.classList.add('d-none');
    div_resposta.classList.add('d-none');
}

async function settingsSubmoduloCrudView(data) {
    // d-none
    div_cp_solicitacao_data.classList.remove('d-none');
    div_cp_user_id.classList.remove('d-none');
    div_resposta.classList.remove('d-none');
    div_cp_resposta_data.classList.remove('d-none');

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
    user_id.disabled = true;

    // d-none
    div_cp_solicitacao_data.classList.remove('d-none');
    div_cp_user_id.classList.remove('d-none');
    div_resposta.classList.remove('d-none');
    div_cp_resposta_data.classList.add('d-none');
}

async function settingsSubmoduloCrudDelete() { }
async function settingsSubmoduloCrudConfirmCreate() { }
async function settingsSubmoduloCrudConfirmEdit() { }
async function settingsSubmoduloCrudTable() {
    await mudarTituloColunas();
}
// Funções Settings Submodulo - Fim''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
// Funções Settings Submodulo - Fim''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

document.addEventListener("DOMContentLoaded", async function () {
    await mudarTituloColunas();
});
