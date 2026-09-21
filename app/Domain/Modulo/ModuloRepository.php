<?php

namespace App\Domain\Modulo;

use App\Models\Modulo;

class ModuloRepository
{
    public function getModulosMenu()
    {
        return Modulo::leftJoin('setores', 'setores.id', 'modulos.setor_id')
            ->select(
                'modulos.*',
                'setores.name as setorName',
                'setores.menu_icon as setorMenuIcon'
            )
            ->orderBy('setores.ordem_visualizacao')
            ->orderBy('modulos.ordem_visualizacao')
            ->get();
    }
}
