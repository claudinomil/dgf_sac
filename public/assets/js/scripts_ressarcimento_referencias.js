// Elementos
const user = document.getElementById('user');

function validar_frm_ressarcimento_referencias() {
    var validacao_ok = true;
    var mensagem = '';

    //Campo: referencia (requerido)
    if (validacao({op:1, value:document.getElementById('referencia').value}) === false) {
        validacao_ok = false;
        mensagem += 'Referência requerido.'+'<br>';
    } else {
        //Campo: referencia (mínimo de 6 caracteres)
        if (validacao({op:2, value:document.getElementById('referencia').value, minCaracteres:6}) === false) {
            validacao_ok = false;
            mensagem += 'Referência precisa ter no mínimo 6 caracteres.' + '<br>';
        }

        //Campo: referencia (máximo de 6 caracteres)
        if (validacao({op:2, value:document.getElementById('referencia').value, maxCaracteres:6}) === false) {
            validacao_ok = false;
            mensagem += 'Referência precisa ter no máximo 6 caracteres.' + '<br>';
        }

        //Campo: referencia (maior/igual a 202301 e menor/igual a 203012)
        var x_referencia = document.getElementById('referencia').value;
        if (x_referencia<'202301' || x_referencia>'203012') {
            validacao_ok = false;
            mensagem += 'Referência precisa estar entre 202301 e 203012.' + '<br>';
        }
    }

    //Campo: ano (requerido)
    if (validacao({op:1, value:document.getElementById('ano').value}) === false) {
        validacao_ok = false;
        mensagem += 'Ano requerido.'+'<br>';
    } else {
        //Campo: ano (mínimo de 4 caracteres)
        if (validacao({op:2, value:document.getElementById('ano').value, minCaracteres:4}) === false) {
            validacao_ok = false;
            mensagem += 'Ano precisa ter no mínimo 4 caracteres.' + '<br>';
        }

        //Campo: ano (máximo de 4 caracteres)
        if (validacao({op:2, value:document.getElementById('ano').value, maxCaracteres:4}) === false) {
            validacao_ok = false;
            mensagem += 'Ano precisa ter no máximo 4 caracteres.' + '<br>';
        }

        //Campo: ano (maior/igual a 2023 e menor/igual a 2030)
        var x_ano = document.getElementById('ano').value;
        if (x_ano<'2023' || x_ano>'2030') {
            validacao_ok = false;
            mensagem += 'Ano precisa estar entre 2023 e 2030.' + '<br>';
        }
    }

    //Campo: mes (requerido)
    if (validacao({op:1, value:document.getElementById('mes').value}) === false) {
        validacao_ok = false;
        mensagem += 'Mês requerido.'+'<br>';
    } else {
        //Campo: mes (mínimo de 2 caracteres)
        if (validacao({op:2, value:document.getElementById('mes').value, minCaracteres:2}) === false) {
            validacao_ok = false;
            mensagem += 'Mês precisa ter no mínimo 2 caracteres.' + '<br>';
        }

        //Campo: mes (máximo de 2 caracteres)
        if (validacao({op:2, value:document.getElementById('mes').value, maxCaracteres:2}) === false) {
            validacao_ok = false;
            mensagem += 'Mês precisa ter no máximo 2 caracteres.' + '<br>';
        }

        //Campo: mes (maior/igual a 01 e menor/igual a 12)
        var x_mes = document.getElementById('mes').value;
        if (x_mes<'01' || x_mes>'12') {
            validacao_ok = false;
            mensagem += 'Mês precisa estar entre 01 e 12.' + '<br>';
        }
    }

    //Campo: parte (requerido)
    if (validacao({op:1, value:document.getElementById('parte').value}) === false) {
        validacao_ok = false;
        mensagem += 'Parte requerido.'+'<br>';
    } else {
        //Campo: parte (mínimo de 2 caracteres)
        if (validacao({op:2, value:document.getElementById('parte').value, minCaracteres:2}) === false) {
            validacao_ok = false;
            mensagem += 'Parte precisa ter no mínimo 2 caracteres.' + '<br>';
        }

        //Campo: parte (máximo de 2 caracteres)
        if (validacao({op:2, value:document.getElementById('parte').value, maxCaracteres:2}) === false) {
            validacao_ok = false;
            mensagem += 'Parte precisa ter no máximo 2 caracteres.' + '<br>';
        }

        //Campo: parte (maior/igual a 01 e menor/igual a 31)
        var x_parte = document.getElementById('parte').value;
        if (x_parte<'01' || x_parte>'31') {
            validacao_ok = false;
            mensagem += 'Parte precisa estar entre 01 e 31.' + '<br>';
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
async function settingsSubmoduloCrudCreate() {}

async function settingsSubmoduloCrudView() {
    const referencia = document.getElementById('referencia').value;
    document.getElementById('referencia_extenso').value = getReferencia(1, referencia);
}

async function settingsSubmoduloCrudEdit() {
    const referencia = document.getElementById('referencia').value;
    document.getElementById('referencia_extenso').value = getReferencia(1, referencia);
}

async function settingsSubmoduloCrudDelete() { }
async function settingsSubmoduloCrudConfirmCreate() {}
async function settingsSubmoduloCrudConfirmEdit() {}
// Funções Settings Submodulo - Fim''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
// Funções Settings Submodulo - Fim''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

document.addEventListener("DOMContentLoaded", function (event) {
    const mes = document.getElementById('mes');
    const ano = document.getElementById('ano');
    const parte = document.getElementById('parte');
    const referencia = document.getElementById('referencia');
    const referenciaExtenso = document.getElementById('referencia_extenso');

    mes.addEventListener('keyup', formatarCampoReferencia);
    ano.addEventListener('keyup', formatarCampoReferencia);
    parte.addEventListener('keyup', formatarCampoReferencia);

    function formatarCampoReferencia() {
        const valorMes = mes.value;
        const valorAno = ano.value;
        const valorParte = parte.value;

        referencia.value = '';
        referenciaExtenso.value = '';

        if (valorAno.length === 4 && valorMes.length === 2 && valorParte.length === 2) {
            const valorReferencia = valorAno + valorMes + valorParte;
            const valorReferenciaExtenso = getReferencia(1, valorReferencia);

            referencia.value = valorReferencia;
            referenciaExtenso.value = valorReferenciaExtenso;
        }
    }
});
