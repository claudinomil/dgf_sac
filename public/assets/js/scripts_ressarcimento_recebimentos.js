// Funções Settings Submodulo - Início'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
// Funções Settings Submodulo - Início'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
async function settingsSubmoduloCrudCreate() { }
async function settingsSubmoduloCrudView() { }
async function settingsSubmoduloCrudEdit() { }
async function settingsSubmoduloCrudDelete() { }
async function settingsSubmoduloCrudConfirmCreate() { }
async function settingsSubmoduloCrudConfirmEdit() { }
// Funções Settings Submodulo - Fim''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
// Funções Settings Submodulo - Fim''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

document.addEventListener('DOMContentLoaded', function () {
    // URL
    var url = window.location.protocol+'//'+window.location.host+'/';
    if (window.location.hostname.indexOf('cbmerj.rj.gov') != -1) {url += 'dgf_sistema/';}

    // Alterar Registros
    document.getElementById('re_btn_alterar_registros')?.addEventListener('click', function () {
        preencherCamposModal();

        // Modal Bootstrap 5
        const modalEl = document.querySelector('.confirmacaoAlterarRegistrosModal');
        const modal = new bootstrap.Modal(modalEl);
        modal.show();
    });

    // re_btn_alterar_registros_confirmar
    document.getElementById('re_btn_alterar_registros_confirmar').addEventListener('click', function () {
        // Loading/Botões
        document.querySelectorAll('.confirmacaoAlterarRegistrosModal_loading').forEach(el => el.style.display = '');
        document.querySelectorAll('.confirmacaoAlterarRegistrosModal_botoes').forEach(el => el.style.display = 'none');

        // Parâmetros
        var referencia = document.getElementById('ar_referencia').value;
        var orgao_id = document.getElementById('ar_orgao').value;

        fetch(url + 'ressarcimento_recebimentos/registros_alterar/' + referencia + '/' + orgao_id)
            .then(response => response.json())
            .then(function (data) {
                if (data.success) {
                    var dados = data.success;
                    var ctrl_ln = 0;
                    var gradeRecebimentosTituloDados = '';
                    var gradeRecebimentosTheadDados = '';
                    var gradeRecebimentosTbodyDados = '';

                    var valor_a_receber_orgao = 0;
                    var valor_recebido_orgao = 0;

                    var total_valor = 0;
                    var total_valor_recebido = 0;
                    var total_saldo_restante = 0;

                    var data_recebimento;
                    var guia_recolhimento;
                    var documento;

                    dados.forEach(function (item) {
                        ctrl_ln++;

                        var recebimento_id = item.id;
                        data_recebimento = item.data_recebimento;
                        guia_recolhimento = item.guia_recolhimento;
                        documento = item.documento;

                        if (ctrl_ln === 1) {
                            document.getElementById('grade_recebimentos_referencia').value = referencia;
                            document.getElementById('grade_recebimentos_orgao_id').value = orgao_id;

                            var titulo = 'Órgão: <b>' + item.orgao + '</b><br>' + 'Referência: <b>' + getReferencia(1, item.referencia) + '</b>';

                            document.getElementById('gradeRecebimentosTitulo').innerHTML = titulo;

                            gradeRecebimentosTheadDados =
                                '<tr>' +
                                '<th class="col_militar">Militar</th>' +
                                '<th style="text-align:right;">Valor (R$)</th>' +
                                '<th style="text-align:right;">Recebido (R$)</th>' +
                                '<th style="text-align:right;">Saldo (R$)</th>' + '</tr>';

                            document.getElementById('gradeRecebimentosThead').innerHTML = gradeRecebimentosTheadDados;
                        }

                        var col_militar = item.nome + '<br>' + item.rg + ' - ' + item.posto_graduacao;

                        var col_valor = item.valor !== undefined ? item.valor : 0;
                        var col_valor_br = float2moeda(col_valor);

                        var col_valor_html = col_valor_br + '<input type="hidden" id="valor_' + recebimento_id + '" value="' + col_valor + '">';

                        total_valor += col_valor;
                        valor_a_receber_orgao += col_valor;

                        var col_valor_recebido = item.valor_recebido !== undefined ? item.valor_recebido : 0;
                        var col_valor_recebido_br = float2moeda(col_valor_recebido);

                        var col_valor_recebido_html =
                            '<input type="hidden" id="valor_recebido_' + recebimento_id + '" name="valor_recebido_' + recebimento_id + '" value="' + col_valor_recebido + '">' +
                            '<input type="text" class="form-control text-end mask_money font-size-11" ' +
                            'id="valor_recebido_br_' + recebimento_id + '" ' +
                            'value="' + col_valor_recebido_br + '" onblur="gradeRecebimentosTableConfigurar();">';

                        total_valor_recebido += col_valor_recebido;
                        valor_recebido_orgao += col_valor_recebido;

                        var col_saldo_restante = col_valor - col_valor_recebido;
                        var col_saldo_restante_br = float2moeda(col_saldo_restante);

                        var col_saldo_restante_html =
                            '<input type="hidden" id="saldo_restante_' + recebimento_id + '" name="saldo_restante_' + recebimento_id + '" value="' + col_saldo_restante + '">' +
                            '<input type="text" class="form-control text-end mask_money font-size-11" ' +
                            'id="saldo_restante_br_' + recebimento_id + '" ' +
                            'value="' + col_saldo_restante_br + '">';

                        total_saldo_restante += col_saldo_restante;

                        gradeRecebimentosTbodyDados +=
                            '<tr class="gradeRecebimentosTbodyTr" data-recebimento_id="' + recebimento_id + '">' +
                            '<td>' + col_militar + '</td>' +
                            '<td style="text-align:right;">' + col_valor_html + '</td>' +
                            '<td style="text-align:right;">' + col_valor_recebido_html + '</td>' +
                            '<td style="text-align:right;">' + col_saldo_restante_html + '</td>' +
                            '</tr>';
                    });

                    // Montando dados HTML da linha de Totais
                    total_valor_html = '<input type="text" class="form-control text-end mask_money font-size-14" id="total_valor" name="total_valor" value="' + float2moeda(total_valor) + '" readonly>';
                    total_saldo_restante_html = '<input type="text" class="form-control text-end mask_money font-size-14" id="total_saldo_restante" name="total_saldo_restante" value="' + float2moeda(total_saldo_restante) + '" readonly>';
                    total_valor_recebido_html = '<input type="text" class="form-control text-end mask_money font-size-14" id="total_valor_recebido" name="total_valor_recebido" value="' + float2moeda(total_valor_recebido) + '" readonly>';

                    gradeRecebimentosTbodyDados += '<tr>';
                    gradeRecebimentosTbodyDados += '    <td><b>TOTAIS</b></td>';
                    gradeRecebimentosTbodyDados += '    <td style="text-align: right;">' + total_valor_html + '</td>';
                    gradeRecebimentosTbodyDados += '    <td style="text-align: right;">' + total_valor_recebido_html + '</td>';
                    gradeRecebimentosTbodyDados += '    <td style="text-align: right;">' + total_saldo_restante_html + '</td>';
                    gradeRecebimentosTbodyDados += '</tr>';

                    document.getElementById('valor_a_receber_orgao').value = float2moeda(valor_a_receber_orgao);
                    document.getElementById('valor_recebido_orgao').value = float2moeda(valor_recebido_orgao);

                    document.getElementById('data_recebimento').value = formatarData(2, data_recebimento);
                    document.getElementById('guia_recolhimento').value = guia_recolhimento;
                    document.getElementById('documento').value = documento;

                    document.getElementById('gradeRecebimentosTbody').innerHTML = gradeRecebimentosTbodyDados;

                    document.getElementById('frm_operacao').value = 'edit';

                    document.querySelectorAll('input').forEach(el => el.disabled = false);
                    document.querySelectorAll('textarea').forEach(el => el.disabled = false);
                    document.querySelectorAll('select').forEach(el => el.disabled = false);
                    document.querySelectorAll('.select2').forEach(el => el.disabled = false);

                    document.getElementById('crudFormButtons1').style.display = '';
                    document.getElementById('crudFormButtons2').style.display = 'none';

                    document.getElementById('crudTable').style.display = 'none';
                    document.getElementById('crudForm').style.display = '';

                    removeMask();
                    putMask();
                } else if (data.error) {
                    removeMask();
                    putMask();
                    alertSwal('warning', data.error, '', 'true', 2000);
                } else {

                    removeMask();
                    putMask();
                    alert('Erro interno');
                }
            })
            .finally(function () {
                document.querySelectorAll('.confirmacaoAlterarRegistrosModal_loading').forEach(el => el.style.display = 'none');
                document.querySelectorAll('.confirmacaoAlterarRegistrosModal_botoes').forEach(el => el.style.display = '');

                var modalEl = document.querySelector('.confirmacaoAlterarRegistrosModal');
                bootstrap.Modal.getInstance(modalEl)?.hide();

                gradeRecebimentosTableConfigurar();
            });
    });

    // re_btn_alterar_registros_confirmar_update
    document.getElementById('re_btn_alterar_registros_confirmar_update')?.addEventListener('click', function (e) {
        e.preventDefault();

        var validacao = true;

        // Validação campos obrigatórios
        if (
            document.getElementById('valor_a_receber_orgao').value === '' ||
            document.getElementById('valor_recebido_orgao').value === '' ||
            document.getElementById('data_recebimento').value === ''
        ) {
            alert('O valor a receber, o valor recebido e a data recebimento são requeridos');
            validacao = false;
        }

        // Validação saldo restante
        if (
            document.getElementById('total_valor_recebido').value !==
            document.getElementById('total_valor').value
        ) {
            var result = confirm(
                'O valor recebido pelo Órgão é diferente do valor total. ' +
                'Saldo restante: R$ ' +
                document.getElementById('total_saldo_restante').value +
                '. Deseja confirmar?'
            );

            if (result === false) {
                validacao = false;
            }
        }

        if (validacao === true) {

            removeMask();

            var form = document.getElementById('frm_ressarcimento_recebimentos');
            var formData = new FormData(form);

            // beforeSend
            document.getElementById('crudFormButtons1').style.display = 'none';
            document.getElementById('crudFormAjaxLoading').style.display = '';

            fetch(url + 'ressarcimento_recebimentos', {
                method: 'POST',
                body: formData
            })
            .then(function (response) {
                return response.json();
            })
            .then(function (response) {

                if (response.success) {

                    alertSwal('success', "Recebimentos", response.success, 'true', 2000);

                    document.getElementById('crudTable').style.display = '';
                    document.getElementById('crudForm').style.display = 'none';

                    window.location.href = url + 'ressarcimento_recebimentos';

                } else if (response.error) {

                    alertSwal('warning', "Recebimentos", response.error, 'true', 10000);

                } else if (response.error_validation) {

                    removeMask();
                    putMask();

                    var message = '<div class="pt-3">';

                    Object.values(response.error_validation).forEach(function (value) {
                        message += '<div class="col-12 text-start font-size-12"><b>></b> ' + value + '</div>';
                    });

                    message += '</div>';

                    alertSwal('warning', "Validação", message, 'true', 20000);

                } else if (response.error_not_found) {

                    removeMask();
                    putMask();

                    alertSwal('warning', "Registro não encontrado", '', 'true', 2000);

                } else if (response.error_permissao) {

                    removeMask();
                    putMask();

                    alertSwal('warning', "Permissão Negada", '', 'true', 2000);

                } else {

                    removeMask();
                    putMask();

                    alert('Erro interno');
                }
            })
            .catch(function () {

                removeMask();
                putMask();

                alert('Erro interno');
            })
            .finally(function () {

                // complete
                document.getElementById('crudFormButtons1').style.display = '';
                document.getElementById('crudFormAjaxLoading').style.display = 'none';
            });
        }
    });

    // valor_recebido_orgao_op_1
    document.getElementById('valor_recebido_orgao_op_1')?.addEventListener('click', function () {
        // Verificando valores se iguais
        if (document.getElementById('valor_a_receber_orgao').value !== document.getElementById('valor_recebido_orgao').value) {
            alert('Valor total a receber é diferente de Valor total recebido');
            return false;
        }

        // Varrer gradeRecebimentosTbodyTr
        document.querySelectorAll('.gradeRecebimentosTbodyTr').forEach(function (tr) {
            // Pegando valores da linha
            var recebimento_id = tr.dataset.recebimento_id;

            var valor = document.getElementById('valor_' + recebimento_id).value;

            document.getElementById('valor_recebido_br_' + recebimento_id).value = float2moeda(valor);
        });

        gradeRecebimentosTableConfigurar();
    });

    // valor_recebido_orgao_op_2
    document.getElementById('valor_recebido_orgao_op_2')?.addEventListener('click', function () {
        // valor_recebido_orgao
        var valor_a_distribuir = moeda2float(
            document.getElementById('valor_recebido_orgao').value
        );

        // Varrer gradeRecebimentosTbodyTr
        document.querySelectorAll('.gradeRecebimentosTbodyTr').forEach(function (tr) {

            var recebimento_id = tr.dataset.recebimento_id;

            var valor = parseFloat(
                document.getElementById('valor_' + recebimento_id).value
            );

            if (valor_a_distribuir > valor) {
                document.getElementById('valor_recebido_br_' + recebimento_id).value = float2moeda(valor);
                valor_a_distribuir = valor_a_distribuir - valor;
            } else {
                document.getElementById('valor_recebido_br_' + recebimento_id).value = float2moeda(valor_a_distribuir);
            }
        });

        gradeRecebimentosTableConfigurar();
    });

    document.getElementById('ar_referencia')?.addEventListener('change', function () {
        preencherCamposModal();
    });
});

function preencherCamposModal() {

    // URL
    var url = window.location.protocol + '//' + window.location.host + '/';
    if (window.location.hostname.indexOf('cbmerj.rj.gov') !== -1) {
        url += 'dgf_sistema/';
    }

    // Verificar referência escolhida
    var referencia_escolhida = 'ref';
    var refValue = document.getElementById('ar_referencia').value;

    if (refValue !== null && refValue !== undefined && refValue !== '') {
        referencia_escolhida = refValue;
    }

    // Buscar dados
    fetch(url + 'ressarcimento_recebimentos/dados/modal/' + referencia_escolhida)
        .then(function (response) {
            return response.json();
        })
        .then(function (data) {
            if (data.success) {
                if (referencia_escolhida === 'ref') {
                    // Select ar_referencia
                    var referencias = data.success.referencias;
                    var ar_referencia_options = '<option value="">Escolha uma referência...</option>';

                    referencias.forEach(function (item) {
                        ar_referencia_options += '<option value="' + item.referencia + '">' +
                            getReferencia(1, item.referencia) +
                            '</option>';
                    });

                    document.getElementById('ar_referencia').innerHTML = ar_referencia_options;

                    // Limpar ar_orgao
                    document.getElementById('ar_orgao').innerHTML = '';
                } else {
                    // Select ar_orgao
                    var orgaos = data.success.orgaos;
                    var ar_orgao_options = '';

                    orgaos.forEach(function (item) {
                        ar_orgao_options += '<option value="' + item.id + '">' +
                            item.name +
                            '</option>';
                    });

                    document.getElementById('ar_orgao').innerHTML = ar_orgao_options;
                }
            }
        });
}

function gradeRecebimentosTableConfigurar() {
    var total_valor = 0;
    var total_valor_recebido = 0;
    var total_saldo_restante = 0;

    // Varrer gradeRecebimentosTbodyTr
    document.querySelectorAll('.gradeRecebimentosTbodyTr').forEach(function (tr) {

        var recebimento_id = tr.dataset.recebimento_id;

        var valor = document.getElementById('valor_' + recebimento_id).value;
        var valor_recebido = document.getElementById('valor_recebido_br_' + recebimento_id).value;

        // Alterando valores
        valor_recebido = moeda2float(valor_recebido);
        var saldo_restante = valor - valor_recebido;

        // Totais
        total_valor += 1 * valor;
        total_valor_recebido += 1 * valor_recebido;
        total_saldo_restante += 1 * saldo_restante;

        // Retornando valores
        document.getElementById('valor_' + recebimento_id).value = valor;
        document.getElementById('valor_recebido_' + recebimento_id).value = valor_recebido;
        document.getElementById('valor_recebido_br_' + recebimento_id).value = float2moeda(valor_recebido);
        document.getElementById('saldo_restante_' + recebimento_id).value = saldo_restante;
        document.getElementById('saldo_restante_br_' + recebimento_id).value = float2moeda(saldo_restante);

        // Disabled
        document.getElementById('saldo_restante_br_' + recebimento_id).disabled = true;
    });

    // Totais
    document.getElementById('total_valor').value = float2moeda(total_valor);
    document.getElementById('total_valor_recebido').value = float2moeda(total_valor_recebido);
    document.getElementById('total_saldo_restante').value = float2moeda(total_saldo_restante);

    // Ajustar tamanhos das colunas
    var col_valor = document.querySelector('#gradeRecebimentosTable .col_valor');
    var col_valor_largura = col_valor ? col_valor.offsetWidth : 0;

    if (col_valor_largura < 90) {
        col_valor_largura = 90;
    }

    document.querySelectorAll('#gradeRecebimentosTable .col_valor').forEach(function (el) {
        el.style.width = col_valor_largura + 'px';
    });

    document.querySelectorAll('#gradeRecebimentosTable .col_valor_recebido').forEach(function (el) {
        el.style.width = (col_valor_largura + 20) + 'px';
        el.style.minWidth = (col_valor_largura + 20) + 'px';
        el.style.maxWidth = (col_valor_largura + 20) + 'px';
    });

    document.querySelectorAll('#gradeRecebimentosTable .col_saldo_restante').forEach(function (el) {
        el.style.width = (col_valor_largura + 20) + 'px';
        el.style.minWidth = (col_valor_largura + 20) + 'px';
        el.style.maxWidth = (col_valor_largura + 20) + 'px';
    });
}
