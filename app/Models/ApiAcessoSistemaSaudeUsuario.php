<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class ApiAcessoSistemaSaudeUsuario extends Authenticatable
{
    use HasApiTokens;

    protected $table = 'api_acesso_sistema_saude_usuarios';

    protected $fillable = [
        'nome',
        'usuario',
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
