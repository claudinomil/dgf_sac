<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <title> {{env('APP_NAME')}} | @yield('page_title')</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="Themesbrand" name="author" />

        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ asset('build/assets/images/image_favicon.png') }}" id="appFavicon">

        <style>
            @page {margin: 100px 50px 100px 50px;}
            header {position: fixed; top: -60px;    left: 0px; right: 0px; background-color: white; height: 60px;}
            footer {position: fixed; bottom: -100px; left: 0px; right: 0px; background-color: white; height: 100px;}
            p { page-break-after: always;}
            p:last-child { page-break-after: never;}
        </style>
    </head>
    <body>
        <header>
            <table width="100%">
                <tr>
                    <th width="55%">&nbsp;</th>
                    <th width="45%">
                        <table width="100%" style="border: 1px solid #79829c; border-collapse: collapse;">
                            <tr>
                                <th align="center" style="vertical-align: middle; font-size: 11px;"><b>CORPO DE BOMBEIROS MILITAR DO E.R.J.</b></th>
                            </tr>
                            <tr>
                                <th align="center" style="vertical-align: middle; font-size: 8px;"><b>Endereço: Praça da República, 45, Centro, Rio de Janeiro - RJ</b></th>
                            </tr>
                            <tr>
                                <th align="center" style="vertical-align: middle; font-size: 8px;"><b>E-mail: dgf2@cbmerj.rj.gov.br</b></th>
                            </tr>
                            <tr>
                                <th align="center" style="vertical-align: middle; font-size: 8px;"><b>CNPJ: 28.176.998/0004-41</b></th>
                            </tr>
                        </table>
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

        <!-- Órgão -->
        <table width="100%" style="font-size: 12px;">
            <tr>
                <th align="left" style="vertical-align: middle; height:30px;"><b>{{$dados['orgao_name']}}</b></th>
            </tr>
        </table>

        <!-- Nota de Ressarcimento -->
        <table width="100%" style="font-size: 16px;">
            <tr>
                <th align="center" style="vertical-align: middle; height:40px;"><b>Nota de Ressarcimento</b></th>
            </tr>
        </table>

        <!-- Ofício referência / Mês referência / Vencimento -->
        <table width="100%" style="border: 1px solid #79829c; border-collapse: collapse; font-size: 10px;">
            <thead>
                <tr style="background-color: #3a425a; color: white;">
                    <th align="center" width="33%" style="border: 1px solid #79829c; border-collapse: collapse; height:20px; vertical-align: middle;"><b>Ofício de Referência</b></th>
                    <th align="center" width="34%" style="border: 1px solid #79829c; border-collapse: collapse; height:20px; vertical-align: middle;"><b>Mês de Referência</b></th>
                    <th align="center" width="33%" style="border: 1px solid #79829c; border-collapse: collapse; height:20px; vertical-align: middle;"><b>Vencimento</b></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th align="center" style="border: 1px solid #79829c; border-collapse: collapse; height:20px;">&nbsp;{{$dados['oficio_numero'].'/'.$dados['oficio_ano']}}</th>
                    <th align="center" style="border: 1px solid #79829c; border-collapse: collapse; height:20px;">&nbsp;{{getReferencia(2, $dados['referencia'])}}</th>
                    <th align="center" style="border: 1px solid #79829c; border-collapse: collapse; height:20px;">&nbsp;{{$dados['configuracao_data_vencimento']}}</th>
                </tr>
            </tbody>
        </table>

        <!-- parágrafo -->
        <br>
        <table width="100%" style="font-size: 11px;">
            <tr>
                <th align="justify" style="vertical-align: middle; height:25px;"><b>REMUNERAÇÃO E ENCARGOS SOCIAIS</b> referentes à {{$dados['total_militares']}} militar(es) do Corpo de Bombeiros Militar do Estado do Rio de Janeiro, cedido a esse Órgão Externo.</th>
            </tr>
        </table>

        <!-- Tabela de Valores -->
        <br>
        <table width="100%" style="border: 1px solid #79829c; border-collapse: collapse; font-size: 10px;">
            <thead>
                <tr style="background-color: #3a425a; color: white;">
                    <th align="center" style="border: 1px solid #79829c; border-collapse: collapse; height:25px; vertical-align: middle;"><b>ITEM</b></th>
                    <th align="center" colspan="2" style="border: 1px solid #79829c; border-collapse: collapse; height:25px; vertical-align: middle;"><b>HISTÓRICO</b></th>
                    <th align="center" style="border: 1px solid #79829c; border-collapse: collapse; height:25px; vertical-align: middle;"><b>VALOR</b></th>
                </tr>
            </thead>
            <tbody>
            <tr>
                <th align="center" style="border: 1px solid #79829c; border-collapse: collapse; height:20px;">01.</th>
                <th align="center" rowspan="3" style="border: 1px solid #79829c; border-collapse: collapse; height:20px;"><b>VENCIMENTOS BRUTOS</b></th>
                <th align="left" style="border: 1px solid #79829c; border-collapse: collapse; height:20px;">&nbsp;RECURSOS ORIUNDOS DA FONTE 100</th>
                <th align="right" style="border: 1px solid #79829c; border-collapse: collapse; height:20px;">{{number_format($dados['valor_recursos_oriundos_fonte100'], '2', ',', '.')}}&nbsp;</th>
            </tr>
            <tr>
                <th align="center" style="border: 1px solid #79829c; border-collapse: collapse; height:20px;">02.</th>
                <th align="left" style="border: 1px solid #79829c; border-collapse: collapse; height:20px;">&nbsp;RECURSOS ORIUNDOS DA FONTE 232</th>
                <th align="right" style="border: 1px solid #79829c; border-collapse: collapse; height:20px;">{{number_format($dados['valor_recursos_oriundos_fonte232'], '2', ',', '.')}}&nbsp;</th>
            </tr>
            <tr>
                <th align="center" style="border: 1px solid #79829c; border-collapse: collapse; height:20px;">03.</th>
                <th align="left" style="border: 1px solid #79829c; border-collapse: collapse; height:20px;">&nbsp;BRUTO (FOLHA SUPLEMENTAR)</th>
                <th align="right" style="border: 1px solid #79829c; border-collapse: collapse; height:20px;">{{number_format($dados['valor_bruto_folha_suplementar'], '2', ',', '.')}}&nbsp;</th>
            </tr>
            <tr>
                <th align="center" style="border: 1px solid #79829c; border-collapse: collapse; height:20px;">04.</th>
                <th align="center" rowspan="2" style="border: 1px solid #79829c; border-collapse: collapse; height:20px;"><b>ENCARGOS SOCIAIS E PATRONAIS</b></th>
                <th align="left" style="border: 1px solid #79829c; border-collapse: collapse; height:20px;">&nbsp;RIOPREVIDÊNCIA (28% PATRONAL)</th>
                <th align="right" style="border: 1px solid #79829c; border-collapse: collapse; height:20px;">{{number_format($dados['valor_rioprevidencia'], '2', ',', '.')}}&nbsp;</th>
            </tr>
            <tr>
                <th align="center" style="border: 1px solid #79829c; border-collapse: collapse; height:20px;">05.</th>
                <th align="left" style="border: 1px solid #79829c; border-collapse: collapse; height:20px;">&nbsp;FUNDO DE SAÚDE (10% PATRONAL)</th>
                <th align="right" style="border: 1px solid #79829c; border-collapse: collapse; height:20px;">{{number_format($dados['valor_fundo_saude'], '2', ',', '.')}}&nbsp;</th>
            </tr>
            <tr>
                <th align="right" colspan="3" style="border: 1px solid #79829c; border-collapse: collapse; height:20px;"><b>TOTAL GERAL -></b></th>
                <th align="right" style="border: 1px solid #79829c; border-collapse: collapse; height:20px;">{{number_format($dados['valor_total'], '2', ',', '.')}}&nbsp;</th>
            </tr>
            </tbody>
        </table>

        <!-- Total da Nota -->
        <br>
        <table width="100%" style="border: 1px solid #79829c; border-collapse: collapse;">
            <tr>
                <th align="center" width="15%" style="border: 1px solid #79829c; border-collapse: collapse; height:30px; font-size: 11px;"><b>Total da Nota -></b></th>
                <th align="center" width="20%" style="border: 1px solid #79829c; border-collapse: collapse; height:30px; font-size: 14px;"><b>R$ {{number_format($dados['valor_total'], '2', ',', '.')}}</b></th>
                <th align="left" width="65%" style="border: 1px solid #79829c; border-collapse: collapse; height:30px; font-size: 11px;">&nbsp;{{getValorExtenso($dados['valor_total'])}}</th>
            </tr>
        </table>

        <!-- parágrafo -->
        <br>
        <table width="100%" style="font-size: 11px;">
            <tr>
                <th align="justify" style="vertical-align: middle;"><b>(1)</b> O ressarcimento em tela deverá ser realizado até o último dia útil do mês de referência, acessando o site: http://www4.fazenda.rj.gov.br/sisgre-web/paginas/gerarGRE/guiaGREPub.jsf e preenchendo a <b>(UGA) Unidade Gestora Arrecadadora</b> com a UG da "SECRETARIA DE ESTADO DE DEFESA CIVIL", <b>"160100"</b>. No campo "Código de recolhimento" com o código <b>"20103-8 - Ressarcimento Pessoal Segurança - Fonte Tesouro"</b> seguindo as orientações do manual para confecção de GRE que foi encaminhado através do ofício (inserir campo) para regularização do ativo junto ao SiafeRio.</th>
            </tr>
        </table>

        <!-- parágrafo -->
        <br>
        <table width="100%" style="font-size: 11px;">
            <tr>
                <th align="justify" style="vertical-align: middle;"><b>(2)</b> Na eventual possibilidade de o(s) militar(es) acima mencionado(s), não pertencer(em) a esse órgão, <b>FAVOR</b> encaminhar a presente Nota de Ressarcimento, por retorno, a esta DGF, pelo endereço supracitado no quadro, para que possamos cancelá-lo;</th>
            </tr>
        </table>

        <!-- parágrafo -->
        <br>
        <table width="100%" style="font-size: 11px;">
            <tr>
                <th align="justify" style="vertical-align: middle;"><b>(3)</b> A cópia do comprovante de depósito deverá ser encaminhada a esta DGF, para os devidos lançamentos contábeis no SIAFEM;</th>
            </tr>
        </table>

        <!-- parágrafo -->
        <br>
        <table width="100%" style="font-size: 11px;">
            <tr>
                <th align="justify" style="vertical-align: middle;"><b>(4)</b> Por fim, enfatizo ainda que, em observância ao que preceitua o § 4° do artigo 7° do Decreto n° 47, de 27 Dez. 2018 (DOERJ de 28 Dez. 18 - pp. 15), o NÃO ressarcimento por 02(dois) meses consecutivos implicará no imediato retorno do militar ao CBMERJ; assim como, na possível suspensão dos respectivos vencimentos, conforme preconiza a Resolução SEPLAG n° 201, de 31 Mar 2009 (DOERJ de 02 Abr. 09 - pp. 13).</th>
            </tr>
        </table>

        <!-- data -->
        <br><br><br>
        <table width="100%" style="font-size: 11px;">
            <tr>
                <th align="right" style="vertical-align: middle;">{{getDataExtenso(date('Y-m-d'))}}.</th>
            </tr>
        </table>
    </body>
</html>
