// Globais
let altura = window.innerHeight;
let largura = window.innerWidth;

async function entrarTelaCheia() {
    try {
        if (!document.fullscreenElement) {
            await document.documentElement.requestFullscreen();
        }

        ajustarDashboard();
    } catch (erro) {
        console.error('Não foi possível ativar tela cheia:', erro);
    }
}

function ajustarDashboard() {
    altura = window.innerHeight;
    largura = window.innerWidth;

    console.log('Altura:', altura);
    console.log('Largura:', largura);

    document.getElementById('dashboard').style.height = `${altura}px`;
}

window.addEventListener('resize', ajustarDashboard);

// Indicadores - Início''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
// Indicadores - Início''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

// Retorna um indicador com Legenda e Valor
function indicador_modelo1_simples({ legenda = null, valor = null }) {
    if (legenda === null || valor === null) { return; }

    let indicador = '';

    indicador = `<div class="indicador-modelo1 flex-fill p-2 rounded">
                    <div class="indicador-modelo1-dados">
                        <div class="indicador-modelo1-titulo">${legenda}</div>
                        <div class="indicador-modelo1-valor">${valor}</div>
                    </div>
                </div>`;
    
    return indicador;
}

// Retorna um indicador com Legenda, Valor e Imagem a Esquerda
function indicador_modelo1_imagem_esquerda({ imagem = null, legenda = null, valor = null }) {
    if (imagem === null || legenda === null || valor === null) { return; }

    let indicador = '';

    indicador = `<div class="indicador-modelo1 flex-fill p-2 rounded">
                    <div class="d-flex align-items-start gap-3">
                        <div class="indicador-modelo1-icone">
                            <i class="${imagem}"></i>
                        </div>
                        <div class="indicador-modelo1-dados">
                            <div class="indicador-modelo1-titulo">${legenda}</div>
                            <div class="indicador-modelo1-valor">${valor}</div>
                        </div>
                    </div>
                </div>`;
    
    return indicador;
}

// Retorna um indicador com Legenda, Valor e Imagem a Direita
function indicador_modelo1_imagem_direita({ imagem = null, legenda = null, valor = null }) {
    if (imagem === null || legenda === null || valor === null) { return; }

    let indicador = '';

    indicador = `<div class="indicador-modelo1 flex-fill p-2 rounded">
                    <div class="d-flex align-items-start gap-3">
                        <div class="indicador-modelo1-dados flex-fill">
                            <div class="indicador-modelo1-titulo">${legenda}</div>
                            <div class="indicador-modelo1-valor">${valor}</div>
                        </div>
                        <div class="indicador-modelo1-icone">
                            <i class="${imagem}"></i>
                        </div>
                    </div>
                </div>`;
    
    return indicador;
}

// Retorna um indicador com Legenda, Valor e Imagem a Direita
function indicador_modelo2_mini_grafico({ legenda = null, imagem = null, imagem_cor = null, valor = null, valor_legenda_cor = null, valor_legenda = null }) {
    if (legenda === null || imagem === null || imagem_cor === null || valor === null || valor_legenda_cor === null || valor_legenda === null) { return; }

    let indicador = '';

    indicador = `<div class="col-6 col-xl-3">
                    <div class="card indicador-modelo2 h-100">
                        <div class="card-body">
                            <div class="indicador-modelo2-titulo">
                                ${legenda}
                                <i class="${imagem} ${imagem_cor}"></i>
                            </div>
                            <div class="indicador-modelo2-valor">${valor}</div>
                            <div class="indicador-modelo2-legenda ${valor_legenda_cor}">
                                ${valor_legenda}
                            </div>
                            <div id="grafico_militares" class="indicador-modelo2-grafico-mini"></div>
                        </div>
                    </div>
                </div>`;
    
    return indicador;
}
// Indicadores - Fim'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
// Indicadores - Fim'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''


document.addEventListener('DOMContentLoaded', function () {
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





    // TESTE DE MONTAR INDICADORES
    const dashboard_indicadores_modelo1 = document.getElementById('dashboard_indicadores_modelo1');

    dashboard_indicadores_modelo1.insertAdjacentHTML('beforeend', indicador_modelo1_imagem_esquerda({ imagem: 'fas fa-users', legenda: 'Total de Militares', valor: '12.450' }));
    dashboard_indicadores_modelo1.insertAdjacentHTML('beforeend', indicador_modelo1_simples({ legenda: 'Total de Férias', valor: '3.000' }));
    dashboard_indicadores_modelo1.insertAdjacentHTML('beforeend', indicador_modelo1_imagem_direita({ imagem: 'fas fa-users', legenda: 'Total de Tempos Averbados', valor: 450 }));
    dashboard_indicadores_modelo1.insertAdjacentHTML('beforeend', indicador_modelo1_imagem_esquerda({ imagem: 'fas fa-users', legenda: 'Total de Militares', valor: '12.450' }));
    dashboard_indicadores_modelo1.insertAdjacentHTML('beforeend', indicador_modelo1_simples({ legenda: 'Total de Férias', valor: '3.000' }));
    dashboard_indicadores_modelo1.insertAdjacentHTML('beforeend', indicador_modelo1_imagem_direita({ imagem: 'fas fa-users', legenda: 'Total de Tempos Averbados', valor: 450 }));
    dashboard_indicadores_modelo1.insertAdjacentHTML('beforeend', indicador_modelo1_imagem_esquerda({ imagem: 'fas fa-users', legenda: 'Total de Militares', valor: '12.450' }));
    dashboard_indicadores_modelo1.insertAdjacentHTML('beforeend', indicador_modelo1_simples({ legenda: 'Total de Férias', valor: '3.000' }));
    dashboard_indicadores_modelo1.insertAdjacentHTML('beforeend', indicador_modelo1_imagem_direita({ imagem: 'fas fa-users', legenda: 'Total de Tempos Averbados', valor: 450 }));

    const dashboard_indicadores_modelo2 = document.getElementById('dashboard_indicadores_modelo2');

    dashboard_indicadores_modelo2.insertAdjacentHTML('beforeend', indicador_modelo2_mini_grafico({ legenda: 'Total de Militares', imagem: 'fa fa-user', imagem_cor: 'text-success', valor: '31.650', valor_legenda_cor: 'text-white', valor_legenda: '<i class="fas fa-arrow-up text-success"></i> <span class="text-success">4,8%</span> <span>no período</span>' }));
    dashboard_indicadores_modelo2.insertAdjacentHTML('beforeend', indicador_modelo2_mini_grafico({ legenda: 'Total de Militares', imagem: 'fa fa-user', imagem_cor: 'text-success', valor: '31.650', valor_legenda_cor: 'text-white', valor_legenda: '86,9% do efetivo total' }));
    dashboard_indicadores_modelo2.insertAdjacentHTML('beforeend', indicador_modelo2_mini_grafico({ legenda: 'Total de Militares', imagem: 'fa fa-user', imagem_cor: 'text-success', valor: '31.650', valor_legenda_cor: 'text-white', valor_legenda: 'Meta: 560' }));
    dashboard_indicadores_modelo2.insertAdjacentHTML('beforeend', indicador_modelo2_mini_grafico({ legenda: 'Total de Militares', imagem: 'fa fa-user', imagem_cor: 'text-success', valor: '31.650', valor_legenda_cor: 'text-white', valor_legenda: 'Efetivo ativo' }));







});