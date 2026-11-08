// Globais'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

// URL
let url = window.location.protocol + "//" + window.location.host + "/";
if (window.location.hostname.indexOf("cbmerj.rj.gov") != -1) { url += "dgf_sistema/"; }

// Const
const formulario = document.getElementById('frm_dashboards_tvs_controles');

// Salvamento
let salvamentoEmAndamento = false;
let salvamentoPendente = false;
let temporizadorSalvamento = null;
//'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

// Preencher checkboxes do Dashboard TV
function preencherCheckboxesDashboardTv(registro) {
    // Indicadores e gráficos
    for (let i = 1; i <= 12; i++) {
        ['indicador_', 'grafico_'].forEach(prefixo => {
            const campo = `${prefixo}${i}`;
            const checkbox = document.getElementById(campo);

            if (!checkbox) return;

            // Valor recebido do banco
            const valor = Number(registro[campo]) === 1 ? 1 : 0;

            // Marcar ou desmarcar checkbox
            checkbox.checked = valor === 1;

            // Definir valor do checkbox
            checkbox.value = String(valor);
        });
    }
}

async function edit() {
    const response = await fetch(url + 'dashboards_tvs_controles/1/edit', {
        method: 'GET',
        headers: {
            'REQUEST-ORIGIN': 'fetch',
            'Accept': 'application/json'
        }
    });

    const data = await response.json();

    // Lendo dados
    if (data.success) {
        // Limpar formulário
        crudLimparFormulario('dashboards_tvs_controles');

        // Preencher formulário
        const campos = document.getElementById('crudFieldsFormSubmodulo').value.split(',');

        campos.forEach(field => {
            crudPreencherFormulario(field, data.success);
        });

        // Settings Submódulos
        settingsSubmoduloCrudEdit(data.success);
    }
}

function agendarSalvamento() {
    salvamentoPendente = true;

    clearTimeout(temporizadorSalvamento);

    temporizadorSalvamento = setTimeout(() => {
        confirmEdit();
    }, 500);
}

async function confirmEdit() {
    // Indica que existe uma alteração aguardando gravação.
    salvamentoPendente = true;

    // Evita duas requisições simultâneas.
    if (salvamentoEmAndamento) return;

    clearTimeout(temporizadorSalvamento);

    salvamentoEmAndamento = true;
    bloquearTelaSistema();

    try {
        while (salvamentoPendente) {
            salvamentoPendente = false;

            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const formData = new FormData(document.getElementById('frm_dashboards_tvs_controles'));

            const response = await fetch(url + 'dashboards_tvs_controles/1', {
                method: 'POST',
                headers: {
                    'REQUEST-ORIGIN': 'fetch',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: formData
            });

            const data = await response.json();

            if (!response.ok) {
                throw new Error(data.error || 'Erro ao atualizar registro.');
            }
        }

        // Todas as alterações foram gravadas.
        window.location.href = url + 'dashboards_tvs_controles';
    } catch (error) {
        console.error('Erro ao salvar configurações:', error);
        alert(error.message);

        salvamentoPendente = false;
        salvamentoEmAndamento = false;
        desbloquearTelaSistema();
    }
}

// Funções Settings Submodulo - Início'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
// Funções Settings Submodulo - Início'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
async function settingsSubmoduloCrudCreate() { }
async function settingsSubmoduloCrudView(data) { }
async function settingsSubmoduloCrudEdit(data) { preencherCheckboxesDashboardTv(data); }
async function settingsSubmoduloCrudDelete() { }
async function settingsSubmoduloCrudConfirmCreate() { }
async function settingsSubmoduloCrudConfirmEdit() { }
// Funções Settings Submodulo - Fim''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
// Funções Settings Submodulo - Fim''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

document.addEventListener("DOMContentLoaded", async function (event) {
    await edit();

    // Ao clicar no input/quadro do Indicador ou Gráfico
    document.querySelectorAll('.indicador-grafico-checkbox').forEach(function (checkbox) {
        function atualizarIndicador() {
            const container = checkbox.parentElement.parentElement;
            const icone = container.querySelector('.indicador-grafico-icone');
            const select = container.querySelector('.indicador-grafico-select-ordem');

            icone.classList.toggle('fa-circle-xmark', !checkbox.checked);
            icone.classList.toggle('fa-circle-check', checkbox.checked);

            // Se desmarcado, assume ordem 120
            if (!checkbox.checked) { select.value = '120'; }
        }

        checkbox.addEventListener('change', atualizarIndicador);

        atualizarIndicador();
    });

    // Detecta alterações em selects, inputs e checkboxes
    formulario.addEventListener('change', function (event) {
        if (event.target.matches('input, select, textarea')) {
            agendarSalvamento();
        }
    });
});
