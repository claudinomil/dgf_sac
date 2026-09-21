<?php

namespace Database\Seeders;

use App\Models\AuxilioFardamentoTipo;
use Illuminate\Database\Seeder;

class AuxilioFardamentoTiposSeeder extends Seeder
{
    public function run()
    {
        AuxilioFardamentoTipo::create(['id' => 1, 'name' => 'POR MOVIMENTAÇÃO']);
        AuxilioFardamentoTipo::create(['id' => 2, 'name' => 'POR PROMOÇÃO']);
        AuxilioFardamentoTipo::create(['id' => 3, 'name' => 'POR CURSO']);
        AuxilioFardamentoTipo::create(['id' => 4, 'name' => '4 ANOS NA MESMA GRADUAÇÃO']);
        AuxilioFardamentoTipo::create(['id' => 5, 'name' => 'ART. 64, LEI 9537/2021']);
    }
}
