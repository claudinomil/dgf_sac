<?php

namespace App\Domain\Poder;

use App\Models\Poder;

class PoderRepository
{
    public function index($limit)
    {
        // Limit
        $limit = $limit ? $limit : 1000;

        return Poder::orderBy('name')->limit($limit)->get();
    }

    public function find($id)
    {
        return Poder::find($id);
    }
}
