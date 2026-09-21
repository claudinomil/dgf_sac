<?php

namespace Database\Seeders;

use App\Models\RessarcimentoFuncao;
use Illuminate\Database\Seeder;

class RessarcimentoFuncoesSeeder extends Seeder
{
    public function run()
    {
        RessarcimentoFuncao::create(['id' => 1, 'name' => 'COMANDANTE', 'ordem_visualizacao' => 10]);
        RessarcimentoFuncao::create(['id' => 2, 'name' => 'SUBCOMANDANTE', 'ordem_visualizacao' => 20]);
        RessarcimentoFuncao::create(['id' => 3, 'name' => 'DIRETOR', 'ordem_visualizacao' => 30]);
        RessarcimentoFuncao::create(['id' => 4, 'name' => 'SUBDIRETOR', 'ordem_visualizacao' => 40]);
        RessarcimentoFuncao::create(['id' => 5, 'name' => 'CHEFE', 'ordem_visualizacao' => 50]);
        RessarcimentoFuncao::create(['id' => 6, 'name' => 'SUBCHEFE', 'ordem_visualizacao' => 60]);
        RessarcimentoFuncao::create(['id' => 7, 'name' => 'Defensor(a) Público(a)', 'ordem_visualizacao' => 70]);
        RessarcimentoFuncao::create(['id' => 8, 'name' => 'Deputado(a) Estadual', 'ordem_visualizacao' => 80]);
        RessarcimentoFuncao::create(['id' => 9, 'name' => 'Governador(a)', 'ordem_visualizacao' => 90]);
        RessarcimentoFuncao::create(['id' => 10, 'name' => 'Prefeito(a)', 'ordem_visualizacao' => 100]);
        RessarcimentoFuncao::create(['id' => 11, 'name' => 'Presidente', 'ordem_visualizacao' => 110]);
        RessarcimentoFuncao::create(['id' => 12, 'name' => 'Procurador(a)-Geral', 'ordem_visualizacao' => 120]);
        RessarcimentoFuncao::create(['id' => 13, 'name' => 'Secretário(a)', 'ordem_visualizacao' => 130]);
        RessarcimentoFuncao::create(['id' => 14, 'name' => 'Vereador(a)', 'ordem_visualizacao' => 140]);
    }
}
