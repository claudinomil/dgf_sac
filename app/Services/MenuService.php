<?php

namespace App\Services;

use Illuminate\Support\Facades\Route;

class MenuService
{
    public function getMenu($tp)
    {
        $menu = '';

        $context = session('userContext');

        if (!$context) {
            return '';
        }

        $modulos = $context['modulos'] ?? [];
        $submodulos = $context['submodulos'] ?? [];

        // Menu Vertical - Início''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        // Menu Vertical - Início''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        if ($tp == 1) {
            // Descobrir módulo ativo
            $moduloIdActive = 0;
            foreach ($submodulos as $dado) {
                if ($dado['menu_route'] . '.index' == 'breadcrumbCurrentPageRoute') {
                    $moduloIdActive = $dado['modulo_id'];
                }
            }

            $menu .= "<ul class='metismenu list-unstyled' id='side-menu'>
                        <li class='menu-title' key='t-menu'>" . __('Menu') . "</li>";

            // Varrer Módulos
            foreach ($modulos as $modulo) {
                $modOk = 1;

                // Menu Setor
                $menu_setor = $modulo['setorName'];
                $menu_setor_icon = $modulo['setorMenuIcon'];

                // Varrer Submódulos
                foreach ($submodulos as $submodulo) {
                    if ($modulo['id'] == $submodulo['modulo_id']) {
                        $permitido = temPermissao($submodulo['prefix_permissao'] . '_list');

                        if ($permitido) {
                            if ($modOk == 1) {
                                $modOk = 0;

                                // li_active
                                $li_active = '';
                                if ($modulo['id'] == $moduloIdActive) {
                                    $li_active = 'mm-active';
                                }

                                if ($menu_setor != '') {
                                    $menu .= "<li>
                                                <a href='javascript: void(0);' class='has-arrow waves-effect text-decoration-none'>
                                                    <i class='" . $menu_setor_icon . "' style='font-size:16px;'></i><span>&nbsp;&nbsp;" . __($menu_setor) . "</span>
                                                </a>
                                                <ul class='sub-menu' aria-expanded='true'>";
                                }

                                $menu .= "<li class='" . $li_active . "'>
                                        <a href='javascript: void(0);' class='has-arrow waves-effect text-decoration-none'>
                                            <i class='" . $modulo['menu_icon'] . "' style='font-size:16px;'></i><span key='t-" . $modulo['menu_route'] . "'>&nbsp;&nbsp;" . __($modulo['menu_text']) . "</span>
                                        </a>
                                        <ul class='sub-menu' aria-expanded='true'>";
                            }

                            $active = '';

                            if ($submodulo['menu_route'] . '.index' == 'breadcrumbCurrentPageRoute') {
                                $active = 'active';
                            }

                            // Verificar se existe rota submodulo.index
                            if (Route::has($submodulo['menu_route'] . '.index')) {
                                $menu .= "<li><a href='" . route($submodulo['menu_route'] . '.index') . "' class='" . $active . " text-decoration-none' key='t-" . $submodulo['menu_route'] . "'><i class='" . $submodulo['menu_icon'] . " font-size-10'></i>" . __($submodulo['menu_text']) . "</a></li>";
                            }
                        }
                    }
                }

                if ($modOk == 0) {
                    $menu .= "</ul></li>";

                    if ($menu_setor != '') {
                        $menu .= "</ul></li>";
                    }
                }
            }

            $menu .= "</ul>";
        }
        // Menu Vertical - Fim'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        // Menu Vertical - Fim'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        // Menu Horizontal - Início''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        // Menu Horizontal - Início''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        if ($tp == 2) {
            // Descobrir módulo ativo
            $moduloIdActive = 0;
            foreach ($submodulos as $dado) {
                if ($dado['menu_route'] . '.index' == 'breadcrumbCurrentPageRoute') {
                    $moduloIdActive = $dado['modulo_id'];
                }
            }

            $menu .= "<ul class='navbar-nav' id='top-menu'>";

            // Varrer Módulos
            foreach ($modulos as $modulo) {
                $modOk = 1;

                // Varrer Submódulos
                foreach ($submodulos as $submodulo) {
                    if ($modulo['id'] == $submodulo['modulo_id']) {
                        $permitido = temPermissao($submodulo['prefix_permissao'] . '_list');

                        if ($permitido) {
                            if ($modOk == 1) {
                                $modOk = 0;

                                // li_active
                                $li_active = '';
                                if ($modulo['id'] == $moduloIdActive) {
                                    $li_active = 'mm-active';
                                }

                                $menu .= "<li class='nav-item dropdown " . $li_active . "'>
                                            <a class='nav-link dropdown-toggle text-decoration-none d-flex align-items-center' href='#' id='topnav-layout' role='button'>
                                                <i class='" . $modulo['menu_icon'] . " me-2'></i><span key='t-" . $modulo['menu_route'] . "'>" . __($modulo['menu_text']) . "</span>
                                            </a>
                                            <div class='dropdown-menu'>";
                            }

                            // Verificar se existe rota submodulo.index
                            if (Route::has($submodulo['menu_route'] . '.index')) {
                                $menu .= "<a href='" . route($submodulo['menu_route'] . '.index') . "' class='dropdown-item text-decoration-none d-flex align-items-center' key='t-" . $submodulo['menu_route'] . "'><i class='" . $submodulo['menu_icon'] . " me-2'></i>" . __($submodulo['menu_text']) . "</a>";
                            }
                        }
                    }
                }

                if ($modOk == 0) {
                    $menu .= "</div></li>";
                }
            }

            $menu .= "</ul>";
        }
        // Menu Horizontal - Fim'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        // Menu Horizontal - Fim'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        return $menu;
    }
}