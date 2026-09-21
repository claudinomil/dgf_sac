<?php

namespace Database\Seeders;

use App\Models\Genero;
use Illuminate\Database\Seeder;

class GenerosSeeder extends Seeder
{
    public function run()
    {
        Genero::create(['id' => 1, 'name' => 'MASCULINO']);
        Genero::create(['id' => 2, 'name' => 'FEMININO']);
        Genero::create(['id' => 3, 'name' => 'NÃO BINÁRIO']);
        Genero::create(['id' => 4, 'name' => 'AGÊNERO']);
        Genero::create(['id' => 5, 'name' => 'PREFIRO NÃO INFORMAR']);
    }
}
