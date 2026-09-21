// URL
var url = window.location.protocol + '//' + window.location.host + '/';
if (window.location.hostname.indexOf('cbmerj.rj.gov') != -1) {
    url += 'dgf_sistema/';
}

// Elementos
const referencia = document.getElementById('referencia');
const ano = document.getElementById('ano');
const mes = document.getElementById('mes');
const parte = document.getElementById('parte');
const militares = document.getElementById('militares');

function validar_frm_ressarcimento_exclusoes() {
    var validacao_ok = true;
    var mensagem = '';

    //Campo: referencia (requerido)
    if (validacao({op:1, value:document.getElementById('referencia').value}) === false) {
        validacao_ok = false;
        mensagem += 'Referência requerido.' + '<br>';
    }

    //Campo: ano (requerido)
    if (validacao({op:1, value:document.getElementById('ano').value}) === false) {
        validacao_ok = false;
        mensagem += 'Ano requerido.' + '<br>';
    }

    //Campo: mes (requerido)
    if (validacao({op:1, value:document.getElementById('mes').value}) === false) {
        validacao_ok = false;
        mensagem += 'Mês requerido.' + '<br>';
    }

    //Campo: parte (requerido)
    if (validacao({op:1, value:document.getElementById('parte').value}) === false) {
        validacao_ok = false;
        mensagem += 'Parte requerido.' + '<br>';
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

async function prepararExclusao() {
    // crudTable
    document.getElementById('crudTable').style.display = 'none';

    // crudForm
    document.getElementById('crudForm').style.display = 'block';

    // Buscar Última Referência
    try {
        const response = await fetch(`${url}ressarcimento_exclusoes/ultima_referencia`, {
            method: 'GET',
            headers: {
                'REQUEST-ORIGIN': 'fetch',
                'Accept': 'application/json'
            }
        });

        const data = await response.json();

        if (!data.referencia?.referencia) {
            // Limpar Dados Referência
            limparDadosReferencia();

            alert('Não existe Ressarcimento para exclusão.');

            retornarGrade();

            return;
        }

        // Dados para tabela ressarcimento_exclusoes
        referencia.value = data.referencia.referencia;
        ano.value = data.referencia.ano;
        mes.value = data.referencia.mes;
        parte.value = data.referencia.parte;
        militares.value = data.militares;

        // Limpar Dados Referência
        limparDadosReferencia();

        // Buscar Dados Referência
        buscarDadosReferencia(referencia.value);
    } catch (error) {
        alert('Erro: ' + error);
    } finally { }
}

async function retornarGrade() {
    // crudTable
    document.getElementById('crudTable').style.display = 'block';

    // crudForm
    document.getElementById('crudForm').style.display = 'none';
}

function limparDadosReferencia() {
    document.getElementById('ctrl_referencia').value = '';
    document.getElementById('re_referencia').innerHTML = '';
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
    var re_referencia = getReferencia(1, referencia);

    document.getElementById('ctrl_referencia').value = referencia;
    document.getElementById('re_referencia').innerHTML = re_referencia;

    fetch(`${url}ressarcimento_exclusoes/dados_ressarcimento/${referencia}`)
    .then(response => response.json())
    .then(function (data) {
        if (data.success) {
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

document.addEventListener("DOMContentLoaded", function (event) {
    // Exclusão Ressarcimento
    document.getElementById('btn_exclusao_ressarcimento').addEventListener('click', function () {
        var modal = document.querySelector('.confirmacaoExclusaoRessarcimento');
        bootstrap.Modal.getOrCreateInstance(modal).show();
    });

    document.getElementById('btn_exclusao_ressarcimento_confirmar').addEventListener('click', function () {
        document.querySelectorAll('.confirmacaoExclusaoRessarcimento_loading').forEach(el => el.style.display = 'block');
        document.querySelectorAll('.confirmacaoExclusaoRessarcimento_botoes').forEach(el => el.style.display = 'none');

        var referencia = document.getElementById('ctrl_referencia').value;

        fetch(`${url}ressarcimento_exclusoes/deletar_pdfs_gerados/${referencia}`);

        fetch(`${url}ressarcimento_exclusoes/deletar_cobranca/${referencia}`)
        .then(response => response.json())
        .then(function (data) {
            if (data.success) {
                limparDadosReferencia();

                alertSwal('success', 'Deletar Cobrança', data.success, 'true', 4000);

                retornarGrade();
            } else if (data.error) {
                alertSwal('warning', 'Deletar Cobrança', data.error, 'true', 4000);
            } else {
                alert('Erro interno');
            }
        })
        .finally(function () {
            document.querySelectorAll('.confirmacaoExclusaoRessarcimento_loading').forEach(el => el.style.display = 'none');
            document.querySelectorAll('.confirmacaoExclusaoRessarcimento_botoes').forEach(el => el.style.display = 'block');

            var modal = document.querySelector('.confirmacaoExclusaoRessarcimento');
            bootstrap.Modal.getOrCreateInstance(modal).hide();
        });
    });
});
