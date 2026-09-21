<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'id' => 1,
            'name' => 'CLAUDINO MIL HOMENS DE MORAES',
            'user' => '27335',
            'email' => 'claudinomoraes@yahoo.com.br',
            'password' => Hash::make('12345678'),
            'email_verified_at' => now(),
            'avatar' => 'assets/images/users/avatar-0.png',
            'grupo_id' => '1',
            'user_situacao_id' => '1',
            'user_tipo_id' => '1',
            'militar_id' => 16509,
            'created_at' => now()
        ]);
    }
}
