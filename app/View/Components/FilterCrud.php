<?php

namespace App\View\Components;

use Illuminate\View\Component;

class FilterCrud extends Component
{
    public $selectCampoPesquisar;

    public function __construct($selectCampoPesquisar)
    {
        $this->selectCampoPesquisar = $selectCampoPesquisar;
    }

    public function render()
    {
        return view('components.filter-crud');
    }
}
