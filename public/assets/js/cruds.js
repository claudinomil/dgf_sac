document.addEventListener("DOMContentLoaded", () => {
    const el = document.getElementById('crudPrefixPermissaoSubmodulo');
    if (!el) return;

    const prefix = el.value;
    const excecoes = ['dashboards', 'relatorios', 'logotipos', 'ressarcimento_cobrancas'];

    if (prefix && !excecoes.includes(prefix)) {
        crudTable(prefix);
    }
});
