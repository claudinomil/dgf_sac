<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Notifications\ResetPasswordNotification;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $table = 'users';

    protected $fillable = [
        'name',
        'user',
        'email',
        'password',
        'grupo_id',
        'user_situacao_id',
        'user_tipo_id',
        'avatar',
        'militar_id',
        'layout_menu'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    public function setNameAttribute($value) {$this->attributes['name'] = mb_strtoupper($value);}
    public function setEmailAttribute($value) {$this->attributes['email'] = $value !== null ? mb_strtolower($value) : null;}
    public function setAvatarAttribute($value) {$this->attributes['avatar'] = mb_strtolower($value);}
}
