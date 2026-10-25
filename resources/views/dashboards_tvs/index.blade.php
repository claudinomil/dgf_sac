<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>DGF SAC - Dashboards TV</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="shortcut icon" href="{{ asset('assets/images/image_favicon.png') }}">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @include('layouts.head-css')

        <style>
            html,
            body {
                width: 100%;
                height: 100%;
                margin: 0 !important;
                padding: 0 !important;
                overflow: hidden !important;
            }

            body {
                background-color: #212529;
            }

            #dashboard {
                position: fixed;
                top: 0;
                left: 0;

                width: 100%;
                height: 100vh;
                height: 100dvh;

                margin: 0;
                padding: 8px;
                box-sizing: border-box;

                overflow: hidden;
            }

            #dashboard_conteudo {
                width: 100%;
                height: 100%;
                overflow: hidden;
            }

            #dashboard_teste {
                width: 100%;
                height: 40px;
                background-color: green;
            }
        </style>
    </head>
    <body>
        <div id="dashboard">
            <div id="dashboard_conteudo">
                <div class="d-flex justify-content-end gap-2 mb-2">
                    <button type="button" class="btn header-item noti-icon waves-effect" data-bs-toggle="fullscreen" id="btn_tela_cheia">
                        <i class="bx bx-fullscreen"></i>
                    </button>
                </div>
                <div id="dashboard_teste"></div>
            </div>
        </div>
        
        @include('layouts.vendor-scripts')
        
        <script src="https://cdn.jsdelivr.net/npm/echarts@6/dist/echarts.min.js"></script>
        <script src="{{ asset('assets/js/scripts_dashboards_tvs.js') }}"></script>
    </body>
</html>




@if(1==2)


<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <title>DGF SAC - Dashboards TV</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <link rel="shortcut icon" href="{{ asset('assets/images/image_favicon.png') }}">

        @vite(['resources/css/app.css','resources/js/app.js'])
        @include('layouts.head-css')

        <style>
            html,
            body {
                width: 100%;
                height: 100%;
                margin: 0;
                overflow: hidden;
            }

            #dashboard {
                width: 100%;
                height: 100vh;
            }
        </style>
    </head>
    <body class="p-2 bg-dark" id="dashboard">




        <button type="button" class="btn header-item noti-icon waves-effect" data-bs-toggle="fullscreen">
            <i class="bx bx-fullscreen"></i>
        </button>





        <button
            type="button"
            id="btn_tela_cheia"
            class="btn btn-primary">
            <i class="fa fa-expand"></i>
            Tela cheia
        </button>






        <div class="col-12" style="background-color: green;">&nbsp;</div>

        @include('layouts.vendor-scripts')

        <!-- E-Charts -->
        <script src="https://cdn.jsdelivr.net/npm/echarts@6/dist/echarts.min.js"></script>

        <!-- scripts_dashboards_tvs.js -->
        <script src="{{ asset('assets/js/scripts_dashboards_tvs.js')}}"></script>
    </body>
</html>























<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">

        <meta
            name="viewport"
            content="width=device-width, initial-scale=1.0">

        <meta
            name="robots"
            content="noindex, nofollow">

        <title>Dashboard Gerencial</title>

        {{-- Bootstrap 5 --}}
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
            rel="stylesheet">

        {{-- Chart.js --}}
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <style>
            :root {
                --dashboard-fundo: #171c2b;
                --dashboard-painel: #2a3042;
                --dashboard-destaque: #ED3237;
                --dashboard-texto: #f8f9fa;
                --dashboard-secundario: #aeb7c7;
                --dashboard-borda: rgba(255, 255, 255, 0.09);
            }

            * {
                box-sizing: border-box;
            }

            html,
            body {
                width: 100%;
                min-height: 100%;
                margin: 0;
            }

            body {
                background: var(--dashboard-fundo);
                color: var(--dashboard-texto);
                font-family: Arial, Helvetica, sans-serif;
                overflow-x: hidden;
            }

            .dashboard {
                min-height: 100vh;
                padding: 22px 28px;
                display: flex;
                flex-direction: column;
                gap: 20px;
            }

            .dashboard-header {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 20px;
            }

            .dashboard-titulo {
                margin: 0;
                font-size: clamp(24px, 2.2vw, 38px);
                font-weight: 700;
                letter-spacing: 0.5px;
            }

            .dashboard-subtitulo {
                margin-top: 6px;
                color: var(--dashboard-secundario);
                font-size: clamp(13px, 1vw, 17px);
            }

            .dashboard-status {
                text-align: right;
                color: var(--dashboard-secundario);
                font-size: clamp(12px, 0.9vw, 15px);
            }

            .status-indicador {
                display: inline-block;
                width: 9px;
                height: 9px;
                margin-right: 7px;
                border-radius: 50%;
                background: #20c997;
            }

            .status-indicador.erro {
                background: var(--dashboard-destaque);
            }

            .dashboard-cards {
                display: grid;
                grid-template-columns: repeat(4, minmax(0, 1fr));
                gap: 16px;
            }

            .dashboard-card,
            .dashboard-grafico {
                background: var(--dashboard-painel);
                border: 1px solid var(--dashboard-borda);
                border-radius: 14px;
                min-width: 0;
            }

            .dashboard-card {
                min-height: 150px;
                padding: 22px;
                display: flex;
                flex-direction: column;
                justify-content: center;
                gap: 12px;
            }

            .dashboard-card-titulo {
                color: var(--dashboard-secundario);
                font-size: clamp(14px, 1.1vw, 19px);
            }

            .dashboard-card-valor {
                color: var(--dashboard-texto);
                font-size: clamp(30px, 3vw, 52px);
                line-height: 1.1;
                font-weight: 700;
                overflow-wrap: anywhere;
            }

            .dashboard-card-destaque {
                border-left: 5px solid var(--dashboard-destaque);
            }

            .dashboard-graficos {
                display: grid;
                grid-template-columns: minmax(0, 1.6fr) minmax(0, 1fr);
                gap: 16px;
                flex: 1;
                min-height: 320px;
            }

            .dashboard-grafico {
                padding: 22px;
                display: flex;
                flex-direction: column;
                min-height: 0;
            }

            .dashboard-grafico-titulo {
                margin: 0 0 18px;
                font-size: clamp(17px, 1.4vw, 24px);
                font-weight: 600;
            }

            .dashboard-grafico-area {
                position: relative;
                flex: 1;
                min-height: 240px;
            }

            .dashboard-footer {
                display: flex;
                justify-content: space-between;
                align-items: center;
                gap: 15px;
                color: var(--dashboard-secundario);
                font-size: clamp(11px, 0.85vw, 14px);
            }

            .dashboard-footer button {
                color: var(--dashboard-texto);
                border-color: var(--dashboard-borda);
            }

            .dashboard-footer button:hover {
                background: var(--dashboard-painel);
                color: #fff;
            }

            @media (min-width: 1600px) {
                .dashboard {
                    padding: 30px 38px;
                    gap: 24px;
                }

                .dashboard-card {
                    min-height: 180px;
                    padding: 28px;
                }

                .dashboard-grafico {
                    padding: 28px;
                }
            }

            @media (max-width: 900px) {
                .dashboard {
                    padding: 16px;
                }

                .dashboard-cards {
                    grid-template-columns: repeat(2, minmax(0, 1fr));
                }

                .dashboard-graficos {
                    grid-template-columns: 1fr;
                }

                .dashboard-grafico {
                    min-height: 320px;
                }
            }

            @media (max-width: 480px) {
                .dashboard-header {
                    align-items: flex-start;
                    flex-direction: column;
                }

                .dashboard-status {
                    text-align: left;
                }

                .dashboard-footer {
                    align-items: flex-start;
                    flex-direction: column;
                }
            }
        </style>
    </head>

    <body>
        <main class="dashboard">

            {{-- Cabeçalho --}}
            <header class="dashboard-header">
                <div>
                    <h1 class="dashboard-titulo">
                        DASHBOARD GERENCIAL
                    </h1>

                    <div class="dashboard-subtitulo">
                        Indicadores administrativos
                    </div>
                </div>

                <div class="dashboard-status">
                    <div>
                        <span
                            id="dashboard_status_indicador"
                            class="status-indicador"></span>

                        <span id="dashboard_status">
                            Carregando dados...
                        </span>
                    </div>

                    <div class="mt-2">
                        Atualizado em:
                        <strong id="dashboard_atualizado_em">--</strong>
                    </div>
                </div>
            </header>

            {{-- Indicadores --}}
            <section class="dashboard-cards">

                <article class="dashboard-card dashboard-card-destaque">
                    <div class="dashboard-card-titulo">
                        Total de militares
                    </div>

                    <div
                        id="dashboard_total_militares"
                        class="dashboard-card-valor">
                        --
                    </div>
                </article>

                <article class="dashboard-card">
                    <div class="dashboard-card-titulo">
                        Total de dependentes
                    </div>

                    <div
                        id="dashboard_total_dependentes"
                        class="dashboard-card-valor">
                        --
                    </div>
                </article>

                <article class="dashboard-card">
                    <div class="dashboard-card-titulo">
                        Indicador 3
                    </div>

                    <div class="dashboard-card-valor">
                        --
                    </div>
                </article>

                <article class="dashboard-card">
                    <div class="dashboard-card-titulo">
                        Indicador 4
                    </div>

                    <div class="dashboard-card-valor">
                        --
                    </div>
                </article>

            </section>

            {{-- Gráficos --}}
            <section class="dashboard-graficos">

                <article class="dashboard-grafico">
                    <h2 class="dashboard-grafico-titulo">
                        Militares por comportamento
                    </h2>

                    <div class="dashboard-grafico-area">
                        <canvas id="grafico_militares_barras"></canvas>
                    </div>
                </article>

                <article class="dashboard-grafico">
                    <h2 class="dashboard-grafico-titulo">
                        Distribuição por comportamento
                    </h2>

                    <div class="dashboard-grafico-area">
                        <canvas id="grafico_militares_rosca"></canvas>
                    </div>
                </article>

            </section>

            {{-- Rodapé --}}
            <footer class="dashboard-footer">
                <span>
                    Atualização automática a cada 60 segundos
                </span>

                <button
                    type="button"
                    id="dashboard_atualizar"
                    class="btn btn-sm btn-outline-light">
                    Atualizar agora
                </button>
            </footer>

        </main>

        <script>
            const urlDadosDashboard = @json(route('dashboards_tvs.dados'));

            const intervaloAtualizacao = 60 * 1000;

            const formatadorNumero = new Intl.NumberFormat('pt-BR');

            let graficoBarras = null;
            let graficoRosca = null;
            let atualizando = false;

            /**
             * Atualiza o status visual da conexão.
             */
            function atualizarStatusDashboard(sucesso, mensagem) {
                const indicador = document.getElementById(
                    'dashboard_status_indicador'
                );

                indicador.classList.toggle('erro', !sucesso);

                document.getElementById('dashboard_status').textContent =
                    mensagem;
            }

            /**
             * Atualiza o conteúdo dos indicadores.
             */
            function atualizarIndicadores(indicadores) {
                document.getElementById(
                    'dashboard_total_militares'
                ).textContent = formatadorNumero.format(
                    indicadores.total_militares ?? 0
                );

                document.getElementById(
                    'dashboard_total_dependentes'
                ).textContent = formatadorNumero.format(
                    indicadores.total_dependentes ?? 0
                );
            }

            /**
             * Configuração comum dos gráficos.
             */
            function obterOpcoesGrafico() {
                return {
                    responsive: true,
                    maintainAspectRatio: false,

                    plugins: {
                        legend: {
                            labels: {
                                color: '#f8f9fa',
                                padding: 16,
                                font: {
                                    size: 13
                                }
                            }
                        }
                    }
                };
            }

            /**
             * Cria os gráficos na primeira execução
             * e atualiza seus dados nas próximas.
             */
            function atualizarGraficos(graficos) {
                const distribuicao =
                    graficos.militares_por_comportamento;

                const labels = distribuicao.labels ?? [];
                const dados = distribuicao.dados ?? [];

                if (graficoBarras === null) {
                    graficoBarras = new Chart(
                        document.getElementById(
                            'grafico_militares_barras'
                        ),
                        {
                            type: 'bar',

                            data: {
                                labels: labels,

                                datasets: [{
                                    label: 'Quantidade de militares',
                                    data: dados,
                                    backgroundColor: '#ED3237',
                                    borderRadius: 5
                                }]
                            },

                            options: {
                                ...obterOpcoesGrafico(),

                                scales: {
                                    x: {
                                        ticks: {
                                            color: '#aeb7c7'
                                        },
                                        grid: {
                                            display: false
                                        }
                                    },

                                    y: {
                                        beginAtZero: true,
                                        ticks: {
                                            color: '#aeb7c7',
                                            precision: 0
                                        },
                                        grid: {
                                            color: 'rgba(255,255,255,0.08)'
                                        }
                                    }
                                }
                            }
                        }
                    );
                } else {
                    graficoBarras.data.labels = labels;
                    graficoBarras.data.datasets[0].data = dados;
                    graficoBarras.update();
                }

                if (graficoRosca === null) {
                    graficoRosca = new Chart(
                        document.getElementById(
                            'grafico_militares_rosca'
                        ),
                        {
                            type: 'doughnut',

                            data: {
                                labels: labels,

                                datasets: [{
                                    label: 'Quantidade de militares',
                                    data: dados,

                                    backgroundColor: [
                                        '#ED3237',
                                        '#0d6efd',
                                        '#20c997',
                                        '#ffc107',
                                        '#6f42c1',
                                        '#fd7e14',
                                        '#0dcaf0',
                                        '#adb5bd'
                                    ],

                                    borderColor: '#2a3042',
                                    borderWidth: 3
                                }]
                            },

                            options: {
                                ...obterOpcoesGrafico(),

                                cutout: '62%'
                            }
                        }
                    );
                } else {
                    graficoRosca.data.labels = labels;
                    graficoRosca.data.datasets[0].data = dados;
                    graficoRosca.update();
                }
            }

            /**
             * Consulta os dados sem recarregar a página.
             */
            async function carregarDadosDashboard() {
                if (atualizando) {
                    return;
                }

                atualizando = true;

                try {
                    const resposta = await fetch(urlDadosDashboard, {
                        method: 'GET',

                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        },

                        credentials: 'same-origin',
                        cache: 'no-store'
                    });

                    if (resposta.status === 401 ||
                        resposta.status === 403) {
                        atualizarStatusDashboard(
                            false,
                            'Acesso não autorizado'
                        );

                        return;
                    }

                    if (!resposta.ok) {
                        throw new Error(
                            'Falha HTTP: ' + resposta.status
                        );
                    }

                    const json = await resposta.json();

                    if (json.code !== 200 || !json.content) {
                        throw new Error(
                            'Resposta inválida do dashboard.'
                        );
                    }

                    atualizarIndicadores(json.content.indicadores);

                    atualizarGraficos(json.content.graficos);

                    document.getElementById(
                        'dashboard_atualizado_em'
                    ).textContent = json.content.atualizado_em;

                    atualizarStatusDashboard(
                        true,
                        'Conectado'
                    );

                } catch (erro) {
                    console.error(
                        'Erro ao atualizar dashboard:',
                        erro
                    );

                    atualizarStatusDashboard(
                        false,
                        'Falha ao atualizar'
                    );

                } finally {
                    atualizando = false;
                }
            }

            document.getElementById(
                'dashboard_atualizar'
            ).addEventListener(
                'click',
                carregarDadosDashboard
            );

            // Primeira consulta ao abrir a tela.
            carregarDadosDashboard();

            // Atualiza os dados a cada 60 segundos.
            setInterval(
                carregarDadosDashboard,
                intervaloAtualizacao
            );
        </script>
    </body>
</html>

@endif