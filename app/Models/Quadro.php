<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quadro extends Model
{
    use HasFactory;

    protected $table = 'quadros';

    protected $fillable = [
        'excluido',
        'codigo_quadro',
        'name',
        'especialidade',
        'quadro_especialidade'
    ];

    public function setNameAttribute($value) {$this->attributes['name'] = mb_strtoupper($value);}
    public function setEspecialidadeAttribute($value) {$this->attributes['especialidade'] = mb_strtoupper($value);}
    public function setQuadroEspecialidadeAttribute($value) {$this->attributes['quadro_especialidade'] = mb_strtoupper($value);}
}
