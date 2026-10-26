<?php

namespace Database\Seeders;

use App\Models\DashboardTvControle;
use Illuminate\Database\Seeder;

class DashboardTvControleSeeder extends Seeder
{
    public function run()
    {
        DashboardTvControle::create(['id' => 1, 'unidade_id' => 46, 'ano' => 2026]);
    }
}