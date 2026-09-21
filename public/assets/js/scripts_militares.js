// Globais'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

// URL
let url = window.location.protocol + "//" + window.location.host + "/";
if (window.location.hostname.indexOf("cbmerj.rj.gov") != -1) { url += "dgf_sistema/"; }

// Const
const militarSituacaoId = document.getElementById('militarSituacaoId');
//'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

// Validação
async function validar_frm_militares() {
    var validacao_ok = true;
    var mensagem = "";

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

    // Campo: rg (requerido)
    if (validacao({ op: 1, value: document.getElementById("rg").value }) === false) {
        validacao_ok = false;
        mensagem += "RG requerido." + "<br>";
    } else {
        if (validacao({ op: 21, value: document.getElementById('rg').value }) === false) {
            validacao_ok = false;
            mensagem += 'RG inválido.' + '<br>';
        }
    }

    // Campo: identidade_funcional (requerido)
    if (validacao({ op: 1, value: document.getElementById("identidade_funcional").value }) === false) {
        validacao_ok = false;
        mensagem += "Identidade Funcional requerido." + "<br>";
    }

    // Campo: vinculo (requerido)
    if (validacao({ op: 1, value: document.getElementById("vinculo").value }) === false) {
        validacao_ok = false;
        mensagem += "Vínculo requerido." + "<br>";
    }

    // Campo: nome (requerido)
    if (validacao({ op: 1, value: document.getElementById("nome").value }) === false) {
        validacao_ok = false;
        mensagem += "Nome requerido." + "<br>";
    }

    // Campo: nome_guerra (requerido)
    if (validacao({ op: 1, value: document.getElementById("nome_guerra").value }) === false) {
        validacao_ok = false;
        mensagem += "Nome Guerra requerido." + "<br>";
    }

    // Campo: situacao_id (requerido)
    if (validacao({ op: 1, value: document.getElementById("situacao_id").value }) === false) {
        validacao_ok = false;
        mensagem += "Situação requerido." + "<br>";
    }

    // Campo: boletim_situacao (inválido)
    if (validacao({ op: 1, value: document.getElementById("boletim_situacao").value }) === true) {
        if (validacao({ op: 20, value: document.getElementById('boletim_situacao').value }) === false) {
            validacao_ok = false;
            mensagem += 'Boletim Situação inválido.' + '<br>';
        }
    }

    // Campo: quadro_id (requerido)
    if (validacao({ op: 1, value: document.getElementById("quadro_id").value }) === false) {
        validacao_ok = false;
        mensagem += "Quadro requerido." + "<br>";
    }

    // Campo: boletim_quadro (inválido)
    if (validacao({ op: 1, value: document.getElementById("boletim_quadro").value }) === true) {
        if (validacao({ op: 20, value: document.getElementById('boletim_quadro').value }) === false) {
            validacao_ok = false;
            mensagem += 'Boletim Quadro inválido.' + '<br>';
        }
    }

    // Campo: graduacao_id (requerido)
    if (validacao({ op: 1, value: document.getElementById("graduacao_id").value }) === false) {
        validacao_ok = false;
        mensagem += "Graduação requerido." + "<br>";
    }

    // Campo: boletim_graduacao (inválido)
    if (validacao({ op: 1, value: document.getElementById("boletim_graduacao").value }) === true) {
        if (validacao({ op: 20, value: document.getElementById('boletim_graduacao').value }) === false) {
            validacao_ok = false;
            mensagem += 'Boletim Graduação inválido.' + '<br>';
        }
    }

    // Campo: data_ingresso (requerido)
    if (validacao({ op: 1, value: document.getElementById("data_ingresso").value }) === false) {
        validacao_ok = false;
        mensagem += "Data Ingresso requerido." + "<br>";
    } else {
        if (validacao({ op: 8, value: document.getElementById('data_ingresso').value }) === false) {
            validacao_ok = false;
            mensagem += 'Data Ingresso inválida.' + '<br>';
        }
    }

    // Campo: boletim_ingresso (inválido)
    if (validacao({ op: 1, value: document.getElementById("boletim_ingresso").value }) === true) {
        if (validacao({ op: 20, value: document.getElementById('boletim_ingresso').value }) === false) {
            validacao_ok = false;
            mensagem += 'Boletim Ingresso inválido.' + '<br>';
        }
    }

    // Campo: unidade_id (requerido)
    if (validacao({ op: 1, value: document.getElementById("unidade_id").value }) === false) {
        validacao_ok = false;
        mensagem += "Unidade requerido." + "<br>";
    }

    // Campo: boletim_movimentacao (inválido)
    if (validacao({ op: 1, value: document.getElementById("boletim_movimentacao").value }) === true) {
        if (validacao({ op: 20, value: document.getElementById('boletim_movimentacao').value }) === false) {
            validacao_ok = false;
            mensagem += 'Boletim Movimentação inválido.' + '<br>';
        }
    }

    // Campo: prestando_servico_id (requerido)
    if (validacao({ op: 1, value: document.getElementById("prestando_servico_id").value }) === false) {
        validacao_ok = false;
        mensagem += "Prestando Serviço requerido." + "<br>";
    }

    // Campo: boletim_prestando_servico (inválido)
    if (validacao({ op: 1, value: document.getElementById("boletim_prestando_servico").value }) === true) {
        if (validacao({ op: 20, value: document.getElementById('boletim_prestando_servico').value }) === false) {
            validacao_ok = false;
            mensagem += 'Boletim Prestando Serviço inválido.' + '<br>';
        }
    }

    // Campo: boletim_funcao (inválido)
    if (validacao({ op: 1, value: document.getElementById("boletim_funcao").value }) === true) {
        if (validacao({ op: 20, value: document.getElementById('boletim_funcao').value }) === false) {
            validacao_ok = false;
            mensagem += 'Boletim Função inválido.' + '<br>';
        }
    }

    // Campo: boletim_segunda_praca (inválido)
    if (validacao({ op: 1, value: document.getElementById("boletim_segunda_praca").value }) === true) {
        if (validacao({ op: 20, value: document.getElementById('boletim_segunda_praca').value }) === false) {
            validacao_ok = false;
            mensagem += 'Boletim Segunda Praça inválido.' + '<br>';
        }
    }

    // Campo: boletim_comportamento (inválido)
    if (validacao({ op: 1, value: document.getElementById("boletim_comportamento").value }) === true) {
        if (validacao({ op: 20, value: document.getElementById('boletim_comportamento').value }) === false) {
            validacao_ok = false;
            mensagem += 'Boletim Comportamento inválido.' + '<br>';
        }
    }

    // Campo: data_segunda_praca (inválido)
    if (validacao({ op: 1, value: document.getElementById("data_segunda_praca").value }) === true) {
        if (validacao({ op: 8, value: document.getElementById('data_segunda_praca').value }) === false) {
            validacao_ok = false;
            mensagem += 'Data Segunda Praça inválida.' + '<br>';
        }
    }

    // Campo: data_nascimento (requerido)
    if (validacao({ op: 1, value: document.getElementById("data_nascimento").value }) === false) {
        validacao_ok = false;
        mensagem += "Data Nascimento requerido." + "<br>";
    } else {
        if (validacao({ op: 8, value: document.getElementById('data_nascimento').value }) === false) {
            validacao_ok = false;
            mensagem += 'Data Nascimento inválida.' + '<br>';
        }
    }

    // Campo: cpf (requerido)
    if (validacao({ op: 1, value: document.getElementById("cpf").value }) === false) {
        validacao_ok = false;
        mensagem += "CPF requerido." + "<br>";
    } else {
        if (validacao({ op: 7, value: document.getElementById('cpf').value }) === false) {
            validacao_ok = false;
            mensagem += 'CPF Inválido.' + '<br>';
        }
    }

    // Campo: temporario (requerido)
    if (validacao({ op: 1, value: document.getElementById("temporario").value }) === false) {
        validacao_ok = false;
        mensagem += "Temporário requerido." + "<br>";
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
    militarSituacaoId.value = data.militarSituacaoId;
}

// Desabilitar campos no Formulário
async function desabilitarCampos() { }

// Habilitar campos no Formulário
async function habilitarCampos() {
    militarSituacaoId.disabled = false;
}

async function atualizarSelectSituacaoId() {
    const frm_operacao = document.getElementById('frm_operacao');
    const response = await fetch(`permissoes_situacoes/retorna_array_campo_grupos_permissoes_situacoes/militares_permissoes_${frm_operacao.value}_situacoes_ids`);
    const data = await response.json();

    if (data.success) {
        const permissoes_ids = data.success;
        const select = document.getElementById('situacao_id');

        for (const option of select.options) {
            if (!option.value) { continue; }

            option.hidden = !permissoes_ids.includes(Number(option.value));
        }
    }
}

// Funções Settings Submodulo - Início'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
// Funções Settings Submodulo - Início'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
async function settingsSubmoduloCrudCreate() {
    await desabilitarCampos();
    await habilitarCampos();
    await atualizarSelectSituacaoId();

    militarSituacaoId.value = 0;

    // Gerar Token para Controle militarSituacaoId
    if (!await tokenServiceGerar('militarSituacaoId', militarSituacaoId.value)) return;
}

async function settingsSubmoduloCrudView(data) {
    await preencherCampos(data);
    await desabilitarCampos();
    await habilitarCampos();

    // Verificando permissões para botões
    await configurarBotoesPermissaoSituacao({ modulo: 'militares', situacaoId: data.militarSituacaoId });

    // Gerar Token para Controle militarSituacaoId
    if (!await tokenServiceGerar('militarSituacaoId', data.militarSituacaoId)) return;
}

async function settingsSubmoduloCrudEdit(data) {
    await preencherCampos(data);
    await desabilitarCampos();
    await habilitarCampos();
    await atualizarSelectSituacaoId();

    // Verificando permissões para botões
    await configurarBotoesPermissaoSituacao({ modulo: 'militares', situacaoId: data.militarSituacaoId });

    // Gerar Token para Controle militarSituacaoId
    if (!await tokenServiceGerar('militarSituacaoId', data.militarSituacaoId)) return;
}

async function settingsSubmoduloCrudDelete() { }

async function settingsSubmoduloCrudConfirmCreate() { }

async function settingsSubmoduloCrudConfirmEdit() { }
// Funções Settings Submodulo - Fim''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
// Funções Settings Submodulo - Fim''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

document.addEventListener("DOMContentLoaded", function (event) { });





function preenchimento_teste() {
    document.getElementById('rg').value = '99/9999.999';
    document.getElementById('identidade_funcional').value = '9999999999';
    document.getElementById('vinculo').value = '1';
    document.getElementById('nome').value = 'NOME TESTE';
    document.getElementById('nome_guerra').value = 'TESTE';
    document.getElementById('situacao_id').value = 1;
    document.getElementById('quadro_id').value = 1;
    document.getElementById('graduacao_id').value = 5;
    document.getElementById('data_ingresso').value = '01/02/2003';
    document.getElementById('unidade_id').value = 46;
    document.getElementById('prestando_servico_id').value = 46;
    document.getElementById('data_nascimento').value = '02/06/1971';
    document.getElementById('cpf').value = '80974494046';
    document.getElementById('temporario').value = 1;
}
