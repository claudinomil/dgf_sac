<?php

namespace App\Http\Controllers;

abstract class Controller
{
    /*
     * Função para retornar Botões para a coluna Ações da tabela de registros do CRUD
     */
    public function columnAction(int $id, int $botoes=7, int $excluido=0)
    {
        // @PARAN: $botoes
        // 0: Nenhum Botão
        // 1: Somente Visualização
        // 2: Somente Alteração
        // 3: Somente Exclusão
        // 4: Visualização e Alteração
        // 5: Visualização e Exclusão
        // 6: Alteração e Exclusão
        // 7: Visualização, Alteração e Exclusão

        // Registro Excluído (Somente Visualização)
        $registroExcluido = '';
        if ((int) $excluido === 1) {
            $botoes = match ($botoes) {
                0 => 0,
                1 => 1,
                2 => 0,
                3 => 0,
                4 => 1,
                5 => 1,
                6 => 1,
                7 => 1,
                default => $botoes
            };

            $registroExcluido = '<div class="col-12 badge bg-danger mt-2"><b>Registro Excluído</b></div>';
        }

        // Prefixo Permissão
        $prefixPermissao = session('crudPrefixPermissaoSubmodulo');

        //Montando Coluna Ação
        $btn = '<td class="text-center" style="vertical-align:top;">';
        $btn .= '<div class="d-flex gap-1">';

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

        $btn .= '<button type="button" class="btn btn-sm text-indigo" data-bs-toggle="tooltip" data-bs-placement="top" title="Visualizar Transações" onclick="crudTransacoes(' . $id . ');"><i class="fa fa-clock-rotate-left font-size-20"></i></button>';

        $btn .= '</div>';
        $btn .= '</td>';

        $btn .= $registroExcluido;

        return $btn;
    }
}
