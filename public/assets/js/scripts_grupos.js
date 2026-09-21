function validar_frm_grupos() {
    var validacao_ok = true;
    var mensagem = "";

    // Campo: name (requerido)
    if (validacao({ op: 1, value: document.getElementById("name").value }) === false) {
        validacao_ok = false;
        mensagem += "Nome requerido." + "<br>";
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

// Marcar todas de uma coluna / Marcar permissão -list quando escolher qualquer outra
function checkedPermissaoTable(acao, prefix='') {
    const all_list = document.getElementById('all_list');
    const all_show = document.getElementById('all_show');
    const all_create = document.getElementById('all_create');
    const all_edit = document.getElementById('all_edit');
    const all_destroy = document.getElementById('all_destroy');

    // all_list
    if (acao == 'all_list') {
        const status = all_list.checked;

        document.querySelectorAll('.check_list').forEach(function (el) {
            el.checked = status;
        });

        if (status === false) {
            all_show.checked = status;
            document.querySelectorAll('.check_show').forEach(function (el) {
                el.checked = status;
            });

            all_create.checked = status;
            document.querySelectorAll('.check_create').forEach(function (el) {
                el.checked = status;
            });

            all_edit.checked = status;
            document.querySelectorAll('.check_edit').forEach(function (el) {
                el.checked = status;
            });

            all_destroy.checked = status;
            document.querySelectorAll('.check_destroy').forEach(function (el) {
                el.checked = status;
            });
        }
    }

    // all_show
    if (acao == 'all_show') {
        const status = all_show.checked;

        document.querySelectorAll('.check_show').forEach(function (el) {
            el.checked = status;
        });

        if (status === true) {
            all_list.checked = status;
            document.querySelectorAll('.check_list').forEach(function (el) {
                el.checked = status;
            });
        }
    }

    // all_create
    if (acao == 'all_create') {
        const status = all_create.checked;

        document.querySelectorAll('.check_create').forEach(function (el) {
            el.checked = status;
        });

        if (status === true) {
            all_list.checked = status;
            document.querySelectorAll('.check_list').forEach(function (el) {
                el.checked = status;
            });
        }
    }

    // all_edit
    if (acao == 'all_edit') {
        const status = all_edit.checked;

        document.querySelectorAll('.check_edit').forEach(function (el) {
            el.checked = status;
        });

        if (status === true) {
            all_list.checked = status;
            document.querySelectorAll('.check_list').forEach(function (el) {
                el.checked = status;
            });
        }
    }

    // all_destroy
    if (acao == 'all_destroy') {
        const status = all_destroy.checked;

        document.querySelectorAll('.check_destroy').forEach(function (el) {
            el.checked = status;
        });

        if (status === true) {
            all_list.checked = status;
            document.querySelectorAll('.check_list').forEach(function (el) {
                el.checked = status;
            });
        }
    }

    // list / show / create / edit / destroy (prefix)
    if (prefix !== '') {
        const prefix_acao = document.getElementById(prefix+'_'+acao);
        const status = prefix_acao.checked;

        if (status === false) {
            all_show.checked = status;
            document.getElementById(prefix + '_' + 'show').checked = status;

            all_create.checked = status;
            document.getElementById(prefix + '_' + 'create').checked = status;

            all_edit.checked = status;
            document.getElementById(prefix + '_' + 'edit').checked = status;

            all_destroy.checked = status;
            document.getElementById(prefix + '_' + 'destroy').checked = status;
        } else {
            document.getElementById(prefix + '_' + 'list').checked = true;
        }
    }
}

// Funções Settings Submodulo - Início'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
// Funções Settings Submodulo - Início'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
async function settingsSubmoduloCrudCreate() {
    checkboxesPermissoes();
    checkboxesRelatorios();
    checkboxesGraficos();

    // Iniciando campos de permissoes situações''''''''''''''''''''''''''''''''''
    const finais = [
        '_permissoes_list_situacoes_ids',
        '_permissoes_show_situacoes_ids',
        '_permissoes_create_situacoes_ids',
        '_permissoes_edit_situacoes_ids',
        '_permissoes_destroy_situacoes_ids'
    ];

    finais.forEach(final => {
        document.querySelectorAll(`[id$="${final}"]`).forEach(elemento => {
            elemento.value = 0;
        });
    });
    //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
}

async function settingsSubmoduloCrudView(data) {
    checkboxesPermissoes();
    checkboxesPermissoesSituacoes(data);
    checkboxesRelatorios();
    checkboxesGraficos();
}

async function settingsSubmoduloCrudEdit(data) {
    checkboxesPermissoes();
    checkboxesPermissoesSituacoes(data);
    checkboxesRelatorios();
    checkboxesGraficos();
}

async function settingsSubmoduloCrudDelete() { }

async function settingsSubmoduloCrudConfirmCreate() { }

async function settingsSubmoduloCrudConfirmEdit() { }

async function checkboxesPermissoes() {
    if (frm_operacao.value != 'create') {
        const url = `grupos/grupo_permissoes/${registro_id.value}`;

        try {
            const response = await fetch(url, {
                method: 'GET',
                headers: { 'REQUEST-ORIGIN': 'fetch' }
            });

            const data = await response.json();
            console.log(data.success);
            // Lendo dados
            if (data.success) {
                const permissoes = data.success;

                permissoes.forEach(item => {
                    document.getElementById(item.permissaoName).checked = true;
                });
            }
        } catch (error) {
            alert('Erro checkboxesPermissoes: ' + error);
        }
    }
}

async function montarCamposPermissoesSituacoesIds(prefix_permissao, operacao) {
    // Montar id inicial para pesquisa dos checkboxes
    ck_id_in = `${prefix_permissao}_${operacao}_situacao_id_`;

    // Montar id campo que vai receber
    hi_id_re = `${prefix_permissao}_permissoes_${operacao}_situacoes_ids`;

    array_marcados = [...document.querySelectorAll(`input[type="checkbox"][id^="${ck_id_in}"]`)]
        .filter(checkbox => checkbox.checked)
        .map(checkbox => checkbox.value)
        .join(',');

    document.getElementById(hi_id_re).value = array_marcados;
}

async function checkboxesPermissoesSituacoes(data) {
    if (frm_operacao.value != 'create') {
        try {
            // Prefixos dos submódulos
            const prefixos = ['militares', 'militares_cursos', 'militares_contatos', 'militares_ajudas_custos', 'militares_auxilios_fardamentos', 'militares_dependentes', 'militares_fundos_saude'];

            // Tipos de permissão
            const operacoes = ['list', 'show', 'create', 'edit', 'destroy'];

            for (const prefixo of prefixos) {
                for (const operacao of operacoes) {
                    // Ex.: militares_permissoes_list_situacoes_ids
                    const campo = `${prefixo}_permissoes_${operacao}_situacoes_ids`;

                    // Desmarca todos os checkboxes desse grupo
                    document.querySelectorAll(`input[id^="${prefixo}_${operacao}_situacao_id_"]`).forEach(chk => chk.checked = false);

                    // Se não houver valores, continua
                    if (!data[campo]) {
                        continue;
                    }

                    // Marca os IDs informados
                    const ids = data[campo].split(',').map(id => id.trim()).filter(id => id !== '');

                    for (const id of ids) {
                        const checkbox = document.getElementById(`${prefixo}_${operacao}_situacao_id_${id}`);

                        if (checkbox) {
                            checkbox.checked = true;
                        }
                    }
                }
            }
        } catch (error) {
            alert('Erro checkboxesPermissoesSituacoes: ' + error);
        }
    }
}

async function checkboxesRelatorios() {
    if (frm_operacao.value != 'create') {
        const url = `grupos/grupo_relatorios/${registro_id.value}`;

        try {
            const response = await fetch(url, {
                method: 'GET',
                headers: { 'REQUEST-ORIGIN': 'fetch' }
            });

            const data = await response.json();

            // Lendo dados
            if (data.success) {
                const relatorios = data.success;

                relatorios.forEach(item => {
                    document.getElementById(`relatorio_${item.relatorioId}`).checked = true;
                });
            }
        } catch (error) {
            alert('Erro checkboxesRelatorios: ' + error);
        }
    }
}

async function checkboxesGraficos() {
    if (frm_operacao.value != 'create') {
        const url = `grupos/grupo_graficos/${registro_id.value}`;

        try {
            const response = await fetch(url, {
                method: 'GET',
                headers: { 'REQUEST-ORIGIN': 'fetch' }
            });

            const data = await response.json();

            // Lendo dados
            if (data.success) {
                const graficos = data.success;

                graficos.forEach(item => {
                    document.getElementById(`grafico_${item.graficoId}`).checked = true;
                });
            }
        } catch (error) {
            alert('Erro checkboxesGraficos: ' + error);
        }
    }
}
// Funções Settings Submodulo - Fim''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
// Funções Settings Submodulo - Fim''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

document.addEventListener("DOMContentLoaded", function (event) {
    // Globais
    const registro_id = document.getElementById('registro_id');
    const frm_operacao = document.getElementById('frm_operacao');
});
