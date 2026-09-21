<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class MilitarContato extends Model
{
    use HasFactory;

    protected $table = 'militares_contatos';

    protected $fillable = [
        'excluido',
        'militar_id',
        'cep',
        'numero',
        'complemento',
        'logradouro',
        'bairro',
        'localidade',
        'uf',
        'celular_1',
        'celular_2',
        'telefone_1',
        'telefone_2',
        'email'
    ];

    public function setLogradouroAttribute(?string $value) {$this->attributes['logradouro'] = filled($value) ? mb_strtoupper($value) : null;}
    public function setBairroAttribute(?string $value) {$this->attributes['bairro'] = filled($value) ? mb_strtoupper($value) : null;}
    public function setLocalidadeAttribute(?string $value) {$this->attributes['localidade'] = filled($value) ? mb_strtoupper($value) : null;}
    public function setUfAttribute(?string $value) {$this->attributes['uf'] = filled($value) ? mb_strtoupper($value) : null;}
    public function setEmailAttribute(?string $value) {$this->attributes['email'] = filled($value) ? mb_strtolower($value) : null;}
}
