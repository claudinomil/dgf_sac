<?php

namespace App\Domain\RessarcimentoCobranca;

use App\Models\RessarcimentoCobranca;
use App\Models\RessarcimentoCobrancaDado;
use App\Models\RessarcimentoCobrancaPdfListagem;
use App\Models\RessarcimentoCobrancaPdfListagemDado;
use App\Models\RessarcimentoCobrancaPdfNota;
use App\Models\RessarcimentoCobrancaPdfOficio;
use App\Models\RessarcimentoConfiguracao;
use App\Models\RessarcimentoMilitar;
use App\Models\RessarcimentoOrgao;
use App\Models\RessarcimentoPagamento;
use App\Models\RessarcimentoRecebimento;

class RessarcimentoCobrancaRepository
{
    public function index()
    {
        return;
    }

    public function create(array $data)
    {
        return RessarcimentoCobranca::create($data);
    }

    public function dados_ressarcimento($referencia)
    {
        // Array de retorno
        $content = array();

        // Registros Órgãos
        $content['orgaos'] = RessarcimentoOrgao::join('ressarcimento_militares', 'ressarcimento_militares.lotacao_id', 'ressarcimento_orgaos.lotacao_id')
            ->select('ressarcimento_orgaos.*')
            ->distinct('ressarcimento_orgaos.lotacao_id')
            ->where('ressarcimento_militares.referencia', $referencia)
            ->get();

        // Registros Militares
        $content['militares'] = RessarcimentoMilitar::where('referencia', $referencia)->get();

        // Registros Pagamentos
        $content['pagamentos'] = RessarcimentoPagamento::where('referencia', $referencia)->get();

        // Registros Configurações
        $content['configuracoes'] = RessarcimentoConfiguracao::where('referencia', $referencia)->get();

        // Registros Cobrancas
        $content['cobrancas_dados'] = RessarcimentoCobrancaDado::where('referencia', $referencia)->get();

        // Registros Cobrancas PDFs Listagens
        $content['cobrancas_pdfs_listagens'] = RessarcimentoCobrancaPdfListagem::where('referencia', $referencia)->get();

        // Registros Cobrancas PDFs Notas
        $content['cobrancas_pdfs_notas'] = RessarcimentoCobrancaPdfNota::where('referencia', $referencia)->get();

        // Registros Cobrancas PDFs Ofícios
        $content['cobrancas_pdfs_oficios'] = RessarcimentoCobrancaPdfOficio::where('referencia', $referencia)->get();

        return $content;
    }

    /*
     * Deletar Cobrança de uma determinada Referência
     * Deletará registros de cobrança nas seguintes tabelas:
     * :: ressarcimento_cobrancas
     * :: ressarcimento_cobrancas_dados
     * :: ressarcimento_recebimentos
     * :: ressarcimento_cobrancas_pdfs_listagens
     * :: ressarcimento_cobrancas_pdfs_listagens_dados
     * :: ressarcimento_cobrancas_pdfs_notas
     * :: ressarcimento_cobrancas_pdfs_oficios
     */
    public function deletar_cobrancas($referencia)
    {
        // Apagando registros tabela ressarcimento_cobrancas
        RessarcimentoCobranca::where('referencia', $referencia)->delete();

        // Apagando registros tabela ressarcimento_cobrancas_dados
        $registros = RessarcimentoCobrancaDado::where('referencia', $referencia)->get();

        foreach ($registros as $registro) {
            $id_excluir = $registro['id'];

            RessarcimentoRecebimento::where('ressarcimento_cobranca_dado_id', $id_excluir)->delete();
            RessarcimentoCobrancaDado::where('id', $id_excluir)->delete();
        }

        // Apagando registros tabela ressarcimento_cobrancas_pdfs_listagens
        $registros = RessarcimentoCobrancaPdfListagem::where('referencia', $referencia)->get();

        foreach ($registros as $registro) {
            $id_excluir = $registro['id'];

            RessarcimentoCobrancaPdfListagemDado::where('ressarcimento_cobranca_pdf_listagem_id', $id_excluir)->delete();
            RessarcimentoCobrancaPdfListagem::where('id', $id_excluir)->delete();
        }

        // Apagando registros tabela ressarcimento_cobrancas_pdfs_notas
        RessarcimentoCobrancaPdfNota::where('referencia', $referencia)->delete();

        // Apagando registros tabela ressarcimento_cobrancas_pdfs_oficios
        RessarcimentoCobrancaPdfOficio::where('referencia', $referencia)->delete();

        return true;
    }

    /*
     * Retornar proximo ano e numero de uma Nota para gravar na tabela ressarcimento_cobrancas_pdfs_listagens
     */
    public function ano_numero_nota()
    {
        $anoAtual = date('Y');

        // Valor padrão (primeira nota do ano)
        $numero = 1;

        // Último registro geral
        $ultimoRegistro = RessarcimentoCobrancaPdfListagem::orderByDesc('nota_ano')
            ->orderByDesc('nota_numero')
            ->first();

        if ($ultimoRegistro && $ultimoRegistro->nota_ano == $anoAtual) {
            $numero = ((int) $ultimoRegistro->nota_numero) + 1;
        }

        // Retorno no mesmo padrão: ano + número
        return $anoAtual . $numero;
    }

    /*
     * Retornar proximo ano e numero de um Ofício para gravar na tabela ressarcimento_cobrancas_pdfs_oficios
     */
    public function ano_numero_oficio()
    {
        $anoAtual = date('Y');

        // Valor padrão (primeiro número do ano)
        $numero = 1;

        // Último registro gerado
        $ultimoRegistro = RessarcimentoCobrancaPdfOficio::orderByDesc('oficio_ano')
            ->orderByDesc('oficio_numero')
            ->first();

        if ($ultimoRegistro && $ultimoRegistro->oficio_ano == $anoAtual) {
            $numero = ((int) $ultimoRegistro->oficio_numero) + 1;
        }

        // Retorno no mesmo padrão: ano + número
        return $anoAtual . $numero;
    }

    public function cobranca_pdf_listagem_create(array $data)
    {
        return RessarcimentoCobrancaPdfListagem::create($data);
    }

    public function cobranca_pdf_listagem_dados_create(array $data)
    {
        return RessarcimentoCobrancaPdfListagemDado::create($data);
    }

    public function cobranca_dados_create(array $data)
    {
        return RessarcimentoCobrancaDado::create($data);
    }

    public function cobranca_pdf_oficio_create(array $data)
    {
        return RessarcimentoCobrancaPdfOficio::create($data);
    }

    public function cobranca_pdf_nota_create(array $data)
    {
        return RessarcimentoCobrancaPdfNota::create($data);
    }

    public function cobranca_pdf_listagem_referencia($referencia)
    {
        return RessarcimentoCobrancaPdfListagem::where('referencia', $referencia)->get();
    }

    public function cobranca_pdf_listagem_dados_referencia($referencia)
    {
        return RessarcimentoCobrancaPdfListagem::join('ressarcimento_cobrancas_pdfs_listagens_dados', 'ressarcimento_cobrancas_pdfs_listagens_dados.ressarcimento_cobranca_pdf_listagem_id', 'ressarcimento_cobrancas_pdfs_listagens.id')
            ->select('ressarcimento_cobrancas_pdfs_listagens_dados.*')
            ->where('ressarcimento_cobrancas_pdfs_listagens.referencia', $referencia)
            ->get();
    }

    public function cobranca_pdf_oficios_referencia($referencia)
    {
        return RessarcimentoCobrancaPdfOficio::where('referencia', $referencia)->get();
    }

    public function cobranca_pdf_notas_referencia($referencia)
    {
        return RessarcimentoCobrancaPdfNota::where('referencia', $referencia)->get();
    }

    public function cobrancaEncerrada($referencia)
    {
        $encerrada = RessarcimentoCobranca::where('cobranca_encerrada', 1)->where('referencia', $referencia)->first();

        if ($encerrada) {
            return true;
        }

        return false;
    }
}
