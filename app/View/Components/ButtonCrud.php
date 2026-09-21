<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ButtonCrud extends Component
{
    public $op;
    public $type;
    public $bgColor;
    public $textColor;
    public $class;
    public $dataBsToggle;
    public $dataBsPlacement;
    public $dataBsTarget;
    public $dataId;
    public $title;
    public $image;
    public $label;
    public $model;

    public function __construct($op = null, $type = "button", $bgColor = "", $textColor = "", $class = null, $dataBsToggle = "tooltip", $dataBsPlacement = "top", $dataBsTarget = "", $dataId = "0", $title = null, $image = null, $label = null, $model = 3)
    {
        $this->op = $op;
        $this->type = $type;
        $this->bgColor = $bgColor;
        $this->textColor = $textColor;
        $this->class = $class;
        $this->dataBsToggle = $dataBsToggle;
        $this->dataBsPlacement = $dataBsPlacement;
        $this->dataBsTarget = $dataBsTarget;
        $this->dataId = $dataId;
        $this->title = $title;
        $this->image = $image;
        $this->label = $label;
        $this->model = $model; //1(Default) 2(Snip) 3(Icon)
    }

    public function render()
    {
        //Modelo do Botão
        if ($this->model == 1) {
            $modelClass = "";
            $imageClass = "";
        }

        if ($this->model == 2) {
            $modelClass = "waves-effect waves-light";
            $imageClass = "font-size-16 align-middle me-2";
        }

        if ($this->model == 3) {
            $modelClass = "waves-effect btn-label waves-light";
            $imageClass = "label-icon";
        }

        //Botão Incluir Registro (CRUD)
        if ($this->op == 1) {
            $this->title = __('Adicionar Registro');
            $this->label = __('Adicionar');

            //Modelo do Botão
            if ($this->model == 2 or $this->model == 3) {
                $this->image = "bx bx-plus ".$imageClass;
            }

            $this->class = "btn btn-sm btn-success text-white mb-2 font-size-12 ".$modelClass." ".$this->class;
        }

        //Botão Alterar Registro (CRUD)
        if ($this->op == 2) {
            $this->title = __('Alterar Registro');
            $this->label = __('Alterar');

            //Modelo do Botão
            if ($this->model == 2 or $this->model == 3) {
                $this->image = "fas fa-pencil-alt ".$imageClass;
            }

            $this->class = "btn btn-sm btn-primary text-white mb-2 font-size-12 ".$modelClass." ".$this->class;
        }

        //Botão Excluir Registro (CRUD)
        if ($this->op == 3) {
            $this->title = __('Excluir Registro');
            $this->label = __('Excluir');

            //Modelo do Botão
            if ($this->model == 2 or $this->model == 3) {
                $this->image = "fa fa-trash-alt ".$imageClass;
            }

            $this->class = "btn btn-sm btn-danger text-white mb-2 font-size-12 ".$modelClass." ".$this->class;
        }

        //Botão Cancelar Operação (CRUD)
        if ($this->op == 4) {
            $this->title = __('Cancelar Operação');
            $this->label = __('Cancelar');

            //Modelo do Botão
            if ($this->model == 2 or $this->model == 3) {
                $this->image = "fa fa-arrow-left ".$imageClass;
            }

            $this->class = "btn btn-sm btn-secondary text-white mb-2 font-size-12 ".$modelClass." ".$this->class;
        }

        //Botão Confirmar Operação (CRUD)
        if ($this->op == 5) {
            $this->title = __('Confirmar Operação');
            $this->label = __('Confirmar');

            //Modelo do Botão
            if ($this->model == 2 or $this->model == 3) {
                $this->image = "fa fa-save ".$imageClass;
            }

            $this->class = "btn btn-sm btn-success text-white mb-2 font-size-12 ".$modelClass." ".$this->class;
        }

        //Botão Pesquisar no Banco (CRUD) - min
        if ($this->op == 6) {
            $this->title = __('Pesquisar no Banco de Dados');
            $this->image = "fa fa-arrow-right";
            $this->label = "";
            $this->class = "btn btn-sm btn-success text-white text-center mb-2 font-size-12 ".$this->class;
        }

        //Botão Info (CRUD)
        if ($this->op == 7) {
            $this->dataBsToggle = "modal";
            $this->dataBsPlacement = "";
            $this->dataBsTarget = $this->dataBsTarget;
            $this->title = __('Informações');
            $this->label = __('Info');

            //Modelo do Botão
            if ($this->model == 2 or $this->model == 3) {
                $this->image = "bx bx-photo-album ".$imageClass;
            }

            $this->class = "btn btn-sm btn-warning text-white mb-2 font-size-12 ".$modelClass." ".$this->class;
        }

        //Botão Customizado
        if ($this->op == 99) {
            //Classe de Cor de Fundo
            if ($this->bgColor != '') {$this->bgColor = "btn-".$this->bgColor;}

            //Classe de Cor do Texto
            if ($this->textColor != '') {$this->textColor = "text-".$this->textColor;}

            //Modelo do Botão
            if ($this->model == 2 or $this->model == 3) {
                $this->image = $this->image." ".$imageClass;
            }

            //Class
            $this->class = "btn mb-2 font-size-12 ".$this->bgColor." ".$this->textColor." ".$modelClass." ".$this->class;
        }

        //Return View
        return view('components.button-crud');
    }
}
