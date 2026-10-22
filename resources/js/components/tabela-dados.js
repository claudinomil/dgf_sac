/**
 * Componente reutilizável para montar tabelas Bootstrap 5.
 *
 * Opções:
 * - elemento: ID ou elemento DOM onde a tabela será renderizada.
 * - colunas: configuração das colunas.
 * - dados: array de objetos.
 * - vazio: mensagem quando não houver registros.
 * - classe: classes CSS da tabela.
 * - responsiva: envolve a tabela em table-responsive.
 * - numerar: adiciona numeração automática quando não houver
 *   uma coluna do tipo "numero".
 *
 * Configurações das colunas:
 * - titulo: título do cabeçalho.
 * - campo: propriedade do registro, aceita campos aninhados.
 * - tipo: texto, numero, booleano, badge, data, personalizado.
 * - classe: classes CSS adicionais.
 * - alinhamento: start, center ou end.
 * - nowrap: true para impedir a quebra de linha.
 * - mapa: mapeamento de valores para classes Bootstrap (badge).
 * - formato: formato de data.
 * - formatar: função de formatação personalizada.
 */

export function montarTabela({ elemento, colunas = [], dados = [], vazio = 'Nenhum registro encontrado.', classe = 'table mb-0', responsiva = true, numerar = false }) {
    // Localizar o elemento de destino.
    const destino = typeof elemento === 'string' ? document.getElementById(elemento) : elemento;

    if (!destino) {
        throw new Error('Elemento de destino da tabela não encontrado.');
    }

    if (!Array.isArray(colunas) || colunas.length === 0) {
        throw new Error('Informe pelo menos uma coluna para a tabela.');
    }

    if (!Array.isArray(dados)) {
        throw new TypeError('Os dados da tabela devem ser um array.');
    }

    const temColunaNumero = colunas.some(coluna => coluna.tipo === 'numero');
    const adicionarNumero = numerar && !temColunaNumero;

    // Criar elementos HTML com texto seguro.
    const criarElemento = (tag, texto = null, classes = '') => {
        const elementoHTML = document.createElement(tag);

        if (texto !== null && texto !== undefined) {
            elementoHTML.textContent = String(texto);
        }

        if (classes) {
            elementoHTML.className = classes;
        }

        return elementoHTML;
    };

    // Aplicar classes e alinhamentos ao cabeçalho e às células.
    const aplicarEstiloColuna = (elementoHTML, coluna) => {
        if (coluna.classe) {
            elementoHTML.classList.add(...coluna.classe.split(/\s+/).filter(Boolean));
        }

        const alinhamentosValidos = ['start', 'center', 'end'];

        if (alinhamentosValidos.includes(coluna.alinhamento)) {
            elementoHTML.classList.add(`text-${coluna.alinhamento}`);
        }

        if (coluna.nowrap === true) {
            elementoHTML.classList.add('text-nowrap');
        }
    };

    // Recuperar propriedades simples ou aninhadas.
    // Exemplo: militar.nome
    const obterValor = (registro, campo) => {
        if (!campo) {
            return null;
        }

        return String(campo)
            .split('.')
            .reduce((objeto, propriedade) => {
                if (objeto === null || objeto === undefined || typeof objeto !== 'object') {
                    return undefined;
                }

                return objeto[propriedade];
            }, registro);
    };

    // Converter valores vazios em um traço.
    const valorOuTraco = valor => {
        return valor === null || valor === undefined || valor === '' ? '-' : valor;
    };

    // Interpretar valores booleanos recebidos pelo JSON.
    const interpretarBooleano = valor => {
        if (valor === true || valor === 1 || valor === '1') {
            return true;
        }

        if (valor === false || valor === 0 || valor === '0' || valor === null || valor === undefined || valor === '') {
            return false;
        }

        const normalizado = String(valor).trim().toLowerCase();

        if (['sim', 'true', 'yes'].includes(normalizado)) {
            return true;
        }

        if (['não', 'nao', 'false', 'no'].includes(normalizado)) {
            return false;
        }

        return Boolean(valor);
    };

    // Formatar datas sem deslocar datas SQL por fuso horário.
    const formatarData = (valor, formato = 'd/m/Y') => {
        if (valor === null || valor === undefined || valor === '') {
            return '-';
        }

        let data;

        if (typeof valor === 'string' && /^\d{4}-\d{2}-\d{2}$/.test(valor)) {
            const [ano, mes, dia] = valor.split('-').map(Number);
            data = new Date(ano, mes - 1, dia);
        } else {
            data = new Date(valor);
        }

        if (Number.isNaN(data.getTime())) {
            return String(valor);
        }

        const partes = {
            d: String(data.getDate()).padStart(2, '0'),
            m: String(data.getMonth() + 1).padStart(2, '0'),
            Y: String(data.getFullYear()),
            H: String(data.getHours()).padStart(2, '0'),
            i: String(data.getMinutes()).padStart(2, '0'),
            s: String(data.getSeconds()).padStart(2, '0')
        };

        return formato.replace(/[dmYHis]/g, letra => partes[letra]);
    };

    // Renderizar o conteúdo de uma célula.
    const renderizarCelula = (celula, coluna, registro, indice) => {
        const tipo = coluna.tipo ?? 'texto';
        const valor = obterValor(registro, coluna.campo);

        if (tipo === 'numero') {
            celula.textContent = String(indice + 1);
            return;
        }

        if (tipo === 'booleano') {
            const ativo = interpretarBooleano(valor);

            const badge = criarElemento('span', ativo ? 'Sim' : 'Não', `badge ${ativo ? 'bg-success' : 'bg-danger'}`);

            celula.appendChild(badge);
            return;
        }

        if (tipo === 'badge') {
            const mapa = coluna.mapa ?? {};
            const chave = String(valor ?? '');
            const texto = valorOuTraco(valor);
            const classeBadge = mapa[chave] ?? 'bg-secondary';
            const badge = criarElemento('span', texto, `badge ${classeBadge}`);

            celula.appendChild(badge);
            return;
        }

        if (tipo === 'data') {
            celula.textContent = formatarData(valor, coluna.formato ?? 'd/m/Y');
            return;
        }

        if (tipo === 'personalizado' && typeof coluna.formatar === 'function') {
            const resultado = coluna.formatar(valor, registro, indice);

            // Permitir elementos DOM criados por callbacks confiáveis.
            // Strings continuam sendo tratadas como texto.
            if (resultado instanceof Node) {
                celula.appendChild(resultado);
            } else {
                celula.textContent = String(valorOuTraco(resultado));
            }

            return;
        }

        celula.textContent = String(valorOuTraco(valor));
    };

    // Criar a tabela.
    const tabela = criarElemento('table', null, classe);

    // Cabeçalho.
    const thead = criarElemento('thead');
    thead.classList.add('table-light');

    const trCabecalho = criarElemento('tr');

    if (adicionarNumero) {
        const th = criarElemento('th', '#');
        th.scope = 'col';
        trCabecalho.appendChild(th);
    }

    colunas.forEach(coluna => {
        const th = criarElemento('th', coluna.titulo ?? '');
        th.scope = 'col';

        aplicarEstiloColuna(th, coluna);
        trCabecalho.appendChild(th);
    });

    thead.appendChild(trCabecalho);
    tabela.appendChild(thead);

    // Corpo.
    const tbody = criarElemento('tbody');

    if (dados.length === 0) {
        const tr = criarElemento('tr');
        const td = criarElemento('td', vazio, 'text-center text-muted py-3');

        td.colSpan = colunas.length + (adicionarNumero ? 1 : 0);
        tr.appendChild(td);
        tbody.appendChild(tr);
    } else {
        dados.forEach((registro, indice) => {
            const tr = criarElemento('tr');

            if (adicionarNumero) {
                const th = criarElemento('th', indice + 1);
                th.scope = 'row';
                tr.appendChild(th);
            }

            colunas.forEach(coluna => {
                const td = criarElemento('td');

                aplicarEstiloColuna(td, coluna);
                renderizarCelula(td, coluna, registro, indice);
                tr.appendChild(td);
            });

            tbody.appendChild(tr);
        });
    }

    tabela.appendChild(tbody);

    // Substituir a tabela anterior.
    destino.replaceChildren();

    if (responsiva) {
        const responsivo = criarElemento('div', null, 'table-responsive');

        responsivo.appendChild(tabela);
        destino.appendChild(responsivo);
    } else {
        destino.appendChild(tabela);
    }

    return tabela;
}
