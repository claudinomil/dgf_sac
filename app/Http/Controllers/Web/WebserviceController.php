<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Domain\Webservice\WebserviceService;
use Illuminate\Http\Request;

class WebserviceController extends Controller
{
    public function __construct(
        private WebserviceService $webserveceService
    ) {}

    /*
     * Evento: 1
     * Buscar Militar por campo e valor
     */
    public function militar(Request $request, $field, $value)
    {
        // Verificando Origem enviada pelo Fetch
        if ($request->header('request-origin') == 'fetch') {
            $militar = $this->webserveceService->getMilitar($field, $value);

            if (!$militar) {
                return response()->json(['error' => 'Registro não encontrado']);
            }

            return response()->json(['success' => $militar]);
        }
    }
}
