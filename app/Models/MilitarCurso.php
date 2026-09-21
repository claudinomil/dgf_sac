<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class MilitarCurso extends Model
{
    use HasFactory;

    protected $table = 'militares_cursos';

    protected $fillable = [
        'excluido',
        'militar_id',
        'curso_id',
        'data_inicio',
        'data_termino',
        'boletim',
        'conceito',
        'classificacao'
    ];

    protected $casts = [
        'data_inicio' => 'date',
        'data_termino' => 'date'
    ];

    public function setDataInicioAttribute($value)
    {
        if (blank($value)) {
            $this->attributes['data_inicio'] = null;
            return;
        }

        $this->attributes['data_inicio'] = Carbon::createFromFormat('d/m/Y', trim($value))->format('Y-m-d');
    }

    public function setDataTerminoAttribute($value)
    {
        if (blank($value)) {
            $this->attributes['data_termino'] = null;
            return;
        }

        $this->attributes['data_termino'] = Carbon::createFromFormat('d/m/Y', trim($value))->format('Y-m-d');
    }
}
