// Globais'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

// URL
let url = window.location.protocol + "//" + window.location.host + "/";
if (window.location.hostname.indexOf("cbmerj.rj.gov") != -1) { url += "dgf_sistema/"; }

// Const
//'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

// Validação
async function validar_frm_dashboards_tvs_controles() {
    var validacao_ok = true;
    var mensagem = "";

    // Campo: unidade_id (requerido)
    if (validacao({ op: 1, value: document.getElementById("unidade_id").value }) === false) {
        validacao_ok = false;
        mensagem += "Unidade requerida." + "<br>";
    }

    // Campo: ano (requerido)
    if (validacao({ op: 1, value: document.getElementById("ano").value }) === false) {
        validacao_ok = false;
        mensagem += "Ano requerido." + "<br>";
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

// Funções Settings Submodulo - Início'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
// Funções Settings Submodulo - Início'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
async function settingsSubmoduloCrudCreate() { }
async function settingsSubmoduloCrudView(data) { }
async function settingsSubmoduloCrudEdit(data) {
    preencherCheckboxesDashboardTv(data);
}
async function settingsSubmoduloCrudDelete() { }
async function settingsSubmoduloCrudConfirmCreate() { }
async function settingsSubmoduloCrudConfirmEdit() { }
// Funções Settings Submodulo - Fim''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
// Funções Settings Submodulo - Fim''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

document.addEventListener("DOMContentLoaded", function (event) { });
