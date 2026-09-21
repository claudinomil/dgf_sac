<?php

namespace App\Domain\Submodulo;

use App\Models\Submodulo;
use Illuminate\Support\Facades\Schema;

class SubmoduloRepository
{
    public function all()
    {
        return Submodulo::orderBy('name')->get();
    }

    public function getSubmodulosMenu()
    {
        return Submodulo::orderBy('ordem_visualizacao')->get();
    }

    public function getSubmodulosGradeGrupos()
    {
        return Submodulo::join('modulos', 'modulos.id', 'submodulos.modulo_id')
            ->select('submodulos.*')
            ->orderBy('modulos.ordem_visualizacao')
            ->orderBy('submodulos.ordem_visualizacao')
            ->get();
    }

    public function getSubmoduloPrefixPermissao($prefix_permissao)
    {
        return Submodulo::where('prefix_permissao', $prefix_permissao)->first();
    }

    public function getColumnListing($prefix_permissao)
    {
        return Schema::getColumnListing($prefix_permissao);
    }
}
