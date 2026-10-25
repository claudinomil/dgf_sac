<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <title>DGF SAC - @yield('title')</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <link rel="shortcut icon" href="{{ asset('assets/images/image_favicon.png') }}">

        @vite(['resources/css/app.css','resources/js/app.js'])
        @include('layouts.head-css')
        
        <script src="{{ asset('assets/js/functions.js')}}"></script>
    </head>
    <body>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-md-3">&nbsp;</div>
                <div class="col-12 col-md-2">
                    <input type="text" class="form-control mt-2 text-center" id="usuario" placeholder="Digite seu Usuário..." value="teste">
                </div>
                <div class="col-12 col-md-2">
                    <input type="password" class="form-control mt-2 text-center" id="password" placeholder="Digite sua Senha..." value="12345678">
                </div>
                <div class="col-12 col-md-2">
                    <input type="text" class="form-control mt-2 text-center" id="cpf" placeholder="Digite o CPF para pesquisa..." value="01798241714">
                </div>
                <div class="col-12 col-md-3">&nbsp;</div>
            </div>
            <div class="col-12 text-center">
                <button class="btn btn-success mt-2" id="btn_chamar">Chamar</button>
                <button class="btn btn-primary mt-2" id="btn_controle">Controle</button>
            </div>
            <div class="row">
                <div class="col-12 col-md-6 mt-5" id="divContentJson">&nbsp;</div>
                <div class="col-12 col-md-6 mt-5">
                    <pre style="white-space: pre; font-family: monospace; font-size: 14px; padding: 15px; background-color: rgb(248, 249, 250); border: 1px solid rgb(222, 226, 230); border-radius: 5px; overflow-x: auto;">
                        <table class="table mb-0">
                            <thead class="table-light font-size-11">
                                <tr>
                                    <th>#</th>
                                    <th>Usuário</th>
                                    <th>Militar</th>
                                    <th>Data / Hora</th>
                                </tr>
                            </thead>
                            <tbody class="font-size-11" id="table_controle_tbody"></tbody>
                        </table>
                    </pre>
                </div>
            </div>
        </div>

        <script>
        async function consultarAcessoFundoSaude(cpf) {
            const usuario = document.getElementById('usuario').value;
            const password = document.getElementById('password').value;

            // Define o prefixo da API conforme o ambiente
            const urlBase = window.location.hostname.includes('cbmerj.rj.gov') ? '/dgf_sistema/api/v1' : '/api/v1';

            try {
                // 1. Autenticar a integração
                const respostaAuth = await fetch(`${urlBase}/auth/token`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        usuario,
                        password
                    })
                });

                const dadosAuth = await respostaAuth.json();

                // Retorna o JSON quando houver erro de autenticação ou autorização
                if (!respostaAuth.ok || !dadosAuth.success) {
                    return dadosAuth;
                }

                const token = dadosAuth.content?.access_token;

                if (!token) {
                    return {
                        success: false,
                        message: 'Token de acesso não retornado pela API.',
                        error: {
                            code: respostaAuth.status,
                            message: 'Não foi possível obter o token de acesso.'
                        },
                        content: null
                    };
                }

                // 2. Consultar o CPF utilizando o token
                const respostaConsulta = await fetch(
                    `${urlBase}/acesso_sistema_saude/consultar`,
                    {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'Authorization': `Bearer ${token}`
                        },
                        body: JSON.stringify({ cpf })
                    }
                );

                const dadosConsulta = await respostaConsulta.json();

                // Retorna o JSON inclusive quando o titular não for encontrado
                if (!respostaConsulta.ok || !dadosConsulta.success) {
                    return dadosConsulta;
                }

                // 3. Retornar o resultado da consulta
                return dadosConsulta;

            } catch (erro) {
                console.error('Erro de comunicação com a API:', erro);

                return {
                    success: false,
                    message: 'Não foi possível comunicar com a API.',
                    error: {
                        code: 0,
                        message: erro.message
                    },
                    content: null
                };
            } finally {
                retornar_controle();
            }
        }

        document.getElementById('btn_chamar').addEventListener('click', function () {
            const cpf = document.getElementById('cpf').value;

            consultarAcessoFundoSaude(cpf)
                .then(resultado => {
                    const divContentJson = document.getElementById('divContentJson');

                    const pre = document.createElement('pre');

                    pre.style.whiteSpace = 'pre';
                    pre.style.fontFamily = 'monospace';
                    pre.style.fontSize = '14px';
                    pre.style.padding = '15px';
                    pre.style.backgroundColor = '#f8f9fa';
                    pre.style.border = '1px solid #dee2e6';
                    pre.style.borderRadius = '5px';
                    pre.style.overflowX = 'auto';

                    pre.textContent = JSON.stringify(resultado, null, 4);

                    divContentJson.replaceChildren(pre);
                })
                .catch(erro => {
                    document.getElementById('divContentJson').textContent =
                        'Erro: ' + erro.message;
                });
        });
        
        document.getElementById('btn_controle').addEventListener('click', async function () {
            retornar_controle();
        });

        async function retornar_controle() {
            try {
                const response = await fetch(`api_acesso_sistema_saude_teste/retornar_controle`, {
                    method: 'GET',
                    headers: { 'REQUEST-ORIGIN': 'fetch' }
                });

                const data = await response.json();

                // Lendo dados
                if (data.success) {
                    var tbody = '';

                    const registros = data.success;

                    registros.forEach((registro, index) => {
                        const militar = registro.militarGraduacaoName+' '+registro.militarName;
                        const usuarioName = registro.usuarioName ?? '';
                        const data = registro.data ?? '';
                        const hora = registro.hora ?? '';
                        const militarCpf = formatarDocumento(1, registro.militarCpf);

                        tbody += `<tr>
                                    <th scope="row">${index + 1}</th>
                                    <td>${usuarioName}</td>
                                    <td>${militar}<br>${militarCpf}</td>
                                    <td>${data} ${hora}</td>
                                </tr>`;
                    });
                    
                    if (tbody === '') {
                        tbody = `<tr><td colspan="4">Nenhuma informação encontrada.</td></tr>`;
                    }

                    document.getElementById('table_controle_tbody').innerHTML = tbody;
                }
            } catch (error) {
                alert('Erro btn_controle: ' + error);
            }
        }
        </script>
    </body>
</html>
