<?php

namespace App\Domain\Esfera;

use App\Models\Esfera;

class EsferaRepository
{
    public function index($limit)
    {
        // Limit
        $limit = $limit ? $limit : 1000;

        return Esfera::orderBy('name')->limit($limit)->get();
    }

    public function find($id)
    {
        return Esfera::find($id);
    }
}
