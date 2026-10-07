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
async function validar_frm_militares_tempos_averbados() {
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

    // // Campo: tempo_averbado_local_id (requerido)
    // if (validacao({ op: 1, value: document.getElementById("tempo_averbado_local_id").value }) === false) {
    //     validacao_ok = false;
    //     mensagem += "Tempo Averbado Local requerido." + "<br>";
    // }

    // // Campo: data_ingresso_local (requerido)
    // if (validacao({ op: 1, value: document.getElementById("data_ingresso_local").value }) === false) {
    //     validacao_ok = false;
    //     mensagem += "Data Ingresso Local requerido." + "<br>";
    // } else {
    //     if (validacao({ op: 8, value: document.getElementById('data_ingresso_local').value }) === false) {
    //         validacao_ok = false;
    //         mensagem += 'Data Ingresso Local inválida.' + '<br>';
    //     }
    // }

    // // Campo: data_termino_local (requerido)
    // if (validacao({ op: 1, value: document.getElementById("data_termino_local").value }) === false) {
    //     validacao_ok = false;
    //     mensagem += "Data Término Local requerido." + "<br>";
    // } else {
    //     if (validacao({ op: 8, value: document.getElementById('data_termino_local').value }) === false) {
    //         validacao_ok = false;
    //         mensagem += 'Data Término Local inválida.' + '<br>';
    //     }
    // }

    // // Campo: tempo_apurado_local (requerido)
    // if (validacao({ op: 23, value: document.getElementById("tempo_apurado_local").value }) === false) {
    //     validacao_ok = false;
    //     mensagem += "Tempo Apurado Local inválido." + "<br>";
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

function calcularTempoApuradoLocal() {
    const dataInicial = document.getElementById('data_ingresso_local').value;
    const dataFinal = document.getElementById('data_termino_local').value;
    const tempo_apurado_local = document.getElementById('tempo_apurado_local');

    // Função interna para validar e converter a data
    function converterData(data) {
        // Verificando formato dd/mm/yyyy
        if (!/^\d{2}\/\d{2}\/\d{4}$/.test(data)) {
            return null;
        }

        const partes = data.split('/');

        const dia = Number(partes[0]);
        const mes = Number(partes[1]);
        const ano = Number(partes[2]);

        // Criando a data
        const dataConvertida = new Date(ano, mes - 1, dia);

        // Verificando se a data realmente existe
        if (
            dataConvertida.getFullYear() !== ano ||
            dataConvertida.getMonth() !== mes - 1 ||
            dataConvertida.getDate() !== dia
        ) {
            return null;
        }

        return dataConvertida;
    }

    // Convertendo as datas
    const inicio = converterData(dataInicial);
    const fim = converterData(dataFinal);

    // Se alguma data for inválida
    if (inicio === null || fim === null) {
        tempo_apurado_local.value = '00000';
        return;
    }

    // Diferença em milissegundos
    const diferenca = fim.getTime() - inicio.getTime();

    // Se o resultado for negativo
    if (diferenca < 0) {
        tempo_apurado_local.value = '00000';
        return;
    }

    // Convertendo para dias
    const dias = Math.floor(diferenca / (1000 * 60 * 60 * 24));

    // Retornando sempre com 5 dígitos
    tempo_apurado_local.value = String(dias).padStart(5, '0');

    return;
}

// Funções Settings Submodulo - Início'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
// Funções Settings Submodulo - Início'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
async function settingsSubmoduloCrudCreate() {
    await desabilitarCampos();
    await habilitarCampos();

    // Pesquisar Militar
    const militarAuto = crudAutocompleteMilitar('militares_tempos_averbados', 'create');
    militarAuto.init();
    document.getElementById('divPesquisarMilitar').style.display = '';
}

async function settingsSubmoduloCrudView(data) {
    await preencherCampos(data);
    await desabilitarCampos();
    await habilitarCampos();

    // Verificando permissões para botões
    await configurarBotoesPermissaoSituacao({ modulo: 'militares_tempos_averbados', situacaoId: data.militarSituacaoId });

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
    await configurarBotoesPermissaoSituacao({ modulo: 'militares_tempos_averbados', situacaoId: data.militarSituacaoId });

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

document.addEventListener("DOMContentLoaded", function (event) { });
