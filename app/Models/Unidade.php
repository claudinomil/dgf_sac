<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unidade extends Model
{
    use HasFactory;

    protected $table = 'unidades';

    protected $fillable = [
        'excluido',
        'codigo_unidade',
        'situacao',
        'tipo',
        'name',
        'sigla',
        'ua',
        'cba',
        'ordem_estrutura',
        'agregado',
        'controle',
        'esfera',
        'poder',
        'vocativo',
        'funcao_id',
        'responsavel',
        'cep',
        'numero',
        'complemento',
        'telefone',
        'fax',
        'cnpj',
        'subordinacao_unidade_id',
        'subordinacao_ordem'
    ];

    public function setNameAttribute(?string $value) {$this->attributes['name'] = mb_strtoupper($value);}
}
