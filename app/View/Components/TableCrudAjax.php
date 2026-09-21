<?php

namespace App\View\Components;

use Illuminate\View\Component;

class TableCrudAjax extends Component
{
    public $tableColsNames = [];

    public function __construct(array $colsNames)
    {
        $this->tableColsNames = $colsNames;
    }

    public function render()
    {
        return view('components.table-crud-ajax');
    }
}
