<?php

namespace Database\Seeders;

use App\Models\UserTipo;
use Illuminate\Database\Seeder;

class UserTiposSeeder extends Seeder
{
    public function run()
    {
        UserTipo::create(['name' => 'MILITAR']);
        UserTipo::create(['name' => 'CIVIL']);
    }
}
