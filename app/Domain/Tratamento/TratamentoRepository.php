<?php

namespace App\Domain\Tratamento;

use App\Models\Tratamento;

class TratamentoRepository
{
    public function index($limit)
    {
        // Limit
        $limit = $limit ? $limit : 1000;

        return Tratamento::orderBy('completo')->limit($limit)->get();
    }

    public function find($id)
    {
        return Tratamento::find($id);
    }
}
