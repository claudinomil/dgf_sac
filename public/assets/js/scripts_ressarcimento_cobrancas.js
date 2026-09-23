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

document.addEventListener("DOMContentLoaded", function () {
    // URL
    var url = window.location.protocol + '//' + window.location.host + '/';
    if (window.location.hostname.indexOf('cbmerj.rj.gov') != -1) {
        url += 'dgf_sistema/';
    }

    // Buscar Dados da Referência
    document.querySelectorAll('.re_btn_referencia').forEach(function (element) {
        element.addEventListener('click', function () {
            var referencia = this.dataset.referencia;

            limparDadosReferencia();
            buscarDadosReferencia(referencia);
        });
    });

    // Gerar Cobrança
    document.getElementById('re_btn_gerar_cobranca').addEventListener('click', function () {
        var modal = document.querySelector('.confirmacaoGerarCobrancaModal');
        bootstrap.Modal.getOrCreateInstance(modal).show();
    });

    document.getElementById('re_btn_gerar_cobranca_confirmar').addEventListener('click', function () {
        document.querySelectorAll('.confirmacaoGerarCobrancaModal_loading').forEach(el => el.style.display = 'block');
        document.querySelectorAll('.confirmacaoGerarCobrancaModal_botoes').forEach(el => el.style.display = 'none');

        var referencia = document.getElementById('ctrl_referencia').value;

        fetch(url + 'ressarcimento_cobrancas/deletar_pdfs_gerados/' + referencia);

        fetch(url + 'ressarcimento_cobrancas/gerar_cobrancas/' + referencia)
        .then(response => response.json())
        .then(function (data) {
            if (data.success) {
                limparDadosReferencia();
                buscarDadosReferencia(referencia);

                alertSwal('success', 'Gerar Cobrança', data.success, 'true', 2000);
            } else if (data.error) {
                alertSwal('warning', 'Gerar Cobrança', data.error, 'true', 4000);
            } else {
                alert('Erro interno');
            }
        })
        .finally(function () {
            document.querySelectorAll('.confirmacaoGerarCobrancaModal_loading').forEach(el => el.style.display = 'none');
            document.querySelectorAll('.confirmacaoGerarCobrancaModal_botoes').forEach(el => el.style.display = 'block');

            var modal = document.querySelector('.confirmacaoGerarCobrancaModal');
            bootstrap.Modal.getOrCreateInstance(modal).hide();
        });
    });

    // Gerar PDFs
    document.getElementById('re_btn_gerar_pdfs').addEventListener('click', function () {
        var modal = document.querySelector('.confirmacaoGerarPdfsModal');
        bootstrap.Modal.getOrCreateInstance(modal).show();
    });

    document.getElementById('re_btn_gerar_pdfs_confirmar').addEventListener('click', function () {
        document.querySelectorAll('.confirmacaoGerarPdfsModal_loading').forEach(el => el.style.display = 'block');
        document.querySelectorAll('.confirmacaoGerarPdfsModal_progresso').forEach(el => el.style.display = 'block');
        document.querySelectorAll('.confirmacaoGerarPdfsModal_botoes').forEach(el => el.style.display = 'none');

        var referencia = document.getElementById('ctrl_referencia').value;

        // Verificar Progresso dos PDFs''''''''''''''''''''''''''''''''''''''''''''''''''''''
        var intervaloProgresso = setInterval(function () {
            fetch(url + 'ressarcimento_cobrancas/progresso_gerar_pdfs/' + referencia)
                .then(response => response.json())
                .then(function (data) {
                    document.getElementById('pdfs_listagens').textContent = data.listagens;
                    document.getElementById('pdfs_notas').textContent = data.notas;
                    document.getElementById('pdfs_oficios').textContent = data.oficios;
                })
                .catch(function (error) {
                    console.error('Erro ao consultar progresso dos PDFs:', error);
                });
        }, 1000);
        //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        // Deletar PDF's
        fetch(url + 'ressarcimento_cobrancas/deletar_pdfs_gerados/' + referencia);

        // Gerar PDF's
        fetch(url + 'ressarcimento_cobrancas/gerar_pdfs/' + referencia)
            .then(response => response.json())
            .then(function (data) {
                if (data.success) {
                    limparDadosReferencia();
                    buscarDadosReferencia(referencia);

                    alertSwal('success', 'Gerar PDFs', data.success, 'true', 2000);
                } else if (data.error) {
                    alertSwal('warning', 'Gerar PDFs', data.error, 'true', 4000);
                } else {
                    alert('Erro interno');
                }
            })
            .finally(function () {
                // Interromper Progresso dos PDFs''''''''''''
                clearInterval(intervaloProgresso);
                //'''''''''''''''''''''''''''''''''''''''''''

                document.querySelectorAll('.confirmacaoGerarPdfsModal_loading').forEach(el => el.style.display = 'none');
                document.querySelectorAll('.confirmacaoGerarPdfsModal_progresso').forEach(el => el.style.display = 'none');
                document.querySelectorAll('.confirmacaoGerarPdfsModal_botoes').forEach(el => el.style.display = 'block');

                var modal = document.querySelector('.confirmacaoGerarPdfsModal');
                bootstrap.Modal.getOrCreateInstance(modal).hide();
            });
    });

    // Baixar PDFs
    document.getElementById('re_btn_baixar_pdfs').addEventListener('click', function () {
        var referencia = document.getElementById('ctrl_referencia').value;

        fetch(url + 'ressarcimento_cobrancas/verificar_existe_zip/' + referencia)
            .then(response => response.json())
            .then(function (data) {
                if (data.success) {
                    var url_atual = window.location.protocol + '//' + window.location.host + '/';

                    const link = document.createElement('a');
                    link.href = url_atual + 'assets/pdfs/cobrancas/cobranca_' + referencia + '.zip';
                    link.download = 'cobranca_' + referencia + '.zip';

                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);

                    alertSwal('success', 'Baixar PDFs', data.success, 'true', 2000);
                } else {
                    alertSwal('warning', 'Baixar PDFs', data.error, 'true', 4000);
                }
            });
    });

    function preencherConfirmacaoModal(configuracoes) {
        document.getElementById('confirmacaoGerarCobrancaModal_data_vencimento').innerHTML = configuracoes['data_vencimento'];

        document.getElementById('confirmacaoGerarCobrancaModal_diretor_linha_0').innerHTML = configuracoes['diretor_cargo'];
        document.getElementById('confirmacaoGerarCobrancaModal_diretor_linha_1').innerHTML = configuracoes['diretor_nome'] + ' - ' + configuracoes['diretor_posto'] + ' ' + configuracoes['diretor_quadro'];
        document.getElementById('confirmacaoGerarCobrancaModal_diretor_linha_2').innerHTML = configuracoes['diretor_cargo'];
        document.getElementById('confirmacaoGerarCobrancaModal_diretor_linha_3').innerHTML = 'ID Funcional: ' + configuracoes['diretor_identidade_funcional'];

        document.getElementById('confirmacaoGerarCobrancaModal_dgf2_linha_0').innerHTML = configuracoes['dgf2_cargo'];
        document.getElementById('confirmacaoGerarCobrancaModal_dgf2_linha_1').innerHTML = configuracoes['dgf2_nome'] + ' - ' + configuracoes['dgf2_posto'] + ' ' + configuracoes['dgf2_quadro'];
        document.getElementById('confirmacaoGerarCobrancaModal_dgf2_linha_2').innerHTML = configuracoes['dgf2_cargo'];
        document.getElementById('confirmacaoGerarCobrancaModal_dgf2_linha_3').innerHTML = 'ID Funcional: ' + configuracoes['dgf2_identidade_funcional'];
    }

    function limparDadosReferencia() {
        document.getElementById('ctrl_referencia').value = '';
        document.getElementById('re_referencia').innerHTML = '';
        document.getElementById('re_status_dados').innerHTML = '';
        document.getElementById('re_status_documentos').innerHTML = '';
        document.getElementById('re_quantidade_orgaos').innerHTML = '0';
        document.getElementById('re_quantidade_militares').innerHTML = '0';
        document.getElementById('re_quantidade_pagamentos').innerHTML = '0';
        document.getElementById('re_quantidade_configuracoes').innerHTML = '0';
        document.getElementById('re_quantidade_cobranca').innerHTML = '0';
        document.getElementById('re_quantidade_listagens').innerHTML = '0';
        document.getElementById('re_quantidade_notas').innerHTML = '0';
        document.getElementById('re_quantidade_oficios').innerHTML = '0';
        document.getElementById('re_registros_grade_status_dados').innerHTML = '';
        document.getElementById('re_registros_grade_status_documentos').innerHTML = '';
    }

    function buscarDadosReferencia(referencia) {
        var url = window.location.protocol + '//' + window.location.host + '/';
        if (window.location.hostname.indexOf('cbmerj.rj.gov') != -1) {
            url += 'dgf_sistema/';
        }

        var re_referencia = getReferencia(1, referencia);

        document.getElementById('ctrl_referencia').value = referencia;
        document.getElementById('re_referencia').innerHTML = re_referencia;

        fetch(url + 'ressarcimento_cobrancas/dados_ressarcimento/' + referencia)
        .then(response => response.json())
        .then(function (data) {
            if (data.success) {
                var re_status_dados = '';

                if (data.success.re_status_dados == 1) {
                    re_status_dados = '<span class="text-success">' + data.success.re_status_dados_texto + '</span>';
                } else if (data.success.re_status_dados == 0) {
                    re_status_dados = '<span class="text-danger">' + data.success.re_status_dados_texto + '</span>';
                }

                var re_status_documentos = '';

                if (data.success.re_status_documentos == 1) {
                    re_status_documentos = '<span class="text-success">' + data.success.re_status_documentos_texto + '</span>';
                } else if (data.success.re_status_documentos == 0) {
                    re_status_documentos = '<span class="text-danger">' + data.success.re_status_documentos_texto + '</span>';
                }

                if (data.success.re_status_dados == 1) {
                    var configuracoes = data.success.re_configuracoes[0];
                    preencherConfirmacaoModal(configuracoes);

                    document.getElementById('div_botao_cobrancas').style.display = 'block';
                } else {
                    document.getElementById('div_botao_cobrancas').style.display = 'none';
                }

                document.getElementById('re_status_dados').innerHTML = re_status_dados;
                document.getElementById('re_status_documentos').innerHTML = re_status_documentos;
                document.getElementById('re_referencia').innerHTML = data.success.re_referencia;
                document.getElementById('re_quantidade_orgaos').innerHTML = data.success.re_quantidade_orgaos;
                document.getElementById('re_quantidade_militares').innerHTML = data.success.re_quantidade_militares;
                document.getElementById('re_quantidade_pagamentos').innerHTML = data.success.re_quantidade_pagamentos;
                document.getElementById('re_quantidade_configuracoes').innerHTML = data.success.re_quantidade_configuracoes;
                document.getElementById('re_quantidade_cobranca').innerHTML = data.success.re_quantidade_cobranca;
                document.getElementById('re_quantidade_listagens').innerHTML = data.success.re_quantidade_listagens;
                document.getElementById('re_quantidade_notas').innerHTML = data.success.re_quantidade_notas;
                document.getElementById('re_quantidade_oficios').innerHTML = data.success.re_quantidade_oficios;

                // Registros Grade de Status dos Dados'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
                var grade_inicio = '';
                var grade_meio = '';
                var grade_fim = '';

                grade_inicio += '<div class="table-responsive">';
                grade_inicio += '<table class="table align-middle mb-0">';
                grade_inicio += '<thead class="table-light">';
                grade_inicio += '<tr>';
                grade_inicio += '<th style="width: 5px;">#</th>';
                grade_inicio += '<th class="align-middle">Status dos Dados</th>';
                grade_inicio += '<th class="align-middle">Detalhes</th>';
                grade_inicio += '</tr>';
                grade_inicio += '</thead>';
                grade_inicio += '<tbody>';

                var linha = 0;

                data.success.re_registros_grade_status_dados.forEach(function (item, i) {
                    grade_meio += '<tr>';

                    //Linha
                    linha++;
                    grade_meio += '<td>' + linha + '</td>';

                    //Status
                    var status = '<span class="text-' + item.status_cor + ' font-size-12">' + item.status + '</span>';
                    grade_meio += '<td>' + status + '</td>';

                    //Detalhes
                    var detalhes = '';
                    if (item.detalhes != '') {
                        detalhes = '<button type="button" class="btn btn-warning btn-sm btn-rounded small" data-bs-toggle="modal" data-bs-target=".gradeRegistrosModal" onclick="document.querySelector(\'.gradeRegistrosModal #gradeRegistrosModalLabel\').innerHTML=\'<font class=text-' + item.status_cor + '>' + item.status + '</font>\'; document.querySelector(\'.gradeRegistrosModal .modal-body\').innerHTML=\'' + item.detalhes + '\';">ver Detalhes</button>';
                    }
                    grade_meio += '<td>' + detalhes + '</td>';

                    grade_meio += '</tr>';
                });

                grade_fim += '</tbody>';
                grade_fim += '</table>';
                grade_fim += '</div>';

                //Html
                document.getElementById('re_registros_grade_status_dados').innerHTML = grade_inicio + grade_meio + grade_fim;
                //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

                // Registros Grade de Status dos Documentos''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
                var grade_inicio = '';
                var grade_meio = '';
                var grade_fim = '';

                grade_inicio += '<div class="table-responsive">';
                grade_inicio += '<table class="table align-middle mb-0">';
                grade_inicio += '<thead class="table-light">';
                grade_inicio += '<tr>';
                grade_inicio += '<th style="width: 5px;">#</th>';
                grade_inicio += '<th class="align-middle">Status dos Documentos</th>';
                grade_inicio += '<th class="align-middle">Detalhes</th>';
                grade_inicio += '</tr>';
                grade_inicio += '</thead>';
                grade_inicio += '<tbody>';

                var linha = 0;

                data.success.re_registros_grade_status_documentos.forEach(function (item, i) {
                    grade_meio += '<tr>';

                    // Linha
                    linha++;
                    grade_meio += '<td>' + linha + '</td>';

                    // Status
                    var status = '<span class="text-' + item.status_cor + ' font-size-12">' + item.status + '</span>';
                    grade_meio += '<td>' + status + '</td>';

                    // Detalhes
                    var detalhes = '';
                    if (item.detalhes != '') {
                        detalhes = '<button type="button" class="btn btn-warning btn-sm btn-rounded small" data-bs-toggle="modal" data-bs-target=".gradeRegistrosModal" onclick="document.querySelector(\'.gradeRegistrosModal #gradeRegistrosModalLabel\').innerHTML=\'<font class=text-' + item.status_cor + '>' + item.status + '</font>\'; document.querySelector(\'.gradeRegistrosModal .modal-body\').innerHTML=\'' + item.detalhes + '\';">ver Detalhes</button>';
                    }
                    grade_meio += '<td>' + detalhes + '</td>';

                    grade_meio += '</tr>';
                });

                grade_fim += '</tbody>';
                grade_fim += '</table>';
                grade_fim += '</div>';

                // Html
                document.getElementById('re_registros_grade_status_documentos').innerHTML = grade_inicio + grade_meio + grade_fim;
                //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

                alertSwal('success', 'Informações Referência', 'Informações verificadas com sucesso.', 'true', 2000);
            } else if (data.error) {
                alertSwal('warning', 'Informações Referência', data.error, 'true', 4000);
            } else {
                alert('Erro interno');
            }
        });
    }
});
