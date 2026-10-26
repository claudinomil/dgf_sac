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

document.addEventListener('DOMContentLoaded', function () {
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
});