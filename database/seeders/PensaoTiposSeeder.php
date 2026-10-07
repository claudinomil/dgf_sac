<?php

namespace Database\Seeders;

use App\Models\PensaoTipo;
use Illuminate\Database\Seeder;

class PensaoTiposSeeder extends Seeder
{
    public function run()
    {
        PensaoTipo::create(['id' => 1, 'name' => 'ALIMENTÍCIA']);
        PensaoTipo::create(['id' => 2, 'name' => 'PÓS MORTE']);
        PensaoTipo::create(['id' => 3, 'name' => 'PROVISÓRIA']);
    }
}
