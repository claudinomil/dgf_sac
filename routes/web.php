<?php

use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\GrupoController;
use App\Http\Controllers\Web\IntegracaoController;
use App\Http\Controllers\Web\MilitarContatoController;
use App\Http\Controllers\Web\MilitarAjudaCustoController;
use App\Http\Controllers\Web\MilitarAuxilioFardamentoController;
use App\Http\Controllers\Web\MilitarController;
use App\Http\Controllers\Web\MilitarCursoController;
use App\Http\Controllers\Web\MilitarDependenteController;
use App\Http\Controllers\Web\MilitarFundoSaudeController;
use App\Http\Controllers\Web\ProfileController;
use App\Http\Controllers\Web\RelatorioController;
use App\Http\Controllers\Web\RessarcimentoCobrancaController;
use App\Http\Controllers\Web\RessarcimentoConfiguracaoController;
use App\Http\Controllers\Web\RessarcimentoExclusaoController;
use App\Http\Controllers\Web\RessarcimentoMilitarController;
use App\Http\Controllers\Web\RessarcimentoOrgaoController;
use App\Http\Controllers\Web\RessarcimentoPagamentoController;
use App\Http\Controllers\Web\RessarcimentoRecebimentoController;
use App\Http\Controllers\Web\RessarcimentoReferenciaController;
use App\Http\Controllers\Web\TokenServiceController;
use App\Http\Controllers\Web\TransacaoController;
use App\Http\Controllers\Web\UserController;
use App\Http\Controllers\Web\SituacaoController;
use App\Http\Controllers\Web\GraduacaoController;
use App\Http\Controllers\Web\QuadroController;
use App\Http\Controllers\Web\ComportamentoController;
use App\Http\Controllers\Web\UnidadeController;
use App\Http\Controllers\Web\FuncaoController;
use App\Http\Controllers\Web\GeneroController;
use App\Http\Controllers\Web\ParentescoController;
use App\Http\Controllers\Web\CursoController;
use App\Http\Controllers\Web\WebserviceController;
use App\Models\RessarcimentoCobranca;
use App\Models\RessarcimentoCobrancaDado;
use App\Models\RessarcimentoCobrancaPdfListagem;
use App\Models\RessarcimentoCobrancaPdfListagemDado;
use App\Models\RessarcimentoCobrancaPdfNota;
use App\Models\RessarcimentoCobrancaPdfOficio;
use App\Models\RessarcimentoConfiguracao;
use App\Models\RessarcimentoMilitar;
use App\Models\RessarcimentoPagamento;
use App\Models\RessarcimentoRecebimento;
use App\Models\RessarcimentoReferencia;
use Illuminate\Support\Facades\Route;





Route::prefix('res')->group(function () {

    Route::get('/', function () {
        $retorno = 'RessarcimentoReferencia             :'.RessarcimentoReferencia::count().'<br>';
        $retorno .= 'RessarcimentoConfiguracao           :'.RessarcimentoConfiguracao::count().'<br>';
        $retorno .= 'RessarcimentoMilitar                :'.RessarcimentoMilitar::count().'<br>';
        $retorno .= 'RessarcimentoPagamento              :'.RessarcimentoPagamento::count().'<br>';
        $retorno .= 'RessarcimentoCobranca               :'.RessarcimentoCobranca::count().'<br>';
        $retorno .= 'RessarcimentoCobrancaDado           :'.RessarcimentoCobrancaDado::count().'<br>';
        $retorno .= 'RessarcimentoCobrancaPdfListagem    :'.RessarcimentoCobrancaPdfListagem::count().'<br>';
        $retorno .= 'RessarcimentoCobrancaPdfListagemDado:'.RessarcimentoCobrancaPdfListagemDado::count().'<br>';
        $retorno .= 'RessarcimentoCobrancaPdfNota        :'.RessarcimentoCobrancaPdfNota::count().'<br>';
        $retorno .= 'RessarcimentoCobrancaPdfOficio      :'.RessarcimentoCobrancaPdfOficio::count().'<br>';
        $retorno .= 'RessarcimentoRecebimento            :'.RessarcimentoRecebimento::count().'<br>';

        return $retorno;
    });
});





// Integração - Início'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
Route::middleware('auth')->prefix('integracoes')->group(function () {
    Route::get('', [IntegracaoController::class, 'index']);

    Route::prefix('impsac')->group(function () {
        Route::get('/quantidades_bancos', [IntegracaoController::class, 'impsac_quantidades_bancos']);

        Route::get('/atualizar_dados/{tabela}', [IntegracaoController::class, 'impsac_atualizar_dados']);
    });
});
// Integração - Fim''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

// Autenticação - Início'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

// Abrir Formulário de Login - Padrão
Route::get('/', [AuthController::class, 'loginForm']);

// Abrir Formulário de Login - Esqueceu sua senha
Route::get('/login', [AuthController::class, 'loginForm'])->name('login');

// Fazer Login
Route::post('/login', [AuthController::class, 'login']);

// Fazer Logout
Route::post('/logout', [AuthController::class, 'logout']);

// Esqueceu sua senha - Chamar Tela para digitar usuário (user) para ser enviado E-mail
Route::get('/forgot/password/reset', [AuthController::class, 'forgot_password_request'])->name('forgot_password.request');

// Esqueceu sua senha - Receber usuário (user) e enviar E-mail
Route::post('/forgot/password/email', [AuthController::class, 'forgot_password_send'])->name('forgot_password.email');

// Esqueceu sua senha - Chamar Tela onde o usuário vai digitar a senha nova
Route::get('/forgot/password/reset/{token}', [AuthController::class, 'forgot_password_reset_form'])->name('forgot_password.reset_form');

// Esqueceu sua senha - Receber senha nova e fazer update na tabela users
Route::post('/forgot/password/reset', [AuthController::class, 'forgot_password_reset'])->name('forgot_password.update');

// Autenticação - Fim''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

// Permissão Situação''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
Route::middleware('auth')->prefix('permissoes_situacoes')->group(function () {
    // Verificar se tem permissão para a Situação
    Route::get('/tem_permissao_situacao/{modulo}/{acao}/{situacaoId}', function (string $modulo, string $acao, int $situacaoId) {
        return response()->json(['success' => temPermissaoSituacao($modulo, $acao, $situacaoId)]);
    });

    // Retornar campo da tabela grupos com Permissões Situações
    Route::get('/retorna_array_campo_grupos_permissoes_situacoes/{campo}', function (string $campo) {
        return response()->json(['success' => retornaArrayCampoGruposPermissoesSituacoes($campo)]);
    });
});
//'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

// Dashboards - Início'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
Route::middleware('auth')->prefix('dashboards')->group(function () {
    Route::get('', [DashboardController::class, 'index'])->name('dashboards.index')->middleware('permissao:dashboards_list');
    Route::get('permissoes_graficos', [DashboardController::class, 'permissoes_graficos'])->middleware('permissao:dashboards_list');

    // Totais Sistema
    Route::get('sistema_totais', [DashboardController::class, 'sistema_totais'])->middleware('permissao:dashboards_list');

    // Gráfico 1: USUÁRIOS GRUPOS
    Route::get('grafico_1', [DashboardController::class, 'grafico_1'])->middleware('permissao:dashboards_list');

    // Gráfico 2: TRANSAÇÕES OPERAÇÕES
    Route::get('grafico_2', [DashboardController::class, 'grafico_2'])->middleware('permissao:dashboards_list');

    // Gráfico 3: TRANSAÇÕES SUBMÓDULOS
    Route::get('grafico_3', [DashboardController::class, 'grafico_3'])->middleware('permissao:dashboards_list');

    // Totais Efetivo
    Route::get('efetivo_totais', [DashboardController::class, 'efetivo_totais'])->middleware('permissao:dashboards_list');

    // Gráfico 4: SITUAÇÕES
    Route::get('grafico_4', [DashboardController::class, 'grafico_4'])->middleware('permissao:dashboards_list');

    // Gráfico 5: QUADROS
    Route::get('grafico_5', [DashboardController::class, 'grafico_5'])->middleware('permissao:dashboards_list');

    // Gráfico 6: GRADUAÇÕES
    Route::get('grafico_6', [DashboardController::class, 'grafico_6'])->middleware('permissao:dashboards_list');

    // Gráfico 7: COMPORTAMENTOS
    Route::get('grafico_7', [DashboardController::class, 'grafico_7'])->middleware('permissao:dashboards_list');

    // Totais Ressarcimento
    Route::get('ressarcimento_totais', [DashboardController::class, 'ressarcimento_totais'])->middleware('permissao:dashboards_list');

    // Gráfico 8: QUANTIDADE DE MILITARES: OFICIAIS/PRAÇAS
    Route::get('grafico_8/{periodo1}/{periodo2}/{orgao_id}', [DashboardController::class, 'grafico_8'])->middleware('permissao:dashboards_list');

    // Gráfico 9: VALORES DEVIDOS E PAGOS PELOS ÓRGÃOS
    Route::get('grafico_9/{periodo1}/{periodo2}/{orgao_id}', [DashboardController::class, 'grafico_9'])->middleware('permissao:dashboards_list');

    // Gráfico 10: NÚMERO DE ÓRGÃOS POR ESFERA
    Route::get('grafico_10/{periodo1}/{periodo2}/{orgao_id}', [DashboardController::class, 'grafico_10'])->middleware('permissao:dashboards_list');

    // Gráfico 11: NÚMERO DE ÓRGÃOS POR PODER
    Route::get('grafico_11/{periodo1}/{periodo2}/{orgao_id}', [DashboardController::class, 'grafico_11'])->middleware('permissao:dashboards_list');

    // Gráfico 12: VALORES DEVIDOS E PAGOS POR ÓRGÃOS MENSALMENTE
    Route::get('grafico_12/{periodo1}/{periodo2}/{orgao_id}', [DashboardController::class, 'grafico_12'])->middleware('permissao:dashboards_list');

    // Totais Balancetes
    Route::get('balancetes_totais', [DashboardController::class, 'balancetes_totais'])->middleware('permissao:dashboards_list');

    // Gráfico 13: REPASSES
    Route::get('grafico_13/{data1}/{data2}/{subconta_id}', [DashboardController::class, 'grafico_13'])->middleware('permissao:dashboards_list');

    // Gráfico 14: DESPESAS
    Route::get('grafico_14/{data1}/{data2}/{subconta_id}', [DashboardController::class, 'grafico_14'])->middleware('permissao:dashboards_list');

    // Gráfico 15: TRANSFERÊNCIAS REALIZADAS
    Route::get('grafico_15/{data1}/{data2}/{subconta_id}', [DashboardController::class, 'grafico_15'])->middleware('permissao:dashboards_list');

    // Gráfico 16: TRANSFERÊNCIAS RECEBIDAS
    Route::get('grafico_16/{data1}/{data2}/{subconta_id}', [DashboardController::class, 'grafico_16'])->middleware('permissao:dashboards_list');

    // Gráfico 17: RESULTADO DO PERÍODO
    Route::get('grafico_17/{data1}/{data2}/{subconta_id}', [DashboardController::class, 'grafico_17'])->middleware('permissao:dashboards_list');
});
// Dashboards - Fim''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

// Relatorios - Início'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
Route::middleware('auth')->prefix('relatorios')->group(function () {
    Route::get('', [RelatorioController::class, 'index'])->name('relatorios.index')->middleware('permissao:relatorios_list');
    Route::get('relatorios_grupo', [RelatorioController::class, 'relatorios_grupo'])->middleware('permissao:relatorios_list');

    // Relatório 1: Grupos
    Route::get('relatorio_1/{grupo_id}', [RelatorioController::class, 'relatorio_1'])->middleware('permissao:relatorios_list');

    // Relatório 2: Usuários
    Route::get('relatorio_2/{grupo_id}/{user_situacao_id}/{user_tipo_id}', [RelatorioController::class, 'relatorio_2'])->middleware('permissao:relatorios_list');

    // Relatório 3: Transações
    Route::get('relatorio_3/{data}/{user_id}/{submodulo_id}/{operacao_id}/{dado}', [RelatorioController::class, 'relatorio_3'])->middleware('permissao:relatorios_list');

    // Relatório 4: MILITARES POR REFERÊNCIA E ÓRGÃO
    Route::get('relatorio_4/{referencia}/{orgao_id}', [RelatorioController::class, 'relatorio_4'])->middleware('permissao:relatorios_list');

    // Relatório 5: RESSARCIMENTO POR REFERÊNCIA E ÓRGÃO
    Route::get('relatorio_5/{referencia}/{orgao_id}', [RelatorioController::class, 'relatorio_5'])->middleware('permissao:relatorios_list');

    // Relatório 6: DÍVIDA DO(S) ÓRGÃO(S)
    Route::get('relatorio_6/{referencia}/{orgao_id}/{saldo}', [RelatorioController::class, 'relatorio_6'])->middleware('permissao:relatorios_list');

    // Relatório 7: MILITARES POR SITUAÇÃO
    Route::get('relatorio_7', [RelatorioController::class, 'relatorio_7'])->middleware('permissao:relatorios_list');

    // Relatório 8: MILITARES POR GRADUAÇÃO
    Route::get('relatorio_8', [RelatorioController::class, 'relatorio_8'])->middleware('permissao:relatorios_list');

    // Relatório 9: MILITARES POR UNIDADE
    Route::get('relatorio_9', [RelatorioController::class, 'relatorio_9'])->middleware('permissao:relatorios_list');

    // Relatório 10: MILITARES POR QUADRO
    Route::get('relatorio_10', [RelatorioController::class, 'relatorio_10'])->middleware('permissao:relatorios_list');

    // Relatório 11: MILITARES POR COMPORTAMENTO
    Route::get('relatorio_11', [RelatorioController::class, 'relatorio_11'])->middleware('permissao:relatorios_list');

    // Relatório 12: MILITARES
    Route::get('relatorio_12/{situacoes}/{graduacoes}/{unidades}/{quadros}/{comportamentos}', [RelatorioController::class, 'relatorio_12'])->middleware('permissao:relatorios_list');
});
// Relatorios - Fim''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

// Perfil Usuário - Início'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
Route::middleware('auth')->prefix('perfil')->group(function () {
    Route::post('/update_avatar', [ProfileController::class, 'updateAvatar']);
    Route::post('/update_password', [ProfileController::class, 'updatePassword']);
});
// Perfil Usuário - Fim''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

// Users - Início''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
Route::middleware('auth')->prefix('users')->group(function () {
    Route::get('', [UserController::class, 'index'])->name('users.index')->middleware('permissao:users_list');
    Route::post('', [UserController::class, 'store'])->middleware('permissao:users_create');
    Route::get('/create', [UserController::class, 'create'])->middleware('permissao:users_create');
    Route::get('/filter/{array_dados}', [UserController::class, 'filter'])->middleware('permissao:users_list');
    Route::get('/{id}', [UserController::class, 'show'])->middleware('permissao:users_show');
    Route::post('/{id}', [UserController::class, 'update'])->middleware('permissao:users_edit');
    Route::delete('/{id}', [UserController::class, 'destroy'])->middleware('permissao:users_destroy');
    Route::get('/{id}/edit', [UserController::class, 'edit'])->middleware('permissao:users_edit');
});
// Users - Fim'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

// Grupos - Início'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
Route::middleware('auth')->prefix('grupos')->group(function () {
    Route::get('', [GrupoController::class, 'index'])->name('grupos.index')->middleware('permissao:grupos_list');
    Route::post('', [GrupoController::class, 'store'])->middleware('permissao:grupos_create');
    Route::get('/create', [GrupoController::class, 'create'])->middleware('permissao:grupos_create');
    Route::get('/filter/{array_dados}', [GrupoController::class, 'filter'])->middleware('permissao:grupos_list');
    Route::get('/{id}', [GrupoController::class, 'show'])->middleware('permissao:grupos_show');
    Route::post('/{id}', [GrupoController::class, 'update'])->middleware('permissao:grupos_edit');
    Route::delete('/{id}', [GrupoController::class, 'destroy'])->middleware('permissao:grupos_destroy');
    Route::get('/{id}/edit', [GrupoController::class, 'edit'])->middleware('permissao:grupos_edit');

    Route::get('/grupo_permissoes/{grupo_id}', [GrupoController::class, 'grupo_permissoes'])->middleware('permissao:grupos_show');
    Route::get('/grupo_relatorios/{grupo_id}', [GrupoController::class, 'grupo_relatorios'])->middleware('permissao:grupos_show');
    Route::get('/grupo_graficos/{grupo_id}', [GrupoController::class, 'grupo_graficos'])->middleware('permissao:grupos_show');
});
// Grupos - Fim''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

// Situações - Início''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
Route::middleware('auth')->prefix('situacoes')->group(function () {
    Route::get('', [SituacaoController::class, 'index'])->name('situacoes.index')->middleware('permissao:situacoes_list');
    Route::post('', [SituacaoController::class, 'store'])->middleware('permissao:situacoes_create');
    Route::get('/create', [SituacaoController::class, 'create'])->middleware('permissao:situacoes_create');
    Route::get('/filter/{array_dados}', [SituacaoController::class, 'filter'])->middleware('permissao:situacoes_list');
    Route::get('/{id}', [SituacaoController::class, 'show'])->middleware('permissao:situacoes_show');
    Route::post('/{id}', [SituacaoController::class, 'update'])->middleware('permissao:situacoes_edit');
    Route::delete('/{id}', [SituacaoController::class, 'destroy'])->middleware('permissao:situacoes_destroy');
    Route::get('/{id}/edit', [SituacaoController::class, 'edit'])->middleware('permissao:situacoes_edit');
});
// Situações - Fim'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

// Graduações - Início'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
Route::middleware('auth')->prefix('graduacoes')->group(function () {
    Route::get('', [GraduacaoController::class, 'index'])->name('graduacoes.index')->middleware('permissao:graduacoes_list');
    Route::post('', [GraduacaoController::class, 'store'])->middleware('permissao:graduacoes_create');
    Route::get('/create', [GraduacaoController::class, 'create'])->middleware('permissao:graduacoes_create');
    Route::get('/filter/{array_dados}', [GraduacaoController::class, 'filter'])->middleware('permissao:graduacoes_list');
    Route::get('/{id}', [GraduacaoController::class, 'show'])->middleware('permissao:graduacoes_show');
    Route::post('/{id}', [GraduacaoController::class, 'update'])->middleware('permissao:graduacoes_edit');
    Route::delete('/{id}', [GraduacaoController::class, 'destroy'])->middleware('permissao:graduacoes_destroy');
    Route::get('/{id}/edit', [GraduacaoController::class, 'edit'])->middleware('permissao:graduacoes_edit');
});
// Graduações - Fim''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

// Quadros - Início''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
Route::middleware('auth')->prefix('quadros')->group(function () {
    Route::get('', [QuadroController::class, 'index'])->name('quadros.index')->middleware('permissao:quadros_list');
    Route::post('', [QuadroController::class, 'store'])->middleware('permissao:quadros_create');
    Route::get('/create', [QuadroController::class, 'create'])->middleware('permissao:quadros_create');
    Route::get('/filter/{array_dados}', [QuadroController::class, 'filter'])->middleware('permissao:quadros_list');
    Route::get('/{id}', [QuadroController::class, 'show'])->middleware('permissao:quadros_show');
    Route::post('/{id}', [QuadroController::class, 'update'])->middleware('permissao:quadros_edit');
    Route::delete('/{id}', [QuadroController::class, 'destroy'])->middleware('permissao:quadros_destroy');
    Route::get('/{id}/edit', [QuadroController::class, 'edit'])->middleware('permissao:quadros_edit');
});
// Quadros - Fim'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

// Comportamentos - Início'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
Route::middleware('auth')->prefix('comportamentos')->group(function () {
    Route::get('', [ComportamentoController::class, 'index'])->name('comportamentos.index')->middleware('permissao:comportamentos_list');
    Route::post('', [ComportamentoController::class, 'store'])->middleware('permissao:comportamentos_create');
    Route::get('/create', [ComportamentoController::class, 'create'])->middleware('permissao:comportamentos_create');
    Route::get('/filter/{array_dados}', [ComportamentoController::class, 'filter'])->middleware('permissao:comportamentos_list');
    Route::get('/{id}', [ComportamentoController::class, 'show'])->middleware('permissao:comportamentos_show');
    Route::post('/{id}', [ComportamentoController::class, 'update'])->middleware('permissao:comportamentos_edit');
    Route::delete('/{id}', [ComportamentoController::class, 'destroy'])->middleware('permissao:comportamentos_destroy');
    Route::get('/{id}/edit', [ComportamentoController::class, 'edit'])->middleware('permissao:comportamentos_edit');
});
// Comportamentos - Fim''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

// Unidades - Início'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
Route::middleware('auth')->prefix('unidades')->group(function () {
    Route::get('', [UnidadeController::class, 'index'])->name('unidades.index')->middleware('permissao:unidades_list');
    Route::post('', [UnidadeController::class, 'store'])->middleware('permissao:unidades_create');
    Route::get('/create', [UnidadeController::class, 'create'])->middleware('permissao:unidades_create');
    Route::get('/filter/{array_dados}', [UnidadeController::class, 'filter'])->middleware('permissao:unidades_list');
    Route::get('/{id}', [UnidadeController::class, 'show'])->middleware('permissao:unidades_show');
    Route::post('/{id}', [UnidadeController::class, 'update'])->middleware('permissao:unidades_edit');
    Route::delete('/{id}', [UnidadeController::class, 'destroy'])->middleware('permissao:unidades_destroy');
    Route::get('/{id}/edit', [UnidadeController::class, 'edit'])->middleware('permissao:unidades_edit');
});
// Unidades - Fim''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

// Funções - Início''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
Route::middleware('auth')->prefix('funcoes')->group(function () {
    Route::get('', [FuncaoController::class, 'index'])->name('funcoes.index')->middleware('permissao:funcoes_list');
    Route::post('', [FuncaoController::class, 'store'])->middleware('permissao:funcoes_create');
    Route::get('/create', [FuncaoController::class, 'create'])->middleware('permissao:funcoes_create');
    Route::get('/filter/{array_dados}', [FuncaoController::class, 'filter'])->middleware('permissao:funcoes_list');
    Route::get('/{id}', [FuncaoController::class, 'show'])->middleware('permissao:funcoes_show');
    Route::post('/{id}', [FuncaoController::class, 'update'])->middleware('permissao:funcoes_edit');
    Route::delete('/{id}', [FuncaoController::class, 'destroy'])->middleware('permissao:funcoes_destroy');
    Route::get('/{id}/edit', [FuncaoController::class, 'edit'])->middleware('permissao:funcoes_edit');
});
// Funções - Fim'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

// Gêneros - Início''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
Route::middleware('auth')->prefix('generos')->group(function () {
    Route::get('', [GeneroController::class, 'index'])->name('generos.index')->middleware('permissao:generos_list');
    Route::post('', [GeneroController::class, 'store'])->middleware('permissao:generos_create');
    Route::get('/create', [GeneroController::class, 'create'])->middleware('permissao:generos_create');
    Route::get('/filter/{array_dados}', [GeneroController::class, 'filter'])->middleware('permissao:generos_list');
    Route::get('/{id}', [GeneroController::class, 'show'])->middleware('permissao:generos_show');
    Route::post('/{id}', [GeneroController::class, 'update'])->middleware('permissao:generos_edit');
    Route::delete('/{id}', [GeneroController::class, 'destroy'])->middleware('permissao:generos_destroy');
    Route::get('/{id}/edit', [GeneroController::class, 'edit'])->middleware('permissao:generos_edit');
});
// Gêneros - Fim'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

// Parentescos - Início''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
Route::middleware('auth')->prefix('parentescos')->group(function () {
    Route::get('', [ParentescoController::class, 'index'])->name('parentescos.index')->middleware('permissao:parentescos_list');
    Route::post('', [ParentescoController::class, 'store'])->middleware('permissao:parentescos_create');
    Route::get('/create', [ParentescoController::class, 'create'])->middleware('permissao:parentescos_create');
    Route::get('/filter/{array_dados}', [ParentescoController::class, 'filter'])->middleware('permissao:parentescos_list');
    Route::get('/{id}', [ParentescoController::class, 'show'])->middleware('permissao:parentescos_show');
    Route::post('/{id}', [ParentescoController::class, 'update'])->middleware('permissao:parentescos_edit');
    Route::delete('/{id}', [ParentescoController::class, 'destroy'])->middleware('permissao:parentescos_destroy');
    Route::get('/{id}/edit', [ParentescoController::class, 'edit'])->middleware('permissao:parentescos_edit');
});
// Parentescos - Fim''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

// Cursos - Início'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
Route::middleware('auth')->prefix('cursos')->group(function () {
    Route::get('', [CursoController::class, 'index'])->name('cursos.index')->middleware('permissao:cursos_list');
    Route::post('', [CursoController::class, 'store'])->middleware('permissao:cursos_create');
    Route::get('/create', [CursoController::class, 'create'])->middleware('permissao:cursos_create');
    Route::get('/filter/{array_dados}', [CursoController::class, 'filter'])->middleware('permissao:cursos_list');
    Route::get('/{id}', [CursoController::class, 'show'])->middleware('permissao:cursos_show');
    Route::post('/{id}', [CursoController::class, 'update'])->middleware('permissao:cursos_edit');
    Route::delete('/{id}', [CursoController::class, 'destroy'])->middleware('permissao:cursos_destroy');
    Route::get('/{id}/edit', [CursoController::class, 'edit'])->middleware('permissao:cursos_edit');
});
// Cursos - Fim''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

// Transações - Início'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
Route::middleware('auth')->prefix('transacoes')->group(function () {
    Route::get('', [TransacaoController::class, 'index'])->name('transacoes.index')->middleware('permissao:transacoes_list');
    Route::get('/filter/{array_dados}', [TransacaoController::class, 'filter'])->middleware('permissao:transacoes_list');
});
// Transações - Fim''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

// Militares - Início''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
Route::middleware('auth')->prefix('militares')->group(function () {
    Route::get('', [MilitarController::class, 'index'])->name('militares.index')->middleware('permissao:militares_list');
    Route::post('', [MilitarController::class, 'store'])->middleware('permissao:militares_create');
    Route::get('/create', [MilitarController::class, 'create'])->middleware('permissao:militares_create');
    Route::get('/filter/{array_dados}', [MilitarController::class, 'filter'])->middleware('permissao:militares_list');
    Route::get('/{id}', [MilitarController::class, 'show'])->middleware('permissao:militares_show');
    Route::post('/{id}', [MilitarController::class, 'update'])->middleware('permissao:militares_edit');
    Route::delete('/{id}', [MilitarController::class, 'destroy'])->middleware('permissao:militares_destroy');
    Route::get('/{id}/edit', [MilitarController::class, 'edit'])->middleware('permissao:militares_edit');

    Route::get('/informacoes/geral/{militar_id}', [MilitarController::class, 'informacoes_geral']);

    Route::post('/informacoes/update_fotografia', [MilitarController::class, 'updateFotografia']);

    Route::post('/autocomplete/militar/{submodulo}/{acao}', [MilitarController::class, 'autocompleteMilitar']);
});
// Militares - Fim'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

// Militares Cursos - Início'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
Route::middleware('auth')->prefix('militares_cursos')->group(function () {
    Route::get('', [MilitarCursoController::class, 'index'])->name('militares_cursos.index')->middleware('permissao:militares_cursos_list');
    Route::post('', [MilitarCursoController::class, 'store'])->middleware('permissao:militares_cursos_create');
    Route::get('/create', [MilitarCursoController::class, 'create'])->middleware('permissao:militares_cursos_create');
    Route::get('/filter/{array_dados}', [MilitarCursoController::class, 'filter'])->middleware('permissao:militares_cursos_list');
    Route::get('/{id}', [MilitarCursoController::class, 'show'])->middleware('permissao:militares_cursos_show');
    Route::post('/{id}', [MilitarCursoController::class, 'update'])->middleware('permissao:militares_cursos_edit');
    Route::delete('/{id}', [MilitarCursoController::class, 'destroy'])->middleware('permissao:militares_cursos_destroy');
    Route::get('/{id}/edit', [MilitarCursoController::class, 'edit'])->middleware('permissao:militares_cursos_edit');
});
// Militares Cursos - Fim''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

// Militares Contatos - Início'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
Route::middleware('auth')->prefix('militares_contatos')->group(function () {
    Route::get('', [MilitarContatoController::class, 'index'])->name('militares_contatos.index')->middleware('permissao:militares_contatos_list');
    Route::post('', [MilitarContatoController::class, 'store'])->middleware('permissao:militares_contatos_create');
    Route::get('/create', [MilitarContatoController::class, 'create'])->middleware('permissao:militares_contatos_create');
    Route::get('/filter/{array_dados}', [MilitarContatoController::class, 'filter'])->middleware('permissao:militares_contatos_list');
    Route::get('/{id}', [MilitarContatoController::class, 'show'])->middleware('permissao:militares_contatos_show');
    Route::post('/{id}', [MilitarContatoController::class, 'update'])->middleware('permissao:militares_contatos_edit');
    Route::delete('/{id}', [MilitarContatoController::class, 'destroy'])->middleware('permissao:militares_contatos_destroy');
    Route::get('/{id}/edit', [MilitarContatoController::class, 'edit'])->middleware('permissao:militares_contatos_edit');
});
// Militares Contatos - Fim''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

// Militares Ajudas de Custos - Início'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
Route::middleware('auth')->prefix('militares_ajudas_custos')->group(function () {
    Route::get('', [MilitarAjudaCustoController::class, 'index'])->name('militares_ajudas_custos.index')->middleware('permissao:militares_ajudas_custos_list');
    Route::post('', [MilitarAjudaCustoController::class, 'store'])->middleware('permissao:militares_ajudas_custos_create');
    Route::get('/create', [MilitarAjudaCustoController::class, 'create'])->middleware('permissao:militares_ajudas_custos_create');
    Route::get('/filter/{array_dados}', [MilitarAjudaCustoController::class, 'filter'])->middleware('permissao:militares_ajudas_custos_list');
    Route::get('/{id}', [MilitarAjudaCustoController::class, 'show'])->middleware('permissao:militares_ajudas_custos_show');
    Route::post('/{id}', [MilitarAjudaCustoController::class, 'update'])->middleware('permissao:militares_ajudas_custos_edit');
    Route::delete('/{id}', [MilitarAjudaCustoController::class, 'destroy'])->middleware('permissao:militares_ajudas_custos_destroy');
    Route::get('/{id}/edit', [MilitarAjudaCustoController::class, 'edit'])->middleware('permissao:militares_ajudas_custos_edit');
});
// Militares Ajudas de Custos - Fim''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

// Militares Auxílios Fardamentos - Início'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
Route::middleware('auth')->prefix('militares_auxilios_fardamentos')->group(function () {
    Route::get('', [MilitarAuxilioFardamentoController::class, 'index'])->name('militares_auxilios_fardamentos.index')->middleware('permissao:militares_auxilios_fardamentos_list');
    Route::post('', [MilitarAuxilioFardamentoController::class, 'store'])->middleware('permissao:militares_auxilios_fardamentos_create');
    Route::get('/create', [MilitarAuxilioFardamentoController::class, 'create'])->middleware('permissao:militares_auxilios_fardamentos_create');
    Route::get('/filter/{array_dados}', [MilitarAuxilioFardamentoController::class, 'filter'])->middleware('permissao:militares_auxilios_fardamentos_list');
    Route::get('/{id}', [MilitarAuxilioFardamentoController::class, 'show'])->middleware('permissao:militares_auxilios_fardamentos_show');
    Route::post('/{id}', [MilitarAuxilioFardamentoController::class, 'update'])->middleware('permissao:militares_auxilios_fardamentos_edit');
    Route::delete('/{id}', [MilitarAuxilioFardamentoController::class, 'destroy'])->middleware('permissao:militares_auxilios_fardamentos_destroy');
    Route::get('/{id}/edit', [MilitarAuxilioFardamentoController::class, 'edit'])->middleware('permissao:militares_auxilios_fardamentos_edit');
});
// Militares Auxílios Fardamentos - Fim''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

// Militares Dependentes - Início''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
Route::middleware('auth')->prefix('militares_dependentes')->group(function () {
    Route::get('', [MilitarDependenteController::class, 'index'])->name('militares_dependentes.index')->middleware('permissao:militares_dependentes_list');
    Route::post('', [MilitarDependenteController::class, 'store'])->middleware('permissao:militares_dependentes_create');
    Route::get('/create', [MilitarDependenteController::class, 'create'])->middleware('permissao:militares_dependentes_create');
    Route::get('/filter/{array_dados}', [MilitarDependenteController::class, 'filter'])->middleware('permissao:militares_dependentes_list');
    Route::get('/{id}', [MilitarDependenteController::class, 'show'])->middleware('permissao:militares_dependentes_show');
    Route::post('/{id}', [MilitarDependenteController::class, 'update'])->middleware('permissao:militares_dependentes_edit');
    Route::delete('/{id}', [MilitarDependenteController::class, 'destroy'])->middleware('permissao:militares_dependentes_destroy');
    Route::get('/{id}/edit', [MilitarDependenteController::class, 'edit'])->middleware('permissao:militares_dependentes_edit');
});
// Militares Dependentes - Fim'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

// Militares Fundos de Saúde - Início'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
Route::middleware('auth')->prefix('militares_fundos_saude')->group(function () {
    Route::get('', [MilitarFundoSaudeController::class, 'index'])->name('militares_fundos_saude.index')->middleware('permissao:militares_fundos_saude_list');
    Route::post('', [MilitarFundoSaudeController::class, 'store'])->middleware('permissao:militares_fundos_saude_create');
    Route::get('/create', [MilitarFundoSaudeController::class, 'create'])->middleware('permissao:militares_fundos_saude_create');
    Route::get('/filter/{array_dados}', [MilitarFundoSaudeController::class, 'filter'])->middleware('permissao:militares_fundos_saude_list');
    Route::get('/{id}', [MilitarFundoSaudeController::class, 'show'])->middleware('permissao:militares_fundos_saude_show');
    Route::post('/{id}', [MilitarFundoSaudeController::class, 'update'])->middleware('permissao:militares_fundos_saude_edit');
    Route::delete('/{id}', [MilitarFundoSaudeController::class, 'destroy'])->middleware('permissao:militares_fundos_saude_destroy');
    Route::get('/{id}/edit', [MilitarFundoSaudeController::class, 'edit'])->middleware('permissao:militares_fundos_saude_edit');
});
// Militares Fundos de Saúde - Fim'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

// Ressarcimentos Referências - Início'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
Route::middleware('auth')->prefix('ressarcimento_referencias')->group(function () {
    Route::get('', [RessarcimentoReferenciaController::class, 'index'])->name('ressarcimento_referencias.index')->middleware('permissao:ressarcimento_referencias_list');
    Route::post('', [RessarcimentoReferenciaController::class, 'store'])->middleware('permissao:ressarcimento_referencias_create');
    Route::get('/create', [RessarcimentoReferenciaController::class, 'create'])->middleware('permissao:ressarcimento_referencias_create');
    Route::get('/filter/{array_dados}', [RessarcimentoReferenciaController::class, 'filter'])->middleware('permissao:ressarcimento_referencias_list');
    Route::get('/{id}', [RessarcimentoReferenciaController::class, 'show'])->middleware('permissao:ressarcimento_referencias_show');
    Route::post('/{id}', [RessarcimentoReferenciaController::class, 'update'])->middleware('permissao:ressarcimento_referencias_edit');
    Route::delete('/{id}', [RessarcimentoReferenciaController::class, 'destroy'])->middleware('permissao:ressarcimento_referencias_destroy');
    Route::get('/{id}/edit', [RessarcimentoReferenciaController::class, 'edit'])->middleware('permissao:ressarcimento_referencias_edit');
});
// Ressarcimentos Referências - Fim''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

// Ressarcimento Configurações - Início''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
Route::middleware('auth')->prefix('ressarcimento_configuracoes')->group(function () {
    Route::get('', [RessarcimentoConfiguracaoController::class, 'index'])->name('ressarcimento_configuracoes.index')->middleware('permissao:ressarcimento_configuracoes_list');
    Route::get('/filter/{array_dados}', [RessarcimentoConfiguracaoController::class, 'filter'])->middleware('permissao:ressarcimento_configuracoes_list');
    Route::get('/{id}', [RessarcimentoConfiguracaoController::class, 'show'])->middleware('permissao:ressarcimento_configuracoes_show');
    Route::post('/{id}', [RessarcimentoConfiguracaoController::class, 'update'])->middleware('permissao:ressarcimento_configuracoes_edit');
    Route::get('/{id}/edit', [RessarcimentoConfiguracaoController::class, 'edit'])->middleware('permissao:ressarcimento_configuracoes_edit');
});
// Ressarcimento Configurações - Fim''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

// Ressarcimento Orgãos - Início'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
Route::middleware('auth')->prefix('ressarcimento_orgaos')->group(function () {
    Route::get('', [RessarcimentoOrgaoController::class, 'index'])->name('ressarcimento_orgaos.index')->middleware('permissao:ressarcimento_orgaos_list');
    Route::get('/filter/{array_dados}', [RessarcimentoOrgaoController::class, 'filter'])->middleware('permissao:ressarcimento_orgaos_list');
    Route::get('/{id}', [RessarcimentoOrgaoController::class, 'show'])->middleware('permissao:ressarcimento_orgaos_show');
    Route::post('/{id}', [RessarcimentoOrgaoController::class, 'update'])->middleware('permissao:ressarcimento_orgaos_edit');
    Route::get('/{id}/edit', [RessarcimentoOrgaoController::class, 'edit'])->middleware('permissao:ressarcimento_orgaos_edit');
});
// Ressarcimento Orgãos - Fim''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

// Ressarcimentos Militares - Início'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
Route::middleware('auth')->prefix('ressarcimento_militares')->group(function () {
    Route::get('', [RessarcimentoMilitarController::class, 'index'])->name('ressarcimento_militares.index')->middleware('permissao:ressarcimento_militares_list');
    Route::get('/filter/{array_dados}', [RessarcimentoMilitarController::class, 'filter'])->middleware('permissao:ressarcimento_militares_list');
    Route::get('/{id}', [RessarcimentoMilitarController::class, 'show'])->middleware('permissao:ressarcimento_militares_show');
    Route::delete('/{id}', [RessarcimentoMilitarController::class, 'destroy'])->middleware('permissao:ressarcimento_militares_destroy');

    Route::post('/importar', [RessarcimentoMilitarController::class, 'importar'])->middleware('permissao:ressarcimento_militares_create');
});
// Ressarcimentos Militares - Fim''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

// Ressarcimentos Pagamentos - Início''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
Route::middleware('auth')->prefix('ressarcimento_pagamentos')->group(function () {
    Route::get('', [RessarcimentoPagamentoController::class, 'index'])->name('ressarcimento_pagamentos.index')->middleware('permissao:ressarcimento_pagamentos_list');
    Route::get('/filter/{array_dados}', [RessarcimentoPagamentoController::class, 'filter'])->middleware('permissao:ressarcimento_pagamentos_list');
    Route::get('/{id}', [RessarcimentoPagamentoController::class, 'show'])->middleware('permissao:ressarcimento_pagamentos_show');
    Route::delete('/{id}', [RessarcimentoPagamentoController::class, 'destroy'])->middleware('permissao:ressarcimento_pagamentos_destroy');
    Route::post('/{id}', [RessarcimentoPagamentoController::class, 'update'])->middleware('permissao:ressarcimento_pagamentos_edit');
    Route::get('/{id}/edit', [RessarcimentoPagamentoController::class, 'edit'])->middleware('permissao:ressarcimento_pagamentos_edit');

    Route::post('/dados/importar', [RessarcimentoPagamentoController::class, 'importar'])->middleware('permissao:ressarcimento_pagamentos_create');
});
// Ressarcimentos Pagamentos - Fim'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

// Ressarcimento Cobranças - Início''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
Route::middleware('auth')->prefix('ressarcimento_cobrancas')->group(function () {
    Route::get('', [RessarcimentoCobrancaController::class, 'index'])->name('ressarcimento_cobrancas.index')->middleware('permissao:ressarcimento_cobrancas_list');

    Route::get('/dados_ressarcimento/{referencia}', [RessarcimentoCobrancaController::class, 'dados_ressarcimento'])->middleware('permissao:ressarcimento_cobrancas_list');
    Route::get('/gerar_cobrancas/{referencia}', [RessarcimentoCobrancaController::class, 'gerar_cobrancas'])->middleware('permissao:ressarcimento_cobrancas_list');
    Route::get('/gerar_pdfs/{referencia}', [RessarcimentoCobrancaController::class, 'gerar_pdfs'])->middleware('permissao:ressarcimento_cobrancas_list');
    Route::get('/verificar_existe_zip/{referencia}', [RessarcimentoCobrancaController::class, 'verificar_existe_zip'])->middleware('permissao:ressarcimento_cobrancas_list');
    Route::get('/deletar_pdfs_gerados/{referencia}', [RessarcimentoCobrancaController::class, 'deletar_pdfs_gerados'])->name('ressarcimento_cobrancas.deletar_pdfs_gerados');

    Route::get('/progresso_gerar_pdfs/{referencia}', [RessarcimentoCobrancaController::class, 'progresso_gerar_pdfs']);
});
// Ressarcimento Cobranças - Fim'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

// Ressarcimentos Recebimentos - Início''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
Route::middleware('auth')->prefix('ressarcimento_recebimentos')->group(function () {
    Route::get('', [RessarcimentoRecebimentoController::class, 'index'])->name('ressarcimento_recebimentos.index')->middleware('permissao:ressarcimento_recebimentos_list');
    Route::post('', [RessarcimentoRecebimentoController::class, 'update_recebimento'])->middleware('permissao:ressarcimento_recebimentos_edit');
    Route::get('/filter/{array_dados}', [RessarcimentoRecebimentoController::class, 'filter'])->middleware('permissao:ressarcimento_recebimentos_list');

    Route::get('/dados/modal/{referencia}', [RessarcimentoRecebimentoController::class, 'dados_modal'])->middleware('permissao:ressarcimento_recebimentos_edit');
    Route::get('/registros_alterar/{referencia}/{orgao_id}', [RessarcimentoRecebimentoController::class, 'registros_alterar'])->middleware('permissao:ressarcimento_recebimentos_edit');
});
// Ressarcimentos Recebimentos - Fim'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

// Ressarcimentos Exclusões - Início'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
Route::middleware('auth')->prefix('ressarcimento_exclusoes')->group(function () {
    Route::get('', [RessarcimentoExclusaoController::class, 'index'])->name('ressarcimento_exclusoes.index')->middleware('permissao:ressarcimento_exclusoes_list');
    Route::get('/create', [RessarcimentoExclusaoController::class, 'create'])->middleware('permissao:ressarcimento_exclusoes_create');
    Route::get('/filter/{array_dados}', [RessarcimentoExclusaoController::class, 'filter'])->middleware('permissao:ressarcimento_exclusoes_list');

    Route::get('/ultima_referencia', [RessarcimentoExclusaoController::class, 'ultima_referencia'])->middleware('permissao:ressarcimento_exclusoes_create');
    Route::get('/dados_ressarcimento/{referencia}', [RessarcimentoExclusaoController::class, 'dados_ressarcimento'])->middleware('permissao:ressarcimento_exclusoes_list');
    Route::get('/deletar_pdfs_gerados/{referencia}', [RessarcimentoExclusaoController::class, 'deletar_pdfs_gerados'])->middleware('permissao:ressarcimento_exclusoes_create');
    Route::get('/deletar_cobranca/{referencia}', [RessarcimentoExclusaoController::class, 'deletar_cobranca'])->middleware('permissao:ressarcimento_exclusoes_create');
});
// Ressarcimentos Exclusões - Fim''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

// Webservices - Início''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
Route::middleware('auth')->prefix('webservices')->group(function () {
    Route::get('/militar/{field}/{value}', [WebserviceController::class, 'militar']);
});
// Webservices - Fim'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

// Token Service - Início''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
Route::middleware('auth')->prefix('token_service')->group(function () {
    Route::get('/gerar/{scopo}/{id}', [TokenServiceController::class, 'gerar']);
    Route::get('/validar/{token}', [TokenServiceController::class, 'validar']);
    Route::get('/scope/{token}', [TokenServiceController::class, 'scope']);
    Route::get('/id/{token}', [TokenServiceController::class, 'id']);
});
// Token Service - Fim'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
