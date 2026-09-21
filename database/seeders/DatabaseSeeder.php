<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $this->call([
            AjudaCustoTiposSeeder::class,
            AuxilioFardamentoTiposSeeder::class,
            GenerosSeeder::class,
            SetoresSeeder::class,
            ModulosSeeder::class,
            SubmodulosSeeder::class,
            GruposSeeder::class,
            PermissoesSeeder::class,
            GrupoPermissoesSeeder::class,
            MilitarSeeder::class,
            UserSituacoesSeeder::class,
            OperacoesSeeder::class,
            UserTiposSeeder::class,
            UserSeeder::class,
            EsferasSeeder::class,
            PoderesSeeder::class,
            TratamentosSeeder::class,
            VocativosSeeder::class,
            RessarcimentoFuncoesSeeder::class,
            RessarcimentoOrgaosSeeder::class,
            ZZZ_20260514_Seeder::class,

            ZZZ_FakerSeeder::class
        ]);
    }
}
