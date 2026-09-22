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
            'id' => 2,
            'name' => 'CRISTIANO PINTO DOS SANTOS',
            'user' => '24862',
            'email' => 'cristiano@cbmerj.rj.gov.br',
            'password' => Hash::make('12345678'),
            'email_verified_at' => now(),
            'avatar' => 'assets/images/users/avatar-0.png',
            'grupo_id' => '1',
            'user_situacao_id' => '1',
            'user_tipo_id' => '1',
            'militar_id' => 15661,
            'created_at' => now()
        ]);

        User::create([
            'id' => 3,
            'name' => 'LEONARDO COELHO MORAES DE ABREU',
            'user' => '35714',
            'email' => 'coelho@cbmerj.rj.gov.br',
            'password' => Hash::make('12345678'),
            'email_verified_at' => now(),
            'avatar' => 'assets/images/users/avatar-0.png',
            'grupo_id' => '1',
            'user_situacao_id' => '1',
            'user_tipo_id' => '1',
            'militar_id' => 20023,
            'created_at' => now()
        ]);

        User::create([
            'id' => 4,
            'name' => 'EDUARDO FERREIRA GONCALVES',
            'user' => '36604',
            'email' => 'eduardoferreira@cbmerj.rj.gov.br',
            'password' => Hash::make('12345678'),
            'email_verified_at' => now(),
            'avatar' => 'assets/images/users/avatar-0.png',
            'grupo_id' => '1',
            'user_situacao_id' => '1',
            'user_tipo_id' => '1',
            'militar_id' => 20051,
            'created_at' => now()
        ]);

        User::create([
            'id' => 5,
            'name' => 'THIAGO OLIVEIRA BATISTA',
            'user' => '34012',
            'email' => 'thiago@cbmerj.rj.gov.br',
            'password' => Hash::make('12345678'),
            'email_verified_at' => now(),
            'avatar' => 'assets/images/users/avatar-0.png',
            'grupo_id' => '1',
            'user_situacao_id' => '1',
            'user_tipo_id' => '1',
            'militar_id' => 19940,
            'created_at' => now()
        ]);

        User::create([
            'id' => 6,
            'name' => 'WILLIAM GUEDES DA SILVA',
            'user' => '46085',
            'email' => 'williamguedes@cbmerj.rj.gov.br',
            'password' => Hash::make('12345678'),
            'email_verified_at' => now(),
            'avatar' => 'assets/images/users/avatar-0.png',
            'grupo_id' => '1',
            'user_situacao_id' => '1',
            'user_tipo_id' => '1',
            'militar_id' => 28454,
            'created_at' => now()
        ]);

        User::create([
            'id' => 7,
            'name' => 'CAIO GUEDES DA SILVA',
            'user' => '46082',
            'email' => 'caioguedes@cbmerj.rj.gov.br',
            'password' => Hash::make('12345678'),
            'email_verified_at' => now(),
            'avatar' => 'assets/images/users/avatar-0.png',
            'grupo_id' => '1',
            'user_situacao_id' => '1',
            'user_tipo_id' => '1',
            'militar_id' => 28456,
            'created_at' => now()
        ]);

        User::create([
            'id' => 8,
            'name' => 'JOCINEI ALVES DE LACERDA',
            'user' => '19967',
            'email' => 'jocinei@cbmerj.rj.gov.br',
            'password' => Hash::make('12345678'),
            'email_verified_at' => now(),
            'avatar' => 'assets/images/users/avatar-0.png',
            'grupo_id' => '1',
            'user_situacao_id' => '1',
            'user_tipo_id' => '1',
            'militar_id' => 12502,
            'created_at' => now()
        ]);

        User::create([
            'id' => 9,
            'name' => 'JOANA CAMILO CESARIO',
            'user' => '53343',
            'email' => 'joanacamilo@cbmerj.rj.gov.br',
            'password' => Hash::make('12345678'),
            'email_verified_at' => now(),
            'avatar' => 'assets/images/users/avatar-0.png',
            'grupo_id' => '1',
            'user_situacao_id' => '1',
            'user_tipo_id' => '1',
            'militar_id' => 30532,
            'created_at' => now()
        ]);

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
