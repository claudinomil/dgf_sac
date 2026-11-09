// Funções Settings Submodulo - Início'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
// Funções Settings Submodulo - Início'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
async function settingsSubmoduloCrudCreate() { }
async function settingsSubmoduloCrudView() { }
async function settingsSubmoduloCrudEdit() { }
async function settingsSubmoduloCrudDelete() { }
async function settingsSubmoduloCrudConfirmCreate() { }
async function settingsSubmoduloCrudConfirmEdit() { }
async function settingsSubmoduloCrudTable() {
    route = 'homologacao_transacoes/datatable/dados_users';
    let fieldsColumns = [];
    let pageLength = 10;
    let crudFieldsColumnsTable = 'userName,c,i,a,e,t';
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

document.addEventListener("DOMContentLoaded", function () {});
