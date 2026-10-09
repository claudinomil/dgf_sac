<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomologacaoSolicitacao extends Model
{
    use HasFactory;

    protected $table = 'homologacao_solicitacoes';

    protected $fillable = [
        'submodulo_id',
        'user_id',
        'solicitacao',
        'solicitacao_tipo',
        'solicitacao_prioridade',
        'data_solicitacao',
        'hora_solicitacao',
        'resposta',
        'solicitacao_status',
        'data_resposta',
        'hora_resposta'
    ];

    protected $casts = [
        'data_solicitacao' => 'date',
        'data_resposta' => 'date'
    ];
}
