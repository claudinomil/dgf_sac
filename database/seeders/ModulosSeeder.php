<?php

namespace Database\Seeders;

use App\Models\Modulo;
use Illuminate\Database\Seeder;

class ModulosSeeder extends Seeder
{
    public function run()
    {
        // Geral
        Modulo::create(['id' => 1, 'setor_id' => null, 'name' => 'Home', 'menu_text' => 'Home', 'menu_url' => 'home', 'menu_route' => 'home', 'menu_icon' => 'fa fa-home', 'ordem_visualizacao' => 10]);
        Modulo::create(['id' => 2, 'setor_id' => null, 'name' => 'Auxiliares', 'menu_text' => 'Auxiliares', 'menu_url' => 'auxiliares', 'menu_route' => 'auxiliares', 'menu_icon' => 'fa fa-list', 'ordem_visualizacao' => 20]);
        Modulo::create(['id' => 5, 'setor_id' => null, 'name' => 'Efetivo', 'menu_text' => 'Efetivo', 'menu_url' => 'efetivo', 'menu_route' => 'efetivo', 'menu_icon' => 'fa fa-users', 'ordem_visualizacao' => 30]);

        // DGF/1

        // DGF/2
        Modulo::create(['id' => 3, 'setor_id' => 2, 'name' => 'Ressarcimento', 'menu_text' => 'Ressarcimento', 'menu_url' => 'ressarcimentos', 'menu_route' => 'ressarcimentos', 'menu_icon' => 'fas fa-file-invoice-dollar', 'ordem_visualizacao' => 40]);

        // DGF/3

        // DGF/4

        // Pagadoria

        // Diretoria

        // SAD
        Modulo::create(['id' => 7, 'setor_id' => 7, 'name' => 'Militares', 'menu_text' => 'Militares', 'menu_url' => 'sad_militares', 'menu_route' => 'sad_militares', 'menu_icon' => 'fa fa-users', 'ordem_visualizacao' => 10]);

        // Homologação
        Modulo::create(['id' => 999, 'setor_id' => 999, 'name' => 'Homologação', 'menu_text' => 'Homologação', 'menu_url' => 'homologacao', 'menu_route' => 'homologacao', 'menu_icon' => 'fas fa-award', 'ordem_visualizacao' => 999]);
    }
}
