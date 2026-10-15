// Globais'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

// URL
let url = window.location.protocol + "//" + window.location.host + "/";
if (window.location.hostname.indexOf("cbmerj.rj.gov") != -1) { url += "dgf_sistema/"; }

// Const
const militarNome = document.getElementById('militarNome');
const militar_id = document.getElementById('militar_id');
const militar_id_token = document.getElementById('militar_id_token');
const militarRg = document.getElementById('militarRg');
const militarIdentidadeFuncional = document.getElementById('militarIdentidadeFuncional');
const militarSituacaoId = document.getElementById('militarSituacaoId');
const militarSituacaoName = document.getElementById('militarSituacaoName');
const militarGraduacaoName = document.getElementById('militarGraduacaoName');
const militarQuadroEspecialidadeName = document.getElementById('militarQuadroEspecialidadeName');
//'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

// Validação
async function validar_frm_militares_ajudas_custos() {
    var validacao_ok = true;
    var mensagem = "";

    // Campo: militar_id (requerido)
    if (validacao({ op: 1, value: document.getElementById("militar_id").value }) === false) {
        validacao_ok = false;
        mensagem += "Militar requerido." + "<br>";
    }

    // Campo: militar_id_token (validação)
    var response = await tokenServiceValidar(document.getElementById('militar_id_token').value);

    if (!response) {
        validacao_ok = false;
        mensagem += "Erro ao Validar o Token MilitarId." + "<br>";
    }

    // Campo: militar_id_token x militar_id (validação)
    var response = await tokenServiceId(document.getElementById('militar_id_token').value);

    if (response != document.getElementById('militar_id').value) {
        validacao_ok = false;
        mensagem += "Erro ao Validar o MilitarIdToken x MilitarId." + "<br>";
    }

    // Campo: militarSituacaoId_token (validação)
    var response = await tokenServiceValidar(document.getElementById('militarSituacaoId_token').value);

    if (!response) {
        validacao_ok = false;
        mensagem += "Erro ao Validar o Token MilitarSituacaoId." + "<br>";
    }

    // Campo: militarSituacaoId_token x militarSituacaoId (validação)
    var response = await tokenServiceId(document.getElementById('militarSituacaoId_token').value);

    if (response != document.getElementById('militarSituacaoId').value) {
        validacao_ok = false;
        mensagem += "Erro ao Validar o MilitarSituacaoIdToken x MilitarSituacaoId." + "<br>";
    }

    // // Campo: ajuda_custo_tipo_id (requerido)
    // if (validacao({ op: 1, value: document.getElementById("ajuda_custo_tipo_id").value }) === false) {
    //     validacao_ok = false;
    //     mensagem += "Ajuda Custo Tipo requerido." + "<br>";
    // }

    // // Campo: boletim (requerido)
    // if (validacao({ op: 1, value: document.getElementById("boletim").value }) === false) {
    //     validacao_ok = false;
    //     mensagem += "Boletim requerido." + "<br>";
    // } else {
    //     if (validacao({ op: 20, value: document.getElementById('boletim').value }) === false) {
    //         validacao_ok = false;
    //         mensagem += 'Boletim inválido.' + '<br>';
    //     }
    // }

    // // Campo: pagamento (requerido)
    // if (validacao({ op: 1, value: document.getElementById("pagamento").value }) === false) {
    //     validacao_ok = false;
    //     mensagem += "Pagamento requerido." + "<br>";
    // } else {
    //     if (validacao({ op: 22, value: document.getElementById('pagamento').value }) === false) {
    //         validacao_ok = false;
    //         mensagem += 'Pagamento inválido.' + '<br>';
    //     }
    // }

    // // Campo: requerimento_numero (requerido)
    // if (validacao({ op: 1, value: document.getElementById("requerimento_numero").value }) === false) {
    //     validacao_ok = false;
    //     mensagem += "Requerimento Número requerido." + "<br>";
    // } else {
    //     if (validacao({ op: 24, value: document.getElementById('requerimento_numero').value }) === false) {
    //         validacao_ok = false;
    //         mensagem += 'Requerimento Número inválido.' + '<br>';
    //     }
    // }

    // // Campo: requerimento_data (requerido)
    // if (validacao({ op: 1, value: document.getElementById("requerimento_data").value }) === false) {
    //     validacao_ok = false;
    //     mensagem += "Requerimento Data requerido." + "<br>";
    // } else {
    //     if (validacao({ op: 8, value: document.getElementById('requerimento_data').value }) === false) {
    //         validacao_ok = false;
    //         mensagem += 'Requerimento Data inválida.' + '<br>';
    //     }
    // }

    // // Campo: POR MOVIMENTAÇÃO (verificar)
    // if (document.getElementById("ajuda_custo_tipo_id").value == 1) {
    //     // Campo: unidade_origem (requerido)
    //     if (validacao({ op: 1, value: document.getElementById("unidade_origem").value }) === false) {
    //         validacao_ok = false;
    //         mensagem += "Unidade Origem requerido." + "<br>";
    //     }

    //     // Campo: unidade_destino (requerido)
    //     if (validacao({ op: 1, value: document.getElementById("unidade_destino").value }) === false) {
    //         validacao_ok = false;
    //         mensagem += "Unidade Destino requerido." + "<br>";
    //     }

    //     // Campo: curso (LIMPAR)
    //     document.getElementById("curso").value = '';

    //     // Campo: boletim_movimentacao_curso (LIMPAR)
    //     document.getElementById("boletim_movimentacao_curso").value = '';

    // // Campo: POR CURSO (verificar)
    // } else if (document.getElementById("ajuda_custo_tipo_id").value == 2) {
    //     // Campo: unidade_origem (LIMPAR)
    //     document.getElementById("unidade_origem").value = '';

    //     // Campo: unidade_destino (LIMPAR)
    //     document.getElementById("unidade_destino").value = '';

    //     // Campo: curso (requerido)
    //     if (validacao({ op: 1, value: document.getElementById("curso").value }) === false) {
    //         validacao_ok = false;
    //         mensagem += "Curso requerido." + "<br>";
    //     }

    //     // Campo: boletim_movimentacao_curso (requerido)
    //     if (validacao({ op: 1, value: document.getElementById("boletim_movimentacao_curso").value }) === false) {
    //         validacao_ok = false;
    //         mensagem += "Boletim Movimentação Curso requerido." + "<br>";
    //     } else {
    //         if (validacao({ op: 20, value: document.getElementById('boletim_movimentacao_curso').value }) === false) {
    //             validacao_ok = false;
    //             mensagem += 'Boletim Movimentação Curso inválido.' + '<br>';
    //         }
    //     }
    // }

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

// Ajustar Formulário (Por Movimentação e Por Curso)
async function ajustarFormulario() {
    const ajuda_custo_tipo_id = document.getElementById('ajuda_custo_tipo_id');

    // Hiden
    document.querySelectorAll('.por_movimentacao, .por_curso').forEach(elemento => {
        elemento.classList.add('d-none');
    });

    // POR MOVIMENTAÇÃO
    if (ajuda_custo_tipo_id.value == 1) {
        document.querySelectorAll('.por_movimentacao').forEach(elemento => {
            elemento.classList.remove('d-none');
        });
    }

    // POR CURSO
    if (ajuda_custo_tipo_id.value == 2) {
        document.querySelectorAll('.por_curso').forEach(elemento => {
            elemento.classList.remove('d-none');
        });
    }
}

// Preencher alguns campos no Formulário
async function preencherCampos(data) {
    militarNome.value = data.militarNome;
    militar_id.value = data.militar_id;
    militarRg.value = data.militarRg;
    militarIdentidadeFuncional.value = data.militarIdentidadeFuncional;
    militarSituacaoId.value = data.militarSituacaoId;
    militarSituacaoName.value = data.militarSituacaoName;
    militarGraduacaoName.value = data.militarGraduacaoName;
    militarQuadroEspecialidadeName.value = data.militarQuadroEspecialidadeName;
}

// Desabilitar campos no Formulário
async function desabilitarCampos() {
    militarNome.disabled = true;
    militarRg.disabled = true;
    militarIdentidadeFuncional.disabled = true;
    militarSituacaoName.disabled = true;
    militarGraduacaoName.disabled = true;
    militarQuadroEspecialidadeName.disabled = true;
}

// Habilitar campos no Formulário
async function habilitarCampos() {
    militar_id.disabled = false;
    militarSituacaoId.disabled = false;
}

// Funções Settings Submodulo - Início'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
// Funções Settings Submodulo - Início'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
async function settingsSubmoduloCrudCreate() {
    await desabilitarCampos();
    await habilitarCampos();

    // Pesquisar Militar
    const militarAuto = crudAutocompleteMilitar('militares_ajudas_custos', 'create');
    militarAuto.init();
    document.getElementById('divPesquisarMilitar').style.display = '';
}

async function settingsSubmoduloCrudView(data) {
    await preencherCampos(data);
    await desabilitarCampos();
    await habilitarCampos();

    // Verificando permissões para botões
    await configurarBotoesPermissaoSituacao({ modulo: 'militares_ajudas_custos', situacaoId: data.militarSituacaoId });

    // Gerar Token para Controle militar_id
    if (!await tokenServiceGerar('militar_id', data.militar_id)) return;

    // Gerar Token para Controle militarSituacaoId
    if (!await tokenServiceGerar('militarSituacaoId', data.militarSituacaoId)) return;

    // Pesquisar Militar
    document.getElementById('divPesquisarMilitar').style.display = 'none';
}

async function settingsSubmoduloCrudEdit(data) {
    await preencherCampos(data);
    await desabilitarCampos();
    await habilitarCampos();

    // Verificando permissões para botões
    await configurarBotoesPermissaoSituacao({ modulo: 'militares_ajudas_custos', situacaoId: data.militarSituacaoId });

    // Gerar Token para Controle militar_id
    if (!await tokenServiceGerar('militar_id', data.militar_id)) return;

    // Gerar Token para Controle militarSituacaoId
    if (!await tokenServiceGerar('militarSituacaoId', data.militarSituacaoId)) return;

    // Pesquisar Militar
    document.getElementById('divPesquisarMilitar').style.display = 'none';
}

async function settingsSubmoduloCrudDelete() { }

async function settingsSubmoduloCrudConfirmCreate() { }

async function settingsSubmoduloCrudConfirmEdit() { }
// Funções Settings Submodulo - Fim''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
// Funções Settings Submodulo - Fim''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

document.addEventListener("DOMContentLoaded", async function (event) {
    // Ajustar Formulário (Por Movimentação e Por Curso)
    await ajustarFormulario();
});
