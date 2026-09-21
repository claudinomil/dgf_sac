async function intTopo(op) {
    // Elementos
    const int_topo_titulo = document.getElementById("int_topo_titulo");
    const int_topo_icone = document.getElementById("int_topo_icone");
    const int_importacoes_sac_antigo = document.getElementById("int_importacoes_sac_antigo");
    const int_xxxyyyzzz = document.getElementById("int_xxxyyyzzz");

    // Iniciando
    int_topo_titulo.innerText = "";
    int_importacoes_sac_antigo.style.display = "none";
    int_xxxyyyzzz.style.display = "none";

    // Importações SAC antigo
    if (op == 1) {
        // Ícone
        int_topo_icone.classList.remove("bx-export");
        int_topo_icone.classList.add("bx-import");

        int_topo_titulo.innerText = "Importações SAC antigo";
        int_importacoes_sac_antigo.style.display = "";

        // Quantidades
        impsacQuantidadesBancos();
    }

    // XXXYYYZZZ
    if (op == 2) {
        // Ícone
        int_topo_icone.classList.remove("bx-import");
        int_topo_icone.classList.add("bx-export");

        int_topo_titulo.innerText = "XXXYYYZZZ";
        int_xxxyyyzzz.style.display = "";
    }
}

// Importações SAC antigo (impsac) - Início'''''''''''''''''''''''''''''''''''''''''''''''''''''''''
async function impsacQuantidadesBancos() {
    // Elementos
    const tabsit_quantidade_banco_1 = document.getElementById('tabsit_quantidade_banco_1');
    const tabsit_quantidade_banco_2 = document.getElementById('tabsit_quantidade_banco_2');
    const tabgra_quantidade_banco_1 = document.getElementById('tabgra_quantidade_banco_1');
    const tabgra_quantidade_banco_2 = document.getElementById('tabgra_quantidade_banco_2');
    const tabuni_quantidade_banco_1 = document.getElementById('tabuni_quantidade_banco_1');
    const tabuni_quantidade_banco_2 = document.getElementById('tabuni_quantidade_banco_2');
    const tabqua_quantidade_banco_1 = document.getElementById('tabqua_quantidade_banco_1');
    const tabqua_quantidade_banco_2 = document.getElementById('tabqua_quantidade_banco_2');
    const tabfun_quantidade_banco_1 = document.getElementById('tabfun_quantidade_banco_1');
    const tabfun_quantidade_banco_2 = document.getElementById('tabfun_quantidade_banco_2');
    const tabetc_quantidade_banco_1 = document.getElementById('tabetc_quantidade_banco_1');
    const tabetc_quantidade_banco_2 = document.getElementById('tabetc_quantidade_banco_2');
    const tabcom_quantidade_banco_1 = document.getElementById('tabcom_quantidade_banco_1');
    const tabcom_quantidade_banco_2 = document.getElementById('tabcom_quantidade_banco_2');
    const tabtps_quantidade_banco_1 = document.getElementById('tabtps_quantidade_banco_1');
    const tabtps_quantidade_banco_2 = document.getElementById('tabtps_quantidade_banco_2');
    const tabfrh_quantidade_banco_1 = document.getElementById('tabfrh_quantidade_banco_1');
    const tabfrh_quantidade_banco_2 = document.getElementById('tabfrh_quantidade_banco_2');
    const tabnac_quantidade_banco_1 = document.getElementById('tabnac_quantidade_banco_1');
    const tabnac_quantidade_banco_2 = document.getElementById('tabnac_quantidade_banco_2');
    const tabnat_quantidade_banco_1 = document.getElementById('tabnat_quantidade_banco_1');
    const tabnat_quantidade_banco_2 = document.getElementById('tabnat_quantidade_banco_2');
    const tabesc_quantidade_banco_1 = document.getElementById('tabesc_quantidade_banco_1');
    const tabesc_quantidade_banco_2 = document.getElementById('tabesc_quantidade_banco_2');
    const tabsxb_quantidade_banco_1 = document.getElementById('tabsxb_quantidade_banco_1');
    const tabsxb_quantidade_banco_2 = document.getElementById('tabsxb_quantidade_banco_2');

    const tabmil_quantidade_banco_1 = document.getElementById('tabmil_quantidade_banco_1');
    const tabmil_quantidade_banco_2 = document.getElementById('tabmil_quantidade_banco_2');

    const tabmil_quantidade_banco_1_2 = document.getElementById('tabmil_quantidade_banco_1_2');
    const tabmil_quantidade_banco_2_2 = document.getElementById('tabmil_quantidade_banco_2_2');

    const tabmil_quantidade_banco_1_3 = document.getElementById('tabmil_quantidade_banco_1_3');
    const tabmil_quantidade_banco_2_3 = document.getElementById('tabmil_quantidade_banco_2_3');

    const tabmil_quantidade_banco_1_4 = document.getElementById('tabmil_quantidade_banco_1_4');
    const tabmil_quantidade_banco_2_4 = document.getElementById('tabmil_quantidade_banco_2_4');

    const tabcur_quantidade_banco_1 = document.getElementById('tabcur_quantidade_banco_1');
    const tabcur_quantidade_banco_2 = document.getElementById('tabcur_quantidade_banco_2');
    const tabcco_quantidade_banco_1 = document.getElementById('tabcco_quantidade_banco_1');
    const tabcco_quantidade_banco_2 = document.getElementById('tabcco_quantidade_banco_2');
    const tabacu_quantidade_banco_1 = document.getElementById('tabacu_quantidade_banco_1');
    const tabacu_quantidade_banco_2 = document.getElementById('tabacu_quantidade_banco_2');
    const tabaxf_quantidade_banco_1 = document.getElementById('tabaxf_quantidade_banco_1');
    const tabaxf_quantidade_banco_2 = document.getElementById('tabaxf_quantidade_banco_2');
    const tabfsa_quantidade_banco_1 = document.getElementById('tabfsa_quantidade_banco_1');
    const tabfsa_quantidade_banco_2 = document.getElementById('tabfsa_quantidade_banco_2');
    const tabfsc_quantidade_banco_1 = document.getElementById('tabfsc_quantidade_banco_1');
    const tabfsc_quantidade_banco_2 = document.getElementById('tabfsc_quantidade_banco_2');
    const tabfsd_quantidade_banco_1 = document.getElementById('tabfsd_quantidade_banco_1');
    const tabfsd_quantidade_banco_2 = document.getElementById('tabfsd_quantidade_banco_2');
    const tabpar_quantidade_banco_1 = document.getElementById('tabpar_quantidade_banco_1');
    const tabpar_quantidade_banco_2 = document.getElementById('tabpar_quantidade_banco_2');
    const tabmde_quantidade_banco_1 = document.getElementById('tabmde_quantidade_banco_1');
    const tabmde_quantidade_banco_2 = document.getElementById('tabmde_quantidade_banco_2');

    const int_quantidade_banco_1 = document.getElementById('int_quantidade_banco_1');
    const int_quantidade_banco_2 = document.getElementById('int_quantidade_banco_2');

    // Iniciando
    tabsit_quantidade_banco_1.innerText = 'null';
    tabsit_quantidade_banco_2.innerText = 'null';
    tabgra_quantidade_banco_1.innerText = 'null';
    tabgra_quantidade_banco_2.innerText = 'null';
    tabuni_quantidade_banco_1.innerText = 'null';
    tabuni_quantidade_banco_2.innerText = 'null';
    tabqua_quantidade_banco_1.innerText = 'null';
    tabqua_quantidade_banco_2.innerText = 'null';
    tabfun_quantidade_banco_1.innerText = 'null';
    tabfun_quantidade_banco_2.innerText = 'null';
    tabetc_quantidade_banco_1.innerText = 'null';
    tabetc_quantidade_banco_2.innerText = 'null';
    tabcom_quantidade_banco_1.innerText = 'null';
    tabcom_quantidade_banco_2.innerText = 'null';
    tabtps_quantidade_banco_1.innerText = 'null';
    tabtps_quantidade_banco_2.innerText = 'null';
    tabfrh_quantidade_banco_1.innerText = 'null';
    tabfrh_quantidade_banco_2.innerText = 'null';
    tabnac_quantidade_banco_1.innerText = 'null';
    tabnac_quantidade_banco_2.innerText = 'null';
    tabnat_quantidade_banco_1.innerText = 'null';
    tabnat_quantidade_banco_2.innerText = 'null';
    tabesc_quantidade_banco_1.innerText = 'null';
    tabesc_quantidade_banco_2.innerText = 'null';
    tabsxb_quantidade_banco_1.innerText = 'null';
    tabsxb_quantidade_banco_2.innerText = 'null';

    tabmil_quantidade_banco_1.innerText = 'null';
    tabmil_quantidade_banco_2.innerText = 'null';

    tabmil_quantidade_banco_1_2.innerText = 'null';
    tabmil_quantidade_banco_2_2.innerText = 'null';

    tabmil_quantidade_banco_1_3.innerText = 'null';
    tabmil_quantidade_banco_2_3.innerText = 'null';

    tabmil_quantidade_banco_1_4.innerText = 'null';
    tabmil_quantidade_banco_2_4.innerText = 'null';

    tabcur_quantidade_banco_1.innerText = 'null';
    tabcur_quantidade_banco_2.innerText = 'null';
    tabcco_quantidade_banco_1.innerText = 'null';
    tabcco_quantidade_banco_2.innerText = 'null';
    tabacu_quantidade_banco_1.innerText = 'null';
    tabacu_quantidade_banco_2.innerText = 'null';
    tabaxf_quantidade_banco_1.innerText = 'null';
    tabaxf_quantidade_banco_2.innerText = 'null';
    tabfsa_quantidade_banco_1.innerText = 'null';
    tabfsa_quantidade_banco_2.innerText = 'null';
    tabfsc_quantidade_banco_1.innerText = 'null';
    tabfsc_quantidade_banco_2.innerText = 'null';
    tabfsd_quantidade_banco_1.innerText = 'null';
    tabfsd_quantidade_banco_2.innerText = 'null';
    tabpar_quantidade_banco_1.innerText = 'null';
    tabpar_quantidade_banco_2.innerText = 'null';
    tabmde_quantidade_banco_1.innerText = 'null';
    tabmde_quantidade_banco_2.innerText = 'null';

    int_quantidade_banco_1.innerText = 'null';
    int_quantidade_banco_2.innerText = 'null';

    // Buscar dados
    try {
        const response = await fetch(`integracoes/impsac/quantidades_bancos`, {
            method: "GET",
            headers: { "REQUEST-ORIGIN": "fetch" },
        });

        const data = await response.json();

        if (data.success) {
            tabsit_quantidade_banco_1.innerText = data.success.totais_banco_1.total_situacoes;
            tabsit_quantidade_banco_2.innerText = data.success.totais_banco_2.total_situacoes;
            tabgra_quantidade_banco_1.innerText = data.success.totais_banco_1.total_graduacoes;
            tabgra_quantidade_banco_2.innerText = data.success.totais_banco_2.total_graduacoes;
            tabuni_quantidade_banco_1.innerText = data.success.totais_banco_1.total_unidades;
            tabuni_quantidade_banco_2.innerText = data.success.totais_banco_2.total_unidades;
            tabqua_quantidade_banco_1.innerText = data.success.totais_banco_1.total_quadros;
            tabqua_quantidade_banco_2.innerText = data.success.totais_banco_2.total_quadros;
            tabfun_quantidade_banco_1.innerText = data.success.totais_banco_1.total_funcoes;
            tabfun_quantidade_banco_2.innerText = data.success.totais_banco_2.total_funcoes;
            tabetc_quantidade_banco_1.innerText = data.success.totais_banco_1.total_estados_civis;
            tabetc_quantidade_banco_2.innerText = data.success.totais_banco_2.total_estados_civis;
            tabcom_quantidade_banco_1.innerText = data.success.totais_banco_1.total_comportamentos;
            tabcom_quantidade_banco_2.innerText = data.success.totais_banco_2.total_comportamentos;
            tabtps_quantidade_banco_1.innerText = data.success.totais_banco_1.total_tipos_sanguineos;
            tabtps_quantidade_banco_2.innerText = data.success.totais_banco_2.total_tipos_sanguineos;
            tabfrh_quantidade_banco_1.innerText = data.success.totais_banco_1.total_fatores_rh;
            tabfrh_quantidade_banco_2.innerText = data.success.totais_banco_2.total_fatores_rh;
            tabnac_quantidade_banco_1.innerText = data.success.totais_banco_1.total_nacionalidades;
            tabnac_quantidade_banco_2.innerText = data.success.totais_banco_2.total_nacionalidades;
            tabnat_quantidade_banco_1.innerText = data.success.totais_banco_1.total_naturalidades;
            tabnat_quantidade_banco_2.innerText = data.success.totais_banco_2.total_naturalidades;
            tabesc_quantidade_banco_1.innerText = data.success.totais_banco_1.total_escolaridades;
            tabesc_quantidade_banco_2.innerText = data.success.totais_banco_2.total_escolaridades;
            tabsxb_quantidade_banco_1.innerText = data.success.totais_banco_1.total_sexos_biologicos;
            tabsxb_quantidade_banco_2.innerText = data.success.totais_banco_2.total_sexos_biologicos;
            tabban_quantidade_banco_1.innerText = data.success.totais_banco_1.total_bancos;
            tabban_quantidade_banco_2.innerText = data.success.totais_banco_2.total_bancos;

            tabmil_quantidade_banco_1.innerText = data.success.totais_banco_1.total_militares;
            tabmil_quantidade_banco_2.innerText = data.success.totais_banco_2.total_militares;

            tabmil_quantidade_banco_1_2.innerText = data.success.totais_banco_1.total_militares;
            tabmil_quantidade_banco_2_2.innerText = data.success.totais_banco_2.total_militares;

            tabmil_quantidade_banco_1_3.innerText = data.success.totais_banco_1.total_militares;
            tabmil_quantidade_banco_2_3.innerText = data.success.totais_banco_2.total_militares;

            tabmil_quantidade_banco_1_4.innerText = data.success.totais_banco_1.total_militares;
            tabmil_quantidade_banco_2_4.innerText = data.success.totais_banco_2.total_militares;

            tabcur_quantidade_banco_1.innerText = data.success.totais_banco_1.total_cursos;
            tabcur_quantidade_banco_2.innerText = data.success.totais_banco_2.total_cursos;
            tabcco_quantidade_banco_1.innerText = data.success.totais_banco_1.total_militares_cursos;
            tabcco_quantidade_banco_2.innerText = data.success.totais_banco_2.total_militares_cursos;
            tabacu_quantidade_banco_1.innerText = data.success.totais_banco_1.total_militares_ajudas_custos;
            tabacu_quantidade_banco_2.innerText = data.success.totais_banco_2.total_militares_ajudas_custos;
            tabaxf_quantidade_banco_1.innerText = data.success.totais_banco_1.total_militares_auxilios_fardamentos;
            tabaxf_quantidade_banco_2.innerText = data.success.totais_banco_2.total_militares_auxilios_fardamentos;
            tabfsa_quantidade_banco_1.innerText = data.success.totais_banco_1.total_militares_fundos_saude;
            tabfsa_quantidade_banco_2.innerText = data.success.totais_banco_2.total_militares_fundos_saude;
            tabfsc_quantidade_banco_1.innerText = data.success.totais_banco_1.total_militares_fundos_saude_controle;
            tabfsc_quantidade_banco_2.innerText = data.success.totais_banco_2.total_militares_fundos_saude_controle;
            tabfsd_quantidade_banco_1.innerText = data.success.totais_banco_1.total_militares_fundos_saude_adesao;
            tabfsd_quantidade_banco_2.innerText = data.success.totais_banco_2.total_militares_fundos_saude_adesao;
            tabpar_quantidade_banco_1.innerText = data.success.totais_banco_1.total_parentescos;
            tabpar_quantidade_banco_2.innerText = data.success.totais_banco_2.total_parentescos;
            tabmde_quantidade_banco_1.innerText = data.success.totais_banco_1.total_militares_dependentes;
            tabmde_quantidade_banco_2.innerText = data.success.totais_banco_2.total_militares_dependentes;

            let quantidade_banco_1 = Number(data.success.totais_banco_1.total_situacoes) +
                Number(data.success.totais_banco_1.total_graduacoes) +
                Number(data.success.totais_banco_1.total_unidades) +
                Number(data.success.totais_banco_1.total_quadros) +
                Number(data.success.totais_banco_1.total_funcoes) +
                Number(data.success.totais_banco_1.total_estados_civis) +
                Number(data.success.totais_banco_1.total_comportamentos) +
                Number(data.success.totais_banco_1.total_tipos_sanguineos) +
                Number(data.success.totais_banco_1.total_fatores_rh) +
                Number(data.success.totais_banco_1.total_nacionalidades) +
                Number(data.success.totais_banco_1.total_naturalidades) +
                Number(data.success.totais_banco_1.total_escolaridades) +
                Number(data.success.totais_banco_1.total_sexos_biologicos) +
                Number(data.success.totais_banco_1.total_bancos) +
                Number(data.success.totais_banco_1.total_militares) +
                Number(data.success.totais_banco_1.total_cursos) +
                Number(data.success.totais_banco_1.total_militares_cursos) +
                Number(data.success.totais_banco_1.total_militares_ajudas_custos) +
                Number(data.success.totais_banco_1.total_militares_auxilios_fardamentos) +
                Number(data.success.totais_banco_1.total_militares_fundos_saude) +
                Number(data.success.totais_banco_1.total_militares_fundos_saude_controle) +
                Number(data.success.totais_banco_1.total_militares_fundos_saude_adesao) +
                Number(data.success.totais_banco_1.total_parentescos) +
                Number(data.success.totais_banco_1.total_militares_dependentes);

            int_quantidade_banco_1.innerText = quantidade_banco_1;

            let quantidade_banco_2 = Number(data.success.totais_banco_2.total_situacoes) +
                Number(data.success.totais_banco_2.total_graduacoes) +
                Number(data.success.totais_banco_2.total_unidades) +
                Number(data.success.totais_banco_2.total_quadros) +
                Number(data.success.totais_banco_2.total_funcoes) +
                Number(data.success.totais_banco_2.total_estados_civis) +
                Number(data.success.totais_banco_2.total_comportamentos) +
                Number(data.success.totais_banco_2.total_tipos_sanguineos) +
                Number(data.success.totais_banco_2.total_fatores_rh) +
                Number(data.success.totais_banco_2.total_nacionalidades) +
                Number(data.success.totais_banco_2.total_naturalidades) +
                Number(data.success.totais_banco_2.total_escolaridades) +
                Number(data.success.totais_banco_2.total_sexos_biologicos) +
                Number(data.success.totais_banco_2.total_bancos) +
                Number(data.success.totais_banco_2.total_militares) +
                Number(data.success.totais_banco_2.total_cursos) +
                Number(data.success.totais_banco_2.total_militares_cursos) +
                Number(data.success.totais_banco_2.total_militares_ajudas_custos) +
                Number(data.success.totais_banco_2.total_militares_auxilios_fardamentos) +
                Number(data.success.totais_banco_2.total_militares_fundos_saude) +
                Number(data.success.totais_banco_2.total_militares_fundos_saude_controle) +
                Number(data.success.totais_banco_2.total_militares_fundos_saude_adesao) +
                Number(data.success.totais_banco_2.total_parentescos) +
                Number(data.success.totais_banco_2.total_militares_dependentes);

            int_quantidade_banco_2.innerText = quantidade_banco_2;
        } else {
            alert(data.error);
        }
    } catch (error) {
        console.error("Erro impsacQuantidadesBancos:", error);
    }
}

async function impsacAtualizarDados(tabela) {
    // Botão
    const btn = document.getElementById(`impsac_btn_${tabela}`);

    try {
        // desabilita botão
        btn.disabled = true;

        // troca conteúdo botão
        btn.innerHTML = `<span class="spinner-border spinner-border-sm" role="status"></span>Aguarde...`;

        // Rota
        const response = await fetch(`integracoes/impsac/atualizar_dados/${tabela}`, {
            method: "GET",
            headers: { "REQUEST-ORIGIN": "fetch" },
        });

        const data = await response.json();

        if (data.success) {
            await intTopo(1);
        } else {
            alert(data.error);
        }
    } catch (error) {
        console.error("Erro impsacAtualizarDados:", error);
    } finally {
        // habilita botão
        btn.disabled = false;

        // troca conteúdo botão
        btn.innerHTML = `Atualizar Dados`;
    }
}

async function impsacIntegrarBancos() {
    // Botão
    const btn = document.getElementById(`impsac_btn_integrar_bancos`);

    try {
        // desabilita botão
        btn.disabled = true;

        // troca conteúdo botão
        btn.innerHTML = `<span class="spinner-border spinner-border-sm" role="status"></span>Aguarde...`;

        // Situações
        await impsacAtualizarDados('situacoes');

        // Graduações
        await impsacAtualizarDados('graduacoes');

        // Unidades
        await impsacAtualizarDados('unidades');

        // Quadros
        await impsacAtualizarDados('quadros');

        // Funções
        await impsacAtualizarDados('funcoes');

        // Estados Civis
        await impsacAtualizarDados('estados_civis');

        // Comportamentos
        await impsacAtualizarDados('comportamentos');

        // Tipos Sanguíneos
        await impsacAtualizarDados('tipos_sanguineos');

        // Fatores RH
        await impsacAtualizarDados('fatores_rh');

        // Nacionalidades
        await impsacAtualizarDados('nacionalidades');

        // Naturalidades
        await impsacAtualizarDados('naturalidades');

        // Escolaridades
        await impsacAtualizarDados('escolaridades');

        // Sexos Biologicos
        await impsacAtualizarDados('sexos_biologicos');

        // Bancos
        await impsacAtualizarDados('bancos');

        // Militares
        await impsacAtualizarDados('militares');

        // Militares 2
        await impsacAtualizarDados('militares_2');

        // Militares 3
        await impsacAtualizarDados('militares_3');

        // Militares 4
        await impsacAtualizarDados('militares_4');

        // Cursos
        await impsacAtualizarDados('cursos');

        // Militares Cursos
        await impsacAtualizarDados('militares_cursos');

        // Militares Ajudas Custos
        await impsacAtualizarDados('militares_ajudas_custos');

        // Militares Auxílios Fardamentos
        await impsacAtualizarDados('militares_auxilios_fardamentos');

        // Militares Fundos Saúde
        await impsacAtualizarDados('militares_fundos_saude');

        // Militares Fundos Saúde Controle
        await impsacAtualizarDados('militares_fundos_saude_controle');

        // Militares Fundos Saúde Adesão
        await impsacAtualizarDados('militares_fundos_saude_adesao');

        // Parentescos
        await impsacAtualizarDados('parentescos');

        // Militares Dependentes
        await impsacAtualizarDados('militares_dependentes');
    } catch (error) {
        console.error("Erro impsacIntegrarBancos:", error);
    } finally {
        // habilita botão
        btn.disabled = false;

        // troca conteúdo botão
        btn.innerHTML = `Integrar Bancos`;
    }
}
// Importações SAC antigo (impsac) - Fim''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

document.addEventListener("DOMContentLoaded", async function (event) {
    // Iniciando
    await intTopo(1);
});
