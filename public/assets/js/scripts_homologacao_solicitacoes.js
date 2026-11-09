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
        const response = await fetch(`homologacao_solicitacoes/totais/solicitacoes/respostas`);

        if (!response.ok) { throw new Error('Erro ao consultar os totais.'); }

        const data = await response.json();
        const totais_solicitacoes = data.success.totais_solicitacoes;
        const totais_respostas_em_analise = data.success.totais_respostas_em_analise;
        const totais_respostas_concluido = data.success.totais_respostas_concluido;
        const totais_respostas_nao_realizado = data.success.totais_respostas_nao_realizado;
        const tabela = $('#datatable-crud-ajax').DataTable();

        // Coluna 0 - SOLICITAÇÃO & RESPOSTA
        let coluna_0 = 'SOLICITAÇÃO & RESPOSTA ';

        coluna_0 += `<a href="#" class="ms-3 badge bg-primary text-decoration-none filtro-solicitacao" data-status="todos">Total Geral: ${totais_solicitacoes}</a>`;

        if (totais_respostas_em_analise > 0) {
            coluna_0 += `<a href="#" class="ms-2 badge bg-info text-decoration-none filtro-solicitacao" data-status="em_analise">Em Análise: ${totais_respostas_em_analise}</a>`;
        }

        if (totais_respostas_concluido > 0) {
            coluna_0 += `<a href="#" class="ms-2 badge bg-success text-decoration-none filtro-solicitacao" data-status="concluido">Concluído: ${totais_respostas_concluido}</a>`;
        }

        if (totais_respostas_nao_realizado > 0) {
            coluna_0 += `<a href="#" class="ms-2 badge bg-danger text-decoration-none filtro-solicitacao" data-status="nao_realizado">Não Realizado: ${totais_respostas_nao_realizado}</a>`;
        }

        tabela.column(0).header().innerHTML = coluna_0;
    } catch (error) {
        console.error(error);
        return false;
    }
}

function filtrarSolicitacoes(status) {
    const tabela = $('#datatable-crud-ajax').DataTable();

    // Limpar filtros anteriores
    tabela.search('');
    tabela.columns().search('');

    // Aplicar filtro conforme o status selecionado
    switch (status) {
        case 'todos':
            break;

        case 'em_analise':
            tabela.column(0).search('Em Análise', true, false);
            break;

        case 'concluido':
            tabela.column(0).search('Concluído', true, false);
            break;

        case 'nao_realizado':
            tabela.column(0).search('Não Realizado', true, false);
            break;

        default:
            return;
    }

    tabela.draw();
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

    // Montando tabela Dados Users
    route = 'homologacao_solicitacoes/datatable/dados_users';
    let fieldsColumns = [];
    let pageLength = 10;
    let crudFieldsColumnsTable = 'userName,sol,res,pen';
    let camposColunasTabelas = crudFieldsColumnsTable.split(',');

    camposColunasTabelas.forEach(function (campo) {
        fieldsColumns.push({ data: campo });
    });

    // DataTable configurações
    var tabela = document.getElementById('datatable-dados-users-ajax');

    new DataTable(tabela, {
        language: {
            pageLength: {
                '-1': 'Mostrar todos os registros',
                '_': 'Mostrar %d registros'
            },
            lengthMenu: 'Exibir _MENU_ resultados por página',
            emptyTable: 'Nenhum registro encontrado',
            info: 'Mostrando de _START_ até _END_ de _TOTAL_ registros',
            infoEmpty: 'Mostrando 0 até 0 de 0 registros',
            infoFiltered: '(Filtrados de _MAX_ registros)',
            infoThousands: '.',
            loadingRecords: 'Carregando...',
            processing: 'Processando...',
            zeroRecords: 'Nenhum registro encontrado',
            search: 'Pesquisar',
            paginate: {
                next: 'Próximo',
                previous: 'Anterior',
                first: 'Primeiro',
                last: 'Último'
            }
        },
        bDestroy: true,
        responsive: false,
        lengthChange: true,
        autoWidth: true,
        order: [],
        ordering: true,
        processing: true,
        serverSide: false,
        pageLength: pageLength,
        ajax: route,
        columns: fieldsColumns
    });
}
// Funções Settings Submodulo - Fim''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
// Funções Settings Submodulo - Fim''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

document.addEventListener("DOMContentLoaded", async function () {
    await mudarTituloColunas();

    // Capturar o clique nos links inseridos nas colunas sem interferir na ordenação
    document.addEventListener('click', async function (event) {
        const link = event.target.closest('.filtro-solicitacao');

        if (!link) { return; }

        event.preventDefault();
        event.stopPropagation();

        const status = link.dataset.status;

        await filtrarSolicitacoes(status);
    });
});
