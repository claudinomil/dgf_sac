<?php

namespace App\Http\Controllers\Web;

use App\Domain\Esfera\EsferaService;
use App\Domain\RessarcimentoFuncao\RessarcimentoFuncaoService;
use App\Domain\Poder\PoderService;
use App\Http\Controllers\Controller;
use App\Domain\RessarcimentoOrgao\RessarcimentoOrgaoService;
use App\Domain\Tratamento\TratamentoService;
use App\Domain\Vocativo\VocativoService;
use App\Http\Requests\RessarcimentoOrgaoUpdateRequest;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;

class RessarcimentoOrgaoController extends Controller
{
    public function __construct(
        private RessarcimentoOrgaoService $ressarcimentoOrgaoService,
        private EsferaService $esferaService,
        private PoderService $poderService,
        private TratamentoService $tratamentoService,
        private VocativoService $vocativoService,
        private RessarcimentoFuncaoService $ressarcimentoFuncaoService
    ) {}

    public function index(Request $request)
    {
        // Requisição Ajax
        if ($request->ajax()) {
            $ressarcimento_orgaos = $this->ressarcimentoOrgaoService->getRessarcimentoOrgaos(1000);

            // Dados recebidos com sucesso
            if ($ressarcimento_orgaos) {
                return $this->datatable($ressarcimento_orgaos);
            } else {
                abort(500, 'Erro Interno RessarcimentoOrgaos');
            }
        } else {
            // Definir CRUD Sessions
            setCrudSessions('ressarcimento_orgaos');

            $esferas = $this->esferaService->getEsferas();
            $poderes = $this->poderService->getPoderes();
            $tratamentos = $this->tratamentoService->getTratamentos();
            $vocativos = $this->vocativoService->getVocativos();
            $ressarcimento_funcoes = $this->ressarcimentoFuncaoService->getRessarcimentoFuncoes();
            $ressarcimento_orgaos = $this->ressarcimentoOrgaoService->getRessarcimentoOrgaos();

            return view('ressarcimento_orgaos.index', compact(['esferas', 'poderes', 'tratamentos', 'vocativos', 'ressarcimento_funcoes', 'ressarcimento_orgaos']));
        }
    }

    public function filter(Request $request, $array_dados)
    {
        //Requisição Ajax
        if ($request->ajax()) {
            $ressarcimento_orgaos = $this->ressarcimentoOrgaoService->getRessarcimentoOrgaosFilter($array_dados, 1000);

            // Dados recebidos com sucesso
            if ($ressarcimento_orgaos) {
                return $this->datatable($ressarcimento_orgaos);
            } else {
                abort(500, 'Erro Interno RessarcimentoOrgaos');
            }
        } else {
            return view('ressarcimento_orgaos.index');
        }
    }

    public function datatable($registros)
    {
        $allData = DataTables::of($registros)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                return $this->columnAction($row['id']);
            })
            ->rawColumns(['action'])
            ->escapeColumns([])
            ->make(true);

        return $allData;
    }

    public function show(Request $request, $id)
    {
        // Verificando Origem enviada pelo Fetch
        if ($request->header('request-origin') == 'fetch') {
            $ressarcimento_orgao = $this->ressarcimentoOrgaoService->getRessarcimentoOrgao($id);

            if (!$ressarcimento_orgao) {
                return response()->json(['error' => 'Registro não encontrado']);
            }

            return response()->json(['success' => $ressarcimento_orgao]);
        }
    }

    public function store(Request $request)
    {
        $this->ressarcimentoOrgaoService->createRessarcimentoOrgao($request->all());

        return response()->json(['success' => 'Registro criado com sucesso']);
    }

    public function edit(Request $request, $id)
    {
        // Verificando Origem enviada pelo Fetch
        if ($request->header('request-origin') == 'fetch') {
            try {
                $ressarcimento_orgao = $this->ressarcimentoOrgaoService->editRessarcimentoOrgao($id);

                if (!$ressarcimento_orgao) {
                    return response()->json(['error' => 'Registro não encontrado'], 404);
                }

                return response()->json(['success' => $ressarcimento_orgao]);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 400);
            }
        }
    }

    public function update(RessarcimentoOrgaoUpdateRequest $request, $id)
    {
        try {
            $this->ressarcimentoOrgaoService->updateRessarcimentoOrgao($id, $request->all());

            return response()->json(['success' => 'Registro atualizado com sucesso']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
