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
    </head>
    <body>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-md-5">&nbsp;</div>
                <div class="col-12 col-md-2">
                    <input type="text" class="form-control mt-2 text-center" id="cpf">
                </div>
                <div class="col-12 col-md-5">&nbsp;</div>
            </div>
            <div class="col-12 text-center">
                <button class="btn btn-success mt-2" id="btn_chamar">Chamar</button>
            </div>
            <div class="col-12 mt-5" id="divContent">
                <!-- <pre class="bg-light border rounded p-3 mb-0"><code></code></pre> -->
            </div>
        </div>

        <script>
        async function consultarAcessoFundoSaude(cpf) {
            // Credenciais da integração
            const email = 'testeapiacessosistemasaude@xxx.com.br';
            const password = '12345678';

            // Endereço base da API
            const urlBase = '/api/v1';

            try {
                // 1. Autenticar a integração e obter o token
                const respostaAuth = await fetch(`${urlBase}/auth/token`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        email: email,
                        password: password
                    })
                });

                const dadosAuth = await respostaAuth.json();

                if (!respostaAuth.ok || !dadosAuth.success) {
                    throw new Error(
                        dadosAuth.error?.autenticacao ||
                        'Não foi possível autenticar a integração.'
                    );
                }

                const token = dadosAuth.content.access_token;

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
                        body: JSON.stringify({
                            cpf: cpf
                        })
                    }
                );

                const dadosConsulta = await respostaConsulta.json();

                if (!respostaConsulta.ok || !dadosConsulta.success) {
                    console.error('Erro na consulta:', dadosConsulta);
                    throw new Error(
                        dadosConsulta.error?.cpf ||
                        dadosConsulta.message ||
                        'Não foi possível consultar o CPF.'
                    );
                }

                // 3. Retornar o resultado da consulta
                return dadosConsulta;

            } catch (erro) {
                console.error('Erro ao consultar a API:', erro);
                throw erro;
            }
        }

        document.getElementById('btn_chamar').addEventListener('click', function () {
            const cpf = document.getElementById('cpf').value;

            consultarAcessoFundoSaude(cpf)
                .then(resultado => {
                    const divContent = document.getElementById('divContent');

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

                    divContent.replaceChildren(pre);
                })
                .catch(erro => {
                    document.getElementById('divContent').textContent =
                        'Erro: ' + erro.message;
                });
        });
        </script>
    </body>
</html>