function validar_frm_importar_ressarcimento_militar() {
    var validacao_ok = true;
    var mensagem = '';

    // Campo: ressarcimento_militar_referencia (requerido)
    if (validacao({op:1, value:document.getElementById('ressarcimento_militar_referencia').value}) === false) {
        validacao_ok = false;
        mensagem += 'Referência requerido.'+'<br>';
    }

    // Campo: ressarcimento_militar_file (requerido)
    if (validacao({op:1, value:document.getElementById('ressarcimento_militar_file').value}) === false) {
        validacao_ok = false;
        mensagem += 'Arquivo requerido.'+'<br>';
    }

    // Mensagem
    if (validacao_ok === false) {
        var texto = '<div class="pt-3">';
        texto += '<div class="col-12 text-start font-size-12">'+mensagem+'</div>';
        texto += '</div>';

        alertSwal('warning', 'Validação', texto, 'true', 5000);
    }

    // Retorno
    return validacao_ok;
}

// Funções Settings Submodulo - Início'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
// Funções Settings Submodulo - Início'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
async function settingsSubmoduloCrudCreate() { }

async function settingsSubmoduloCrudView() {
    var referencia = document.getElementById('referencia').value;
    document.getElementById('referencia').value = getReferencia(1, referencia);
}

async function settingsSubmoduloCrudEdit() {
    var referencia = document.getElementById('referencia').value;
    document.getElementById('referencia').value = getReferencia(1, referencia);
}

async function settingsSubmoduloCrudDelete() { }
async function settingsSubmoduloCrudConfirmCreate() { }
async function settingsSubmoduloCrudConfirmEdit() { }
// Funções Settings Submodulo - Fim''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
// Funções Settings Submodulo - Fim''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

document.addEventListener("DOMContentLoaded", function (event) {
    // URL
    var url = window.location.protocol+'//'+window.location.host+'/';
    if (window.location.hostname.indexOf('cbmerj.rj.gov') != -1) { url += 'dgf_sistema/'; }

    // Elementos
    const frm_importar_ressarcimento_militar = document.getElementById('frm_importar_ressarcimento_militar');

    // Importar Militares''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    // Botão Modal Importar Militares
    const btnModalImportarMilitar = document.getElementById('btnModalImportarMilitar');

    btnModalImportarMilitar.addEventListener('click', function () {
    // Limpar validações
        document.querySelectorAll('.is-invalid').forEach(function (el) {
            el.classList.remove('is-invalid');
        });

        // Limpar formulário
        frm_importar_ressarcimento_militar.reset();

        // Habilitar inputs
        document.querySelectorAll('input').forEach(function (el) {
            el.disabled = false;
        });

        // Habilitar selects
        document.querySelectorAll('select').forEach(function (el) {
            el.disabled = false;
        });

        // Habilitar elementos .select2
        document.querySelectorAll('.select2').forEach(function (el) {
            el.disabled = false;
        });

        // Abrir modal Bootstrap 5
        const modalElement = document.querySelector('.modal-importar-militares');
        const modal = new bootstrap.Modal(modalElement);
        modal.show();
    });

    // Botao Confirmar Importação
    const botao = document.getElementById('btnConfirmarImportacaoMilitar');

    btnConfirmarImportacaoMilitar.addEventListener('click', function (e) {
        e.preventDefault();

        // Validação
        if (validar_frm_importar_ressarcimento_militar() === true) {
            const formData = new FormData(frm_importar_ressarcimento_militar);

            fetch(url + 'ressarcimento_militares/importar', {
                method: 'POST',
                body: formData
            }).then(function (response) {
                return response.json();
            }).then(function (response) {
                if (response.success) {
                    let registrosImportados = '<div class="col-12 text-success">Registros Importados: ' + response.success.registros_importados + '</div>';

                    let registrosImportadosAnteriormente = '';
                    let qtdAnteriormente = 0;

                    response.success.registros_importados_anteriormente.forEach(function (item) {
                        registrosImportadosAnteriormente += '<div class="col-12 font-size-10">' + item + '</div>';
                        qtdAnteriormente++;
                    });

                    if (registrosImportadosAnteriormente !== '') {
                        registrosImportadosAnteriormente = '<div class="col-12 text-primary">Registros Importados anteriormente: ' + qtdAnteriormente + '</div>' + registrosImportadosAnteriormente;
                    }

                    let registrosErros = '';
                    let qtdErros = 0;

                    response.success.registros_erros.forEach(function (item) {
                        registrosErros += '<div class="col-12 font-size-10">' + item + '</div>';
                        qtdErros++;
                    });

                    if (registrosErros !== '') {
                        registrosErros = '<div class="col-12 text-danger">Registros com Erro: ' + qtdErros + '</div>' + registrosErros;
                    }

                    let planilhaError = '';
                    let qtdPlanilha = 0;

                    response.success.planilha_error.forEach(function (item) {
                        planilhaError += '<div class="col-12 font-size-10">' + item + '</div>';
                        qtdPlanilha++;
                    });

                    if (planilhaError !== '') {
                        planilhaError = '<div class="col-12 text-danger">Planilha com Erro: ' + qtdPlanilha + '</div>' +
                            planilhaError;
                    }

                    alertSwal('success', 'Ressarcimento Militares - Importação', registrosImportados + registrosImportadosAnteriormente + registrosErros + planilhaError, 'true', 50000);
                }

                if (response.error) {
                    alertSwal('error', 'Ressarcimento Militares - Importação', response.error, 'true', 3000);
                }
            })
            .catch(function (error) {
                alert(error);
            })
            .finally(function () {
                document.getElementById('modal-importar-militares-footer-1').style.display = 'block';
                document.getElementById('modal-importar-militares-footer-2').style.display = 'none';
            });

            // beforeSend
            document.getElementById('modal-importar-militares-footer-1').style.display = 'none';
            document.getElementById('modal-importar-militares-footer-2').style.display = 'block';
        }
    });
    //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
});
