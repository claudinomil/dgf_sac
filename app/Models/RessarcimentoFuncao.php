<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RessarcimentoFuncao extends Model
{
    use HasFactory;

    protected $table = 'ressarcimento_funcoes';

    protected $fillable = [
        'name',
        'ordem_visualizacao'
    ];

    public function setNameAttribute($value) {$this->attributes['name'] = mb_strtoupper($value);}
}
