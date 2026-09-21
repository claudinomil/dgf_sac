function maskPis(v) {
    v = v.replace(/\D/g, '')
         .slice(0, 11);

    return v
        .replace(/(\d{3})(\d)/, '$1.$2')
        .replace(/(\d{5})(\d)/, '$1.$2')
        .replace(/(\d{2})(\d{1})$/, '$1-$2');
}

function maskPasep(v) {
    v = v.replace(/\D/g, '')
         .slice(0, 11);

    return v
        .replace(/(\d{3})(\d)/, '$1.$2')
        .replace(/(\d{5})(\d)/, '$1.$2')
        .replace(/(\d{2})(\d{1})$/, '$1-$2');
}

function maskTituloEleitor(v) {
    v = v.replace(/\D/g, '')
         .slice(0, 12);

    return v
        .replace(/(\d{4})(\d)/, '$1 $2')
        .replace(/(\d{4}) (\d{4})(\d)/, '$1 $2 $3');
}

function maskBoletim(v) {
    v = v.replace(/\D/g, '')
         .slice(0, 11); // 3 números + 8 da data

    if (v.length > 3) {
        v = v.replace(/^(\d{3})(\d)/, '$1-$2');
    }

    if (v.length > 6) {
        v = v.replace(/^(\d{3})-(\d{2})(\d)/, '$1-$2/$3');
    }

    if (v.length > 9) {
        v = v.replace(/^(\d{3})-(\d{2})\/(\d{2})(\d)/, '$1-$2/$3/$4');
    }

    return v;
}

function maskPagamento(v) {
    // Mantém apenas números e limita a 6 dígitos (MMYYYY)
    v = v.replace(/\D/g, '').slice(0, 6);

    // Insere a barra após o mês
    if (v.length > 2) {
        v = v.replace(/^(\d{2})(\d+)/, '$1/$2');
    }

    return v;
}

function maskProcessoSei(v) {
    // Remove tudo que não for número
    v = v.replace(/\D/g, '').slice(0, 16);

    let r = 'SEI-';

    if (v.length <= 6) {
        r += v;
    } else if (v.length <= 12) {
        r += v.substring(0, 6) + '/' + v.substring(6);
    } else {
        r += v.substring(0, 6) + '/' +
             v.substring(6, 12) + '/' +
             v.substring(12);
    }

    return r;
}

function maskRg(v) {
    v = v.replace(/\D/g, '')
         .slice(0, 9); // 2 + 4 + 3 números

    if (v.length > 2) {
        v = v.replace(/^(\d{2})(\d)/, '$1/$2');
    }

    if (v.length > 6) {
        v = v.replace(/^(\d{2})\/(\d{4})(\d)/, '$1/$2.$3');
    }

    return v;
}

function maskCPF(v) {
    v = v.replace(/\D/g, '')
         .slice(0,11);

    return v
        .replace(/(\d{3})(\d)/, '$1.$2')
        .replace(/(\d{3})(\d)/, '$1.$2')
        .replace(/(\d{3})(\d{1,2})$/, '$1-$2');
}

function maskCNPJ(v) {
    v = v.replace(/\D/g, '')
         .slice(0,14);

    return v
        .replace(/^(\d{2})(\d)/, '$1.$2')
        .replace(/^(\d{2})\.(\d{3})(\d)/, '$1.$2.$3')
        .replace(/\.(\d{3})(\d)/, '.$1/$2')
        .replace(/(\d{4})(\d)/, '$1-$2');
}

function maskCEP(v) {
    v = v.replace(/\D/g, '')
         .slice(0,8);

    return v.replace(/(\d{5})(\d)/, '$1-$2');
}

function maskTelefone(v) {
    v = v.replace(/\D/g, '')
         .slice(0,10);

    return v
        .replace(/^(\d{2})(\d)/, '($1) $2')
        .replace(/(\d{4})(\d)/, '$1-$2');
}

function maskCelular(v) {
    v = v.replace(/\D/g, '')
         .slice(0,11);

    return v
        .replace(/^(\d{2})(\d)/, '($1) $2')
        .replace(/(\d{5})(\d)/, '$1-$2');
}

function maskData(v) {
    v = v.replace(/\D/g, '')
         .slice(0,8);

    return v
        .replace(/(\d{2})(\d)/, '$1/$2')
        .replace(/(\d{2})\/(\d{2})(\d)/, '$1/$2/$3');
}

function maskHora(v) {
    v = v.replace(/\D/g, '')
         .slice(0,6);

    return v
        .replace(/(\d{2})(\d)/, '$1:$2')
        .replace(/(\d{2}):(\d{2})(\d)/, '$1:$2:$3');
}

function maskMoney(v) {
    v = v.replace(/\D/g,'');

    let value = (Number(v) / 100).toLocaleString('pt-BR', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    });

    return value;
}

function putMask() {
    document.querySelectorAll(".mask_pis").forEach(el => {
        el.addEventListener("input", () => {
            el.value = maskPis(el.value);
        });

        el.value = maskPis(el.value);
    });

    document.querySelectorAll(".mask_pasep").forEach(el => {
        el.addEventListener("input", () => {
            el.value = maskPasep(el.value);
        });

        el.value = maskPasep(el.value);
    });

    document.querySelectorAll(".mask_titulo_eleitor").forEach(el => {
        el.addEventListener("input", () => {
            el.value = maskTituloEleitor(el.value);
        });

        el.value = maskTituloEleitor(el.value);
    });

    document.querySelectorAll(".mask_boletim").forEach(el => {
        el.addEventListener("input", () => {
            el.value = maskBoletim(el.value);
        });

        el.value = maskBoletim(el.value);
    });

    document.querySelectorAll(".mask_pagamento").forEach(el => {
        el.addEventListener("input", () => {
            el.value = maskPagamento(el.value);
        });

        el.value = maskPagamento(el.value);
    });


    document.querySelectorAll(".mask_processo_sei").forEach(el => {
        el.addEventListener("input", () => {
            el.value = maskProcessoSei(el.value);
        });

        el.value = maskProcessoSei(el.value);
    });

    document.querySelectorAll(".mask_rg").forEach(el => {
        el.addEventListener("input", () => {
            el.value = maskRg(el.value);
        });

        el.value = maskRg(el.value);
    });

    document.querySelectorAll(".mask_cpf").forEach(el => {
        el.addEventListener("input", () => {
            el.value = maskCPF(el.value);
        });

        el.value = maskCPF(el.value);
    });

    document.querySelectorAll(".mask_cnpj").forEach(el => {
        el.addEventListener("input", () => {
            el.value = maskCNPJ(el.value);
        });

        el.value = maskCNPJ(el.value);
    });

    document.querySelectorAll(".mask_cep").forEach(el => {
        el.addEventListener("input", () => {
            el.value = maskCEP(el.value);
        });

        el.value = maskCEP(el.value);
    });

    document.querySelectorAll(".mask_cell_with_ddd").forEach(el => {
        el.addEventListener("input", () => {
            el.value = maskCelular(el.value);
        });

        el.value = maskCelular(el.value);
    });

    document.querySelectorAll(".mask_phone_with_ddd").forEach(el => {
        el.addEventListener("input", () => {
            el.value = maskTelefone(el.value);
        });

        el.value = maskTelefone(el.value);
    });

    document.querySelectorAll(".mask_date").forEach(el => {
        el.addEventListener("input", () => {
            el.value = maskData(el.value);
        });

        el.value = maskData(el.value);
    });

    document.querySelectorAll(".mask_time").forEach(el => {
        el.addEventListener("input", () => {
            el.value = maskHora(el.value);
        });

        el.value = maskHora(el.value);
    });

    document.querySelectorAll(".mask_money").forEach(el => {
        el.addEventListener("input", () => {
            el.value = maskMoney(el.value);
        });

        el.value = maskMoney(el.value);
    });
}

function removeMask() {
    document.querySelectorAll(".mask_pis").forEach(el => {
        el.value = unMask(el.value);
    });

    document.querySelectorAll(".mask_pasep").forEach(el => {
        el.value = unMask(el.value);
    });

    document.querySelectorAll(".mask_titulo_eleitor").forEach(el => {
        el.value = unMask(el.value);
    });

    document.querySelectorAll(".mask_cpf").forEach(el => {
        el.value = unMask(el.value);
    });

    document.querySelectorAll(".mask_cnpj").forEach(el => {
        el.value = unMask(el.value);
    });

    document.querySelectorAll(".mask_cep").forEach(el => {
        el.value = unMask(el.value);
    });

    document.querySelectorAll(".mask_cell_with_ddd").forEach(el => {
        el.value = unMask(el.value);
    });

    document.querySelectorAll(".mask_phone_with_ddd").forEach(el => {
        el.value = unMask(el.value);
    });
}

function unMask(valor) {
    return valor.replace(/\D/g, '');
}

document.addEventListener("DOMContentLoaded", () => {
    putMask();
});
