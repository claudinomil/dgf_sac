async function dashTopo(op) {
    try {
        // Buscar Permissões de Gráficos
        const response = await fetch('dashboards/permissoes_graficos', {
            method: 'GET',
            headers: { 'REQUEST-ORIGIN': 'fetch' }
        });

        const data = await response.json();

        let graficos = [];

        if (data.success) { graficos = data.success; }

        // Elementos
        const dash_topo_titulo = document.getElementById('dash_topo_titulo');
        const dashboard_sistema = document.getElementById('dashboard_sistema');
        const dashboard_efetivo = document.getElementById('dashboard_efetivo');
        const dashboard_ressarcimento = document.getElementById('dashboard_ressarcimento');
        const container_grafico_1 = document.getElementById('container_grafico_1');
        const container_grafico_2 = document.getElementById('container_grafico_2');
        const container_grafico_3 = document.getElementById('container_grafico_3');
        const container_grafico_4 = document.getElementById('container_grafico_4');
        const container_grafico_5 = document.getElementById('container_grafico_5');
        const container_grafico_6 = document.getElementById('container_grafico_6');
        const container_grafico_7 = document.getElementById('container_grafico_7');
        const container_grafico_8 = document.getElementById('container_grafico_8');
        const container_grafico_9 = document.getElementById('container_grafico_9');
        const container_grafico_10 = document.getElementById('container_grafico_10');
        const container_grafico_11 = document.getElementById('container_grafico_11');
        const container_grafico_12 = document.getElementById('container_grafico_12');

        // Iniciando
        dash_topo_titulo.innerText = '';
        dashboard_sistema.style.display = 'none';
        dashboard_efetivo.style.display = 'none';
        dashboard_ressarcimento.style.display = 'none';
        container_grafico_1.style.display = 'none';
        container_grafico_2.style.display = 'none';
        container_grafico_3.style.display = 'none';
        container_grafico_4.style.display = 'none';
        container_grafico_5.style.display = 'none';
        container_grafico_6.style.display = 'none';
        container_grafico_7.style.display = 'none';
        container_grafico_8.style.display = 'none';
        container_grafico_9.style.display = 'none';
        container_grafico_10.style.display = 'none';
        container_grafico_11.style.display = 'none';
        container_grafico_12.style.display = 'none';

        // Dashboards Sistema
        if (op == 1) {
            dash_topo_titulo.innerText = 'Sistema';
            dashboard_sistema.style.display = '';

            await sistemaTotais();

            if (graficos.includes(1)) {
                container_grafico_1.style.display = '';
                await dashboardSistemaGrafico1();
            }

            if (graficos.includes(2)) {
                container_grafico_2.style.display = '';
                await dashboardSistemaGrafico2();
            }

            if (graficos.includes(3)) {
                container_grafico_3.style.display = '';
                await dashboardSistemaGrafico3();
            }
        }

        // Dashboards Efetivo
        if (op == 2) {
            dash_topo_titulo.innerText = 'Efetivo';
            dashboard_efetivo.style.display = '';

            await efetivoTotais();

            if (graficos.includes(4)) {
                container_grafico_4.style.display = '';
                await dashboardEfetivoGrafico1();
            }

            if (graficos.includes(5)) {
                container_grafico_5.style.display = '';
                await dashboardEfetivoGrafico2();
            }

            if (graficos.includes(6)) {
                container_grafico_6.style.display = '';
                await dashboardEfetivoGrafico3();
            }

            if (graficos.includes(7)) {
                container_grafico_7.style.display = '';
                await dashboardEfetivoGrafico4();
            }
        }

        // Dashboards Ressarcimento
        if (op == 3) {
            dash_topo_titulo.innerText = 'Ressarcimento';
            dashboard_ressarcimento.style.display = '';

            await ressarcimentoTotais();

            if (graficos.includes(8)) {
                container_grafico_8.style.display = '';
                await dashboardEfetivoGrafico8();
            }

            if (graficos.includes(9)) {
                container_grafico_9.style.display = '';
                await dashboardEfetivoGrafico9();
            }

            if (graficos.includes(10)) {
                container_grafico_10.style.display = '';
                await dashboardEfetivoGrafico10();
            }

            if (graficos.includes(11)) {
                container_grafico_11.style.display = '';
                await dashboardEfetivoGrafico11();
            }

            if (graficos.includes(12)) {
                container_grafico_12.style.display = '';
                await dashboardEfetivoGrafico12();
            }
        }
    } catch (error) {
        alert('Erro dashTopo: ' + error);
    }
}

async function sistemaTotais() {
    // Elementos
    const dashboard_sistema_usuarios_total_geral = document.getElementById('dashboard_sistema_usuarios_total_geral');
    const dashboard_sistema_usuarios_total_liberados = document.getElementById('dashboard_sistema_usuarios_total_liberados');
    const dashboard_sistema_usuarios_total_bloqueados = document.getElementById('dashboard_sistema_usuarios_total_bloqueados');
    const dashboard_sistema_usuarios_total_militares = document.getElementById('dashboard_sistema_usuarios_total_militares');
    const dashboard_sistema_usuarios_total_civis = document.getElementById('dashboard_sistema_usuarios_total_civis');
    const dashboard_sistema_grupos_total_geral = document.getElementById('dashboard_sistema_grupos_total_geral');
    const dashboard_sistema_transacoes_total_geral = document.getElementById('dashboard_sistema_transacoes_total_geral');

    // Iniciando
    dashboard_sistema_usuarios_total_geral.innerText = 0;
    dashboard_sistema_usuarios_total_liberados.innerText = 0;
    dashboard_sistema_usuarios_total_bloqueados.innerText = 0;
    dashboard_sistema_usuarios_total_militares.innerText = 0;
    dashboard_sistema_usuarios_total_civis.innerText = 0;
    dashboard_sistema_grupos_total_geral.innerText = 0;
    dashboard_sistema_transacoes_total_geral.innerText = 0;

    // Buscar Dados
    try {
        const response = await fetch('dashboards/sistema_totais', {
            method: 'GET',
            headers: { 'REQUEST-ORIGIN': 'fetch' }
        });

        const data = await response.json();

        if (data.success) {
            const totais = data.success;

            dashboard_sistema_usuarios_total_geral.innerText = totais.usuarios_total_geral;
            dashboard_sistema_usuarios_total_liberados.innerText = totais.usuarios_total_liberados;
            dashboard_sistema_usuarios_total_bloqueados.innerText = totais.usuarios_total_bloqueados;
            dashboard_sistema_usuarios_total_militares.innerText = totais.usuarios_total_militares;
            dashboard_sistema_usuarios_total_civis.innerText = totais.usuarios_total_civis;
            dashboard_sistema_grupos_total_geral.innerText = totais.grupos_total_geral;
            dashboard_sistema_transacoes_total_geral.innerText = totais.transacoes_total_geral;
        }
    } catch (error) {
        alert('Erro sistemaTotais: ' + error);
    }
}

// Grafico 1 : Usuários Grupos
async function dashboardSistemaGrafico1() {
    // Global
    const graficoData = {
        usuarios_quantidade: 0,
        usuarios_grupos: []
    };

    const response = await fetch('dashboards/grafico_1', {
        method: 'GET',
        headers: { 'REQUEST-ORIGIN': 'fetch' }
    });

    const dados = await response.json();

    // Atualiza apenas os campos existentes
    for (const key in graficoData) {
        if (Object.hasOwn(dados, key)) {
            graficoData[key] = dados[key];
        }
    }

    // Dados Gráfico
    const dados_grafico = Array.isArray(graficoData.usuarios_grupos) ? graficoData.usuarios_grupos.map(item => ({
        name: primeiraMaiuscula(item.name),
        value: Number(item.quantidade) || 0
    })) : [];

    await chartPieSimple({ divId: 'div_grafico_1', titleText: 'Usuários Grupos', titleSubText: graficoData.usuarios_quantidade + ' Registros', dados: dados_grafico });
}

// Grafico 2 : Transações Operações
async function dashboardSistemaGrafico2() {
    // Global
    const graficoData = {
        transacoes_quantidade: 0,
        transacoes_operacoes: []
    };

    const response = await fetch('dashboards/grafico_2', {
        method: 'GET',
        headers: { 'REQUEST-ORIGIN': 'fetch' }
    });

    const dados = await response.json();

    // Atualiza apenas os campos existentes
    for (const key in graficoData) {
        if (Object.hasOwn(dados, key)) {
            graficoData[key] = dados[key];
        }
    }

    // Dados Gráfico
    const dados_grafico = Array.isArray(graficoData.transacoes_operacoes) ? graficoData.transacoes_operacoes.map(item => ({
        name: primeiraMaiuscula(item.name),
        value: Number(item.quantidade) || 0
    })) : [];

    await chartBarSimple({ divId: 'div_grafico_2', titleText: 'Transações Operações', titleSubText: graficoData.transacoes_quantidade + ' Registros', dados: dados_grafico });
}

// Grafico 3 : Transações Submódulos
async function dashboardSistemaGrafico3() {
    // Global
    const graficoData = {
        transacoes_quantidade: 0,
        transacoes_submodulos: []
    };

    const response = await fetch('dashboards/grafico_3', {
        method: 'GET',
        headers: { 'REQUEST-ORIGIN': 'fetch' }
    });

    const dados = await response.json();

    // Atualiza apenas os campos existentes
    for (const key in graficoData) {
        if (Object.hasOwn(dados, key)) {
            graficoData[key] = dados[key];
        }
    }

    // Dados Gráfico
    const dados_grafico = Array.isArray(graficoData.transacoes_submodulos) ? graficoData.transacoes_submodulos.map(item => ({
        name: primeiraMaiuscula(item.name),
        value: Number(item.quantidade) || 0
    })) : [];

    await chartPieSimple({ divId: 'div_grafico_3', titleText: 'Transações Submódulos', titleSubText: graficoData.transacoes_quantidade + ' Registros', dados: dados_grafico });
}

async function efetivoTotais() {
    // Elementos
    const dashboard_efetivo_militares_total_ativos = document.getElementById('dashboard_efetivo_militares_total_ativos');
    const dashboard_sistema_militares_total_oficiais_ativos = document.getElementById('dashboard_sistema_militares_total_oficiais_ativos');
    const dashboard_sistema_militares_total_aspirantes = document.getElementById('dashboard_sistema_militares_total_aspirantes');
    const dashboard_sistema_militares_total_alunos_cfo = document.getElementById('dashboard_sistema_militares_total_alunos_cfo');
    const dashboard_sistema_militares_total_pracas_ativos = document.getElementById('dashboard_sistema_militares_total_pracas_ativos');

    // Iniciando
    dashboard_efetivo_militares_total_ativos.innerText = 0;
    dashboard_sistema_militares_total_oficiais_ativos.innerText = 0;
    dashboard_sistema_militares_total_aspirantes.innerText = 0;
    dashboard_sistema_militares_total_alunos_cfo.innerText = 0;
    dashboard_sistema_militares_total_pracas_ativos.innerText = 0;

    // Buscar Dados
    try {
        const response = await fetch('dashboards/efetivo_totais', {
            method: 'GET',
            headers: { 'REQUEST-ORIGIN': 'fetch' }
        });

        const data = await response.json();

        if (data.success) {
            const totais = data.success;

            dashboard_efetivo_militares_total_ativos.innerText = totais.militares_total_ativos;
            dashboard_sistema_militares_total_oficiais_ativos.innerText = totais.militares_total_oficiais_ativos;
            dashboard_sistema_militares_total_aspirantes.innerText = totais.militares_total_aspirantes;
            dashboard_sistema_militares_total_alunos_cfo.innerText = totais.militares_total_alunos_cfo;
            dashboard_sistema_militares_total_pracas_ativos.innerText = totais.militares_total_pracas_ativos;
        }
    } catch (error) {
        alert('Erro efetivoTotais: ' + error);
    }
}

// Grafico 4 : Situações
async function dashboardEfetivoGrafico1() {
    // Global
    const graficoData = {
        militares_quantidade: 0,
        militares_situacoes: []
    };

    const response = await fetch('dashboards/grafico_4', {
        method: 'GET',
        headers: { 'REQUEST-ORIGIN': 'fetch' }
    });

    const dados = await response.json();

    // Atualiza apenas os campos existentes
    for (const key in graficoData) {
        if (Object.hasOwn(dados, key)) {
            graficoData[key] = dados[key];
        }
    }

    // Quantidades recebidas
    let qtd_recebidas = 0;
    graficoData.militares_situacoes.forEach(function (dado) {
        qtd_recebidas += dado.quantidade;
    });

    // Dados Gráfico
    const dados_grafico = Array.isArray(graficoData.militares_situacoes) ? graficoData.militares_situacoes.map(item => ({
        name: primeiraMaiuscula(item.name),
        value: Number(item.quantidade) || 0
    })) : [];

    await chartPieSimple({ divId: 'div_grafico_4', titleText: 'Situações', titleSubText: graficoData.militares_quantidade + ' Militares Ativos' + '\n' + qtd_recebidas + ' Militares com Situação', dados: dados_grafico });
}

// Grafico 5 : Quadros
async function dashboardEfetivoGrafico2() {
    // Fechar Modal
    document.getElementById('modal_grafico_5_fechar').click();

    // Militares Selecionados
    const militares_selecionados = document.querySelector('input[name="modal_grafico_5_militares"]:checked')?.value || 1;

    // Quadros Marcados
    const quadros_selecionados = Array.from(document.querySelectorAll('input[type="checkbox"][name^="modal_grafico_5_quadro_"]:checked')).map(item => item.value);

    // String separada por virgula
    const quadros_selecionados_string = quadros_selecionados.join(',');

    // URL PARAMS
    const params = new URLSearchParams({
        militares_selecionados: militares_selecionados,
        quadros_selecionados: quadros_selecionados_string
    });

    // Global
    const graficoData = {
        militares_quantidade: 0,
        militares_quadros: []
    };

    const response = await fetch('dashboards/grafico_5?' + params.toString(),
        {
            method: 'GET',
            headers: { 'REQUEST-ORIGIN': 'fetch' }
        }
    );

    const dados = await response.json();

    // Atualiza apenas os campos existentes
    for (const key in graficoData) {
        if (Object.hasOwn(dados, key)) {
            graficoData[key] = dados[key];
        }
    }

    // Quantidades recebidas
    let qtd_recebidas = 0;
    graficoData.militares_quadros.forEach(function (dado) {
        qtd_recebidas += dado.quantidade;
    });

    // Txt Recebidas
    let txt_recebidas = '';
    if (militares_selecionados == 2) { txt_recebidas = ' Militares com Quadros Selecionados'; }
    if (militares_selecionados == 3) { txt_recebidas = ' Militares Oficiais com Quadros Selecionados'; }
    if (militares_selecionados == 6) { txt_recebidas = ' Militares Praças com Quadros Selecionados'; }

    // Dados Gráfico
    const dados_grafico = Array.isArray(graficoData.militares_quadros) ? graficoData.militares_quadros.map(item => ({
        name: primeiraMaiuscula(item.name),
        value: Number(item.quantidade) || 0
    })) : [];

    await chartPieSimple({ divId: 'div_grafico_5', titleText: 'Quadros', titleSubText: graficoData.militares_quantidade + ' Militares Ativos' + '\n' + qtd_recebidas + txt_recebidas, dados: dados_grafico, modalFiltroId: 'modal_grafico_5' });
}

// Grafico 6 : Graduações
async function dashboardEfetivoGrafico3() {
    // Fechar Modal
    document.getElementById('modal_grafico_6_fechar').click();

    // Militares Selecionados
    const militares_selecionados = document.querySelector('input[name="modal_grafico_6_militares"]:checked')?.value || 1;

    // Graduações Marcadas
    const graduacoes_selecionadas = Array.from(document.querySelectorAll('input[type="checkbox"][name^="modal_grafico_6_graduacao_"]:checked')).map(item => item.value);

    // String separada por virgula
    const graduacoes_selecionadas_string = graduacoes_selecionadas.join(',');

    // URL PARAMS
    const params = new URLSearchParams({
        militares_selecionados: militares_selecionados,
        graduacoes_selecionadas: graduacoes_selecionadas_string
    });

    // Global
    const graficoData = {
        militares_quantidade: 0,
        militares_graduacoes: []
    };

    const response = await fetch('dashboards/grafico_6?' + params.toString(), {
        method: 'GET',
        headers: { 'REQUEST-ORIGIN': 'fetch' }
    });

    const dados = await response.json();

    // Atualiza apenas os campos existentes
    for (const key in graficoData) {
        if (Object.hasOwn(dados, key)) {
            graficoData[key] = dados[key];
        }
    }

    // Quantidades recebidas
    let qtd_recebidas = 0;
    graficoData.militares_graduacoes.forEach(function (dado) {
        qtd_recebidas += dado.quantidade;
    });

    // Txt Recebidas
    let txt_recebidas = '';
    if (militares_selecionados == 2) { txt_recebidas = ' Militares com Graduações Selecionadas'; }
    if (militares_selecionados == 3) { txt_recebidas = ' Militares Oficiais com Graduações Selecionadas'; }
    if (militares_selecionados == 6) { txt_recebidas = ' Militares Praças com Graduações Selecionadas'; }

    // Dados Gráfico
    const dados_grafico = Array.isArray(graficoData.militares_graduacoes) ? graficoData.militares_graduacoes.map(item => ({
        name: primeiraMaiuscula(item.name),
        value: Number(item.quantidade) || 0
    })) : [];

    await chartPieSimple({ divId: 'div_grafico_6', titleText: 'Graduações', titleSubText: graficoData.militares_quantidade + ' Militares Ativos' + '\n' + qtd_recebidas + txt_recebidas, dados: dados_grafico, modalFiltroId: 'modal_grafico_6' });
}

// Grafico 7 : Comportamentos
async function dashboardEfetivoGrafico4() {
    // Global
    const graficoData = {
        militares_quantidade: 0,
        militares_comportamentos: []
    };

    const response = await fetch('dashboards/grafico_7', {
        method: 'GET',
        headers: { 'REQUEST-ORIGIN': 'fetch' }
    });

    const dados = await response.json();

    // Atualiza apenas os campos existentes
    for (const key in graficoData) {
        if (Object.hasOwn(dados, key)) {
            graficoData[key] = dados[key];
        }
    }

    // Quantidades recebidas
    let qtd_recebidas = 0;
    graficoData.militares_comportamentos.forEach(function (dado) {
        qtd_recebidas += dado.quantidade;
    });

    // Dados Gráfico
    const dados_grafico = Array.isArray(graficoData.militares_comportamentos) ? graficoData.militares_comportamentos.map(item => ({
        name: primeiraMaiuscula(item.name),
        value: Number(item.quantidade) || 0
    })) : [];

    await chartPieSimple({ divId: 'div_grafico_7', titleText: 'Comportamentos', titleSubText: graficoData.militares_quantidade + ' Militares Ativos' + '\n' + qtd_recebidas + ' Militares com Comportamento', dados: dados_grafico });
}

async function ressarcimentoTotais() {
    // Elementos
    const dashboard_efetivo_militares_total_ativos = document.getElementById('dashboard_efetivo_militares_total_ativos');
    const dashboard_sistema_militares_total_oficiais_ativos = document.getElementById('dashboard_sistema_militares_total_oficiais_ativos');
    const dashboard_sistema_militares_total_aspirantes = document.getElementById('dashboard_sistema_militares_total_aspirantes');
    const dashboard_sistema_militares_total_alunos_cfo = document.getElementById('dashboard_sistema_militares_total_alunos_cfo');
    const dashboard_sistema_militares_total_pracas_ativos = document.getElementById('dashboard_sistema_militares_total_pracas_ativos');

    // Iniciando
    dashboard_efetivo_militares_total_ativos.innerText = 0;
    dashboard_sistema_militares_total_oficiais_ativos.innerText = 0;
    dashboard_sistema_militares_total_aspirantes.innerText = 0;
    dashboard_sistema_militares_total_alunos_cfo.innerText = 0;
    dashboard_sistema_militares_total_pracas_ativos.innerText = 0;

    // Buscar Dados
    try {
        const response = await fetch('dashboards/ressarcimento_totais', {
            method: 'GET',
            headers: { 'REQUEST-ORIGIN': 'fetch' }
        });

        const data = await response.json();

        if (data.success) {
            const totais = data.success;

            dashboard_efetivo_militares_total_ativos.innerText = totais.militares_total_ativos;
            dashboard_sistema_militares_total_oficiais_ativos.innerText = totais.militares_total_oficiais_ativos;
            dashboard_sistema_militares_total_aspirantes.innerText = totais.militares_total_aspirantes;
            dashboard_sistema_militares_total_alunos_cfo.innerText = totais.militares_total_alunos_cfo;
            dashboard_sistema_militares_total_pracas_ativos.innerText = totais.militares_total_pracas_ativos;
        }
    } catch (error) {
        alert('Erro ressarcimentoTotais: ' + error);
    }
}

// Grafico 8 : QUANTIDADE DE MILITARES: OFICIAIS/PRAÇAS
async function dashboardEfetivoGrafico8() {
    // Global
    const graficoData = {
        militares_quantidade: 0,
        militares_situacoes: []
    };

    // URL PARAMS
    const periodo_1 = document.getElementById('modal_grafico_8_periodo_1');
    const periodo_2 = document.getElementById('modal_grafico_8_periodo_2');
    const orgao_id = document.getElementById('modal_grafico_8_orgao_id');

    // Validação
    if (periodo_1.value == '' || periodo_2.value == '' || orgao_id.value == '' || orgao_id.value == 0) {
        alert('Escolha o período e o Órgão.');

        return;
    }

    // Fetch
    const response = await fetch(`dashboards/grafico_8/${periodo_1.value}/${periodo_2.value}/${orgao_id.value}`, {
        method: 'GET',
        headers: { 'REQUEST-ORIGIN': 'fetch' }
    });

    const dados = await response.json();

    // Atualiza apenas os campos existentes
    for (const key in graficoData) {
        if (Object.hasOwn(dados, key)) {
            graficoData[key] = dados[key];
        }
    }

    // Quantidades recebidas
    let qtd_recebidas = 0;
    graficoData.militares_situacoes.forEach(function (dado) {
        qtd_recebidas += dado.quantidade;
    });

    // Dados Gráfico
    const dados_grafico = Array.isArray(graficoData.militares_situacoes) ? graficoData.militares_situacoes.map(item => ({
        name: primeiraMaiuscula(item.name),
        value: Number(item.quantidade) || 0
    })) : [];

    await chartPieSimple({ divId: 'div_grafico_8', titleText: 'Situações', titleSubText: graficoData.militares_quantidade + ' Militares Ativos' + '\n' + qtd_recebidas + ' Militares com Situação', dados: dados_grafico, modalFiltroId: 'modal_grafico_8' });
}

// Grafico 9 : VALORES DEVIDOS E PAGOS PELOS ÓRGÃOS
async function dashboardEfetivoGrafico9() {
    // Global
    const graficoData = {
        militares_quantidade: 0,
        militares_situacoes: []
    };

    // URL PARAMS
    const periodo_1 = document.getElementById('modal_grafico_9_periodo_1');
    const periodo_2 = document.getElementById('modal_grafico_9_periodo_2');
    const orgao_id = document.getElementById('modal_grafico_9_orgao_id');

    // Validação
    if (periodo_1.value == '' || periodo_2.value == '' || orgao_id.value == '' || orgao_id.value == 0) {
        alert('Escolha o período e o Órgão.');

        return;
    }

    // Fetch
    const response = await fetch(`dashboards/grafico_9/${periodo_1.value}/${periodo_2.value}/${orgao_id.value}`, {
        method: 'GET',
        headers: { 'REQUEST-ORIGIN': 'fetch' }
    });

    const dados = await response.json();

    // Atualiza apenas os campos existentes
    for (const key in graficoData) {
        if (Object.hasOwn(dados, key)) {
            graficoData[key] = dados[key];
        }
    }

    // Quantidades recebidas
    let qtd_recebidas = 0;
    graficoData.militares_situacoes.forEach(function (dado) {
        qtd_recebidas += dado.quantidade;
    });

    // Dados Gráfico
    const dados_grafico = Array.isArray(graficoData.militares_situacoes) ? graficoData.militares_situacoes.map(item => ({
        name: primeiraMaiuscula(item.name),
        value: Number(item.quantidade) || 0
    })) : [];

    await chartPieSimple({ divId: 'div_grafico_9', titleText: 'Situações', titleSubText: graficoData.militares_quantidade + ' Militares Ativos' + '\n' + qtd_recebidas + ' Militares com Situação', dados: dados_grafico, modalFiltroId: 'modal_grafico_9' });
}

// Grafico 10 : NÚMERO DE ÓRGÃOS POR ESFERA
async function dashboardEfetivoGrafico10() {
    // Global
    const graficoData = {
        militares_quantidade: 0,
        militares_situacoes: []
    };

    // URL PARAMS
    const periodo_1 = document.getElementById('modal_grafico_10_periodo_1');
    const periodo_2 = document.getElementById('modal_grafico_10_periodo_2');
    const orgao_id = document.getElementById('modal_grafico_10_orgao_id');

    // Validação
    if (periodo_1.value == '' || periodo_2.value == '' || orgao_id.value == '' || orgao_id.value == 0) {
        alert('Escolha o período e o Órgão.');

        return;
    }

    // Fetch
    const response = await fetch(`dashboards/grafico_10/${periodo_1.value}/${periodo_2.value}/${orgao_id.value}`, {
        method: 'GET',
        headers: { 'REQUEST-ORIGIN': 'fetch' }
    });

    const dados = await response.json();

    // Atualiza apenas os campos existentes
    for (const key in graficoData) {
        if (Object.hasOwn(dados, key)) {
            graficoData[key] = dados[key];
        }
    }

    // Quantidades recebidas
    let qtd_recebidas = 0;
    graficoData.militares_situacoes.forEach(function (dado) {
        qtd_recebidas += dado.quantidade;
    });

    // Dados Gráfico
    const dados_grafico = Array.isArray(graficoData.militares_situacoes) ? graficoData.militares_situacoes.map(item => ({
        name: primeiraMaiuscula(item.name),
        value: Number(item.quantidade) || 0
    })) : [];

    await chartPieSimple({ divId: 'div_grafico_10', titleText: 'Situações', titleSubText: graficoData.militares_quantidade + ' Militares Ativos' + '\n' + qtd_recebidas + ' Militares com Situação', dados: dados_grafico, modalFiltroId: 'modal_grafico_10' });
}

// Grafico 11 : NÚMERO DE ÓRGÃOS POR PODER
async function dashboardEfetivoGrafico11() {
    // Global
    const graficoData = {
        militares_quantidade: 0,
        militares_situacoes: []
    };

    // URL PARAMS
    const periodo_1 = document.getElementById('modal_grafico_11_periodo_1');
    const periodo_2 = document.getElementById('modal_grafico_11_periodo_2');
    const orgao_id = document.getElementById('modal_grafico_11_orgao_id');

    // Validação
    if (periodo_1.value == '' || periodo_2.value == '' || orgao_id.value == '' || orgao_id.value == 0) {
        alert('Escolha o período e o Órgão.');

        return;
    }

    // Fetch
    const response = await fetch(`dashboards/grafico_11/${periodo_1.value}/${periodo_2.value}/${orgao_id.value}`, {
        method: 'GET',
        headers: { 'REQUEST-ORIGIN': 'fetch' }
    });

    const dados = await response.json();

    // Atualiza apenas os campos existentes
    for (const key in graficoData) {
        if (Object.hasOwn(dados, key)) {
            graficoData[key] = dados[key];
        }
    }

    // Quantidades recebidas
    let qtd_recebidas = 0;
    graficoData.militares_situacoes.forEach(function (dado) {
        qtd_recebidas += dado.quantidade;
    });

    // Dados Gráfico
    const dados_grafico = Array.isArray(graficoData.militares_situacoes) ? graficoData.militares_situacoes.map(item => ({
        name: primeiraMaiuscula(item.name),
        value: Number(item.quantidade) || 0
    })) : [];

    await chartPieSimple({ divId: 'div_grafico_11', titleText: 'Situações', titleSubText: graficoData.militares_quantidade + ' Militares Ativos' + '\n' + qtd_recebidas + ' Militares com Situação', dados: dados_grafico, modalFiltroId: 'modal_grafico_11' });
}

// Grafico 12 : VALORES DEVIDOS E PAGOS POR ÓRGÃOS MENSALMENTE
async function dashboardEfetivoGrafico12() {
    // Global
    const graficoData = {
        militares_quantidade: 0,
        militares_situacoes: []
    };

    // URL PARAMS
    const periodo_1 = document.getElementById('modal_grafico_12_periodo_1');
    const periodo_2 = document.getElementById('modal_grafico_12_periodo_2');
    const orgao_id = document.getElementById('modal_grafico_12_orgao_id');

    // Validação
    if (periodo_1.value == '' || periodo_2.value == '' || orgao_id.value == '' || orgao_id.value == 0) {
        alert('Escolha o período e o Órgão.');

        return;
    }

    // Fetch
    const response = await fetch(`dashboards/grafico_12/${periodo_1.value}/${periodo_2.value}/${orgao_id.value}`, {
        method: 'GET',
        headers: { 'REQUEST-ORIGIN': 'fetch' }
    });

    const dados = await response.json();

    // Atualiza apenas os campos existentes
    for (const key in graficoData) {
        if (Object.hasOwn(dados, key)) {
            graficoData[key] = dados[key];
        }
    }

    // Quantidades recebidas
    let qtd_recebidas = 0;
    graficoData.militares_situacoes.forEach(function (dado) {
        qtd_recebidas += dado.quantidade;
    });

    // Dados Gráfico
    const dados_grafico = Array.isArray(graficoData.militares_situacoes) ? graficoData.militares_situacoes.map(item => ({
        name: primeiraMaiuscula(item.name),
        value: Number(item.quantidade) || 0
    })) : [];

    await chartPieSimple({ divId: 'div_grafico_12', titleText: 'Situações', titleSubText: graficoData.militares_quantidade + ' Militares Ativos' + '\n' + qtd_recebidas + ' Militares com Situação', dados: dados_grafico, modalFiltroId: 'modal_grafico_12' });
}

async function balancetesTotais() {
    // Elementos
    const dashboard_efetivo_militares_total_ativos = document.getElementById('dashboard_efetivo_militares_total_ativos');
    const dashboard_sistema_militares_total_oficiais_ativos = document.getElementById('dashboard_sistema_militares_total_oficiais_ativos');
    const dashboard_sistema_militares_total_aspirantes = document.getElementById('dashboard_sistema_militares_total_aspirantes');
    const dashboard_sistema_militares_total_alunos_cfo = document.getElementById('dashboard_sistema_militares_total_alunos_cfo');
    const dashboard_sistema_militares_total_pracas_ativos = document.getElementById('dashboard_sistema_militares_total_pracas_ativos');

    // Iniciando
    dashboard_efetivo_militares_total_ativos.innerText = 0;
    dashboard_sistema_militares_total_oficiais_ativos.innerText = 0;
    dashboard_sistema_militares_total_aspirantes.innerText = 0;
    dashboard_sistema_militares_total_alunos_cfo.innerText = 0;
    dashboard_sistema_militares_total_pracas_ativos.innerText = 0;

    // Buscar Dados
    try {
        const response = await fetch('dashboards/ressarcimento_totais', {
            method: 'GET',
            headers: { 'REQUEST-ORIGIN': 'fetch' }
        });

        const data = await response.json();

        if (data.success) {
            const totais = data.success;

            dashboard_efetivo_militares_total_ativos.innerText = totais.militares_total_ativos;
            dashboard_sistema_militares_total_oficiais_ativos.innerText = totais.militares_total_oficiais_ativos;
            dashboard_sistema_militares_total_aspirantes.innerText = totais.militares_total_aspirantes;
            dashboard_sistema_militares_total_alunos_cfo.innerText = totais.militares_total_alunos_cfo;
            dashboard_sistema_militares_total_pracas_ativos.innerText = totais.militares_total_pracas_ativos;
        }
    } catch (error) {
        alert('Erro balancetesTotais: ' + error);
    }
}

// Grafico 13 : REPASSES
async function dashboardEfetivoGrafico13() {
    // Global
    const graficoData = {
        militares_quantidade: 0,
        militares_situacoes: []
    };

    const response = await fetch('dashboards/grafico_13', {
        method: 'GET',
        headers: { 'REQUEST-ORIGIN': 'fetch' }
    });

    const dados = await response.json();

    // Atualiza apenas os campos existentes
    for (const key in graficoData) {
        if (Object.hasOwn(dados, key)) {
            graficoData[key] = dados[key];
        }
    }

    // Quantidades recebidas
    let qtd_recebidas = 0;
    graficoData.militares_situacoes.forEach(function (dado) {
        qtd_recebidas += dado.quantidade;
    });

    // Dados Gráfico
    const dados_grafico = Array.isArray(graficoData.militares_situacoes) ? graficoData.militares_situacoes.map(item => ({
        name: primeiraMaiuscula(item.name),
        value: Number(item.quantidade) || 0
    })) : [];

    await chartPieSimple({ divId: 'div_grafico_13', titleText: 'Situações', titleSubText: graficoData.militares_quantidade + ' Militares Ativos' + '\n' + qtd_recebidas + ' Militares com Situação', dados: dados_grafico });
}

// Grafico 14 : DESPESAS
async function dashboardEfetivoGrafico14() {
    // Global
    const graficoData = {
        militares_quantidade: 0,
        militares_situacoes: []
    };

    const response = await fetch('dashboards/grafico_14', {
        method: 'GET',
        headers: { 'REQUEST-ORIGIN': 'fetch' }
    });

    const dados = await response.json();

    // Atualiza apenas os campos existentes
    for (const key in graficoData) {
        if (Object.hasOwn(dados, key)) {
            graficoData[key] = dados[key];
        }
    }

    // Quantidades recebidas
    let qtd_recebidas = 0;
    graficoData.militares_situacoes.forEach(function (dado) {
        qtd_recebidas += dado.quantidade;
    });

    // Dados Gráfico
    const dados_grafico = Array.isArray(graficoData.militares_situacoes) ? graficoData.militares_situacoes.map(item => ({
        name: primeiraMaiuscula(item.name),
        value: Number(item.quantidade) || 0
    })) : [];

    await chartPieSimple({ divId: 'div_grafico_14', titleText: 'Situações', titleSubText: graficoData.militares_quantidade + ' Militares Ativos' + '\n' + qtd_recebidas + ' Militares com Situação', dados: dados_grafico });
}

// Grafico 15 : TRANSFERÊNCIAS REALIZADAS
async function dashboardEfetivoGrafico15() {
    // Global
    const graficoData = {
        militares_quantidade: 0,
        militares_situacoes: []
    };

    const response = await fetch('dashboards/grafico_15', {
        method: 'GET',
        headers: { 'REQUEST-ORIGIN': 'fetch' }
    });

    const dados = await response.json();

    // Atualiza apenas os campos existentes
    for (const key in graficoData) {
        if (Object.hasOwn(dados, key)) {
            graficoData[key] = dados[key];
        }
    }

    // Quantidades recebidas
    let qtd_recebidas = 0;
    graficoData.militares_situacoes.forEach(function (dado) {
        qtd_recebidas += dado.quantidade;
    });

    // Dados Gráfico
    const dados_grafico = Array.isArray(graficoData.militares_situacoes) ? graficoData.militares_situacoes.map(item => ({
        name: primeiraMaiuscula(item.name),
        value: Number(item.quantidade) || 0
    })) : [];

    await chartPieSimple({ divId: 'div_grafico_15', titleText: 'Situações', titleSubText: graficoData.militares_quantidade + ' Militares Ativos' + '\n' + qtd_recebidas + ' Militares com Situação', dados: dados_grafico });
}

// Grafico 16 : TRANSFERÊNCIAS RECEBIDAS
async function dashboardEfetivoGrafico16() {
    // Global
    const graficoData = {
        militares_quantidade: 0,
        militares_situacoes: []
    };

    const response = await fetch('dashboards/grafico_16', {
        method: 'GET',
        headers: { 'REQUEST-ORIGIN': 'fetch' }
    });

    const dados = await response.json();

    // Atualiza apenas os campos existentes
    for (const key in graficoData) {
        if (Object.hasOwn(dados, key)) {
            graficoData[key] = dados[key];
        }
    }

    // Quantidades recebidas
    let qtd_recebidas = 0;
    graficoData.militares_situacoes.forEach(function (dado) {
        qtd_recebidas += dado.quantidade;
    });

    // Dados Gráfico
    const dados_grafico = Array.isArray(graficoData.militares_situacoes) ? graficoData.militares_situacoes.map(item => ({
        name: primeiraMaiuscula(item.name),
        value: Number(item.quantidade) || 0
    })) : [];

    await chartPieSimple({ divId: 'div_grafico_16', titleText: 'Situações', titleSubText: graficoData.militares_quantidade + ' Militares Ativos' + '\n' + qtd_recebidas + ' Militares com Situação', dados: dados_grafico });
}

// Grafico 17 : RESULTADO DO PERÍODO
async function dashboardEfetivoGrafico17() {
    // Global
    const graficoData = {
        militares_quantidade: 0,
        militares_situacoes: []
    };

    const response = await fetch('dashboards/grafico_17', {
        method: 'GET',
        headers: { 'REQUEST-ORIGIN': 'fetch' }
    });

    const dados = await response.json();

    // Atualiza apenas os campos existentes
    for (const key in graficoData) {
        if (Object.hasOwn(dados, key)) {
            graficoData[key] = dados[key];
        }
    }

    // Quantidades recebidas
    let qtd_recebidas = 0;
    graficoData.militares_situacoes.forEach(function (dado) {
        qtd_recebidas += dado.quantidade;
    });

    // Dados Gráfico
    const dados_grafico = Array.isArray(graficoData.militares_situacoes) ? graficoData.militares_situacoes.map(item => ({
        name: primeiraMaiuscula(item.name),
        value: Number(item.quantidade) || 0
    })) : [];

    await chartPieSimple({ divId: 'div_grafico_17', titleText: 'Situações', titleSubText: graficoData.militares_quantidade + ' Militares Ativos' + '\n' + qtd_recebidas + ' Militares com Situação', dados: dados_grafico });
}

document.addEventListener("DOMContentLoaded", async function (event) {
    await dashTopo(2);
});
