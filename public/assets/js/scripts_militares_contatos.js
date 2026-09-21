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
async function validar_frm_militares_contatos() {
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

    // Campo: cep (não requerido / CEP Válido)
    if (validacao({ op: 1, value: document.getElementById('cep').value }) === true) {
        // Campo: cep (CEP Válido)
        if (validacao({ op: 9, value: document.getElementById('cep').value }) === false) {
            validacao_ok = false;
            mensagem += 'CEP Inválido.' + '<br>';
        } else {
            // Campo: numero (não requerido / somente números)
            if (validacao({ op: 1, value: document.getElementById('numero').value }) === true) {
                // Campo: numero (requerido)
                if (validacao({ op: 1, value: document.getElementById('numero').value }) === false) {
                    validacao_ok = false;
                    mensagem += 'Número requerido.' + '<br>';
                }

                // Campo: logradouro (requerido)
                if (validacao({ op: 1, value: document.getElementById('logradouro').value }) === false) {
                    validacao_ok = false;
                    mensagem += 'Logradouro requerido.' + '<br>';
                }

                // Campo: localidade (requerido)
                if (validacao({ op: 1, value: document.getElementById('localidade').value }) === false) {
                    validacao_ok = false;
                    mensagem += 'Localidade requerido.' + '<br>';
                }

                // Campo: bairro (requerido)
                if (validacao({ op: 1, value: document.getElementById('bairro').value }) === false) {
                    validacao_ok = false;
                    mensagem += 'Bairro requerido.' + '<br>';
                }

                // Campo: uf (requerido)
                if (validacao({ op: 1, value: document.getElementById('uf').value }) === false) {
                    validacao_ok = false;
                    mensagem += 'UF requerido.' + '<br>';
                }
            }
        }
    }

    // Campo: telefone_1 (não requerido)
    if (validacao({ op: 1, value: document.getElementById("telefone_1").value }) === true) {
        // Campo: telefone_1 (valido)
        if (validacao({ op: 11, value: document.getElementById("telefone_1").value }) === false) {
            validacao_ok = false;
            mensagem += "Telefone 1 inválido." + "<br>";
        }
    }

    // Campo: telefone_2 (não requerido)
    if (validacao({ op: 1, value: document.getElementById("telefone_2").value }) === true) {
        // Campo: telefone_2 (valido)
        if (validacao({ op: 11, value: document.getElementById("telefone_2").value }) === false) {
            validacao_ok = false;
            mensagem += "Telefone 2 inválido." + "<br>";
        }
    }

    // Campo: celular_1 (não requerido)
    if (validacao({ op: 1, value: document.getElementById("celular_1").value }) === true) {
        // Campo: celular_1 (valido)
        if (validacao({ op: 11, value: document.getElementById("celular_1").value }) === false) {
            validacao_ok = false;
            mensagem += "Celular 1 inválido." + "<br>";
        }
    }

    // Campo: celular_2 (não requerido)
    if (validacao({ op: 1, value: document.getElementById("celular_2").value }) === true) {
        // Campo: celular_2 (valido)
        if (validacao({ op: 11, value: document.getElementById("celular_2").value }) === false) {
            validacao_ok = false;
            mensagem += "Celular 2 inválido." + "<br>";
        }
    }

    // Campo: email (não requerido)
    if (validacao({ op: 1, value: document.getElementById("email").value }) === true) {
        // Campo: email (valido)
        if (validacao({ op: 5, value: document.getElementById("email").value }) === false) {
            validacao_ok = false;
            mensagem += "E-mail inválido." + "<br>";
        }
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
    const militarAuto = crudAutocompleteMilitar('militares_contatos', 'create');
    militarAuto.init();
    document.getElementById('divPesquisarMilitar').style.display = '';
}

async function settingsSubmoduloCrudView(data) {
    await preencherCampos(data);
    await desabilitarCampos();
    await habilitarCampos();

    // Verificando permissões para botões
    await configurarBotoesPermissaoSituacao({ modulo: 'militares_contatos', situacaoId: data.militarSituacaoId });

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
    await configurarBotoesPermissaoSituacao({ modulo: 'militares_contatos', situacaoId: data.militarSituacaoId });

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
