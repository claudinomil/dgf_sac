// Globais
const dashboard_indicadores_container = document.getElementById('dashboard_indicadores_container');
const dashboard_graficos_container = document.getElementById('dashboard_graficos_container');
let rota_dashboards_tvs_indicadores_ultimo_retorno = null;

// Ajustar Tela - Início'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
// Ajustar Tela - Início'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
let altura = window.innerHeight;
let largura = window.innerWidth;

function ajustarDashboard() {
    altura = window.innerHeight;
    largura = window.innerWidth;

    document.getElementById('dashboard').style.height = `${altura}px`;
}

window.addEventListener('resize', ajustarDashboard);
// Ajustar Tela - Fim''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
// Ajustar Tela - Fim''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

// Indicadores - Início''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
// Indicadores - Início''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

// Retorna um indicador com Legenda e Valor
function indicador_totais({ legenda = null, valor = null, colunas = 2, imagem = 'fa fa-star', imagem_cor = 'text-success' }) {
    if (legenda === null || valor === null) { return; }

    let indicador = '';

    // Tela Redimencionamentos
    if (window.matchMedia('(max-width: 575.98px)').matches) {
        // MOBILE - Até 575px

        // Class
        classLegenda = 'font-size-10';
        classValor = 'font-size-16';
        classImagem = 'font-size-20';
    } else if (window.matchMedia('(min-width: 576px) and (max-width: 991.98px)').matches) {
        // TABLET - 576px até 991px

        // Class
        classLegenda = 'font-size-12';
        classValor = 'font-size-18';
        classImagem = 'font-size-20';
    } else if (window.matchMedia('(min-width: 992px) and (max-width: 1599.98px)').matches) {
        // NOTEBOOK / DESKTOP - 992px até 1599px

        // Class
        classLegenda = 'font-size-14';
        classValor = 'font-size-20';
        classImagem = 'font-size-20';
    } else if (window.matchMedia('(min-width: 1600px) and (max-width: 2559.98px)').matches) {
        // TV / TELAS GRANDES - 1600px até 2559px

        // Class
        classLegenda = 'font-size-16';
        classValor = 'font-size-22';
        classImagem = 'font-size-30';
    } else if (window.matchMedia('(min-width: 2560px)').matches) {
        // TV 4K - 2560px ou mais

        // Class
        classLegenda = 'font-size-18';
        classValor = 'font-size-24';
        classImagem = 'font-size-30';
    }

    indicador = `<div class="col-12 col-md-${colunas}">
                    <div class="card rounded-3 text-white h-100" style="background: #202b3c; border: 1px solid #354156;">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="text-truncate ${classLegenda}">${primeiraMaiuscula(legenda)}</div>
                                <div class="d-flex text-success ${classImagem}">
                                    <i class="${imagem} ${imagem_cor}"></i>
                                </div>
                            </div>
                            <div class="col-12 my-auto fw-bold text-white ${classValor}">${valor}</div>
                        </div>
                    </div>
                </div>`;

    return indicador;
}

// Retorna um indicador com Legenda, Valor e Imagem a Direita
function indicador_modelo2_mini_grafico({ identificador = '', colunas = 2, legenda = null, imagem = null, imagem_cor = null, valor = null, valor_legenda_cor = null, valor_legenda = null }) {
    if (legenda === null || imagem === null || imagem_cor === null || valor === null || valor_legenda_cor === null || valor_legenda === null) { return; }

    let indicador = '';

    // Tela Redimencionamentos
    if (window.matchMedia('(max-width: 575.98px)').matches) {
        // MOBILE - Até 575px

        // Class
        classLegenda = 'font-size-10';
        classValor = 'font-size-16';
        classImagem = 'font-size-20';
    } else if (window.matchMedia('(min-width: 576px) and (max-width: 991.98px)').matches) {
        // TABLET - 576px até 991px

        // Class
        classLegenda = 'font-size-12';
        classValor = 'font-size-18';
        classImagem = 'font-size-20';
    } else if (window.matchMedia('(min-width: 992px) and (max-width: 1599.98px)').matches) {
        // NOTEBOOK / DESKTOP - 992px até 1599px

        // Class
        classLegenda = 'font-size-14';
        classValor = 'font-size-20';
        classImagem = 'font-size-20';
    } else if (window.matchMedia('(min-width: 1600px) and (max-width: 2559.98px)').matches) {
        // TV / TELAS GRANDES - 1600px até 2559px

        // Class
        classLegenda = 'font-size-16';
        classValor = 'font-size-22';
        classImagem = 'font-size-30';
    } else if (window.matchMedia('(min-width: 2560px)').matches) {
        // TV 4K - 2560px ou mais

        // Class
        classLegenda = 'font-size-18';
        classValor = 'font-size-24';
        classImagem = 'font-size-30';
    }

    indicador = `<div class="col-6 col-md-${colunas}">
                    <div class="card rounded-3 text-white h-100" style="background: #202b3c; border: 1px solid #354156;">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="text-truncate ${classLegenda}">${primeiraMaiuscula(legenda)}</div>
                                <div class="d-flex text-success ${classImagem}">
                                    <i class="${imagem} ${imagem_cor}"></i>
                                </div>
                            </div>
                            <div class="col-12 my-auto fw-bold text-white ${classValor}">${valor}</div>
                            <div class="col-12 w-100 mt-2" style="height: 150px;" id="${identificador}_grafico_mini"></div>
                        </div>
                    </div>
                </div>`;

    return indicador;
}
// Indicadores - Fim'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
// Indicadores - Fim'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

// Gerar Indicadores e Gráficos - Início'''''''''''''''''''''''''''''''''''''''''''''
// Gerar Indicadores e Gráficos - Início'''''''''''''''''''''''''''''''''''''''''''''
async function indicadoresGraficosGerar() {
    try {
        const response = await fetch('dashboards_tvs/indicadores_graficos', {
            method: 'GET',
            headers: {
                'REQUEST-ORIGIN': 'fetch',
                'Accept': 'application/json'
            }
        });

        const data = await response.json();

        // Verificar se os dados são iguais aos recebidos anteriormente
        const retornoAtual = JSON.stringify(data);

        if (retornoAtual === rota_dashboards_tvs_indicadores_ultimo_retorno) { return; }

        // Armazenar novo retorno
        rota_dashboards_tvs_indicadores_ultimo_retorno = retornoAtual;

        // Gerar HTML's
        await indicadoresGraficosGerarHtmls(data);

        // Gerar Gráficos
        await indicadoresGraficosGerarGraficos(data);
    } catch (error) {
        alert('Erro indicadoresGerar: ' + error);
    }
}

async function indicadoresGraficosGerarHtmls(data) {
    try {
        if (data.success) {
            const dados = data.success;
            const indicadores = dados.indicadores ?? [];

            const dashboard_info = document.getElementById('dashboard_info');
            const agora = new Date();

            // Informações do Dashboard
            dashboard_info.innerHTML = `<div class="col-12 text-warning text-center align-self-center fw-bold nowrap">DASHBOARD GERENCIAL</div>
                                        <div class="col-12 text-white text-center align-self-center nowrap">${primeiraMaiuscula(dados.unidade_nome ?? '')}</div>
                                        <div class="col-12 text-white text-center align-self-center nowrap">${agora.toLocaleTimeString('pt-BR', { hour12: false })}</div>`;

            dashboard_indicadores_container.innerHTML = '';
            dashboard_graficos_container.innerHTML = '';

            indicadores.forEach(element => {
                // Valor Total
                let valor_total = 0;
                element.dados_grafico.forEach(item => {
                    valor_total = valor_total + item.value;
                });


                dashboard_indicadores_container.insertAdjacentHTML('beforeend', indicador_totais({ legenda: element.titulo, valor: valor_total, colunas: element.colunas }));
                dashboard_graficos_container.insertAdjacentHTML('beforeend', indicador_modelo2_mini_grafico({ identificador: element.identificador, colunas: element.colunas, legenda: element.titulo, imagem: 'fa fa-user', imagem_cor: 'text-success', valor: valor_total, valor_legenda_cor: 'text-white', valor_legenda: '', grafico: 'barra', grafico_posicao: 'antes' }));


            });
        }
    } catch (error) {
        alert('Erro indicadoresGerarHtmls: ' + error);
    }
}

async function indicadoresGraficosGerarGraficos(data) {
    try {
        if (data.success) {
            const dados = data.success;
            const indicadores = dados.indicadores ?? [];

            // ForEach Indicadores
            indicadores.forEach(element => {
                // Gerar gráficos
                chartMinPieSimple({ divId: element.identificador + '_grafico_mini', dados: element.dados_grafico });
            });
        }
    } catch (error) {
        alert('Erro indicadoresGraficosGerarGraficos: ' + error);
    }
}
// Gerar Indicadores e Gráficos - Fim''''''''''''''''''''''''''''''''''''''''''''''''
// Gerar Indicadores e Gráficos - Fim''''''''''''''''''''''''''''''''''''''''''''''''

document.addEventListener('DOMContentLoaded', async function () {
    // btnTelaCheia
    const btnTelaCheia = document.getElementById('btn_tela_cheia');
    if (!btnTelaCheia) { return; }

    // Alternar entre tela cheia e tela normal
    btnTelaCheia.addEventListener('click', async function () {
        try {
            if (!document.fullscreenElement) {
                await document.documentElement.requestFullscreen();
            } else {
                await document.exitFullscreen();
            }
        } catch (erro) {
            console.error('Não foi possível alterar o modo de tela:', erro);
        }
    });

    // Atualizar botão conforme o modo atual
    document.addEventListener('fullscreenchange', function () {
        if (document.fullscreenElement) {
            btnTelaCheia.innerHTML = `<i class="bx bx-exit-fullscreen"></i>`;
        } else {
            btnTelaCheia.innerHTML = `<i class="bx bx-fullscreen"></i>`;
        }
    });

    // Gerar Indicadores
    await indicadoresGraficosGerar();

    // Executar a cada 5 segundos
    setInterval(async () => {
        await indicadoresGraficosGerar();
    }, 5000);

    // Executar também quando redimensionar a tela
    window.addEventListener('resize', async () => {
        // Forçar atualização da tela reiniciando os dados
        rota_dashboards_tvs_indicadores_ultimo_retorno = null;

        await indicadoresGraficosGerar();
    });
});
