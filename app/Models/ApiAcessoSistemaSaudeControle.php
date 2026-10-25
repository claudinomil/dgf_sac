<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApiAcessoSistemaSaudeControle extends Model
{
    use HasFactory;

    protected $table = 'api_acesso_sistema_saude_controle';

    protected $fillable = [
        'api_acesso_sistema_saude_usuario_id',
        'origem',
        'militar_id',
        'data',
        'hora'
    ];
}