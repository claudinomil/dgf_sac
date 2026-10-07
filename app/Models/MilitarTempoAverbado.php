<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class MilitarTempoAverbado extends Model
{
    use HasFactory;

    protected $table = 'militares_tempos_averbados';

    protected $fillable = [
        'excluido',
        'militar_id',
        'tempo_averbado_local_id',
        'data_ingresso_local',
        'data_termino_local',
        'tempo_apurado_local',
        'boletim',
        'proderj_servico_publico',
        'proderj_servico_publico_rj',
        'proderj_servico_cargo',
        'proderj_controle',
        'lancado_proderj',
        'observacao',
        'referencia_processo_sei'
    ];

    protected $casts = [
        'data_ingresso_local',
        'data_termino_local'
    ];

    public function setDataIngressoLocalAttribute(?string $value)
    {
        if (blank($value)) {
            $this->attributes['data_ingresso_local'] = null;
            return;
        }

        $this->attributes['data_ingresso_local'] = Carbon::createFromFormat('d/m/Y', trim($value))->format('Y-m-d');
    }

    public function setDataTerminoLocalAttribute(?string $value)
    {
        if (blank($value)) {
            $this->attributes['data_termino_local'] = null;
            return;
        }

        $this->attributes['data_termino_local'] = Carbon::createFromFormat('d/m/Y', trim($value))->format('Y-m-d');
    }
}