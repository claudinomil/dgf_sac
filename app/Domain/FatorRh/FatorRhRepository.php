<?php

namespace App\Domain\FatorRh;

use App\Models\FatorRh;

class FatorRhRepository
{
    public function all()
    {
        return FatorRh::orderby('name')->get();
    }
}
