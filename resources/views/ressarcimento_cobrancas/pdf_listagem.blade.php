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
            <table width="100%" style="font-size: 10px;">
                <tr>
                    <th align="center" style="vertical-align: middle;"><b>SECRETARIA DE ESTADO DA DEFESA CIVIL - SEDEC</b></th>
                </tr>
                <tr>
                    <th align="center" style="vertical-align: middle;"><b>CORPO DE BOMBEIROS MILITAR DO ESTADO DO RIO DE JANEIRO - CBMERJ</b></th>
                </tr>
                <tr>
                    <th align="center" style="vertical-align: middle;"><b>DIRETORIA GERAL DE FINANÇAS - DGF</b></th>
                </tr>
            </table>
        </header>
        <footer>
            <table width="100%" style="font-size: 10px;">
{{--                @foreach($dados as $dado)--}}
                    <tr>
                        <th align="center" style="vertical-align: middle;"><b>{{$listagem['configuracao_dgf2_nome'].' - '.$listagem['configuracao_dgf2_posto'].' '.$listagem['configuracao_dgf2_quadro']}}</b></th>
                    </tr>
                    <tr>
                        <th align="center" style="vertical-align: middle;"><b>{{$listagem['configuracao_dgf2_cargo']}}</b></th>
                    </tr>

{{--                    @break--}}
{{--                @endforeach--}}
            </table>
        </footer>

        <table width="100%" style="border: 1px solid #79829c; border-collapse: collapse; font-size: 8px;">
            <thead>
                <tr style="background-color: #3a425a; color: white;">
                    <th align="center" style="border: 1px solid #79829c; border-collapse: collapse; height:25px; vertical-align: middle;"><b>ID FUNCIONAL</b></th>
                    <th align="center" style="border: 1px solid #79829c; border-collapse: collapse; height:25px; vertical-align: middle;"><b>FUNÇÃO</b></th>
                    <th align="center" style="border: 1px solid #79829c; border-collapse: collapse; height:25px; vertical-align: middle;"><b>NOME</b></th>
                    <th align="center" style="border: 1px solid #79829c; border-collapse: collapse; height:25px; vertical-align: middle;"><b>VENC. BRUTO</b></th>
                    <th align="center" style="border: 1px solid #79829c; border-collapse: collapse; height:25px; vertical-align: middle;"><b>F. SAÚDE 10</b></th>
                    <th align="center" style="border: 1px solid #79829c; border-collapse: collapse; height:25px; vertical-align: middle;"><b>RIOPREV. 22</b></th>
                    <th align="center" style="border: 1px solid #79829c; border-collapse: collapse; height:25px; vertical-align: middle;"><b>FONTE 10</b></th>
                    <th align="center" style="border: 1px solid #79829c; border-collapse: collapse; height:25px; vertical-align: middle;"><b>FOLHA SUPL.</b></th>
                    <th align="center" style="border: 1px solid #79829c; border-collapse: collapse; height:25px; vertical-align: middle;"><b>VALOR TOTAL</b></th>
                    <th align="center" style="border: 1px solid #79829c; border-collapse: collapse; height:25px; vertical-align: middle;"><b>ÓRGÃO</b></th>
                    <th align="center" style="border: 1px solid #79829c; border-collapse: collapse; height:25px; vertical-align: middle;"><b>NOTA</b></th>
                    <th align="center" style="border: 1px solid #79829c; border-collapse: collapse; height:25px; vertical-align: middle;"><b>OE COBRAR</b></th>
                </tr>
            </thead>
            <tbody>
                @foreach($listagens_dados as $listagens_dado)
                    @if($listagens_dado['ressarcimento_cobranca_pdf_listagem_id'] == $listagem['id'])
                        <tr>
                            <th align="center" style="border: 1px solid #79829c; border-collapse: collapse; height:20px;">&nbsp;{{$listagens_dado['militar_identidade_funcional']}}</th>
                            <th align="center" style="border: 1px solid #79829c; border-collapse: collapse; height:20px;">&nbsp;{{$listagens_dado['militar_posto_graduacao']}}</th>
                            <th align="left" style="border: 1px solid #79829c; border-collapse: collapse; height:20px;">&nbsp;{{$listagens_dado['militar_nome']}}</th>
                            <th align="right" style="border: 1px solid #79829c; border-collapse: collapse; height:20px;">{{number_format($listagens_dado['vencimento_bruto'], '2', ',', '.')}}&nbsp;</th>
                            <th align="right" style="border: 1px solid #79829c; border-collapse: collapse; height:20px;">{{number_format($listagens_dado['fundo_saude_10'], '2', ',', '.')}}&nbsp;</th>
                            <th align="right" style="border: 1px solid #79829c; border-collapse: collapse; height:20px;">{{number_format($listagens_dado['rioprevidencia22'], '2', ',', '.')}}&nbsp;</th>
                            <th align="right" style="border: 1px solid #79829c; border-collapse: collapse; height:20px;">{{number_format($listagens_dado['fonte10'], '2', ',', '.')}}&nbsp;</th>
                            <th align="right" style="border: 1px solid #79829c; border-collapse: collapse; height:20px;">{{number_format($listagens_dado['folha_suplementar'], '2', ',', '.')}}&nbsp;</th>
                            <th align="right" style="border: 1px solid #79829c; border-collapse: collapse; height:20px;">{{number_format($listagens_dado['valor_total'], '2', ',', '.')}}&nbsp;</th>
                            <th align="left" style="border: 1px solid #79829c; border-collapse: collapse; height:20px;">&nbsp;{{$listagem['orgao_name']}}</th>
                            <th align="center" style="border: 1px solid #79829c; border-collapse: collapse; height:20px;">&nbsp;{{$listagem['nota_numero'].'/'.$listagem['nota_ano']}}</th>
                            <th align="center" style="border: 1px solid #79829c; border-collapse: collapse; height:20px;">&nbsp;{{$listagem['oe_cobrar']}}</th>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </body>
</html>
