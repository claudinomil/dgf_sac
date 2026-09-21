//Funções para API Google - Início''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
//Funções para API Google - Início''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

/*
Retorna endereço via CEP
Ex: const addressOrigem = await getAddressFromCep(cepOrigem);
*/
async function getAddressFromCep(cep) {
    const url = `https://viacep.com.br/ws/${cep}/json/`;
    const response = await fetch(url);
    const data = await response.json();

    if (!data.erro) {
        return `${data.logradouro}, ${data.bairro}, ${data.localidade}, ${data.uf}, Brasil`;
    } else {
        console.log(`CEP ${cep} não encontrado`);
    }
}

/*
API Google
Retorna coordenadas via endereço
*/
async function getCoordinatesFromAddress(address) {
    const apiKey = 'AIzaSyCySX2x8e-TEfua6M1gZG1vNGIYng1av4g';

    const url = `https://maps.googleapis.com/maps/api/geocode/json?address=${encodeURIComponent(address)}&key=${apiKey}`;
    const response = await fetch(url);
    const data = await response.json();

    if (data.status === "OK" && data.results.length > 0) {
        const location = data.results[0].geometry.location;
        return { lat: location.lat, lon: location.lng };
    } else {
        console.log(`Coordenadas não encontradas para: ${address}`);
    }
}

/*
API Google
Retorna Distância e Duração entre dois pontos
*/
async function pegarDistanciaDuracao(lat1, lon1, lat2, lon2) {
    const origem = `${lat1},${lon1}`;
    const destino = `${lat2},${lon2}`;
    const url = `/build/proxy-directions.php?origem=${origem}&destino=${destino}`; // usando seu proxy PHP

    const resposta = await fetch(url);
    const dados = await resposta.json();

    if (dados.routes?.length) {
        const distancia = dados.routes[0].legs[0].distance.text;
        const duracao = dados.routes[0].legs[0].duration.text;
        return { distancia, duracao };
    } else {
        console.log("Não foi possível obter a distância.");
    }
}

/*
API Google
Retorna a rota entre dois pontos passo a passo
*/
async function pegarRotaPassoAPasso(lat1, lon1, lat2, lon2, comHtml = false) {
    const origem = `${lat1},${lon1}`;
    const destino = `${lat2},${lon2}`;
    const url = `/build/proxy-directions.php?origem=${origem}&destino=${destino}`;

    const resposta = await fetch(url);
    const dados = await resposta.json();

    if (dados.routes?.length) {
        const passos = dados.routes[0].legs[0].steps;

        const rota = passos.map((step, index) => {
            let instrucao = step.html_instructions;
            const distancia = step.distance.text;

            if (!comHtml) {
                // Substitui <div ...> por \n e remove todas as tags HTML restantes
                instrucao = instrucao
                    .replace(/<div[^>]*>/gi, ', ')
                    .replace(/<\/div>/gi, '')
                    .replace(/<[^>]+>/g, ''); // Remove o restante das tags HTML
            }

            return `${index + 1}. ${instrucao.trim()} (${distancia})`;
        });

        return rota;
    } else {
        console.log("Não foi possível obter a rota.");
    }
}

/*
API Google
Retorna Imagem Base64 de dois pontos em um mapa
*/
async function gerarMapaBase64(lat1, lon1, lat2, lon2) {
    const url = `/build/gerar-mapa.php?lat1=${lat1}&lon1=${lon1}&lat2=${lat2}&lon2=${lon2}`;
    const res = await fetch(url);
    const dados = await res.json();

    if (dados.status === "ok") {
        return dados.base64; // isso você pode jogar direto no jsPDF
    } else {
        console.log("Erro ao gerar imagem base64.");
    }
}

/*
API Google
Retorna tradução de texto
*/
async function traduzirTextoGoogle(texto, idiomaOrigem = 'pt', idiomaDestino = 'en') {
    if (texto == '' || texto === null) {return '';}

    const apiKey = 'AIzaSyBGeQFWQ6kFJ9hnXvogPLtmYXJHVuM6U78';
    const url = `https://translation.googleapis.com/language/translate/v2?key=${apiKey}`;
    const body = {q: texto, source: idiomaOrigem, target: idiomaDestino, format: 'text'};

    try {
        const response = await fetch(url, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(body)
        });

        const data = await response.json();

        if (data.data && data.data.translations && data.data.translations.length > 0) {
            return data.data.translations[0].translatedText;
        } else {
            console.log('Tradução não encontrada.');
            return texto;
        }
    } catch (erro) {
        console.error('Erro na tradução:', erro);
        return null;
    }
}

//Distância e Duração
async function distanciaDuracaoPontos(cepOrigem, cepDestino) {
    try {
        //Pegar Endereco dos CEPs
        const addressOrigem = await getAddressFromCep(cepOrigem);
        const addressDestino = await getAddressFromCep(cepDestino);

        //Pegar Coordenadas dos Endereços
        const coordsOrigem = await getCoordinatesFromAddress(addressOrigem);
        const coordsDestino = await getCoordinatesFromAddress(addressDestino);

        //Pegar distância e duração
        const distanciaDuracao = await pegarDistanciaDuracao(coordsOrigem.lat, coordsOrigem.lon, coordsDestino.lat, coordsDestino.lon);
        return distanciaDuracao;
    } catch (error) {
        console.error("Erro:", error);
    }
}

//Rota Passo-a-Passo
async function rotaPassoAPasso(cepOrigem, cepDestino) {
    try {
        // Pegar Endereco dos CEPs
        const addressOrigem = await getAddressFromCep(cepOrigem);
        const addressDestino = await getAddressFromCep(cepDestino);

        // Pegar Coordenadas dos Endereços
        const coordsOrigem = await getCoordinatesFromAddress(addressOrigem);
        const coordsDestino = await getCoordinatesFromAddress(addressDestino);

        // Pegar passos da rota e RETORNAR!
        const rota = await pegarRotaPassoAPasso(coordsOrigem.lat, coordsOrigem.lon, coordsDestino.lat, coordsDestino.lon);

        return rota;

    } catch (error) {
        console.error("Erro:", error);
        throw error; // repassa o erro para o .catch de fora, se necessário
    }
}

//Gerar imagem Mapa
async function gerarMapaImagem(cepOrigem, cepDestino) {
    try {
        //Pegar Endereco dos CEPs
        const addressOrigem = await getAddressFromCep(cepOrigem);
        const addressDestino = await getAddressFromCep(cepDestino);

        //Pegar Coordenadas dos Endereços
        const coordsOrigem = await getCoordinatesFromAddress(addressOrigem);
        const coordsDestino = await getCoordinatesFromAddress(addressDestino);

        //Mapa
        const imagemBase64 = await gerarMapaBase64(coordsOrigem.lat, coordsOrigem.lon, coordsDestino.lat, coordsDestino.lon);

        return imagemBase64;
    } catch (error) {
        console.error("Erro:", error);
    }
}
//Funções para API Google - Fim'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
//Funções para API Google - Fim'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

//API FOGO CRUZADO''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
const apiFogoCruzadoLogin = async () => {
    const response = await fetch('https://api-service.fogocruzado.org.br/api/v2/auth/login', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
            email: 'claudinomilhomens@gmail.com',
            password: 'claudino1971'
        })
    });

    if (!response.ok) {
        alert('Erro apiFogoCruzadoLogin: ', response.status);
        return null;
    }

    const data = await response.json();

    return data.data.accessToken;
};

const apiFogoCruzadoOccurrences = async (token, data_inicio, data_fim, cidade_id) => {
    //INFORMAÇÕES DE USO
    var estado_id_rj = "b112ffbe-17b3-4ad0-8f2a-2038745d1d14";

    /*
    IDs das Cidades
    var cidade_id_belford_roxo = "88959ad9-b2f5-4a33-a8ec-ceff5a572ca5";
    var cidade_id_cachoeiras_de_macacu = "9d7b569c-ec84-4908-96ab-3706ec3bfc57";
    var cidade_id_duque_de_caxias = "2cded3bc-5dfa-425b-a274-5c1a4b8838d5";
    var cidade_id_guapimirim = "b920f9ed-fa79-4fc0-bc53-ceb14598fa45";
    var cidade_id_itaborai = "74000596-0e8d-4762-af55-6fba1db74ceb";
    var cidade_id_itaguai = "e6aa9117-3816-4f42-a7da-1b4b8eef6cdd";
    var cidade_id_japeri = "dbd21829-f83c-4479-86c8-3f2953021740";
    var cidade_id_mage = "d4231ca8-3c08-42e2-b877-ad00cc49cecf";
    var cidade_id_marica = "bd078555-2b04-4e46-a637-e87d70551a04";
    var cidade_id_mesquita = "5a86d707-02ec-4e09-b497-b000b22f156b";
    var cidade_id_nilopolis = "2a69c719-bffc-4839-b832-1ac02b9e873f";
    var cidade_id_niteroi = "07335d05-e371-42fd-a8f0-42853ccf1a0f";
    var cidade_id_nova_iguacu = "7ab2a9b5-7727-4460-8007-eb58b78cc7c9";
    var cidade_id_paracambi = "6752c981-6a86-4e34-a484-f8b1e2228393";
    var cidade_id_queimados = "17d2880a-2295-4a24-a480-96d9fa0d40d4";
    var cidade_id_rio_bonito = "712f930a-db93-4363-a3c9-9eccc4f12a5f";
    var cidade_id_rio_de_janeiro = "d1bf56cc-6d85-4e6a-a5f5-0ab3f4074be3";
    var cidade_id_sao_goncalo = "ab6bc6ed-952f-48f9-ad84-cbfd3dde53ba";
    var cidade_id_sao_joao_de_meriti = "82f35929-e84c-4842-8181-1dc45a22785f";
    var cidade_id_seropedica = "7ee9135d-6f6a-4f95-91bb-c3a5021d409a";
    var cidade_id_tangua = "c46741dc-bdd2-43d0-92fc-f4d95ed61bf1";
    */

    /*
    EXEMPLOS:

    Filtrando por várias cidades:
    https://api-service.fogocruzado.org.br/api/v2/occurrences
    ?order=ASC
    &page=1
    &take=20
    &idState=813ca36b-91e3-4a18-b408-60b27a1942ef
    &idCities=d79d2347-bd0d-40aa-8dcc-04134cffd988
    &idCities=e37f7ad7-cd64-4279-946a-8d689b9b934b

    Filtrando por data:
    https://api-service.fogocruzado.org.br/api/v2/occurrences
    ?initialdate=2023-01-01
    &finaldate=2023-07-13
    &idState=b112ffbe-17b3-4ad0-8f2a-2038745d1d14
    &typeOccurrence=withVictim
    */

    var url = "";

    url += "https://api-service.fogocruzado.org.br/api/v2/occurrences";
    url += "?initialdate="+data_inicio;
    url += "&finaldate="+data_fim;
    url += "&idState="+estado_id_rj;
    url += "&idCities="+cidade_id;
    //url += "&idCities="+cidade_id_niteroi;

    const response = await fetch(url, {
        method: 'GET',
        headers: { 'Authorization': 'Bearer ' + token }
    });

    if (!response.ok) {
        alert('Erro apiFogoCruzadoOccurrences: ', response.status);
        return;
    }

    return await response.json();
};

const apiFogoCruzadoMain = async (data_inicio, data_fim, cidade_id) => {
    const token = await apiFogoCruzadoLogin();

    if (token) {
        const ocorrencias = await apiFogoCruzadoOccurrences(token, data_inicio, data_fim, cidade_id);

        if (ocorrencias.code == 200) {
            return ocorrencias.data;
        } else {
            alert('Erro apiFogoCruzadoMain: ', ocorrencias.msg);
        }
    } else {
        alert('Erro apiFogoCruzadoMain: Token inválido.');
    }
};

//apiFogoCruzadoMain(data_inicio, data_fim, cidade_id);
//''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

/*
* Função para Gerar PDF com a Biblioteca jsPDF
* Gera Pdf com Tabela de Registros
* @PARAM p_orientation (p = Retrato / l = Paisagem)
* @PARAM p_header (true = Vai ter Cabeçalho / false = Não vai ter Cabeçalho)
* @PARAM p_topo_1 (true = Vai usar o Topo 1 / false = Não vai usar o Topo 1)
* @PARAM p_topo_2 (true = Vai usar o Topo 2 / false = Não vai usar o Topo 2)
* @PARAM p_nome='Relatório (Nome do Relatório)
* @PARAM p_parametros (true = Vai usar Parâmetros / false = Não vai usar Parâmetros)
* @PARAM p_parametros_texto (Parâmetros)
* @PARAM p_dadosTableCabecalho (Array com Nomes das Colunas)
* @PARAM p_dadosTableLinhas (Array com Dados)
* @PARAM p_columnStyles (Styles para cada Coluna individualmente)
* @PARAM p_footer (true = Vai usar Rodapé / false = Não vai usar Rodapé)
* @PARAM p_data (Data da Geração do Relatório)
* @PARAM p_hora (Hora da Geração do Relatório)
 */
function gerarPdfTabela({p_orientation='p', p_header=true, p_topo_1=false, p_topo_2=true, p_nome='Relatório', p_parametros=true, p_parametros_texto='Parâmetros aqui...', p_dadosTableCabecalho=[], p_dadosTableLinhas=[], p_columnStyles={}, p_footer=true, p_data='', p_hora=''}) {
    //Configurações
    if (!window.jsPDF) window.jsPDF = window.jspdf.jsPDF;
    if (!window.autoTable) window.autoTable = window.jspdf.autoTable;

    //Iniciando jsPDF
    var doc = new jsPDF({orientation: p_orientation});

    //Variáveis
    var pageHeight = doc.internal.pageSize.height || doc.internal.pageSize.getHeight();
    var pageWidth = doc.internal.pageSize.width || doc.internal.pageSize.getWidth();
    var totalPagesExp = '{total_pages_count_string}';

    //Margens Topo 1
    var topo_1_image_margin_left = 81;
    var topo_1_image_margin_top = 10;
    var topo_1_image_width = 50;
    var topo_1_image_height = 32;
    var topo_1_text_1_margin_top = topo_1_image_margin_top + topo_1_image_height + 5;
    var topo_1_text_2_margin_top = topo_1_image_margin_top + topo_1_image_height + 10;
    var topo_1_text_3_margin_top = topo_1_image_margin_top + topo_1_image_height + 15;

    //Margens Topo 2
    var topo_2_image_margin_left = 10;
    var topo_2_image_margin_top = 10;
    var topo_2_image_width = 27;
    var topo_2_image_height = 30;
    var topo_2_text_1_margin_left = topo_2_image_width + 20;
    var topo_2_text_2_margin_left = topo_2_image_width + 20;
    var topo_2_text_3_margin_left = topo_2_image_width + 20;
    var topo_2_text_1_margin_top = topo_2_image_margin_top + 10;
    var topo_2_text_2_margin_top = topo_2_image_margin_top + 17;
    var topo_2_text_3_margin_top = topo_2_image_margin_top + 24;

    //Margens Nome
    var nome_margin_top = 10;

    if (p_topo_1 === true) {
        nome_margin_top = nome_margin_top + topo_1_text_3_margin_top;
    }

    if (p_topo_2 === true) {
        nome_margin_top = nome_margin_top + topo_2_image_margin_top + topo_2_image_height;
    }

    //Margens Parâmetros
    var parametros_margin_top = nome_margin_top + 10;

    //Margens Table
    var table_margin_horizontal = 10;
    var table_margin_top = 10;
    var table_margin_bottom = 10;

    if (p_topo_1 === true) {
        table_margin_top = topo_1_text_3_margin_top + 10;
    }

    if (p_topo_2 === true) {
        table_margin_top = topo_2_text_3_margin_top + 10;
    }

    if (p_parametros === true) {
        var p_parametros_total_caracteres = p_parametros_texto.length;

        if (p_parametros_total_caracteres <= 80) {
            table_margin_top = parametros_margin_top + 4;
        } else if (p_parametros_total_caracteres > 80 && p_parametros_total_caracteres <= 160) {
            table_margin_top = parametros_margin_top + 8;
        } else if (p_parametros_total_caracteres > 160 && p_parametros_total_caracteres <= 240) {
            table_margin_top = parametros_margin_top + 12;
        } else if (p_parametros_total_caracteres > 240 && p_parametros_total_caracteres <= 320) {
            table_margin_top = parametros_margin_top + 16;
        } else if (p_parametros_total_caracteres > 320) {
            table_margin_top = parametros_margin_top + 20;
        }

        table_margin_bottom = 30;
    }

    //AutoTable
    doc.autoTable({
        //Table
        head: [p_dadosTableCabecalho[0]],
        body: p_dadosTableLinhas.slice(0),

        //Configurações
        theme: 'striped',
        margin: {horizontal: table_margin_horizontal, top: table_margin_top, bottom: table_margin_bottom},
        columnStyles: p_columnStyles,

        //Antes de começar a desenhar a página
        willDrawPage: function (data) {
            //Header
            if (p_header === true) {
                //Topo 1
                if (p_topo_1 === true) {
                    doc.setFontSize(11);
                    doc.addImage('build/assets/images/logo_governo_rj.png', 'PNG', topo_1_image_margin_left, topo_1_image_margin_top, topo_1_image_width, topo_1_image_height);
                    doc.text('Secretaria de Estado de Defesa Civil', pageWidth / 2, topo_1_text_1_margin_top, {align: 'center'});
                    doc.text('Corpo de Bombeiros Militar do Estado do Rio de Janeiro', pageWidth / 2, topo_1_text_2_margin_top, {align: 'center'});
                    doc.text('Diretoria Geral de Finanças', pageWidth / 2, topo_1_text_3_margin_top, {align: 'center'});
                }

                //Topo 2
                if (p_topo_2 === true) {
                    doc.setFontSize(11);
                    doc.addImage('build/assets/images/image_logo_relatorio.png', 'PNG', topo_2_image_margin_left, topo_2_image_margin_top, topo_2_image_width, topo_2_image_height);
                    doc.text('Secretaria de Estado de Defesa Civil', topo_2_text_1_margin_left, topo_2_text_1_margin_top);
                    doc.text('Corpo de Bombeiros Militar do Estado do Rio de Janeiro', topo_2_text_1_margin_left, topo_2_text_2_margin_top);
                    doc.text('Diretoria Geral de Finanças', topo_2_text_1_margin_left, topo_2_text_3_margin_top);
                }
            }

            //Nome
            if (doc.internal.getNumberOfPages() == 1) {
                doc.setFontSize(16);
                doc.text(p_nome, pageWidth / 2, nome_margin_top, {align: 'center'});
            }

            //Parâmetros
            if (doc.internal.getNumberOfPages() == 1) {
                if (p_parametros === true) {
                    doc.setFontSize(10);
                    doc.text(p_parametros_texto, 10, parametros_margin_top, {maxWidth: 180, align: 'justify'});
                }
            }
        },

        //Depois de desenhar a página
        didDrawPage: function (data) {
            //Footer
            if (p_footer === true) {
                var text = 'Página ' + doc.internal.getNumberOfPages();

                if (typeof doc.putTotalPages === 'function') {
                    text = text + ' de ' + totalPagesExp;
                }

                if (p_data != '') {text = text + '  -  '+ p_data;}

                if (p_hora != '') {text = text + ' às '+ p_hora;}

                //Margens
                if (p_orientation == 'p') {
                    var footer_text_1_margin_left = 105;
                    var footer_text_2_margin_left = 125;
                }

                if (p_orientation == 'l') {
                    var footer_text_1_margin_left = 150;
                    var footer_text_2_margin_left = 170;
                }

                doc.setFontSize(10);
                doc.text('Gerado pelo Sistema SAC - DGF', footer_text_1_margin_left, pageHeight - 15, {align: 'center'});
                doc.text(text, footer_text_2_margin_left, pageHeight - 10, {align: 'center'});
            }

            //Alterar variáveis a partir da página 2
            if (doc.internal.getNumberOfPages() >= 1) {
                data.settings.margin.top = nome_margin_top;
            }
        }
    });

    //Total page number
    if (typeof doc.putTotalPages === 'function') {
        doc.putTotalPages(totalPagesExp);
    }

    //Salvar o PDF gerado no lado do Cliente
    //doc.save('relatorio_pdf.pdf');

    //Converter o PDF para uma string de dados
    const pdfData = doc.output('datauristring');

    //Abra uma nova janela do navegador para visualizar o PDF
    window.open(pdfData, '_blank');
}








/*
* Função para Gerar PDF com a Biblioteca jsPDF
* Gera Pdf para funcionario_acao_1
 */
function funcionario_acao_1_gerar_pdf() {
    //Formulario campos
    const funcionario_acao_1_local = document.getElementById('funcionario_acao_1_local').value;
    const funcionario_acao_1_dias_horarios = document.getElementById('funcionario_acao_1_dias_horarios').value;
    const funcionario_acao_1_valor = document.getElementById('funcionario_acao_1_valor').value;

    //funcionarios_ids
    const funcionariosMarcados = document.querySelectorAll('input[name="funcionario_acao_1_funcionario_id"]:checked');
    const funcionarios_ids = Array.from(funcionariosMarcados).map(checkbox => checkbox.value);

    if (funcionario_acao_1_local == '' || funcionario_acao_1_dias_horarios == '' || funcionario_acao_1_valor == '' || funcionarios_ids.length <= 0) {
        alert('Escolha o Local, Data/Horário, Valor e pelo menos 1(um) Funcionário.');
    } else {
        //URL
        var url_atual = window.location.protocol + '//' + window.location.host + '/';

        //Acessar rota
        fetch(url_atual + 'funcionarios/funcionarioAcao1/funcionario_acao_1_gerar_pdf_dados/' + funcionarios_ids, {
            method: 'GET',
            headers: {'REQUEST-ORIGIN': 'fetch'}
        }).then(response => {
            return response.json();
        }).then(data => {
            //Lendo json
            let funcionariosDados = data;

            //Dados
            if (funcionariosDados.length <= 0) {
                alert('Nenhum dado encontrado para gerar PDF.');
            } else {
                //Configurações
                if (!window.jsPDF) window.jsPDF = window.jspdf.jsPDF;

                //Iniciando jsPDF
                var doc = new jsPDF({orientation: 'p'});

                //Setando Font
                doc.setFont("helvetica");

                //Variáveis (Geral)
                const pageHeight = doc.internal.pageSize.height || doc.internal.pageSize.getHeight();
                const pageWidth = doc.internal.pageSize.width || doc.internal.pageSize.getWidth();
                const funcionario_acao_1_local = document.getElementById('funcionario_acao_1_local').value;
                const funcionario_acao_1_dias_horarios = document.getElementById('funcionario_acao_1_dias_horarios').value;
                const funcionario_acao_1_valor = document.getElementById('funcionario_acao_1_valor').value;

                //Varrer Funcionários
                funcionariosDados.forEach((funcionarioDado, index) => {
                    if (index > 0) {
                        doc.addPage();
                    }

                    //Texto Contrato''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

                    //Configurações iniciais para texto do Contrato
                    const marginLeft = 20;
                    const marginRight = 190;
                    const marginTop = 20;
                    const textWidth = 170; // Largura máxima para o texto
                    const spacingBetweenTextsA = 5;
                    const spacingBetweenTextsB = 6;
                    const spacingBetweenTextsC = 10;
                    const spacingBetweenTextsD = 12;
                    const spacingBetweenTextsE = 15;

                    //Dados
                    const contratante_nome = 'CONSULTARIA MAIS COMÉRCIO E SERVIÇOS DE ENGENHARIA E ARQUITETURA LTDA';
                    const contratante_cnpj = '35.205.811/0001-03';
                    const contratante_endereco = 'Rua Aristides Lobo, nº 124, parte, Rio Comprido, Rio de Janeiro, RJ, CEP: 20250-450';
                    const contratante_representante = 'seu sócio MARCUS VINICIUS MACHADO DE OLIVEIRA, brasileiro, militar e empresário, casado, portador da carteira de identidade nº 008717697-0, expedida pelo Detran/RJ, inscrita no CPF sob o nº 023.824.687-69';
                    const contratado_nome = funcionarioDado.name;
                    const contratado_cpf = funcionarioDado.cpf;

                    var contratado_endereco = '';

                    if (funcionarioDado.cep !== null) {
                        contratado_endereco = funcionarioDado.logradouro + ', ' + funcionarioDado.numero + ', ' + funcionarioDado.complemento + ', ' + funcionarioDado.bairro + ', ' + funcionarioDado.localidade + ', ' + funcionarioDado.uf + ', ' + funcionarioDado.cep;
                    }

                    var novaMarginTop = 0;
                    var linhasTexto = 0;
                    var alturaTexto = 0;

                    //Texto
                    var texto = '';

                    //Texto
                    texto = `CONTRATO DE PRESTAÇÃO DE SERVIÇOS DE BOMBEIRO CIVIL`;

                    novaMarginTop = marginTop;
                    linhasTexto = doc.splitTextToSize(texto, textWidth);
                    alturaTexto = linhasTexto.length * spacingBetweenTextsB;

                    doc.setFont('helvetica', 'bold');
                    doc.setFontSize(14);
                    doc.text(texto, ((pageWidth - doc.getTextWidth(texto)) / 2), novaMarginTop);

                    //Texto
                    texto = `CONTRATANTE: ${contratante_nome}, devidamente inscrita no CNPJ de nº ${contratante_cnpj}, com sede na ${contratante_endereco}, neste ato representada por seu sócio ${contratante_representante}, doravante denominado CONTRATANTE.`;

                    novaMarginTop = novaMarginTop + alturaTexto + spacingBetweenTextsB;
                    linhasTexto = doc.splitTextToSize(texto, textWidth);
                    alturaTexto = linhasTexto.length * spacingBetweenTextsA;

                    if ((novaMarginTop + alturaTexto) > 270) {doc.addPage(); novaMarginTop = marginTop;}

                    doc.setFont('helvetica', 'normal');
                    doc.setFontSize(12);
                    doc.text(texto, marginLeft, novaMarginTop, { maxWidth: textWidth, align: 'justify' });

                    //Texto
                    texto = `CONTRATADO: ${contratado_nome}, inscrito(a) no CPF sob nº ${contratado_cpf}`;
                    if (contratado_endereco != '') {texto += `, com endereço em ${contratado_endereco}`;}
                    texto += `, doravante denominado CONTRATADO.`;

                    novaMarginTop = novaMarginTop + alturaTexto + spacingBetweenTextsA;
                    linhasTexto = doc.splitTextToSize(texto, textWidth);
                    alturaTexto = linhasTexto.length * spacingBetweenTextsA;

                    if ((novaMarginTop + alturaTexto) > 270) {doc.addPage(); novaMarginTop = marginTop;}

                    doc.setFont('helvetica', 'normal');
                    doc.setFontSize(12);
                    doc.text(texto, marginLeft, novaMarginTop, {maxWidth: textWidth, align: 'justify'});

                    //Texto
                    texto = `Têm entre si justo e contratado a prestação de serviços de bombeiro civil, conforme as cláusulas e condições a seguir estabelecidas.`;

                    novaMarginTop = novaMarginTop + alturaTexto + spacingBetweenTextsA;
                    linhasTexto = doc.splitTextToSize(texto, textWidth);
                    alturaTexto = linhasTexto.length * spacingBetweenTextsA;

                    if ((novaMarginTop + alturaTexto) > 270) {doc.addPage(); novaMarginTop = marginTop;}

                    doc.setFont('helvetica', 'normal');
                    doc.setFontSize(12);
                    doc.text(texto, marginLeft, novaMarginTop, {maxWidth: textWidth, align: 'justify'});

                    //Texto
                    texto = `CLÁUSULA PRIMEIRA - DO OBJETO`;

                    novaMarginTop = novaMarginTop + alturaTexto + spacingBetweenTextsD;
                    linhasTexto = doc.splitTextToSize(texto, textWidth);
                    alturaTexto = linhasTexto.length * spacingBetweenTextsA;

                    if ((novaMarginTop + alturaTexto) > 270) {doc.addPage(); novaMarginTop = marginTop;}

                    doc.setFont('helvetica', 'bold');
                    doc.setFontSize(14);
                    doc.text(texto, marginLeft, novaMarginTop, {maxWidth: textWidth, align: 'justify'});

                    //Texto
                    texto = `1.1. O presente contrato tem por objeto a prestação de serviços de bombeiro civil de forma autônoma, pelo CONTRATADO, compreendendo atividades de prevenção e combate a incêndios, atendimento emergencial de primeiros socorros e controle de pânico, com o fornecimento dos respectivos Equipamentos de Proteção Individual e material de Primeiros Socorros, conforme especificações a seguir:`;

                    novaMarginTop = novaMarginTop + alturaTexto + spacingBetweenTextsA;
                    linhasTexto = doc.splitTextToSize(texto, textWidth);
                    alturaTexto = linhasTexto.length * spacingBetweenTextsA;

                    if ((novaMarginTop + alturaTexto) > 270) {doc.addPage(); novaMarginTop = marginTop;}

                    doc.setFont('helvetica', 'normal');
                    doc.setFontSize(12);
                    doc.text(texto, marginLeft, novaMarginTop, {maxWidth: textWidth, align: 'justify'});

                    //Texto
                    texto = `a) Local da prestação dos serviços: ${funcionario_acao_1_local};`;

                    novaMarginTop = novaMarginTop + alturaTexto + spacingBetweenTextsA;
                    linhasTexto = doc.splitTextToSize(texto, textWidth);
                    alturaTexto = linhasTexto.length * spacingBetweenTextsA;

                    if ((novaMarginTop + alturaTexto) > 270) {doc.addPage(); novaMarginTop = marginTop;}

                    doc.setFont('helvetica', 'normal');
                    doc.setFontSize(12);
                    doc.text(texto, marginLeft, novaMarginTop, {maxWidth: textWidth, align: 'justify'});

                    //Texto
                    texto = `b) Horário da prestação de serviços: ${funcionario_acao_1_dias_horarios};`;

                    novaMarginTop = novaMarginTop + alturaTexto + spacingBetweenTextsA;
                    linhasTexto = doc.splitTextToSize(texto, textWidth);
                    alturaTexto = linhasTexto.length * spacingBetweenTextsA;

                    if ((novaMarginTop + alturaTexto) > 270) {doc.addPage(); novaMarginTop = marginTop;}

                    doc.setFont('helvetica', 'normal');
                    doc.setFontSize(12);
                    doc.text(texto, marginLeft, novaMarginTop, {maxWidth: textWidth, align: 'justify'});

                    //Texto
                    texto = `1.2. A execução dos serviços deverá atender às normas da Lei Federal nº 11.901/2009, bem como às normas da ABNT NBR 14608/2007, que regulamentam a atuação do bombeiro civil.`;

                    novaMarginTop = novaMarginTop + alturaTexto + spacingBetweenTextsA;
                    linhasTexto = doc.splitTextToSize(texto, textWidth);
                    alturaTexto = linhasTexto.length * spacingBetweenTextsA;

                    if ((novaMarginTop + alturaTexto) > 270) {doc.addPage(); novaMarginTop = marginTop;}

                    doc.setFont('helvetica', 'normal');
                    doc.setFontSize(12);
                    doc.text(texto, marginLeft, novaMarginTop, {maxWidth: textWidth, align: 'justify'});

                    // //Texto
                    // texto = `1.3. A execução dos serviços deverá atender plenamente ao horário de funcionamento do local da prestação dos serviços. O horário poderá ser ajustado contratualmente, desde que seja preservado o número de 12 horas trabalhadas por 36 horas de descanso, totalizando 36 horas semanais, conforme art. 5º da Lei 11.901/2009.`;
                    //
                    // novaMarginTop = novaMarginTop + alturaTexto + spacingBetweenTextsA;
                    // linhasTexto = doc.splitTextToSize(texto, textWidth);
                    // alturaTexto = linhasTexto.length * spacingBetweenTextsA;
                    //
                    // if ((novaMarginTop + alturaTexto) > 270) {doc.addPage(); novaMarginTop = marginTop;}
                    //
                    // doc.setFont('helvetica', 'normal');
                    // doc.setFontSize(12);
                    // doc.text(texto, marginLeft, novaMarginTop, {maxWidth: textWidth, align: 'justify'});

                    //Texto
                    texto = `1.4. Fica expressamente pactuado que este contrato é firmado entre partes autônomas e independentes, sem qualquer subordinação ou exclusividade, e sem que se estabeleça qualquer vínculo empregatício entre as partes ou com terceiros contratados pelo CONTRATADO para a execução dos serviços.`;

                    novaMarginTop = novaMarginTop + alturaTexto + spacingBetweenTextsA;
                    linhasTexto = doc.splitTextToSize(texto, textWidth);
                    alturaTexto = linhasTexto.length * spacingBetweenTextsA;

                    if ((novaMarginTop + alturaTexto) > 270) {doc.addPage(); novaMarginTop = marginTop;}

                    doc.setFont('helvetica', 'normal');
                    doc.setFontSize(12);
                    doc.text(texto, marginLeft, novaMarginTop, {maxWidth: textWidth, align: 'justify'});

                    //Texto
                    texto = `CLÁUSULA SEGUNDA - OBRIGAÇÕES DO CONTRATADO:`;

                    novaMarginTop = novaMarginTop + alturaTexto + spacingBetweenTextsD;
                    linhasTexto = doc.splitTextToSize(texto, textWidth);
                    alturaTexto = linhasTexto.length * spacingBetweenTextsA;

                    if ((novaMarginTop + alturaTexto) > 270) {doc.addPage(); novaMarginTop = marginTop;}

                    doc.setFont('helvetica', 'bold');
                    doc.setFontSize(14);
                    doc.text(texto, marginLeft, novaMarginTop, {maxWidth: textWidth, align: 'justify'});

                    //Texto
                    texto = `2.1. O CONTRATADO obriga-se a:`;

                    novaMarginTop = novaMarginTop + alturaTexto + spacingBetweenTextsA;
                    linhasTexto = doc.splitTextToSize(texto, textWidth);
                    alturaTexto = linhasTexto.length * spacingBetweenTextsA;

                    if ((novaMarginTop + alturaTexto) > 270) {doc.addPage(); novaMarginTop = marginTop;}

                    doc.setFont('helvetica', 'normal');
                    doc.setFontSize(12);
                    doc.text(texto, marginLeft, novaMarginTop, {maxWidth: textWidth, align: 'justify'});

                    //Texto
                    texto = `a) Executar os serviços com zelo, pontualidade e profissionalismo;`;

                    novaMarginTop = novaMarginTop + alturaTexto + spacingBetweenTextsA;
                    linhasTexto = doc.splitTextToSize(texto, textWidth);
                    alturaTexto = linhasTexto.length * spacingBetweenTextsA;

                    if ((novaMarginTop + alturaTexto) > 270) {doc.addPage(); novaMarginTop = marginTop;}

                    doc.setFont('helvetica', 'normal');
                    doc.setFontSize(12);
                    doc.text(texto, marginLeft, novaMarginTop, {maxWidth: textWidth, align: 'justify'});

                    //Texto
                    texto = `b) Utilizar uniforme adequado e manter-se devidamente equipado com EPIs;`;

                    novaMarginTop = novaMarginTop + alturaTexto + spacingBetweenTextsA;
                    linhasTexto = doc.splitTextToSize(texto, textWidth);
                    alturaTexto = linhasTexto.length * spacingBetweenTextsA;

                    if ((novaMarginTop + alturaTexto) > 270) {doc.addPage(); novaMarginTop = marginTop;}

                    doc.setFont('helvetica', 'normal');
                    doc.setFontSize(12);
                    doc.text(texto, marginLeft, novaMarginTop, {maxWidth: textWidth, align: 'justify'});

                    //Texto
                    texto = `c) Manter sigilo absoluto sobre quaisquer informações internas do local vigiado;`;

                    novaMarginTop = novaMarginTop + alturaTexto + spacingBetweenTextsA;
                    linhasTexto = doc.splitTextToSize(texto, textWidth);
                    alturaTexto = linhasTexto.length * spacingBetweenTextsA;

                    if ((novaMarginTop + alturaTexto) > 270) {doc.addPage(); novaMarginTop = marginTop;}

                    doc.setFont('helvetica', 'normal');
                    doc.setFontSize(12);
                    doc.text(texto, marginLeft, novaMarginTop, {maxWidth: textWidth, align: 'justify'});

                    //Texto
                    texto = `d) Comunicar ao CONTRATANTE sobre quaisquer irregularidades ou necessidades de adequação em segurança.`;

                    novaMarginTop = novaMarginTop + alturaTexto + spacingBetweenTextsA;
                    linhasTexto = doc.splitTextToSize(texto, textWidth);
                    alturaTexto = linhasTexto.length * spacingBetweenTextsA;

                    if ((novaMarginTop + alturaTexto) > 270) {doc.addPage(); novaMarginTop = marginTop;}

                    doc.setFont('helvetica', 'normal');
                    doc.setFontSize(12);
                    doc.text(texto, marginLeft, novaMarginTop, {maxWidth: textWidth, align: 'justify'});

                    //Texto
                    texto = `2.2. Os serviços a serem executados pelo CONTRATADO compreendem ações de prevenção e de emergência, descritos a seguir:`;

                    novaMarginTop = novaMarginTop + alturaTexto + spacingBetweenTextsA;
                    linhasTexto = doc.splitTextToSize(texto, textWidth);
                    alturaTexto = linhasTexto.length * spacingBetweenTextsA;

                    if ((novaMarginTop + alturaTexto) > 270) {doc.addPage(); novaMarginTop = marginTop;}

                    doc.setFont('helvetica', 'normal');
                    doc.setFontSize(12);
                    doc.text(texto, marginLeft, novaMarginTop, {maxWidth: textWidth, align: 'justify'});

                    //Texto
                    texto = `2.2.1. Ações de Prevenção:`;

                    novaMarginTop = novaMarginTop + alturaTexto + spacingBetweenTextsA;
                    linhasTexto = doc.splitTextToSize(texto, textWidth);
                    alturaTexto = linhasTexto.length * spacingBetweenTextsA;

                    if ((novaMarginTop + alturaTexto) > 270) {doc.addPage(); novaMarginTop = marginTop;}

                    doc.setFont('helvetica', 'normal');
                    doc.setFontSize(12);
                    doc.text(texto, marginLeft, novaMarginTop, {maxWidth: textWidth, align: 'justify'});

                    //Texto
                    texto = `a) Identificar e avaliar os riscos existentes;`;

                    novaMarginTop = novaMarginTop + alturaTexto + spacingBetweenTextsA;
                    linhasTexto = doc.splitTextToSize(texto, textWidth);
                    alturaTexto = linhasTexto.length * spacingBetweenTextsA;

                    if ((novaMarginTop + alturaTexto) > 270) {doc.addPage(); novaMarginTop = marginTop;}

                    doc.setFont('helvetica', 'normal');
                    doc.setFontSize(12);
                    doc.text(texto, marginLeft, novaMarginTop, {maxWidth: textWidth, align: 'justify'});

                    //Texto
                    texto = `b) Elaborar relatório das irregularidades encontradas nos sistemas preventivos com apresentação de eventuais sugestões para melhoria das condições de segurança;`;

                    novaMarginTop = novaMarginTop + alturaTexto + spacingBetweenTextsA;
                    linhasTexto = doc.splitTextToSize(texto, textWidth);
                    alturaTexto = linhasTexto.length * spacingBetweenTextsA;

                    if ((novaMarginTop + alturaTexto) > 270) {doc.addPage(); novaMarginTop = marginTop;}

                    doc.setFont('helvetica', 'normal');
                    doc.setFontSize(12);
                    doc.text(texto, marginLeft, novaMarginTop, {maxWidth: textWidth, align: 'justify'});

                    //Texto
                    texto = `c) Conhecer, em profundidade, a técnica e tática para utilização dos equipamentos e sistemas de extinção de incêndio: mangueiras, extintores, chuveiros automáticos e CO2;`;

                    novaMarginTop = novaMarginTop + alturaTexto + spacingBetweenTextsA;
                    linhasTexto = doc.splitTextToSize(texto, textWidth);
                    alturaTexto = linhasTexto.length * spacingBetweenTextsA;

                    if ((novaMarginTop + alturaTexto) > 270) {doc.addPage(); novaMarginTop = marginTop;}

                    doc.setFont('helvetica', 'normal');
                    doc.setFontSize(12);
                    doc.text(texto, marginLeft, novaMarginTop, {maxWidth: textWidth, align: 'justify'});

                    //Texto
                    texto = `d) Conhecer a localização dos alarmes, extintores, caixas de incêndio, bem como, a ligação do conjunto de bombas de pressurização da rede de hidrantes;`;

                    novaMarginTop = novaMarginTop + alturaTexto + spacingBetweenTextsA;
                    linhasTexto = doc.splitTextToSize(texto, textWidth);
                    alturaTexto = linhasTexto.length * spacingBetweenTextsA;

                    if ((novaMarginTop + alturaTexto) > 270) {doc.addPage(); novaMarginTop = marginTop;}

                    doc.setFont('helvetica', 'normal');
                    doc.setFontSize(12);
                    doc.text(texto, marginLeft, novaMarginTop, {maxWidth: textWidth, align: 'justify'});

                    //Texto
                    texto = `e) Inspecionar periodicamente os equipamentos de proteção contra incêndio e de rotas de fuga, comunicando ao fiscal do contrato, com a maior brevidade possível, as anormalidades detectadas;`;

                    novaMarginTop = novaMarginTop + alturaTexto + spacingBetweenTextsA;
                    linhasTexto = doc.splitTextToSize(texto, textWidth);
                    alturaTexto = linhasTexto.length * spacingBetweenTextsA;

                    if ((novaMarginTop + alturaTexto) > 270) {doc.addPage(); novaMarginTop = marginTop;}

                    doc.setFont('helvetica', 'normal');
                    doc.setFontSize(12);
                    doc.text(texto, marginLeft, novaMarginTop, {maxWidth: textWidth, align: 'justify'});

                    //Texto
                    texto = `f) Executar ronda(s) diária(s) conforme a orientação recebida da CONTRATANTE, verificando todas as dependências das instalações, adotando os cuidados e providências necessários para o perfeito desempenho das funções e manutenção da ordem nas instalações;`;

                    novaMarginTop = novaMarginTop + alturaTexto + spacingBetweenTextsA;
                    linhasTexto = doc.splitTextToSize(texto, textWidth);
                    alturaTexto = linhasTexto.length * spacingBetweenTextsA;

                    if ((novaMarginTop + alturaTexto) > 270) {doc.addPage(); novaMarginTop = marginTop;}

                    doc.setFont('helvetica', 'normal');
                    doc.setFontSize(12);
                    doc.text(texto, marginLeft, novaMarginTop, {maxWidth: textWidth, align: 'justify'});

                    //Texto
                    texto = `g) Analisar com rapidez a situação e empregar os meios disponíveis para debelar um incêndio;`;

                    novaMarginTop = novaMarginTop + alturaTexto + spacingBetweenTextsA;
                    linhasTexto = doc.splitTextToSize(texto, textWidth);
                    alturaTexto = linhasTexto.length * spacingBetweenTextsA;

                    if ((novaMarginTop + alturaTexto) > 270) {doc.addPage(); novaMarginTop = marginTop;}

                    doc.setFont('helvetica', 'normal');
                    doc.setFontSize(12);
                    doc.text(texto, marginLeft, novaMarginTop, {maxWidth: textWidth, align: 'justify'});

                    //Texto
                    texto = `h) Investigar a origem de qualquer anormalidade na edificação que seja indício de princípio de incêndio;`;

                    novaMarginTop = novaMarginTop + alturaTexto + spacingBetweenTextsA;
                    linhasTexto = doc.splitTextToSize(texto, textWidth);
                    alturaTexto = linhasTexto.length * spacingBetweenTextsA;

                    if ((novaMarginTop + alturaTexto) > 270) {doc.addPage(); novaMarginTop = marginTop;}

                    doc.setFont('helvetica', 'normal');
                    doc.setFontSize(12);
                    doc.text(texto, marginLeft, novaMarginTop, {maxWidth: textWidth, align: 'justify'});

                    //Texto
                    texto = `i) Comunicar à CONTRATANTE, toda ocorrência anormal que verificar;`;

                    novaMarginTop = novaMarginTop + alturaTexto + spacingBetweenTextsA;
                    linhasTexto = doc.splitTextToSize(texto, textWidth);
                    alturaTexto = linhasTexto.length * spacingBetweenTextsA;

                    if ((novaMarginTop + alturaTexto) > 270) {doc.addPage(); novaMarginTop = marginTop;}

                    doc.setFont('helvetica', 'normal');
                    doc.setFontSize(12);
                    doc.text(texto, marginLeft, novaMarginTop, {maxWidth: textWidth, align: 'justify'});

                    //Texto
                    texto = `j) Apresentar à CONTRATANTE, relatório formal das irregularidades encontradas, com propostas e medidas corretivas adequadas;`;

                    novaMarginTop = novaMarginTop + alturaTexto + spacingBetweenTextsA;
                    linhasTexto = doc.splitTextToSize(texto, textWidth);
                    alturaTexto = linhasTexto.length * spacingBetweenTextsA;

                    if ((novaMarginTop + alturaTexto) > 270) {doc.addPage(); novaMarginTop = marginTop;}

                    doc.setFont('helvetica', 'normal');
                    doc.setFontSize(12);
                    doc.text(texto, marginLeft, novaMarginTop, {maxWidth: textWidth, align: 'justify'});

                    //Texto
                    texto = `k) Testar periodicamente os equipamentos de combate a incêndio e afins;`;

                    novaMarginTop = novaMarginTop + alturaTexto + spacingBetweenTextsA;
                    linhasTexto = doc.splitTextToSize(texto, textWidth);
                    alturaTexto = linhasTexto.length * spacingBetweenTextsA;

                    if ((novaMarginTop + alturaTexto) > 270) {doc.addPage(); novaMarginTop = marginTop;}

                    doc.setFont('helvetica', 'normal');
                    doc.setFontSize(12);
                    doc.text(texto, marginLeft, novaMarginTop, {maxWidth: textWidth, align: 'justify'});

                    //Texto
                    texto = `l) Avaliar e acompanhar as atividades de risco;`;

                    novaMarginTop = novaMarginTop + alturaTexto + spacingBetweenTextsA;
                    linhasTexto = doc.splitTextToSize(texto, textWidth);
                    alturaTexto = linhasTexto.length * spacingBetweenTextsA;

                    if ((novaMarginTop + alturaTexto) > 270) {doc.addPage(); novaMarginTop = marginTop;}

                    doc.setFont('helvetica', 'normal');
                    doc.setFontSize(12);
                    doc.text(texto, marginLeft, novaMarginTop, {maxWidth: textWidth, align: 'justify'});

                    //Texto
                    texto = `m) Estar sempre em condições de auxiliar o CBMERJ, por ocasião de sua chegada, no sentido de fornecer dados gerais sobre o edifício e o evento, bem como, promover o rápido e fácil acesso aos dispositivos de segurança;`;

                    novaMarginTop = novaMarginTop + alturaTexto + spacingBetweenTextsA;
                    linhasTexto = doc.splitTextToSize(texto, textWidth);
                    alturaTexto = linhasTexto.length * spacingBetweenTextsA;

                    if ((novaMarginTop + alturaTexto) > 270) {doc.addPage(); novaMarginTop = marginTop;}

                    doc.setFont('helvetica', 'normal');
                    doc.setFontSize(12);
                    doc.text(texto, marginLeft, novaMarginTop, {maxWidth: textWidth, align: 'justify'});

                    //Texto
                    texto = `n) Efetuar rondas diárias e esporádicas em todas as instalações dos edifícios para verificar a existência de possíveis problemas que possam representar eventuais riscos de incêndio.`;

                    novaMarginTop = novaMarginTop + alturaTexto + spacingBetweenTextsA;
                    linhasTexto = doc.splitTextToSize(texto, textWidth);
                    alturaTexto = linhasTexto.length * spacingBetweenTextsA;

                    if ((novaMarginTop + alturaTexto) > 270) {doc.addPage(); novaMarginTop = marginTop;}

                    doc.setFont('helvetica', 'normal');
                    doc.setFontSize(12);
                    doc.text(texto, marginLeft, novaMarginTop, {maxWidth: textWidth, align: 'justify'});

                    //Texto
                    texto = `2.2.2. Ações de Emergência:`;

                    novaMarginTop = novaMarginTop + alturaTexto + spacingBetweenTextsA;
                    linhasTexto = doc.splitTextToSize(texto, textWidth);
                    alturaTexto = linhasTexto.length * spacingBetweenTextsA;

                    if ((novaMarginTop + alturaTexto) > 270) {doc.addPage(); novaMarginTop = marginTop;}

                    doc.setFont('helvetica', 'normal');
                    doc.setFontSize(12);
                    doc.text(texto, marginLeft, novaMarginTop, {maxWidth: textWidth, align: 'justify'});

                    //Texto
                    texto = `a) Identificar e avaliar a situação;`;

                    novaMarginTop = novaMarginTop + alturaTexto + spacingBetweenTextsA;
                    linhasTexto = doc.splitTextToSize(texto, textWidth);
                    alturaTexto = linhasTexto.length * spacingBetweenTextsA;

                    if ((novaMarginTop + alturaTexto) > 270) {doc.addPage(); novaMarginTop = marginTop;}

                    doc.setFont('helvetica', 'normal');
                    doc.setFontSize(12);
                    doc.text(texto, marginLeft, novaMarginTop, {maxWidth: textWidth, align: 'justify'});

                    //Texto
                    texto = `b) Acionar imediatamente o CBMERJ;`;

                    novaMarginTop = novaMarginTop + alturaTexto + spacingBetweenTextsA;
                    linhasTexto = doc.splitTextToSize(texto, textWidth);
                    alturaTexto = linhasTexto.length * spacingBetweenTextsA;

                    if ((novaMarginTop + alturaTexto) > 270) {doc.addPage(); novaMarginTop = marginTop;}

                    doc.setFont('helvetica', 'normal');
                    doc.setFontSize(12);
                    doc.text(texto, marginLeft, novaMarginTop, {maxWidth: textWidth, align: 'justify'});

                    //Texto
                    texto = `c) Verificar a transmissão do alarme e auxiliar no abandono da edificação;`;

                    novaMarginTop = novaMarginTop + alturaTexto + spacingBetweenTextsA;
                    linhasTexto = doc.splitTextToSize(texto, textWidth);
                    alturaTexto = linhasTexto.length * spacingBetweenTextsA;

                    if ((novaMarginTop + alturaTexto) > 270) {doc.addPage(); novaMarginTop = marginTop;}

                    doc.setFont('helvetica', 'normal');
                    doc.setFontSize(12);
                    doc.text(texto, marginLeft, novaMarginTop, {maxWidth: textWidth, align: 'justify'});

                    //Texto
                    texto = `d) Combater os incêndios em sua fase inicial, de forma que possam ser controlados por meio de materiais e equipamentos colocados pela CONTRATANTE a disposição da CONTRATADO;`;

                    novaMarginTop = novaMarginTop + alturaTexto + spacingBetweenTextsA;
                    linhasTexto = doc.splitTextToSize(texto, textWidth);
                    alturaTexto = linhasTexto.length * spacingBetweenTextsA;

                    if ((novaMarginTop + alturaTexto) > 270) {doc.addPage(); novaMarginTop = marginTop;}

                    doc.setFont('helvetica', 'normal');
                    doc.setFontSize(12);
                    doc.text(texto, marginLeft, novaMarginTop, {maxWidth: textWidth, align: 'justify'});

                    //Texto
                    texto = `e) Atuar no controle de pânico;`;

                    novaMarginTop = novaMarginTop + alturaTexto + spacingBetweenTextsA;
                    linhasTexto = doc.splitTextToSize(texto, textWidth);
                    alturaTexto = linhasTexto.length * spacingBetweenTextsA;

                    if ((novaMarginTop + alturaTexto) > 270) {doc.addPage(); novaMarginTop = marginTop;}

                    doc.setFont('helvetica', 'normal');
                    doc.setFontSize(12);
                    doc.text(texto, marginLeft, novaMarginTop, {maxWidth: textWidth, align: 'justify'});

                    //Texto
                    texto = `f) Prestar os primeiros socorros a feridos;`;

                    novaMarginTop = novaMarginTop + alturaTexto + spacingBetweenTextsA;
                    linhasTexto = doc.splitTextToSize(texto, textWidth);
                    alturaTexto = linhasTexto.length * spacingBetweenTextsA;

                    if ((novaMarginTop + alturaTexto) > 270) {doc.addPage(); novaMarginTop = marginTop;}

                    doc.setFont('helvetica', 'normal');
                    doc.setFontSize(12);
                    doc.text(texto, marginLeft, novaMarginTop, {maxWidth: textWidth, align: 'justify'});

                    //Texto
                    texto = `g) Interromper o fornecimento de energia elétrica quando da ocorrência de sinistro;`;

                    novaMarginTop = novaMarginTop + alturaTexto + spacingBetweenTextsA;
                    linhasTexto = doc.splitTextToSize(texto, textWidth);
                    alturaTexto = linhasTexto.length * spacingBetweenTextsA;

                    if ((novaMarginTop + alturaTexto) > 270) {doc.addPage(); novaMarginTop = marginTop;}

                    doc.setFont('helvetica', 'normal');
                    doc.setFontSize(12);
                    doc.text(texto, marginLeft, novaMarginTop, {maxWidth: textWidth, align: 'justify'});

                    //Texto
                    texto = `h) Estar sempre em condições de auxiliar o CBMERJ, por ocasião de sua chegada, no sentido de fornecer dados gerais sobre a ocorrência, bem como promover o rápido e fácil acesso aos dispositivos de segurança.`;

                    novaMarginTop = novaMarginTop + alturaTexto + spacingBetweenTextsA;
                    linhasTexto = doc.splitTextToSize(texto, textWidth);
                    alturaTexto = linhasTexto.length * spacingBetweenTextsA;

                    if ((novaMarginTop + alturaTexto) > 270) {doc.addPage(); novaMarginTop = marginTop;}

                    doc.setFont('helvetica', 'normal');
                    doc.setFontSize(12);
                    doc.text(texto, marginLeft, novaMarginTop, {maxWidth: textWidth, align: 'justify'});

                    //Texto
                    texto = `CLÁUSULA TERCEIRA - OBRIGAÇÕES DO CONTRATANTE`;

                    novaMarginTop = novaMarginTop + alturaTexto + spacingBetweenTextsD;
                    linhasTexto = doc.splitTextToSize(texto, textWidth);
                    alturaTexto = linhasTexto.length * spacingBetweenTextsA;

                    if ((novaMarginTop + alturaTexto) > 270) {doc.addPage(); novaMarginTop = marginTop;}

                    doc.setFont('helvetica', 'bold');
                    doc.setFontSize(14);
                    doc.text(texto, marginLeft, novaMarginTop, {maxWidth: textWidth, align: 'justify'});

                    //Texto
                    texto = `3.1. O CONTRATANTE obriga-se a:`;

                    novaMarginTop = novaMarginTop + alturaTexto + spacingBetweenTextsA;
                    linhasTexto = doc.splitTextToSize(texto, textWidth);
                    alturaTexto = linhasTexto.length * spacingBetweenTextsA;

                    if ((novaMarginTop + alturaTexto) > 270) {doc.addPage(); novaMarginTop = marginTop;}

                    doc.setFont('helvetica', 'normal');
                    doc.setFontSize(12);
                    doc.text(texto, marginLeft, novaMarginTop, {maxWidth: textWidth, align: 'justify'});

                    //Texto
                    texto = `a) Disponibilizar ao CONTRATADO as informações necessárias para o desempenho de suas funções;`;

                    novaMarginTop = novaMarginTop + alturaTexto + spacingBetweenTextsA;
                    linhasTexto = doc.splitTextToSize(texto, textWidth);
                    alturaTexto = linhasTexto.length * spacingBetweenTextsA;

                    if ((novaMarginTop + alturaTexto) > 270) {doc.addPage(); novaMarginTop = marginTop;}

                    doc.setFont('helvetica', 'normal');
                    doc.setFontSize(12);
                    doc.text(texto, marginLeft, novaMarginTop, {maxWidth: textWidth, align: 'justify'});

                    //Texto
                    texto = `b) Fornecer acesso a um espaço adequado para guarda de equipamentos e descanso, se aplicável;`;

                    novaMarginTop = novaMarginTop + alturaTexto + spacingBetweenTextsA;
                    linhasTexto = doc.splitTextToSize(texto, textWidth);
                    alturaTexto = linhasTexto.length * spacingBetweenTextsA;

                    if ((novaMarginTop + alturaTexto) > 270) {doc.addPage(); novaMarginTop = marginTop;}

                    doc.setFont('helvetica', 'normal');
                    doc.setFontSize(12);
                    doc.text(texto, marginLeft, novaMarginTop, {maxWidth: textWidth, align: 'justify'});

                    //Texto
                    texto = `c) Efetuar o pagamento dos honorários conforme estipulado neste contrato;`;

                    novaMarginTop = novaMarginTop + alturaTexto + spacingBetweenTextsA;
                    linhasTexto = doc.splitTextToSize(texto, textWidth);
                    alturaTexto = linhasTexto.length * spacingBetweenTextsA;

                    if ((novaMarginTop + alturaTexto) > 270) {doc.addPage(); novaMarginTop = marginTop;}

                    doc.setFont('helvetica', 'normal');
                    doc.setFontSize(12);
                    doc.text(texto, marginLeft, novaMarginTop, {maxWidth: textWidth, align: 'justify'});

                    //Texto
                    texto = `d) Cumprir as normas de segurança aplicáveis ao local onde os serviços serão prestados.`;

                    novaMarginTop = novaMarginTop + alturaTexto + spacingBetweenTextsA;
                    linhasTexto = doc.splitTextToSize(texto, textWidth);
                    alturaTexto = linhasTexto.length * spacingBetweenTextsA;

                    if ((novaMarginTop + alturaTexto) > 270) {doc.addPage(); novaMarginTop = marginTop;}

                    doc.setFont('helvetica', 'normal');
                    doc.setFontSize(12);
                    doc.text(texto, marginLeft, novaMarginTop, {maxWidth: textWidth, align: 'justify'});

                    //Texto
                    texto = `e) Exercer a fiscalização dos serviços por técnicos especialmente designados.`;

                    novaMarginTop = novaMarginTop + alturaTexto + spacingBetweenTextsA;
                    linhasTexto = doc.splitTextToSize(texto, textWidth);
                    alturaTexto = linhasTexto.length * spacingBetweenTextsA;

                    if ((novaMarginTop + alturaTexto) > 270) {doc.addPage(); novaMarginTop = marginTop;}

                    doc.setFont('helvetica', 'normal');
                    doc.setFontSize(12);
                    doc.text(texto, marginLeft, novaMarginTop, {maxWidth: textWidth, align: 'justify'});

                    //Texto
                    texto = `f) Indicar instalações sanitárias, para uso do CONTRATADO;`;

                    novaMarginTop = novaMarginTop + alturaTexto + spacingBetweenTextsA;
                    linhasTexto = doc.splitTextToSize(texto, textWidth);
                    alturaTexto = linhasTexto.length * spacingBetweenTextsA;

                    if ((novaMarginTop + alturaTexto) > 270) {doc.addPage(); novaMarginTop = marginTop;}

                    doc.setFont('helvetica', 'normal');
                    doc.setFontSize(12);
                    doc.text(texto, marginLeft, novaMarginTop, {maxWidth: textWidth, align: 'justify'});

                    //Texto
                    texto = `CLÁUSULA QUARTA - REMUNERAÇÃO E CONDIÇÕES DE PAGAMENTO`;

                    novaMarginTop = novaMarginTop + alturaTexto + spacingBetweenTextsD;
                    linhasTexto = doc.splitTextToSize(texto, textWidth);
                    alturaTexto = linhasTexto.length * spacingBetweenTextsA;

                    if ((novaMarginTop + alturaTexto) > 270) {doc.addPage(); novaMarginTop = marginTop;}

                    doc.setFont('helvetica', 'bold');
                    doc.setFontSize(14);
                    doc.text(texto, marginLeft, novaMarginTop, {maxWidth: textWidth, align: 'justify'});

                    //Texto
                    texto = `4.1. Pela prestação dos serviços, o CONTRATANTE pagará ao CONTRATADO o valor de R$ ${funcionario_acao_1_valor}, a ser pago diariamente.`;

                    novaMarginTop = novaMarginTop + alturaTexto + spacingBetweenTextsA;
                    linhasTexto = doc.splitTextToSize(texto, textWidth);
                    alturaTexto = linhasTexto.length * spacingBetweenTextsA;

                    if ((novaMarginTop + alturaTexto) > 270) {doc.addPage(); novaMarginTop = marginTop;}

                    doc.setFont('helvetica', 'normal');
                    doc.setFontSize(12);
                    doc.text(texto, marginLeft, novaMarginTop, {maxWidth: textWidth, align: 'justify'});

                    //Texto
                    texto = `4.2. O pagamento será realizado via transferência bancária, PIX ou dinheiro.`;

                    novaMarginTop = novaMarginTop + alturaTexto + spacingBetweenTextsA;
                    linhasTexto = doc.splitTextToSize(texto, textWidth);
                    alturaTexto = linhasTexto.length * spacingBetweenTextsA;

                    if ((novaMarginTop + alturaTexto) > 270) {doc.addPage(); novaMarginTop = marginTop;}

                    doc.setFont('helvetica', 'normal');
                    doc.setFontSize(12);
                    doc.text(texto, marginLeft, novaMarginTop, {maxWidth: textWidth, align: 'justify'});

                    // //Texto
                    // texto = `4.3. Em caso de atraso no pagamento, incidirão sobre o valor devido:`;
                    //
                    // novaMarginTop = novaMarginTop + alturaTexto + spacingBetweenTextsA;
                    // linhasTexto = doc.splitTextToSize(texto, textWidth);
                    // alturaTexto = linhasTexto.length * spacingBetweenTextsA;
                    //
                    // if ((novaMarginTop + alturaTexto) > 270) {doc.addPage(); novaMarginTop = marginTop;}
                    //
                    // doc.setFont('helvetica', 'normal');
                    // doc.setFontSize(12);
                    // doc.text(texto, marginLeft, novaMarginTop, {maxWidth: textWidth, align: 'justify'});
                    //
                    // //Texto
                    // texto = `a) Multa de 2% (dois por cento) sobre o montante em aberto;`;
                    //
                    // novaMarginTop = novaMarginTop + alturaTexto + spacingBetweenTextsA;
                    // linhasTexto = doc.splitTextToSize(texto, textWidth);
                    // alturaTexto = linhasTexto.length * spacingBetweenTextsA;
                    //
                    // if ((novaMarginTop + alturaTexto) > 270) {doc.addPage(); novaMarginTop = marginTop;}
                    //
                    // doc.setFont('helvetica', 'normal');
                    // doc.setFontSize(12);
                    // doc.text(texto, marginLeft, novaMarginTop, {maxWidth: textWidth, align: 'justify'});
                    //
                    // //Texto
                    // texto = `b) Juros moratórios de 1% ao mês, calculados pro rata die;`;
                    //
                    // novaMarginTop = novaMarginTop + alturaTexto + spacingBetweenTextsA;
                    // linhasTexto = doc.splitTextToSize(texto, textWidth);
                    // alturaTexto = linhasTexto.length * spacingBetweenTextsA;
                    //
                    // if ((novaMarginTop + alturaTexto) > 270) {doc.addPage(); novaMarginTop = marginTop;}
                    //
                    // doc.setFont('helvetica', 'normal');
                    // doc.setFontSize(12);
                    // doc.text(texto, marginLeft, novaMarginTop, {maxWidth: textWidth, align: 'justify'});
                    //
                    // //Texto
                    // texto = `c) Correção monetária pelo índice IPCA;`;
                    //
                    // novaMarginTop = novaMarginTop + alturaTexto + spacingBetweenTextsA;
                    // linhasTexto = doc.splitTextToSize(texto, textWidth);
                    // alturaTexto = linhasTexto.length * spacingBetweenTextsA;
                    //
                    // if ((novaMarginTop + alturaTexto) > 270) {doc.addPage(); novaMarginTop = marginTop;}
                    //
                    // doc.setFont('helvetica', 'normal');
                    // doc.setFontSize(12);
                    // doc.text(texto, marginLeft, novaMarginTop, {maxWidth: textWidth, align: 'justify'});

                    //Texto
                    texto = `CLÁUSULA QUINTA - INADIMPLEMENTO`;

                    novaMarginTop = novaMarginTop + alturaTexto + spacingBetweenTextsD;
                    linhasTexto = doc.splitTextToSize(texto, textWidth);
                    alturaTexto = linhasTexto.length * spacingBetweenTextsA;

                    if ((novaMarginTop + alturaTexto) > 270) {doc.addPage(); novaMarginTop = marginTop;}

                    doc.setFont('helvetica', 'bold');
                    doc.setFontSize(14);
                    doc.text(texto, marginLeft, novaMarginTop, {maxWidth: textWidth, align: 'justify'});

                    //Texto
                    texto = `5.1. Caso o CONTRATANTE não efetue o pagamento no prazo acordado, o CONTRATADO poderá:`;

                    novaMarginTop = novaMarginTop + alturaTexto + spacingBetweenTextsA;
                    linhasTexto = doc.splitTextToSize(texto, textWidth);
                    alturaTexto = linhasTexto.length * spacingBetweenTextsA;

                    if ((novaMarginTop + alturaTexto) > 270) {doc.addPage(); novaMarginTop = marginTop;}

                    doc.setFont('helvetica', 'normal');
                    doc.setFontSize(12);
                    doc.text(texto, marginLeft, novaMarginTop, {maxWidth: textWidth, align: 'justify'});

                    //Texto
                    texto = `a) Aplicar as penalidades previstas na cláusula 4.3;`;

                    novaMarginTop = novaMarginTop + alturaTexto + spacingBetweenTextsA;
                    linhasTexto = doc.splitTextToSize(texto, textWidth);
                    alturaTexto = linhasTexto.length * spacingBetweenTextsA;

                    if ((novaMarginTop + alturaTexto) > 270) {doc.addPage(); novaMarginTop = marginTop;}

                    doc.setFont('helvetica', 'normal');
                    doc.setFontSize(12);
                    doc.text(texto, marginLeft, novaMarginTop, {maxWidth: textWidth, align: 'justify'});

                    //Texto
                    texto = `b) Suspender a prestação dos serviços até a regularização do pagamento;`;

                    novaMarginTop = novaMarginTop + alturaTexto + spacingBetweenTextsA;
                    linhasTexto = doc.splitTextToSize(texto, textWidth);
                    alturaTexto = linhasTexto.length * spacingBetweenTextsA;

                    if ((novaMarginTop + alturaTexto) > 270) {doc.addPage(); novaMarginTop = marginTop;}

                    doc.setFont('helvetica', 'normal');
                    doc.setFontSize(12);
                    doc.text(texto, marginLeft, novaMarginTop, {maxWidth: textWidth, align: 'justify'});

                    //Texto
                    texto = `c) Rescindir o contrato, mediante notificação formal, caso o atraso seja superior a 15 (quinze) dias.`;

                    novaMarginTop = novaMarginTop + alturaTexto + spacingBetweenTextsA;
                    linhasTexto = doc.splitTextToSize(texto, textWidth);
                    alturaTexto = linhasTexto.length * spacingBetweenTextsA;

                    if ((novaMarginTop + alturaTexto) > 270) {doc.addPage(); novaMarginTop = marginTop;}

                    doc.setFont('helvetica', 'normal');
                    doc.setFontSize(12);
                    doc.text(texto, marginLeft, novaMarginTop, {maxWidth: textWidth, align: 'justify'});

                    //Texto
                    texto = `5.2. Caso o CONTRATADO não cumpra suas funções de forma adequada ou falte sem justificativa, o CONTRATANTE poderá:`;

                    novaMarginTop = novaMarginTop + alturaTexto + spacingBetweenTextsA;
                    linhasTexto = doc.splitTextToSize(texto, textWidth);
                    alturaTexto = linhasTexto.length * spacingBetweenTextsA;

                    if ((novaMarginTop + alturaTexto) > 270) {doc.addPage(); novaMarginTop = marginTop;}

                    doc.setFont('helvetica', 'normal');
                    doc.setFontSize(12);
                    doc.text(texto, marginLeft, novaMarginTop, {maxWidth: textWidth, align: 'justify'});

                    //Texto
                    texto = `a) Aplicar descontos proporcionais sobre os dias não trabalhados;`;

                    novaMarginTop = novaMarginTop + alturaTexto + spacingBetweenTextsA;
                    linhasTexto = doc.splitTextToSize(texto, textWidth);
                    alturaTexto = linhasTexto.length * spacingBetweenTextsA;

                    if ((novaMarginTop + alturaTexto) > 270) {doc.addPage(); novaMarginTop = marginTop;}

                    doc.setFont('helvetica', 'normal');
                    doc.setFontSize(12);
                    doc.text(texto, marginLeft, novaMarginTop, {maxWidth: textWidth, align: 'justify'});

                    //Texto
                    texto = `b) Rescindir o contrato de imediato, sem aviso prévio.`;

                    novaMarginTop = novaMarginTop + alturaTexto + spacingBetweenTextsA;
                    linhasTexto = doc.splitTextToSize(texto, textWidth);
                    alturaTexto = linhasTexto.length * spacingBetweenTextsA;

                    if ((novaMarginTop + alturaTexto) > 270) {doc.addPage(); novaMarginTop = marginTop;}

                    doc.setFont('helvetica', 'normal');
                    doc.setFontSize(12);
                    doc.text(texto, marginLeft, novaMarginTop, {maxWidth: textWidth, align: 'justify'});

                    //Texto
                    texto = `CLÁUSULA SEXTA - DURAÇÃO E RESCISÃO`;

                    novaMarginTop = novaMarginTop + alturaTexto + spacingBetweenTextsD;
                    linhasTexto = doc.splitTextToSize(texto, textWidth);
                    alturaTexto = linhasTexto.length * spacingBetweenTextsA;

                    if ((novaMarginTop + alturaTexto) > 270) {doc.addPage(); novaMarginTop = marginTop;}

                    doc.setFont('helvetica', 'bold');
                    doc.setFontSize(14);
                    doc.text(texto, marginLeft, novaMarginTop, {maxWidth: textWidth, align: 'justify'});

                    //Texto
                    texto = `6.1. O presente contrato terá vigência de [prazo: ex. 6 meses, 12 meses], a contar da data de assinatura, podendo ser prorrogado por acordo mútuo.`;

                    novaMarginTop = novaMarginTop + alturaTexto + spacingBetweenTextsA;
                    linhasTexto = doc.splitTextToSize(texto, textWidth);
                    alturaTexto = linhasTexto.length * spacingBetweenTextsA;

                    if ((novaMarginTop + alturaTexto) > 270) {doc.addPage(); novaMarginTop = marginTop;}

                    doc.setFont('helvetica', 'normal');
                    doc.setFontSize(12);
                    doc.text(texto, marginLeft, novaMarginTop, {maxWidth: textWidth, align: 'justify'});

                    //Texto
                    texto = `6.2. O contrato poderá ser rescindido:`;

                    novaMarginTop = novaMarginTop + alturaTexto + spacingBetweenTextsA;
                    linhasTexto = doc.splitTextToSize(texto, textWidth);
                    alturaTexto = linhasTexto.length * spacingBetweenTextsA;

                    if ((novaMarginTop + alturaTexto) > 270) {doc.addPage(); novaMarginTop = marginTop;}

                    doc.setFont('helvetica', 'normal');
                    doc.setFontSize(12);
                    doc.text(texto, marginLeft, novaMarginTop, {maxWidth: textWidth, align: 'justify'});

                    //Texto
                    texto = `a) Por mútuo acordo entre as partes;`;

                    novaMarginTop = novaMarginTop + alturaTexto + spacingBetweenTextsA;
                    linhasTexto = doc.splitTextToSize(texto, textWidth);
                    alturaTexto = linhasTexto.length * spacingBetweenTextsA;

                    if ((novaMarginTop + alturaTexto) > 270) {doc.addPage(); novaMarginTop = marginTop;}

                    doc.setFont('helvetica', 'normal');
                    doc.setFontSize(12);
                    doc.text(texto, marginLeft, novaMarginTop, {maxWidth: textWidth, align: 'justify'});

                    //Texto
                    texto = `b) Pela inadimplência do CONTRATANTE por mais de 15 dias;`;

                    novaMarginTop = novaMarginTop + alturaTexto + spacingBetweenTextsA;
                    linhasTexto = doc.splitTextToSize(texto, textWidth);
                    alturaTexto = linhasTexto.length * spacingBetweenTextsA;

                    if ((novaMarginTop + alturaTexto) > 270) {doc.addPage(); novaMarginTop = marginTop;}

                    doc.setFont('helvetica', 'normal');
                    doc.setFontSize(12);
                    doc.text(texto, marginLeft, novaMarginTop, {maxWidth: textWidth, align: 'justify'});

                    //Texto
                    texto = `c) Pelo descumprimento das obrigações estipuladas neste contrato;`;

                    novaMarginTop = novaMarginTop + alturaTexto + spacingBetweenTextsA;
                    linhasTexto = doc.splitTextToSize(texto, textWidth);
                    alturaTexto = linhasTexto.length * spacingBetweenTextsA;

                    if ((novaMarginTop + alturaTexto) > 270) {doc.addPage(); novaMarginTop = marginTop;}

                    doc.setFont('helvetica', 'normal');
                    doc.setFontSize(12);
                    doc.text(texto, marginLeft, novaMarginTop, {maxWidth: textWidth, align: 'justify'});

                    //Texto
                    texto = `d) Por falta grave do CONTRATADO, como negligência, abandono do posto ou conduta inadequada.`;

                    novaMarginTop = novaMarginTop + alturaTexto + spacingBetweenTextsA;
                    linhasTexto = doc.splitTextToSize(texto, textWidth);
                    alturaTexto = linhasTexto.length * spacingBetweenTextsA;

                    if ((novaMarginTop + alturaTexto) > 270) {doc.addPage(); novaMarginTop = marginTop;}

                    doc.setFont('helvetica', 'normal');
                    doc.setFontSize(12);
                    doc.text(texto, marginLeft, novaMarginTop, {maxWidth: textWidth, align: 'justify'});

                    //Texto
                    texto = `6.3. Em caso de rescisão sem justa causa, a parte que der causa deverá comunicar a outra com 15 (quinze) dias de antecedência.`;

                    novaMarginTop = novaMarginTop + alturaTexto + spacingBetweenTextsA;
                    linhasTexto = doc.splitTextToSize(texto, textWidth);
                    alturaTexto = linhasTexto.length * spacingBetweenTextsA;

                    if ((novaMarginTop + alturaTexto) > 270) {doc.addPage(); novaMarginTop = marginTop;}

                    doc.setFont('helvetica', 'normal');
                    doc.setFontSize(12);
                    doc.text(texto, marginLeft, novaMarginTop, {maxWidth: textWidth, align: 'justify'});

                    //Texto
                    texto = `CLÁUSULA SÉTIMA - RESPONSABILIDADE E SEGURANÇA`;

                    novaMarginTop = novaMarginTop + alturaTexto + spacingBetweenTextsD;
                    linhasTexto = doc.splitTextToSize(texto, textWidth);
                    alturaTexto = linhasTexto.length * spacingBetweenTextsA;

                    if ((novaMarginTop + alturaTexto) > 270) {doc.addPage(); novaMarginTop = marginTop;}

                    doc.setFont('helvetica', 'bold');
                    doc.setFontSize(14);
                    doc.text(texto, marginLeft, novaMarginTop, {maxWidth: textWidth, align: 'justify'});

                    //Texto
                    texto = `7.1. O CONTRATADO será responsável civil e criminalmente por qualquer ato de negligência ou imprudência que ocasione danos ao CONTRATANTE ou a terceiros.`;

                    novaMarginTop = novaMarginTop + alturaTexto + spacingBetweenTextsA;
                    linhasTexto = doc.splitTextToSize(texto, textWidth);
                    alturaTexto = linhasTexto.length * spacingBetweenTextsA;

                    if ((novaMarginTop + alturaTexto) > 270) {doc.addPage(); novaMarginTop = marginTop;}

                    doc.setFont('helvetica', 'normal');
                    doc.setFontSize(12);
                    doc.text(texto, marginLeft, novaMarginTop, {maxWidth: textWidth, align: 'justify'});

                    //Texto
                    texto = `7.2. O CONTRATANTE se compromete a fornecer um ambiente seguro e adequado para o desempenho das funções do CONTRATADO`;

                    novaMarginTop = novaMarginTop + alturaTexto + spacingBetweenTextsA;
                    linhasTexto = doc.splitTextToSize(texto, textWidth);
                    alturaTexto = linhasTexto.length * spacingBetweenTextsA;

                    if ((novaMarginTop + alturaTexto) > 270) {doc.addPage(); novaMarginTop = marginTop;}

                    doc.setFont('helvetica', 'normal');
                    doc.setFontSize(12);
                    doc.text(texto, marginLeft, novaMarginTop, {maxWidth: textWidth, align: 'justify'});

                    //Texto
                    texto = `CLÁUSULA OITAVA - DAS RESPONSABILIDADES FISCAIS E PREVIDENCIÁRIAS`;

                    novaMarginTop = novaMarginTop + alturaTexto + spacingBetweenTextsD;
                    linhasTexto = doc.splitTextToSize(texto, textWidth);
                    alturaTexto = linhasTexto.length * spacingBetweenTextsA;

                    if ((novaMarginTop + alturaTexto) > 270) {doc.addPage(); novaMarginTop = marginTop;}

                    doc.setFont('helvetica', 'bold');
                    doc.setFontSize(14);
                    doc.text(texto, marginLeft, novaMarginTop, {maxWidth: textWidth, align: 'justify'});

                    //Texto
                    texto = `8.1 A CONTRATADA assume integral responsabilidade pelo recolhimento de tributos, contribuições previdenciárias e quaisquer encargos decorrentes da prestação de serviços.`;

                    novaMarginTop = novaMarginTop + alturaTexto + spacingBetweenTextsC;
                    linhasTexto = doc.splitTextToSize(texto, textWidth);
                    alturaTexto = linhasTexto.length * spacingBetweenTextsA;

                    if ((novaMarginTop + alturaTexto) > 270) {doc.addPage(); novaMarginTop = marginTop;}

                    doc.setFont('helvetica', 'normal');
                    doc.setFontSize(12);
                    doc.text(texto, marginLeft, novaMarginTop, {maxWidth: textWidth, align: 'justify'});

                    //Texto
                    texto = `8.2. A CONTRATANTE está isenta de qualquer responsabilidade em relação a vínculos trabalhistas, previdenciários, ou fiscais da CONTRATADA ou de seus empregados e/ou colaboradores, ficando a cargo exclusivo da CONTRATADA todas as providências necessárias para cumprimento dessas obrigações.`;

                    novaMarginTop = novaMarginTop + alturaTexto + spacingBetweenTextsA;
                    linhasTexto = doc.splitTextToSize(texto, textWidth);
                    alturaTexto = linhasTexto.length * spacingBetweenTextsA;

                    if ((novaMarginTop + alturaTexto) > 270) {doc.addPage(); novaMarginTop = marginTop;}

                    doc.setFont('helvetica', 'normal');
                    doc.setFontSize(12);
                    doc.text(texto, marginLeft, novaMarginTop, {maxWidth: textWidth, align: 'justify'});

                    //Texto
                    texto = `8.3. A CONTRATADA obriga-se a isentar e indenizar a CONTRATANTE em caso de qualquer reclamação trabalhista, previdenciária ou fiscal promovida por terceiros contratados pelo CONTRATADO que venha a resultar em condenação ou ônus financeiro para a CONTRATANTE.`;

                    novaMarginTop = novaMarginTop + alturaTexto + spacingBetweenTextsA;
                    linhasTexto = doc.splitTextToSize(texto, textWidth);
                    alturaTexto = linhasTexto.length * spacingBetweenTextsA;

                    if ((novaMarginTop + alturaTexto) > 270) {doc.addPage(); novaMarginTop = marginTop;}

                    doc.setFont('helvetica', 'normal');
                    doc.setFontSize(12);
                    doc.text(texto, marginLeft, novaMarginTop, {maxWidth: textWidth, align: 'justify'});

                    //Texto
                    texto = `CLÁUSULA NONA -  DISPOSIÇÕES GERAIS`;

                    novaMarginTop = novaMarginTop + alturaTexto + spacingBetweenTextsD;
                    linhasTexto = doc.splitTextToSize(texto, textWidth);
                    alturaTexto = linhasTexto.length * spacingBetweenTextsA;

                    if ((novaMarginTop + alturaTexto) > 270) {doc.addPage(); novaMarginTop = marginTop;}

                    doc.setFont('helvetica', 'bold');
                    doc.setFontSize(14);
                    doc.text(texto, marginLeft, novaMarginTop, {maxWidth: textWidth, align: 'justify'});

                    //Texto
                    texto = `9.1. O presente contrato não gera vínculo empregatício, sendo o CONTRATADO um profissional autônomo, responsável por todas as suas obrigações previdenciárias e fiscais.`;

                    novaMarginTop = novaMarginTop + alturaTexto + spacingBetweenTextsA;
                    linhasTexto = doc.splitTextToSize(texto, textWidth);
                    alturaTexto = linhasTexto.length * spacingBetweenTextsA;

                    if ((novaMarginTop + alturaTexto) > 270) {doc.addPage(); novaMarginTop = marginTop;}

                    doc.setFont('helvetica', 'normal');
                    doc.setFontSize(12);
                    doc.text(texto, marginLeft, novaMarginTop, {maxWidth: textWidth, align: 'justify'});

                    //Texto
                    texto = `9.2. Qualquer alteração neste contrato deverá ser realizada mediante aditivo contratual, assinado por ambas as partes.`;

                    novaMarginTop = novaMarginTop + alturaTexto + spacingBetweenTextsA;
                    linhasTexto = doc.splitTextToSize(texto, textWidth);
                    alturaTexto = linhasTexto.length * spacingBetweenTextsA;

                    if ((novaMarginTop + alturaTexto) > 270) {doc.addPage(); novaMarginTop = marginTop;}

                    doc.setFont('helvetica', 'normal');
                    doc.setFontSize(12);
                    doc.text(texto, marginLeft, novaMarginTop, {maxWidth: textWidth, align: 'justify'});

                    //Texto
                    texto = `9.3. As partes elegem o foro da Comarca da Capital do Estado do Rio de Janeiro, para dirimir eventuais litígios decorrentes deste contrato.`;

                    novaMarginTop = novaMarginTop + alturaTexto + spacingBetweenTextsA;
                    linhasTexto = doc.splitTextToSize(texto, textWidth);
                    alturaTexto = linhasTexto.length * spacingBetweenTextsA;

                    if ((novaMarginTop + alturaTexto) > 270) {doc.addPage(); novaMarginTop = marginTop;}

                    doc.setFont('helvetica', 'normal');
                    doc.setFontSize(12);
                    doc.text(texto, marginLeft, novaMarginTop, {maxWidth: textWidth, align: 'justify'});

                    //Texto
                    texto = `E, por estarem justas e contratadas, as partes assinam o presente contrato em duas vias de igual teor e forma, na presença de duas testemunhas.`;

                    novaMarginTop = novaMarginTop + alturaTexto + spacingBetweenTextsA;
                    linhasTexto = doc.splitTextToSize(texto, textWidth);
                    alturaTexto = linhasTexto.length * spacingBetweenTextsA;

                    if ((novaMarginTop + alturaTexto) > 270) {doc.addPage(); novaMarginTop = marginTop;}

                    doc.setFont('helvetica', 'normal');
                    doc.setFontSize(12);
                    doc.text(texto, marginLeft, novaMarginTop, {maxWidth: textWidth, align: 'justify'});

                    //Texto
                    texto = dataExtenso(3, dataServidor(2));

                    novaMarginTop = novaMarginTop + alturaTexto + spacingBetweenTextsD;
                    linhasTexto = doc.splitTextToSize(texto, textWidth);
                    alturaTexto = linhasTexto.length * spacingBetweenTextsA;

                    if ((novaMarginTop + alturaTexto) > 270) {doc.addPage(); novaMarginTop = marginTop;}

                    doc.setFont('helvetica', 'normal');
                    doc.setFontSize(12);
                    doc.text(texto, marginLeft, novaMarginTop, {maxWidth: textWidth, align: 'justify'});

                    //Texto
                    texto = `______________________________________`;

                    novaMarginTop = novaMarginTop + alturaTexto + spacingBetweenTextsC;
                    linhasTexto = doc.splitTextToSize(texto, textWidth);
                    alturaTexto = linhasTexto.length * spacingBetweenTextsA;

                    if ((novaMarginTop + alturaTexto) > 270) {doc.addPage(); novaMarginTop = marginTop;}

                    doc.setFont('helvetica', 'normal');
                    doc.setFontSize(12);
                    doc.text(texto, marginLeft, novaMarginTop, {maxWidth: textWidth, align: 'justify'});

                    //Texto
                    texto = `CONTRATANTE`;

                    novaMarginTop = novaMarginTop + alturaTexto + spacingBetweenTextsA;
                    linhasTexto = doc.splitTextToSize(texto, textWidth);
                    alturaTexto = linhasTexto.length * spacingBetweenTextsA;

                    if ((novaMarginTop + alturaTexto) > 270) {doc.addPage(); novaMarginTop = marginTop;}

                    doc.setFont('helvetica', 'normal');
                    doc.setFontSize(12);
                    doc.text(texto, marginLeft, novaMarginTop, {maxWidth: textWidth, align: 'justify'});

                    //Texto
                    texto = `______________________________________`;

                    novaMarginTop = novaMarginTop + alturaTexto + spacingBetweenTextsC;
                    linhasTexto = doc.splitTextToSize(texto, textWidth);
                    alturaTexto = linhasTexto.length * spacingBetweenTextsA;

                    if ((novaMarginTop + alturaTexto) > 270) {doc.addPage(); novaMarginTop = marginTop;}

                    doc.setFont('helvetica', 'normal');
                    doc.setFontSize(12);
                    doc.text(texto, marginLeft, novaMarginTop, {maxWidth: textWidth, align: 'justify'});

                    //Texto
                    texto = `CONTRATADO`;

                    novaMarginTop = novaMarginTop + alturaTexto + spacingBetweenTextsA;
                    linhasTexto = doc.splitTextToSize(texto, textWidth);
                    alturaTexto = linhasTexto.length * spacingBetweenTextsA;

                    if ((novaMarginTop + alturaTexto) > 270) {doc.addPage(); novaMarginTop = marginTop;}

                    doc.setFont('helvetica', 'normal');
                    doc.setFontSize(12);
                    doc.text(texto, marginLeft, novaMarginTop, {maxWidth: textWidth, align: 'justify'});

                    //Texto
                    texto = `________________________________`;

                    novaMarginTop = novaMarginTop + alturaTexto + spacingBetweenTextsC;
                    linhasTexto = doc.splitTextToSize(texto, textWidth);
                    alturaTexto = linhasTexto.length * spacingBetweenTextsA;

                    if ((novaMarginTop + alturaTexto) > 270) {doc.addPage(); novaMarginTop = marginTop;}

                    doc.setFont('helvetica', 'normal');
                    doc.setFontSize(12);
                    doc.text(texto, marginLeft, novaMarginTop, {maxWidth: textWidth, align: 'justify'});

                    //Texto
                    texto = `TESTEMUNHA 1:`;

                    novaMarginTop = novaMarginTop + alturaTexto + spacingBetweenTextsA;
                    linhasTexto = doc.splitTextToSize(texto, textWidth);
                    alturaTexto = linhasTexto.length * spacingBetweenTextsA;

                    if ((novaMarginTop + alturaTexto) > 270) {doc.addPage(); novaMarginTop = marginTop;}

                    doc.setFont('helvetica', 'normal');
                    doc.setFontSize(12);
                    doc.text(texto, marginLeft, novaMarginTop, {maxWidth: textWidth, align: 'justify'});

                    //Texto
                    texto = `CPF:`;

                    novaMarginTop = novaMarginTop + alturaTexto + spacingBetweenTextsA;
                    linhasTexto = doc.splitTextToSize(texto, textWidth);
                    alturaTexto = linhasTexto.length * spacingBetweenTextsA;

                    if ((novaMarginTop + alturaTexto) > 270) {doc.addPage(); novaMarginTop = marginTop;}

                    doc.setFont('helvetica', 'normal');
                    doc.setFontSize(12);
                    doc.text(texto, marginLeft, novaMarginTop, {maxWidth: textWidth, align: 'justify'});

                    //Texto
                    texto = `________________________________`;

                    novaMarginTop = novaMarginTop + alturaTexto + spacingBetweenTextsC;
                    linhasTexto = doc.splitTextToSize(texto, textWidth);
                    alturaTexto = linhasTexto.length * spacingBetweenTextsA;

                    if ((novaMarginTop + alturaTexto) > 270) {doc.addPage(); novaMarginTop = marginTop;}

                    doc.setFont('helvetica', 'normal');
                    doc.setFontSize(12);
                    doc.text(texto, marginLeft, novaMarginTop, {maxWidth: textWidth, align: 'justify'});

                    //Texto
                    texto = `TESTEMUNHA 2:`;

                    novaMarginTop = novaMarginTop + alturaTexto + spacingBetweenTextsA;
                    linhasTexto = doc.splitTextToSize(texto, textWidth);
                    alturaTexto = linhasTexto.length * spacingBetweenTextsA;

                    if ((novaMarginTop + alturaTexto) > 270) {doc.addPage(); novaMarginTop = marginTop;}

                    doc.setFont('helvetica', 'normal');
                    doc.setFontSize(12);
                    doc.text(texto, marginLeft, novaMarginTop, {maxWidth: textWidth, align: 'justify'});

                    //Texto
                    texto = `CPF:`;

                    novaMarginTop = novaMarginTop + alturaTexto + spacingBetweenTextsA;
                    linhasTexto = doc.splitTextToSize(texto, textWidth);
                    alturaTexto = linhasTexto.length * spacingBetweenTextsA;

                    if ((novaMarginTop + alturaTexto) > 270) {doc.addPage(); novaMarginTop = marginTop;}

                    doc.setFont('helvetica', 'normal');
                    doc.setFontSize(12);
                    doc.text(texto, marginLeft, novaMarginTop, {maxWidth: textWidth, align: 'justify'});
                    //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

                    //Rodapé''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
                    // var footer_text_1_margin_left = 105;
                    // var footer_text_2_margin_left = 125;
                    // var data_hora = dataServidor(2) + ' às ' + horaServidor(2);
                    //
                    // doc.setFontSize(10);
                    // doc.text('Gerado pelo Sistema SAC', pageWidth / 2, pageHeight - 15, {align: 'center'});
                    // doc.text(data_hora, pageWidth / 2, pageHeight - 10, {align: 'center'});
                    //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
                });

                //Gerar o pdf, abrir em uma outra aba e colocar link para download''''''''''''''''''''''''''''''''''''''
                const pdfBlob = doc.output('blob');
                const pdfUrl = URL.createObjectURL(pdfBlob);

                //Tentar abrir em uma nova aba
                const newTab = window.open(pdfUrl);

                //Adiciona um link abaixo do botão
                let funcionario_acao_1_botoes = document.getElementById('funcionario_acao_1_botoes');

                //Verifica se já existe um link para evitar duplicação
                let existingLink = document.getElementById('pdf_download_link');
                if (existingLink) {
                    existingLink.href = pdfUrl; // Atualiza o link existente
                    return;
                }

                //Cria o link dinamicamente
                let link = document.createElement('a');
                link.id = 'pdf_download_link';
                link.href = pdfUrl;
                link.download = 'documento.pdf';
                link.textContent = 'Clique aqui para baixar o PDF';

                //Estiliza o link para ficar vermelho
                link.style.color = 'red';
                link.style.textDecoration = 'underline';
                link.style.display = 'block';
                link.style.marginTop = '10px';

                //Insere o link logo abaixo do botão
                funcionario_acao_1_botoes.parentNode.insertBefore(link, funcionario_acao_1_botoes.nextSibling);
                //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            }
        }).catch(error => {
            alert('Erro funcionario_acao_1_gerar_pdf: ' + error);
        });
    }
}

/*
* Validar valor recebido
* Retorna true se valor foi validado
* Retorna false se valor não foi validado
*
* @PARAM op=1 : Campo Requerido
* @PARAM op=2 : Mínimo de Caracteres
* @PARAM op=3 : Máximo de Caracteres
* @PARAM op=4 : Somente Números
* @PARAM op=5 : E-mail Válido
* @PARAM op=6 : CNPJ Válido
* @PARAM op=7 : CPF Válido
* @PARAM op=8 : Data Válida
* @PARAM op=9 : CEP Válido
* @PARAM op=10 : URL Válida
* @PARAM op=11 : Telefone Válido
* @PARAM op=12 : Celular Válido
* @PARAM op=13 : PIS Válido
* @PARAM op=14 : PASEP Válido
* @PARAM op=15 : Carteira Trabalho Válido
* @PARAM op=16 : Campo FILE com arquivo PDF (enviar id do elemento)
* @PARAM op=17 : Hora Válida
 */
function validacao({op=0, value='', minCaracteres=0, maxCaracteres=0, id=''}) {
    var regex;

    //Campo Requerido
    if (op == 1) {
        //Expressão regular que verifica se a entrada é vazia ou contém apenas espaços em branco
        regex = /^\s*$/;

        //Verificando
        if (regex.test(value) === true) {
            return false;
        } else {
            return true;
        }
    }

    //Mínimo de Caracteres
    if (op == 2) {
        //Expressão regular que verifica se a entrada tem pelo menos 'minimo' caracteres
        regex = new RegExp(`^.{${minCaracteres},}$`);

        //Verificando
        if (regex.test(value) === true) {
            return true;
        } else {
            return false;
        }
    }

    //Máximo de Caracteres
    if (op == 3) {
        //Expressão regular que verifica se a entrada tem no máximo 'maximo' caracteres
        regex = new RegExp(`^.{0,${maxCaracteres}}$`);

        //Verificando
        if (regex.test(value) === true) {
            return true;
        } else {
            return false;
        }
    }

    //Somente Números
    if (op == 4) {
        //Expressão regular que verifica se a entrada contém somente números
        regex = /^[0-9]+$/;

        //Verificando
        if (regex.test(value) === true) {
            return true;
        } else {
            return false;
        }
    }

    //E-mail Válido
    if (op == 5) {
        //Expressão regular para validar endereços de e-mail
        regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        //Verificando
        if (regex.test(value) === true) {
            return true;
        } else {
            return false;
        }
    }

    //CNPJ Válido
    if (op == 6) {
        //Remover caracteres não numéricos
        value = value.replace(/\D/g, '');

        //Verificar se CNPJ possui 14 dígitos
        if (value.length !== 14) return false;

        //Verificar se todos os dígitos são iguais
        if (/^(\d)\1+$/.test(value)) return false;

        //Validar dígitos verificadores
        const peso = [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
        let soma = 0;
        for (let i = 0; i < 12; i++) {
            soma += parseInt(value.charAt(i)) * peso[i + 1];
        }
        let resto = soma % 11;
        let digitoVerificador1 = resto < 2 ? 0 : 11 - resto;
        if (parseInt(value.charAt(12)) !== digitoVerificador1) return false;

        soma = 0;
        for (let i = 0; i < 13; i++) {
            soma += parseInt(value.charAt(i)) * peso[i];
        }
        resto = soma % 11;
        let digitoVerificador2 = resto < 2 ? 0 : 11 - resto;

        return parseInt(value.charAt(13)) === digitoVerificador2;
    }

    //CPF Válido
    if (op == 7) {
        //Remover caracteres não numéricos
        value = value.replace(/\D/g, '');

        //Verificar se o CPF possui 11 dígitos
        if (value.length !== 11) return false;

        //Verificar se todos os dígitos são iguais
        if (/^(\d)\1+$/.test(value)) return false;

        //Validar dígitos verificadores
        let soma = 0;
        let resto;
        for (let i = 1; i <= 9; i++) {
            soma += parseInt(value.charAt(i - 1)) * (11 - i);
        }
        resto = (soma * 10) % 11;
        if (resto === 10 || resto === 11) resto = 0;
        if (resto !== parseInt(value.charAt(9))) return false;

        soma = 0;
        for (let i = 1; i <= 10; i++) {
            soma += parseInt(value.charAt(i - 1)) * (12 - i);
        }
        resto = (soma * 10) % 11;
        if (resto === 10 || resto === 11) resto = 0;

        return resto === parseInt(value.charAt(10));
    }

    //Data Válida
    if (op == 8) {
        //Expressão regular para verificar o formato da data (DD/MM/AAAA)
        regex = /^(0[1-9]|[12][0-9]|3[01])\/(0[1-9]|1[0-2])\/\d{4}$/;

        //Verificando
        if (regex.test(value) === true) {
            return true;
        } else {
            return false;
        }
    }

    //CEP Válido
    if (op == 9) {
        //Expressão regular para verificar o formato do CEP (XXXXX-XXX)
        regex = /^\d{5}-\d{3}$/;

        //Verificando
        if (regex.test(value) === true) {
            return true;
        } else {
            return false;
        }
    }

    //URL Válida
    if (op == 10) {
        //Expressão regular para verificar o formato básico da URL
        regex = /^(ftp|http|https):\/\/[^ "]+$/;

        //Verificando
        if (regex.test(value) === true) {
            return true;
        } else {
            return false;
        }
    }

    //Telefone Válido
    if (op == 11) {
        //Expressão regular para validar números de telefone brasileiros
        regex = /^\(?\d{2}\)?[-.\s]?\d{4,5}[-.\s]?\d{4}$/;

        //Verificando
        if (regex.test(value) === true) {
            return true;
        } else {
            return false;
        }
    }

    //Celular Válido
    if (op == 12) {
        //Expressão regular para validar números de celular brasileiros
        regex = /^\(?\d{2}\)?[-.\s]?\d{5}[-.\s]?\d{4}$/;

        //Verificando
        if (regex.test(value) === true) {
            return true;
        } else {
            return false;
        }
    }

    //PIS Válido
    if (op == 13) {
        //Expressão regular para validar números de PIS brasileiros
        regex = /^\d{3}\.\d{5}\.\d{2}-\d$/;

        //Verificando
        if (regex.test(value) === true) {
            return true;
        } else {
            return false;
        }
    }

    //PASEP Válido
    if (op == 14) {
        //Expressão regular para validar números de PASEP brasileiros
        regex = /^\d{3}\.\d{5}\.\d{2}-\d$/;

        //Verificando
        if (regex.test(value) === true) {
            return true;
        } else {
            return false;
        }
    }

    //Carteira Trabalho Válido
    if (op == 15) {
        //Expressão regular para validar números de CTPS brasileiros
        regex = /^\d{7,14}$/;

        //Verificando
        if (regex.test(value) === true) {
            return true;
        } else {
            return false;
        }
    }

    //Campo FILE com arquivo PDF
    if (op == 16) {
        let elemento = document.getElementById(id);
        const file = elemento.files[0]; // Obtém o primeiro arquivo selecionado

        //verificar se é vazio
        if (!file) {
            return false;
        }

        //verificar se é um PDF (MIME type ou extensão)
        if (file.type !== "application/pdf" && !file.name.endsWith(".pdf")) {
            elemento.value = ''; //Limpa o campo caso não seja um PDF
            return false;
        }

        return true;
    }

    //Hora Válida
    if (op == 17) {
        //Expressão regular para verificar o formato da hora (HH:mm:ss)
        regex = /^(0[0-9]|1[0-9]|2[0-3]):([0-5][0-9]):([0-5][0-9])$/;

        //Verificando
        if (regex.test(value) === true) {
            return true;
        } else {
            return false;
        }
    }

    //Campo FILE com arquivo IMG
    if (op == 18) {
        let elemento = document.getElementById(id);
        const file = elemento.files[0]; // Obtém o primeiro arquivo selecionado

        // Verificar se está vazio
        if (!file) {
            return false;
        }

        // Tipos MIME permitidos para imagens
        const tiposPermitidos = ["image/png", "image/jpeg", "image/gif"];

        // Extensões permitidas (em minúsculo)
        const extensoesPermitidas = [".png", ".jpg", ".jpeg", ".gif"];

        const nomeArquivo = file.name.toLowerCase();
        const tipoValido = tiposPermitidos.includes(file.type);
        const extensaoValida = extensoesPermitidas.some(ext => nomeArquivo.endsWith(ext));
        if (!tipoValido && !extensaoValida) {
            elemento.value = ''; // Limpa o campo se não for imagem válida
            return false;
        }

        return true;
    }

    // Campo com duas decimais (valores monetários)
    if (op == 19) {
        // Expressão regular que verifica se a entrada é um valor decimal de 0,00 até infinito
        regex = /^\d{1,3}(\.\d{3})*,\d{2}$/;

        // Verificando
        if (regex.test(value) === true) {
            return true;
        } else {
            return false;
        }
    }
}

//Código para Acessar Câmera Frontal e Traseira - Início''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
//Código para Acessar Câmera Frontal e Traseira - Início''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

//Função para iniciar a captura da câmera
function startCameraFrontal() {
    //Verifica se o navegador suporta a API de captura de mídia
    if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
        //Solicita permissão para acessar a câmera
        navigator.mediaDevices.getUserMedia({ video: { facingMode: 'user' } })
            .then(function (stream) {
                //O usuário concedeu permissão para acessar a câmera (Obtém elementos do DOM)
                const videoFrontal = document.getElementById('videoFrontal');
                videoFrontal.srcObject = stream;
                videoFrontal.play();
            })
            .catch(function (error) {
                // O usuário negou a permissão ou ocorreu um erro
                alert('Erro ao acessar a câmera:'+error);
            });
    } else {
        alert('Seu navegador não suporta a API de captura de mídia.');
    }
}

//Função para parar a captura da câmera
function stopCameraFrontal() {
    const videoFrontal = document.getElementById('videoFrontal');
    const tracksFrontal = videoFrontal.srcObject.getTracks();

    tracksFrontal.forEach(function (track) {
        track.stop(); // Para cada faixa de vídeo
    });
}

//Função para iniciar a captura da câmera traseira
function startCameraTraseira() {
    //Verifica se o navegador suporta a API de captura de mídia
    if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
        //Solicita permissão para acessar a câmera
        navigator.mediaDevices.getUserMedia({ video: { facingMode: 'environment' } })
            .then(function (stream) {
                //O usuário concedeu permissão para acessar a câmera (Obtém elementos do DOM)
                const videoTraseira = document.getElementById('videoTraseira');
                videoTraseira.srcObject = stream;
                videoTraseira.play();
            })
            .catch(function (error) {
                // O usuário negou a permissão ou ocorreu um erro
                alert('Erro ao acessar a câmera:'+error);
            });
    } else {
        alert('Seu navegador não suporta a API de captura de mídia.');
    }
}

//Função para parar a captura da câmera traseira
function stopCameraTraseira() {
    const videoTraseira = document.getElementById('videoTraseira');
    const tracks = videoTraseira.srcObject.getTracks();

    tracks.forEach(function (track) {
        track.stop(); // Para cada faixa de vídeo
    });
}
//Código para Acessar Câmera Frontal e Traseira - Fim'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
//Código para Acessar Câmera Frontal e Traseira - Fim'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

function fornecedorExtraData(id='') {
    //Limpando dados
    $('.jsonFornecedor').html('');

    //Verificar se mandou id ou se veio do registro_id
    if (id == '') {id = $('#registro_id').val();}

    //URL
    var url_atual = window.location.protocol+'//'+window.location.host+'/';

    //Ajax
    $.ajax({
        processing: true,
        serverSide: true,
        type: "GET",
        url: url_atual+"fornecedores/extradata/"+id,
        data: {},
        datatype: "json",
        success: function (response) {
            //Lendo json
            let json = JSON.parse(response);

            //Lendo dados Fornecedor
            let fornecedor = json.fornecedor;

            //Passando dados Fornecedor
            $('.jsonFornecedorName').html(fornecedor.name);

            if (fornecedor.status == '1') {nameStatus = 'Ativo';}
            if (fornecedor.status == '2') {nameStatus = 'Inativo';}
            $('.jsonFornecedorStatus').html(nameStatus);

            if (fornecedor.tipo == '1') {
                $('.jsonFornecedorTipo').html('Pessoa Jurídica');
                $('.labelFornecedorCnpjCpf').html('CNPJ');
                $('.jsonFornecedorCnpj').html(aplicarMascaraJs(fornecedor.cnpj, '##.###.###/####-##'));
            }

            if (fornecedor.tipo == '2') {
                $('.jsonFornecedorTipo').html('Pessoa Física');
                $('.labelFornecedorCnpjCpf').html('CPF');
                $('.jsonFornecedorCpf').html(aplicarMascaraJs(fornecedor.cpf, '###.###.###-##'));
            }

            //Informações Gerais
            $('.jsonFornecedorSite').html(fornecedor.site);
            $('.jsonFornecedorEmail').html(fornecedor.email);

            if (fornecedor.telefone_1 != '' && fornecedor.telefone_1 !== null) {$('.jsonFornecedorContatoTelefone1').html(aplicarMascaraJs(fornecedor.telefone_1, '(##) #####-####'));}
            if (fornecedor.telefone_2 != '' && fornecedor.telefone_2 !== null) {$('.jsonFornecedorContatoTelefone2').html(aplicarMascaraJs(fornecedor.telefone_2, '(##) #####-####'));}
            if (fornecedor.celular_1 != '' && fornecedor.celular_1 !== null) {$('.jsonFornecedorContatoCelular1').html(aplicarMascaraJs(fornecedor.celular_1, '(##) #####-####'));}
            if (fornecedor.celular_2 != '' && fornecedor.celular_2 !== null) {$('.jsonFornecedorContatoCelular2').html(aplicarMascaraJs(fornecedor.celular_2, '(##) #####-####'));}

            //Lendo dados servicos''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            let fornecedor_compras = json.fornecedor_compras;

            var tbodyCompras = '';

            //Passando dados compras (Tabela)
            var row = 0;

            function montarTable(item) {
                row++;

                xxx = item.xxx;
                yyy = item.yyy;

                tbodyCompras += "<tr>";
                tbodyCompras += "<th scope='row'>" + row + "</th>";
                tbodyCompras += "<td>" + xxx + "</td>";
                tbodyCompras += "<td>" + yyy + "</td>";
                tbodyCompras += "</tr>";
            }

            fornecedor_compras.forEach(montarTable);

            //Destruindo e iniciando (Simulando um Refresh)
            $('.class-datatable-2').DataTable().destroy();
            $('.jsonFornecedorComprasTable').html(tbodyCompras);

            configurarDataTable(2);

            //Alterar tamanho do input Pesquisar da tabela
            $('.dataTables_filter .fildFilterTable').attr('style',  'width:150px');
            //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        },
        complete: function () {},
        error: function (response) {
            alert('ERROR: '+response);
        }
    });
}

//Marcar permissão -list quando escolher qualquer outra
function checkedPermissaoTable(opClick, submodulo_id) {
    //opClick = 1 : Clicou em todos_listar
    if (opClick == 1) {
        if ($('#todos_listar').is(':checked') == true) {
            for (id = 1; id <= 100; id++) {
                $('#listar_' + id).prop('checked', true);
            }
        } else {
            $('#todos_mostrar').prop('checked', false);
            $('#todos_criar').prop('checked', false);
            $('#todos_editar').prop('checked', false);
            $('#todos_deletar').prop('checked', false);

            for (id = 1; id <= 100; id++) {
                $('#listar_' + id).prop('checked', false);
                $('#mostrar_' + id).prop('checked', false);
                $('#criar_' + id).prop('checked', false);
                $('#editar_' + id).prop('checked', false);
                $('#deletar_' + id).prop('checked', false);
            }
        }
    }

    //opClick = 2 : Clicou em todos_mostrar
    if (opClick == 2) {
        if ($('#todos_mostrar').is(':checked') == true) {
            $('#todos_listar').prop('checked', true);

            for (id = 1; id <= 100; id++) {
                $('#mostrar_' + id).prop('checked', true);

                $('#listar_' + id).prop('checked', true);
            }
        } else {
            for (id = 1; id <= 100; id++) {
                $('#mostrar_' + id).prop('checked', false);
            }
        }
    }

    //opClick = 3 : Clicou em todos_criar
    if (opClick == 3) {
        if ($('#todos_criar').is(':checked') == true) {
            for (id = 1; id <= 100; id++) {
                $('#criar_' + id).prop('checked', true);

                $('#todos_listar').prop('checked', true);
                $('#listar_' + id).prop('checked', true);
            }
        } else {
            for (id = 1; id <= 100; id++) {
                $('#criar_' + id).prop('checked', false);
            }
        }
    }

    //opClick = 4 : Clicou em todos_editar
    if (opClick == 4) {
        if ($('#todos_editar').is(':checked') == true) {
            for (id = 1; id <= 100; id++) {
                $('#editar_' + id).prop('checked', true);

                $('#todos_listar').prop('checked', true);
                $('#listar_' + id).prop('checked', true);
            }
        } else {
            for (id = 1; id <= 100; id++) {
                $('#editar_' + id).prop('checked', false);
            }
        }
    }

    //opClick = 5 : Clicou em todos_deletar
    if (opClick == 5) {
        if ($('#todos_deletar').is(':checked') == true) {
            for (id = 1; id <= 100; id++) {
                $('#deletar_' + id).prop('checked', true);

                $('#todos_listar').prop('checked', true);
                $('#listar_' + id).prop('checked', true);
            }
        } else {
            for (id = 1; id <= 100; id++) {
                $('#deletar_' + id).prop('checked', false);
            }
        }
    }

    //opClick = 6 : Clicou em listar_
    if (opClick == 6) {
        if ($('#listar_' + submodulo_id).is(':checked') == false) {
            $('#todos_mostrar').prop('checked', false);
            $('#mostrar_' + submodulo_id).prop('checked', false);

            $('#todos_criar').prop('checked', false);
            $('#criar_' + submodulo_id).prop('checked', false);

            $('#todos_editar').prop('checked', false);
            $('#editar_' + submodulo_id).prop('checked', false);

            $('#todos_deletar').prop('checked', false);
            $('#deletar_' + submodulo_id).prop('checked', false);
        }
    }

    //opClick = 7 : Clicou em mostrar_
    if (opClick == 7) {
        if ($('#mostrar_' + submodulo_id).is(':checked') == true) {
            $('#listar_' + submodulo_id).prop('checked', true);
        }

        if ($('#mostrar_' + submodulo_id).is(':checked') == false) {
            $('#todos_mostrar').prop('checked', false);
        }
    }

    //opClick = 8 : Clicou em criar_
    if (opClick == 8) {
        if ($('#criar_' + submodulo_id).is(':checked') == true) {
            $('#listar_' + submodulo_id).prop('checked', true);
        }

        if ($('#criar_' + submodulo_id).is(':checked') == false) {
            $('#todos_criar').prop('checked', false);
        }
    }
    //opClick = 9 : Clicou em editar_
    if (opClick == 9) {
        if ($('#editar_' + submodulo_id).is(':checked') == true) {
            $('#listar_' + submodulo_id).prop('checked', true);
        }

        if ($('#editar_' + submodulo_id).is(':checked') == false) {
            $('#todos_editar').prop('checked', false);
        }
    }
    //opClick = 10 : Clicou em deletar_
    if (opClick == 10) {
        if ($('#deletar_' + submodulo_id).is(':checked') == true) {
            $('#listar_' + submodulo_id).prop('checked', true);
        }

        if ($('#deletar_' + submodulo_id).is(':checked') == false) {
            $('#todos_deletar').prop('checked', false);
        }
    }
}

//Modal de Confirmação
function alertSwalConfirmacao(message = '') {
    if (message == '') { message = 'Confirma operação?'; }

    return Swal.fire({
        title: message,
        text: '',
        icon: 'question',
        showDenyButton: true,
        confirmButtonText: '<i class="fa fa-thumbs-up"></i> Confirmar',
        confirmButtonColor: '#38c172',
        denyButtonText: `<i class="fa fa-thumbs-down"></i> Cancelar`,
        denyButtonColor: '#e3342f',
        customClass: {
            container: '...',
            popup: 'small',
            title: 'h5',
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-primary'
        }
    }).then(result => result.isConfirmed);
}

//Modal de Confirmação com submit
function alertSwalConfirmacaoSubmit(frm_name) {
    Swal.fire({
        title: 'Confirma operação?',
        text: '',
        icon: 'question',
        showDenyButton: true,
        confirmButtonText: '<i class="fa fa-thumbs-up"></i> Confirmar',
        confirmButtonColor: '#38c172',
        denyButtonText: `<i class="fa fa-thumbs-down"></i> Cancelar`,
        denyButtonColor: '#e3342f',
        customClass: {
            container: '...',
            popup: 'small',
            header: '...',
            title: 'h5',
            closeButton: '...',
            icon: 'small',
            image: '...',
            content: '...',
            htmlContainer: '...',
            input: '...',
            inputLabel: '...',
            validationMessage: '...',
            actions: '...',
            confirmButton: 'btn btn-success',
            denyButton: '...',
            cancelButton: 'btn btn-primary',
            loader: '...',
            footer: '....'
        }
    }).then((confirmed) => {
        $('#'+frm_name).submit();
    });
}

//Modal para Mensagens
function alertSwal(icon='success', title='', html='', showConfirmButton=false, timer=2000) {
    Swal.fire({
        icon: icon,
        title: title,
        html: html,
        showConfirmButton: showConfirmButton,
        timer: timer
    });
}

//visualizar a imagem da font awesome em uma div ao lado
function viewFontAwesome(field) {
    if ($('#'+field).val() != '') {
        const image_view = $('#image_view');
        image_view.attr('class', $('#'+field).val());
    }
}

//Retorna data Servidor
//op=1 : 9999-99-99
//op=2 : 99/99/9999
function dataServidor(op) {
    //Dados
    var data = new Date();
    var dia = String(data.getDate()).padStart(2, '0');
    var mes = String(data.getMonth() + 1).padStart(2, '0');
    var ano = data.getFullYear();

    //Retorno
    if (op == 1) {return ano+'-'+mes+'-'+dia;}
    if (op == 2) {return dia+'/'+mes+'/'+ano;}
}

//Retorna hora Servidor
//op=1 : H:m:s
//op=2 : H:m
function horaServidor(op) {
    //Dados
    var data = new Date();
    var hora = data.getHours().toString();
    var minutos = data.getMinutes().toString();
    var segundos = data.getSeconds().toString();

    //Acertos
    if (hora.length == 1) {hora = '0'+hora;}
    if (minutos.length == 1) {minutos = '0'+minutos;}
    if (segundos.length == 1) {segundos = '0'+segundos;}

    //Retorno
    if (op == 1) {return hora+':'+minutos+':'+segundos;}
    if (op == 2) {return hora+':'+minutos;}
}

//Retorna data por extenso
//op=1, data=14/04/2023 : Sexta-feira, 14 de Abril de 2023
//op=2, data=14/04/2023 : Rio de Janeiro, 14 de Abril de 2023
//op=3, data=14/04/2023 : Rio de Janeiro, Sexta-feira, 14 de Abril de 2023

function dataExtenso(op, data_informada) {
    meses = new Array("Janeiro","Fevereiro","Março","Abril","Maio","Junho","Julho","Agosto","Setembro","Outubro","Novembro","Dezembro");
    semana = new Array("Domingo","Segunda-feira","Terça-feira","Quarta-feira","Quinta-feira","Sexta-feira","Sábado");

    var dia_informado = data_informada.split('/')[0];
    var mes_informado = data_informada.split('/')[1];
    var ano_informado = data_informada.split('/')[2];
    var data = ano_informado + '-' + mes_informado + '-' + dia_informado + " 00:00:00";
    var dataInfo = new Date(data);
    var dia = dataInfo.getDate();
    var dias = dataInfo.getDay();
    var mes = dataInfo.getMonth();
    var ano = dataInfo.getFullYear();

    if (op == 1) {
        var dataext = semana[dias] + ", " + dia + " de " + meses[mes] + " de " + ano;
    }

    if (op == 2) {
        var dataext = "Rio de Janeiro, " + dia + " de " + meses[mes] + " de " + ano;
    }

    if (op == 3) {
        var dataext = "Rio de Janeiro, " + semana[dias] + ", " + dia + " de " + meses[mes] + " de " + ano;
    }

    return dataext;
}

function valorExtenso(vlr) {
    var Num=parseFloat(vlr);

    if (vlr == 0) {
        return "Zero";
    } else {
        var inteiro = parseInt(vlr);; // parte inteira do valor

        if(inteiro<1000000000000000) {
            var resto = Num.toFixed(2) - inteiro.toFixed(2);       // parte fracionária do valor
            resto=resto.toFixed(2)
            var vlrS =  inteiro.toString();

            var cont=vlrS.length;
            var extenso="";
            var auxnumero;
            var auxnumero2;
            var auxnumero3;

            var unidade =["", "um", "dois", "três", "quatro", "cinco",
                "seis", "sete", "oito", "nove", "dez", "onze",
                "doze", "treze", "quatorze", "quinze", "dezesseis",
                "dezessete", "dezoito", "dezenove"];

            var centena = ["", "cento", "duzentos", "trezentos",
                "quatrocentos", "quinhentos", "seiscentos",
                "setecentos", "oitocentos", "novecentos"];

            var dezena = ["", "", "vinte", "trinta", "quarenta", "cinquenta",
                "sessenta", "setenta", "oitenta", "noventa"];

            var qualificaS = ["reais", "mil", "milhão", "bilhão", "trilhão"];
            var qualificaP = ["reais", "mil", "milhões", "bilhões", "trilhões"];

            for (var i=cont;i > 0;i--)
            {
                var verifica1="";
                var verifica2=0;
                var verifica3=0;
                auxnumero2="";
                auxnumero3="";
                auxnumero=0;
                auxnumero2 = vlrS.substr(cont-i,1);
                auxnumero = parseInt(auxnumero2);


                if((i==14)||(i==11)||(i==8)||(i==5)||(i==2))
                {
                    auxnumero2 = vlrS.substr(cont-i,2);
                    auxnumero = parseInt(auxnumero2);
                }

                if((i==15)||(i==12)||(i==9)||(i==6)||(i==3))
                {
                    extenso=extenso+centena[auxnumero];
                    auxnumero2 = vlrS.substr(cont-i+1,1)
                    auxnumero3 = vlrS.substr(cont-i+2,1)

                    if((auxnumero2!="0")||(auxnumero3!="0"))
                        extenso+=" e ";

                }else

                if(auxnumero>19){
                    auxnumero2 = vlrS.substr(cont-i,1);
                    auxnumero = parseInt(auxnumero2);
                    extenso=extenso+dezena[auxnumero];
                    auxnumero3 = vlrS.substr(cont-i+1,1)

                    if((auxnumero3!="0")&&(auxnumero2!="1"))
                        extenso+=" e ";
                }
                else if((auxnumero<=19)&&(auxnumero>9)&&((i==14)||(i==11)||(i==8)||(i==5)||(i==2)))
                {
                    extenso=extenso+unidade[auxnumero];
                }else if((auxnumero<10)&&((i==13)||(i==10)||(i==7)||(i==4)||(i==1)))
                {
                    auxnumero3 = vlrS.substr(cont-i-1,1);
                    if((auxnumero3!="1")&&(auxnumero3!=""))
                        extenso=extenso+unidade[auxnumero];
                }

                if(i%3==1)
                {
                    verifica3 = cont-i;
                    if(verifica3==0)
                        verifica1 = vlrS.substr(cont-i,1);

                    if(verifica3==1)
                        verifica1 = vlrS.substr(cont-i-1,2);

                    if(verifica3>1)
                        verifica1 = vlrS.substr(cont-i-2,3);

                    verifica2 = parseInt(verifica1);

                    if(i==13)
                    {
                        if(verifica2==1){
                            extenso=extenso+" "+qualificaS[4]+" ";
                        }else if(verifica2!=0){extenso=extenso+" "+qualificaP[4]+" ";}}
                    if(i==10)
                    {
                        if(verifica2==1){
                            extenso=extenso+" "+qualificaS[3]+" ";
                        }else if(verifica2!=0){extenso=extenso+" "+qualificaP[3]+" ";}}
                    if(i==7)
                    {
                        if(verifica2==1){
                            extenso=extenso+" "+qualificaS[2]+" ";
                        }else if(verifica2!=0){extenso=extenso+" "+qualificaP[2]+" ";}}
                    if(i==4)
                    {
                        if(verifica2==1){
                            extenso=extenso+" "+qualificaS[1]+" ";
                        }else if(verifica2!=0){extenso=extenso+" "+qualificaP[1]+" ";}}
                    if(i==1)
                    {
                        if(verifica2==1){
                            extenso=extenso+" "+qualificaS[0]+" ";
                        }else {extenso=extenso+" "+qualificaP[0]+" ";}}
                }
            }
            resto = resto * 100;
            var aexCent=0;
            if(resto<=19&&resto>0)
                extenso+=" e "+unidade[resto]+" Centavos";
            if(resto>19)
            {
                aexCent=parseInt(resto/10);

                extenso+=" e "+dezena[aexCent]
                resto=resto-(aexCent*10);

                if(resto!=0)
                    extenso+=" e "+unidade[resto]+" Centavos";
                else extenso+=" Centavos";
            }

            return extenso;
        } else {
            return "Numero maior que 999 trilhões";
        }
    }
}

function float2moeda(num) {
    x = 0;

    if (num < 0) {
        num = Math.abs(num);
        x = 1;
    }

    if (isNaN(num)) num = "0";

    cents = Math.floor((num*100+0.5)%100);
    num = Math.floor((num*100+0.5)/100).toString();

    if (cents < 10) cents = "0" + cents;

    for (var i = 0; i < Math.floor((num.length-(1+i))/3); i++)
        num = num.substring(0,num.length-(4*i+3))+'.'+num.substring(num.length-(4*i+3));
    ret = num + ',' + cents;

    if (x == 1) ret = ' - ' + ret;

    return ret;
}

function moeda2float(moeda){
    moeda = moeda.replace(".","");
    moeda = moeda.replace(".","");
    moeda = moeda.replace(".","");
    moeda = moeda.replace(".","");
    moeda = moeda.replace(",",".");
    return parseFloat(moeda);
}

function aplicarMascaraJs(value, pattern) {
    if (value === null || value === undefined || value === '') {return '';}

    let i = 0;
    const v = value.toString();
    return pattern.replace(/#/g, () => v[i++] || '');
}

// Diversas - Início''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
// Diversas - Início''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
function toNumberOrMoney(valor, tipo = 'float', casas = 2) {
    if (valor === null || valor === undefined || valor === '') return null;

    if (typeof valor === 'string') {
        valor = valor.trim().replace(/[R$\s]/g, '');

        const temVirgula = valor.includes(',');
        const temPonto = valor.includes('.');

        // Formato brasileiro: usa vírgula como decimal
        if (temVirgula && (!temPonto || valor.lastIndexOf(',') > valor.lastIndexOf('.'))) {
            valor = valor.replace(/\./g, '').replace(',', '.');

        // Formato americano: usa ponto como decimal e vírgula como milhar
        } else if (temPonto && (!temVirgula || valor.lastIndexOf('.') > valor.lastIndexOf(','))) {
            valor = valor.replace(/,/g, '');
        }
        // Caso não tenha separadores, mantém como está (ex: "1234")
    }

    const numero = parseFloat(valor);

    if (isNaN(numero)) return null;

    if (tipo === 'money') {
        return numero.toLocaleString('pt-BR', {
            minimumFractionDigits: casas,
            maximumFractionDigits: casas
        });
    }

    return parseFloat(numero.toFixed(casas));
}
/*
* @PARAM op=1 : Entrada 01/02/2003   Saída 2003-02-01
* @PARAM op=2 : Entrada 2003-02-01   Saída 01/02/2003
 */
function formatarData(op, data) {
    if (data === null || data == '' || data === undefined) {return '';}

    if (op == 1) {
        var dia = data.substring(0, 2);
        var mes = data.substring(3, 5);
        var ano = data.substring(6, 10);

        return ano+'-'+mes+'-'+dia;
    }

    if (op == 2) {
        var dia = data.substring(8, 10);
        var mes = data.substring(5, 7);
        var ano = data.substring(0, 4);

        return dia+'/'+mes+'/'+ano;
    }
}

function capitalizarFrase(frase) {
    if (!frase) {return '';}

    return frase
        .toLowerCase()
        .split(' ')
        .map(palavra => {
            return palavra.length > 2
                ? palavra.charAt(0).toUpperCase() + palavra.slice(1)
                : palavra;
        })
        .join(' ');
}

/*
* @PARAM op=1 : Entrada 2135523524   Saída (21) 3552-3524
* @PARAM op=2 : Entrada 21964210128   Saída (21) 96421-0128
* @PARAM op=3 : Entrada 2135523524   Saída 21 3552-3524
* @PARAM op=4 : Entrada 21964210128   Saída 21 96421-0128
 */
function formatarTelCel(op, numero) {
    if (numero === null || numero == '') {return '';}

    numero = numero.replaceAll(' ', '');
    numero = numero.replaceAll('.', '');
    numero = numero.replaceAll('/', '');
    numero = numero.replaceAll('-', '');

    if (op == 1) {
        return '('+numero.substring(0, 2)+') '+numero.substring(2, 6)+'-'+numero.substring(6, 10);
    }

    if (op == 2) {
        return '('+numero.substring(0, 2)+') '+numero.substring(2, 7)+'-'+numero.substring(7, 11);
    }

    if (op == 3) {
        return ''+numero.substring(0, 2)+' '+numero.substring(2, 6)+'-'+numero.substring(6, 10);
    }

    if (op == 4) {
        return ''+numero.substring(0, 2)+' '+numero.substring(2, 7)+'-'+numero.substring(7, 11);
    }
}
// Diversas - Fim'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
// Diversas - Fim'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''




//Funções para Api ViaCep Para rodar em formulario sem REPEATER (Inicio)''''''''''''''''''''''''''''''''''''''''''''''''

//FORMULARIO COM CAMPOS SIMPLES'''''''''''''''''''''''''''''''''''''''''''''
function limpa_formulário_cep() {
    //Limpa valores do formulário de cep.
    document.getElementById('logradouro').value=("");
    document.getElementById('bairro').value=("");
    document.getElementById('localidade').value=("");
    document.getElementById('uf').value=("");
    //document.getElementById('ibge').value=("");
}

function meu_callback(conteudo) {
    if (!("erro" in conteudo)) {
        //Atualiza os campos com os valores.
        document.getElementById('logradouro').value=(conteudo.logradouro);
        document.getElementById('bairro').value=(conteudo.bairro);
        document.getElementById('localidade').value=(conteudo.localidade);
        document.getElementById('uf').value=(conteudo.uf);
        //document.getElementById('ibge').value=(conteudo.ibge);
    } //end if.
    else {
        //CEP não Encontrado.
        limpa_formulário_cep();
        alert("CEP não encontrado.");
    }
}

function pesquisacep(valor) {

    //Nova variável "cep" somente com dígitos.
    var cep = valor.replace(/\D/g, '');

    //Verifica se campo cep possui valor informado.
    if (cep != "") {

        //Expressão regular para validar o CEP.
        var validacep = /^[0-9]{8}$/;

        //Valida o formato do CEP.
        if(validacep.test(cep)) {

            //Preenche os campos com "..." enquanto consulta webservice.
            document.getElementById('logradouro').value="...";
            document.getElementById('bairro').value="...";
            document.getElementById('localidade').value="...";
            document.getElementById('uf').value="...";
            //document.getElementById('ibge').value="...";

            //Cria um elemento javascript.
            var script = document.createElement('script');

            //Sincroniza com o callback.
            script.src = 'https://viacep.com.br/ws/'+ cep + '/json/?callback=meu_callback';

            //Insere script no documento e carrega o conteúdo.
            document.body.appendChild(script);

        } //end if.
        else {
            //cep é inválido.
            limpa_formulário_cep();
            alert("Formato de CEP inválido.");
        }
    } //end if.
    else {
        //cep sem valor, limpa formulário.
        limpa_formulário_cep();
    }
};
//''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

//FORMULARIO COM CAMPOS _COBRANCA'''''''''''''''''''''''''''''''''''''''''''
function limpa_formulário_cep_cobranca() {
    //Limpa valores do formulário de cep_cobranca.
    document.getElementById('logradouro_cobranca').value=("");
    document.getElementById('bairro_cobranca').value=("");
    document.getElementById('localidade_cobranca').value=("");
    document.getElementById('uf_cobranca').value=("");
    //document.getElementById('ibge_cobranca').value=("");
}

function meu_callback_cobranca(conteudo) {
    if (!("erro" in conteudo)) {
        //Atualiza os campos com os valores.
        document.getElementById('logradouro_cobranca').value=(conteudo.logradouro);
        document.getElementById('bairro_cobranca').value=(conteudo.bairro);
        document.getElementById('localidade_cobranca').value=(conteudo.localidade);
        document.getElementById('uf_cobranca').value=(conteudo.uf);
        //document.getElementById('ibge_cobranca').value=(conteudo.ibge);
    } //end if.
    else {
        //CEP não Encontrado.
        limpa_formulário_cep_cobranca();
        alert("CEP não encontrado.");
    }
}

function pesquisacep_cobranca(valor) {

    //Nova variável "cep" somente com dígitos.
    var cep = valor.replace(/\D/g, '');

    //Verifica se campo cep possui valor informado.
    if (cep != "") {

        //Expressão regular para validar o CEP.
        var validacep = /^[0-9]{8}$/;

        //Valida o formato do CEP.
        if(validacep.test(cep)) {

            //Preenche os campos com "..." enquanto consulta webservice.
            document.getElementById('logradouro_cobranca').value="...";
            document.getElementById('bairro_cobranca').value="...";
            document.getElementById('localidade_cobranca').value="...";
            document.getElementById('uf_cobranca').value="...";
            //document.getElementById('ibge_cobranca').value="...";

            //Cria um elemento javascript.
            var script = document.createElement('script');

            //Sincroniza com o callback.
            script.src = 'https://viacep.com.br/ws/'+ cep + '/json/?callback=meu_callback_cobranca';

            //Insere script no documento e carrega o conteúdo.
            document.body.appendChild(script);

        } //end if.
        else {
            //cep é inválido.
            limpa_formulário_cep_cobranca();
            alert("Formato de CEP inválido.");
        }
    } //end if.
    else {
        //cep sem valor, limpa formulário.
        limpa_formulário_cep_cobranca();
    }
};
//''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
//Funções para Api ViaCep Para rodar em formulario sem REPEATER (Fim)'''''''''''''''''''''''''''''''''''''''''''''''''''

//Funções para Api ViaCep Para rodar em formulario com REPEATER (Inicio)'''''''''''''''''''''''''''''''''''''''''''''''''
function limpa_formulário_cep_repeater() {
    //Limpa valores do formulário de cep.
    $("input[type=text][name='endereco["+$('#ctrl_endereco_indice').val()+"][a_endereco]']").val('');
}

function meu_callback_repeater(conteudo) {
    if (!("erro" in conteudo)) {
        //Atualiza os campos com os valores.
        $("input[type=text][name='endereco["+$('#ctrl_endereco_indice').val()+"][a_endereco]']")
            .val(conteudo.logradouro+', '+
                $("input[type=text][name='endereco["+$('#ctrl_endereco_indice').val()+"][a_numero]']").val()+' - '+
                $("input[type=text][name='endereco["+$('#ctrl_endereco_indice').val()+"][a_complemento]']").val()+' - '+
                conteudo.bairro+' - '+
                conteudo.localidade+' - '+
                conteudo.uf);
    } else {
        //CEP não Encontrado.
        limpa_formulário_cep();
        alert("CEP não encontrado.");
    }
}

function pesquisacep_repeater(indice) {
    //retornar o indice do campo
    $('#ctrl_endereco_indice').val(indice);

    //Valor do campo CEP
    var valorCampoCep = $("input[type=text][name='endereco["+indice+"][a_cep]']").val();

    //Nova variável "cep" somente com dígitos.
    var cep = valorCampoCep.replace(/\D/g, '');

    //Verifica se campo cep possui valor informado.
    if (cep != "") {
        //Expressão regular para validar o CEP.
        var validacep = /^[0-9]{8}$/;

        //Valida o formato do CEP.
        if(validacep.test(cep)) {
            //Preenche os campos com "..." enquanto consulta webservice.
            $("input[type=text][name='endereco["+indice+"][a_endereco]']").val('...');

            //Cria um elemento javascript.
            var script = document.createElement('script');

            //Sincroniza com o callback.
            script.src = 'https://viacep.com.br/ws/'+ cep + '/json/?callback=meu_callback';

            //Insere script no documento e carrega o conteúdo.
            document.body.appendChild(script);

        } else {
            //cep é inválido.
            limpa_formulário_cep();
            alert("Formato de CEP inválido.");
        }
    } else {
        //cep sem valor, limpa formulário.
        limpa_formulário_cep();
    }
};
//Funções para Api ViaCep Para rodar em formulario com REPEATER (Fim)'''''''''''''''''''''''''''''''''''''''''''''''''''

/*
* Função que verifica o locale do Sistema e traduz usando os arquivos pt_BR.json e en.json
*/
async function traduzirViaLocale(texto='') {
    if (texto == '') {return texto;}

    const response = await fetch('/translate?key=' + encodeURIComponent(texto));
    const data = await response.json();
    if (data.translation != '') {
        return data.translation;
    } else {
        return texto;
    }
}

/*
* Função para pesquisa na API receitaws.com.br
 */
async function getReceitaWSCNPJ(cnpj) {
    const response = await fetch(`/receitaws/consulta-cnpj/${cnpj}`);
    const data = await response.json();
    return data;
}

/*
* Função para ajustar margens de um modal
 */
function ajustarMargensModalsInfo({ modalId = '', top = 20, right = 0, bottom = 20, left = 0 } = {}) {
    if (modalId == '') {return;}

    const alturaTela = window.innerHeight;
    const larguraTela = window.innerWidth;

    const header = document.querySelector('#'+modalId+' .modal-header');

    let header_height = 130;

    if (header) {
        header.style.minHeight = header_height+'px';
    }

    const dialog = document.querySelector('#'+modalId+' .modal-dialog');

    if (dialog) {
        dialog.style.maxWidth = (larguraTela - left - right) + 'px';
        dialog.style.minHeight = (alturaTela - top - bottom) + 'px';
        dialog.style.marginTop = top + 'px';
        dialog.style.marginBottom = bottom + 'px';
        dialog.style.marginLeft = left + 'px';
        dialog.style.marginRight = right + 'px';
    }

    const body = document.querySelector('#'+modalId+' .modal-body');

    if (body) {
        body.style.minHeight = (alturaTela - top - bottom - header_height) + 'px';
    }
}

//Função para verificar se o arquivo existe
async function arquivoExiste(arquivo) {
    // Verificando variavel
    if (arquivo === null || arquivo === undefined || arquivo === "") {
        return false;
    }

    // fetch
    var existe = await fetch('/arquivo_existe?arquivo=' + encodeURIComponent(arquivo), {
        method: 'GET'
    });

    var resposta = await existe.text();

    if (resposta === 'success') {
        return true;
    }

    return false;
}

/*
 * Gerar texto em código numérico positivo
 */
async function gerarCodigoNumerico(texto) {
    let hash = 0;
    for (let i = 0; i < texto.length; i++) {
        hash = (hash << 5) - hash + texto.charCodeAt(i);
        hash |= 0; // força para 32 bits
    }
    return Math.abs(hash); // número sempre positivo
}

// Primeira letra maiuscula
function primeiraMaiuscula(frase) {
    const excecoes = [
        "de", "da", "do", "das", "dos",
        "em", "no", "na", "nos", "nas",
        "por", "para",
        "e", "a", "o"
    ];

    return frase
        .toLowerCase()
        .split(/\s+/)
        .map((palavra, index) => {

            // Primeira palavra sempre deve ser capitalizada
            if (index === 0) {
                return palavra.charAt(0).toUpperCase() + palavra.slice(1);
            }

            // Mantém as exceções minúsculas
            if (excecoes.includes(palavra)) {
                return palavra;
            }

            // Capitaliza normalmente
            return palavra.charAt(0).toUpperCase() + palavra.slice(1);
        })
        .join(' ');
}

//Corrigir rotação da Foto para apresentação visual - Início''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
//Corrigir rotação da Foto para apresentação visual - Início''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
function carregarImagemComoBase64(url) {
    return new Promise((resolve, reject) => {
        const img = new Image();
        img.crossOrigin = "Anonymous";
        img.onload = function () {
            const canvas = document.createElement("canvas");
            canvas.width = img.width;
            canvas.height = img.height;
            const ctx = canvas.getContext("2d");
            ctx.drawImage(img, 0, 0);
            resolve(canvas.toDataURL("image/jpeg"));
        };
        img.onerror = reject;
        img.src = url;
    });
}

function corrigirRotacaoImagem(base64Image) {
    return new Promise((resolve, reject) => {
        try {
            const exif = window.piexif;
            const binary = atob(base64Image.split(',')[1]);
            const exifObj = exif.load(binary);
            const orientation = exifObj['0th'][exif.ImageIFD.Orientation] || 1;

            const img = new Image();
            img.onload = function () {
                const canvas = document.createElement("canvas");
                const ctx = canvas.getContext("2d");

                let width = img.width;
                let height = img.height;

                if (orientation > 4) {
                    canvas.width = height;
                    canvas.height = width;
                } else {
                    canvas.width = width;
                    canvas.height = height;
                }

                switch (orientation) {
                    case 2: ctx.transform(-1, 0, 0, 1, width, 0); break;
                    case 3: ctx.transform(-1, 0, 0, -1, width, height); break;
                    case 4: ctx.transform(1, 0, 0, -1, 0, height); break;
                    case 5: ctx.transform(0, 1, 1, 0, 0, 0); break;
                    case 6: ctx.transform(0, 1, -1, 0, height, 0); break;
                    case 7: ctx.transform(0, -1, -1, 0, height, width); break;
                    case 8: ctx.transform(0, -1, 1, 0, 0, width); break;
                }

                ctx.drawImage(img, 0, 0);
                resolve(canvas.toDataURL("image/jpeg"));
            };
            img.onerror = reject;
            img.src = base64Image;
        } catch (e) {
            resolve(base64Image); // se erro, usa a imagem original
        }
    });
}
//Corrigir rotação da Foto para apresentação visual - Fim'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
//Corrigir rotação da Foto para apresentação visual - Fim'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

//Fuções para gerar Cartões de Emergência - Início''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
//Fuções para gerar Cartões de Emergência - Início''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

/*
* @PARAM op : 1(Clientes Executivos)  2(Funcionarios)
* @PARAM ids : um ou vários ids do Cliente Executivo ou Funcionários
* @PARAM gerar : 1(Um registro para mostrar no Modal Info)  2(Um ou vários registros para mostrar em aba diferente do navegador)
* @PARAM divId : Div para visualização do Pdf com gerar=1
 */
async function cartaoEmergencialGerarPDF(op = 0, ids = 0, gerar = 2, traducao = 'pt', divId = '') {
    //Crítica
    if (op == 0) return;
    if (ids == 0) return;
    if (gerar == 1 && divId == '') return;

    //Configurações - Início''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    //Configurações - Início''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    //Iniciando
    const { jsPDF } = window.jspdf;

    //Variáveis (Geral)
    let doc;
    const larguraCartao = 85.60;
    const alturaCartao = 53.98;
    const espacamento = 10;
    let larguraPagina, margem, xEsquerda, xDireita, yTop;

    //ids
    let strIds = String(ids);
    let arrIds = strIds.split(',');
    let qtdIds = arrIds.length;

    var pageTopo = 'build/assets/images/relatorios_topo.png';
    var pageRodape = 'build/assets/images/relatorios_rodape.png';

    //Gerar 1
    if (gerar === 1 && qtdIds == 1) {
        doc = new jsPDF({ orientation: "landscape", unit: "mm", format: [larguraCartao, alturaCartao] });
        larguraPagina = larguraCartao;
        margem = 0;
        xEsquerda = margem;
        xDireita = larguraPagina - margem - larguraCartao;
        yTop = 0;
    }

    //Gerar 2
    if (gerar === 2) {
        doc = new jsPDF({ orientation: "portrait", unit: "mm", format: "a4" });
        larguraPagina = 210;
        alturaPagina = 297;
        margem = 15;
        xEsquerda = margem;
        xDireita = larguraPagina - margem - larguraCartao;
        yTop = 50;

        var relatorio_parametros = '';
        if (op == 1) {relatorio_parametros = 'Clientes Executivos';}
        if (op == 2) {relatorio_parametros = 'Funcionarios';}
    }

    if (!doc) return;
    //Configurações - Fim'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    //Configurações - Fim'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

    //Funções internas - Início'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    //Funções internas - Início'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    async function inserirCabecalho() {
        //Linha 1'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        //Texto 1
        texto = 'SISTEMA SAC';
        if (traducao == 'en') {texto = await traduzirTextoGoogle(texto);}
        texto = ' '+texto;
        doc.setFont('helvetica', 'bold');
        doc.setFontSize(12);
        doc.setFillColor('#9eeaf7');
        doc.rect(15, yTop - 6, larguraPagina - 30, 8, 'F');
        doc.text(texto, 15, yTop);

        //Texto 2
        texto = 'ADMINISTRAÇÃO E CONTROLE';
        if (traducao == 'en') {texto = await traduzirTextoGoogle(texto);}
        texto = texto+' ';
        var posX = larguraPagina - 15 - doc.getTextWidth(texto);
        doc.text(texto, posX, yTop);

        yTop = yTop + 12;
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        //Linha 2'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        //Texto 1
        texto = 'Parâmetros: '+relatorio_parametros;
        if (traducao == 'en') {texto = await traduzirTextoGoogle(texto);}
        texto = ' '+texto;
        doc.setFont('helvetica', 'normal');
        doc.setFontSize(12);
        doc.setFillColor('#d2d3d4');
        doc.rect(15, yTop - 6, larguraPagina - 30, 8, 'F');
        doc.text(texto, 15, yTop);

        //Texto 2
        texto = dataServidor(2)+' às '+horaServidor(1);
        if (traducao == 'en') {texto = await traduzirTextoGoogle(texto);}
        texto = texto+' ';
        var posX = larguraPagina - 15 - doc.getTextWidth(texto);
        doc.text(texto, posX, yTop);

        yTop = yTop + 12;
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        //Linha 3'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        //Texto 1
        texto = 'CARTÕES EMERGENCIAIS';
        if (traducao == 'en') {texto = await traduzirTextoGoogle(texto);}
        texto = ' '+texto;
        doc.setFont('helvetica', 'normal');
        doc.setFontSize(12);
        doc.setFillColor('#d2d3d4');
        doc.rect(15, yTop - 6, larguraPagina - 30, 8, 'F');
        doc.text(texto, 15, yTop);

        yTop = yTop + 15;
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    }

    async function adicionarCabecalhoRodape(topo, rodape) {
        doc.addImage(topo, 'PNG', 15, 10, larguraPagina - 30, 30);
        doc.addImage(rodape, 'PNG', 15, alturaPagina - 30, larguraPagina - 20, 20);
    }

    async function novaPagina() {
        doc.addPage();
        yTop = 50;

        await adicionarCabecalhoRodape(pageTopo, pageRodape);
    }
    //Funções internas - Fim''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    //Funções internas - Fim''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

    //Gerando PDF - Início''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    //Gerando PDF - Início''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    try {
        //Aviso Temporário na tela'''''''''''''''''''''''''''''''''''''''''''''''''''''
        var loadingAvisoTmp = document.getElementById('loading-aviso-tmp');
        loadingAvisoTmp.innerHTML = 'Processando, por favor aguarde...';
        loadingAvisoTmp.style.display = 'block';
        //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        //Dados
        const pessoas = await cartaoEmergencialDados(op, ids);
        var registro = 0;

        for (const pessoa of pessoas) {
            registro++;

            //QRCode caminho PNG
            var qrCodePngCaminho = 'build/assets/images/sem_imagem_quadrada.png';
            var qrCodePngCaminhoPt = 'build/assets/images/sem_imagem_quadrada.png';
            var qrCodePngCaminhoEn = 'build/assets/images/sem_imagem_quadrada.png';
            var logoCaminho = 'build/assets/images/sem_imagem_retangular.png';

            if (op == 1) {
                // qrCodePngCaminhoPt
                var arquivo_existe = await arquivoExiste('build/assets/qrcodes/clientes_executivos/qrcode_cartao_emergencial_pt_'+pessoa.id+'.png');
                if (arquivo_existe === true) {qrCodePngCaminhoPt = 'build/assets/qrcodes/clientes_executivos/qrcode_cartao_emergencial_pt_'+pessoa.id+'.png';}

                // qrCodePngCaminhoEn
                var arquivo_existe = await arquivoExiste('build/assets/qrcodes/clientes_executivos/qrcode_cartao_emergencial_en_'+pessoa.id+'.png');
                if (arquivo_existe === true) {qrCodePngCaminhoEn = 'build/assets/qrcodes/clientes_executivos/qrcode_cartao_emergencial_en_'+pessoa.id+'.png';}

                // logoCaminho
                var arquivo_existe = await arquivoExiste('build/assets/images/clientes/logotipo_cartao_emergencial_'+pessoa.cliente_id+'.png');
                if (arquivo_existe === true) {logoCaminho = 'build/assets/images/clientes/logotipo_cartao_emergencial_'+pessoa.cliente_id+'.png';}
            }
            if (op == 2) {
                // qrCodePngCaminhoPt
                var arquivo_existe = await arquivoExiste('build/assets/qrcodes/funcionarios/qrcode_cartao_emergencial_pt_'+pessoa.id+'.png');
                if (arquivo_existe === true) {qrCodePngCaminhoPt = 'build/assets/qrcodes/funcionarios/qrcode_cartao_emergencial_pt_'+pessoa.id+'.png';}

                // qrCodePngCaminhoEn
                var arquivo_existe = await arquivoExiste('build/assets/qrcodes/funcionarios/qrcode_cartao_emergencial_en_'+pessoa.id+'.png');
                if (arquivo_existe === true) {qrCodePngCaminhoEn = 'build/assets/qrcodes/funcionarios/qrcode_cartao_emergencial_en_'+pessoa.id+'.png';}

                // logoCaminho
                var arquivo_existe = await arquivoExiste('build/assets/images/cartao_emergencial_funcionario.png');
                if (arquivo_existe === true) {logoCaminho = 'build/assets/images/cartao_emergencial_funcionario.png';}
            }

            if (gerar === 1) {
                if (traducao == 'pt') {
                    if (op == 1) {
                        // qrCodePngCaminho
                        var arquivo_existe = await arquivoExiste('build/assets/qrcodes/clientes_executivos/qrcode_cartao_emergencial_pt_' + pessoa.id + '.png');
                        if (arquivo_existe === true) {qrCodePngCaminho = 'build/assets/qrcodes/clientes_executivos/qrcode_cartao_emergencial_pt_' + pessoa.id + '.png';}
                    }
                    if (op == 2) {
                        // qrCodePngCaminho
                        var arquivo_existe = await arquivoExiste('build/assets/qrcodes/funcionarios/qrcode_cartao_emergencial_pt_' + pessoa.id + '.png');
                        if (arquivo_existe === true) {qrCodePngCaminho = 'build/assets/qrcodes/funcionarios/qrcode_cartao_emergencial_pt_' + pessoa.id + '.png';}
                    }
                }
                if (traducao == 'en') {
                    if (op == 1) {
                        // qrCodePngCaminho
                        var arquivo_existe = await arquivoExiste('build/assets/qrcodes/clientes_executivos/qrcode_cartao_emergencial_en_'+pessoa.id+'.png');
                        if (arquivo_existe === true) {qrCodePngCaminho = 'build/assets/qrcodes/clientes_executivos/qrcode_cartao_emergencial_en_'+pessoa.id+'.png';}
                    }
                    if (op == 2) {
                        // qrCodePngCaminho
                        var arquivo_existe = await arquivoExiste('build/assets/qrcodes/funcionarios/qrcode_cartao_emergencial_en_'+pessoa.id+'.png');
                        if (arquivo_existe === true) {qrCodePngCaminho = 'build/assets/qrcodes/funcionarios/qrcode_cartao_emergencial_en_'+pessoa.id+'.png';}
                    }
                }

                await cartaoEmergencialDesenhar(doc, xEsquerda, yTop, pessoa, qrCodePngCaminho, logoCaminho, traducao);
            }

            if (gerar === 2) {
                //Cabeçalho e rodapé
                if (registro == 1) {
                    await adicionarCabecalhoRodape(pageTopo, pageRodape);

                    inserirCabecalho();
                }

                await cartaoEmergencialDesenhar(doc, xEsquerda, yTop, pessoa, qrCodePngCaminhoPt, logoCaminho, 'pt');
                await cartaoEmergencialDesenhar(doc, xDireita, yTop, pessoa, qrCodePngCaminhoEn, logoCaminho, 'en');

                yTop += alturaCartao + espacamento;

                if (yTop + alturaCartao > 270) {
                    if (registro < pessoas.length) {
                        novaPagina();
                    }
                }
            }
        }

        //Gerar 1
        if (gerar === 1) {
            // Usar pdfjsLib global carregado via <script>
            pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';

            const blob = doc.output("blob");
            const url = URL.createObjectURL(blob);

            const pdf = await pdfjsLib.getDocument(url).promise;
            const page = await pdf.getPage(1);

            const viewport = page.getViewport({ scale: 3 });
            const canvas = document.createElement('canvas');
            const context = canvas.getContext('2d');
            canvas.width = viewport.width;
            canvas.height = viewport.height;

            await page.render({ canvasContext: context, viewport }).promise;

            const imgDataUrl = canvas.toDataURL('image/png');

            const div = document.getElementById(divId);
            if (!div) {
                console.warn(`Div com id "${divId}" não encontrada.`);
                return;
            }

            div.innerHTML = ''; // limpa conteúdo

            const img = document.createElement('img');
            img.src = imgDataUrl;
            img.style.maxWidth = '100%';

            div.appendChild(img);

            URL.revokeObjectURL(url);
        }

        //Gerar 2
        if (gerar === 2) {
            const pdfUrl = doc.output('bloburl');
            window.open(pdfUrl, '_blank');
        }
    } catch (e) {
        alert("Erro ao gerar PDF: " + e.message);
    } finally {
        //Aviso Temporário na tela'''''''''''''''''''''''''''''''''''''''''''''''''''''
        var loadingAvisoTmp = document.getElementById('loading-aviso-tmp');
        loadingAvisoTmp.innerHTML = '';
        loadingAvisoTmp.style.display = 'none';
        //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    }
    //Gerando PDF - Fim'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    //Gerando PDF - Fim'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
}

async function cartaoEmergencialDados(op, ids) {
    //Clientes Executivos
    if (op == 1) {
        const resposta = await fetch('/clientes_executivos/cartoes_emergenciais/dados/'+ids, {
            method: 'GET',
            headers: {
                'REQUEST-ORIGIN': 'fetch',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        });

        const dados = await resposta.json();

        if (dados.success) {
            var clientes_executivos = dados.success;

            // monta o array no formato usado no PDF
            return clientes_executivos.map(function(pessoa) {
                var obj = {
                    id: pessoa.id,
                    cliente_id: pessoa.cliente_id,
                    nome: pessoa.executivo_nome,
                    genero: pessoa.generoName,
                    nascimento: pessoa.data_nascimento,
                    fotografia_cartao_emergencial: pessoa.fotografia_cartao_emergencial,
                    contato_1_nome: pessoa.contato_1_nome,
                    contato_1_parentesco: pessoa.contato_1_parentesco,
                    contato_1_telefone: pessoa.contato_1_telefone,
                    contato_1_celular: pessoa.contato_1_celular,
                    contato_2_nome: pessoa.contato_2_nome,
                    contato_2_parentesco: pessoa.contato_2_parentesco,
                    contato_2_telefone: pessoa.contato_2_telefone,
                    contato_2_celular: pessoa.contato_2_celular
                };

                // percorre todas as propriedades e substitui null/undefined por ""
                for (var key in obj) {
                    if (obj[key] === null || obj[key] === undefined) {
                        obj[key] = "";
                    }
                }

                return obj;
            });
        } else {
            return [];
        }
    }

    //Funcionarios
    if (op == 2) {
        const resposta = await fetch('/funcionarios/cartoes_emergenciais/dados/'+ids, {
            method: 'GET',
            headers: {
                'REQUEST-ORIGIN': 'fetch',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        });

        const dados = await resposta.json();

        if (dados.success) {
            var funcionarios = dados.success;

            // monta o array no formato usado no PDF
            return funcionarios.map(function(pessoa) {
                var obj = {
                    id: pessoa.id,
                    nome: pessoa.name,
                    genero: pessoa.generoName,
                    nascimento: pessoa.data_nascimento,
                    fotografia_cartao_emergencial: pessoa.fotografia_cartao_emergencial,
                    contato_1_nome: pessoa.contato_1_nome,
                    contato_1_parentesco: pessoa.contato_1_parentesco,
                    contato_1_telefone: pessoa.contato_1_telefone,
                    contato_1_celular: pessoa.contato_1_celular,
                    contato_2_nome: pessoa.contato_2_nome,
                    contato_2_parentesco: pessoa.contato_2_parentesco,
                    contato_2_telefone: pessoa.contato_2_telefone,
                    contato_2_celular: pessoa.contato_2_celular
                };

                // percorre todas as propriedades e substitui null/undefined por ""
                for (var key in obj) {
                    if (obj[key] === null || obj[key] === undefined) {
                        obj[key] = "";
                    }
                }

                return obj;
            });
        } else {
            return [];
        }
    }
}

// Desenha 1 cartão
async function cartaoEmergencialDesenhar(doc, x, y, pessoa, qrCodePngCaminho, logoCaminho, traducao) {
    //URL
    var url_atual = window.location.protocol + '//' + window.location.host + '/';

    const largura = 85.60;
    const altura = 53.98;

    // Cabeçalho azul
    doc.setFillColor('#c0f0f7'); // azul claro
    doc.rect(x, y, largura, 10, 'F');

    // Logo (esquerda)
    const logo = logoCaminho;
    doc.addImage(logo, 'PNG', x + 2, y + 1.5, 20, 7);

    // Título
    doc.setFontSize(8);
    doc.setFont('helvetica', 'bold');
    doc.setTextColor('#ce0000');

    if (traducao == 'pt') {
        doc.text("CARTÃO DE EMERGÊNCIA", x + largura / 2, y + 6.5, { align: 'center' });
    } else {
        doc.text("EMERGENCY CARD", x + largura / 2, y + 6.5, { align: 'center' });
    }

    // Ícone médico (direita)
    const icone = 'build/assets/images/emergencia.png';
    doc.addImage(icone, 'PNG', x + largura - 11, y + 1.5, 7, 7);

    // Foto
    var caminhoFoto = 'build/assets/images/sem_imagem_quadrada.png';

    var arquivo_existe = await arquivoExiste(pessoa.fotografia_cartao_emergencial);
    if (arquivo_existe === true) {caminhoFoto = pessoa.fotografia_cartao_emergencial;}

    const base64 = await carregarImagemComoBase64(caminhoFoto);
    const imagemCorrigida = await corrigirRotacaoImagem(base64);
    doc.addImage(imagemCorrigida, "JPEG", x + 3, y + 12, 25, 27);

    // QR Code (ao lado direito da foto)
    doc.addImage(qrCodePngCaminho, "PNG", x + largura - 25, y + 12, 24, 24);

    // Nome
    doc.setTextColor('#000000');
    doc.setFontSize(8);
    doc.setFont('helvetica', 'bold');
    doc.text(pessoa.nome, x + 30, y + 15, { maxWidth: 30 });

    // Informações
    doc.setFont('helvetica', 'normal');
    doc.setFontSize(7);

    const genero_tit = traducao === 'en' ? 'Gender:' : 'Gênero:';
    const genero = traducao === 'en' ? await traduzirTextoGoogle(capitalizarFrase(pessoa.genero)) : capitalizarFrase(pessoa.genero);
    const nascimento_tit = traducao === 'en' ? 'Date of Birth:' : 'Data de Nascimento:';
    const nascimento = traducao === 'en' ? pessoa.nascimento : formatarData(2, pessoa.nascimento);

    const larguraTextoMax = 30; // limita a largura para não passar sob o QR

    doc.setFontSize(7);
    doc.setFont('helvetica', 'bold');
    doc.setTextColor('#545454');
    doc.text(genero_tit, x + 30, y + 24, { maxWidth: larguraTextoMax });

    doc.setFontSize(7);
    doc.setFont('helvetica', 'normal');
    doc.setTextColor('#000000');
    doc.text(genero, x + 30, y + 28, { maxWidth: larguraTextoMax });

    doc.setFontSize(7);
    doc.setFont('helvetica', 'bold');
    doc.setTextColor('#545454');
    doc.text(nascimento_tit, x + 30, y + 34, { maxWidth: larguraTextoMax });

    doc.setFontSize(7);
    doc.setFont('helvetica', 'normal');
    doc.setTextColor('#000000');
    doc.text(nascimento, x + 30, y + 38, { maxWidth: larguraTextoMax });

    // Contato de emergência (embaixo)
    var contato_1 = '';
    var contato_2 = '';

    if (pessoa.contato_1_nome) {contato_1 = capitalizarFrase(pessoa.contato_1_nome);}
    if (pessoa.contato_1_parentesco) {contato_1 += '  '+'('+capitalizarFrase(pessoa.contato_1_parentesco)+')';}
    if (pessoa.contato_1_telefone) {contato_1 += '  '+'+55 '+formatarTelCel(3, pessoa.contato_1_telefone);}
    if (pessoa.contato_1_celular) {contato_1 += '  '+'+55 '+formatarTelCel(3, pessoa.contato_1_celular);}

    if (pessoa.contato_2_nome) {contato_2 = capitalizarFrase(pessoa.contato_2_nome);}
    if (pessoa.contato_2_parentesco) {contato_2 += '  '+'('+capitalizarFrase(pessoa.contato_2_parentesco)+')';}
    if (pessoa.contato_2_telefone) {contato_2 += '  '+'+55 '+formatarTelCel(3, pessoa.contato_2_telefone);}
    if (pessoa.contato_2_celular) {contato_2 += '  '+'+55 '+formatarTelCel(3, pessoa.contato_2_celular);}

    if (contato_1 != '' || contato_2 != '') {
        doc.setFontSize(7);
        doc.setFont('helvetica', 'bold');
        doc.setTextColor('#545454');
        doc.text(traducao === 'en' ? "EMERGENCY CONTACTS:" : "CONTATOS DE EMERGÊNCIA:", x + 3, y + altura - 11);

        doc.setFontSize(6);
        doc.setFont('helvetica', 'normal');
        doc.setTextColor('#000000');
        if (contato_1 != '') {doc.text(contato_1, x + 3, y + altura - 7);}
        if (contato_2 != '') {doc.text(contato_2, x + 3, y + altura - 3);}
    }

    // Borda azul
    doc.setDrawColor('#c0f0f7');
    doc.setLineWidth(0.5);
    //doc.roundedRect(x, y, largura, altura, 2, 2);
    doc.rect(x, y, largura, altura);
}
//Fuções para gerar Cartões de Emergência - Fim'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
//Fuções para gerar Cartões de Emergência - Fim'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
