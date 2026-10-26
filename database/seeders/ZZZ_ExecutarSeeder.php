<?php

namespace Database\Seeders;

use App\Models\Permissao;
use App\Models\Submodulo;
use Illuminate\Database\Seeder;

class ZZZ_ExecutarSeeder extends Seeder
{
    /*
     * Seeder para Executar quando não quero rodar o "php artisan migrate:fresh --seed" e zerar tudo
     * Faz somente algumas operações uma unica vez
     * php artisan db:seed --class=ZZZ_ExecutarSeeder
     */
    public function run()
    {
        // Dashboards TVs'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        Submodulo::where('id', 8881)->update(['menu_url' => 'dashboards_tvs_controles', 'menu_route' => 'dashboards_tvs_controles', 'prefix_permissao' => 'dashboards_tvs_controles', 'prefix_route' => 'dashboards_tvs_controles']);
        Permissao::where('id', 8881)->update(['name' => 'dashboards_tvs_controles_list']);
        Permissao::where('id', 8884)->update(['name' => 'dashboards_tvs_controles_edit']);
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    }
}