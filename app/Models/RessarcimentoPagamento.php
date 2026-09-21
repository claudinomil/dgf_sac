<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RessarcimentoPagamento extends Model
{
    use HasFactory;

    protected $table = 'ressarcimento_pagamentos';

    protected $fillable = [
        'ressarcimento_militar_id',
        'referencia',
        'identidade_funcional',
        'rg',
        'nome_cargo',
        'posto_graduacao',
        'nome',
        'ua',
        'cpf',
        'bruto',
        'desconto',
        'liquido',
        'soldo',
        'hospital10',
        'rioprevidencia22',
        'etapa_ferias',
        'etapa_destacado',
        'ajuda_fardamento',
        'habilitacao_profissional',
        'gret',
        'ferias',
        'raio_x',
        'trienio',
        'fundo_saude',
        'abono_permanencia',
        'auxilio_transporte',
        'gram',
        'auxilio_fardamento',
        'cidade',
        'observacao'
    ];

    public function setBrutoAttribute($value)
    {
        if ($value == '') {$value = 0.00;} else {$value = getValorFormatado(1, $value);}
        $this->attributes['bruto'] = $value;
    }
    public function getBrutoAttribute($value) {return number_format($value, 2, ',', '.');}

    public function setDescontoAttribute($value)
    {
        if ($value == '') {$value = 0.00;} else {$value = getValorFormatado(1, $value);}
        $this->attributes['desconto'] = $value;
    }
    public function getDescontoAttribute($value) {return number_format($value, 2, ',', '.');}

    public function setLiquidoAttribute($value)
    {
        if ($value == '') {$value = 0.00;} else {$value = getValorFormatado(1, $value);}
        $this->attributes['liquido'] = $value;
    }
    public function getLiquidoAttribute($value) {return number_format($value, 2, ',', '.');}

    public function setSoldoAttribute($value)
    {
        if ($value == '') {$value = 0.00;} else {$value = getValorFormatado(1, $value);}
        $this->attributes['soldo'] = $value;
    }
    public function getSoldoAttribute($value) {return number_format($value, 2, ',', '.');}

    public function setHospital10Attribute($value)
    {
        if ($value == '') {$value = 0.00;} else {$value = getValorFormatado(1, $value);}
        $this->attributes['hospital10'] = $value;
    }
    public function getHospital10Attribute($value) {return number_format($value, 2, ',', '.');}

    public function setRioprevidencia22Attribute($value)
    {
        if ($value == '') {$value = 0.00;} else {$value = getValorFormatado(1, $value);}
        $this->attributes['rioprevidencia22'] = $value;
    }
    public function getRioprevidencia22Attribute($value) {return number_format($value, 2, ',', '.');}

    public function setEtapaFeriasAttribute($value)
    {
        if ($value == '') {$value = 0.00;} else {$value = getValorFormatado(1, $value);}
        $this->attributes['etapa_ferias'] = $value;
    }
    public function getEtapaFeriasAttribute($value) {return number_format($value, 2, ',', '.');}

    public function setEtapaDestacadoAttribute($value)
    {
        if ($value == '') {$value = 0.00;} else {$value = getValorFormatado(1, $value);}
        $this->attributes['etapa_destacado'] = $value;
    }
    public function getEtapaDestacadoAttribute($value) {return number_format($value, 2, ',', '.');}

    public function setAjudaFardamentoAttribute($value)
    {
        if ($value == '') {$value = 0.00;} else {$value = getValorFormatado(1, $value);}
        $this->attributes['ajuda_fardamento'] = $value;
    }
    public function getAjudaFardamentoAttribute($value) {return number_format($value, 2, ',', '.');}

    public function setHabilitacaoProfissionalAttribute($value)
    {
        if ($value == '') {$value = 0.00;} else {$value = getValorFormatado(1, $value);}
        $this->attributes['habilitacao_profissional'] = $value;
    }
    public function getHabilitacaoProfissionalAttribute($value) {return number_format($value, 2, ',', '.');}

    public function setGretAttribute($value)
    {
        if ($value == '') {$value = 0.00;} else {$value = getValorFormatado(1, $value);}
        $this->attributes['gret'] = $value;
    }
    public function getGretAttribute($value) {return number_format($value, 2, ',', '.');}

    public function setFeriasAttribute($value)
    {
        if ($value == '') {$value = 0.00;} else {$value = getValorFormatado(1, $value);}
        $this->attributes['ferias'] = $value;
    }
    public function getFeriasAttribute($value) {return number_format($value, 2, ',', '.');}

    public function setRaioXAttribute($value)
    {
        if ($value == '') {$value = 0.00;} else {$value = getValorFormatado(1, $value);}
        $this->attributes['raio_x'] = $value;
    }
    public function getRaioXAttribute($value) {return number_format($value, 2, ',', '.');}

    public function setTrienioAttribute($value)
    {
        if ($value == '') {$value = 0.00;} else {$value = getValorFormatado(1, $value);}
        $this->attributes['trienio'] = $value;
    }
    public function getTrienioAttribute($value) {return number_format($value, 2, ',', '.');}

    public function setFundoSaudeAttribute($value)
    {
        if ($value == '') {$value = 0.00;} else {$value = getValorFormatado(1, $value);}
        $this->attributes['fundo_saude'] = $value;
    }
    public function getFundoSaudeAttribute($value) {return number_format($value, 2, ',', '.');}

    public function setAbonoPermanenciaAttribute($value)
    {
        if ($value == '') {$value = 0.00;} else {$value = getValorFormatado(1, $value);}
        $this->attributes['abono_permanencia'] = $value;
    }
    public function getAbonoPermanenciaAttribute($value) {return number_format($value, 2, ',', '.');}

    public function setAuxilioTransporteAttribute($value)
    {
        if ($value == '') {$value = 0.00;} else {$value = getValorFormatado(1, $value);}
        $this->attributes['auxilio_transporte'] = $value;
    }
    public function getAuxilioTransporteAttribute($value) {return number_format($value, 2, ',', '.');}

    public function setGramAttribute($value)
    {
        if ($value == '') {$value = 0.00;} else {$value = getValorFormatado(1, $value);}
        $this->attributes['gram'] = $value;
    }
    public function getGramAttribute($value) {return number_format($value, 2, ',', '.');}

    public function setAuxilioFardamentoAttribute($value)
    {
        if ($value == '') {$value = 0.00;} else {$value = getValorFormatado(1, $value);}
        $this->attributes['auxilio_fardamento'] = $value;
    }
    public function getAuxilioFardamentoAttribute($value) {return number_format($value, 2, ',', '.');}
}
