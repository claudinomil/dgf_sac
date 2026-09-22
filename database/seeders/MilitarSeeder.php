<?php

namespace Database\Seeders;

use App\Models\Militar;
use Illuminate\Database\Seeder;

class MilitarSeeder extends Seeder
{
    public function run()
    {
        Militar::create(['id' => 15661, 'nome' => 'CRISTIANO PINTO DOS SANTOS', 'rg' => '00/0024.862']);
        Militar::create(['id' => 20023, 'nome' => 'LEONARDO COELHO MORAES DE ABREU', 'rg' => '00/0035.714']);
        Militar::create(['id' => 20051, 'nome' => 'EDUARDO FERREIRA GONCALVES', 'rg' => '00/0036.604']);
        Militar::create(['id' => 19940, 'nome' => 'THIAGO OLIVEIRA BATISTA', 'rg' => '00/0034.012']);
        Militar::create(['id' => 28454, 'nome' => 'WILLIAM GUEDES DA SILVA', 'rg' => '00/0046.085']);
        Militar::create(['id' => 28456, 'nome' => 'CAIO GUEDES DA SILVA', 'rg' => '00/0046.082']);
        Militar::create(['id' => 12502, 'nome' => 'JOCINEI ALVES DE LACERDA', 'rg' => '00/0019.967']);
        Militar::create(['id' => 30532, 'nome' => 'JOANA CAMILO CESARIO', 'rg' => '00/0053.343']);
        Militar::create(['id' => 16509, 'nome' => 'CLAUDINO MIL HOMENS DE MORAES', 'rg' => '00/0027.335']);
    }
}
