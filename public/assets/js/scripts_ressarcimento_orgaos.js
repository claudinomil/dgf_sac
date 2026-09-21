function validar_frm_ressarcimento_orgaos() {
    var validacao_ok = true;
    var mensagem = '';

    //Campo: name (requerido)
    if (validacao({op:1, value:document.getElementById('name').value}) === false) {
        validacao_ok = false;
        mensagem += 'Nome requerido.'+'<br>';
    }

    //Campo: cnpj (não requerido)
    if (validacao({op:1, value:document.getElementById('cnpj').value}) === true) {
        if (validacao({op: 6, value: document.getElementById('cnpj').value}) === false) {
            validacao_ok = false;
            mensagem += 'CNPJ inválido.' + '<br>';
        }
    }

    //Campo: esfera_id (requerido)
    if (validacao({op:1, value:document.getElementById('esfera_id').value}) === false) {
        validacao_ok = false;
        mensagem += 'Esfera requerido.'+'<br>';
    }

    //Campo: poder_id (requerido)
    if (validacao({op:1, value:document.getElementById('poder_id').value}) === false) {
        validacao_ok = false;
        mensagem += 'Poder requerido.'+'<br>';
    }

    //Campo: tratamento_id (requerido)
    if (validacao({op:1, value:document.getElementById('tratamento_id').value}) === false) {
        validacao_ok = false;
        mensagem += 'Tratamento requerido.'+'<br>';
    }

    //Campo: vocativo_id (requerido)
    if (validacao({op:1, value:document.getElementById('vocativo_id').value}) === false) {
        validacao_ok = false;
        mensagem += 'Vocativo requerido.'+'<br>';
    }

    //Campo: ressarcimento_funcao_id (requerido)
    if (validacao({op:1, value:document.getElementById('ressarcimento_funcao_id').value}) === false) {
        validacao_ok = false;
        mensagem += 'Função requerido.'+'<br>';
    }

    //Campo: cep (requerido)
    if (validacao({op:1, value:document.getElementById('cep').value}) === false) {
        validacao_ok = false;
        mensagem += 'CEP requerido.'+'<br>';
    } else {
        if (validacao({op: 9, value: document.getElementById('cep').value}) === false) {
            validacao_ok = false;
            mensagem += 'CEP inválido.' + '<br>';
        }
    }

    //Campo: numero (requerido)
    if (validacao({op:1, value:document.getElementById('numero').value}) === false) {
        validacao_ok = false;
        mensagem += 'Número requerido.'+'<br>';
    } else {
        if (validacao({op:4, value:document.getElementById('numero').value}) === false) {
            validacao_ok = false;
            mensagem += 'Número inválido.'+'<br>';
        }
    }

    //Campo: telefone_1 (não requerido)
    if (validacao({op:1, value:document.getElementById('telefone_1').value}) === true) {
        if (validacao({op:11, value:document.getElementById('telefone_1').value}) === false) {
            validacao_ok = false;
            mensagem += 'Telefone 1 inválido.'+'<br>';
        }
    }

    //Campo: telefone_2 (não requerido)
    if (validacao({op:1, value:document.getElementById('telefone_2').value}) === true) {
        if (validacao({op:11, value:document.getElementById('telefone_2').value}) === false) {
            validacao_ok = false;
            mensagem += 'Telefone 2 inválido.'+'<br>';
        }
    }

    //Campo: contato_telefone (não requerido)
    if (validacao({op:1, value:document.getElementById('contato_telefone').value}) === true) {
        if (validacao({op:11, value:document.getElementById('contato_telefone').value}) === false) {
            validacao_ok = false;
            mensagem += 'Contato telefone inválido.'+'<br>';
        }
    }

    //Campo: contato_celular (não requerido)
    if (validacao({op:1, value:document.getElementById('contato_celular').value}) === true) {
        if (validacao({op:12, value:document.getElementById('contato_celular').value}) === false) {
            validacao_ok = false;
            mensagem += 'Contato celular inválido.'+'<br>';
        }
    }

    //Campo: contato_email (não requerido)
    if (validacao({op:1, value:document.getElementById('contato_email').value}) === true) {
        if (validacao({op:5, value:document.getElementById('contato_email').value}) === false) {
            validacao_ok = false;
            mensagem += 'Contato e-mail inválido.'+'<br>';
        }
    }

    //Mensagem
    if (validacao_ok === false) {
        var texto = '<div class="pt-3">';
        texto += '<div class="col-12 text-start font-size-12">'+mensagem+'</div>';
        texto += '</div>';

        alertSwal('warning', 'Validação', texto, 'true', 5000);
    }

    //Retorno
    return validacao_ok;
}

// Funções Settings Submodulo - Início'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
// Funções Settings Submodulo - Início'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
async function settingsSubmoduloCrudCreate() { }
async function settingsSubmoduloCrudView() { }
async function settingsSubmoduloCrudEdit() { }
async function settingsSubmoduloCrudDelete() { }
async function settingsSubmoduloCrudConfirmCreate() {}
async function settingsSubmoduloCrudConfirmEdit() {}
// Funções Settings Submodulo - Fim''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
// Funções Settings Submodulo - Fim''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

document.addEventListener("DOMContentLoaded", function (event) { });
