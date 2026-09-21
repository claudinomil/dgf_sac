<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSituacao extends Model
{
    use HasFactory;

    protected $table = 'user_situacoes';

    protected $fillable = [
        'name',
        'bg_badge'
    ];
}
