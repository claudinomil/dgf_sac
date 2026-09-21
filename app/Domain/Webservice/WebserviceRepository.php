<?php

namespace App\Domain\Webservice;

use Illuminate\Support\Facades\Http;

class WebserviceRepository
{
    /*
     * WebService - DGF
     */
    public function webserviceDgf($parametros) {
        // Parâmetros
        if (isset($parametros['evento'])) {$evento = $parametros['evento'];} else {$evento = 0;}
        if (isset($parametros['field'])) {$field = $parametros['field'];} else {$field = '';}
        if (isset($parametros['value'])) {$value = $parametros['value'];} else {$value = '';}
        if (isset($parametros['limit'])) {$limit = $parametros['limit'];} else {$limit = 500;}
        if (isset($parametros['selectWhere'])) {$selectWhere = $parametros['selectWhere'];} else {$selectWhere = '';}
        if (isset($parametros['data1'])) {$data1 = $parametros['data1'];} else {$data1 = '';}
        if (isset($parametros['data2'])) {$data2 = $parametros['data2'];} else {$data2 = '';}
        if (isset($parametros['subconta_id'])) {$subconta_id = $parametros['subconta_id'];} else {$subconta_id = 0;}

        // Response
        $response = Http::get("http://dgf.rj.gov.br/sites/sistema/service_sistema_dgf.php", [
            'token' => 'hg4t@hb%gfdRRR$$$hk999R@@@hvfCLAU',
            'evento' => $evento,
            'field' => $field,
            'value' => $value,
            'limit' => $limit,
            'selectWhere' => $selectWhere,
            'data1' => $data1,
            'data2' => $data2,
            'subconta_id' => $subconta_id
        ]);

        dd($response);

        return $response;
    }

    public function militar($field, $value)
    {
        // WebService - DGF
        $parametros = array();
        $parametros['evento'] = 1;
        $parametros['field'] = $field;
        $parametros['value'] = $value;

        $registro = $this->webserviceDgf($parametros);

        // Registro recebido com sucesso
        if (isset($registro['success'])) {
            return $registro['success'][0];
        }

        return $registro['error'];
    }

    public function totais()
    {
        // WebService - DGF
        $parametros = array();
        $parametros['evento'] = 6;
        $parametros['field'] = '';
        $parametros['value'] = '';

        $registro = $this->webserviceDgf($parametros);

        // Registro recebido com sucesso
        if (isset($registro['success'])) {
            return $registro['success'][0];
        }

        return $registro['error'];
    }

    public function tabelaRegistros(string $tabela)
    {
        // WebService - DGF
        $parametros = array();
        $parametros['evento'] = 7;
        $parametros['field'] = '';
        $parametros['value'] = $tabela;

        $registros = $this->webserviceDgf($parametros);

        // Registro recebido com sucesso
        if (isset($registros['success'])) {
            return $registros['success'];
        }

        return $registros['error'];
    }
}
