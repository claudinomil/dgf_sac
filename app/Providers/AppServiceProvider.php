<?php

namespace App\Providers;

use App\Models\Militar;
use App\Models\MilitarAjudaCusto;
use App\Models\MilitarAuxilioFardamento;
use App\Models\MilitarContato;
use App\Models\MilitarCurso;
use App\Models\MilitarDependente;
use App\Models\MilitarFundoSaude;
use App\Models\RessarcimentoConfiguracao;
use App\Models\RessarcimentoReferencia;
use App\Models\RessarcimentoMilitar;
use App\Models\RessarcimentoOrgao;
use App\Models\RessarcimentoPagamento;
use App\Models\Situacao;
use App\Models\Graduacao;
use App\Models\Comportamento;
use App\Models\Funcao;
use App\Models\Quadro;
use App\Models\Parentesco;
use App\Models\Genero;
use App\Models\Curso;
use App\Models\Unidade;
use App\Models\User;
use App\Observers\MilitarContatoObserver;
use App\Observers\MilitarAjudaCustoObserver;
use App\Observers\MilitarAuxilioFardamentoObserver;
use App\Observers\MilitarCursoObserver;
use App\Observers\MilitarDependenteObserver;
use App\Observers\MilitarFundoSaudeObserver;
use App\Observers\MilitarObserver;
use App\Observers\RessarcimentoConfiguracaoObserver;
use App\Observers\RessarcimentoReferenciaObserver;
use App\Observers\RessarcimentoMilitarObserver;
use App\Observers\RessarcimentoOrgaoObserver;
use App\Observers\RessarcimentoPagamentoObserver;
use App\Observers\SituacaoObserver;
use App\Observers\GraduacaoObserver;
use App\Observers\ComportamentoObserver;
use App\Observers\FuncaoObserver;
use App\Observers\QuadroObserver;
use App\Observers\ParentescoObserver;
use App\Observers\GeneroObserver;
use App\Observers\CursoObserver;
use App\Observers\UnidadeObserver;
use App\Observers\UserObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        User::observe(UserObserver::class);
        Situacao::observe(SituacaoObserver::class);
        Comportamento::observe(ComportamentoObserver::class);
        Funcao::observe(FuncaoObserver::class);
        Quadro::observe(QuadroObserver::class);
        Parentesco::observe(ParentescoObserver::class);
        Genero::observe(GeneroObserver::class);
        Curso::observe(CursoObserver::class);
        Unidade::observe(UnidadeObserver::class);
        Graduacao::observe(GraduacaoObserver::class);
        RessarcimentoReferencia::observe(RessarcimentoReferenciaObserver::class);
        RessarcimentoMilitar::observe(RessarcimentoMilitarObserver::class);
        RessarcimentoOrgao::observe(RessarcimentoOrgaoObserver::class);
        RessarcimentoConfiguracao::observe(RessarcimentoConfiguracaoObserver::class);
        RessarcimentoPagamento::observe(RessarcimentoPagamentoObserver::class);
        Militar::observe(MilitarObserver::class);
        MilitarCurso::observe(MilitarCursoObserver::class);
        MilitarDependente::observe(MilitarDependenteObserver::class);
        MilitarFundoSaude::observe(MilitarFundoSaudeObserver::class);
        MilitarContato::observe(MilitarContatoObserver::class);
        MilitarAjudaCusto::observe(MilitarAjudaCustoObserver::class);
        MilitarAuxilioFardamento::observe(MilitarAuxilioFardamentoObserver::class);
    }
}
