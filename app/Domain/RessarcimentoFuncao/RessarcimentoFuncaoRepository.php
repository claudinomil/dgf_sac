<?php

namespace App\Domain\RessarcimentoFuncao;

use App\Models\RessarcimentoFuncao;

class RessarcimentoFuncaoRepository
{
    public function all()
    {
        return RessarcimentoFuncao::orderby('name')->get();
    }

    public function index($limit)
    {
        // Limit
        $limit = $limit ? $limit : 1000;

        return RessarcimentoFuncao::orderBy('name')->limit($limit)->get();
    }

    public function find($id)
    {
        return RessarcimentoFuncao::find($id);
    }}
