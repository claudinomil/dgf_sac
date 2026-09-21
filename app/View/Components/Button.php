<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Button extends Component
{
    public $op;
    public $type;
    public $bgColor;
    public $textColor;
    public $class;
    public $dataBsToggle;
    public $dataBsPlacement;
    public $dataId;
    public $title;
    public $imageAwesome;
    public $label;

    public function __construct($op = NULL, $type = NULL, $bgColor = NULL, $textColor = NULL, $class = NULL, $dataBsToggle = NULL, $dataBsPlacement = NULL, $dataId = NULL, $title = NULL, $imageAwesome = NULL, $label = NULL)
    {
        $this->op = $op;
        $this->type = $type;
        $this->bgColor = $bgColor;
        $this->textColor = $textColor;
        $this->class = $class;
        $this->dataBsToggle = $dataBsToggle;
        $this->dataBsPlacement = $dataBsPlacement;
        $this->dataId = $dataId;
        $this->title = $title;
        $this->imageAwesome = $imageAwesome;
        $this->label = $label;
    }

    public function render()
    {
        return view('components.button');
    }
}
