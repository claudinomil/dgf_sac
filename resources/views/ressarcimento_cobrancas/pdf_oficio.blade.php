<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <title> {{env('APP_NAME')}} | @yield('page_title')</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="Themesbrand" name="author" />

        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ asset('assets/images/image_favicon.png') }}" id="appFavicon">

        <style>
            @page {margin: 170px 50px 100px 50px;}
            header {position: fixed; top: -150px;    left: 0px; right: 0px; background-color: white; height: 150px;}
            footer {position: fixed; bottom: -100px; left: 0px; right: 0px; background-color: white; height: 100px;}
            p { page-break-after: always;}
            p:last-child { page-break-after: never;}
        </style>
    </head>
    <body>
        <header>
            <table width="100%" style="font-size: 12px;">
                <tr>
                    <th><img src="assets/images/logo_governo_rj.png" alt="" width="18%"></th>
                </tr>
                <tr>
                    <th align="center" style="vertical-align: middle;">
                        <b>
                            Secretaria de Estado de Defesa Civil
                            <br>
                            Corpo de Bombeiros Militar do Estado do Rio de Janeiro
                            <br>
                            Diretoria Geral de Finanças
                        </b>
                    </th>
                </tr>
            </table>
        </header>
        <footer>
            <table width="100%" style="font-size: 10px;">
                <tr>
                    <th align="center" style="vertical-align: middle;"><b>{{$dados['configuracao_diretor_nome'].' - '.$dados['configuracao_diretor_posto'].' '.$dados['configuracao_diretor_quadro']}}</b></th>
                </tr>
                <tr>
                    <th align="center" style="vertical-align: middle;"><b>{{$dados['configuracao_diretor_cargo']}}</b></th>
                </tr>
                <tr>
                    <th align="center" style="vertical-align: middle;"><b>ID Funcional: {{$dados['configuracao_diretor_identidade_funcional']}}</b></th>
                </tr>
            </table>
        </footer>

        <!-- Ofício e Data -->
        <table width="100%" style="font-size: 12px;">
            <tr>
                <th align="left" width="50%" style="vertical-align: middle; height:30px;">{{'Ofício n° Ressarc/DGF/DGF2/'.str_pad($dados['oficio_numero'], 5, '0', STR_PAD_LEFT).'/'.$dados['oficio_ano']}}</th>
                <th align="right" width="50%" style="vertical-align: middle; height:30px;">{{getDataExtenso(date('Y-m-d'))}}.</th>
            </tr>
        </table>

        <!-- Tratamento e Órgão -->
        <table width="100%" style="font-size: 12px;">
            <tr>
                <th align="left" style="vertical-align: middle;">
                    {{$dados['orgao_tratamento_reduzido'].' '.$dados['orgao_vocativo']}}
                    <br>
                    <b>{{$dados['orgao_funcao'].' '.$dados['orgao_name']}}</b>
                </th>
            </tr>
        </table>

        <!-- Endereço e CNPJ/UG -->
        <table width="100%" style="font-size: 12px;">
            <tr>
                <th align="left" style="vertical-align: middle;">
                    {{'End.: '.$dados['orgao_logradouro'].', '.$dados['orgao_numero'].', '.$dados['orgao_complemento'].', '.$dados['orgao_bairro'].', '.$dados['orgao_localidade']}}
                    <br>
                    {{'CEP: '.$dados['orgao_cep']}}
                    <br>
                    {{'Tel.: '.$dados['orgao_telefone_1'].' / '.$dados['orgao_telefone_2']}}
                    <br>
                    CNPJ/UG:
                    @if($dados['orgao_ug'] != '')
                        {{' '.$dados['orgao_ug']}}
                    @else
                        {{' '.$dados['orgao_cnpj']}}
                    @endif
                </th>
            </tr>
        </table>

        <!-- parágrafo -->
        <br>
        <table width="100%" style="font-size: 11px;">
            <tr>
                <th align="justify" style="vertical-align: middle; height:25px;">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$dados['orgao_vocativo']}},
                    <br><br>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Com os cumprimentos de estilo, encaminho a Vossa Excelência a documentação do tipo <b>NOTA DE RESSARCIMENTO</b>, atinente ao mês de {{getReferencia(2, $dados['referencia'])}}, em anexo, correspondente à cobrança de REMUNERAÇÃO, CONTRIBUIÇÕES E DEMAIS ENCARGOS SOCIAIS E PATRONAIS, referente à militar(es) do Corpo de Bombeiros Militar do Estado do Rio de Janeiro (CBMERJ), cedido(s) ou à disposição desse ilustre Órgão, com data de vencimento em {{$dados['configuracao_data_vencimento']}}.
                </th>
            </tr>
        </table>

        <!-- parágrafo -->
        <br>
        <table width="100%" style="font-size: 11px;">
            <tr>
                <th align="justify" style="vertical-align: middle; height:25px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Por oportuno, solicito-a Vossa Excelência o encaminhamento da frequência mensal de todo(s) o(s) bombeiro(s) militar(es) até o quinto dia útil do mês subsequente, à Diretoria Geral de Pessoal (DGP-CBMERJ), para que não ocorram quaisquer transtornos de natureza remuneratória a este(s) servidor(es) e solicito que seja desconsiderada qualquer documentação que tenha sido enviada anteriormente referente a assunto que verse sobre o período mencionado.</th>
            </tr>
        </table>

        <!-- parágrafo -->
        <br>
        <table width="100%" style="font-size: 11px;">
            <tr>
                <th align="justify" style="vertical-align: middle; height:25px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;O Ressarcimento da despesa, objeto do presente, deverá ser realizado até o último dia útil do mês de referência, acessando o site: http://www4.fazenda.rj.gov.br/sisgre-web/paginas/gerarGRE/guiaGREPub.jsf e preenchendo a (UGA) Unidade Gestora Arrecadadora com a UG da "SECRETARIA DO ESTADO DE DEFESA CIVIL", "160100". no campo "Código de recolhimento" com o código "20103-8 - Ressarcimento Pessoal Segurança - Fonte Tesouro" seguindo as orientações do manual para confecção de GRE que foi encaminhado através do ofício (inserir campo) para regularização do ativo junto ao Siafe-Rio.</th>
            </tr>
        </table>

        <!-- parágrafo -->
        <br>
        <table width="100%" style="font-size: 11px;">
            <tr>
                <th align="justify" style="vertical-align: middle; height:25px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Por derradeiro, enfatizo, em observância ao que preceitua o § 4° do artigo 7° do Decreto n° 47, de 27 Dez. 2018 (DOERJ de 28 Dez. 18 - pp. 15), o NÃO ressarcimento por 2(dois) meses consecutivos implicará na suspensão da sessão e imediata apresentação do(s) servidor(es) cedido(s) ao CBMERJ. A não apresentação do servidor ensejará na suspensão de seu pagamento e na abertura do devido procedimento administrativo disciplinar, em conformidade com os termos do § 2° do Art. 4° da Resolução SEPLAG n° 201, de 31 Mar 2009 (DOERJ de 02 Abr. 09 - pp. 13).</th>
            </tr>
        </table>

        <!-- parágrafo -->
        <br>
        <table width="100%" style="font-size: 11px;">
            <tr>
                <th align="justify" style="vertical-align: middle; height:25px;">Respeitosamente,</th>
            </tr>
        </table>
    </body>
</html>
