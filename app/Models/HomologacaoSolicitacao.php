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
        'solicitacao_data',
        'solicitacao_hora',
        'solicitacao_imagem',
        'resposta',
        'resposta_status',
        'resposta_data',
        'resposta_hora'
    ];

    protected $casts = [
        'solicitacao_data' => 'date',
        'resposta_data' => 'date'
    ];
}
