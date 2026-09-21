<?php

namespace Database\Seeders;

use App\Models\Militar;
use Illuminate\Database\Seeder;

class MilitarSeeder extends Seeder
{
    public function run()
    {
        Militar::create([
            'id' => 16509,
            'nome' => 'CLAUDINO MIL HOMENS DE MORAES',
            'rg' => '00/0027.335'
        ]);
    }
}
