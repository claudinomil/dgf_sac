<?php

namespace Database\Seeders;

use App\Models\AjudaCustoTipo;
use Illuminate\Database\Seeder;

class AjudaCustoTiposSeeder extends Seeder
{
    public function run()
    {
        AjudaCustoTipo::create(['id' => 1, 'name' => 'POR MOVIMENTAÇÃO']);
        AjudaCustoTipo::create(['id' => 2, 'name' => 'POR CURSO']);
    }
}
