<?php

namespace App\Domain\Vocativo;

use App\Models\Vocativo;

class VocativoRepository
{
    public function index($limit)
    {
        // Limit
        $limit = $limit ? $limit : 1000;

        return Vocativo::orderBy('name')->limit($limit)->get();
    }

    public function find($id)
    {
        return Vocativo::find($id);
    }
}
