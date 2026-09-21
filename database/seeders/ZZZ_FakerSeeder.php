<?php

namespace Database\Seeders;

use App\Models\Transacao;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ZZZ_FakerSeeder extends Seeder
{
    public function run()
    {
        $faker = \Faker\Factory::create('pt_BR');

        // Usuários
        for($i=1; $i<=10; $i++) {
            User::create([
                'user' => $faker->numberBetween(27336, 28000),
                'name' => $faker->name,
                'email' => $faker->email,
                'user_situacao_id' => $faker->numberBetween(1, 2),
                'user_tipo_id' => $faker->numberBetween(1, 2),
                'grupo_id' => $faker->numberBetween(1, 5),
                'password' => Hash::make('12345678'),
                'email_verified_at' => now(),
                'avatar' => 'assets/images/users/avatar-0.png',
                'created_at' => now()
            ]);
        }

        // Transações
        for($i=1; $i<=50; $i++) {
            Transacao::create([
                'date' => $faker->date(),
                'time' => $faker->time(),
                'user_id' => $faker->numberBetween(1, 11),
                'operacao_id' => $faker->numberBetween(1, 3),
                'submodulo_id' => $faker->numberBetween(6, 14),
                'dados' => []
            ]);
        }
    }
}
