<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class ApiAcessoSistemaSaude extends Authenticatable
{
    use HasApiTokens;

    protected $table = 'api_acesso_sistema_saude';

    protected $fillable = [
        'nome',
        'email',
        'password',
        'ativo',
    ];

    protected $hidden = [
        'password',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'ativo' => 'boolean',
        ];
    }
}
