<?php

namespace App\Domain\Permissao;

use App\Models\GrupoPermissao;
use App\Models\Permissao;

class PermissaoRepository
{
    public function all()
    {
        return Permissao::orderBy('name')->get();
    }

    public function getPermissoesGrupo(int $grupo_id)
    {
        return GrupoPermissao::join('permissoes','permissoes.id','grupos_permissoes.permissao_id')
            ->where('grupos_permissoes.grupo_id',$grupo_id)
            ->pluck('permissoes.name')
            ->toArray();
    }
}
