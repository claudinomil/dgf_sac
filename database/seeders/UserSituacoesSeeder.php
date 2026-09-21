<?php

namespace Database\Seeders;

use App\Models\UserSituacao;
use Illuminate\Database\Seeder;

class UserSituacoesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserSituacao::create(['name' => 'Liberado', 'bg_badge' => 'success']);
        UserSituacao::create(['name' => 'Bloqueado', 'bg_badge' => 'danger']);
    }
}
