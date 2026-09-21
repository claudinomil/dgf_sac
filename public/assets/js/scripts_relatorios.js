// Globais'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
let url = window.location.protocol + '//' + window.location.host + '/';
if (window.location.hostname.indexOf('cbmerj.rj.gov') !== -1) { url += 'dgf_sistema/'; }
//'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

async function dashTopo(op) {
    try {
        // Buscar Relatórios para o Grupo do Usuário
        const response = await fetch('relatorios/relatorios_grupo', {
            method: 'GET',
            headers: { 'REQUEST-ORIGIN': 'fetch' }
        });

        const data = await response.json();

        let relatorios = [];

        if (data.success) { relatorios = data.success; }

        // Elementos
        const dash_topo_titulo = document.getElementById('dash_topo_titulo');
        const relatorios_sistema = document.getElementById('relatorios_sistema');
        const relatorios_efetivo = document.getElementById('relatorios_efetivo');
        const relatorios_ressarcimento = document.getElementById('relatorios_ressarcimento');

        // Iniciando
        dash_topo_titulo.innerText = '';
        relatorios_sistema.style.display = 'none';
        relatorios_efetivo.style.display = 'none';
        relatorios_ressarcimento.style.display = 'none';

        // Relatorios Sistema
        if (op == 1) {
            dash_topo_titulo.innerText = 'Sistema';
            relatorios_sistema.style.display = '';

            // Filtro
            dados = data.success.filter(relatorio => relatorio.relatorioGrupoId == 1);

            let html = '<div class="row g-2 d-flex">';

            dados.forEach(relatorio => {
                html += `<div class="col" onclick="relatoriosRelatorio${relatorio.relatorioId}(1, '${relatorio.relatorioName}')" style="cursor: pointer;">
                            <div class="card mini-stats-wid h-100">
                                <div class="card-body p-2">
                                    <div class="d-flex align-items-center">
                                        <div class="w-100">
                                            <p class="text-muted fw-medium mb-1 font-size-12 text-nowrap">${relatorio.relatorioName}</p>
                                        </div>
                                        <div class="ms-auto ps-3">
                                            <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
                                                <span class="avatar-title rounded-circle bg-primary">
                                                    <i class="bx bx-printer font-size-24"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>`;
            });

            html += '</div>';

            document.getElementById('relatorios_sistema').innerHTML = html;
        }

        // Relatorios Efetivo
        if (op == 2) {
            dash_topo_titulo.innerText = 'Efetivo';
            relatorios_efetivo.style.display = '';

            // Filtro
            dados = data.success.filter(relatorio => relatorio.relatorioGrupoId == 2);

            let html = '<div class="row g-2 d-flex">';

            dados.forEach(relatorio => {
                html += `<div class="col" onclick="relatoriosRelatorio${relatorio.relatorioId}(1, '${relatorio.relatorioName}')" style="cursor: pointer;">
                            <div class="card mini-stats-wid h-100">
                                <div class="card-body p-2">
                                    <div class="d-flex align-items-center">
                                        <div class="w-100">
                                            <p class="text-muted fw-medium mb-1 font-size-12 text-nowrap">${relatorio.relatorioName}</p>
                                        </div>
                                        <div class="ms-auto ps-3">
                                            <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
                                                <span class="avatar-title rounded-circle bg-primary">
                                                    <i class="bx bx-printer font-size-24"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>`;
            });

            html += '</div>';

            document.getElementById('relatorios_efetivo').innerHTML = html;
        }

        // Relatorios Ressarcimento
        if (op == 3) {
            dash_topo_titulo.innerText = 'Ressarcimento';
            relatorios_ressarcimento.style.display = '';

            // Filtro
            dados = data.success.filter(relatorio => relatorio.relatorioGrupoId == 3);

            let html = '<div class="row g-2 d-flex">';

            dados.forEach(relatorio => {
                html += `<div class="col" onclick="relatoriosRelatorio${relatorio.relatorioId}(1, '${relatorio.relatorioName}')" style="cursor: pointer;">
                            <div class="card mini-stats-wid h-100">
                                <div class="card-body p-2">
                                    <div class="d-flex align-items-center">
                                        <div class="w-100">
                                            <p class="text-muted fw-medium mb-1 font-size-12 text-nowrap">${relatorio.relatorioName}</p>
                                        </div>
                                        <div class="ms-auto ps-3">
                                            <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
                                                <span class="avatar-title rounded-circle bg-primary">
                                                    <i class="bx bx-printer font-size-24"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>`;
            });

            html += '</div>';

            document.getElementById('relatorios_ressarcimento').innerHTML = html;
        }
    } catch (error) {
        alert('Erro dashTopo: ' + error);
    }
}

// Relatório 1 : Grupos
async function relatoriosRelatorio1(op = 1, relatorio_name = '') {
    if (op == 1) {
        // Título Modal
        document.getElementById('modal_relatorio_1_titulo').innerHTML = relatorio_name;

        // Abrir Modal
        new bootstrap.Modal(document.getElementById('modal_relatorio_1')).show();
    } else {
        try {
            // Colocar Processando...
            document.getElementById('modal_relatorio_1_footer_1').style.display = 'none';
            document.getElementById('modal_relatorio_1_footer_2').style.display = 'block';

            // Buscar Dados
            const response = await fetch(url + 'relatorios/relatorio_1/' + document.getElementById('modal_relatorio_1_grupo_id').value, {
                method: 'GET',
                headers: { 'REQUEST-ORIGIN': 'fetch' }
            });

            const data = await response.json();

            if (!data.success) {
                alert(data.error);

                // Retirar Processando...
                document.getElementById('modal_relatorio_1_footer_2').style.display = 'none';
                document.getElementById('modal_relatorio_1_footer_1').style.display = 'block';

                return;
            }

            // Dados da tabela Cabeçalho
            let dadosTableCabecalho = [['NOME']];

            // Dados da tabela Linhas
            let dadosTableLinhas = [];

            data.success['relatorio_registros'].forEach(function(item) {
                dadosTableLinhas.push([item.name]);
            });

            // Gerar PDF
            gerarPdfTabela({
                p_header: true,
                p_topo_1: false,
                p_topo_2: true,
                p_nome: data.success['relatorio_nome'],
                p_parametros: true,
                p_parametros_texto: data.success['relatorio_parametros'],
                p_dadosTableCabecalho: dadosTableCabecalho,
                p_dadosTableLinhas: dadosTableLinhas,
                p_footer: true,
                p_data: data.success['relatorio_data'],
                p_hora: data.success['relatorio_hora']
            });

            // Retirar Processando...
            document.getElementById('modal_relatorio_1_footer_2').style.display = 'none';
            document.getElementById('modal_relatorio_1_footer_1').style.display = 'block';

            // Fechar Modal
            document.getElementById('modal_relatorio_1_cancelar').click();

        } catch (error) {
            console.error('Erro relatoriosRelatorio1 : ', error);

            alert('Erro ao gerar relatório.');

            // Retirar Processando...
            document.getElementById('modal_relatorio_1_footer_2').style.display = 'none';
            document.getElementById('modal_relatorio_1_footer_1').style.display = 'block';
        }
    }
}

// Relatório 2 : Usuários
async function relatoriosRelatorio2(op = 1, relatorio_name = '') {
    if (op == 1) {
        // Título Modal
        document.getElementById('modal_relatorio_2_titulo').innerHTML = relatorio_name;

        // Abrir Modal
        new bootstrap.Modal(document.getElementById('modal_relatorio_2')).show();
    } else {
        try {
            // Colocar Processando...
            document.getElementById('modal_relatorio_2_footer_1').style.display = 'none';
            document.getElementById('modal_relatorio_2_footer_2').style.display = 'block';

            // Buscar Dados
            const response = await fetch(url + 'relatorios/relatorio_2/' + document.getElementById('modal_relatorio_2_grupo_id').value + '/' + document.getElementById('modal_relatorio_2_user_situacao_id').value + '/' + document.getElementById('modal_relatorio_2_user_tipo_id').value, {
                method: 'GET',
                headers: { 'REQUEST-ORIGIN': 'fetch' }
            });

            const data = await response.json();

            if (!data.success) {
                alert(data.error);

                // Retirar Processando...
                document.getElementById('modal_relatorio_2_footer_2').style.display = 'none';
                document.getElementById('modal_relatorio_2_footer_1').style.display = 'block';

                return;
            }

            // Dados da tabela Cabeçalho
            let dadosTableCabecalho = [['NOME','E-MAIL','GRUPO','SITUAÇÃO','MILITAR/CIVIL']];

            // Dados da tabela Linhas
            let dadosTableLinhas = [];

            data.success['relatorio_registros'].forEach(function (item) {
                var nome = item.name;
                var email = item.email;
                var grupo = item.grupo;
                var situacao = item.user_situacao;
                var tipo = '';
                if (item.user_tipo_id == 1) { tipo = item.user + ' - ' + item.militar_posto_graduacao; }
                if (item.user_tipo_id == 2) { tipo = item.user + ' - ' + 'CIVIL'; }

                dadosTableLinhas.push([nome, email, grupo, situacao, tipo]);
            });

            // Gerar PDF
            gerarPdfTabela({
                p_header: true,
                p_topo_1: false,
                p_topo_2: true,
                p_nome: data.success['relatorio_nome'],
                p_parametros: true,
                p_parametros_texto: data.success['relatorio_parametros'],
                p_dadosTableCabecalho: dadosTableCabecalho,
                p_dadosTableLinhas: dadosTableLinhas,
                p_footer: true,
                p_data: data.success['relatorio_data'],
                p_hora: data.success['relatorio_hora']
            });

            // Retirar Processando...
            document.getElementById('modal_relatorio_2_footer_2').style.display = 'none';
            document.getElementById('modal_relatorio_2_footer_1').style.display = 'block';

            // Fechar Modal
            document.getElementById('modal_relatorio_2_cancelar').click();

        } catch (error) {
            console.error('Erro relatoriosRelatorio2 : ', error);

            alert('Erro ao gerar relatório.');

            // Retirar Processando...
            document.getElementById('modal_relatorio_2_footer_2').style.display = 'none';
            document.getElementById('modal_relatorio_2_footer_1').style.display = 'block';
        }
    }
}

// Relatório 3 : Transações
async function relatoriosRelatorio3(op = 1, relatorio_name = '') {
    if (op == 1) {
        // Título Modal
        document.getElementById('modal_relatorio_3_titulo').innerHTML = relatorio_name;

        // Abrir Modal
        new bootstrap.Modal(document.getElementById('modal_relatorio_3')).show();
    } else {
        try {
            // Colocar Processando...
            document.getElementById('modal_relatorio_3_footer_1').style.display = 'none';
            document.getElementById('modal_relatorio_3_footer_2').style.display = 'block';

            // Acertos nos inputs
            var modal_relatorio_3_data = 'xxxyyyzzz';
            if (document.getElementById('modal_relatorio_3_data').value != '') { modal_relatorio_3_data = formatarData(1, document.getElementById('modal_relatorio_3_data').value); }

            var modal_relatorio_3_dado = 'xxxyyyzzz';
            if (document.getElementById('modal_relatorio_3_dado').value != '') { modal_relatorio_3_dado = document.getElementById('modal_relatorio_3_dado').value; }

            // Buscar Dados
            const response = await fetch(url + 'relatorios/relatorio_3/' + modal_relatorio_3_data + '/' + document.getElementById('modal_relatorio_3_user_id').value + '/' + document.getElementById('modal_relatorio_3_submodulo_id').value + '/' + document.getElementById('modal_relatorio_3_operacao_id').value + '/' + modal_relatorio_3_dado, {
                method: 'GET',
                headers: { 'REQUEST-ORIGIN': 'fetch' }
            });

            const data = await response.json();
            console.log(data);
            if (!data.success) {
                alert(data.error);

                // Retirar Processando...
                document.getElementById('modal_relatorio_3_footer_2').style.display = 'none';
                document.getElementById('modal_relatorio_3_footer_1').style.display = 'block';

                return;
            }

            // Dados da tabela Cabeçalho
            let dadosTableCabecalho = [['DATA','USUÁRIO','SUBMÓDULO','OPERAÇÃO','DADOS']];

            // Dados da tabela Linhas
            let dadosTableLinhas = [];

            data.success['relatorio_registros'].forEach(function (item) {
                let dados = '';

                if (item.dados && item.dados.campos) {
                    item.dados.campos.forEach(campo => {
                        dados += `${campo.etiqueta}\n`;
                        dados += `Anterior: ${campo.anterior_view ?? campo.anterior ?? '-'} ## `;
                        dados += `Atual: ${campo.atual_view ?? campo.atual ?? '-'}\n\n`;
                    });
                }

                dadosTableLinhas.push([item.date, item.user, item.submodulo, item.operacao, dados]);
            });

            // Gerar PDF
            gerarPdfTabela({
                p_header: true,
                p_topo_1: false,
                p_topo_2: true,
                p_nome: data.success['relatorio_nome'],
                p_parametros: true,
                p_parametros_texto: data.success['relatorio_parametros'],
                p_dadosTableCabecalho: dadosTableCabecalho,
                p_dadosTableLinhas: dadosTableLinhas,
                p_footer: true,
                p_data: data.success['relatorio_data'],
                p_hora: data.success['relatorio_hora']
            });

            // Retirar Processando...
            document.getElementById('modal_relatorio_3_footer_2').style.display = 'none';
            document.getElementById('modal_relatorio_3_footer_1').style.display = 'block';

            // Fechar Modal
            document.getElementById('modal_relatorio_3_cancelar').click();

        } catch (error) {
            console.error('Erro relatoriosRelatorio3 : ', error);

            alert('Erro ao gerar relatório.');

            // Retirar Processando...
            document.getElementById('modal_relatorio_3_footer_2').style.display = 'none';
            document.getElementById('modal_relatorio_3_footer_1').style.display = 'block';
        }
    }
}

// Relatório 4 : MILITARES POR REFERÊNCIA E ÓRGÃO
async function relatoriosRelatorio4(op = 1, relatorio_name = '') {
    if (op == 1) {
        // Título Modal
        document.getElementById('modal_relatorio_4_titulo').innerHTML = relatorio_name;

        // Abrir Modal
        new bootstrap.Modal(document.getElementById('modal_relatorio_4')).show();
    } else {
        try {
            // Colocar Processando...
            document.getElementById('modal_relatorio_4_footer_1').style.display = 'none';
            document.getElementById('modal_relatorio_4_footer_2').style.display = 'block';

            // Buscar Dados
            const response = await fetch(url + 'relatorios/relatorio_4/' + document.getElementById('modal_relatorio_4_referencia').value + '/' + document.getElementById('modal_relatorio_4_orgao_id').value, {
                method: 'GET',
                headers: { 'REQUEST-ORIGIN': 'fetch' }
            });

            const data = await response.json();

            if (!data.success) {
                alert(data.error);

                // Retirar Processando...
                document.getElementById('modal_relatorio_4_footer_2').style.display = 'none';
                document.getElementById('modal_relatorio_4_footer_1').style.display = 'block';

                return;
            }

            // Dados da tabela Cabeçalho
            let dadosTableCabecalho = [['ÓRGÃO','MILITAR','ID FUNC.','POSTO/GRAD','QUADRO']];

            // Dados da tabela Linhas
            let dadosTableLinhas = [];

            data.success['relatorio_registros'].forEach(function (item) {
                dadosTableLinhas.push([item.orgao_nome, item.militar_nome, item.militar_identidade_funcional, item.militar_posto_graduacao, item.militar_quadro]);
            });

            // Gerar PDF
            gerarPdfTabela({
                p_header: true,
                p_topo_1: false,
                p_topo_2: true,
                p_nome: data.success['relatorio_nome'],
                p_parametros: true,
                p_parametros_texto: data.success['relatorio_parametros'],
                p_dadosTableCabecalho: dadosTableCabecalho,
                p_dadosTableLinhas: dadosTableLinhas,
                p_footer: true,
                p_data: data.success['relatorio_data'],
                p_hora: data.success['relatorio_hora']
            });

            // Retirar Processando...
            document.getElementById('modal_relatorio_4_footer_2').style.display = 'none';
            document.getElementById('modal_relatorio_4_footer_1').style.display = 'block';

            // Fechar Modal
            document.getElementById('modal_relatorio_4_cancelar').click();

        } catch (error) {
            console.error('Erro relatoriosRelatorio4 : ', error);

            alert('Erro ao gerar relatório.');

            // Retirar Processando...
            document.getElementById('modal_relatorio_4_footer_2').style.display = 'none';
            document.getElementById('modal_relatorio_4_footer_1').style.display = 'block';
        }
    }
}

// Relatório 5 : RESSARCIMENTO POR REFERÊNCIA E ÓRGÃO
async function relatoriosRelatorio5(op = 1, relatorio_name = '') {
    if (op == 1) {
        // Título Modal
        document.getElementById('modal_relatorio_5_titulo').innerHTML = relatorio_name;

        // Abrir Modal
        new bootstrap.Modal(document.getElementById('modal_relatorio_5')).show();
    } else {
        try {
            // Colocar Processando...
            document.getElementById('modal_relatorio_5_footer_1').style.display = 'none';
            document.getElementById('modal_relatorio_5_footer_2').style.display = 'block';

            // Buscar Dados
            const response = await fetch(url + 'relatorios/relatorio_5/' + document.getElementById('modal_relatorio_5_referencia').value + '/' + document.getElementById('modal_relatorio_5_orgao_id').value, {
                method: 'GET',
                headers: { 'REQUEST-ORIGIN': 'fetch' }
            });

            const data = await response.json();

            if (!data.success) {
                alert(data.error);

                // Retirar Processando...
                document.getElementById('modal_relatorio_5_footer_2').style.display = 'none';
                document.getElementById('modal_relatorio_5_footer_1').style.display = 'block';

                return;
            }

            // Dados da tabela Cabeçalho
            let dadosTableCabecalho = [['ÓRGÃO','VENCIMENTOS BRUTOS','ENCARGOS SOCIAIS E PATRONAIS','RESSARCIMENTO']];

            // Dados da tabela Linhas
            let dadosTableLinhas = [];

            data.success['relatorio_registros'].forEach(function (item) {
                dadosTableLinhas.push([item.orgao_name,float2moeda(item.vencimentos_brutos),float2moeda(item.encargos_sociais_e_patronais),float2moeda(item.ressarcimento)]);
            });

            //Definir as configurações de estilo para cada célula
            const columnStyles = {
                1: { halign: 'right' },
                2: { halign: 'right' },
                3: { halign: 'right' }
            };

            //Gerar PDF
            gerarPdfTabela({
                p_orientation:'p',
                p_header:true,
                p_topo_1:false,
                p_topo_2:true,
                p_nome:data.success['relatorio_nome'],
                p_parametros:true,
                p_parametros_texto:data.success['relatorio_parametros'],
                p_dadosTableCabecalho:dadosTableCabecalho,
                p_dadosTableLinhas:dadosTableLinhas,
                p_columnStyles:columnStyles,
                p_footer:true,
                p_data:data.success['relatorio_data'],
                p_hora:data.success['relatorio_hora']
            });

            // Retirar Processando...
            document.getElementById('modal_relatorio_5_footer_2').style.display = 'none';
            document.getElementById('modal_relatorio_5_footer_1').style.display = 'block';

            // Fechar Modal
            document.getElementById('modal_relatorio_5_cancelar').click();

        } catch (error) {
            console.error('Erro relatoriosRelatorio5 : ', error);

            alert('Erro ao gerar relatório.');

            // Retirar Processando...
            document.getElementById('modal_relatorio_5_footer_2').style.display = 'none';
            document.getElementById('modal_relatorio_5_footer_1').style.display = 'block';
        }
    }
}

// Relatório 6 : DÍVIDA DO(S) ÓRGÃO(S)
async function relatoriosRelatorio6(op = 1, relatorio_name = '') {
    if (op == 1) {
        // Título Modal
        document.getElementById('modal_relatorio_6_titulo').innerHTML = relatorio_name;

        // Abrir Modal
        new bootstrap.Modal(document.getElementById('modal_relatorio_6')).show();
    } else {
        try {
            // Colocar Processando...
            document.getElementById('modal_relatorio_6_footer_1').style.display = 'none';
            document.getElementById('modal_relatorio_6_footer_2').style.display = 'block';

            // Buscar Dados
            const response = await fetch(url + 'relatorios/relatorio_6/' + document.getElementById('modal_relatorio_6_referencia').value + '/' + document.getElementById('modal_relatorio_6_orgao_id').value + '/' + document.getElementById('modal_relatorio_6_saldo').value, {
                method: 'GET',
                headers: { 'REQUEST-ORIGIN': 'fetch' }
            });

            const data = await response.json();

            if (!data.success) {
                alert(data.error);

                // Retirar Processando...
                document.getElementById('modal_relatorio_6_footer_2').style.display = 'none';
                document.getElementById('modal_relatorio_6_footer_1').style.display = 'block';

                return;
            }

            // Dados da tabela Cabeçalho
            let dadosTableCabecalho = [['ÓRGÃO','RESSARCIMENTO','RECEBIMENTO','SALDO']];

            // Dados da tabela Linhas
            let dadosTableLinhas = [];

            data.success['relatorio_registros'].forEach(function (item) {
                dadosTableLinhas.push([item.orgao_name,float2moeda(item.ressarcimento),float2moeda(item.recebimento),float2moeda(item.saldo)]);
            });

            //Definir as configurações de estilo para cada célula
            const columnStyles = {
                1: { halign: 'right' },
                2: { halign: 'right' },
                3: { halign: 'right' }
            };

            //Gerar PDF
            gerarPdfTabela({
                p_orientation:'p',
                p_header:true,
                p_topo_1:false,
                p_topo_2:true,
                p_nome:data.success['relatorio_nome'],
                p_parametros:true,
                p_parametros_texto:data.success['relatorio_parametros'],
                p_dadosTableCabecalho:dadosTableCabecalho,
                p_dadosTableLinhas:dadosTableLinhas,
                p_columnStyles:columnStyles,
                p_footer:true,
                p_data:data.success['relatorio_data'],
                p_hora:data.success['relatorio_hora']
            });

            // Retirar Processando...
            document.getElementById('modal_relatorio_6_footer_2').style.display = 'none';
            document.getElementById('modal_relatorio_6_footer_1').style.display = 'block';

            // Fechar Modal
            document.getElementById('modal_relatorio_6_cancelar').click();

        } catch (error) {
            console.error('Erro relatoriosRelatorio6 : ', error);

            alert('Erro ao gerar relatório.');

            // Retirar Processando...
            document.getElementById('modal_relatorio_6_footer_2').style.display = 'none';
            document.getElementById('modal_relatorio_6_footer_1').style.display = 'block';
        }
    }
}

// Relatório 7 : Militares por Situação
async function relatoriosRelatorio7(op = 1, relatorio_name = '') {
    if (op == 1) {
        // Título Modal
        document.getElementById('modal_relatorio_7_titulo').innerHTML = relatorio_name;

        // Abrir Modal
        new bootstrap.Modal(document.getElementById('modal_relatorio_7')).show();
    } else {
        try {
            // Colocar Processando...
            document.getElementById('modal_relatorio_7_footer_1').style.display = 'none';
            document.getElementById('modal_relatorio_7_footer_2').style.display = 'block';

            // Buscar Dados
            const response = await fetch(url + 'relatorios/relatorio_7', {
                method: 'GET',
                headers: { 'REQUEST-ORIGIN': 'fetch' }
            });

            const data = await response.json();

            if (!data.success) {
                alert(data.error);

                // Retirar Processando...
                document.getElementById('modal_relatorio_7_footer_2').style.display = 'none';
                document.getElementById('modal_relatorio_7_footer_1').style.display = 'block';

                return;
            }

            // Dados da tabela Cabeçalho
            let dadosTableCabecalho = [['SITUAÇÃO', 'QTD']];

            // Dados da tabela Linhas
            let dadosTableLinhas = [];

            data.success['relatorio_registros'].forEach(function(item) {
                dadosTableLinhas.push([item.name, item.quantidade]);
            });

            // Gerar PDF
            gerarPdfTabela({
                p_header: true,
                p_topo_1: false,
                p_topo_2: true,
                p_nome: data.success['relatorio_nome'],
                p_parametros: true,
                p_parametros_texto: data.success['relatorio_parametros'],
                p_dadosTableCabecalho: dadosTableCabecalho,
                p_dadosTableLinhas: dadosTableLinhas,
                p_footer: true,
                p_data: data.success['relatorio_data'],
                p_hora: data.success['relatorio_hora']
            });

            // Retirar Processando...
            document.getElementById('modal_relatorio_7_footer_2').style.display = 'none';
            document.getElementById('modal_relatorio_7_footer_1').style.display = 'block';

            // Fechar Modal
            document.getElementById('modal_relatorio_7_cancelar').click();

        } catch (error) {
            console.error('Erro relatoriosRelatorio7 : ', error);

            alert('Erro ao gerar relatório.');

            // Retirar Processando...
            document.getElementById('modal_relatorio_7_footer_2').style.display = 'none';
            document.getElementById('modal_relatorio_7_footer_1').style.display = 'block';
        }
    }
}

// Relatório 8 : Militares por Graduação
async function relatoriosRelatorio8(op = 1, relatorio_name = '') {
    if (op == 1) {
        // Título Modal
        document.getElementById('modal_relatorio_8_titulo').innerHTML = relatorio_name;

        // Abrir Modal
        new bootstrap.Modal(document.getElementById('modal_relatorio_8')).show();
    } else {
        try {
            // Colocar Processando...
            document.getElementById('modal_relatorio_8_footer_1').style.display = 'none';
            document.getElementById('modal_relatorio_8_footer_2').style.display = 'block';

            // Buscar Dados
            const response = await fetch(url + 'relatorios/relatorio_8', {
                method: 'GET',
                headers: { 'REQUEST-ORIGIN': 'fetch' }
            });

            const data = await response.json();

            if (!data.success) {
                alert(data.error);

                // Retirar Processando...
                document.getElementById('modal_relatorio_8_footer_2').style.display = 'none';
                document.getElementById('modal_relatorio_8_footer_1').style.display = 'block';

                return;
            }

            // Dados da tabela Cabeçalho
            let dadosTableCabecalho = [['GRADUAÇÃO', 'QTD']];

            // Dados da tabela Linhas
            let dadosTableLinhas = [];

            data.success['relatorio_registros'].forEach(function(item) {
                dadosTableLinhas.push([item.name, item.quantidade]);
            });

            // Gerar PDF
            gerarPdfTabela({
                p_header: true,
                p_topo_1: false,
                p_topo_2: true,
                p_nome: data.success['relatorio_nome'],
                p_parametros: true,
                p_parametros_texto: data.success['relatorio_parametros'],
                p_dadosTableCabecalho: dadosTableCabecalho,
                p_dadosTableLinhas: dadosTableLinhas,
                p_footer: true,
                p_data: data.success['relatorio_data'],
                p_hora: data.success['relatorio_hora']
            });

            // Retirar Processando...
            document.getElementById('modal_relatorio_8_footer_2').style.display = 'none';
            document.getElementById('modal_relatorio_8_footer_1').style.display = 'block';

            // Fechar Modal
            document.getElementById('modal_relatorio_8_cancelar').click();

        } catch (error) {
            console.error('Erro relatoriosRelatorio8 : ', error);

            alert('Erro ao gerar relatório.');

            // Retirar Processando...
            document.getElementById('modal_relatorio_8_footer_2').style.display = 'none';
            document.getElementById('modal_relatorio_8_footer_1').style.display = 'block';
        }
    }
}

// Relatório 9 : Militares por Unidade
async function relatoriosRelatorio9(op = 1, relatorio_name = '') {
    if (op == 1) {
        // Título Modal
        document.getElementById('modal_relatorio_9_titulo').innerHTML = relatorio_name;

        // Abrir Modal
        new bootstrap.Modal(document.getElementById('modal_relatorio_9')).show();
    } else {
        try {
            // Colocar Processando...
            document.getElementById('modal_relatorio_9_footer_1').style.display = 'none';
            document.getElementById('modal_relatorio_9_footer_2').style.display = 'block';

            // Buscar Dados
            const response = await fetch(url + 'relatorios/relatorio_9', {
                method: 'GET',
                headers: { 'REQUEST-ORIGIN': 'fetch' }
            });

            const data = await response.json();

            if (!data.success) {
                alert(data.error);

                // Retirar Processando...
                document.getElementById('modal_relatorio_9_footer_2').style.display = 'none';
                document.getElementById('modal_relatorio_9_footer_1').style.display = 'block';

                return;
            }

            // Dados da tabela Cabeçalho
            let dadosTableCabecalho = [['UNIDADE', 'QTD']];

            // Dados da tabela Linhas
            let dadosTableLinhas = [];

            data.success['relatorio_registros'].forEach(function(item) {
                dadosTableLinhas.push([item.name, item.quantidade]);
            });

            // Gerar PDF
            gerarPdfTabela({
                p_header: true,
                p_topo_1: false,
                p_topo_2: true,
                p_nome: data.success['relatorio_nome'],
                p_parametros: true,
                p_parametros_texto: data.success['relatorio_parametros'],
                p_dadosTableCabecalho: dadosTableCabecalho,
                p_dadosTableLinhas: dadosTableLinhas,
                p_footer: true,
                p_data: data.success['relatorio_data'],
                p_hora: data.success['relatorio_hora']
            });

            // Retirar Processando...
            document.getElementById('modal_relatorio_9_footer_2').style.display = 'none';
            document.getElementById('modal_relatorio_9_footer_1').style.display = 'block';

            // Fechar Modal
            document.getElementById('modal_relatorio_9_cancelar').click();

        } catch (error) {
            console.error('Erro relatoriosRelatorio9 : ', error);

            alert('Erro ao gerar relatório.');

            // Retirar Processando...
            document.getElementById('modal_relatorio_9_footer_2').style.display = 'none';
            document.getElementById('modal_relatorio_9_footer_1').style.display = 'block';
        }
    }
}

// Relatório 10 : Militares por Quadro
async function relatoriosRelatorio10(op = 1, relatorio_name = '') {
    if (op == 1) {
        // Título Modal
        document.getElementById('modal_relatorio_10_titulo').innerHTML = relatorio_name;

        // Abrir Modal
        new bootstrap.Modal(document.getElementById('modal_relatorio_10')).show();
    } else {
        try {
            // Colocar Processando...
            document.getElementById('modal_relatorio_10_footer_1').style.display = 'none';
            document.getElementById('modal_relatorio_10_footer_2').style.display = 'block';

            // Buscar Dados
            const response = await fetch(url + 'relatorios/relatorio_10', {
                method: 'GET',
                headers: { 'REQUEST-ORIGIN': 'fetch' }
            });

            const data = await response.json();

            if (!data.success) {
                alert(data.error);

                // Retirar Processando...
                document.getElementById('modal_relatorio_10_footer_2').style.display = 'none';
                document.getElementById('modal_relatorio_10_footer_1').style.display = 'block';

                return;
            }

            // Dados da tabela Cabeçalho
            let dadosTableCabecalho = [['QUADRO', 'QTD']];

            // Dados da tabela Linhas
            let dadosTableLinhas = [];

            data.success['relatorio_registros'].forEach(function(item) {
                dadosTableLinhas.push([item.name, item.quantidade]);
            });

            // Gerar PDF
            gerarPdfTabela({
                p_header: true,
                p_topo_1: false,
                p_topo_2: true,
                p_nome: data.success['relatorio_nome'],
                p_parametros: true,
                p_parametros_texto: data.success['relatorio_parametros'],
                p_dadosTableCabecalho: dadosTableCabecalho,
                p_dadosTableLinhas: dadosTableLinhas,
                p_footer: true,
                p_data: data.success['relatorio_data'],
                p_hora: data.success['relatorio_hora']
            });

            // Retirar Processando...
            document.getElementById('modal_relatorio_10_footer_2').style.display = 'none';
            document.getElementById('modal_relatorio_10_footer_1').style.display = 'block';

            // Fechar Modal
            document.getElementById('modal_relatorio_10_cancelar').click();

        } catch (error) {
            console.error('Erro relatoriosRelatorio10 : ', error);

            alert('Erro ao gerar relatório.');

            // Retirar Processando...
            document.getElementById('modal_relatorio_10_footer_2').style.display = 'none';
            document.getElementById('modal_relatorio_10_footer_1').style.display = 'block';
        }
    }
}

// Relatório 11 : Militares por Comportamento
async function relatoriosRelatorio11(op = 1, relatorio_name = '') {
    if (op == 1) {
        // Título Modal
        document.getElementById('modal_relatorio_11_titulo').innerHTML = relatorio_name;

        // Abrir Modal
        new bootstrap.Modal(document.getElementById('modal_relatorio_11')).show();
    } else {
        try {
            // Colocar Processando...
            document.getElementById('modal_relatorio_11_footer_1').style.display = 'none';
            document.getElementById('modal_relatorio_11_footer_2').style.display = 'block';

            // Buscar Dados
            const response = await fetch(url + 'relatorios/relatorio_11', {
                method: 'GET',
                headers: { 'REQUEST-ORIGIN': 'fetch' }
            });

            const data = await response.json();

            if (!data.success) {
                alert(data.error);

                // Retirar Processando...
                document.getElementById('modal_relatorio_11_footer_2').style.display = 'none';
                document.getElementById('modal_relatorio_11_footer_1').style.display = 'block';

                return;
            }

            // Dados da tabela Cabeçalho
            let dadosTableCabecalho = [['COMPORTAMENTO', 'QTD']];

            // Dados da tabela Linhas
            let dadosTableLinhas = [];

            data.success['relatorio_registros'].forEach(function(item) {
                dadosTableLinhas.push([item.name, item.quantidade]);
            });

            // Gerar PDF
            gerarPdfTabela({
                p_header: true,
                p_topo_1: false,
                p_topo_2: true,
                p_nome: data.success['relatorio_nome'],
                p_parametros: true,
                p_parametros_texto: data.success['relatorio_parametros'],
                p_dadosTableCabecalho: dadosTableCabecalho,
                p_dadosTableLinhas: dadosTableLinhas,
                p_footer: true,
                p_data: data.success['relatorio_data'],
                p_hora: data.success['relatorio_hora']
            });

            // Retirar Processando...
            document.getElementById('modal_relatorio_11_footer_2').style.display = 'none';
            document.getElementById('modal_relatorio_11_footer_1').style.display = 'block';

            // Fechar Modal
            document.getElementById('modal_relatorio_11_cancelar').click();

        } catch (error) {
            console.error('Erro relatoriosRelatorio11 : ', error);

            alert('Erro ao gerar relatório.');

            // Retirar Processando...
            document.getElementById('modal_relatorio_11_footer_2').style.display = 'none';
            document.getElementById('modal_relatorio_11_footer_1').style.display = 'block';
        }
    }
}

// Relatório 12 : Militares
async function relatoriosRelatorio12(op = 1, relatorio_name = '') {
    if (op == 1) {
        // Título Modal
        document.getElementById('modal_relatorio_12_titulo').innerHTML = relatorio_name;

        // Abrir Modal
        new bootstrap.Modal(document.getElementById('modal_relatorio_12')).show();
    } else {
        try {
            // Colocar Processando...
            document.getElementById('modal_relatorio_12_footer_1').style.display = 'none';
            document.getElementById('modal_relatorio_12_footer_2').style.display = 'block';

            // Pegar valores
            const situacoes = pegarCheckboxesMarcados('modal_relatorio_12_situacoes_checkboxes');
            const graduacoes = pegarCheckboxesMarcados('modal_relatorio_12_graduacoes_checkboxes');
            const unidades = pegarCheckboxesMarcados('modal_relatorio_12_unidades_checkboxes');
            const quadros = pegarCheckboxesMarcados('modal_relatorio_12_quadros_checkboxes');
            const comportamentos = pegarCheckboxesMarcados('modal_relatorio_12_comportamentos_checkboxes');

            // Validação
            if (situacoes == 0) {
                alert('Marque ao menos uma Situação.');

                // Retirar Processando...
                document.getElementById('modal_relatorio_12_footer_2').style.display = 'none';
                document.getElementById('modal_relatorio_12_footer_1').style.display = 'block';

                return;
            }

            // Pegar Campos
            const campos_valores = [];
            const campos_textos = [];

            document.querySelectorAll('[name="modal_relatorio_12_campos_colunas[]"]').forEach(select => {
                if (select.value !== '') {
                    campos_valores.push(select.value);
                    campos_textos.push(select.options[select.selectedIndex].text);
                }
            });

            // Validação
            if (campos_valores.length == 0) {
                alert('Escolha ao menos um Campo.');

                // Retirar Processando...
                document.getElementById('modal_relatorio_12_footer_2').style.display = 'none';
                document.getElementById('modal_relatorio_12_footer_1').style.display = 'block';

                return;
            }

            // Montar URL
            const rota = `${url}relatorios/relatorio_12/${situacoes}/${graduacoes}/${unidades}/${quadros}/${comportamentos}`;

            // Buscar Dados
            const response = await fetch(rota, {
                method: 'GET',
                headers: { 'REQUEST-ORIGIN': 'fetch' }
            });

            const data = await response.json();

            if (!data.success) {
                alert(data.error);

                // Retirar Processando...
                document.getElementById('modal_relatorio_12_footer_2').style.display = 'none';
                document.getElementById('modal_relatorio_12_footer_1').style.display = 'block';

                return;
            }

            // Dados da tabela Cabeçalho
            let dadosTableCabecalho = [campos_textos];

            // Dados da tabela Linhas
            let dadosTableLinhas = [];

            data.success['relatorio_registros'].forEach(function (item) {
                let linha = [];

                campos_valores.forEach(function (campo) {
                    if (campo == 'data_ingresso' || campo == 'data_nascimento') {
                        dado = formatarData(2, item[campo]);
                    } else if (campo == 'nome' || campo == 'situacaoName' || campo == 'graduacaoName' || campo == 'unidadeName' || campo == 'quadroName' || campo == 'sexoBiologicoName' || campo == 'generoName' || campo == 'nome_guerra' || campo == 'prestandoServicoName' || campo == 'funcaoName' || campo == 'bancoName' || campo == 'pai' || campo == 'estadoCivilName' || campo == 'mae' || campo == 'comportamentoName' || campo == 'tipoSanguineoName' || campo == 'fatorRhName' || campo == 'nacionalidadeName' || campo == 'naturalidadeName' || campo == 'escolaridadeName') {
                        dado = primeiraMaiuscula(item[campo]);
                    } else if (campo == 'cpf') {
                        dado = formatarDocumento(1, item[campo]);
                    } else if (campo == 'pasep') {
                        dado = formatarDocumento(2, item[campo]);
                    } else {
                        dado = item[campo];
                    }

                    linha.push(dado);
                });

                dadosTableLinhas.push(linha);
            });

            // Gerar PDF
            gerarPdfTabela({
                p_header: true,
                p_topo_1: false,
                p_topo_2: true,
                p_nome: data.success['relatorio_nome'],
                p_parametros: true,
                p_parametros_texto: data.success['relatorio_parametros'],
                p_dadosTableCabecalho: dadosTableCabecalho,
                p_dadosTableLinhas: dadosTableLinhas,
                p_footer: true,
                p_data: data.success['relatorio_data'],
                p_hora: data.success['relatorio_hora']
            });

            // Retirar Processando...
            document.getElementById('modal_relatorio_12_footer_2').style.display = 'none';
            document.getElementById('modal_relatorio_12_footer_1').style.display = 'block';

            // Fechar Modal
            document.getElementById('modal_relatorio_12_cancelar').click();

        } catch (error) {
            console.error('Erro relatoriosRelatorio12 : ', error);

            alert('Erro ao gerar relatório.');

            // Retirar Processando...
            document.getElementById('modal_relatorio_12_footer_2').style.display = 'none';
            document.getElementById('modal_relatorio_12_footer_1').style.display = 'block';
        }
    }
}

function relatorio12SituacoesCheckboxesAlterarTodos(marcar = true) {
    document.querySelectorAll('input[name="modal_relatorio_12_situacoes_checkboxes"]').forEach(function (checkbox) {
        checkbox.checked = marcar;
    });
}

function relatorio12GraduacoesCheckboxesAlterarTodos(marcar = true) {
    document.querySelectorAll('input[name="modal_relatorio_12_graduacoes_checkboxes"]').forEach(function (checkbox) {
        checkbox.checked = marcar;
    });
}

function relatorio12UnidadesCheckboxesAlterarTodos(marcar = true) {
    document.querySelectorAll('input[name="modal_relatorio_12_unidades_checkboxes"]').forEach(function (checkbox) {
        checkbox.checked = marcar;
    });
}

function relatorio12QuadrosCheckboxesAlterarTodos(marcar = true) {
    document.querySelectorAll('input[name="modal_relatorio_12_quadros_checkboxes"]').forEach(function (checkbox) {
        checkbox.checked = marcar;
    });
}

function relatorio12ComportamentosCheckboxesAlterarTodos(marcar = true) {
    document.querySelectorAll('input[name="modal_relatorio_12_comportamentos_checkboxes"]').forEach(function (checkbox) {
        checkbox.checked = marcar;
    });
}

function pegarCheckboxesMarcados(name) {
    const valores = Array.from(document.querySelectorAll(`input[name="${name}"]:checked`)).map(checkbox => checkbox.value);

    return valores.length > 0 ? valores.join(',') : '0';
}

document.addEventListener("DOMContentLoaded", async function (event) {
    // Iniciar
    await dashTopo(2);

    // Relatório 12 - Marcar Todos
    relatorio12SituacoesCheckboxesAlterarTodos();
    relatorio12GraduacoesCheckboxesAlterarTodos();
    relatorio12UnidadesCheckboxesAlterarTodos();
    relatorio12QuadrosCheckboxesAlterarTodos();
    relatorio12ComportamentosCheckboxesAlterarTodos();
});
