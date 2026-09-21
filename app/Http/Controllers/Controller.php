<?php

namespace App\Http\Controllers;

abstract class Controller
{
    /*
     * Função para retornar Botões para a coluna Ações da tabela de registros do CRUD
     */
    public function columnActionANTERIOR(string $id, $botoes=7)
    {
        //PARAN: $botoes
        //0: Nenhum Botão
        //1: Somente Visualização
        //2: Somente Alteração
        //3: Somente Exclusão
        //4: Visualização e Alteração
        //5: Visualização e Exclusão
        //6: Alteração e Exclusão
        //7: Visualização, Alteração e Exclusão

        //Montando Coluna Ação
        $btn = '<td class="text-center" style="vertical-align:top;"><div class="row">';

        if ($botoes == 1 or $botoes == 4 or $botoes == 5 or $botoes == 7) {
            if (temPermissao('users_show')) {
                $btn .= '<div class="col-12 col-md-4 pb-2"><button type="button" class="btn btn-outline-info text-center btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Visualizar Registro" onclick="crudView(' . $id . ');"><i class="fa fa-eye font-size-18"></i></button></div>';
            }
        }

        if ($botoes == 2 or $botoes == 4 or $botoes == 6 or $botoes == 7) {
            if (temPermissao('users_edit')) {
                $btn .= '<div class="col-12 col-md-4 pb-2"><button type="button" class="btn btn-outline-primary text-center btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Alterar Registro" onclick="crudEdit(' . $id . ');"><i class="fas fa-pencil-alt font-size-18"></i></button></div>';
            }
        }

        if ($botoes == 3 or $botoes == 5 or $botoes == 6 or $botoes == 7) {
            if (temPermissao('users_destroy')) {
                $btn .= '<div class="col-12 col-md-4 pb-2"><button type="button" class="btn btn-outline-danger text-center btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Excluir Registro" onclick="crudDelete(' . $id . ');"><i class="fa fa-trash-alt font-size-18"></i></button></div>';
            }
        }

        $btn .= '</div></td>';

        return $btn;
    }

        public function columnAction(string $id, $botoes=7)
    {
        //PARAN: $botoes
        //0: Nenhum Botão
        //1: Somente Visualização
        //2: Somente Alteração
        //3: Somente Exclusão
        //4: Visualização e Alteração
        //5: Visualização e Exclusão
        //6: Alteração e Exclusão
        //7: Visualização, Alteração e Exclusão

        $prefixPermissao = session('crudPrefixPermissaoSubmodulo');

        //Montando Coluna Ação
        $btn = '<td class="text-center" style="vertical-align:top;"><div class="d-flex gap-1">';

        if ($botoes == 1 or $botoes == 4 or $botoes == 5 or $botoes == 7) {
            if (temPermissao($prefixPermissao.'_show')) {
                $btn .= '<button type="button" class="btn btn-sm text-info" data-bs-toggle="tooltip" data-bs-placement="top" title="Visualizar Registro" onclick="crudView(' . $id . ');"><i class="fa fa-eye font-size-20"></i></button>';
            }
        }

        if ($botoes == 2 or $botoes == 4 or $botoes == 6 or $botoes == 7) {
            if (temPermissao($prefixPermissao.'_edit')) {
                $btn .= '<button type="button" class="btn btn-sm text-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar Registro" onclick="crudEdit(' . $id . ');"><i class="fas fa-pencil-alt font-size-20"></i></button>';
            }
        }

        if ($botoes == 3 or $botoes == 5 or $botoes == 6 or $botoes == 7) {
            if (temPermissao($prefixPermissao.'_destroy')) {
                $btn .= '<button type="button" class="btn btn-sm text-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Excluir Registro" onclick="crudDelete(' . $id . ');"><i class="fa fa-trash-alt font-size-20"></i></button>';
            }
        }

        $btn .= '</div></td>';

        return $btn;
    }
}
