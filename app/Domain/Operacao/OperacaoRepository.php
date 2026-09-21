<?php

namespace App\Domain\Operacao;

use App\Models\Operacao;

class OperacaoRepository
{
    public function all()
    {
        return Operacao::orderby('name')->get();
    }

    public function index(int $limit)
    {
        // Limit
        $limit = $limit ? $limit : 1000;

        return Operacao::orderBy('name')->limit($limit)->get();
    }
}
