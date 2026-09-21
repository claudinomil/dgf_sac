function validar_frm_ressarcimento_configuracoes() {
    var validacao_ok = true;
    var mensagem = '';

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
    //URL
    var url = window.location.protocol+'//'+window.location.host+'/';
    if (window.location.hostname.indexOf('cbmerj.rj.gov') != -1) { url += 'dgf_sistema/'; }

    document.getElementById("diretor_rg").addEventListener("keyup", async function () {
        let rg = document.getElementById("diretor_rg").value;

        try {
            const response = await fetch(`${url}webservices/militar/rg/${rg}`, {
                method: 'GET',
                headers: { 'REQUEST-ORIGIN': 'fetch' }
            });

            const data = await response.json();

            if (data.success) {
                let militar = data.success;

                // Retornar dados para os inputs
                document.getElementById('diretor_identidade_funcional').value = militar.identidade_funcional;
                document.getElementById('diretor_nome').value = militar.nome;
                document.getElementById('diretor_posto').value = militar.graduacao;
                document.getElementById('diretor_quadro').value = militar.quadro;

                document.getElementById('errorDiretorRg').innerHTML = '';
            } else {
                // Retornar dados para os inputs
                document.getElementById('diretor_identidade_funcional').value = '';
                document.getElementById('diretor_nome').value = '';
                document.getElementById('diretor_posto').value = '';
                document.getElementById('diretor_quadro').value = '';

                document.getElementById('errorDiretorRg').innerHTML = data.error;
            }
        } catch (error) {
            console.error("Erro na requisição:", error);
        }
    });

    document.getElementById("dgf2_rg").addEventListener("keyup", async function () {
        let rg = document.getElementById("dgf2_rg").value;

        try {
            const response = await fetch(`${url}webservices/militar/rg/${rg}`, {
                method: 'GET',
                headers: { 'REQUEST-ORIGIN': 'fetch' }
            });

            const data = await response.json();

            if (data.success) {
                let militar = data.success;

                // Retornar dados para os inputs
                document.getElementById('dgf2_identidade_funcional').value = militar.identidade_funcional;
                document.getElementById('dgf2_nome').value = militar.nome;
                document.getElementById('dgf2_posto').value = militar.graduacao;
                document.getElementById('dgf2_quadro').value = militar.quadro;

                document.getElementById('errorDgf2Rg').innerHTML = '';
            } else {
                // Retornar dados para os inputs
                document.getElementById('dgf2_identidade_funcional').value = '';
                document.getElementById('dgf2_nome').value = '';
                document.getElementById('dgf2_posto').value = '';
                document.getElementById('dgf2_quadro').value = '';

                document.getElementById('errorDgf2Rg').innerHTML = data.error;
            }
        } catch (error) {
            console.error("Erro na requisição:", error);
        }
    });
});
