// Configuração
function crudConfiguracao({p_frm_operacao=null, p_fieldsDisabled=null, p_crudFormButtons1=null, p_crudFormButtons2=null, p_crudTable=null, p_crudForm=null, p_crudFormAjaxLoading=null, p_removeMask=null, p_putMask=null}) {
    // Campo hidden frm_operacao
    if (p_frm_operacao !== null) {
        document.getElementById('frm_operacao').value = p_frm_operacao;
    }

    // Campos do Formulário - disabled true/false
    if (p_fieldsDisabled !== null) {
        // Seleciona todos os inputs
        var elementos = document.querySelectorAll('input');
        elementos.forEach(function(elemento) {
            elemento.disabled = p_fieldsDisabled;
        });

        // Seleciona todos os textareas
        var elementos = document.querySelectorAll('textarea');
        elementos.forEach(function(elemento) {
            elemento.disabled = p_fieldsDisabled;
        });

        // Seleciona todos os selects
        var elementos = document.querySelectorAll('select');
        elementos.forEach(function(elemento) {
            elemento.disabled = p_fieldsDisabled;
        });

        // Seleciona todos os select2s
        var elementos = document.querySelectorAll('.select2');
        elementos.forEach(function(elemento) {
            elemento.disabled = p_fieldsDisabled;
        });

        // Campos do Formulário - disabled true/false (Campos Padrões)
        if (p_fieldsDisabled === true) {
            //Seleciona fildFilterTable
            var elementos = document.querySelectorAll('.fildFilterTable');
            elementos.forEach(function(elemento) {
                elemento.disabled = false;
            });

            //Seleciona fildLengthTable
            var elementos = document.querySelectorAll('.fildLengthTable');
            elementos.forEach(function(elemento) {
                elemento.disabled = false;
            });
        }
    }

    // Botões do Modal
    if (p_crudFormButtons1 == 'show') {
        document.getElementById('crudFormButtons1').style.display = 'block';

        // Verificando botões inferiores no formulário (só alguns submódulos tem esses botões inferiores)'''
        let divBotInf = document.getElementById('crudFormButtons1_inferior');
        if (divBotInf) {document.getElementById('crudFormButtons1_inferior').style.display = 'block';}
        //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    }

    if (p_crudFormButtons1 == 'hide') {
        document.getElementById('crudFormButtons1').style.display = 'none';

        // Verificando botões inferiores no formulário (só alguns submódulos tem esses botões inferiores)'''
        let divBotInf = document.getElementById('crudFormButtons1_inferior');
        if (divBotInf) {document.getElementById('crudFormButtons1_inferior').style.display = 'none';}
        //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    }

    if (p_crudFormButtons2 == 'show') {
        document.getElementById('crudFormButtons2').style.display = 'block';

        // Verificando botões inferiores no formulário (só alguns submódulos tem esses botões inferiores)'''
        let divBotInf = document.getElementById('crudFormButtons2_inferior');
        if (divBotInf) {document.getElementById('crudFormButtons2_inferior').style.display = 'block';}
        //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    }

    if (p_crudFormButtons2 == 'hide') {
        document.getElementById('crudFormButtons2').style.display = 'none';

        // Verificando botões inferiores no formulário (só alguns submódulos tem esses botões inferiores)'''
        let divBotInf = document.getElementById('crudFormButtons2_inferior');
        if (divBotInf) {document.getElementById('crudFormButtons2_inferior').style.display = 'none';}
        //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    }

    // Table Show/Hide
    if (p_crudTable == 'show') {
        // Seleciona crudTable
        document.getElementById('crudTable').style.display = 'block';
    }

    if (p_crudTable == 'hide') {
        // Seleciona crudTable
        document.getElementById('crudTable').style.display = 'none';
    }

    // Form Show/Hide
    if (p_crudForm == 'show') {
        // Seleciona crudForm
        document.getElementById('crudForm').style.display = 'block';
    }

    if (p_crudForm == 'hide') {
        // Seleciona crudForm
        document.getElementById('crudForm').style.display = 'none';
    }

    // DIV Loading Show/Hide
    if (p_crudFormAjaxLoading == 'show') {
        // Seleciona crudFormAjaxLoading
        document.getElementById('crudFormAjaxLoading').style.display = 'block';
    }

    if (p_crudFormAjaxLoading == 'hide') {
        // Seleciona crudFormAjaxLoading
        document.getElementById('crudFormAjaxLoading').style.display = 'none';
    }

    //Removendo Máscaras
    if (p_removeMask === true) {removeMask();}

    //Restaurando Máscaras
    if (p_putMask === true) {putMask();}
}

//Preencher Formulario
async function crudPreencherFormulario(campo, dados) {
    var campo_formulario = campo;
    var campo_tabela = campo;

    if (campo_tabela == 'id') {
        document.getElementById('registro_id').value = dados['id'];
    } else {
        var elemento = document.getElementById(campo_formulario);
        if (elemento) {
            if (elemento.classList.contains('select2')) {
                //Incluindo valor no Select e alterando no Select2
                var select2 = document.getElementById(campo_formulario);
                select2.value = dados[campo_tabela];
                var event = new Event('change', { bubbles: true });
                select2.dispatchEvent(event);
            } else {
                document.getElementById(campo_formulario).value = dados[campo_tabela];
            }
        }
    }
}

// Limpar Formulario
function crudLimparFormulario(nomeFormulario) {
    const form = document.getElementById(nomeFormulario);
    if (!form) return;

    // remover validação bootstrap
    form.querySelectorAll('.is-invalid').forEach(el=>{
        el.classList.remove('is-invalid');
    });

    // Limpar Select2
    form.querySelectorAll('.select2').forEach(el=>{
        $(el).val(null).trigger('change');
    });

    // limpar campos
    Array.from(form.elements).forEach(el => {
        switch (el.type) {
            case 'text':
            case 'textarea':
            case 'email':
            case 'number':
            case 'password':
            case 'hidden':
            case 'select-one':
                el.value = '';
            break;

            case 'checkbox':
            case 'radio':
                el.checked = false;
            break;

            case 'file':
                el.value = null;
            break;
        }
    });
}

//Montartabela
async function crudTable(route, fieldsColumns='', pageLength=5) {
    if (fieldsColumns == '') {
        let crudFieldsColumnsTable = document.getElementById('crudFieldsColumnsTable').value;
        let camposColunasTabelas = crudFieldsColumnsTable.split(',');
        fieldsColumns = [];
        camposColunasTabelas.forEach(function (campo) {
            fieldsColumns.push({data: campo});
        });
    }

    //DataTable configurações
    var tabela = document.getElementById('datatable-crud-ajax');
    var dataTable = new DataTable(tabela, {
        language: {
            pageLength: {
                '-1': 'Mostrar todos os registros',
                '_': 'Mostrar %d registros'
            },
            lengthMenu: 'Exibir _MENU_ resultados por página',
            emptyTable: 'Nenhum registro encontrado',
            info: 'Mostrando de _START_ até _END_ de _TOTAL_ registros',
            infoEmpty: 'Mostrando 0 até 0 de 0 registros',
            infoFiltered: '(Filtrados de _MAX_ registros)',
            infoThousands: '.',
            loadingRecords: 'Carregando...',
            processing: 'Processando...',
            zeroRecords: 'Nenhum registro encontrado',
            search: 'Pesquisar',
            paginate: {
                next: 'Próximo',
                previous: 'Anterior',
                first: 'Primeiro',
                last: 'Último'
            }
        },
        bDestroy: true,
        responsive: false,
        lengthChange: true,
        autoWidth: true,
        order: [],
        processing: true,
        serverSide: false,
        pageLength: pageLength,
        ajax: route,
        columns: fieldsColumns,

        // Após terminar a Grade de Registros
        initComplete: function (settings, json) {
            showTooltips();
        }
    });

    // Configuração
    crudConfiguracao({p_fieldsDisabled:false});
}

// Create
async function crudCreate() {
    // Variáveis
    let prefixPermissaoSubmodulo = document.getElementById('crudPrefixPermissaoSubmodulo').value;
    let nameSubmodulo = document.getElementById('crudNameSubmodulo').value;
    let nameFormSubmodulo = document.getElementById('crudNameFormSubmodulo').value;

    // Acessar rota
    fetch(prefixPermissaoSubmodulo+'/create', {
        method: 'GET',
        headers: {'REQUEST-ORIGIN': 'fetch'}
    }).then(response => {
        return response.json();
    }).then(async (data) => {
        // Lendo dados
        if (data.success) {
            // Limpar Formulario
            crudLimparFormulario(nameFormSubmodulo);

            // Configuração
            crudConfiguracao({p_frm_operacao:'create', p_fieldsDisabled:false, p_crudFormButtons1:'show', p_crudFormButtons2:'hide', p_crudTable:'hide', p_crudForm:'show', p_removeMask:true, p_putMask:true});

            // Settings Submódulos''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            if (typeof window['settingsSubmoduloCrudCreate'] === 'function') {
                settingsSubmoduloCrudCreate();
            }
            //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        } else {
            alert('Erro interno');
        }
    }).catch(error => {
        alert('ErroFunctions:'+error);
    });
}

// View
async function crudView(registro_id) {
    // Campo hidden registro_id
    document.getElementById('registro_id').value = registro_id;

    // Variáveis
    const prefixPermissaoSubmodulo = document.getElementById('crudPrefixPermissaoSubmodulo').value;
    const nameFormSubmodulo = document.getElementById('crudNameFormSubmodulo').value;

    const url = `${prefixPermissaoSubmodulo}/${registro_id}`;

    try {
        const response = await fetch(url, {
            method: 'GET',
            headers: {
                'REQUEST-ORIGIN': 'fetch',
                'Accept': 'application/json'
            }
        });

        const data = await response.json();

        // Lendo dados
        if (data.success) {
            // Limpar formulário
            crudLimparFormulario(nameFormSubmodulo);

            // Configuração da tela
            crudConfiguracao({ p_frm_operacao: 'view', p_fieldsDisabled: true, p_crudFormButtons1: 'hide', p_crudFormButtons2: 'show', p_crudTable: 'hide', p_crudForm: 'show', p_removeMask: true, p_putMask: true });

            // Preencher formulário
            const campos = document.getElementById('crudFieldsFormSubmodulo').value.split(',');
            campos.forEach(field => {
                crudPreencherFormulario(field, data.success);
            });

            // Settings Submódulos''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            if (typeof window['settingsSubmoduloCrudView'] === 'function') {
                settingsSubmoduloCrudView(data.success);
            }
            //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        } else if (data.error) {
            alertSwal('warning', data.error, '', 'true', 3000);
        } else {
            alert('Erro interno');
        }
    } catch (error) {
        alert('Erro Crud Functions View: ' + error);
    } finally {
        // Garantir restauração de máscaras
        crudConfiguracao({ p_removeMask: true, p_putMask: true });
    }
}

// Edit
async function crudEdit(registro_id) {
    // Variáveis
    if (registro_id == 0) { registro_id = document.getElementById('registro_id').value; }
    const prefixPermissaoSubmodulo = document.getElementById('crudPrefixPermissaoSubmodulo').value;
    const nameFormSubmodulo = document.getElementById('crudNameFormSubmodulo').value;

    const url = `${prefixPermissaoSubmodulo}/${registro_id}/edit`;

    try {
        const response = await fetch(url, {
            method: 'GET',
            headers: {
                'REQUEST-ORIGIN': 'fetch',
                'Accept': 'application/json'
            }
        });

        const data = await response.json();

        // Lendo dados
        if (data.success) {
            // Limpar formulário
            crudLimparFormulario(nameFormSubmodulo);

            // Configuração da tela
            crudConfiguracao({ p_frm_operacao: 'edit', p_fieldsDisabled: false, p_crudFormButtons1: 'show', p_crudFormButtons2: 'hide', p_crudTable: 'hide', p_crudForm: 'show', p_removeMask: true, p_putMask: true });

            // Preencher formulário
            const campos = document.getElementById('crudFieldsFormSubmodulo').value.split(',');
            campos.forEach(field => {
                crudPreencherFormulario(field, data.success);
            });

            // Settings Submódulos''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            if (typeof window['settingsSubmoduloCrudEdit'] === 'function') {
                settingsSubmoduloCrudEdit(data.success);
            }
            //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        } else if (data.error) {
            alertSwal('warning', data.error, '', 'true', 3000);
        } else {
            alert('Erro interno');
        }
    } catch (error) {
        alert('Erro Crud Functions View: ' + error);
    } finally {
        // Garantir restauração de máscaras
        crudConfiguracao({ p_removeMask: true, p_putMask: true });
    }
}

// Delete
async function crudDelete(registro_id) {
    // Variáveis
    if (registro_id == 0) { registro_id = document.getElementById('registro_id').value; }
    const prefixPermissaoSubmodulo = document.getElementById('crudPrefixPermissaoSubmodulo').value;
    const nameSubmodulo = document.getElementById('crudNameSubmodulo').value;
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    const url = `${prefixPermissaoSubmodulo}/${registro_id}`;

    // Confirmação
    const confirmed = await alertSwalConfirmacao();
    if (!confirmed) return;

    try {
        // Configuração - Loading
        crudConfiguracao({ p_crudFormButtons1: 'hide', p_crudFormAjaxLoading: 'show' });

        // Settings Submódulos''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        if (typeof window['settingsSubmoduloCrudDelete'] === 'function') {
            settingsSubmoduloCrudDelete();
        }
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        const response = await fetch(url, {
            method: 'DELETE',
            headers: {
                'REQUEST-ORIGIN': 'fetch',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            }
        });

        const data = await response.json();

        // Sucesso
        if (data.success) {
            alertSwal('success', data.success, '', 'true', 2000);

            crudConfiguracao({ p_crudTable: 'show', p_crudForm: 'hide' });

            crudTable(prefixPermissaoSubmodulo);
        } else if (data.error) {
            alertSwal('warning', data.error, '', 'true', 3000);

            crudConfiguracao({ p_crudTable: 'show', p_crudForm: 'hide' });

            crudTable(prefixPermissaoSubmodulo);
        } else if (data.error_validation) {
            const message = montarMensagemValidacao(data.error_validation);
            alertSwal('warning', "Validação", message, 'true', 3000);

            crudConfiguracao({ p_removeMask: true, p_putMask: true });
        } else {
            alert('Erro interno');
        }
    } catch (error) {
        crudConfiguracao({ p_removeMask: true, p_putMask: true });

        alert('Erro Crud Functions Delete: ' + error);
    } finally {
        // Restaurar botões
        crudConfiguracao({ p_crudFormButtons1: 'show', p_crudFormAjaxLoading: 'hide' });
    }
}

// Confirm Operacao
async function crudConfirmOperation() {
    // Variáveis
    const registro_id = document.getElementById('registro_id').value;
    const prefixPermissaoSubmodulo = document.getElementById('crudPrefixPermissaoSubmodulo').value;
    const nameSubmodulo = document.getElementById('crudNameSubmodulo').value;
    const nameFormSubmodulo = document.getElementById('crudNameFormSubmodulo').value;
    const frm_operacao = document.getElementById('frm_operacao').value;
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    const formulario = document.getElementById(nameFormSubmodulo);

    // Verificar Validação
    if (await window['validar_' + nameFormSubmodulo]() !== true) return;

    let executar = 1;

    //Settings Submódulos'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

    if (executar != 1) return;

    // Configuração
    crudConfiguracao({ p_removeMask: true });

    // Função para tratamento comum
    function tratarResposta(data) {
        if (data.success) {
            alertSwal('success', nameSubmodulo, data.success, 'true', 2000);
            crudLimparFormulario(nameFormSubmodulo);
            crudConfiguracao({ p_crudTable: 'show', p_crudForm: 'hide' });
            crudTable(prefixPermissaoSubmodulo);
        } else if (data.error_validation) {
            crudConfiguracao({ p_removeMask: true, p_putMask: true });
            const message = montarMensagemValidacao(data.error_validation);
            alertSwal('warning', "Validação", message, 'true', 3000);
        } else if (data.error) {
            crudConfiguracao({ p_removeMask: true, p_putMask: true });
            alertSwal('warning', nameSubmodulo, data.error, 'true', 3000);
        } else {
            crudConfiguracao({ p_removeMask: true, p_putMask: true });
            alert('Erro interno');
        }
    }

    // Configuração loading
    crudConfiguracao({ p_crudFormButtons1: 'hide', p_crudFormAjaxLoading: 'show' });

    // CREATE
    if (frm_operacao == 'create') {
        // Settings Submódulos''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        if (typeof window['settingsSubmoduloCrudConfirmCreate'] === 'function') {
            settingsSubmoduloCrudConfirmCreate();
        }
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        // FormData (Tem que ser aqui apos a settingsSubmoduloCrudConfirmCreate())
        const formData = new FormData(formulario);

        // Fetch
        fetch(prefixPermissaoSubmodulo, {
            method: 'POST',
            headers: {
                'REQUEST-ORIGIN': 'fetch',
                'X-CSRF-TOKEN': csrfToken
            },
            body: formData
        }).then(response => response.json()).then(data => tratarResposta(data)).catch(error => {
            crudConfiguracao({ p_removeMask: true, p_putMask: true });
            alert('Erro Crud Functions Confirm Operation Create: ' + error);
        }).finally(() => {
            crudConfiguracao({ p_crudFormButtons1: 'show', p_crudFormAjaxLoading: 'hide' });
        });
    }

    // EDIT
    if (frm_operacao == 'edit') {
        // Settings Submódulos''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        if (typeof window['settingsSubmoduloCrudConfirmEdit'] === 'function') {
            await settingsSubmoduloCrudConfirmEdit();
        }
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        // FormData (Tem que ser aqui apos a settingsSubmoduloCrudConfirmCreate())
        const formData = new FormData(formulario);

        // Fetch
        fetch(`${prefixPermissaoSubmodulo}/${registro_id}`, {
            method: 'POST',
            headers: {
                'REQUEST-ORIGIN': 'fetch',
                'X-CSRF-TOKEN': csrfToken
            },
            body: formData
        }).then(response => response.json()).then(data => tratarResposta(data)).catch(error => {
            crudConfiguracao({ p_removeMask: true, p_putMask: true });
            alert('Erro Crud Functions Confirm Operation Edit:' + error);
        }).finally(() => {
            crudConfiguracao({ p_crudFormButtons1: 'show', p_crudFormAjaxLoading: 'hide' });
        });
    }
}

// Cancel Operacao
function crudCancelOperation() {
    // Configuração
    crudConfiguracao({p_fieldsDisabled:false, p_crudTable:'show', p_crudForm:'hide'});
}

// Filter New
function crudFilterInsertLine() {
    // Seleciona a div original
    var divOriginal = document.getElementsByClassName('filterRepeaterItem')[0];

    // Clona a div sem os valores dos inputs
    var divClonada = divOriginal.cloneNode(true);

    // Limpa os valores dos inputs clonados
    var inputsClonados = divClonada.getElementsByTagName("input");
    for (var i = 0; i < inputsClonados.length; i++) {inputsClonados[i].value = "";}

    // Adiciona a div clonada abaixo da original
    document.getElementById("filterRepeaterList").appendChild(divClonada);

    // Ajustar Itens
    crudFilterAdjustItems();
}

// Remover Item
function crudFilterRemoveLine(dataId='') {
    // Pegando todas as Divs
    var divs = document.querySelectorAll('.filterRepeaterItem');

    // Verificando se só tem um item e não deixar remover
    if (divs.length == 1) {
        alert('Não é possivel remover.');
    } else {
        // Varrendo as Divs para remover a solicitada
        divs.forEach(function (div) {
            if (div.dataset.id === dataId) {
                div.remove();
            }
        });

        // Ajustar Itens
        crudFilterAdjustItems();
    }
}

// Função para montar mensagem de validação
function montarMensagemValidacao(validations) {
    let message = '<div class="pt-3">';
    for (const chave in validations) {
        message += `<div class="col-12 text-start font-size-12"><b>></b> ${validations[chave]}</div>`;
    }
    message += '</div>';
    return message;
}

// Filter Ajustar itens
function crudFilterAdjustItems() {
    // Colocar data-id nos itens
    var ind = 0;
    document.querySelectorAll('.filterRepeaterItem').forEach(function(elemento) {
        elemento.dataset.id = ind;
        ind++;
    });

    // Colocar a função para remover linhas nos botões
    var ind = 0;
    document.querySelectorAll('#filter_crud_botao_excluir').forEach(function(elemento) {
        elemento.value = ind;

        // Colocando função no elemento
        elemento.onclick = function () {
            crudFilterRemoveLine(elemento.value);
        };

        ind++;
    });
}

// Executar Filtros
function crudFilterExecutar(submodulo='') {
    // Variáveis
    if (submodulo == '') {submodulo = document.getElementById('crudPrefixPermissaoSubmodulo').value;}

    // Pegar quantidade de Itens/Filtros
    var qtdItens = document.querySelectorAll('.filterRepeaterItem').length;

    // Arrays
    const array_dados = [];

    // Varrer filtros para montar array de dados
    for(i=0; i<qtdItens; i++) {
        var tipo_condicao = document.getElementsByName('filter_crud_tipo_condicao')[i];
        var campo_pesquisar = document.getElementsByName('filter_crud_campo_pesquisar')[i];
        var operacao_realizar = document.getElementsByName('filter_crud_operacao_realizar')[i];
        var dado_pesquisar = document.getElementsByName('filter_crud_dado_pesquisar')[i];

        if (dado_pesquisar.value == '') {
            alert('Digite algo para pesquisar no filtro ' + (i + 1));

            return false;
        }

        // Populando array_dados
        array_dados.push(tipo_condicao.value);
        array_dados.push(campo_pesquisar.value);
        array_dados.push(operacao_realizar.value);
        array_dados.push(dado_pesquisar.value);
    }

    // Table
    crudTable(submodulo+'/filter/'+array_dados);
}

// OffCanva Profille View
async function crudOffCanvaProfilleView(op, user_id) {
    // Buscar Elementos
    const profilleImgAvatar = document.getElementById('profilleImgAvatar');
    const profilleName = document.getElementById('profilleName');
    const profilleInformacaoName = document.getElementById('profilleInformacaoName');
    const profilleInformacaoUser = document.getElementById('profilleInformacaoUser');
    const profilleInformacaoEmail = document.getElementById('profilleInformacaoEmail');
    const profilleInformacaoGrupoName = document.getElementById('profilleInformacaoGrupoName');
    const profilleInformacaoSituacaoName = document.getElementById('profilleInformacaoSituacaoName');
    const profilleInformacaoUserTipoName = document.getElementById('profilleInformacaoUserTipoName');
    const profilleInformacaoMilitarRg = document.getElementById('profilleInformacaoMilitarRg');
    const profilleInformacaoMilitarNome = document.getElementById('profilleInformacaoMilitarNome');
    const profilleInformacaoMilitarPostoGraduacao = document.getElementById('profilleInformacaoMilitarPostoGraduacao');
    const profilleInformacaoMilitarSituacao = document.getElementById('profilleInformacaoMilitarSituacao');
    const profilleInformacaoMilitarQuadroEspecialidade = document.getElementById('profilleInformacaoMilitarQuadroEspecialidade');

    // Limpar Elementos
    profilleImgAvatar.src = 'assets/images/users/avatar-0.png';
    profilleName.innerText = '';
    profilleInformacaoName.innerText = '';
    profilleInformacaoUser.innerText = '';
    profilleInformacaoEmail.innerText = '';
    profilleInformacaoGrupoName.innerText = '';
    profilleInformacaoSituacaoName.innerText = '';
    profilleInformacaoUserTipoName.innerText = '';
    profilleInformacaoMilitarRg.innerText = '';
    profilleInformacaoMilitarNome.innerText = '';
    profilleInformacaoMilitarPostoGraduacao.innerText = '';
    profilleInformacaoMilitarSituacao.innerText = '';
    profilleInformacaoMilitarQuadroEspecialidade.innerText = '';

    // Abrir OffCanva Profille
    const offcanvasElement = document.getElementById('offcanvaProfille');
    const offcanvas = new bootstrap.Offcanvas(offcanvasElement);
    offcanvas.show();

    // Show/Hide Elementos para Usuário Logado'''''''''''''''''''''''''''''''''''''''''
    const userLogado = document.querySelectorAll('.profille_user_logado');
    const mostrarLogado = op == 2;

    userLogado.forEach(el => {
        el.style.display = mostrarLogado ? '' : 'none';
    });
    //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

    // URL
    const url = `users/${user_id}`;

    try {
        const response = await fetch(url, {
            method: 'GET',
            headers: { 'REQUEST-ORIGIN': 'fetch' }
        });

        const data = await response.json();

        // Lendo dados
        if (data.success) {
            const user = data.success;

            // Popular Elementos
            profilleImgAvatar.src = user.avatar;
            profilleName.innerText = user.name;
            profilleInformacaoName.innerText = user.name;
            profilleInformacaoUser.innerText = user.user;
            profilleInformacaoEmail.innerText = user.email;
            profilleInformacaoGrupoName.innerText = user.grupoName;
            profilleInformacaoSituacaoName.innerText = user.situacaoName;
            profilleInformacaoUserTipoName.innerText = user.userTipoName;
            profilleInformacaoMilitarRg.innerText = user.militarRg;
            profilleInformacaoMilitarNome.innerText = user.militarNome;
            profilleInformacaoMilitarPostoGraduacao.innerText = user.militarGraduacaoName;
            profilleInformacaoMilitarSituacao.innerText = user.militarSituacaoName;
            profilleInformacaoMilitarQuadroEspecialidade.innerText = user.militarQuadroEspecialidadeName;

            // class="profille_user_tipo_militar"''''''''''''''''''''''''''''''''''''''''''''''
            const userTipoMilitar = document.querySelectorAll('.profille_user_tipo_militar');
            const mostrarMilitar = user.user_tipo_id == 1;

            userTipoMilitar.forEach(el => {
                el.style.display = mostrarMilitar ? '' : 'none';
            });
            //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            // class="user_tipo_civil''"'''''''''''''''''''''''''''''''''''''''''''''''''''''''
            const userTipoCivil = document.querySelectorAll('.user_tipo_civil');
            const mostrarCivil = user.user_tipo_id == 2;

            userTipoCivil.forEach(el => {
                el.style.display = mostrarCivil ? '' : 'none';
            });
            //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        } else if (data.error) {
            alertSwal('warning', data.error, '', 'true', 3000);
        } else {
            alert('Erro interno');
        }
    } catch (error) {
        alert('Erro crudOffCanvaProfilleView: ' + error);
    } finally {
        // Garantir restauração de máscaras
        crudConfiguracao({ p_removeMask: true, p_putMask: true });
    }
}

// OffCanva Profille Update Avatar
async function crudOffCanvaProfilleUpdateAvatar() {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Formulário
    const form = document.getElementById('frm_profille_update_avatar');
    const formData = new FormData(form);

    // URL
    const url = 'perfil/update_avatar';

    fetch(url, {
        method: 'POST',
        headers: {
            'REQUEST-ORIGIN': 'fetch',
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json'
        },
        body: formData
    }).then(async response => {
        const data = await response.json();

        if (!response.ok) { throw data; }

        return data;
    }).then(data => {
        if (data.success) {
            // Trocar Avatares''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            const avatares = document.querySelectorAll('.url_user_avatar');
            const urlAvatar = data.avatar_url + '?t=' + new Date().getTime();
            avatares.forEach(img => { img.src = urlAvatar; });
            //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            // Resposta
            alertSwal('success', "Perfil", data.success, 'true', 2000);
        } else if (data.error_validation) {
            const message = montarMensagemValidacao(data.error_validation);

            // Resposta
            alertSwal('warning', "Validação", message, 'true', 3000);
        }
    }).catch(error => {
        alert('Erro crudOffCanvaProfilleUpdateAvatar: ' + error);
    });
}

// OffCanva Profille Update Password
async function crudOffCanvaProfilleUpdatePassword() {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Formulário
    const form = document.getElementById('frm_profille_update_password');
    const formData = new FormData(form);

    // URL
    const url = 'perfil/update_password';

    fetch(url, {
        method: 'POST',
        headers: {
            'REQUEST-ORIGIN': 'fetch',
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json'
        },
        body: formData
    }).then(async response => {
        const data = await response.json();

        if (!response.ok) { throw data; }

        return data;
    }).then(data => {
        if (data.success) {
            // Resposta
            alertSwal('success', "Perfil", data.success, 'true', 2000);
        } else if (data.error_validation) {
            const message = montarMensagemValidacao(data.error_validation);

            // Resposta
            alertSwal('warning', "Validação", message, 'true', 3000);
        } else if (data.error) {
            // Resposta
            alertSwal('warning', "Validação", data.error, 'true', 3000);
        }
    }).catch(error => {
        alert('Erro crudOffCanvaProfilleUpdatePassword: ' + error);
    });
}

// OffCanva Informações Militar
async function crudOffCanvaInformacoesMilitar(militar_id) {
    // Buscar Elementos
    const militarImgFotografia = document.getElementById('militarImgFotografia');
    const informacoes_militar_id = document.getElementById('informacoes_militar_id');
    const militarName = document.getElementById('militarName');
    const militarInformacaoNome = document.getElementById('militarInformacaoNome');
    const militarInformacaoRg = document.getElementById('militarInformacaoRg');
    const militarInformacaoNomeGuerra = document.getElementById('militarInformacaoNomeGuerra');
    const militarInformacaoIdentidadeFuncional = document.getElementById('militarInformacaoIdentidadeFuncional');
    const militarInformacaoDataIngresso = document.getElementById('militarInformacaoDataIngresso');
    const militarInformacaoSituacao = document.getElementById('militarInformacaoSituacao');
    const militarInformacaoPostoGraduacao = document.getElementById('militarInformacaoPostoGraduacao');
    const militarInformacaoQuadro = document.getElementById('militarInformacaoQuadro');
    const militarInformacaoComportamento = document.getElementById('militarInformacaoComportamento');
    const militarInformacaoUnidade = document.getElementById('militarInformacaoUnidade');
    const militarInformacaoPrestandoServico = document.getElementById('militarInformacaoPrestandoServico');

    // Limpar Elementos
    militarImgFotografia.src = 'assets/images/militares/fotografia-0.png';
    informacoes_militar_id.value = 0;
    militarName.innerText = '';
    militarInformacaoNome.innerText = '';
    militarInformacaoRg.innerText = '';
    militarInformacaoNomeGuerra.innerText = '';
    militarInformacaoIdentidadeFuncional.innerText = '';
    militarInformacaoDataIngresso.innerText = '';
    militarInformacaoSituacao.innerText = '';
    militarInformacaoPostoGraduacao.innerText = '';
    militarInformacaoQuadro.innerText = '';
    militarInformacaoComportamento.innerText = '';
    militarInformacaoUnidade.innerText = '';
    militarInformacaoPrestandoServico.innerText = '';

    // Abrir OffCanva Informações Militar
    const offcanvasElement = document.getElementById('offcanvaInformacoesMilitar');
    const offcanvas = new bootstrap.Offcanvas(offcanvasElement);
    offcanvas.show();



    // ****** COLOCAR PERMISSOES PARA O USUARIO VER O PROPRIO PERFIL E PARA O USUARIO VER O PERFIL DE OUTROS MILITARES PELA GRADE DE REGISTROS
    // ****** USANDO : users_perfil_show E users_perfil_edit



    // URL
    const url = `militares/informacoes/geral/${militar_id}`;

    try {
        const response = await fetch(url, {
            method: 'GET',
            headers: { 'REQUEST-ORIGIN': 'fetch' }
        });

        const data = await response.json();

        // Lendo dados
        if (data.success) {
            // Informações do Militar
            const militar = data.success.militar;

            militarImgFotografia.src = militar.fotografia;
            informacoes_militar_id.value = militar.id;
            militarName.innerText = militar.nome;
            militarInformacaoNome.innerText = militar.nome;
            militarInformacaoRg.innerText = militar.rg;
            militarInformacaoNomeGuerra.innerText = militar.nome_guerra;
            militarInformacaoIdentidadeFuncional.innerText = militar.identidade_funcional;
            militarInformacaoDataIngresso.innerText = formatarData(2, militar.data_ingresso);
            militarInformacaoSituacao.innerText = militar.situacaoName;
            militarInformacaoPostoGraduacao.innerText = militar.graduacaoName;
            militarInformacaoQuadro.innerText = militar.quadroName;
            militarInformacaoComportamento.innerText = militar.comportamentoName
            militarInformacaoUnidade.innerText = militar.unidadeName;
            militarInformacaoPrestandoServico.innerText = militar.prestandoServicoName

            // Informações do Militar (Ajudas de Custos)
            const offcanvaInformacoesMilitarAjudasCustos = document.getElementById('offcanvaInformacoesMilitarAjudasCustos');
            const offcanvaInformacoesMilitarAjudasCustosTbody = document.getElementById('offcanvaInformacoesMilitarAjudasCustosTbody');
            const militarAjudasCustos = data.success.militar_ajudas_custos ?? [];

            offcanvaInformacoesMilitarAjudasCustos.style.display = militarAjudasCustos.length ? 'block' : 'none';

            var tbody = '';

            militarAjudasCustos.forEach((registro, index) => {
                const ajudaCustoTipo = registro.ajudaCustoTipoName ?? '';
                const boletim = registro.boletim ?? '';
                const pagamento = registro.pagamento ?? '';
                const referenciaProcessoSei = registro.referencia_processo_sei ?? '';

                tbody += `<tr>
                            <th scope="row">${index + 1}</th>
                            <td>${ajudaCustoTipo}</td>
                            <td>${boletim}</td>
                            <td>${pagamento}</td>
                            <td>${referenciaProcessoSei}</td>
                        </tr>`;
            });

            offcanvaInformacoesMilitarAjudasCustosTbody.innerHTML = tbody;

            // Informações do Militar (Auxílios Fardamentos)
            const offcanvaInformacoesMilitarAuxiliosFardamentos = document.getElementById('offcanvaInformacoesMilitarAuxiliosFardamentos');
            const offcanvaInformacoesMilitarAuxiliosFardamentosTbody = document.getElementById('offcanvaInformacoesMilitarAuxiliosFardamentosTbody');
            const militarAuxiliosFardamentos = data.success.militar_auxilios_fardamentos ?? [];

            offcanvaInformacoesMilitarAuxiliosFardamentos.style.display = militarAuxiliosFardamentos.length ? 'block' : 'none';

            var tbody = '';

            militarAuxiliosFardamentos.forEach((registro, index) => {
                const auxilioFardamentoTipo = registro.auxilioFardamentoTipoName ?? '';
                const boletim = registro.boletim ?? '';
                const pagamento = registro.pagamento ?? '';
                const referenciaProcessoSei = registro.referencia_processo_sei ?? '';

                tbody += `<tr>
                            <th scope="row">${index + 1}</th>
                            <td>${auxilioFardamentoTipo}</td>
                            <td>${boletim}</td>
                            <td>${pagamento}</td>
                            <td>${referenciaProcessoSei}</td>
                        </tr>`;
            });

            offcanvaInformacoesMilitarAuxiliosFardamentosTbody.innerHTML = tbody;

            // Informações do Militar (Cursos)
            const offcanvaInformacoesMilitarCursos = document.getElementById('offcanvaInformacoesMilitarCursos');
            const offcanvaInformacoesMilitarCursosTbody = document.getElementById('offcanvaInformacoesMilitarCursosTbody');
            const militarCursos = data.success.militar_cursos ?? [];

            offcanvaInformacoesMilitarCursos.style.display = militarCursos.length ? 'block' : 'none';

            var tbody = '';

            militarCursos.forEach((registro, index) => {
                const curso = registro.cursoName ?? '';
                const boletim = registro.boletim ?? '';
                const conceito = registro.conceito ?? '';

                tbody += `<tr>
                            <th scope="row">${index + 1}</th>
                            <td>${curso}</td>
                            <td>${boletim}</td>
                            <td>${conceito}</td>
                        </tr>`;
            });

            offcanvaInformacoesMilitarCursosTbody.innerHTML = tbody;

            // Informações do Militar (Dependentes)
            const offcanvaInformacoesMilitarDependentes = document.getElementById('offcanvaInformacoesMilitarDependentes');
            const offcanvaInformacoesMilitarDependentesTbody = document.getElementById('offcanvaInformacoesMilitarDependentesTbody');
            const militarDependentes = data.success.militar_dependentes ?? [];

            offcanvaInformacoesMilitarDependentes.style.display = militarDependentes.length ? 'block' : 'none';

            var tbody = '';

            militarDependentes.forEach((registro, index) => {
                const parentesco = registro.parentescoName ?? '';
                const nome = registro.name ?? '';

                tbody += `<tr>
                            <th scope="row">${index + 1}</th>
                            <td>${parentesco}</td>
                            <td>${nome}</td>
                        </tr>`;
            });

            offcanvaInformacoesMilitarDependentesTbody.innerHTML = tbody;

            // Informações do Militar (Fundos Saúde)
            const offcanvaInformacoesMilitarFundosSaude = document.getElementById('offcanvaInformacoesMilitarFundosSaude');
            const offcanvaInformacoesMilitarFundosSaudeTbody = document.getElementById('offcanvaInformacoesMilitarFundosSaudeTbody');
            const militarFundosSaude = data.success.militar_fundos_saude ?? [];

            offcanvaInformacoesMilitarFundosSaude.style.display = militarFundosSaude.length ? 'block' : 'none';

            var tbody = '';

            militarFundosSaude.forEach((registro, index) => {
                const cancelar_desconto = registro.cancelar_desconto == 1 ? 'SIM' : 'NÃO';
                const acesso_sistema_saude = registro.acesso_sistema_saude == 1 ? 'SIM' : 'NÃO';
                const tipo_acesso = { 1: 'INTEGRAL', 2: 'AMBULATORIAL' }[Number(registro.tipo_acesso)] ?? 'NEGADO';

                tbody += `<tr>
                            <th scope="row">${index + 1}</th>
                            <td>${cancelar_desconto}</td>
                            <td>${acesso_sistema_saude}</td>
                            <td>${tipo_acesso}</td>
                        </tr>`;
            });

            offcanvaInformacoesMilitarFundosSaudeTbody.innerHTML = tbody;
        } else if (data.error) {
            alertSwal('warning', data.error, '', 'true', 3000);
        } else {
            alert('Erro interno');
        }
    } catch (error) {
        alert('Erro crudOffCanvaInformacoesMilitar: ' + error);
    } finally {
        // Garantir restauração de máscaras
        crudConfiguracao({ p_removeMask: true, p_putMask: true });
    }
}

// OffCanva Informações Militar Update Fotografia
async function crudOffCanvaInformacoesMilitarUpdateFotografia() {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Formulário
    const form = document.getElementById('frm_informacoes_militar_update_fotografia');
    const formData = new FormData(form);
    const btnOffCanvaInformacoesMilitarUpdateFotografia = document.getElementById('btnOffCanvaInformacoesMilitarUpdateFotografia');

    // Desabilitando Botão
    btnOffCanvaInformacoesMilitarUpdateFotografia.disabled = true;

    // URL
    const url = 'militares/informacoes/update_fotografia';

    fetch(url, {
        method: 'POST',
        headers: {
            'REQUEST-ORIGIN': 'fetch',
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json'
        },
        body: formData
    }).then(async response => {
        const data = await response.json();

        if (!response.ok) { throw data; }

        return data;
    }).then(data => {
        if (data.success) {
            // Trocar Fotografia''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            const urlFotografia = data.fotografia_url + '?t=' + new Date().getTime();
            const informacoes_militar_id = document.getElementById('informacoes_militar_id').value;

            document.getElementById('militarImgFotografia').src = urlFotografia;
            document.getElementById('militarImgFotografia-'+informacoes_militar_id).src = urlFotografia;
            //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            // Resposta
            alertSwal('success', "Militares", data.success, 'true', 2000);
        } else if (data.error_validation) {
            const message = montarMensagemValidacao(data.error_validation);

            // Resposta
            alertSwal('warning', "Validação", message, 'true', 3000);
        }
    }).catch(error => {
        alert('Erro crudOffCanvaInformacoesMilitarUpdateFotografia: ' + error);
    }).finally(() => {
        // Habilitando Botão
        btnOffCanvaInformacoesMilitarUpdateFotografia.disabled = false;
    });
}
