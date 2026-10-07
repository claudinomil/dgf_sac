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

    const tabmil1_quantidade_banco_1 = document.getElementById('tabmil1_quantidade_banco_1');
    const tabmil1_quantidade_banco_2 = document.getElementById('tabmil1_quantidade_banco_2');

    const tabmil2_quantidade_banco_1 = document.getElementById('tabmil2_quantidade_banco_1');
    const tabmil2_quantidade_banco_2 = document.getElementById('tabmil2_quantidade_banco_2');

    const tabmil3_quantidade_banco_1 = document.getElementById('tabmil3_quantidade_banco_1');
    const tabmil3_quantidade_banco_2 = document.getElementById('tabmil3_quantidade_banco_2');

    const tabmil4_quantidade_banco_1 = document.getElementById('tabmil4_quantidade_banco_1');
    const tabmil4_quantidade_banco_2 = document.getElementById('tabmil4_quantidade_banco_2');

    const tabcur_quantidade_banco_1 = document.getElementById('tabcur_quantidade_banco_1');
    const tabcur_quantidade_banco_2 = document.getElementById('tabcur_quantidade_banco_2');

    const tabcco1_quantidade_banco_1 = document.getElementById('tabcco1_quantidade_banco_1');
    const tabcco1_quantidade_banco_2 = document.getElementById('tabcco1_quantidade_banco_2');

    const tabcco2_quantidade_banco_1 = document.getElementById('tabcco2_quantidade_banco_1');
    const tabcco2_quantidade_banco_2 = document.getElementById('tabcco2_quantidade_banco_2');

    const tabcco3_quantidade_banco_1 = document.getElementById('tabcco3_quantidade_banco_1');
    const tabcco3_quantidade_banco_2 = document.getElementById('tabcco3_quantidade_banco_2');

    const tabcco4_quantidade_banco_1 = document.getElementById('tabcco4_quantidade_banco_1');
    const tabcco4_quantidade_banco_2 = document.getElementById('tabcco4_quantidade_banco_2');

    const tabcco5_quantidade_banco_1 = document.getElementById('tabcco5_quantidade_banco_1');
    const tabcco5_quantidade_banco_2 = document.getElementById('tabcco5_quantidade_banco_2');

    const tabcco6_quantidade_banco_1 = document.getElementById('tabcco6_quantidade_banco_1');
    const tabcco6_quantidade_banco_2 = document.getElementById('tabcco6_quantidade_banco_2');

    const tabcco7_quantidade_banco_1 = document.getElementById('tabcco7_quantidade_banco_1');
    const tabcco7_quantidade_banco_2 = document.getElementById('tabcco7_quantidade_banco_2');

    const tabcco8_quantidade_banco_1 = document.getElementById('tabcco8_quantidade_banco_1');
    const tabcco8_quantidade_banco_2 = document.getElementById('tabcco8_quantidade_banco_2');

    const tabacu_quantidade_banco_1 = document.getElementById('tabacu_quantidade_banco_1');
    const tabacu_quantidade_banco_2 = document.getElementById('tabacu_quantidade_banco_2');

    const tabaxf1_quantidade_banco_1 = document.getElementById('tabaxf1_quantidade_banco_1');
    const tabaxf1_quantidade_banco_2 = document.getElementById('tabaxf1_quantidade_banco_2');

    const tabaxf2_quantidade_banco_1 = document.getElementById('tabaxf2_quantidade_banco_1');
    const tabaxf2_quantidade_banco_2 = document.getElementById('tabaxf2_quantidade_banco_2');

    const tabaxf3_quantidade_banco_1 = document.getElementById('tabaxf3_quantidade_banco_1');
    const tabaxf3_quantidade_banco_2 = document.getElementById('tabaxf3_quantidade_banco_2');

    const tabfsa1_quantidade_banco_1 = document.getElementById('tabfsa1_quantidade_banco_1');
    const tabfsa1_quantidade_banco_2 = document.getElementById('tabfsa1_quantidade_banco_2');

    const tabfsa2_quantidade_banco_1 = document.getElementById('tabfsa2_quantidade_banco_1');
    const tabfsa2_quantidade_banco_2 = document.getElementById('tabfsa2_quantidade_banco_2');

    const tabfsa3_quantidade_banco_1 = document.getElementById('tabfsa3_quantidade_banco_1');
    const tabfsa3_quantidade_banco_2 = document.getElementById('tabfsa3_quantidade_banco_2');

    const tabfsa4_quantidade_banco_1 = document.getElementById('tabfsa4_quantidade_banco_1');
    const tabfsa4_quantidade_banco_2 = document.getElementById('tabfsa4_quantidade_banco_2');

    const tabfsc_quantidade_banco_1 = document.getElementById('tabfsc_quantidade_banco_1');
    const tabfsc_quantidade_banco_2 = document.getElementById('tabfsc_quantidade_banco_2');

    const tabfsd_quantidade_banco_1 = document.getElementById('tabfsd_quantidade_banco_1');
    const tabfsd_quantidade_banco_2 = document.getElementById('tabfsd_quantidade_banco_2');

    const tabpar_quantidade_banco_1 = document.getElementById('tabpar_quantidade_banco_1');
    const tabpar_quantidade_banco_2 = document.getElementById('tabpar_quantidade_banco_2');

    const tabtal_quantidade_banco_1 = document.getElementById('tabtal_quantidade_banco_1');
    const tabtal_quantidade_banco_2 = document.getElementById('tabtal_quantidade_banco_2');

    const tabmde1_quantidade_banco_1 = document.getElementById('tabmde1_quantidade_banco_1');
    const tabmde1_quantidade_banco_2 = document.getElementById('tabmde1_quantidade_banco_2');

    const tabmde2_quantidade_banco_1 = document.getElementById('tabmde2_quantidade_banco_1');
    const tabmde2_quantidade_banco_2 = document.getElementById('tabmde2_quantidade_banco_2');

    const tabmde3_quantidade_banco_1 = document.getElementById('tabmde3_quantidade_banco_1');
    const tabmde3_quantidade_banco_2 = document.getElementById('tabmde3_quantidade_banco_2');

    const tabmde4_quantidade_banco_1 = document.getElementById('tabmde4_quantidade_banco_1');
    const tabmde4_quantidade_banco_2 = document.getElementById('tabmde4_quantidade_banco_2');

    const tabmde5_quantidade_banco_1 = document.getElementById('tabmde5_quantidade_banco_1');
    const tabmde5_quantidade_banco_2 = document.getElementById('tabmde5_quantidade_banco_2');

    const tabmde6_quantidade_banco_1 = document.getElementById('tabmde6_quantidade_banco_1');
    const tabmde6_quantidade_banco_2 = document.getElementById('tabmde6_quantidade_banco_2');

    const tabmde7_quantidade_banco_1 = document.getElementById('tabmde7_quantidade_banco_1');
    const tabmde7_quantidade_banco_2 = document.getElementById('tabmde7_quantidade_banco_2');

    const tabmpe1_quantidade_banco_1 = document.getElementById('tabmpe1_quantidade_banco_1');
    const tabmpe1_quantidade_banco_2 = document.getElementById('tabmpe1_quantidade_banco_2');

    const tabmpe2_quantidade_banco_1 = document.getElementById('tabmpe2_quantidade_banco_1');
    const tabmpe2_quantidade_banco_2 = document.getElementById('tabmpe2_quantidade_banco_2');

    const tabmta_quantidade_banco_1 = document.getElementById('tabmta_quantidade_banco_1');
    const tabmta_quantidade_banco_2 = document.getElementById('tabmta_quantidade_banco_2');

    const tabmfe1_quantidade_banco_1 = document.getElementById('tabmfe1_quantidade_banco_1');
    const tabmfe1_quantidade_banco_2 = document.getElementById('tabmfe1_quantidade_banco_2');

    const tabmfe2_quantidade_banco_1 = document.getElementById('tabmfe2_quantidade_banco_1');
    const tabmfe2_quantidade_banco_2 = document.getElementById('tabmfe2_quantidade_banco_2');

    const tabmfe3_quantidade_banco_1 = document.getElementById('tabmfe3_quantidade_banco_1');
    const tabmfe3_quantidade_banco_2 = document.getElementById('tabmfe3_quantidade_banco_2');

    const tabmfe4_quantidade_banco_1 = document.getElementById('tabmfe4_quantidade_banco_1');
    const tabmfe4_quantidade_banco_2 = document.getElementById('tabmfe4_quantidade_banco_2');

    const tabmfe5_quantidade_banco_1 = document.getElementById('tabmfe5_quantidade_banco_1');
    const tabmfe5_quantidade_banco_2 = document.getElementById('tabmfe5_quantidade_banco_2');

    const tabmfe6_quantidade_banco_1 = document.getElementById('tabmfe6_quantidade_banco_1');
    const tabmfe6_quantidade_banco_2 = document.getElementById('tabmfe6_quantidade_banco_2');

    const tabmfe7_quantidade_banco_1 = document.getElementById('tabmfe7_quantidade_banco_1');
    const tabmfe7_quantidade_banco_2 = document.getElementById('tabmfe7_quantidade_banco_2');

    const tabmfe8_quantidade_banco_1 = document.getElementById('tabmfe8_quantidade_banco_1');
    const tabmfe8_quantidade_banco_2 = document.getElementById('tabmfe8_quantidade_banco_2');

    const tabmfe9_quantidade_banco_1 = document.getElementById('tabmfe9_quantidade_banco_1');
    const tabmfe9_quantidade_banco_2 = document.getElementById('tabmfe9_quantidade_banco_2');

    const tabmfe10_quantidade_banco_1 = document.getElementById('tabmfe10_quantidade_banco_1');
    const tabmfe10_quantidade_banco_2 = document.getElementById('tabmfe10_quantidade_banco_2');

    const tabmfe11_quantidade_banco_1 = document.getElementById('tabmfe11_quantidade_banco_1');
    const tabmfe11_quantidade_banco_2 = document.getElementById('tabmfe11_quantidade_banco_2');

    const tabmfe12_quantidade_banco_1 = document.getElementById('tabmfe12_quantidade_banco_1');
    const tabmfe12_quantidade_banco_2 = document.getElementById('tabmfe12_quantidade_banco_2');

    const tabmfe13_quantidade_banco_1 = document.getElementById('tabmfe13_quantidade_banco_1');
    const tabmfe13_quantidade_banco_2 = document.getElementById('tabmfe13_quantidade_banco_2');

    const tabmfe14_quantidade_banco_1 = document.getElementById('tabmfe14_quantidade_banco_1');
    const tabmfe14_quantidade_banco_2 = document.getElementById('tabmfe14_quantidade_banco_2');

    const tabmfe15_quantidade_banco_1 = document.getElementById('tabmfe15_quantidade_banco_1');
    const tabmfe15_quantidade_banco_2 = document.getElementById('tabmfe15_quantidade_banco_2');

    const tabmfe16_quantidade_banco_1 = document.getElementById('tabmfe16_quantidade_banco_1');
    const tabmfe16_quantidade_banco_2 = document.getElementById('tabmfe16_quantidade_banco_2');

    const tabmfe17_quantidade_banco_1 = document.getElementById('tabmfe17_quantidade_banco_1');
    const tabmfe17_quantidade_banco_2 = document.getElementById('tabmfe17_quantidade_banco_2');

    const tabmfe18_quantidade_banco_1 = document.getElementById('tabmfe18_quantidade_banco_1');
    const tabmfe18_quantidade_banco_2 = document.getElementById('tabmfe18_quantidade_banco_2');

    const tabmfe19_quantidade_banco_1 = document.getElementById('tabmfe19_quantidade_banco_1');
    const tabmfe19_quantidade_banco_2 = document.getElementById('tabmfe19_quantidade_banco_2');

    const tabmfe20_quantidade_banco_1 = document.getElementById('tabmfe20_quantidade_banco_1');
    const tabmfe20_quantidade_banco_2 = document.getElementById('tabmfe20_quantidade_banco_2');

    const tabmfe21_quantidade_banco_1 = document.getElementById('tabmfe21_quantidade_banco_1');
    const tabmfe21_quantidade_banco_2 = document.getElementById('tabmfe21_quantidade_banco_2');

    const tabmfe22_quantidade_banco_1 = document.getElementById('tabmfe22_quantidade_banco_1');
    const tabmfe22_quantidade_banco_2 = document.getElementById('tabmfe22_quantidade_banco_2');

    const tabmfe23_quantidade_banco_1 = document.getElementById('tabmfe23_quantidade_banco_1');
    const tabmfe23_quantidade_banco_2 = document.getElementById('tabmfe23_quantidade_banco_2');

    const tabmfe24_quantidade_banco_1 = document.getElementById('tabmfe24_quantidade_banco_1');
    const tabmfe24_quantidade_banco_2 = document.getElementById('tabmfe24_quantidade_banco_2');

    const tabmfe25_quantidade_banco_1 = document.getElementById('tabmfe25_quantidade_banco_1');
    const tabmfe25_quantidade_banco_2 = document.getElementById('tabmfe25_quantidade_banco_2');

    const tabmfe26_quantidade_banco_1 = document.getElementById('tabmfe26_quantidade_banco_1');
    const tabmfe26_quantidade_banco_2 = document.getElementById('tabmfe26_quantidade_banco_2');

    const tabmfe27_quantidade_banco_1 = document.getElementById('tabmfe27_quantidade_banco_1');
    const tabmfe27_quantidade_banco_2 = document.getElementById('tabmfe27_quantidade_banco_2');

    const tabmfe28_quantidade_banco_1 = document.getElementById('tabmfe28_quantidade_banco_1');
    const tabmfe28_quantidade_banco_2 = document.getElementById('tabmfe28_quantidade_banco_2');

    const tabmfe29_quantidade_banco_1 = document.getElementById('tabmfe29_quantidade_banco_1');
    const tabmfe29_quantidade_banco_2 = document.getElementById('tabmfe29_quantidade_banco_2');

    const tabmfe30_quantidade_banco_1 = document.getElementById('tabmfe30_quantidade_banco_1');
    const tabmfe30_quantidade_banco_2 = document.getElementById('tabmfe30_quantidade_banco_2');

    const tabmfe31_quantidade_banco_1 = document.getElementById('tabmfe31_quantidade_banco_1');
    const tabmfe31_quantidade_banco_2 = document.getElementById('tabmfe31_quantidade_banco_2');

    const tabmfe32_quantidade_banco_1 = document.getElementById('tabmfe32_quantidade_banco_1');
    const tabmfe32_quantidade_banco_2 = document.getElementById('tabmfe32_quantidade_banco_2');

    const tabmfe33_quantidade_banco_1 = document.getElementById('tabmfe33_quantidade_banco_1');
    const tabmfe33_quantidade_banco_2 = document.getElementById('tabmfe33_quantidade_banco_2');

    const tabmfe34_quantidade_banco_1 = document.getElementById('tabmfe34_quantidade_banco_1');
    const tabmfe34_quantidade_banco_2 = document.getElementById('tabmfe34_quantidade_banco_2');

    const tabmfe35_quantidade_banco_1 = document.getElementById('tabmfe35_quantidade_banco_1');
    const tabmfe35_quantidade_banco_2 = document.getElementById('tabmfe35_quantidade_banco_2');

    const tabmfe36_quantidade_banco_1 = document.getElementById('tabmfe36_quantidade_banco_1');
    const tabmfe36_quantidade_banco_2 = document.getElementById('tabmfe36_quantidade_banco_2');

    const tabmfe37_quantidade_banco_1 = document.getElementById('tabmfe37_quantidade_banco_1');
    const tabmfe37_quantidade_banco_2 = document.getElementById('tabmfe37_quantidade_banco_2');

    const tabmfe38_quantidade_banco_1 = document.getElementById('tabmfe38_quantidade_banco_1');
    const tabmfe38_quantidade_banco_2 = document.getElementById('tabmfe38_quantidade_banco_2');

    const tabmfe39_quantidade_banco_1 = document.getElementById('tabmfe39_quantidade_banco_1');
    const tabmfe39_quantidade_banco_2 = document.getElementById('tabmfe39_quantidade_banco_2');

    const tabmfe40_quantidade_banco_1 = document.getElementById('tabmfe40_quantidade_banco_1');
    const tabmfe40_quantidade_banco_2 = document.getElementById('tabmfe40_quantidade_banco_2');

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

    tabmil1_quantidade_banco_1.innerText = 'null';
    tabmil1_quantidade_banco_2.innerText = 'null';

    tabmil2_quantidade_banco_1.innerText = 'null';
    tabmil2_quantidade_banco_2.innerText = 'null';

    tabmil3_quantidade_banco_1.innerText = 'null';
    tabmil3_quantidade_banco_2.innerText = 'null';

    tabmil4_quantidade_banco_1.innerText = 'null';
    tabmil4_quantidade_banco_2.innerText = 'null';

    tabcur_quantidade_banco_1.innerText = 'null';
    tabcur_quantidade_banco_2.innerText = 'null';

    tabcco1_quantidade_banco_1.innerText = 'null';
    tabcco1_quantidade_banco_2.innerText = 'null';

    tabcco2_quantidade_banco_1.innerText = 'null';
    tabcco2_quantidade_banco_2.innerText = 'null';

    tabcco3_quantidade_banco_1.innerText = 'null';
    tabcco3_quantidade_banco_2.innerText = 'null';

    tabcco4_quantidade_banco_1.innerText = 'null';
    tabcco4_quantidade_banco_2.innerText = 'null';

    tabcco5_quantidade_banco_1.innerText = 'null';
    tabcco5_quantidade_banco_2.innerText = 'null';

    tabcco6_quantidade_banco_1.innerText = 'null';
    tabcco6_quantidade_banco_2.innerText = 'null';

    tabcco7_quantidade_banco_1.innerText = 'null';
    tabcco7_quantidade_banco_2.innerText = 'null';

    tabcco8_quantidade_banco_1.innerText = 'null';
    tabcco8_quantidade_banco_2.innerText = 'null';

    tabacu_quantidade_banco_1.innerText = 'null';
    tabacu_quantidade_banco_2.innerText = 'null';

    tabaxf1_quantidade_banco_1.innerText = 'null';
    tabaxf1_quantidade_banco_2.innerText = 'null';

    tabaxf2_quantidade_banco_1.innerText = 'null';
    tabaxf2_quantidade_banco_2.innerText = 'null';

    tabaxf3_quantidade_banco_1.innerText = 'null';
    tabaxf3_quantidade_banco_2.innerText = 'null';

    tabfsa1_quantidade_banco_1.innerText = 'null';
    tabfsa1_quantidade_banco_2.innerText = 'null';

    tabfsa2_quantidade_banco_1.innerText = 'null';
    tabfsa2_quantidade_banco_2.innerText = 'null';

    tabfsa3_quantidade_banco_1.innerText = 'null';
    tabfsa3_quantidade_banco_2.innerText = 'null';

    tabfsa4_quantidade_banco_1.innerText = 'null';
    tabfsa4_quantidade_banco_2.innerText = 'null';

    tabfsc_quantidade_banco_1.innerText = 'null';
    tabfsc_quantidade_banco_2.innerText = 'null';

    tabfsd_quantidade_banco_1.innerText = 'null';
    tabfsd_quantidade_banco_2.innerText = 'null';

    tabpar_quantidade_banco_1.innerText = 'null';
    tabpar_quantidade_banco_2.innerText = 'null';

    tabtal_quantidade_banco_1.innerText = 'null';
    tabtal_quantidade_banco_2.innerText = 'null';

    tabmde1_quantidade_banco_1.innerText = 'null';
    tabmde1_quantidade_banco_2.innerText = 'null';

    tabmde2_quantidade_banco_1.innerText = 'null';
    tabmde2_quantidade_banco_2.innerText = 'null';

    tabmde3_quantidade_banco_1.innerText = 'null';
    tabmde3_quantidade_banco_2.innerText = 'null';

    tabmde4_quantidade_banco_1.innerText = 'null';
    tabmde4_quantidade_banco_2.innerText = 'null';

    tabmde5_quantidade_banco_1.innerText = 'null';
    tabmde5_quantidade_banco_2.innerText = 'null';

    tabmde6_quantidade_banco_1.innerText = 'null';
    tabmde6_quantidade_banco_2.innerText = 'null';

    tabmde7_quantidade_banco_1.innerText = 'null';
    tabmde7_quantidade_banco_2.innerText = 'null';

    tabmpe1_quantidade_banco_1.innerText = 'null';
    tabmpe1_quantidade_banco_2.innerText = 'null';

    tabmpe2_quantidade_banco_1.innerText = 'null';
    tabmpe2_quantidade_banco_2.innerText = 'null';

    tabmta_quantidade_banco_1.innerText = 'null';
    tabmta_quantidade_banco_2.innerText = 'null';

    tabmfe1_quantidade_banco_1.innerText = 'null';
    tabmfe1_quantidade_banco_2.innerText = 'null';

    tabmfe2_quantidade_banco_1.innerText = 'null';
    tabmfe2_quantidade_banco_2.innerText = 'null';

    tabmfe3_quantidade_banco_1.innerText = 'null';
    tabmfe3_quantidade_banco_2.innerText = 'null';

    tabmfe4_quantidade_banco_1.innerText = 'null';
    tabmfe4_quantidade_banco_2.innerText = 'null';

    tabmfe5_quantidade_banco_1.innerText = 'null';
    tabmfe5_quantidade_banco_2.innerText = 'null';

    tabmfe6_quantidade_banco_1.innerText = 'null';
    tabmfe6_quantidade_banco_2.innerText = 'null';

    tabmfe7_quantidade_banco_1.innerText = 'null';
    tabmfe7_quantidade_banco_2.innerText = 'null';

    tabmfe8_quantidade_banco_1.innerText = 'null';
    tabmfe8_quantidade_banco_2.innerText = 'null';

    tabmfe9_quantidade_banco_1.innerText = 'null';
    tabmfe9_quantidade_banco_2.innerText = 'null';

    tabmfe10_quantidade_banco_1.innerText = 'null';
    tabmfe10_quantidade_banco_2.innerText = 'null';

    tabmfe11_quantidade_banco_1.innerText = 'null';
    tabmfe11_quantidade_banco_2.innerText = 'null';

    tabmfe12_quantidade_banco_1.innerText = 'null';
    tabmfe12_quantidade_banco_2.innerText = 'null';

    tabmfe13_quantidade_banco_1.innerText = 'null';
    tabmfe13_quantidade_banco_2.innerText = 'null';

    tabmfe14_quantidade_banco_1.innerText = 'null';
    tabmfe14_quantidade_banco_2.innerText = 'null';

    tabmfe15_quantidade_banco_1.innerText = 'null';
    tabmfe15_quantidade_banco_2.innerText = 'null';

    tabmfe16_quantidade_banco_1.innerText = 'null';
    tabmfe16_quantidade_banco_2.innerText = 'null';

    tabmfe17_quantidade_banco_1.innerText = 'null';
    tabmfe17_quantidade_banco_2.innerText = 'null';

    tabmfe18_quantidade_banco_1.innerText = 'null';
    tabmfe18_quantidade_banco_2.innerText = 'null';

    tabmfe19_quantidade_banco_1.innerText = 'null';
    tabmfe19_quantidade_banco_2.innerText = 'null';

    tabmfe20_quantidade_banco_1.innerText = 'null';
    tabmfe20_quantidade_banco_2.innerText = 'null';

    tabmfe21_quantidade_banco_1.innerText = 'null';
    tabmfe21_quantidade_banco_2.innerText = 'null';

    tabmfe22_quantidade_banco_1.innerText = 'null';
    tabmfe22_quantidade_banco_2.innerText = 'null';

    tabmfe23_quantidade_banco_1.innerText = 'null';
    tabmfe23_quantidade_banco_2.innerText = 'null';

    tabmfe24_quantidade_banco_1.innerText = 'null';
    tabmfe24_quantidade_banco_2.innerText = 'null';

    tabmfe25_quantidade_banco_1.innerText = 'null';
    tabmfe25_quantidade_banco_2.innerText = 'null';

    tabmfe26_quantidade_banco_1.innerText = 'null';
    tabmfe26_quantidade_banco_2.innerText = 'null';

    tabmfe27_quantidade_banco_1.innerText = 'null';
    tabmfe27_quantidade_banco_2.innerText = 'null';

    tabmfe28_quantidade_banco_1.innerText = 'null';
    tabmfe28_quantidade_banco_2.innerText = 'null';

    tabmfe29_quantidade_banco_1.innerText = 'null';
    tabmfe29_quantidade_banco_2.innerText = 'null';

    tabmfe30_quantidade_banco_1.innerText = 'null';
    tabmfe30_quantidade_banco_2.innerText = 'null';

    tabmfe31_quantidade_banco_1.innerText = 'null';
    tabmfe31_quantidade_banco_2.innerText = 'null';

    tabmfe32_quantidade_banco_1.innerText = 'null';
    tabmfe32_quantidade_banco_2.innerText = 'null';

    tabmfe33_quantidade_banco_1.innerText = 'null';
    tabmfe33_quantidade_banco_2.innerText = 'null';

    tabmfe34_quantidade_banco_1.innerText = 'null';
    tabmfe34_quantidade_banco_2.innerText = 'null';

    tabmfe35_quantidade_banco_1.innerText = 'null';
    tabmfe35_quantidade_banco_2.innerText = 'null';

    tabmfe36_quantidade_banco_1.innerText = 'null';
    tabmfe36_quantidade_banco_2.innerText = 'null';

    tabmfe37_quantidade_banco_1.innerText = 'null';
    tabmfe37_quantidade_banco_2.innerText = 'null';

    tabmfe38_quantidade_banco_1.innerText = 'null';
    tabmfe38_quantidade_banco_2.innerText = 'null';

    tabmfe39_quantidade_banco_1.innerText = 'null';
    tabmfe39_quantidade_banco_2.innerText = 'null';

    tabmfe40_quantidade_banco_1.innerText = 'null';
    tabmfe40_quantidade_banco_2.innerText = 'null';

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

            tabmil1_quantidade_banco_1.innerText = data.success.totais_banco_1.total_militares;
            tabmil1_quantidade_banco_2.innerText = data.success.totais_banco_2.total_militares;

            tabmil2_quantidade_banco_1.innerText = data.success.totais_banco_1.total_militares;
            tabmil2_quantidade_banco_2.innerText = data.success.totais_banco_2.total_militares;

            tabmil3_quantidade_banco_1.innerText = data.success.totais_banco_1.total_militares;
            tabmil3_quantidade_banco_2.innerText = data.success.totais_banco_2.total_militares;

            tabmil4_quantidade_banco_1.innerText = data.success.totais_banco_1.total_militares;
            tabmil4_quantidade_banco_2.innerText = data.success.totais_banco_2.total_militares;

            tabcur_quantidade_banco_1.innerText = data.success.totais_banco_1.total_cursos;
            tabcur_quantidade_banco_2.innerText = data.success.totais_banco_2.total_cursos;

            tabcco1_quantidade_banco_1.innerText = data.success.totais_banco_1.total_militares_cursos;
            tabcco1_quantidade_banco_2.innerText = data.success.totais_banco_2.total_militares_cursos;

            tabcco2_quantidade_banco_1.innerText = data.success.totais_banco_1.total_militares_cursos;
            tabcco2_quantidade_banco_2.innerText = data.success.totais_banco_2.total_militares_cursos;

            tabcco3_quantidade_banco_1.innerText = data.success.totais_banco_1.total_militares_cursos;
            tabcco3_quantidade_banco_2.innerText = data.success.totais_banco_2.total_militares_cursos;

            tabcco4_quantidade_banco_1.innerText = data.success.totais_banco_1.total_militares_cursos;
            tabcco4_quantidade_banco_2.innerText = data.success.totais_banco_2.total_militares_cursos;

            tabcco5_quantidade_banco_1.innerText = data.success.totais_banco_1.total_militares_cursos;
            tabcco5_quantidade_banco_2.innerText = data.success.totais_banco_2.total_militares_cursos;

            tabcco6_quantidade_banco_1.innerText = data.success.totais_banco_1.total_militares_cursos;
            tabcco6_quantidade_banco_2.innerText = data.success.totais_banco_2.total_militares_cursos;

            tabcco7_quantidade_banco_1.innerText = data.success.totais_banco_1.total_militares_cursos;
            tabcco7_quantidade_banco_2.innerText = data.success.totais_banco_2.total_militares_cursos;

            tabcco8_quantidade_banco_1.innerText = data.success.totais_banco_1.total_militares_cursos;
            tabcco8_quantidade_banco_2.innerText = data.success.totais_banco_2.total_militares_cursos;

            tabacu_quantidade_banco_1.innerText = data.success.totais_banco_1.total_militares_ajudas_custos;
            tabacu_quantidade_banco_2.innerText = data.success.totais_banco_2.total_militares_ajudas_custos;

            tabaxf1_quantidade_banco_1.innerText = data.success.totais_banco_1.total_militares_auxilios_fardamentos;
            tabaxf1_quantidade_banco_2.innerText = data.success.totais_banco_2.total_militares_auxilios_fardamentos;

            tabaxf2_quantidade_banco_1.innerText = data.success.totais_banco_1.total_militares_auxilios_fardamentos;
            tabaxf2_quantidade_banco_2.innerText = data.success.totais_banco_2.total_militares_auxilios_fardamentos;

            tabaxf3_quantidade_banco_1.innerText = data.success.totais_banco_1.total_militares_auxilios_fardamentos;
            tabaxf3_quantidade_banco_2.innerText = data.success.totais_banco_2.total_militares_auxilios_fardamentos;

            tabfsa1_quantidade_banco_1.innerText = data.success.totais_banco_1.total_militares_fundos_saude;
            tabfsa1_quantidade_banco_2.innerText = data.success.totais_banco_2.total_militares_fundos_saude;

            tabfsa2_quantidade_banco_1.innerText = data.success.totais_banco_1.total_militares_fundos_saude;
            tabfsa2_quantidade_banco_2.innerText = data.success.totais_banco_2.total_militares_fundos_saude;

            tabfsa3_quantidade_banco_1.innerText = data.success.totais_banco_1.total_militares_fundos_saude;
            tabfsa3_quantidade_banco_2.innerText = data.success.totais_banco_2.total_militares_fundos_saude;

            tabfsa4_quantidade_banco_1.innerText = data.success.totais_banco_1.total_militares_fundos_saude;
            tabfsa4_quantidade_banco_2.innerText = data.success.totais_banco_2.total_militares_fundos_saude;

            tabfsc_quantidade_banco_1.innerText = data.success.totais_banco_1.total_militares_fundos_saude_controle;
            tabfsc_quantidade_banco_2.innerText = data.success.totais_banco_2.total_militares_fundos_saude_controle;

            tabfsd_quantidade_banco_1.innerText = data.success.totais_banco_1.total_militares_fundos_saude_adesao;
            tabfsd_quantidade_banco_2.innerText = data.success.totais_banco_2.total_militares_fundos_saude_adesao;

            tabpar_quantidade_banco_1.innerText = data.success.totais_banco_1.total_parentescos;
            tabpar_quantidade_banco_2.innerText = data.success.totais_banco_2.total_parentescos;

            tabtal_quantidade_banco_1.innerText = data.success.totais_banco_1.total_tempos_averbados_locais;
            tabtal_quantidade_banco_2.innerText = data.success.totais_banco_2.total_tempos_averbados_locais;

            tabmde1_quantidade_banco_1.innerText = data.success.totais_banco_1.total_militares_dependentes;
            tabmde1_quantidade_banco_2.innerText = data.success.totais_banco_2.total_militares_dependentes;

            tabmde2_quantidade_banco_1.innerText = data.success.totais_banco_1.total_militares_dependentes;
            tabmde2_quantidade_banco_2.innerText = data.success.totais_banco_2.total_militares_dependentes;

            tabmde3_quantidade_banco_1.innerText = data.success.totais_banco_1.total_militares_dependentes;
            tabmde3_quantidade_banco_2.innerText = data.success.totais_banco_2.total_militares_dependentes;

            tabmde4_quantidade_banco_1.innerText = data.success.totais_banco_1.total_militares_dependentes;
            tabmde4_quantidade_banco_2.innerText = data.success.totais_banco_2.total_militares_dependentes;

            tabmde5_quantidade_banco_1.innerText = data.success.totais_banco_1.total_militares_dependentes;
            tabmde5_quantidade_banco_2.innerText = data.success.totais_banco_2.total_militares_dependentes;

            tabmde6_quantidade_banco_1.innerText = data.success.totais_banco_1.total_militares_dependentes;
            tabmde6_quantidade_banco_2.innerText = data.success.totais_banco_2.total_militares_dependentes;

            tabmde7_quantidade_banco_1.innerText = data.success.totais_banco_1.total_militares_dependentes;
            tabmde7_quantidade_banco_2.innerText = data.success.totais_banco_2.total_militares_dependentes;

            tabmfe1_quantidade_banco_1.innerText = data.success.totais_banco_1.total_militares_ferias;
            tabmfe1_quantidade_banco_2.innerText = data.success.totais_banco_2.total_militares_ferias;

            tabmfe2_quantidade_banco_1.innerText = data.success.totais_banco_1.total_militares_ferias;
            tabmfe2_quantidade_banco_2.innerText = data.success.totais_banco_2.total_militares_ferias;

            tabmfe3_quantidade_banco_1.innerText = data.success.totais_banco_1.total_militares_ferias;
            tabmfe3_quantidade_banco_2.innerText = data.success.totais_banco_2.total_militares_ferias;

            tabmfe4_quantidade_banco_1.innerText = data.success.totais_banco_1.total_militares_ferias;
            tabmfe4_quantidade_banco_2.innerText = data.success.totais_banco_2.total_militares_ferias;

            tabmfe5_quantidade_banco_1.innerText = data.success.totais_banco_1.total_militares_ferias;
            tabmfe5_quantidade_banco_2.innerText = data.success.totais_banco_2.total_militares_ferias;

            tabmfe6_quantidade_banco_1.innerText = data.success.totais_banco_1.total_militares_ferias;
            tabmfe6_quantidade_banco_2.innerText = data.success.totais_banco_2.total_militares_ferias;

            tabmfe7_quantidade_banco_1.innerText = data.success.totais_banco_1.total_militares_ferias;
            tabmfe7_quantidade_banco_2.innerText = data.success.totais_banco_2.total_militares_ferias;

            tabmfe8_quantidade_banco_1.innerText = data.success.totais_banco_1.total_militares_ferias;
            tabmfe8_quantidade_banco_2.innerText = data.success.totais_banco_2.total_militares_ferias;

            tabmfe9_quantidade_banco_1.innerText = data.success.totais_banco_1.total_militares_ferias;
            tabmfe9_quantidade_banco_2.innerText = data.success.totais_banco_2.total_militares_ferias;

            tabmfe10_quantidade_banco_1.innerText = data.success.totais_banco_1.total_militares_ferias;
            tabmfe10_quantidade_banco_2.innerText = data.success.totais_banco_2.total_militares_ferias;

            tabmfe11_quantidade_banco_1.innerText = data.success.totais_banco_1.total_militares_ferias;
            tabmfe11_quantidade_banco_2.innerText = data.success.totais_banco_2.total_militares_ferias;

            tabmfe12_quantidade_banco_1.innerText = data.success.totais_banco_1.total_militares_ferias;
            tabmfe12_quantidade_banco_2.innerText = data.success.totais_banco_2.total_militares_ferias;

            tabmfe13_quantidade_banco_1.innerText = data.success.totais_banco_1.total_militares_ferias;
            tabmfe13_quantidade_banco_2.innerText = data.success.totais_banco_2.total_militares_ferias;

            tabmfe14_quantidade_banco_1.innerText = data.success.totais_banco_1.total_militares_ferias;
            tabmfe14_quantidade_banco_2.innerText = data.success.totais_banco_2.total_militares_ferias;

            tabmfe15_quantidade_banco_1.innerText = data.success.totais_banco_1.total_militares_ferias;
            tabmfe15_quantidade_banco_2.innerText = data.success.totais_banco_2.total_militares_ferias;

            tabmfe16_quantidade_banco_1.innerText = data.success.totais_banco_1.total_militares_ferias;
            tabmfe16_quantidade_banco_2.innerText = data.success.totais_banco_2.total_militares_ferias;

            tabmfe17_quantidade_banco_1.innerText = data.success.totais_banco_1.total_militares_ferias;
            tabmfe17_quantidade_banco_2.innerText = data.success.totais_banco_2.total_militares_ferias;

            tabmfe18_quantidade_banco_1.innerText = data.success.totais_banco_1.total_militares_ferias;
            tabmfe18_quantidade_banco_2.innerText = data.success.totais_banco_2.total_militares_ferias;

            tabmfe19_quantidade_banco_1.innerText = data.success.totais_banco_1.total_militares_ferias;
            tabmfe19_quantidade_banco_2.innerText = data.success.totais_banco_2.total_militares_ferias;

            tabmfe20_quantidade_banco_1.innerText = data.success.totais_banco_1.total_militares_ferias;
            tabmfe20_quantidade_banco_2.innerText = data.success.totais_banco_2.total_militares_ferias;

            tabmfe21_quantidade_banco_1.innerText = data.success.totais_banco_1.total_militares_ferias;
            tabmfe21_quantidade_banco_2.innerText = data.success.totais_banco_2.total_militares_ferias;

            tabmfe22_quantidade_banco_1.innerText = data.success.totais_banco_1.total_militares_ferias;
            tabmfe22_quantidade_banco_2.innerText = data.success.totais_banco_2.total_militares_ferias;

            tabmfe23_quantidade_banco_1.innerText = data.success.totais_banco_1.total_militares_ferias;
            tabmfe23_quantidade_banco_2.innerText = data.success.totais_banco_2.total_militares_ferias;

            tabmfe24_quantidade_banco_1.innerText = data.success.totais_banco_1.total_militares_ferias;
            tabmfe24_quantidade_banco_2.innerText = data.success.totais_banco_2.total_militares_ferias;

            tabmfe25_quantidade_banco_1.innerText = data.success.totais_banco_1.total_militares_ferias;
            tabmfe25_quantidade_banco_2.innerText = data.success.totais_banco_2.total_militares_ferias;

            tabmfe26_quantidade_banco_1.innerText = data.success.totais_banco_1.total_militares_ferias;
            tabmfe26_quantidade_banco_2.innerText = data.success.totais_banco_2.total_militares_ferias;

            tabmfe27_quantidade_banco_1.innerText = data.success.totais_banco_1.total_militares_ferias;
            tabmfe27_quantidade_banco_2.innerText = data.success.totais_banco_2.total_militares_ferias;

            tabmfe28_quantidade_banco_1.innerText = data.success.totais_banco_1.total_militares_ferias;
            tabmfe28_quantidade_banco_2.innerText = data.success.totais_banco_2.total_militares_ferias;

            tabmfe29_quantidade_banco_1.innerText = data.success.totais_banco_1.total_militares_ferias;
            tabmfe29_quantidade_banco_2.innerText = data.success.totais_banco_2.total_militares_ferias;

            tabmfe30_quantidade_banco_1.innerText = data.success.totais_banco_1.total_militares_ferias;
            tabmfe30_quantidade_banco_2.innerText = data.success.totais_banco_2.total_militares_ferias;

            tabmfe31_quantidade_banco_1.innerText = data.success.totais_banco_1.total_militares_ferias;
            tabmfe31_quantidade_banco_2.innerText = data.success.totais_banco_2.total_militares_ferias;

            tabmfe32_quantidade_banco_1.innerText = data.success.totais_banco_1.total_militares_ferias;
            tabmfe32_quantidade_banco_2.innerText = data.success.totais_banco_2.total_militares_ferias;

            tabmfe33_quantidade_banco_1.innerText = data.success.totais_banco_1.total_militares_ferias;
            tabmfe33_quantidade_banco_2.innerText = data.success.totais_banco_2.total_militares_ferias;

            tabmfe34_quantidade_banco_1.innerText = data.success.totais_banco_1.total_militares_ferias;
            tabmfe34_quantidade_banco_2.innerText = data.success.totais_banco_2.total_militares_ferias;

            tabmfe35_quantidade_banco_1.innerText = data.success.totais_banco_1.total_militares_ferias;
            tabmfe35_quantidade_banco_2.innerText = data.success.totais_banco_2.total_militares_ferias;

            tabmfe36_quantidade_banco_1.innerText = data.success.totais_banco_1.total_militares_ferias;
            tabmfe36_quantidade_banco_2.innerText = data.success.totais_banco_2.total_militares_ferias;

            tabmfe37_quantidade_banco_1.innerText = data.success.totais_banco_1.total_militares_ferias;
            tabmfe37_quantidade_banco_2.innerText = data.success.totais_banco_2.total_militares_ferias;

            tabmfe38_quantidade_banco_1.innerText = data.success.totais_banco_1.total_militares_ferias;
            tabmfe38_quantidade_banco_2.innerText = data.success.totais_banco_2.total_militares_ferias;

            tabmfe39_quantidade_banco_1.innerText = data.success.totais_banco_1.total_militares_ferias;
            tabmfe39_quantidade_banco_2.innerText = data.success.totais_banco_2.total_militares_ferias;

            tabmfe40_quantidade_banco_1.innerText = data.success.totais_banco_1.total_militares_ferias;
            tabmfe40_quantidade_banco_2.innerText = data.success.totais_banco_2.total_militares_ferias;

            tabmpe1_quantidade_banco_1.innerText = data.success.totais_banco_1.total_militares_pensoes;
            tabmpe1_quantidade_banco_2.innerText = data.success.totais_banco_2.total_militares_pensoes;

            tabmpe2_quantidade_banco_1.innerText = data.success.totais_banco_1.total_militares_pensoes;
            tabmpe2_quantidade_banco_2.innerText = data.success.totais_banco_2.total_militares_pensoes;

            tabmta_quantidade_banco_1.innerText = data.success.totais_banco_1.total_militares_tempos_averbados;
            tabmta_quantidade_banco_2.innerText = data.success.totais_banco_2.total_militares_tempos_averbados;

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
                Number(data.success.totais_banco_1.total_militares_dependentes) +
                Number(data.success.totais_banco_1.total_militares_ferias) +
                Number(data.success.totais_banco_1.total_tempos_averbados_locais) +
                Number(data.success.totais_banco_1.total_militares_tempos_averbados) +
                Number(data.success.totais_banco_1.total_militares_pensoes);

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
                Number(data.success.totais_banco_2.total_militares_dependentes) +
                Number(data.success.totais_banco_2.total_militares_ferias) +
                Number(data.success.totais_banco_2.total_tempos_averbados_locais) +
                Number(data.success.totais_banco_2.total_militares_tempos_averbados) +
                Number(data.success.totais_banco_2.total_militares_pensoes);

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

        // Cursos
        await impsacAtualizarDados('cursos');

        // Parentescos
        await impsacAtualizarDados('parentescos');

        // Tempos Averbados Locais
        await impsacAtualizarDados('tempos_averbados_locais');

        // Militares 1
        await impsacAtualizarDados('militares_1');

        // Militares 2
        await impsacAtualizarDados('militares_2');

        // Militares 3
        await impsacAtualizarDados('militares_3');

        // Militares 4
        await impsacAtualizarDados('militares_4');

        // Militares Cursos 1
        await impsacAtualizarDados('militares_cursos_1');

        // Militares Cursos 2
        await impsacAtualizarDados('militares_cursos_2');

        // Militares Cursos 3
        await impsacAtualizarDados('militares_cursos_3');

        // Militares Cursos 4
        await impsacAtualizarDados('militares_cursos_4');

        // Militares Cursos 5
        await impsacAtualizarDados('militares_cursos_5');

        // Militares Cursos 6
        await impsacAtualizarDados('militares_cursos_6');

        // Militares Cursos 7
        await impsacAtualizarDados('militares_cursos_7');

        // Militares Cursos 8
        await impsacAtualizarDados('militares_cursos_8');

        // Militares Ajudas Custos
        await impsacAtualizarDados('militares_ajudas_custos');

        // Militares Auxílios Fardamentos 1
        await impsacAtualizarDados('militares_auxilios_fardamentos_1');

        // Militares Auxílios Fardamentos 2
        await impsacAtualizarDados('militares_auxilios_fardamentos_2');

        // Militares Auxílios Fardamentos 3
        await impsacAtualizarDados('militares_auxilios_fardamentos_3');

        // Militares Fundos Saúde 1
        await impsacAtualizarDados('militares_fundos_saude_1');

        // Militares Fundos Saúde 2
        await impsacAtualizarDados('militares_fundos_saude_2');

        // Militares Fundos Saúde 3
        await impsacAtualizarDados('militares_fundos_saude_3');

        // Militares Fundos Saúde 4
        await impsacAtualizarDados('militares_fundos_saude_4');

        // Militares Fundos Saúde Controle
        await impsacAtualizarDados('militares_fundos_saude_controle');

        // Militares Fundos Saúde Adesão
        await impsacAtualizarDados('militares_fundos_saude_adesao');

        // Militares Dependentes 1
        await impsacAtualizarDados('militares_dependentes_1');

        // Militares Dependentes 2
        await impsacAtualizarDados('militares_dependentes_2');

        // Militares Dependentes 3
        await impsacAtualizarDados('militares_dependentes_3');

        // Militares Dependentes 4
        await impsacAtualizarDados('militares_dependentes_4');

        // Militares Dependentes 5
        await impsacAtualizarDados('militares_dependentes_5');

        // Militares Dependentes 6
        await impsacAtualizarDados('militares_dependentes_6');

        // Militares Dependentes 7
        await impsacAtualizarDados('militares_dependentes_7');

        // Militares Tempos Averbados
        await impsacAtualizarDados('militares_tempos_averbados');

        // Militares Pensoes 1
        await impsacAtualizarDados('militares_pensoes_1');

        // Militares Pensoes 2
        await impsacAtualizarDados('militares_pensoes_2');

        // Militares Férias 1
        await impsacAtualizarDados('militares_ferias_1');

        // Militares Férias 2
        await impsacAtualizarDados('militares_ferias_2');

        // Militares Férias 3
        await impsacAtualizarDados('militares_ferias_3');

        // Militares Férias 4
        await impsacAtualizarDados('militares_ferias_4');

        // Militares Férias 5
        await impsacAtualizarDados('militares_ferias_5');

        // Militares Férias 6
        await impsacAtualizarDados('militares_ferias_6');

        // Militares Férias 7
        await impsacAtualizarDados('militares_ferias_7');

        // Militares Férias 8
        await impsacAtualizarDados('militares_ferias_8');

        // Militares Férias 9
        await impsacAtualizarDados('militares_ferias_9');

        // Militares Férias 10
        await impsacAtualizarDados('militares_ferias_10');

        // Militares Férias 11
        await impsacAtualizarDados('militares_ferias_11');

        // Militares Férias 12
        await impsacAtualizarDados('militares_ferias_12');

        // Militares Férias 13
        await impsacAtualizarDados('militares_ferias_13');

        // Militares Férias 14
        await impsacAtualizarDados('militares_ferias_14');

        // Militares Férias 15
        await impsacAtualizarDados('militares_ferias_15');

        // Militares Férias 16
        await impsacAtualizarDados('militares_ferias_16');

        // Militares Férias 17
        await impsacAtualizarDados('militares_ferias_17');

        // Militares Férias 18
        await impsacAtualizarDados('militares_ferias_18');

        // Militares Férias 19
        await impsacAtualizarDados('militares_ferias_19');

        // Militares Férias 20
        await impsacAtualizarDados('militares_ferias_20');

        // Militares Férias 21
        await impsacAtualizarDados('militares_ferias_21');

        // Militares Férias 22
        await impsacAtualizarDados('militares_ferias_22');

        // Militares Férias 23
        await impsacAtualizarDados('militares_ferias_23');

        // Militares Férias 24
        await impsacAtualizarDados('militares_ferias_24');

        // Militares Férias 25
        await impsacAtualizarDados('militares_ferias_25');

        // Militares Férias 26
        await impsacAtualizarDados('militares_ferias_26');

        // Militares Férias 27
        await impsacAtualizarDados('militares_ferias_27');

        // Militares Férias 28
        await impsacAtualizarDados('militares_ferias_28');

        // Militares Férias 29
        await impsacAtualizarDados('militares_ferias_29');

        // Militares Férias 30
        await impsacAtualizarDados('militares_ferias_30');

        // Militares Férias 31
        await impsacAtualizarDados('militares_ferias_31');

        // Militares Férias 32
        await impsacAtualizarDados('militares_ferias_32');

        // Militares Férias 33
        await impsacAtualizarDados('militares_ferias_33');

        // Militares Férias 34
        await impsacAtualizarDados('militares_ferias_34');

        // Militares Férias 35
        await impsacAtualizarDados('militares_ferias_35');

        // Militares Férias 36
        await impsacAtualizarDados('militares_ferias_36');

        // Militares Férias 37
        await impsacAtualizarDados('militares_ferias_37');

        // Militares Férias 38
        await impsacAtualizarDados('militares_ferias_38');

        // Militares Férias 39
        await impsacAtualizarDados('militares_ferias_39');

        // Militares Férias 40
        await impsacAtualizarDados('militares_ferias_40');
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
