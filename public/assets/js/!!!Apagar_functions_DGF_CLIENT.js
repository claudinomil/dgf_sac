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

//Funções para o Submódulo Ressarcimento Recebimentos - INÍCIO''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
//Funções para o Submódulo Ressarcimento Recebimentos - INÍCIO''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

//Configurar tabela gradeRecebimentosTable
function gradeRecebimentosTableConfigurar() {
    var total_valor = 0;
    var total_valor_recebido = 0;
    var total_saldo_restante = 0;

    //Varrer gradeRecebimentosTbodyTr
    $(".gradeRecebimentosTbodyTr").each(function () {
        //Pegando valores ta tabela tr
        var recebimento_id = $(this).data('recebimento_id');
        var valor = $("#valor_"+recebimento_id).val();
        var valor_recebido = $("#valor_recebido_br_"+recebimento_id).val();

        //Alterando valores
        valor_recebido = moeda2float(valor_recebido);
        var saldo_restante = valor - valor_recebido;

        //Totais
        total_valor += 1*valor;
        total_valor_recebido += 1*valor_recebido;
        total_saldo_restante += 1*saldo_restante;

        //Retornando valores
        $("#valor_"+recebimento_id).val(valor);
        $("#valor_recebido_"+recebimento_id).val(valor_recebido);
        $("#valor_recebido_br_"+recebimento_id).val(float2moeda(valor_recebido));
        $("#saldo_restante_"+recebimento_id).val(saldo_restante);
        $("#saldo_restante_br_"+recebimento_id).val(float2moeda(saldo_restante));

        //Colocando o input saldo_restante_br_* como disabled
        $("#saldo_restante_br_"+recebimento_id).prop('disabled', true);
    });

    //Retornando valores totais
    $("#total_valor").val(float2moeda(total_valor));
    $("#total_valor_recebido").val(float2moeda(total_valor_recebido));
    $("#total_saldo_restante").val(float2moeda(total_saldo_restante));

    //Ajustar tamanhos das colunas de valores'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    var col_valor_largura = $("#gradeRecebimentosTable .col_valor").width();
    if (col_valor_largura < 90) {col_valor_largura = 90;}

    $("#gradeRecebimentosTable .col_valor").css('width', col_valor_largura);

    $("#gradeRecebimentosTable .col_valor_recebido").css('width', col_valor_largura+20);
    $("#gradeRecebimentosTable .col_valor_recebido").css('min-width', col_valor_largura+20);
    $("#gradeRecebimentosTable .col_valor_recebido").css('max-width', col_valor_largura+20);

    $("#gradeRecebimentosTable .col_saldo_restante").css('width', col_valor_largura+20);
    $("#gradeRecebimentosTable .col_saldo_restante").css('min-width', col_valor_largura+20);
    $("#gradeRecebimentosTable .col_saldo_restante").css('max-width', col_valor_largura+20);
    //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
}

//Funções para o Submódulo Ressarcimento Recebimentos - FIM'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
//Funções para o Submódulo Ressarcimento Recebimentos - FIM'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

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
function alertSwalConfirmacao(callback) {
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
        callback(confirmed && confirmed.value == true);
    });
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

//Modal de Confirmação para Exclusão de Registro - (CRUD)
// function alertSwalConfirmacaoExclusaoRegistro(id, descricao) {
//     Swal.fire({
//         title: 'Confirma exclusão do registro?',
//         text: descricao,
//         icon: 'warning',
//         showDenyButton: true,
//         confirmButtonText: '<i class="fa fa-thumbs-up"></i> Confirmar',
//         confirmButtonColor: '#38c172',
//         denyButtonText: `<i class="fa fa-thumbs-down"></i> Cancelar`,
//         denyButtonColor: '#e3342f'
//     }).then((result) => {
//         if (result.isConfirmed) {
//             Livewire.emit("destroy", id);
//         }
//     });
// }

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

/*
* @PARAM op=1 : Entrada 01/02/2003   Saída 2003-02-01
* @PARAM op=2 : Entrada 2003-02-01   Saída 01/02/2003
 */
function formatarData(op, data) {
    if (data === null || data == '') {return '';}

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

function gerarCor(op=0) {
    if (op == 1) {
        cor = '#556ee6';
    } else if (op == 2) {
        cor = '#f46a6a';
    } else if (op == 3) {
        cor = '#34c38f';
    } else if (op == 4) {
        cor = '#f1b44c';
    } else if (op == 5) {
        cor = '#564ab1';
    } else if (op == 6) {
        cor = '#adb5bd';
    } else if (op == 7) {
        cor = '#e83e8c';
    } else if (op == 8) {
        cor = '#000000';
    } else if (op == 9) {
        cor = '#50a5f1';
    } else if (op == 10) {
        cor = '#74788d';
    } else if (op == 11) {
        cor = '#6f42c1';
    } else if (op == 12) {
        cor = '#e83e8c';
    } else if (op == 13) {
        cor = '#34c38f';
    } else if (op == 14) {
        cor = '#f1b44c';
    } else if (op == 15) {
        cor = '#556ee6';
    } else if (op == 16) {
        cor = '#74788d';
    } else if (op == 17) {
        cor = '#f46a6a';
    } else if (op == 18) {
        cor = '#50a5f1';
    } else if (op == 19) {
        cor = '#343a40';
    } else if (op == 20) {
        cor = '#74788d';
    } else {
        var hexadecimais = '0123456789ABCDEF';
        var cor = '#';

        //Pega um número aleatório no array acima
        for (var i = 0; i < 6; i++) {
            //E concatena à variável cor
            cor += hexadecimais[Math.floor(Math.random() * 16)];
        }
    }

    return cor;
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
