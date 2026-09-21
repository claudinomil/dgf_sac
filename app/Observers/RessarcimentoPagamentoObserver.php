<?php

namespace App\Observers;

use App\Models\RessarcimentoPagamento;
use App\Domain\Transacao\TransacaoService;

class RessarcimentoPagamentoObserver
{
    private $transacaoService;

    public function __construct(TransacaoService $transacaoService)
    {
        $this->transacaoService = $transacaoService;
    }

    // NÃO VAI GRAVAR REGISTRO DE CADA IMPORTAÇÃO E SIM UMA COMPILAÇÃO DA IMPORTAÇÃO'''''''''''''''''''''''''''

    // public function created(RessarcimentoPagamento $ressarcimento_pagamento)
    // {
    //     $this->transacaoService->transacao(1, 1, 'ressarcimento_pagamentos', $ressarcimento_pagamento->toArray(), []);
    // }

    //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

    public function updated(RessarcimentoPagamento $ressarcimento_pagamento)
    {
        $this->transacaoService->transacao(1, 2, 'ressarcimento_pagamentos', $ressarcimento_pagamento->getChanges(), $ressarcimento_pagamento->getOriginal());
    }

    public function deleted(RessarcimentoPagamento $ressarcimento_pagamento)
    {
        $this->transacaoService->transacao(1, 3, 'ressarcimento_pagamentos', $ressarcimento_pagamento->toArray(), []);
    }
}
