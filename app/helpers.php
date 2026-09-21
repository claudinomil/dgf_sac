<?php

if (!function_exists('temPermissao')) {
    function temPermissao(string $permissao)
    {
        $context = session('userContext');

        if (!$context) {return false;}

        $permissoes = $context['permissoes'] ?? [];

        return (bool) in_array($permissao, $permissoes);
    }
}

if (!function_exists('temPermissaoSituacao')) {
    // Verificar se tem permissão para a Situação (Submódulos Militares e todos relacionados a ele)
    function temPermissaoSituacao(string $modulo, string $acao, int $situacaoId): bool
    {
        $campo = $modulo . '_permissoes_' . $acao . '_situacoes_ids';

        $context = session('userContext');

        if (!$context) {return false;}

        $permissoesSituacoes = $context['permissoes_situacoes'] ?? [];

        if (empty($permissoesSituacoes[$campo])) {return false;}

        $ids = array_map('intval', explode(',', $permissoesSituacoes[$campo]));

        return in_array($situacaoId, $ids, true);
    }
}

if (!function_exists('retornaArrayCampoGruposPermissoesSituacoes')) {
    function retornaArrayCampoGruposPermissoesSituacoes(string $campo)
    {
        $valor = session("userContext.permissoes_situacoes.$campo");

        if (empty($valor)) {return [];}

        return array_map('intval', explode(',', $valor));
    }
}

if (!function_exists('primeiraMaiuscula')) {
    function primeiraMaiuscula(?string $texto): string
    {
        if (empty($texto)) {return '';}

        $preposicoes = ['de','da','do','das','des','dos','a','e','o'];

        $palavras = explode(' ', mb_strtolower($texto));

        foreach ($palavras as $i => $palavra) {

            if (!in_array($palavra, $preposicoes)) {
                $palavras[$i] = mb_convert_case($palavra, MB_CASE_TITLE, "UTF-8");
            }

        }

        return implode(' ', $palavras);
    }
}

if (!function_exists('setCrudSessions')) {
    function setCrudSessions(string $prefix_permissao)
    {
        $submoduloService = app(\App\Domain\Submodulo\SubmoduloService::class);

        $submodulo = $submoduloService->getSubmoduloPrefixPermissao($prefix_permissao);
        $namesFieldsSubmodulo = $submoduloService->getColumnListing($prefix_permissao);

        session([
            'crudPrefixPermissaoSubmodulo' => $submodulo->prefix_permissao,
            'crudNameSubmodulo'            => $submodulo->name,
            'crudNameFormSubmodulo'        => 'frm_' . $submodulo->prefix_permissao,
            'crudFieldsFormSubmodulo'      => implode(',', $namesFieldsSubmodulo),
        ]);
    }
}

if (!function_exists('getReferencia')) {
    /*
    * Retornar referencia
    * @PARAM op=1 : recebe 20230902 e retorna setembro de 2023 parte 02
    * @PARAM op=2 : recebe 202309 e retorna setembro de 2023
    * @PARAM op=3 : recebe setembro de 2023 parte 02 e retorna 20230902
    * @PARAM op=4 : recebe setembro de 2023 e retorna 202309
    */
    function getReferencia(int $op, string $referencia)
    {
        if ($op == 1) {
            $ano = substr($referencia, 0, 4);
            $mes = substr($referencia, 4, 2);
            $parte = substr($referencia, 6, 2);
            $mes_extenso = getMes(1, $mes);

            return $mes_extenso. ' de '.$ano.' parte '.$parte;
        }

        if ($op == 2) {
            $ano = substr($referencia, 0, 4);
            $mes = substr($referencia, 4, 2);
            $mes_extenso = getMes(1, $mes);

            return $mes_extenso. ' de '.$ano;
        }

        if ($op == 3) {
            $explode = explode('', $referencia);

            $parte = $explode[4];
            $ano = $explode[2];
            $mes_extenso = $explode[0];
            $mes = getMes(2, $mes_extenso);

            return $ano.$mes.$parte;
        }

        if ($op == 4) {
            $explode = explode('', $referencia);

            $ano = $explode[2];
            $mes_extenso = $explode[0];
            $mes = getMes(2, $mes_extenso);

            return $ano.$mes;
        }

        return false;
    }
}

if (!function_exists('getMes')) {
    /*
    * Retornar Mês e Mês por Extenso
    * @PARAM op=1 = retorna Mês por Extenso
    * @PARAM op=2 = retorna Mês Numeral
    */
    function getMes(int $op, string $mes)
    {
        if ($op == 1) {
            if (strlen($mes) == 1) {$mes = '0'.$mes;}

            if ($mes == '01') {return 'janeiro';}
            if ($mes == '02') {return 'fevereiro';}
            if ($mes == '03') {return 'março';}
            if ($mes == '04') {return 'abril';}
            if ($mes == '05') {return 'maio';}
            if ($mes == '06') {return 'junho';}
            if ($mes == '07') {return 'julho';}
            if ($mes == '08') {return 'agosto';}
            if ($mes == '09') {return 'setembro';}
            if ($mes == '10') {return 'outubro';}
            if ($mes == '11') {return 'novembro';}
            if ($mes == '12') {return 'dezembro';}
        }

        if ($op == 2) {
            if ($mes == 'janeiro') {return '01';}
            if ($mes == 'fevereiro') {return '02';}
            if ($mes == 'março') {return '03';}
            if ($mes == 'abril') {return '04';}
            if ($mes == 'maio') {return '05';}
            if ($mes == 'junho') {return '06';}
            if ($mes == 'julho') {return '07';}
            if ($mes == 'agosto') {return '08';}
            if ($mes == 'setembro') {return '09';}
            if ($mes == 'outubro') {return '10';}
            if ($mes == 'novembro') {return '11';}
            if ($mes == 'dezembro') {return '12';}
        }

        return false;
    }
}

if (!function_exists('getDataExtenso')) {
    /*
    * Retornar data por extenso
    * @PARAM $data: 2023-10-25
    */
    function getDataExtenso(string $data)
    {
        $ano = substr($data, 0, 4);
        $mes = substr($data, 5, 2);
        $dia = substr($data, 8, 2);

        $mes_extenso = getMes(1, $mes);

        return 'Rio de Janeiro, '.$dia.' de '.$mes_extenso.' de '.$ano;
    }
}

if (!function_exists('getValorExtenso')) {
    /*
    * Retornar valor por extenso
    */
    function getValorExtenso($valor = 0, $maiusculas = false) {
        // verifica se tem virgula decimal
        if (strpos($valor, ",") > 0) {
            // retira o ponto de milhar, se tiver
            $valor = str_replace(".", "", $valor);

            // troca a virgula decimal por ponto decimal
            $valor = str_replace(",", ".", $valor);
        }
        $singular = array("centavo", "real", "mil", "milhão", "bilhão", "trilhão", "quatrilhão");
        $plural = array("centavos", "reais", "mil", "milhões", "bilhões", "trilhões", "quatrilhões");

        $c = array("", "cem", "duzentos", "trezentos", "quatrocentos", "quinhentos", "seiscentos", "setecentos", "oitocentos", "novecentos");
        $d = array("", "dez", "vinte", "trinta", "quarenta", "cinquenta", "sessenta", "setenta", "oitenta", "noventa");
        $d10 = array("dez", "onze", "doze", "treze", "quatorze", "quinze", "dezesseis", "dezesete", "dezoito", "dezenove");
        $u = array("", "um", "dois", "trÃªs", "quatro", "cinco", "seis", "sete", "oito", "nove");

        $z = 0;

        $valor = number_format($valor, 2, ".", ".");
        $inteiro = explode(".", $valor);
        $cont = count($inteiro);
        for ($i = 0; $i < $cont; $i++)
            for ($ii = strlen($inteiro[$i]); $ii < 3; $ii++)
                $inteiro[$i] = "0" . $inteiro[$i];

        $fim = $cont - ($inteiro[$cont - 1] > 0 ? 1 : 2);
        $rt = '';

        for ($i = 0; $i < $cont; $i++) {
            $valor = $inteiro[$i];
            $rc = (($valor > 100) && ($valor < 200)) ? "cento" : $c[$valor[0]];
            $rd = ($valor[1] < 2) ? "" : $d[$valor[1]];
            $ru = ($valor > 0) ? (($valor[1] == 1) ? $d10[$valor[2]] : $u[$valor[2]]) : "";

            $r = $rc . (($rc && ($rd || $ru)) ? " e " : "") . $rd . (($rd &&
                    $ru) ? " e " : "") . $ru;
            $t = $cont - 1 - $i;
            $r .= $r ? " " . ($valor > 1 ? $plural[$t] : $singular[$t]) : "";
            if ($valor == "000")
                $z++; elseif ($z > 0)
                $z--;
            if (($t == 1) && ($z > 0) && ($inteiro[0] > 0))
                $r .= (($z > 1) ? " de " : "") . $plural[$t];
            if ($r)
                $rt = $rt . ((($i > 0) && ($i <= $fim) &&
                        ($inteiro[0] > 0) && ($z < 1)) ? ( ($i < $fim) ? ", " : " e ") : " ") . $r;
        }

        if (!$maiusculas) {
            return($rt ? $rt : "zero");
        } elseif ($maiusculas == "2") {
            return (strtoupper($rt) ? strtoupper($rt) : "Zero");
        } else {
            return (ucwords($rt) ? ucwords($rt) : "Zero");
        }
    }
}

if (!function_exists('getDataFormatada')) {
    /*
    * Retornar data formatada
    * A) Recebe formatos de datas: 99/99/9999 ou 99-99-9999 ou 9999/99/99 ou 9999-99-99
    * B) Depois retorna essa data no formato pedido pelo usuário
    * @PARAM op=1 = recebe qualquer data e retorna 99/99/9999
    * @PARAM op=2 = recebe qualquer data e retorna 99-99-9999
    * @PARAM op=3 = recebe qualquer data e retorna 9999/99/99
    * @PARAM op=4 = recebe qualquer data e retorna 9999-99-99
    */
    function getDataFormatada(int $op, ?string $data='')
    {
        //Variáveis para formatar o retorno
        $dia = '';
        $mes = '';
        $ano = '';

        //Verificando recebimento da data
        if ($data == '') {
            $data = null;
        } else {
            //Retirando espaços
            $data = trim($data);
            $data = str_replace(" ", "", $data);

            //Formato: 9999-99-99
            if (is_numeric(substr($data, 0, 4)) and substr($data, 4, 1) == '-' and is_numeric(substr($data, 5, 2)) and substr($data, 7, 1) == '-' and is_numeric(substr($data, 8, 2))) {
                $dia = substr($data, 8, 2);
                $mes = substr($data, 5, 2);
                $ano = substr($data, 0, 4);
            }

            //Formato: 9999/99/99
            if (is_numeric(substr($data, 0, 4)) and substr($data, 4, 1) == '/' and is_numeric(substr($data, 5, 2)) and substr($data, 7, 1) == '/' and is_numeric(substr($data, 8, 2))) {
                $dia = substr($data, 8, 2);
                $mes = substr($data, 5, 2);
                $ano = substr($data, 0, 4);
            }

            //Formato: 99-99-9999
            if (is_numeric(substr($data, 0, 2)) and substr($data, 2, 1) == '-' and is_numeric(substr($data, 3, 2)) and substr($data, 5, 1) == '-' and is_numeric(substr($data, 6, 4))) {
                $dia = substr($data, 0, 2);
                $mes = substr($data, 3, 2);
                $ano = substr($data, 6, 4);
            }

            //Formato: 99/99/9999
            if (is_numeric(substr($data, 0, 2)) and substr($data, 2, 1) == '/' and is_numeric(substr($data, 3, 2)) and substr($data, 5, 1) == '/' and is_numeric(substr($data, 6, 4))) {
                $dia = substr($data, 0, 2);
                $mes = substr($data, 3, 2);
                $ano = substr($data, 6, 4);
            }
        }

        //Retorno
        if ($dia == '' or $mes == '' or $ano == '' or $dia == '00' or $mes == '00' or $ano == '0000') {
            $data = null;
        } else {
            //Retorna no formato (99/99/9999)
            if ($op == 1) {$data = $dia.'/'.$mes.'/'.$ano;}

            //Retorna no formato (99-99-9999)
            if ($op == 2) {$data = $dia.'-'.$mes.'-'.$ano;}

            //Retorna no formato (9999/99/99)
            if ($op == 3) {$data = $ano.'/'.$mes.'/'.$dia;}

            //Retorna no formato (9999-99-99)
            if ($op == 4) {$data = $ano.'-'.$mes.'-'.$dia;}
        }

        return $data;
    }
}

if (!function_exists('getValorFormatado')) {
    /*
    * Retornar valor formatado
    * A) Recebe qualquer número e transforma ele para o formato 123456.78
    * B) Depois retorna esse número no formato pedido pelo usuário
    * @PARAM op=1 = recebe qualquer número e retorna 123456.78
    * @PARAM op=2 = recebe qualquer número e retorna 123.456,78
    * @PARAM op=3 = recebe qualquer número e retorna 123,456.78
    * @PARAM op=4 = recebe qualquer número e retorna 123456,78
    */
    function getValorFormatado(int $op, string $valor)
    {
        if ($valor == '') {
            $valor = 0;
        }

        //Retirando espaços
        $valor = trim($valor);
        $valor = str_replace(" ", "", $valor);

        //Montando um array com cada digito
        $dados = str_split($valor);

        //Guardar ultima posição de um ponto/virgula
        $ponto_virgula = 0;

        //Posição da casa decimal
        $posicao_casa_decimal = 0;

        //posição
        $posicao = 0;
        foreach ($dados as $dado) {
            //Verificando e guardando caso o dígito seja um ponto
            if ($dado == '.') {
                $ponto_virgula = 1;
                $posicao_casa_decimal = $posicao;
            }

            //Verificando e guardando caso o dígito seja uma vírgula
            if ($dado == ',') {
                $ponto_virgula = 2;
                $posicao_casa_decimal = $posicao;
            }

            $posicao++;
        }

        //Refazer valor retirando pontos/vírgulas nas separações de milhares
        $valor = '';

        //posição
        $posicao = 0;
        foreach ($dados as $dado) {
            //Se dígito for um ponto/vírgula
            if ($dado == '.' or $dado == ',') {
                //Se for o ponto/vírgula da casa decimal (concatenar ao valor)
                if ($posicao_casa_decimal == $posicao) {$valor .= $dado;}
            } else {
                //concatenar ao valor
                $valor .= $dado;
            }

            $posicao++;
        }

        //Se valor tem vírgula trocar por ponto
        if ($ponto_virgula == 2) {
            $valor = str_replace(',', '.', $valor);
        }

        //Retorna no formato (123456.78)
        if ($op == 1) {
            $valor = number_format($valor, '2', '.', '');
        }

        //Retorna no formato (123.456,78)
        if ($op == 2) {
            $valor = number_format($valor, '2', ',', '.');
        }

        //Retorna no formato (123,456.78)
        if ($op == 3) {
            $valor = number_format($valor, '2', '.', ',');
        }

        //Retorna no formato (123456,78)
        if ($op == 4) {
            $valor = number_format($valor, '2', ',', '');
        }

        return $valor;
    }
}

if (!function_exists('getRG')) {
    /*
    * Formatar RG
    * @PARAM op=1 : recebe 00/0027.335 e retorna 27335
    * @PARAM op=2 : recebe 27335 e retorna 00/0027.335
    */
    function getRG(int $op, string $rg) {
        if ($op == 1) {
            $rg = str_replace('/', '', $rg);
            $rg = str_replace('.', '', $rg);

            for($i=0; $i<7; $i++) {
                if (substr($rg, 0, 1) == '0') {
                    $rg = substr($rg, 1);
                } else {
                    exit;
                }
            }
        }

        if ($op == 1) {
            if (strlen($rg) == 7) {$rg = '00/'.substr($rg, 0, 4) . '.' . substr($rg, 4, 3);}
            if (strlen($rg) == 6) {$rg = '00/'.'0' . substr($rg, 0, 3) . '.' . substr($rg, 3, 3);}
            if (strlen($rg) == 5) {$rg = '00/'.'00' . substr($rg, 0, 2) . '.' . substr($rg, 2, 3);}
            if (strlen($rg) == 4) {$rg = '00/'.'000' . substr($rg, 0, 1) . '.' . substr($rg, 1, 3);}
            if (strlen($rg) == 3) {$rg = '00/'.'0000' . '.' . substr($rg, 0, 3);}
        }

        return $rg;
    }
}

if (!function_exists('getCepFormatado')) {
    /*
    * Retorna CEP formatado
    * @PARAM op=1 = 99999-999
    * @PARAM op=2 = 99999999
    */
    function getCepFormatado(int $op, ?string $cep = '')
    {
        if (empty($cep)) {
            return null;
        }

        $cep = preg_replace('/\D/', '', trim($cep));

        if (strlen($cep) != 8) {
            return null;
        }

        if ($op == 1) {
            return substr($cep, 0, 5) . '-' . substr($cep, 5, 3);
        }

        if ($op == 2) {
            return $cep;
        }

        return null;
    }
}

if (!function_exists('getCpfFormatado')) {
    /*
    * Retorna CPF formatado
    * @PARAM op=1 = 999.999.999-99
    * @PARAM op=2 = 99999999999
    */
    function getCpfFormatado(int $op, ?string $cpf = '')
    {
        if (empty($cpf)) {
            return null;
        }

        $cpf = preg_replace('/\D/', '', trim($cpf));

        if (strlen($cpf) != 11) {
            return null;
        }

        if ($op == 1) {
            return substr($cpf, 0, 3) . '.' . substr($cpf, 3, 3) . '.' . substr($cpf, 6, 3) . '-' . substr($cpf, 9, 2);
        }

        if ($op == 2) {
            return $cpf;
        }

        return null;
    }
}

if (!function_exists('getCnpjFormatado')) {
    /*
    * Retorna CNPJ formatado
    * @PARAM op=1 = 99.999.999/9999-99
    * @PARAM op=2 = 99999999999999
    */
    function getCnpjFormatado(int $op, ?string $cnpj = '')
    {
        if (empty($cnpj)) {
            return null;
        }

        $cnpj = preg_replace('/\D/', '', trim($cnpj));

        if (strlen($cnpj) != 14) {
            return null;
        }

        if ($op == 1) {
            return substr($cnpj, 0, 2) . '.' . substr($cnpj, 2, 3) . '.' . substr($cnpj, 5, 3) . '/' . substr($cnpj, 8, 4) . '-' . substr($cnpj, 12, 2);
        }

        if ($op == 2) {
            return $cnpj;
        }

        return null;
    }
}

if (!function_exists('getValorFormatado')) {
    /*
    * Retornar valor formatado
    * A) Recebe qualquer número e transforma ele para o formato 123456.78
    * B) Depois retorna esse número no formato pedido pelo usuário
    * @PARAM op=1 = recebe qualquer número e retorna 123456.78
    * @PARAM op=2 = recebe qualquer número e retorna 123.456,78
    * @PARAM op=3 = recebe qualquer número e retorna 123,456.78
    * @PARAM op=4 = recebe qualquer número e retorna 123456,78
    */
    function getValorFormatado(int $op, string $valor)
    {
        if ($valor == '') {
            $valor = 0;
        }

        //Retirando espaços
        $valor = trim($valor);
        $valor = str_replace(" ", "", $valor);

        //Montando um array com cada digito
        $dados = str_split($valor);

        //Guardar ultima posição de um ponto/virgula
        $ponto_virgula = 0;

        //Posição da casa decimal
        $posicao_casa_decimal = 0;

        //posição
        $posicao = 0;
        foreach ($dados as $dado) {
            //Verificando e guardando caso o dígito seja um ponto
            if ($dado == '.') {
                $ponto_virgula = 1;
                $posicao_casa_decimal = $posicao;
            }

            //Verificando e guardando caso o dígito seja uma vírgula
            if ($dado == ',') {
                $ponto_virgula = 2;
                $posicao_casa_decimal = $posicao;
            }

            $posicao++;
        }

        //Refazer valor retirando pontos/vírgulas nas separações de milhares
        $valor = '';

        //posição
        $posicao = 0;
        foreach ($dados as $dado) {
            //Se dígito for um ponto/vírgula
            if ($dado == '.' or $dado == ',') {
                //Se for o ponto/vírgula da casa decimal (concatenar ao valor)
                if ($posicao_casa_decimal == $posicao) {$valor .= $dado;}
            } else {
                //concatenar ao valor
                $valor .= $dado;
            }

            $posicao++;
        }

        //Se valor tem vírgula trocar por ponto
        if ($ponto_virgula == 2) {
            $valor = str_replace(',', '.', $valor);
        }

        //Retorna no formato (123456.78)
        if ($op == 1) {
            $valor = number_format($valor, '2', '.', '');
        }

        //Retorna no formato (123.456,78)
        if ($op == 2) {
            $valor = number_format($valor, '2', ',', '.');
        }

        //Retorna no formato (123,456.78)
        if ($op == 3) {
            $valor = number_format($valor, '2', '.', ',');
        }

        //Retorna no formato (123456,78)
        if ($op == 4) {
            $valor = number_format($valor, '2', ',', '');
        }

        return $valor;
    }
}

if (!function_exists('getTelefoneFormatado')) {
    /*
    * Retorna Telefone formatado
    * @PARAM op=1 = (99) 9999-9999
    * @PARAM op=2 = 9999999999
    */
    function getTelefoneFormatado(int $op, ?string $telefone = '')
    {
        if (empty($telefone)) {
            return null;
        }

        $telefone = preg_replace('/\D/', '', trim($telefone));

        if (strlen($telefone) != 10) {
            return null;
        }

        if ($op == 1) {
            return '(' . substr($telefone, 0, 2) . ') ' .
                   substr($telefone, 2, 4) . '-' .
                   substr($telefone, 6, 4);
        }

        if ($op == 2) {
            return $telefone;
        }

        return null;
    }
}

if (!function_exists('getCelularFormatado')) {
    /*
    * Retorna Celular formatado
    * @PARAM op=1 = (99) 99999-9999
    * @PARAM op=2 = 99999999999
    */
    function getCelularFormatado(int $op, ?string $celular = '')
    {
        if (empty($celular)) {
            return null;
        }

        $celular = preg_replace('/\D/', '', trim($celular));

        if (strlen($celular) != 11) {
            return null;
        }

        if ($op == 1) {
            return '(' . substr($celular, 0, 2) . ') ' .
                   substr($celular, 2, 5) . '-' .
                   substr($celular, 7, 4);
        }

        if ($op == 2) {
            return $celular;
        }

        return null;
    }
}

if (!function_exists('getRemoverAcentos')) {
    function getRemoverAcentos(string $texto): string
    {
        if ($texto == '') {return $texto;}

        $texto = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $texto);
        return preg_replace('/[^A-Za-z0-9\s]/', '', $texto);
    }
}
