function validar_frm_ressarcimento_pagamentos() {
    var validacao_ok = true;
    var mensagem = '';

    //Campo: identidade_funcional (requerido)
    if (validacao({op:1, value:document.getElementById('identidade_funcional').value}) === false) {
        validacao_ok = false;
        mensagem += 'Identidade Funcional é requerido.'+'<br>';
    }

    //Campo: rg (requerido)
    if (validacao({op:1, value:document.getElementById('rg').value}) === false) {
        validacao_ok = false;
        mensagem += 'RG é requerido.'+'<br>';
    }

    //Campo: nome_cargo (requerido)
    if (validacao({op:1, value:document.getElementById('nome_cargo').value}) === false) {
        validacao_ok = false;
        mensagem += 'Nome Cargo é requerido.'+'<br>';
    }

    //Campo: posto_graduacao (requerido)
    if (validacao({op:1, value:document.getElementById('posto_graduacao').value}) === false) {
        validacao_ok = false;
        mensagem += 'Posto/Graduação é requerido.'+'<br>';
    }

    //Campo: nome (requerido)
    if (validacao({op:1, value:document.getElementById('nome').value}) === false) {
        validacao_ok = false;
        mensagem += 'Nome é requerido.'+'<br>';
    }

    //Campo: ua (requerido)
    if (validacao({op:1, value:document.getElementById('ua').value}) === false) {
        validacao_ok = false;
        mensagem += 'UA é requerido.'+'<br>';
    }

    //Campo: cpf (requerido)
    if (validacao({op:1, value:document.getElementById('cpf').value}) === false) {
        validacao_ok = false;
        mensagem += 'CPF é requerido.'+'<br>';
    }

    //Campo: bruto (requerido)
    if (validacao({op:1, value:document.getElementById('bruto').value}) === false) {
        validacao_ok = false;
        mensagem += 'Bruto é requerido.'+'<br>';
    }

    //Campo: desconto (requerido)
    if (validacao({op:1, value:document.getElementById('desconto').value}) === false) {
        validacao_ok = false;
        mensagem += 'Desconto é requerido.'+'<br>';
    }

    //Campo: liquido (requerido)
    if (validacao({op:1, value:document.getElementById('liquido').value}) === false) {
        validacao_ok = false;
        mensagem += 'Líquido é requerido.'+'<br>';
    }

    //Campo: soldo (requerido)
    if (validacao({op:1, value:document.getElementById('soldo').value}) === false) {
        validacao_ok = false;
        mensagem += 'Soldo é requerido.'+'<br>';
    }

    //Campo: hospital10 (requerido)
    if (validacao({op:1, value:document.getElementById('hospital10').value}) === false) {
        validacao_ok = false;
        mensagem += 'Hospital 10 é requerido.'+'<br>';
    }

    //Campo: rioprevidencia22 (requerido)
    if (validacao({op:1, value:document.getElementById('rioprevidencia22').value}) === false) {
        validacao_ok = false;
        mensagem += 'Rioprevidência 22 é requerido.'+'<br>';
    }

    //Campo: etapa_ferias (requerido)
    if (validacao({op:1, value:document.getElementById('etapa_ferias').value}) === false) {
        validacao_ok = false;
        mensagem += 'Etapa Férias é requerido.'+'<br>';
    }

    //Campo: etapa_destacado (requerido)
    if (validacao({op:1, value:document.getElementById('etapa_destacado').value}) === false) {
        validacao_ok = false;
        mensagem += 'Etapa Destacado é requerido.'+'<br>';
    }

    //Campo: ajuda_fardamento (requerido)
    if (validacao({op:1, value:document.getElementById('ajuda_fardamento').value}) === false) {
        validacao_ok = false;
        mensagem += 'Ajuda Fardamento é requerido.'+'<br>';
    }

    //Campo: habilitacao_profissional (requerido)
    if (validacao({op:1, value:document.getElementById('habilitacao_profissional').value}) === false) {
        validacao_ok = false;
        mensagem += 'Habilitação Profissional é requerido.'+'<br>';
    }

    //Campo: gret (requerido)
    if (validacao({op:1, value:document.getElementById('gret').value}) === false) {
        validacao_ok = false;
        mensagem += 'GRET é requerido.'+'<br>';
    }

    //Campo: ferias (requerido)
    if (validacao({op:1, value:document.getElementById('ferias').value}) === false) {
        validacao_ok = false;
        mensagem += 'Férias é requerido.'+'<br>';
    }

    //Campo: raio_x (requerido)
    if (validacao({op:1, value:document.getElementById('raio_x').value}) === false) {
        validacao_ok = false;
        mensagem += 'Raio X é requerido.'+'<br>';
    }

    //Campo: trienio (requerido)
    if (validacao({op:1, value:document.getElementById('trienio').value}) === false) {
        validacao_ok = false;
        mensagem += 'Triênio é requerido.'+'<br>';
    }

    //Campo: fundo_saude (requerido)
    if (validacao({op:1, value:document.getElementById('fundo_saude').value}) === false) {
        validacao_ok = false;
        mensagem += 'Fundo Saúde é requerido.'+'<br>';
    }

    //Campo: abono_permanencia (requerido)
    if (validacao({op:1, value:document.getElementById('abono_permanencia').value}) === false) {
        validacao_ok = false;
        mensagem += 'Abono Permanência é requerido.'+'<br>';
    }

    //Campo: auxilio_transporte (requerido)
    if (validacao({op:1, value:document.getElementById('auxilio_transporte').value}) === false) {
        validacao_ok = false;
        mensagem += 'Auxílio Transporte é requerido.'+'<br>';
    }

    //Campo: gram (requerido)
    if (validacao({op:1, value:document.getElementById('gram').value}) === false) {
        validacao_ok = false;
        mensagem += 'GRAM é requerido.'+'<br>';
    }

    //Campo: auxilio_fardamento (requerido)
    if (validacao({op:1, value:document.getElementById('auxilio_fardamento').value}) === false) {
        validacao_ok = false;
        mensagem += 'Auxílio Fardamento é requerido.'+'<br>';
    }

    //Campo: cidade (requerido)
    if (validacao({op:1, value:document.getElementById('cidade').value}) === false) {
        validacao_ok = false;
        mensagem += 'Cidade é requerido.'+'<br>';
    }

    // Mensagem
    if (validacao_ok === false) {
        var texto = '<div class="pt-3">';
        texto += '<div class="col-12 text-start font-size-12">'+mensagem+'</div>';
        texto += '</div>';

        alertSwal('warning', 'Validação', texto, 'true', 5000);
    }

    // Retorno
    return validacao_ok;
}

function validar_frm_importar_ressarcimento_pagamentos() {
    var validacao_ok = true;
    var mensagem = '';

    //Campo: ressarcimento_pagamento_referencia (requerido)
    if (validacao({op:1, value:document.getElementById('ressarcimento_pagamento_referencia').value}) === false) {
        validacao_ok = false;
        mensagem += 'Referência requerido.'+'<br>';
    }

    //Campo: ressarcimento_pagamento_file (requerido)
    if (validacao({op:1, value:document.getElementById('ressarcimento_pagamento_file').value}) === false) {
        validacao_ok = false;
        mensagem += 'Arquivo requerido.'+'<br>';
    }

    //Mensagem
    if (validacao_ok === false) {
        var texto = '<div class="pt-3">';
        texto += '<div class="col-12 text-start font-size-12">'+mensagem+'</div>';
        texto += '</div>';

        alertSwal('warning', 'Validação', texto, 'true', 5000);
    }

    //Retorno
    return validacao_ok;
}
// Funções Settings Submodulo - Início'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
// Funções Settings Submodulo - Início'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
async function settingsSubmoduloCrudCreate() { }
async function settingsSubmoduloCrudView() { }
async function settingsSubmoduloCrudEdit() { }
async function settingsSubmoduloCrudDelete() { }
async function settingsSubmoduloCrudConfirmCreate() { }
async function settingsSubmoduloCrudConfirmEdit() { }
// Funções Settings Submodulo - Fim''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
// Funções Settings Submodulo - Fim''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

document.addEventListener("DOMContentLoaded", function () {
    // URL
    let url = window.location.protocol + "//" + window.location.host + "/";
    if (window.location.hostname.indexOf("cbmerj.rj.gov") !== -1) { url += "dgf_sistema/"; }

    // Botão Modal Importar Pagamentos
    const btnModalImportarPagamentos = document.getElementById("btnModalImportarPagamentos");

    if (btnModalImportarPagamentos) {
        btnModalImportarPagamentos.addEventListener("click", function () {
            // Limpar validações
            document.querySelectorAll(".is-invalid").forEach(el => {
                el.classList.remove("is-invalid");
            });

            // Limpar formulário
            const form = document.getElementById("frm_importar_ressarcimento_pagamentos");
            if (form) form.reset();

            // Habilitar campos
            document.querySelectorAll("input, select, .select2").forEach(el => {
                el.disabled = false;
            });

            // Abrir modal Bootstrap
            const modalElement = document.querySelector(".modal-importar-pagamentos");
            if (modalElement) {
                const modal = new bootstrap.Modal(modalElement);
                modal.show();
            }
        });
    }

    // Botão Confirmar Importação
    const btnConfirmarImportacaoPagamentos = document.getElementById("btnConfirmarImportacaoPagamentos");

    if (btnConfirmarImportacaoPagamentos) {
        btnConfirmarImportacaoPagamentos.addEventListener("click", function (e) {
            e.preventDefault();

            if (validar_frm_importar_ressarcimento_pagamentos() === true) {
                document.getElementById("frm_importar_ressarcimento_pagamentos").requestSubmit();
            }
        });
    }

    // Submit Form
    const formImportacao = document.getElementById("frm_importar_ressarcimento_pagamentos");

    if (formImportacao) {
        formImportacao.addEventListener("submit", function (e) {
            e.preventDefault();

            const formData = new FormData(this);

            fetch(url + "ressarcimento_pagamentos/dados/importar", {
                method: "POST",
                body: formData
            })
                .then(response => response.json())
                .then(response => {
                    if (response.success) {
                        let registros_importados = `<div class="col-12 text-success">Registros Importados: ${response.success.registros_importados}</div>`;

                        // Importados anteriormente
                        let registros_importados_anteriormente = "";
                        let registros_importados_anteriormente_qtd = 0;

                        response.success.registros_importados_anteriormente.forEach(item => {
                            registros_importados_anteriormente += `<div class="col-12 font-size-10">${item}</div>`;
                            registros_importados_anteriormente_qtd++;
                        });

                        if (registros_importados_anteriormente !== "") {
                            registros_importados_anteriormente = `<div class="col-12 text-primary">Registros Importados anteriormente: ${registros_importados_anteriormente_qtd}</div>` + registros_importados_anteriormente;
                        }

                        // Registros com erro
                        let registros_erros = "";
                        let registros_erros_qtd = 0;

                        response.success.registros_erros.forEach(item => {
                            registros_erros += `<div class="col-12 font-size-10">${item}</div>`;
                            registros_erros_qtd++;
                        });

                        if (registros_erros !== "") {
                            registros_erros = `<div class="col-12 text-danger">Registros com Erro: ${registros_erros_qtd}</div>` + registros_erros;
                        }

                        // Planilha erro
                        let planilha_error = "";
                        let planilha_error_qtd = 0;

                        response.success.planilha_error.forEach(item => {
                            planilha_error += `<div class="col-12 font-size-10">${item}</div>`;
                            planilha_error_qtd++;
                        });

                        if (planilha_error !== "") {
                            planilha_error = `<div class="col-12 text-danger">Planilha com Erro: ${planilha_error_qtd}</div>` + planilha_error;
                        }

                        // Referência militares
                        let referencia_militares_existe = "";
                        let referencia_militares_existe_qtd = 0;

                        if (response.success.referencia_militares_existe === false) {
                            referencia_militares_existe += `<div class="col-12 font-size-10">Não existe Militares para essa Referência.</div>`;
                            referencia_militares_existe_qtd++;
                        }

                        if (referencia_militares_existe !== "") {
                            referencia_militares_existe = `<div class="col-12 text-warning">Referência com Erro: ${referencia_militares_existe_qtd}</div>` + referencia_militares_existe;
                        }

                        alertSwal("success", "Ressarcimento Pagamento - Importação", registros_importados + registros_importados_anteriormente + registros_erros + planilha_error + referencia_militares_existe, "true", 50000);
                    }

                    if (response.error) {
                        alert(response.error);

                        document.getElementById("modal-importar-pagamentos-footer-1").style.display = "block";
                        document.getElementById("modal-importar-pagamentos-footer-2").style.display = "none";
                    }
                })
                .catch(error => {
                alert(error);
                })
                .finally(() => {
                    document.getElementById("modal-importar-pagamentos-footer-1").style.display = "block";
                    document.getElementById("modal-importar-pagamentos-footer-2").style.display = "none";
                });

            // Antes de enviar
            document.getElementById("modal-importar-pagamentos-footer-1").style.display = "none";
            document.getElementById("modal-importar-pagamentos-footer-2").style.display = "block";
        });
    }

    // valores_principais
    document.querySelectorAll(".valores_principais").forEach(el => {
        el.addEventListener("keyup", function () {
            let bruto = moeda2float(document.getElementById("bruto").value);
            let fundo_saude = moeda2float(document.getElementById("fundo_saude").value);
            let auxilio_transporte = moeda2float(document.getElementById("auxilio_transporte").value);
            let rioprevidencia22 = moeda2float(document.getElementById("rioprevidencia22").value);
            let etapa_ferias = moeda2float(document.getElementById("etapa_ferias").value);
            let etapa_destacado = moeda2float(document.getElementById("etapa_destacado").value);
            let abono_permanencia = moeda2float(document.getElementById("abono_permanencia").value);

            let fonte10 = etapa_ferias + etapa_destacado;

            bruto = bruto - fonte10;

            let folha_suplementar = 0;

            let valor_total = bruto + fundo_saude + rioprevidencia22 + fonte10 + folha_suplementar;

            document.getElementById("bruto").value = float2moeda(bruto);
            document.getElementById("valores_principais_total").value = float2moeda(valor_total);
        });
    });

});
