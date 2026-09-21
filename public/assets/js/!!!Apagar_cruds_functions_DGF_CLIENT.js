//Configuração
function crudConfiguracao({p_frm_operacao=null, p_fieldsDisabled=null, p_crudFormButtons1=null, p_crudFormButtons2=null, p_crudTable=null, p_crudForm=null, p_crudFormAjaxLoading=null, p_removeMask=null, p_putMask=null}) {
    //Campo hidden frm_operacao
    if (p_frm_operacao !== null) {
        document.getElementById('frm_operacao').value = p_frm_operacao;
    }

    //Campos do Formulário - disabled true/false
    if (p_fieldsDisabled !== null) {
        //Seleciona todos os inputs
        var elementos = document.querySelectorAll('input');
        elementos.forEach(function(elemento) {
            elemento.disabled = p_fieldsDisabled;
        });

        //Seleciona todos os textareas
        var elementos = document.querySelectorAll('textarea');
        elementos.forEach(function(elemento) {
            elemento.disabled = p_fieldsDisabled;
        });

        //Seleciona todos os selects
        var elementos = document.querySelectorAll('select');
        elementos.forEach(function(elemento) {
            elemento.disabled = p_fieldsDisabled;
        });

        //Seleciona todos os select2s
        var elementos = document.querySelectorAll('.select2');
        elementos.forEach(function(elemento) {
            elemento.disabled = p_fieldsDisabled;
        });

        //Campos do Formulário - disabled true/false (Campos Padrões)
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

    //Botões do Modal
    if (p_crudFormButtons1 == 'show') {
        document.getElementById('crudFormButtons1').style.display = 'block';

        //Verificando botões inferiores no formulário (só alguns submódulos tem esses botões inferiores)'''
        let divBotInf = document.getElementById('crudFormButtons1_inferior');
        if (divBotInf) {document.getElementById('crudFormButtons1_inferior').style.display = 'block';}
        //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    }

    if (p_crudFormButtons1 == 'hide') {
        document.getElementById('crudFormButtons1').style.display = 'none';

        //Verificando botões inferiores no formulário (só alguns submódulos tem esses botões inferiores)'''
        let divBotInf = document.getElementById('crudFormButtons1_inferior');
        if (divBotInf) {document.getElementById('crudFormButtons1_inferior').style.display = 'none';}
        //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    }

    if (p_crudFormButtons2 == 'show') {
        document.getElementById('crudFormButtons2').style.display = 'block';

        //Verificando botões inferiores no formulário (só alguns submódulos tem esses botões inferiores)'''
        let divBotInf = document.getElementById('crudFormButtons2_inferior');
        if (divBotInf) {document.getElementById('crudFormButtons2_inferior').style.display = 'block';}
        //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    }

    if (p_crudFormButtons2 == 'hide') {
        document.getElementById('crudFormButtons2').style.display = 'none';

        //Verificando botões inferiores no formulário (só alguns submódulos tem esses botões inferiores)'''
        let divBotInf = document.getElementById('crudFormButtons2_inferior');
        if (divBotInf) {document.getElementById('crudFormButtons2_inferior').style.display = 'none';}
        //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    }

    //Table Show/Hide
    if (p_crudTable == 'show') {
        //Seleciona crudTable
        document.getElementById('crudTable').style.display = 'block';
    }

    if (p_crudTable == 'hide') {
        //Seleciona crudTable
        document.getElementById('crudTable').style.display = 'none';
    }

    //Form Show/Hide
    if (p_crudForm == 'show') {
        //Seleciona crudForm
        document.getElementById('crudForm').style.display = 'block';
    }

    if (p_crudForm == 'hide') {
        //Seleciona crudForm
        document.getElementById('crudForm').style.display = 'none';
    }

    //DIV Loading Show/Hide
    if (p_crudFormAjaxLoading == 'show') {
        //Seleciona crudFormAjaxLoading
        document.getElementById('crudFormAjaxLoading').style.display = 'block';
    }

    if (p_crudFormAjaxLoading == 'hide') {
        //Seleciona crudFormAjaxLoading
        document.getElementById('crudFormAjaxLoading').style.display = 'none';
    }

    //Removendo Máscaras
    if (p_removeMask === true) {removeMask();}

    //Restaurando Máscaras
    if (p_putMask === true) {putMask();}
}

//Preencher Formulario
function crudPreencherFormulario(campo, dados) {
    if (campo == 'id') {
        document.getElementById('registro_id').value = dados['id'];
    } else {
        var elemento = document.getElementById(campo);
        if (elemento) {
            if (elemento.classList.contains('select2')) {
                //Incluindo valor no Select e alterando no Select2
                var select2 = document.getElementById(campo);
                select2.value = dados[campo];
                var event = new Event('change', { bubbles: true });
                select2.dispatchEvent(event);
            } else {
                document.getElementById(campo).value = dados[campo];
            }
        }
    }
}

//Limpar Formulario
function crudLimparFormulario(nomeFormulario) {
    //Seleciona todos os elementos que possuem a classe 'is-invalid'
    var elementos = document.querySelectorAll('.is-invalid');
    elementos.forEach(function(elemento) {
        elemento.classList.remove('is-invalid');
    });

    //Limpando Select2
    var elementos = document.querySelectorAll('.select2');
    elementos.forEach(function(elemento) {
        elemento.value = '';
        var event = new Event('change', { bubbles: true });
        elemento.dispatchEvent(event);
    });

    //Limpar Formulário
    var formulario = document.getElementById(nomeFormulario);
    var elementos = formulario.elements;

    for (var i = 0; i < elementos.length; i++) {
        var elemento = elementos[i];

        switch (elemento.type) {
            case "text":
            case "textarea":
            case "select-one":
                elemento.value = '';
                break;
            case "checkbox":
            case "radio":
                elemento.checked = false;
                break;
        }
    }
}

//Montartabela
function crudTable(route, fieldsColumns='', pageLength=5) {
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
        columns: fieldsColumns
    });

    //Configuração
    crudConfiguracao({p_fieldsDisabled:false});
}

//Create
function crudCreate() {
    //URL
    var url = window.location.protocol+'//'+window.location.host+'/';
    if (window.location.hostname.indexOf('cbmerj.rj.gov') != -1) {url += 'dgf_sistema/';}

    //Variáveis
    let prefixPermissaoSubmodulo = document.getElementById('crudPrefixPermissaoSubmodulo').value;
    let nameSubmodulo = document.getElementById('crudNameSubmodulo').value;
    let nameFormSubmodulo = document.getElementById('crudNameFormSubmodulo').value;

    //Acessar rota
    fetch(prefixPermissaoSubmodulo+'/create', {
        method: 'GET',
        headers: {'REQUEST-ORIGIN': 'fetch'}
    }).then(response => {
        return response.json();
    }).then(data => {
        //Lendo dados
        if (data.success) {
            //Limpar Formulario
            crudLimparFormulario(nameFormSubmodulo);

            //Configuração
            crudConfiguracao({p_frm_operacao:'create', p_fieldsDisabled:false, p_crudFormButtons1:'show', p_crudFormButtons2:'hide', p_crudTable:'hide', p_crudForm:'show', p_removeMask:true, p_putMask:true});

            //Settings Submódulos'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            if (prefixPermissaoSubmodulo == 'notificacoes') {
                elementos = document.getElementsByClassName('fieldsViewEdit');
                elementos.forEach(function(elemento) {elemento.style.display = 'none';});

                elementos = document.getElementsByClassName('fieldsCreate');
                elementos.forEach(function(elemento) {elemento.style.display = 'block';});
            }

            if (prefixPermissaoSubmodulo == 'grupos') {
                elementos = document.getElementsByClassName('markUnmarkAll');
                elementos.forEach(function(elemento) {elemento.style.display = 'block';});

                //Desabilitar/Habilitar opções de Show
                elementos = document.getElementsByClassName('tdShow');
                elementos.forEach(function(elemento) {elemento.style.display = 'none';});

                //Desabilitar/Habilitar opções de Create/Edit
                elementos = document.getElementsByClassName('tdCreateEdit');
                elementos.forEach(function(elemento) {elemento.style.display = 'block';});

                //Dashboards - desmarcar checkbox
                var elementos = document.querySelectorAll('.grupo_dashboards');
                elementos.forEach(function(elemento) {
                    elemento.checked = false;
                });

                //Relatorios - desmarcar checkbox
                var elementos = document.querySelectorAll('.grupo_relatorios');
                elementos.forEach(function(elemento) {
                    elemento.checked = false;
                });
            }

            if (prefixPermissaoSubmodulo == 'users') {
                //voltar configurações de campos apos passar pelo edit
                document.getElementById('email').readOnly = false;
            }
            //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        } else if (data.error_permissao) {
            alertSwal('warning', "Permissão Negada", '', 'true', 2000);
        } else {
            alert('Erro interno');
        }
    }).catch(error => {
        alert('ErroFunctions:'+error);
    });
}

//View
function crudView(registro_id) {
    //URL
    var url = window.location.protocol+'//'+window.location.host+'/';
    if (window.location.hostname.indexOf('cbmerj.rj.gov') != -1) {url += 'dgf_sistema/';}

    //Campo hidden registro_id
    document.getElementById('registro_id').value = registro_id;

    //Variáveis
    let prefixPermissaoSubmodulo = document.getElementById('crudPrefixPermissaoSubmodulo').value;
    let nameSubmodulo = document.getElementById('crudNameSubmodulo').value;
    let nameFormSubmodulo = document.getElementById('crudNameFormSubmodulo').value;

    //Buscar dados do Registro
    //Acessar rota
    fetch(prefixPermissaoSubmodulo+'/'+registro_id, {
        method: 'GET',
        headers: {'REQUEST-ORIGIN': 'fetch'}
    }).then(response => {
        return response.json();
    }).then(data => {
        //Lendo dados
        if (data.success) {
            //Limpar Formulario
            crudLimparFormulario(nameFormSubmodulo);

            //Configuração
            crudConfiguracao({p_frm_operacao:'view', p_fieldsDisabled:true, p_crudFormButtons1:'hide', p_crudFormButtons2:'show', p_crudTable:'hide', p_crudForm:'show', p_removeMask:true, p_putMask:true});

            //preencher formulário
            let input = document.getElementById('crudFieldsFormSubmodulo').value;
            let crudFieldsFormSubmodulo = input.split(',');
            crudFieldsFormSubmodulo.forEach(function (field) {
                crudPreencherFormulario(field, data.success);
            });

            //Settings Submódulos'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            if (prefixPermissaoSubmodulo == 'notificacoes') {
                elementos = document.getElementsByClassName('fieldsViewEdit');
                elementos.forEach(function(elemento) {elemento.style.display = 'block';});

                elementos = document.getElementsByClassName('fieldsCreate');
                elementos.forEach(function(elemento) {elemento.style.display = 'none';});

                //fieldDate / fieldTime / fieldUserName
                document.getElementById('fieldDate').value = data.success['date'];
                document.getElementById('fieldTime').value = data.success['time'];
                document.getElementById('fieldUserName').value = data.success['userName'];

                //Marcar notificação como lida
                fetch('notificacoes/readingNotificacoes/' + registro_id, {
                    method: 'GET',
                    headers: {'REQUEST-ORIGIN': 'fetch'}
                });
            }

            if (prefixPermissaoSubmodulo == 'grupos') {
                elementos = document.getElementsByClassName('markUnmarkAll');
                elementos.forEach(function(elemento) {elemento.style.display = 'block';});

                //Desabilitar/Habilitar opções de Show
                elementos = document.getElementsByClassName('tdShow');
                elementos.forEach(function(elemento) {elemento.style.display = 'none';});

                //Desabilitar/Habilitar opções de Create/Edit
                elementos = document.getElementsByClassName('tdCreateEdit');
                elementos.forEach(function(elemento) {elemento.style.display = 'block';});

                for (const chave in data.success) {
                    var elementos = document.querySelectorAll('.create_edit_' + chave);
                    elementos.forEach(function(elemento) {
                        elemento.checked = true;
                    });
                }

                //Dashboards
                //desmarcar checkbox
                var elementos = document.querySelectorAll('.grupo_dashboards');
                elementos.forEach(function(elemento) {
                    elemento.checked = false;
                });

                //marcar checkbox
                var dashboards = data.success['dashboards'];
                dashboards.forEach(function(item) {
                    document.getElementById('dashboard_' + item['dashboard_id']).checked = true;
                });

                //Relatorios
                //desmarcar checkbox
                var elementos = document.querySelectorAll('.grupo_relatorios');
                elementos.forEach(function(elemento) {
                    elemento.checked = false;
                });

                //marcar checkbox
                var relatorios = data.success['relatorios'];
                relatorios.forEach(function(item) {
                    document.getElementById('relatorio_' + item['relatorio_id']).checked = true;
                });
            }

            if (prefixPermissaoSubmodulo == 'ressarcimento_militares') {
                var referencia = document.getElementById('referencia').value;
                document.getElementById('referencia').value = getReferencia(1, referencia);
            }

            if (prefixPermissaoSubmodulo == 'ressarcimento_configuracoes') {
                var referencia = document.getElementById('referencia').value;
                document.getElementById('referencia_extenso').value = getReferencia(1, referencia);
            }

            if (prefixPermissaoSubmodulo == 'ressarcimento_referencias') {
                var referencia = document.getElementById('referencia').value;
                document.getElementById('referencia_extenso').value = getReferencia(1, referencia);
            }
            //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            //Configuração
            crudConfiguracao({p_removeMask:true, p_putMask:true});
        } else if (data.error_not_found) {
            //Configuração
            crudConfiguracao({p_removeMask:true, p_putMask:true});

            alertSwal('warning', "Registro não encontrado", '', 'true', 2000);
        } else if (data.error_permissao) {
            //Configuração
            crudConfiguracao({p_removeMask:true, p_putMask:true});

            alertSwal('warning', "Permissão Negada", '', 'true', 2000);
        } else {
            //Configuração
            crudConfiguracao({p_removeMask:true, p_putMask:true});

            alert('Erro interno');
        }
    }).catch(error => {
        alert('Erro Crud Functions View:'+error);
    });
}

//Edit
function crudEdit(registro_id) {
    //URL
    var url = window.location.protocol+'//'+window.location.host+'/';
    if (window.location.hostname.indexOf('cbmerj.rj.gov') != -1) {url += 'dgf_sistema/';}

    //Variáveis
    if (registro_id == 0) {registro_id = document.getElementById('registro_id').value;}
    let prefixPermissaoSubmodulo = document.getElementById('crudPrefixPermissaoSubmodulo').value;
    let nameSubmodulo = document.getElementById('crudNameSubmodulo').value;
    let nameFormSubmodulo = document.getElementById('crudNameFormSubmodulo').value;

    //Buscar dados do Registro
    fetch(prefixPermissaoSubmodulo+'/'+registro_id+'/edit', {
        method: 'GET',
        headers: {'REQUEST-ORIGIN': 'fetch'}
    }).then(response => {
        return response.json();
    }).then(data => {
        //Lendo dados
        if (data.success) {
            //Limpar Formulario
            crudLimparFormulario(nameFormSubmodulo);

            //Configuração
            crudConfiguracao({p_frm_operacao:'edit', p_fieldsDisabled:false, p_crudFormButtons1:'show', p_crudFormButtons2:'hide', p_crudTable:'hide', p_crudForm:'show', p_removeMask:true, p_putMask:true});

            //preencher formulário
            let input = document.getElementById('crudFieldsFormSubmodulo').value;
            let crudFieldsFormSubmodulo = input.split(',');
            crudFieldsFormSubmodulo.forEach(function (field) {
                crudPreencherFormulario(field, data.success);
            });

            //Settings Submódulos'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            if (prefixPermissaoSubmodulo == 'notificacoes') {
                elementos = document.getElementsByClassName('fieldsViewEdit');
                elementos.forEach(function(elemento) {elemento.style.display = 'block';});

                elementos = document.getElementsByClassName('fieldsCreate');
                elementos.forEach(function(elemento) {elemento.style.display = 'none';});

                //fieldDate / fieldTime / fieldUserName
                document.getElementById('fieldDate').value = data.success['date'];
                document.getElementById('fieldTime').value = data.success['time'];
                document.getElementById('fieldUserName').value = data.success['userName'];
            }

            if (prefixPermissaoSubmodulo == 'grupos') {
                elementos = document.getElementsByClassName('markUnmarkAll');
                elementos.forEach(function(elemento) {elemento.style.display = 'block';});

                //Desabilitar/Habilitar opções de Show
                elementos = document.getElementsByClassName('tdShow');
                elementos.forEach(function(elemento) {elemento.style.display = 'none';});

                //Desabilitar/Habilitar opções de Create/Edit
                elementos = document.getElementsByClassName('tdCreateEdit');
                elementos.forEach(function(elemento) {elemento.style.display = 'block';});

                for (const chave in data.success) {
                    var elementos = document.querySelectorAll('.create_edit_' + chave);
                    elementos.forEach(function(elemento) {
                        elemento.checked = true;
                    });
                }

                //Dashboards
                //desmarcar checkbox
                var elementos = document.querySelectorAll('.grupo_dashboards');
                elementos.forEach(function(elemento) {
                    elemento.checked = false;
                });

                //marcar checkbox
                var dashboards = data.success['dashboards'];
                dashboards.forEach(function(item) {
                    document.getElementById('dashboard_' + item['dashboard_id']).checked = true;
                });

                //Relatorios
                //desmarcar checkbox
                var elementos = document.querySelectorAll('.grupo_relatorios');
                elementos.forEach(function(elemento) {
                    elemento.checked = false;
                });

                //marcar checkbox
                var relatorios = data.success['relatorios'];
                relatorios.forEach(function(item) {
                    document.getElementById('relatorio_' + item['relatorio_id']).checked = true;
                });
            }

            if (prefixPermissaoSubmodulo == 'users') {
                //Não deixar alterar E-mail pelo submódulo Users
                document.getElementById('email').readOnly = true;
            }

            if (prefixPermissaoSubmodulo == 'ressarcimento_militares') {
                var referencia = document.getElementById('referencia').value;
                document.getElementById('referencia').value = getReferencia(1, referencia);
            }

            if (prefixPermissaoSubmodulo == 'ressarcimento_configuracoes') {
                var referencia = document.getElementById('referencia').value;
                document.getElementById('referencia_extenso').value = getReferencia(1, referencia);
            }

            if (prefixPermissaoSubmodulo == 'ressarcimento_referencias') {
                var referencia = document.getElementById('referencia').value;
                document.getElementById('referencia_extenso').value = getReferencia(1, referencia);
            }
            //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            //Configuração
            crudConfiguracao({p_removeMask:true, p_putMask:true});
        } else if (data.error_not_found) {
            //Configuração
            crudConfiguracao({p_removeMask:true, p_putMask:true});

            alertSwal('warning', "Registro não encontrado", '', 'true', 2000);
        } else if (data.error_permissao) {
            //Configuração
            crudConfiguracao({p_removeMask:true, p_putMask:true});

            alertSwal('warning', "Permissão Negada", '', 'true', 2000);
        } else {
            //Configuração
            crudConfiguracao({p_removeMask:true, p_putMask:true});

            alert('Erro interno');
        }
    }).catch(error => {
        alert('Erro Crud Functions Edit:'+error);
    });
}

//Delete
function crudDelete(registro_id) {
    //URL
    var url = window.location.protocol+'//'+window.location.host+'/';
    if (window.location.hostname.indexOf('cbmerj.rj.gov') != -1) {url += 'dgf_sistema/';}

    //Variáveis
    if (registro_id == 0) {registro_id = document.getElementById('registro_id').value;}
    let prefixPermissaoSubmodulo = document.getElementById('crudPrefixPermissaoSubmodulo').value;
    let nameSubmodulo = document.getElementById('crudNameSubmodulo').value;
    let nameFormSubmodulo = document.getElementById('crudNameFormSubmodulo').value;

    //Confirmação de Delete
    alertSwalConfirmacao(function (confirmed) {
        if (confirmed) {
            //Configuração - Retirar DIV Botões e colocar DIV Loading
            crudConfiguracao({p_crudFormButtons1:'hide', p_crudFormAjaxLoading:'show'});

            //Acessar rota
            fetch(prefixPermissaoSubmodulo+'/'+registro_id, {
                method: 'DELETE',
                headers: {
                    'REQUEST-ORIGIN': 'fetch',
                    'X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            }).then(response => {
                return response.json();
            }).then(data => {
                //Lendo dados
                if (data.success) {
                    alertSwal('success', nameSubmodulo, data.success, 'true', 2000);

                    //Configuração
                    crudConfiguracao({p_crudTable:'show', p_crudForm:'hide'});

                    //Table
                    crudTable(prefixPermissaoSubmodulo);
                } else if (data.error) {
                    alertSwal('error', nameSubmodulo, data.error, 'true', 2000);

                    //Configuração
                    crudConfiguracao({p_crudTable:'show', p_crudForm:'hide'});

                    //Table
                    crudTable(prefixPermissaoSubmodulo);
                } else if (data.error_permissao) {
                    alertSwal('warning', "Permissão Negada", '', 'true', 2000);
                } else {
                    alert('Erro interno');
                }
            }).catch(error => {
                //Configuração
                crudConfiguracao({p_removeMask:true, p_putMask:true});

                alert('Erro Crud Functions Delete:'+error);
            });

            //Configuração - Retirar DIV Loading e colocar DIV Botões
            crudConfiguracao({p_crudFormButtons1:'show', p_crudFormAjaxLoading:'hide'});
        }
    });
}

//Confirm Operacao
function crudConfirmOperation() {
    //URL
    var url = window.location.protocol+'//'+window.location.host+'/';
    if (window.location.hostname.indexOf('cbmerj.rj.gov') != -1) {url += 'dgf_sistema/';}

    //Variáveis
    let registro_id = document.getElementById('registro_id').value;
    let prefixPermissaoSubmodulo = document.getElementById('crudPrefixPermissaoSubmodulo').value;
    let nameSubmodulo = document.getElementById('crudNameSubmodulo').value;
    let nameFormSubmodulo = document.getElementById('crudNameFormSubmodulo').value;

    //Verificar Validação feita com sucesso
    if (window['validar_'+nameFormSubmodulo]() === true) {
        var executar = 1;

        //Validação CNPJ e UG'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        if (prefixPermissaoSubmodulo == 'ressarcimento_orgaos') {
            var cnpj = document.getElementById('cnpj').value;
            var ug = document.getElementById('ug').value;

            if (cnpj == '' && ug == '') {
                alertSwal('warning', 'Validação', 'Digite CNPJ e/ou UG ', 'true', 20000);
                executar = 0;
                return false;
            }
        }
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        if (executar == 1) {
            //Configuração
            crudConfiguracao({p_removeMask:true});

            //Confirm Operacao - Create
            if (document.getElementById('frm_operacao').value == 'create') {
                //FormData
                var formulario = document.getElementById(nameFormSubmodulo);
                var formData = new FormData(formulario);

                //Configuração - Retirar DIV Botões e colocar DIV Loading
                crudConfiguracao({p_crudFormButtons1:'hide', p_crudFormAjaxLoading:'show'});

                //Acessar rota
                fetch(prefixPermissaoSubmodulo, {
                    method: 'POST',
                    headers: {
                        'REQUEST-ORIGIN': 'fetch',
                        'X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: formData
                }).then(response => {
                    return response.json();
                }).then(data => {
                    //Lendo dados
                    if (data.success) {
                        //Enviar E-mail'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
                        if (prefixPermissaoSubmodulo == 'users') {
                            var email = document.getElementById('email').value;
                            var senha = data.content;
                            var senha = senha.substring(4, 14);

                            //Acessar rota
                            fetch('enviar_email/users/primeiro_acesso/' + email + '/' + senha, {
                                method: 'GET',
                                headers: {'REQUEST-ORIGIN': 'fetch'}
                            });
                        }
                        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

                        alertSwal('success', nameSubmodulo, data.success, 'true', 2000);

                        //Limpar Formulario
                        crudLimparFormulario(nameFormSubmodulo);

                        //Configuração
                        crudConfiguracao({p_crudTable:'show', p_crudForm:'hide'});

                        //Table
                        crudTable(prefixPermissaoSubmodulo);
                    } else if (data.error_validation) {
                        //Configuração
                        crudConfiguracao({p_removeMask:true, p_putMask:true});

                        //Montar mensage de erro de Validação
                        message = '<div class="pt-3">';
                        var validations = data.error_validation;
                        for (const chave in validations) {
                            message += '<div class="col-12 text-start font-size-12"><b>></b> ' + validations[chave] + '</div>';
                        }
                        message += '</div>';

                        alertSwal('warning', "Validação", message, 'true', 20000);
                    } else if (data.error_permissao) {
                        //Configuração
                        crudConfiguracao({p_removeMask:true, p_putMask:true});

                        alertSwal('warning', "Permissão Negada", '', 'true', 2000);
                    } else if (data.error) {
                        alertSwal('warning', nameSubmodulo, data.error, 'true', 20000);
                    } else {
                        //Configuração
                        crudConfiguracao({p_removeMask:true, p_putMask:true});

                        alert('Erro interno');
                    }
                }).catch(error => {
                    //Configuração
                    crudConfiguracao({p_removeMask:true, p_putMask:true});

                    alert('Erro Crud Functions Confirm Operation Create: '+error);
                });

                //Configuração - Retirar DIV Loading e colocar DIV Botões
                crudConfiguracao({p_crudFormButtons1:'show', p_crudFormAjaxLoading:'hide'});
            }

            //Confirm Operacao - Edit
            if (document.getElementById('frm_operacao').value == 'edit') {
                //FormData
                var formulario = document.getElementById(nameFormSubmodulo);
                var formData = new FormData(formulario);

                //Configuração - Retirar DIV Botões e colocar DIV Loading
                crudConfiguracao({p_crudFormButtons1:'hide', p_crudFormAjaxLoading:'show'});

                //Acessar rota
                fetch(prefixPermissaoSubmodulo+'/'+registro_id, {
                    method: 'POST',
                    headers: {
                        'REQUEST-ORIGIN': 'fetch',
                        'X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: formData
                }).then(response => {
                    return response.json();
                }).then(data => {
                    //Lendo dados
                    if (data.success) {
                        alertSwal('success', nameSubmodulo, data.success, 'true', 2000);

                        //Limpar Formulario
                        crudLimparFormulario(nameFormSubmodulo);

                        //Configuração
                        crudConfiguracao({p_crudTable:'show', p_crudForm:'hide'});

                        //Table
                        crudTable(prefixPermissaoSubmodulo);
                    } else if (data.error_validation) {
                        //Configuração
                        crudConfiguracao({p_removeMask:true, p_putMask:true});

                        //Montar mensage de erro de Validação
                        message = '<div class="pt-3">';
                        var validations = data.error_validation;
                        for (const chave in validations) {
                            message += '<div class="col-12 text-start font-size-12"><b>></b> ' + validations[chave] + '</div>';
                        }
                        message += '</div>';

                        alertSwal('warning', "Validação", message, 'true', 20000);
                    } else if (data.error_not_found) {
                        //Configuração
                        crudConfiguracao({p_removeMask:true, p_putMask:true});

                        alertSwal('warning', "Registro não encontrado", '', 'true', 2000);
                    } else if (data.error_permissao) {
                        //Configuração
                        crudConfiguracao({p_removeMask:true, p_putMask:true});

                        alertSwal('warning', "Permissão Negada", '', 'true', 2000);
                    } else if (data.error) {
                        alertSwal('warning', nameSubmodulo, data.error, 'true', 20000);
                    } else {
                        //Configuração
                        crudConfiguracao({p_removeMask:true, p_putMask:true});

                        alert('Erro interno');
                    }
                }).catch(error => {
                    //Configuração
                    crudConfiguracao({p_removeMask:true, p_putMask:true});

                    alert('Erro Crud Functions Confirm Operation Edit:'+error);
                });

                //Configuração - Retirar DIV Loading e colocar DIV Botões
                crudConfiguracao({p_crudFormButtons1:'show', p_crudFormAjaxLoading:'hide'});
            }
        }
    }
}

//Cancel Operacao
function crudCancelOperation() {
    //Configuração
    crudConfiguracao({p_fieldsDisabled:false, p_crudTable:'show', p_crudForm:'hide'});
}

//Filter New
function crudFilterInsertLine() {
    //Seleciona a div original
    var divOriginal = document.getElementsByClassName('filterRepeaterItem')[0];

    //Clona a div sem os valores dos inputs
    var divClonada = divOriginal.cloneNode(true);

    //Limpa os valores dos inputs clonados
    var inputsClonados = divClonada.getElementsByTagName("input");
    for (var i = 0; i < inputsClonados.length; i++) {inputsClonados[i].value = "";}

    //Adiciona a div clonada abaixo da original
    document.getElementById("filterRepeaterList").appendChild(divClonada);

    //Ajustar Itens
    crudFilterAdjustItems();
}

//Remover Item
function crudFilterRemoveLine(dataId='') {
    //Pegando todas as Divs
    var divs = document.querySelectorAll('.filterRepeaterItem');

    //Verificando se só tem um item e não deixar remover
    if (divs.length == 1) {
        alert('Não é possivel remover.');
    } else {
        //Varrendo as Divs para remover a solicitada
        divs.forEach(function (div) {
            if (div.dataset.id === dataId) {
                div.remove();
            }
        });

        //Ajustar Itens
        crudFilterAdjustItems();
    }
}

//Filter Ajustar itens
function crudFilterAdjustItems() {
    //Colocar data-id nos itens
    var ind = 0;
    document.querySelectorAll('.filterRepeaterItem').forEach(function(elemento) {
        elemento.dataset.id = ind;
        ind++;
    });

    //Colocar a função para remover linhas nos botões
    var ind = 0;
    document.querySelectorAll('#filter_crud_botao_excluir').forEach(function(elemento) {
        elemento.value = ind;

        //Colocando função no elemento
        elemento.onclick = function () {
            crudFilterRemoveLine(elemento.value);
        };

        ind++;
    });
}

//Executar Filtros
function crudFilterExecutar(submodulo='') {
    //Variáveis
    if (submodulo == '') {submodulo = document.getElementById('crudPrefixPermissaoSubmodulo').value;}

    //Pegar quantidade de Itens/Filtros
    var qtdItens = document.querySelectorAll('.filterRepeaterItem').length;

    //Arrays
    const array_dados = [];

    //Varrer filtros para montar array de dados
    for(i=0; i<qtdItens; i++) {
        var tipo_condicao = document.getElementsByName('filter_crud_tipo_condicao')[i];
        var campo_pesquisar = document.getElementsByName('filter_crud_campo_pesquisar')[i];
        var operacao_realizar = document.getElementsByName('filter_crud_operacao_realizar')[i];
        var dado_pesquisar = document.getElementsByName('filter_crud_dado_pesquisar')[i];

        if (dado_pesquisar.value == '') {
            alert('Digite algo para pesquisar no filtro ' + (i + 1));

            return false;
        }

        //Populando array_dados
        array_dados.push(tipo_condicao.value);
        array_dados.push(campo_pesquisar.value);
        array_dados.push(operacao_realizar.value);
        array_dados.push(dado_pesquisar.value);
    }

    //Table
    crudTable(submodulo+'/filter/'+array_dados);
}
