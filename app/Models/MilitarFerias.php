<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MilitarFerias extends Model
{
    use HasFactory;

    protected $table = 'militares_ferias';

    protected $fillable = [
        'excluido',
        'militar_id',
        'mes',
        'ano',
        'referencia',
        'documento_origem',
        'boletim',
        'ciente',
        'documento',
        'unidade',
        'excecao_id',
        'controle_sistema_cadastramento_ferias',
        'observacao'
    ];

    protected $casts = [
        'data_nascimento' => 'date'
    ];
}
