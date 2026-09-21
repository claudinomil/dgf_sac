<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Domain\User\UserService;
use App\Domain\Grupo\GrupoService;
use App\Domain\UserSituacao\UserSituacaoService;
use App\Domain\UserContext\UserContextService;
use App\Domain\UserTipo\UserTipoService;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(
        private UserService $userService,
        private GrupoService $grupoService,
        private UserSituacaoService $userSituacaoService,
        private UserTipoService $userTipoService,
        private UserContextService $userContextService
    ) {}

    public function index(Request $request)
    {
        // Requisição Ajax
        if ($request->ajax()) {
            $users = $this->userService->getUsers(1000);

            // Dados recebidos com sucesso
            if ($users) {
                return $this->datatable($users);
            } else {
                abort(500, 'Erro Interno User');
            }
        } else {
            // Definir CRUD Sessions
            setCrudSessions('users');

            $grupos = $this->grupoService->getGrupos(9999);
            $userSituacoes = $this->userSituacaoService->getUserSituacoes();
            $userTipos = $this->userTipoService->getUserTipos();

            return view('users.index', compact(['grupos', 'userSituacoes', 'userTipos']));
        }
    }

    public function filter(Request $request, $array_dados)
    {
        //Requisição Ajax
        if ($request->ajax()) {
            $users = $this->userService->getUsersFilter($array_dados, 1000);

            // Dados recebidos com sucesso
            if ($users) {
                return $this->datatable($users);
            } else {
                abort(500, 'Erro Interno User');
            }
        } else {
            return view('users.index');
        }
    }

    public function datatable($registros)
    {
        $allData = DataTables::of($registros)
            ->addIndexColumn()
            ->editColumn('avatar', function ($row) {
                if (session('userContext.user.id') == $row['id']) {
                    $classImg = 'url_user_avatar';
                } else {
                    $classImg = '';
                }

                $retorno = "<div class='text-center'>";
                $retorno .= "<img src='" . asset($row['avatar']) . "' alt='' class='img-thumbnail rounded-circle avatar-sm " . $classImg . "'>";
                $retorno .= "<br>";
                $retorno .= "<button type='button' class='btn btn-sm text-secondary' data-bs-toggle='tooltip' data-bs-placement='top' title='Visualizar Perfil' onclick='crudOffCanvaProfilleView(1, " . $row['id'] . ");'><i class='fas fa-info-circle font-size-20'></i></button>";
                $retorno .= "</div>";

                return $retorno;
            })
            ->addColumn('action', function ($row) {
                return $this->columnAction($row['id']);
            })
            ->rawColumns(['action'])
            ->escapeColumns([])
            ->make(true);

        return $allData;
    }

    public function create()
    {
        //Verificando Origem enviada pelo Fetch
        if ($_SERVER['HTTP_REQUEST_ORIGIN'] == 'fetch') {
            return response()->json(['success' => true]);
        }
    }

    public function show(Request $request, $id)
    {
        // Verificando Origem enviada pelo Fetch
        if ($request->header('request-origin') == 'fetch') {
            $user = $this->userService->getUser($id);

            if (!$user) {
                return response()->json(['error' => 'Registro não encontrado']);
            }

            return response()->json(['success' => $user]);
        }
    }

    public function store(UserStoreRequest $request)
    {
        $this->userService->createUser($request->all());

        return response()->json(['success' => 'Registro criado com sucesso']);
    }

    public function edit(Request $request, $id)
    {
        // Verificando Origem enviada pelo Fetch
        if ($request->header('request-origin') == 'fetch') {
            try {
                $user = $this->userService->editUser($id);

                if (!$user) {
                    return response()->json(['error' => 'Registro não encontrado'], 404);
                }

                return response()->json(['success' => $user]);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 400);
            }
        }
    }

    public function update(UserUpdateRequest $request, $id)
    {
        try {
            $this->userService->updateUser($id, $request->all());

            // Se alteração é no Usuário Logado chama Refresh do UserContext
            if (session('userContext.user.id') == $id) {
                $this->userContextService->refresh();
            }

            return response()->json(['success' => 'Registro atualizado com sucesso']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function destroy(int $id)
    {
        try {
            $this->userService->deleteUser($id);

            return response()->json(['success' => 'Registro excluído com sucesso']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
