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
* @PARAM op=18 : Campo FILE com arquivo IMG
* @PARAM op=19 : Decimal 2 casas
* @PARAM op=20 : Boletim
* @PARAM op=21 : RG Militar
* @PARAM op=22 : Pagamento
 */
function validacao({op=0, value='', minCaracteres=0, maxCaracteres=0, id=''}) {
    var regex;

    // Campo Requerido
    if (op == 1) {
        // Expressão regular que verifica se a entrada é vazia ou contém apenas espaços em branco
        regex = /^\s*$/;

        // Verificando
        if (regex.test(value) === true) {
            return false;
        } else {
            return true;
        }
    }

    // Mínimo de Caracteres
    if (op == 2) {
        // Expressão regular que verifica se a entrada tem pelo menos 'minimo' caracteres
        regex = new RegExp(`^.{${minCaracteres},}$`);

        // Verificando
        if (regex.test(value) === true) {
            return true;
        } else {
            return false;
        }
    }

    // Máximo de Caracteres
    if (op == 3) {
        // Expressão regular que verifica se a entrada tem no máximo 'maximo' caracteres
        regex = new RegExp(`^.{0,${maxCaracteres}}$`);

        // Verificando
        if (regex.test(value) === true) {
            return true;
        } else {
            return false;
        }
    }

    // Somente Números
    if (op == 4) {
        // Expressão regular que verifica se a entrada contém somente números
        regex = /^[0-9]+$/;

        // Verificando
        if (regex.test(value) === true) {
            return true;
        } else {
            return false;
        }
    }

    // E-mail Válido
    if (op == 5) {
        // Expressão regular para validar endereços de e-mail
        regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        // Verificando
        if (regex.test(value) === true) {
            return true;
        } else {
            return false;
        }
    }

    // CNPJ Válido
    if (op == 6) {
        // Remover caracteres não numéricos
        value = value.replace(/\D/g, '');

        // Verificar se CNPJ possui 14 dígitos
        if (value.length !== 14) return false;

        // Verificar se todos os dígitos são iguais
        if (/^(\d)\1+$/.test(value)) return false;

        // Validar dígitos verificadores
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

    // CPF Válido
    if (op == 7) {
        // Remover caracteres não numéricos
        value = value.replace(/\D/g, '');

        // Verificar se o CPF possui 11 dígitos
        if (value.length !== 11) return false;

        // Verificar se todos os dígitos são iguais
        if (/^(\d)\1+$/.test(value)) return false;

        // Validar dígitos verificadores
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

    // Data Válida
    if (op == 8) {
        // Expressão regular para verificar o formato da data (DD/MM/AAAA)
        regex = /^(0[1-9]|[12][0-9]|3[01])\/(0[1-9]|1[0-2])\/\d{4}$/;

        // Verificando
        if (regex.test(value) === true) {
            return true;
        } else {
            return false;
        }
    }

    // CEP Válido
    if (op == 9) {
        // Expressão regular para verificar o formato do CEP (XXXXX-XXX)
        regex = /^\d{5}-\d{3}$/;

        // Verificando
        if (regex.test(value) === true) {
            return true;
        } else {
            return false;
        }
    }

    // URL Válida
    if (op == 10) {
        // Expressão regular para verificar o formato básico da URL
        regex = /^(ftp|http|https):\/\/[^ "]+$/;

        // Verificando
        if (regex.test(value) === true) {
            return true;
        } else {
            return false;
        }
    }

    // Telefone Válido
    if (op == 11) {
        // Expressão regular para validar números de telefone brasileiros
        regex = /^\(?\d{2}\)?[-.\s]?\d{4,5}[-.\s]?\d{4}$/;

        // Verificando
        if (regex.test(value) === true) {
            return true;
        } else {
            return false;
        }
    }

    // Celular Válido
    if (op == 12) {
        // Expressão regular para validar números de celular brasileiros
        regex = /^\(?\d{2}\)?[-.\s]?\d{5}[-.\s]?\d{4}$/;

        // Verificando
        if (regex.test(value) === true) {
            return true;
        } else {
            return false;
        }
    }

    // PIS Válido
    if (op == 13) {
        // Expressão regular para validar números de PIS brasileiros
        regex = /^\d{3}\.\d{5}\.\d{2}-\d$/;

        // Verificando
        if (regex.test(value) === true) {
            return true;
        } else {
            return false;
        }
    }

    // PASEP Válido
    if (op == 14) {
        // Expressão regular para validar números de PASEP brasileiros
        regex = /^\d{3}\.\d{5}\.\d{2}-\d$/;

        // Verificando
        if (regex.test(value) === true) {
            return true;
        } else {
            return false;
        }
    }

    // Carteira Trabalho Válido
    if (op == 15) {
        // Expressão regular para validar números de CTPS brasileiros
        regex = /^\d{7,14}$/;

        // Verificando
        if (regex.test(value) === true) {
            return true;
        } else {
            return false;
        }
    }

    // Campo FILE com arquivo PDF
    if (op == 16) {
        let elemento = document.getElementById(id);
        const file = elemento.files[0]; // Obtém o primeiro arquivo selecionado

        // verificar se é vazio
        if (!file) {
            return false;
        }

        // verificar se é um PDF (MIME type ou extensão)
        if (file.type !== "application/pdf" && !file.name.endsWith(".pdf")) {
            elemento.value = ''; // Limpa o campo caso não seja um PDF
            return false;
        }

        return true;
    }

    // Hora Válida
    if (op == 17) {
        // Expressão regular para verificar o formato da hora (HH:mm:ss)
        regex = /^(0[0-9]|1[0-9]|2[0-3]):([0-5][0-9]):([0-5][0-9])$/;

        // Verificando
        if (regex.test(value) === true) {
            return true;
        } else {
            return false;
        }
    }

    // Campo FILE com arquivo IMG
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

    // Campo Boletim: 001-31/12/2025
    if (op == 20) {
        // Formato: 001-31/12/2025
        regex = /^(00[1-9]|0[1-9]\d|[1-9]\d{2})-(\d{2})\/(\d{2})\/(\d{4})$/;

        if (!regex.test(value)) {
            return false;
        }

        // Captura os grupos
        const partes = value.match(regex);

        const dia = parseInt(partes[2], 10);
        const mes = parseInt(partes[3], 10);
        const ano = parseInt(partes[4], 10);

        // Cria a data
        const data = new Date(ano, mes - 1, dia);

        // Verifica se a data é válida
        return (data.getFullYear() === ano && data.getMonth() === mes - 1 && data.getDate() === dia);
    }

    // Campo RG: 00/0000.000
    if (op == 21) {
        // Formato: 00/0000.000
        regex = /^\d{2}\/\d{4}\.\d{3}$/;

        return regex.test(value);
    }

    // Campo Pagamento: mm/yyyy
    if (op == 22) {
        return /^(0[1-9]|1[0-2])\/\d{4}$/.test(value);
    }
}

// Modal para Mensagens
function alertSwal(icon = 'success', title = '', html = '', showConfirmButton = false, timer = 2000) {
    Swal.fire({
        icon: icon,
        title: title,
        html: html,
        showConfirmButton: showConfirmButton,
        timer: timer
    });
}

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

function showTooltips() {
	$('[data-bs-toggle="tooltip"]').tooltip({ boundary: 'window' });
}

function hideTooltips() {
	//Remove os Tooltips
	$('[data-bs-toggle="tooltip"]').tooltip('hide');

	//Remove os que perderam a referencia
	$('[role="tooltip"]').hide();
}

// Primeira letra maiuscula
function primeiraMaiuscula(frase) {
    if (!frase) { return ''; }

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

async function chartPieSimple({ divId = '', titleText = '', titleSubText = '', legenda = 'bottom', dados = [], modalFiltroId = '' }) {
    if (divId == '') { return; }
    if (!document.getElementById(divId)) { return; }

    // Chart
    var chartDom = document.getElementById(divId);

    // Se já existe um gráfico nesse elemento, destruir
    if (echarts.getInstanceByDom(chartDom)) {echarts.dispose(chartDom);}

    // Iniciar
    var myChart = echarts.init(chartDom);

    // Opções
    var option;

    // Legenda: legenda (string) -> 'top' | 'bottom' | 'left' | 'right' '''''''''''''''''''''

    // valores padrão (fallback)
    var legendConfig = {
        top: 0,
        left: 'center',
        orient: 'horizontal'
    };

    // ajuste do centro do gráfico para evitar sobreposição com a legenda
    var seriesCenter = ['50%', '50%']; // padrão

    // Mapeamento do parâmetro `legenda`
    switch ((legenda || '').toLowerCase()) {
        case 'top':
            // → Coloca a legenda no topo, ao centro
            legendConfig = { top: 0, left: 'center', orient: 'horizontal' };
            // → move o gráfico um pouco para baixo (para não encostar na legenda)
            seriesCenter = ['50%', '55%'];
            break;

        case 'bottom':
            // → Coloca a legenda no rodapé, ao centro
            legendConfig = { bottom: 0, left: 'center', orient: 'horizontal' };
            // → move o gráfico um pouco para cima (para abrir espaço no rodapé)
            seriesCenter = ['50%', '45%'];
            break;

        case 'left':
            // → Legenda vertical à esquerda, centralizada verticalmente
            legendConfig = { orient: 'vertical', left: 10, top: 'center' };
            // → move o gráfico para a direita para abrir espaço para a legenda
            seriesCenter = ['55%', '50%'];
            break;

        case 'right':
            // → Legenda vertical à direita, centralizada verticalmente
            legendConfig = { orient: 'vertical', right: 10, top: 'center' };
            // → move o gráfico para a esquerda para abrir espaço para a legenda
            seriesCenter = ['35%', '50%'];
            break;

        default:
            // → valor inválido ou vazio: legenda top-center (comportamento padrão)
            legendConfig = { top: 0, left: 'center', orient: 'horizontal' };
            seriesCenter = ['50%', '55%'];
            break;
    }
    //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

    // Title'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    titleConfig = {title: {show: false}};

    if (titleText != '') {
        titleConfig = {title: {text: titleText, subtext: titleSubText, left: 'center'}};
    }
    //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

    // Criar Toolbox Feature'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    var toolboxFeature = {
        saveAsImage: { title: 'Salvar Imagem' }
    };

    // Se existir modalFiltroId adiciona botão customizado
    if (modalFiltroId != '') {
        toolboxFeature.myFiltro = {
            show: true,
            title: 'Filtro',
            icon: 'path://M4 4 H20 V20 H4 Z',
            onclick: function () {
                var modalElement = document.getElementById(modalFiltroId);
                if (modalElement) {
                    var modal = new bootstrap.Modal(modalElement);
                    modal.show();
                }
            }
        };
    }
    //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

    // Monta option usando as configurações calculadas
    option = {
        textStyle: {fontSize: 10},
        ...titleConfig,
        backgroundColor: '#ffffff',
        toolbox: {
            orient: 'vertical',
            right: -10,
            top: 0,
            feature: toolboxFeature
        },
        tooltip: {
            trigger: 'item',
            textStyle: {fontSize: 10}
        },
        legend: {
            // Aplica a configuração resultante da switch acima
            ...legendConfig,
            textStyle: {fontSize: 10}
        },
        series: [
            {
                type: 'pie',
                radius: '40%',
                center: seriesCenter,
                data: dados,
                emphasis: {
                    itemStyle: {
                    shadowBlur: 10,
                    shadowOffsetX: 0,
                    shadowColor: 'rgba(0, 0, 0, 0.5)'
                    }
                }
            }
        ]
    };

    // Aplica a configuração ao gráfico
    option && myChart.setOption(option);
}

async function chartBarSimple({ divId = '', titleText = '', titleSubText = '', legenda = 'bottom', dados = [], modalFiltroId = '' }) {
    if (divId == '') { return; }
    if (!document.getElementById(divId)) { return; }

    // Chart
    var chartDom = document.getElementById(divId);

    // Se já existe um gráfico nesse elemento, destruir
    if (echarts.getInstanceByDom(chartDom)) {echarts.dispose(chartDom);}

    // Iniciar
    var myChart = echarts.init(chartDom);

    // Opções
    var option;

    // Title'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    titleConfig = {title: {show: false}};

    if (titleText != '') {
        titleConfig = {title: {text: titleText, subtext: titleSubText, left: 'center'}};
    }
    //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

    // Criar Toolbox Feature'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    var toolboxFeature = {
        saveAsImage: { title: 'Salvar Imagem' }
    };

    // Se existir modalFiltroId adiciona botão customizado
    if (modalFiltroId != '') {
        toolboxFeature.myFiltro = {
            show: true,
            title: 'Filtro',
            icon: 'path://M4 4 H20 V20 H4 Z',
            onclick: function () {
                var modalElement = document.getElementById(modalFiltroId);
                if (modalElement) {
                    var modal = new bootstrap.Modal(modalElement);
                    modal.show();
                }
            }
        };
    }
    //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

    // Monta option usando as configurações calculadas
    option = {
        textStyle: {fontSize: 10},
        ...titleConfig,
        backgroundColor: '#ffffff',
        toolbox: {
            orient: 'vertical',
            right: -10,
            top: 0,
            feature: toolboxFeature
        },
        tooltip: {
            trigger: 'axis',
            textStyle: {fontSize: 10},
            axisPointer: {
                type: 'shadow'
            }
        },
        grid: {
            left: '3%',
            right: '4%',
            bottom: '3%',
            containLabel: true
        },
        xAxis: [
            {
            type: 'category',
            data: dados.map(item => item.name),
            axisTick: {
                alignWithLabel: true
            }
            }
        ],
        yAxis: [
            {
            type: 'value'
            }
        ],
        series: [
            {
                //name: 'Direct',
                type: 'bar',
                barWidth: '60%',
                data: dados.map(item => item.value)
            }
        ]
        };

        // Aplica a configuração ao gráfico
    option && myChart.setOption(option);
}

/*
 * Retornar referencia
 * @PARAM op=1 : recebe 20230902 e retorna setembro de 2023 parte 02
 * @PARAM op=2 : recebe 202309 e retorna setembro de 2023
 * @PARAM op=3 : recebe setembro de 2023 parte 02 e retorna 20230902
 * @PARAM op=4 : recebe setembro de 2023 e retorna 202309
 */
function getReferencia(op, referencia) {
    var referencia = referencia.toString();

    if (op == 1) {
        var ano = referencia.substring(0, 4);
        var mes = referencia.substring(4, 6);
        var parte = referencia.substring(6, 8);
        var mes_extenso = getMes(1, mes);

        return mes_extenso+' de '+ano+' parte '+parte;
    }

    if (op == 2) {
        var ano = referencia.substring(0, 4);
        var mes = referencia.substring(4, 6);
        var mes_extenso = getMes(1, mes);

        return mes_extenso+' de '+ano;
    }

    if (op == 3) {
        const explode = referencia.split(' ');

        parte = explode[4];
        ano = explode[2];
        mes_extenso = explode[0];
        mes = getMes(2, mes_extenso);

        return ano+mes+parte;
    }

    if (op == 4) {
        const explode = referencia.split(' ');

        ano = explode[2];
        mes_extenso = explode[0];
        mes = getMes(2, mes_extenso);

        return ano+mes;
    }

    return false;
}

/*
 * Retornar Mês e Mês por Extenso
 * @PARAM op=1 = retorna Mês por Extenso
 * @PARAM op=2 = retorna Mês Numeral
 */
function getMes(op, mes) {
    if (op == 1) {
        if (mes.length == 1) {mes = '0'+mes;}

        if (mes == '01') {return 'janeiro';}
        if (mes == '02') {return 'fevereiro';}
        if (mes == '03') {return 'março';}
        if (mes == '04') {return 'abril';}
        if (mes == '05') {return 'maio';}
        if (mes == '06') {return 'junho';}
        if (mes == '07') {return 'julho';}
        if (mes == '08') {return 'agosto';}
        if (mes == '09') {return 'setembro';}
        if (mes == '10') {return 'outubro';}
        if (mes == '11') {return 'novembro';}
        if (mes == '12') {return 'dezembro';}
    }

    if (op == 2) {
        if (mes == 'janeiro') {return '01';}
        if (mes == 'fevereiro') {return '02';}
        if (mes == 'março') {return '03';}
        if (mes == 'abril') {return '04';}
        if (mes == 'maio') {return '05';}
        if (mes == 'junho') {return '06';}
        if (mes == 'julho') {return '07';}
        if (mes == 'agosto') {return '08';}
        if (mes == 'setembro') {return '09';}
        if (mes == 'outubro') {return '10';}
        if (mes == 'novembro') {return '11';}
        if (mes == 'dezembro') {return '12';}
    }

    return false;
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

function formatarDocumento(op, valor) {
    if (valor === null || valor === '' || valor === undefined) {
        return '';
    }

    // Remover tudo que não for número
    valor = valor.toString().replace(/\D/g, '');

    // CPF
    if (op == 1) {
        if (valor.length !== 11) {
            return valor;
        }

        return valor.replace(
            /(\d{3})(\d{3})(\d{3})(\d{2})/,
            '$1.$2.$3-$4'
        );
    }

    // PASEP
    if (op == 2) {
        if (valor.length !== 11) {
            return valor;
        }

        return valor.replace(
            /(\d{3})(\d{5})(\d{2})(\d{1})/,
            '$1.$2.$3-$4'
        );
    }

    return valor;
}

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
    var topo_2_image_width = 19;
    var topo_2_image_height = 21;
    var topo_2_text_1_margin_left = topo_2_image_width + 20;
    var topo_2_text_2_margin_left = topo_2_image_width + 20;
    var topo_2_text_3_margin_left = topo_2_image_width + 20;
    var topo_2_text_1_margin_top = topo_2_image_margin_top + 5;
    var topo_2_text_2_margin_top = topo_2_image_margin_top + 11;
    var topo_2_text_3_margin_top = topo_2_image_margin_top + 17;

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

        // Estilo geral
        styles: { fontSize: 7 },

        //Antes de começar a desenhar a página
        willDrawPage: function (data) {
            //Header
            if (p_header === true) {
                //Topo 1
                if (p_topo_1 === true) {
                    doc.setFontSize(10);
                    doc.addImage('assets/images/logo_governo_rj.png', 'PNG', topo_1_image_margin_left, topo_1_image_margin_top, topo_1_image_width, topo_1_image_height);
                    doc.text('Secretaria de Estado de Defesa Civil', pageWidth / 2, topo_1_text_1_margin_top, {align: 'center'});
                    doc.text('Corpo de Bombeiros Militar do Estado do Rio de Janeiro', pageWidth / 2, topo_1_text_2_margin_top, {align: 'center'});
                    doc.text('Diretoria Geral de Finanças', pageWidth / 2, topo_1_text_3_margin_top, {align: 'center'});
                }

                //Topo 2
                if (p_topo_2 === true) {
                    doc.setFontSize(10);
                    doc.addImage('assets/images/image_logo_relatorio.png', 'PNG', topo_2_image_margin_left, topo_2_image_margin_top, topo_2_image_width, topo_2_image_height);
                    doc.text('Secretaria de Estado de Defesa Civil', topo_2_text_1_margin_left, topo_2_text_1_margin_top);
                    doc.text('Corpo de Bombeiros Militar do Estado do Rio de Janeiro', topo_2_text_1_margin_left, topo_2_text_2_margin_top);
                    doc.text('Diretoria Geral de Finanças', topo_2_text_1_margin_left, topo_2_text_3_margin_top);
                }
            }

            //Nome
            if (doc.internal.getNumberOfPages() == 1) {
                doc.setFontSize(10);
                doc.text(p_nome, pageWidth / 2, nome_margin_top, {align: 'center'});
            }

            //Parâmetros
            if (doc.internal.getNumberOfPages() == 1) {
                if (p_parametros === true) {
                    doc.setFontSize(9);
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

                doc.setFontSize(9);
                doc.text('Gerado pelo Sistema SAC - DGF', footer_text_1_margin_left, pageHeight - 15, {align: 'center'});
                doc.text(text, footer_text_2_margin_left, pageHeight - 10, {align: 'center'});
            }

            //Alterar variáveis a partir da página 2
            if (doc.internal.getNumberOfPages() >= 1) {
                data.settings.margin.top = nome_margin_top;
            }
        }
    });

    // Total page number
    if (typeof doc.putTotalPages === 'function') {
        doc.putTotalPages(totalPagesExp);
    }

    // Salvar o PDF gerado no lado do Cliente
    //doc.save('relatorio_pdf.pdf');

    // Gerar blob do PDF
    const blob = doc.output('blob');

    // Criar URL temporária
    const url = URL.createObjectURL(blob);

    // Abrir nova aba
    window.open(url, '_blank');
}

// Função para verificar permissão (Similar a temPermissao() do helper.php)
function temPermissao(permissao) {
    const permissoes = window.userPermissions ?? [];
    return permissoes.includes(permissao);
}

// Mostrar elemento do DOM já selecionado
function mostrarElemento(elemento) {
    if (elemento) {
        elemento.style.display = '';
    }
}

// Ocultar elemento do DOM já selecionado
function ocultarElemento(elemento) {
    if (elemento) {
        elemento.style.display = 'none';
    }
}

// Verificar se tem permissão para a Situação (Submódulos Militares e todos relacionados a ele)
async function temPermissaoSituacao(modulo, acao, situacaoId) {
    try {
        const response = await fetch(`permissoes_situacoes/tem_permissao_situacao/${modulo}/${acao}/${situacaoId}`);

        const data = await response.json();

        return data.success;
    } catch (error) {
        console.error(error);
        return false;
    }
}

// Configurar os Botões dos CRUDs para cada submodulo (Submódulos Militares e todos relacionados a ele)
async function configurarBotoesPermissaoSituacao({ modulo, situacaoId }) {
    const botaoConfirmar = document.getElementById('crudFormButtons1ConfirmOperation');
    const botaoEditar = document.getElementById('crudFormButtons2Edit');
    const botaoExcluir = document.getElementById('crudFormButtons2Delete');

    const podeEditar = await temPermissaoSituacao(modulo, 'edit', situacaoId);
    const podeExcluir = await temPermissaoSituacao(modulo, 'destroy', situacaoId);

    ocultarElemento(botaoConfirmar);
    ocultarElemento(botaoEditar);
    ocultarElemento(botaoExcluir);

    if (podeEditar || podeExcluir) { mostrarElemento(botaoConfirmar); }
    if (podeEditar) { mostrarElemento(botaoEditar); }
    if (podeExcluir) { mostrarElemento(botaoExcluir); }
}

// Autocomplete Militar (Com todos os Militares)
function autocompleteMilitar() {
    const input = document.getElementById('pesquisar_militar');
    const box = document.getElementById('autocomplete_militar');

    let timeout = null;
    let controller = null;
    let ultimaBusca = "";

    function init() {
        input.addEventListener("input", onInput);
    }

    function onInput() {
        clearTimeout(timeout);

        const valor = input.value.trim();

        box.innerHTML = "";

        if (valor.length < 4) return;

        if (valor === ultimaBusca) return;

        timeout = setTimeout(() => {
            if (controller) controller.abort();

            controller = new AbortController();

            fetch(`militares/autocomplete/militar/xxxyyyzzz/xyz`, {
                method: "POST",
                signal: controller.signal,
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                    "request-origin": "fetch"
                },
                body: JSON.stringify({ pesquisa: valor })
            })
            .then(res => res.json())
            .then(data => {
                ultimaBusca = valor;
                render(data);
            })
            .catch(err => {
                if (err.name !== "AbortError") {
                    console.error(err);
                }
            });

        }, 300 || 300);
    }

    function render(data) {
        box.innerHTML = "";

        if (!data.length) {
            box.innerHTML = `<div class="list-group-item text-danger">Nenhum militar encontrado</div>`;
            return;
        }

        data.forEach(item => {
            const el = document.createElement("button");
            el.type = "button";
            el.className = "list-group-item list-group-item-action";

            el.innerHTML = `<strong>${item.militarNome}</strong><br>RG: ${item.militarRg ?? '-'} | ID Func: ${item.militarIdentidadeFuncional ?? '-'} | Situação: ${item.militarSituacaoName ?? '-'}`;

            el.addEventListener("click", () => select(item));

            box.appendChild(el);
        });
    }

    async function select(m) {
        box.innerHTML = "";
        input.value = m.militarNome;

        setValue("militar_id", m.militar_id);
        setValue("militarNome", m.militarNome);
        setValue("militarRg", m.militarRg);
        setValue("militarIdentidadeFuncional", m.militarIdentidadeFuncional);
        setValue("militarSituacaoName", m.militarSituacaoName);
        setValue("militarGraduacaoName", m.militarGraduacaoName);
        setValue("militarQuadroEspecialidadeName", m.militarQuadroEspecialidadeName);

        setValue("user", m.militarRg);
    }

    function setValue(id, value) {
        // Verificar se id=user e fazer formatação''''''''
        if (id == 'user') {
            value = value.replace(/\D/g, ''); // deixa só números
            value = value.replace(/^0+/, ''); // remove zeros à esquerda
        }
        //''''''''''''''''''''''''''''''''''''''''''''''''

        const el = document.getElementById(id);
        if (el) el.value = value ?? "";
    }

    return {
        init
    };
}

// Autocomplete Militar para os CRUDs ligados ao submódulo Militares
function crudAutocompleteMilitar(submodulo, acao) {
    const input = document.getElementById('pesquisar_militar');
    const box = document.getElementById('autocomplete_militar');

    let timeout = null;
    let controller = null;
    let ultimaBusca = "";

    function init() {
        input.addEventListener("input", onInput);
    }

    function onInput() {
        clearTimeout(timeout);

        const valor = input.value.trim();

        box.innerHTML = "";

        if (valor.length < 4) return;

        if (valor === ultimaBusca) return;

        timeout = setTimeout(() => {
            if (controller) controller.abort();

            controller = new AbortController();

            fetch(`militares/autocomplete/militar/${submodulo}/${acao}`, {
                method: "POST",
                signal: controller.signal,
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                    "request-origin": "fetch"
                },
                body: JSON.stringify({ pesquisa: valor })
            })
            .then(res => res.json())
            .then(data => {
                ultimaBusca = valor;
                render(data);
            })
            .catch(err => {
                if (err.name !== "AbortError") {
                    console.error(err);
                }
            });

        }, 300 || 300);
    }

    function render(data) {
        box.innerHTML = "";

        if (!data.length) {
            box.innerHTML = `<div class="list-group-item text-danger">Nenhum militar encontrado</div>`;
            return;
        }

        data.forEach(item => {
            const el = document.createElement("button");
            el.type = "button";
            el.className = "list-group-item list-group-item-action";

            el.innerHTML = `<strong>${item.militarNome}</strong><br>RG: ${item.militarRg ?? '-'} | ID Func: ${item.militarIdentidadeFuncional ?? '-'} | Situação: ${item.militarSituacaoName ?? '-'}`;

            el.addEventListener("click", () => select(item));

            box.appendChild(el);
        });
    }

    async function select(m) {
        // Gerar Token para Controle militar_id
        if (!await tokenServiceGerar('militar_id', m.militar_id)) return;

        // Gerar Token para Controle militarSituacaoId
        if (!await tokenServiceGerar('militarSituacaoId', m.militarSituacaoId)) return;

        // Verificando permissões para botões
        await configurarBotoesPermissaoSituacao({ modulo: submodulo, situacaoId: m.militarSituacaoId });

        // Dados
        box.innerHTML = "";
        input.value = m.militarNome;

        setValue("militar_id", m.militar_id);
        setValue("militarNome", m.militarNome);
        setValue("militarRg", m.militarRg);
        setValue("militarIdentidadeFuncional", m.militarIdentidadeFuncional);
        setValue("militarSituacaoId", m.militarSituacaoId);
        setValue("militarSituacaoName", m.militarSituacaoName);
        setValue("militarGraduacaoName", m.militarGraduacaoName);
        setValue("militarQuadroEspecialidadeName", m.militarQuadroEspecialidadeName);
    }

    function setValue(id, value) {
        const el = document.getElementById(id);
        if (el) el.value = value ?? "";
    }

    return {
        init
    };
}

async function tokenServiceGerar(scopo, id) {
    try {
        const response = await fetch(`token_service/gerar/${scopo}/${id}`, { method: 'GET' });
        const responseData = await response.json();

        if (!response.ok || !responseData.success) {
            throw new Error();
        }

        document.getElementById(`${scopo}_token`).value = responseData.success;

        return true;
    } catch (e) {
        alert(`Erro ao gerar o Token (${scopo}).`);

        return false;
    }
}

async function tokenServiceValidar(token) {
    token = (!token || token.trim() === '') ? 'xxxyyyzzz' : token;

    const response = await fetch(`token_service/validar/${token}`, { method: 'GET' });
    const response_data = await response.json();

    if (response_data.success) {
        return response_data.success;
    } else {
        return false;
    }
}

async function tokenServiceScope(token) {
    token = (!token || token.trim() === '') ? 'xxxyyyzzz' : token;

    const response = await fetch(`token_service/scope/${token}`, { method: 'GET' });
    const response_data = await response.json();

    if (response_data.success) {
        return response_data.success;
    } else {
        return false;
    }
}

async function tokenServiceId(token) {
    token = (!token || token.trim() === '') ? 'xxxyyyzzz' : token;

    const response = await fetch(`token_service/id/${token}`, { method: 'GET' });
    const response_data = await response.json();

    if (response_data.success) {
        return response_data.success;
    } else {
        return false;
    }
}

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
